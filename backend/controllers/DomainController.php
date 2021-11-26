<?php

namespace backend\controllers;

use backend\jobs\Be1Job;
use backend\jobs\MegaindexJob;
use backend\jobs\MetricaJob;
use Yii;
use backend\models\Domain;
use backend\models\DomainAPI;
use backend\models\Project;
use backend\models\search\BlackList;
use backend\models\search\DomainSearch;
use Codeception\Lib\Di;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\queue\Queue;
use floor12\notification\Notification;
use yii\helpers\Html;
use yii\web\View;

use function GuzzleHttp\json_decode;

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

    public function actionTest($id)
    {
        $model = Domain::findOne($id);
        $js_path = __DIR__ . '/../../nodejs/be1.js';
        $js_func = 'be1.js ' . parse_url($model->domain, PHP_URL_HOST);
        // die($js_func);
        // $node = '/snap/node/5322/bin/node';
        $node = 'node';
        $res = json_decode(exec("cd " . dirname($js_path) . " && {$node} {$js_func}"));
        var_dump($res);
        die;
        // $json = '{"domain":"blogstroykin.com","traffic":"","organic":"","direct":"","traffic_season":"","project_stage":10,"profit_await":"15","evaluate_min":"75","evaluate_middle":"113","evaluate_max":"150","domain_age":"2 года 57 дней","IKS":20,"index_Y":"2132","index_G":"2630","megaindexTrustRank":"5","megaindexDomainRank":"0"}';
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
    }

    public function actionStart($id)
    {
        // $model = Domain::findOne($id);
        // $js_path = __DIR__.'/../../nodejs/be1.js';
        // $js_func = 'be1.js ' . parse_url($model->domain, PHP_URL_HOST);
        // // die($js_func);
        // // $node = '/snap/node/5322/bin/node';
        // $node = 'node';
        // $res = json_decode(exec("cd " . dirname($js_path)." && {$node} {$js_func}"));
        // $json = '{"domain":"blogstroykin.com","traffic":"","organic":"","direct":"","traffic_season":"","project_stage":10,"profit_await":"15","evaluate_min":"75","evaluate_middle":"113","evaluate_max":"150","domain_age":"2 года 57 дней","IKS":20,"index_Y":"2132","index_G":"2630","megaindexTrustRank":"5","megaindexDomainRank":"0"}';
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
        if (Yii::$app->queue->push(new MetricaJob([
            'id' => $id,
        ]))) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => 'Домен ' . $model->domain . ' номер ' . $model->id . ' отправлен в очередь на обработку. '
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
    public function actionTesting()
    {
        $model = Domain::findOne(801);
        $domainAPI = new DomainAPI();
        $domain = parse_url($model->domain, PHP_URL_HOST);
        $json = $domainAPI->get($domain);
        $json = json_decode($json, true);
        echo $json['www.russianfood.com']['title'];
        var_dump($json);
        die;

        $model = Domain::findOne(801);
        $domain = parse_url($model->domain, PHP_URL_HOST);
        $domainAPI = new DomainAPI();
        $json = $domainAPI->get($domain);
        var_dump($json);
        die;

        // $model = Domain::findOne(913);
        $model->traffic = $json['www.russianfood.com']['traffic'];
        $model->organic = $json['www.russianfood.com']['organic'];
        $model->direct = $json['www.russianfood.com']['direct'];
        $model->traffic_season = $json['www.russianfood.com']['traffic_season'];
        $model->project_stage = $json['www.russianfood.com']['project_stage'];
        $model->profit_await = $json['www.russianfood.com']['profit_await'];
        $model->evaluate_min = $json['www.russianfood.com']['evaluate_min'];
        $model->evaluate_middle = $json['www.russianfood.com']['evaluate_middle'];
        $model->evaluate_max = $json['www.russianfood.com']['evaluate_max'];
        $model->domain_age = $json['www.russianfood.com']['domain_age'];
        $model->IKS = $json['www.russianfood.com']['IKS'];
        $model->index_Y = $json['www.russianfood.com']['index_Y'];
        $model->index_G = $json['www.russianfood.com']['index_G'];
        if ($model->save()) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => 'Домен ' . $model->domain . ' успешно обновлен. '
            ]);
        } else {
            $error = [];
            foreach ($model->errors as $error) {
                $arr[] = implode(' ', $error);
            }
            $error = implode('<br>', $arr);
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-danger'],
                'body' => $error
            ]);
        }
    }

    public function actionEvent()
    {
        $model = Domain::findOne(908);
        $domain = parse_url($model->domain, PHP_URL_HOST);
        $domainAPI = new DomainAPI();
        $res = $domainAPI->getLi($domain);
        var_dump($res);
    }

    public function actionMultipleParsing()
    {
        if ($ids = Yii::$app->request->post('id')) {
            $count = 0;
            foreach($ids as $id) {
                $model = Domain::findOne($id);
                if (Yii::$app->queue->push(new MegaindexJob([
                    'id' => $model->id,
                ]))) {
                    Html::script("f12notification.error('Registration failed.')");
                    Notification::info('The form is loading...');
                    // return Notification::info('The form is loading...');
                    // return $this->redirect(Yii::$app->request->referrer);
                } else {
                    $arr = [];
                    foreach ($model->errors as $error) {
                        $arr[] = implode(' ', $error);
                    }
                    $error = implode('<br>', $arr);
                    // return $this->redirect(Yii::$app->request->referrer);
                }
                $count++;
            }
            if(isset($error)) {
                Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-danger'],
                    'body' => $error
                ]);
            }
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => $count . ' доменов успешно спарсены'
            ]);
            // return Notification::info('The form is loading...');

            // $domains = [];
            // foreach($models as $domain){
            //     // $domain = parse_url($model->domain, PHP_URL_HOST);
            //     $domains[] = parse_url($domain->domain, PHP_URL_HOST);
            // }
            // $json = json_encode($domains);
            // $domain = parse_url($model->domain, PHP_URL_HOST);
            // $domainAPI = new DomainAPI();
            // $json = $domainAPI->get($domain);
            // var_dump($json);die;
            // $afterExecAlert = function ($event) {
            //     throw new \Exception('Hurra - EVENT_AFTER_EXEC');
            // };
            // Yii::$app->queue->on(Queue::EVENT_AFTER_EXEC, $afterExecAlert);
        } else {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-danger'],
                'body' => 'Неверный запрос'
            ]);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    // public static function flash()
    // {
    //     return $this->redirect(Yii::$app->request->referrer);
    // }

    public function actionDomains()
    {
        $model = new Domain();
        $api = new DomainAPI();
        $result = $api->get("domains");
        print_r($result);


        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['index']);
        // }
        return $this->render('put', [
            'model' => $model,

        ]);


        print_r($result);
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
