<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'id' => 'search-form',
    'layout' => 'inline',
    'options' => ['class' => 'text-right']
]); ?>

    <?= $form->field($model, 'query')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'name' => 'search-button']) ?>
    </div>

<?php ActiveForm::end(); ?>