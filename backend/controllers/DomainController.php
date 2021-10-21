<?php

namespace backend\controllers;

use backend\jobs\MetricaJob;
use Yii;
use backend\models\Domain;
use backend\models\search\BlackList;
use backend\models\search\DomainSearch;
use Codeception\Lib\Di;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DomainController implements the CRUD actions for Domain model.
 */
class DomainController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Domain models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $currentUserId = Yii::$app->user->getId();
        $searchModel = new DomainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $currentUserId, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Domain model.
     * @param int $id ID
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionStartAjax($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->queue->push(new MetricaJob([
            'id' => $id,
        ]))) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => 'Домен ' . $model->domain . ' номер '.$model->id.' отправлен в очередь на обработку. '
            ]);
        } else {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-danger'],
                'body' => 'Ошибка'
            ]); 
        }
        // die;
        // $js_path = '/var/www/yii2zif/startup/nodejs/metrica.js';
        // $js_func = 'metrica.js ' . $model->domain;
        // $node = '/snap/node/5322/bin/node';
        // $out = null;
        // // die("cd ".dirname($js_path)." && {$node} {$js_func} 2>&1");
        // $res = exec("cd ".dirname($js_path)." && {$node} {$js_func} 2>&1", $out, $err);
        // var_dump($res);die;
        // if($err) {
        //     Yii::$app->session->setFlash('alert', [
        //     'options' => ['class' => 'alert-danger'],
        //     'body' => "Произошла ошибка: " . $res
        //     ]);
        // } else {
        //     Yii::$app->session->setFlash('alert', [
        //         'options' => ['class' => 'alert-success'],
        //         'body' => 'Домен ' . $model->domain . ' отправлен на парсинг. '
        //     ]);
        // }


        // return $result;
        // return $this->render('start', [
        //     'model' => $this->findModel($id),
        // ]);
    }

    public function actionMultipleChangeStatus()
    {
        if (Yii::$app->request->post('id','blacklist')) {
            Domain::updateAll(['blacklist' => Yii::$app->request->post('blacklist')], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionBlacklist()
    {
        $searchModel = new BlackList();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Domain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Domain();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Domain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Domain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Domain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Domain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Domain::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
