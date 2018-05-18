<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Master Data';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->homeUrl . "js/index.js", ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(Yii::$app->homeUrl . "js/master.js", ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);
$token = $this->renderDynamic('return Yii::$app->request->csrfToken;');

$jsx = <<< 'SCRIPT'
    IndexObj.initialScript();
    MasterObj.initialScript();
SCRIPT;
$this->registerJs('IndexObj.baseUrl = "' . Yii::$app->homeUrl . '"', \yii\web\View::POS_HEAD);
$this->registerJs('IndexObj.csrfToken = "' . $token . '"', \yii\web\View::POS_HEAD);
$this->registerJs($jsx);
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <a href="<?=yii\helpers\Url::to('@web/product/create')?>" class="btn btn-primary" >Tambah Baru</a>
        <button type="button" class="btn btn-success" data-id="create" data-toggle="modal" data-target="#myModal">
            Tambah Baru Ajax
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="bg-default">
                        <th width="3%">No.</th>
                        <th>Kode</th>
                        <th>Nama Roti</th>
                        <th>Harga</th>
                        <th width="13%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $start = (int) $offset * (int) $page;
                    foreach ($models as $value) {
                        $start++;
                        $btn_class = 'btn-warning';
                        $btn_text = 'OFF';
                        if ($value['status'] == '1') {
                            $btn_class = 'btn-primary';
                            $btn_text = 'ON';
                        }
                        echo '<tr>
                        <td>' . $start . '</td>
                        <td>' . $value['code'] . '</td>
                        <td>' . $value['name'] . '</td>
                        <td>' . number_format($value['price'],2) . '</td>
                        <td align="center">
                          <a class="btn btn-success btn-xs" title="Update" href="' . Yii::$app->homeUrl . 'product/update/' . $value['id'] . '" data-id="' . $value['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                          <button id="btn_update_ajax_' . $value['id'] . '" title="Status" class="btn btn-danger btn-xs btn_update_ajax" data-id="' . $value['id'] . '" data-toggle="modal" data-target="#myModal">Update Ajax</button>
                          <button id="btn_status_' . $value['id'] . '" title="Status" class="btn ' . $btn_class . ' btn-xs status" data-id="' . $value['id'] . '"> ' . $btn_text . ' </button>
                        </td>
                    <tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <?php
            //display pagination
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" id="id-produk" name="id-produk" value="create">
                    <div id="c-code" class="form-group field-productsform-code required">
                        <label class="control-label" for="productsform-code">Kode</label>
                        <input type="text" id="productsform-code" class="form-control" name="ProductsForm[code]" aria-required="true">
                        <div id="e-code" class="help-block"></div>
                    </div>
                    <div id="c-name" class="form-group field-productsform-name required">
                        <label class="control-label" for="productsform-name">Nama Roti</label>
                        <input type="text" id="productsform-name" class="form-control" name="ProductsForm[name]" aria-required="true">
                        <div id="e-name" class="help-block"></div>
                    </div>
                    <div id="c-price" class="form-group field-productsform-price required">
                        <label class="control-label" for="productsform-price">Price</label>
                        <input type="text" id="productsform-price" class="form-control" name="ProductsForm[price]" aria-required="true">
                        <div id="e-price" class="help-block"></div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="create-update-form" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>