<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php
        $form = ActiveForm::begin([
                    'id' => $form_id,
        ]);
            if ($form_id === 'form-update-product') {
                $model->code = $_model['code'];
                $model->name = $_model['name'];
                $model->price = $_model['price'];
            }
        ?>
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <?= $form->field($model, 'code')->textInput(); ?>
                <?= $form->field($model, 'name')->textInput(); ?>
                <?= $form->field($model, 'price')->textInput(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <hr class="row-header">
                <div class="form-group">
                     <?= Html::submitButton($save, ['class' => 'btn btn-primary', 'name' => 'save-button']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>   
    </div>
</div>