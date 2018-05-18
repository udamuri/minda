<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\ProductsForm;

class ProductController extends \yii\web\Controller
{

	/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'create-ajax','update', 'update-ajax', 'set-status' , 'get-data'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $search = Yii::$app->request->get('search');
        if ($search) {
            $search = strtolower(trim(strip_tags($search)));
        } else {
            $search = '';
        }

        $query = (new \yii\db\Query())
                ->select([
                    'p.id',
                    'p.code',
                    'p.name',
                    'p.price',
                    'p.status'
                ])
                ->from('products p');

        if ($search !== '') {
            $query->where('lower(ta.judul) LIKE "%' . $search . '%" ');
        }

        $pageSize = 10;
        
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $pageSize
        ]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->orderBy(['id' => SORT_DESC])
                ->all();

        return $this->render('index', [
                    'models' => $models,
                    'pages' => $pages,
                    'offset' => $pages->offset,
                    'page' => $pages->page,
                    'search' => $search,
                    'pageSize' => $pageSize
        ]);
    }

    public function actionCreate()
    {
        $model = new ProductsForm;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->create()) {
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
                return Yii::$app->getResponse()->redirect(\yii\helpers\Url::to('@web/product/index'));
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionCreateAjax()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new ProductsForm;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->create()) {
                return 'success';
            } else {
                return $model->errors;
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = new ProductsForm;
        $_model = $model->getData($id);

        if ($_model) {
            if ($model->load(Yii::$app->request->post())) {
                $model->myid = $id;
                if ($model->update($id)) {
                    Yii::$app->session->setFlash('success', 'Data berhasil diubah');
                	return Yii::$app->getResponse()->redirect(\yii\helpers\Url::to('@web/product/index'));
                }
            }
            return $this->render('update', [
                'model' => $model,
                '_model' => $_model,
            ]);
        } else {
            return Yii::$app->getResponse()->redirect(\yii\helpers\Url::to('@web/product/index'));
        }
    }

    public function actionUpdateAjax()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new ProductsForm;
        if(Yii::$app->request->post('id')) {
            if ($model->load(Yii::$app->request->post())) {
                $id = Yii::$app->request->post('id');
                $model->myid = $id;
                if ($model->update($id)) {
                    return 'success';
                } else {
                    return $model->errors;
                }
            }
        } else {
            return 'id not set';
        }
    }

    public function actionGetData()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $_model = [];
        if(Yii::$app->request->post('id')) {
            $model = new ProductsForm;
            $id = Yii::$app->request->post('id');
            $_model = $model->getData($id);
        }

        return $_model;
    }

    /*
     * Set status ON OR OFF
     */
    public function actionSetStatus()
    {
        if ($post = Yii::$app->request->post()) {
            if (isset($post['id'])) {
                $model = new ProductsForm;
                if ($status = $model->setStatus($post['id'])) {
                    return $status;
                }
            }
        }

        return null;
    }

}
