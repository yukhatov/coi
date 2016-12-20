<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 19.12.16
 * Time: 17:07
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'surname') ?>

<?= $form->field($model, 'birthday')->widget(\kartik\date\DatePicker::className(), [
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
]) ?>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
