<?php

namespace backend\controllers;

use common\models\Audit;
use common\models\ObjectCategory;
use common\models\ObjectSystem;
use common\models\search\AuditSearch;
use common\models\Threat;
use SimpleXLSX;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuditController implements the CRUD actions for Audit model.
 */
class AuditController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Audit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuditSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Audit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание нового аудита
     */
    public function actionCreate()
    {
        $model = new Audit();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->save();
                return $this->redirect(['audit-step-one', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionAuditStepOne($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && ($post = $this->request->post())) {

            $model->load($this->request->post());

            $model->saveLogCategories();
            $model->saveObjectCategories();
            $model->saveObjectSystems();

            $model->status = 1;
            $model->save();
            return $this->redirect(['audit-step-two', 'id' => $model->id]);
        }

        return $this->render('audit_step_one', [
            'model' => $model,
        ]);
    }

    public function actionAuditStepTwo($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && ($post = $this->request->post())) {

            // $model->load($this->request->post());
            // $model->status = 2;
            // $model->save();
            // return $this->redirect(['audit-step-three', 'id' => $model->id]);
        }

        return $this->render('audit_step_two', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // if ($this->request->isPost && $model->load($this->request->post())) {
        //     $model->save();
        //     return $this->redirect(['index']);
        // }

        if ($model->status == 0) {
            return $this->redirect(['audit-step-one', 'id' => $model->id]);
        } elseif ($model->status == 1) {
            return $this->redirect(['audit-step-two', 'id' => $model->id]);
        } elseif ($model->status == 2) {
            return $this->redirect(['audit-step-three', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Audit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
