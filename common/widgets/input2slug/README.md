## Usage without Model
```php
<?= common\widgets\input2slug\SlugInput::widget([
  'name'      =>  'in',
  'targetId'  =>  'test',
]);?>
<?= \yii\helpers\Html::textInput('out', null, [
  'id'    =>	'test'
]);?>
 ```
 ## Usage with ActiveForm notation
 ```php
  <?= $form->field($model, 'title')->widget(common\widgets\input2slug\SlugInput::className(), [
    'maxlength' =>  true,
    'targetId'  =>  'url-code'
  ]);?>
 ```
