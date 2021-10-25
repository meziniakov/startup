<?php

namespace backend\controllers;

use backend\jobs\MetricaJob;
use Yii;
use backend\models\Domain;
use backend\models\Project;
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
        $project = Project::findOne($id);
        $this->view->title = $project->name . " / Домены";
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

    public function actionStart($id)
    {
        // $model = Domain::findOne($id);
        // $js_path = __DIR__.'/../../nodejs/be1.js';
        // $js_func = 'be1.js ' . parse_url($model->domain, PHP_URL_HOST);
        // // die($js_func);
        // $node = '/snap/node/5322/bin/node';
        // // $node = 'node';
        // $res = json_decode(exec("cd " . dirname($js_path)." && {$node} {$js_func}"));
        // // $json = '{"domain":"blogstroykin.com","traffic":"","organic":"","direct":"","traffic_season":"","project_stage":10,"profit_await":"15","evaluate_min":"75","evaluate_middle":"113","evaluate_max":"150","domain_age":"2 года 57 дней","IKS":20,"index_Y":"2132","index_G":"2630","megaindexTrustRank":"5","megaindexDomainRank":"0"}';
        // // $res = json_decode($json);
        // $model->traffic = $res->traffic ? $res->traffic : '';
        // $model->organic = $res->organic ? $res->organic : '';
        // $model->direct = $res->direct ? $res->direct : '';
        // $model->traffic_season = $res->traffic_season ? $res->traffic_season : '';
        // $model->project_stage = $res->project_stage ? $res->project_stage : '';
        // $model->profit_await = $res->profit_await ? $res->profit_await : '';
        // $model->evaluate_min = $res->evaluate_min ? $res->evaluate_min : '';
        // $model->evaluate_middle = $res->evaluate_middle ? $res->evaluate_middle : '';
        // $model->evaluate_max = $res->evaluate_max ? $res->evaluate_max : '';
        // $model->domain_age = $res->domain_age ? $res->domain_age : '';
        // $model->index_Y = $res->index_Y ? $res->index_Y : '';
        // $model->index_G = $res->index_G ? $res->index_G : '';
        // $model->CMS = "";
        // if($model->save()) {
        //     Yii::$app->session->setFlash('alert', [
        //         'options' => ['class' => 'alert-success'],
        //         'body' => 'Домен ' . $model->domain . ' номер '.$model->id.' отправлен в очередь на обработку. '
        //     ]);
        //     return $this->redirect(['domain/view', 'id' => $id]);
        // } else {
        //     Yii::$app->session->setFlash('alert', [
        //         'options' => ['class' => 'alert-danger'],
        //         'body' => 'Ошибка'
        //     ]);
        //     echo "<pre>";
        //     print_r($model->getErrors());
        // }
        $model = $this->findModel($id);
        if(Yii::$app->queue->push(new MetricaJob([
            'id' => $id,
        ]))) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => 'Домен ' . $model->domain . ' номер '.$model->id.' отправлен в очередь на обработку. '
            ]);
            // exec('cd ' . __DIR__.'/../../console' . ' && ./yii queue/run');
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-danger'],
                'body' => 'Ошибка'
            ]);
        }
    }

    public function actionMultipleBlacklist()
    {
        if (Yii::$app->request->post('id')) {
            Domain::updateAll(['blacklist' => 1], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMultipleUnblacklist()
    {
        if (Yii::$app->request->post('id')) {
            Domain::updateAll(['blacklist' => 0], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionBlacklist()
    {
        $this->view->title = "Черный список";
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
