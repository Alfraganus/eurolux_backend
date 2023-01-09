<?php
/**
 * Файл поведения TranslationBehavior
 * 
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\UnknownPropertyException;

/**
 * Поведение содержит логику получения полей переводов моделей AR
 * как вирутальных свойств модели
 * 
 * @property \yii\db\ActiveRecord $owner
 * @property \yii\db\ActiveRecord[] $allTranslations
 * @property \yii\db\ActiveRecord $translation
 */
class TranslationModelBehavior extends Behavior
{
	/**
	 * Имя класса модели-транслятора
	 * @var string
	 */
	public $translationModelClass;
	
	/**
	 * Связь c моделью-транслятором
	 * @var array
	 */
	public $translationHasOneLink;
	
	/**
	 * Наименование поля отбра по озыку в моделе-трансляторе
	 * @var string
	 */
	public $translationModelLanguageField = 'language_code';


    /**
     * Magic-method, производящий проверки на существование отношения модели-транслятора,
     * и, если она существует пытается получить у нее свойста по имени
     * @param string $name
     * @return mixed
     * @throws UnknownPropertyException
     */
	public function __get($name)
	{
		try {
			
			return parent::__get($name);
			
		} catch (UnknownPropertyException $e) {
		    if (!$this->owner->translation) {
		        return null;
            }

			if ($this->owner->translation) {
				return $this->owner->translation->$name;
			}
			
			throw $e;
		
		}
	}
	
	/**
	 * Разрешаем запрос свойста с любым именем,
	 * иначе  magic-method __get не отработает
	 * {@inheritdoc}
	 */
	public function canGetProperty($name, $checkVars = true)
	{
		return parent::canGetProperty($name, $checkVars) || true;
	}
	
    /**
	 * Получает трансляцию на текущем языке
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation($code = '')
    {
		$class = $this->translationModelClass;
		
        return $this->owner->hasOne($class, $this->translationHasOneLink)->andWhere($class::tableName() . ".{$this->translationModelLanguageField} = :code", [
            ':code' => ($code == '' ? Yii::$app->language : $code)
        ]);
    }
	
	/**
	 * Получает все трансляции модели
	 * @return \yii\db\ActiveQuery
	 */
	public function getAllTranslations()
	{
		$class = $this->translationModelClass;
		
        return $this->owner->hasMany($class, $this->translationHasOneLink);		
	}
	
	/**
	 * Проверяет имеет ли запись трансляцию на указанный язык
	 * @param type $language
	 * @return boolean
	 */
	public function hasLanguageTranslation($language)
	{
		foreach ($this->allTranslations as $translation) {
			if ($translation->{$this->translationModelLanguageField} == $language) {
				return true;
			}
		}
		
		return false;
	}
}
