<?php
/**
 * Файл поведения TranslationBehavior
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\behaviors;

use Yii;
use yii\base\Model;
use yii\base\Behavior;
use common\models\Language;
use common\helpers\LanguageHelper;

/**
 * Поведение содержит логику получения полей переводов моделей AR
 * как вирутальных свойств модели
 *
 * @property \yii\db\ActiveRecord $owner
 * @property \yii\db\ActiveRecord[] $allTranslations
 * @property \yii\db\ActiveRecord $translation
 */
class TranslationFormBehavior extends Behavior
{
    /**
     * Имя класса модели-транслятора
     * @var string
     */
    public $translationFormClass;

    /**
     * Наименование поля отбра по озыку в моделе-трансляторе
     * @var string
     */
    public $translationModelParentField;

    /**
     * Наименование свойства связанного с переводами
     * @var string
     */
    public $translationsPropName;


    /**
     * Получить модели перевода для всех языков, если модели перевода нет в базе то создается новая модель
     * @return array
     */
    public function getTranslationModelsForAllLanguages()
    {
        $results = [];
        /*** @var Language[] $languages */
        $languages = LanguageHelper::getLanguages();
        foreach ($languages as $language) {
            $modelLang = $this->getTranslationModelsByLanguageCode($language->code);

            if (!$modelLang) {
                $modelLang = new $this->translationFormClass();
                if (property_exists($modelLang, 'is_active') && $language->code == Language::CODE_RU) {
                    $modelLang->is_active = true;
                }
            } elseif (property_exists($modelLang, 'is_active')) {
                $modelLang->is_active = true;
            }
            $modelLang->language_code = $language->code;
            $modelLang->{$this->translationModelParentField} = $this->owner->model ? $this->owner->model->id : null;
            $modelLang->language = $language;

            $results[] = $modelLang;
        }

        return $results;

    }

    /**
     * Получить языковую форму по коду языка
     *
     * @param $code
     * @return null | Model
     */
    private function getTranslationModelsByLanguageCode($code)
    {
        if (!$this->owner->model || !$translations = $this->owner->model->{$this->translationsPropName}) {
            return null;
        }
        foreach ($translations as $translation) {
            if ($translation->language_code == $code) {
                return new $this->translationFormClass($translation);
            }
        }

        return null;
    }
}
