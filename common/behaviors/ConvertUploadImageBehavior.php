<?php

namespace common\behaviors;

use chulakov\filestorage\behaviors\FileUploadBehavior;
use chulakov\filestorage\ImageComponent;
use chulakov\filestorage\uploaders\UploadedFile;
use common\models\enums\MimeFileType;
use yii\base\Model;
use yii\di\Instance;

/**
 * Конвертация загруженного изображение в другой формат
 *
 * @package common\behaviors
 */
class ConvertUploadImageBehavior extends FileUploadBehavior
{
    /** @var string */
    public $convertToExtension = 'webp';

    /** @var array */
    public $convertFromExtension = [];

    /** @var ImageComponent */
    private $imageComponent;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return array_merge(parent::events(), [
            Model::EVENT_AFTER_VALIDATE => 'afterValidate',
        ]);
    }

    /**
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->imageComponent = Instance::ensure('imageComponent');
    }

    /**
     * Заменим изображение на новое в папке temp
     */
    public function afterValidate()
    {
        /** @var UploadedFile $image */
        $image = $this->owner->{$this->attribute};
        if (!$image) {
            return;
        }
        if (!in_array($this->convertToExtension, MimeFileType::getExtensions())) {
            $this->owner->addError($this->attribute, 'Указанный тип не поддерживается');
            return;
        }
        if ($image->type === MimeFileType::getType($this->convertToExtension)) {
            return;
        }
        if (
            !empty($this->convertFromExtension)
            && !in_array($image->type, MimeFileType::getTypesFilterByExtensions($this->convertFromExtension))
        ) {
            return;
        }

        $imageConvert = $this->imageComponent->make($image->getFile());
        $imageConvert->convert($this->convertToExtension);

        $imageConvertStream = $imageConvert->getImage()->stream(null, 100);

        $image->type = MimeFileType::getType($this->convertToExtension);
        $image->size = $imageConvertStream->getSize();
        $image->name = preg_replace('/\.[^\.]+$/', '.' . $this->convertToExtension, $image->name);

        if (!$this->replaceFile($image->tempName, $imageConvertStream->detach())) {
            $this->owner->addError($this->attribute, 'Не удалось конвертировать изображение');
        }
    }

    /**
     * Заменить изображение на новое
     * @param string $filePath
     * @param resource $file
     * @return bool
     */
    private function replaceFile(string $filePath, $file): bool
    {
        $target = fopen($filePath, 'wb');
        if ($target === false) {
            return false;
        }

        $result = stream_copy_to_stream($file, $target);
        @fclose($target);
        return $result;
    }
}
