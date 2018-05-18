<?php
$this->title = 'Tambah';
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
            'form_id' => 'form-create-product',
            'save' => 'Simpan',
        ])
        ?>
    </div>
</div>
