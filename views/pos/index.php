<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Kasir';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->homeUrl . "js/index.js", ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(Yii::$app->homeUrl . "js/pos.js", ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);
$token = $this->renderDynamic('return Yii::$app->request->csrfToken;');

$jsx = <<< 'SCRIPT'
    IndexObj.initialScript();
    PosObj.initialScript();
SCRIPT;
$this->registerJs('IndexObj.baseUrl = "' . Yii::$app->homeUrl . '"', \yii\web\View::POS_HEAD);
$this->registerJs('IndexObj.csrfToken = "' . $token . '"', \yii\web\View::POS_HEAD);
$this->registerJs($jsx);
?>

<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div id="c-code" class="form-group field-productsform-code required">
            <label class="control-label" for="productsform-code">Kode</label>
            <input type="text" id="code" class="form-control" name="code" aria-required="true">
            <div id="e-code" class="help-block"></div>
        </div>
        <div id="c-qty" class="form-group field-productsform-name required">
            <label class="control-label" for="productsform-name">Jumlah Pembelian</label>
            <input type="text" id="qty" class="form-control" name="name" aria-required="true">
            <div id="e-qty" class="help-block"></div>
        </div>
        <button id="input-ajax" class="btn btn-success">Input</button>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="bg-default">
                        <th>Kode</th>
                        <th>Nama Roti</th>
                        <th>QTY</th>
                        <th>Total</th>
                        <th width="13%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="body-1">
                    
                </tbody>
                <tbody id="body-2">
                    
                </tbody>
            </table>
        </div>
        
        <hr>
        <button id="bayar" class="btn btn-primary">Bayar</button>
    </div>
</div>
