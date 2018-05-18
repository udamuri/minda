<?php
$this->title = 'Ubah';
$this->params['breadcrumbs'][] = [
    'label' => 'Agenda',
    'url' => Yii::$app->homeUrl . 'agenda'
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <?=
        $this->render('_form', [
            'model' => $model,
            '_model' => $_model,
            'form_id' => 'form-update-product',
            'save' => 'Simpan Perubahan',
            'cancel' => 'Batal'
        ])
        ?>
    </div>
</div>
