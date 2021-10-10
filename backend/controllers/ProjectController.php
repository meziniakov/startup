<?php

namespace backend\controllers;

use backend\models\Domain;
use Yii;
use common\models\Project;
use backend\models\search\ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
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
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $currentUserId = Yii::$app->user->getId();
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $currentUserId);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param int $id ID
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Project model.
     * @param int $id ID
     * @return mixed
     */
    public function actionStart($id)
    {
        $project = $this->findModel($id);
        $start = 0;
        $domainCount = 0;
        // for ($start=0; $start < 21; $start += 10) {
        while ($start < 9) {
            $doc = Project::client('https://www.google.ru/', 'search', [
                'q' => $project->keywords,
                'start' => $start,
            ]);
            $entry = $doc->find('div#main div.kCrYT');
            $data['title'] = pq($entry)->text();
            echo $data['title']; die;
            // var_dump($entry);die;
            // var_dump(pq($entry)->find('h1')->html());die;
            foreach ($entry as $item) {
                var_dump(pq($item)->find('a')->attr('href'));die;
                // $domain = new Domain();
                $domain = [];
                $domain = parse_url(pq($item)->find('a')->attr('href'), PHP_URL_HOST);
                var_dump($domain);die;
                // $domain->save();
                $domainCount++;
            }
            $start += 10;
        }

        Yii::$app->session->setFlash('alert', [
            'options' => ['class' => 'alert-success'],
            'body' => 'Добавлено ' . $domainCount . ' доменов'
        ]);

        // return $this->render('index', [
        //     'model' => $this->findModel($id),
        // ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Project model.
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
     * Deletes an existing Project model.
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
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
