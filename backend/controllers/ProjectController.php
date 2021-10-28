<?php

namespace backend\controllers;

use backend\models\Domain;
use backend\models\Project;
use backend\models\search\DomainsSearch;
use Yii;
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

    public function actionPusk($id)
    {
        $project = $this->findModel($id);
        $query = str_replace(" ", "+", $project->keywords);
        $js_path = __DIR__.'/../../nodejs/metrica.js';
        $js_func = 'google.js ' . $query .' '. $project->total;
        // $node = '/snap/node/5322/bin/node';
        $node = 'node';
        // die("cd " . dirname($js_path)." && {$node} {$js_func}");
        $res = shell_exec("cd " . dirname($js_path)." && {$node} {$js_func}");
        $project->addTagValues(trim($res));
        if($project->validate() && $project->save()) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => 'Успешно добавлено домены'
            ]);    
            return $this->redirect(['domain/index', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => print_r($project->getErrors())
            ]);    
            return $this->redirect(['project/index']);
        }
        // die;
        // $projects = Project::find()->with('domains')->all();
        // foreach ($projects as $project) {
        //     print_r($project->domains);
        // }
        // // var_dump($domains);
    }

    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
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
