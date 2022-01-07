<?php

namespace backend\controllers;

use common\models\Audit;
use common\models\Cvss3 as ModelsCvss3;
use common\models\ObjectCategory;
use common\models\ObjectSystem;
use common\models\Recommendation;
use common\models\search\AuditSearch;
use common\models\search\LogAuditSearch;
use common\models\search\LogSearch;
use common\models\Threat;
use Grav\Plugin\HighlightPlugin;
use SecurityDatabase\Cvss\Cvss3;
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

    public function actionStatistic($id)
    {
        $model = $this->findModel($id);

        $searchModel = new LogAuditSearch();

        $ids = [];
        $logs = $model->logs;
        if (!empty($logs)) {
            foreach ($logs as $log) {
                $ids[] = $log->id;
            }
        }

        $searchModel->ids = $ids;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $diagr_priority = $this->calculatePriorityLogs($logs);
        $diagr_category = $this->calculateCategoryLogs($logs);
        $diagr_threat = $this->calculateThreatLogs($logs);
        
        return $this->render('statistic_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelAudit' => $model,
            'diagr_priority' => $diagr_priority,
            'diagr_category' => $diagr_category,
            'diagr_threat' => $diagr_threat,
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
        die;
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

        return $this->render('audit_step_two', [
            'model' => $model,
        ]);
    }

    public function actionFinish($id)
    {
        $model = $this->findModel($id);
        $recommendations = $model->recommendations;
        $logs = $model->logs;
        if (($model->status == 1) && (count($recommendations) > 0)) {

            $model->status = 2;

            if ($model->save()) {
                foreach ($recommendations as $recommendation) {
                    $recommendation->status = 1;
                    $recommendation->save();
                }
                foreach ($logs as $log) {
                    $log->type = $model->id;
                    $log->save();
                }
            }
        }

        return $this->redirect(['index']);
    }

    public function actionAddRecommendation($id)
    {
        $model = $this->findModel($id);
        $modelRecom = new Recommendation();

        if ($model->status == 1) {
            if ($this->request->isPost && ($post = $this->request->post())) {

                $modelRecom->load($post);
                $modelRecom->date = strtotime(date('Y-m-d'));
                $modelRecom->status = 0;
                $modelRecom->audit_id = $model->id;
                $modelRecom->save();

                return $this->redirect(['audit-step-two', 'id' => $model->id]);
            }
        }
        return $this->render('add_recommendation', [
            'model' => $model,
            'modelRecom' => $modelRecom,
        ]);
    }

    public function actionUpdateRecommendation($id)
    {
        $modelRecom = Recommendation::find()->where(['id' => $id])->one();

        if (empty($modelRecom)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = $this->findModel($modelRecom->audit_id);

        if ($model->status == 1) {
            if ($this->request->isPost && ($post = $this->request->post())) {

                $modelRecom->load($post);
                $modelRecom->date = strtotime(date('Y-m-d'));
                $modelRecom->status = 0;
                $modelRecom->audit_id = $model->id;
                $modelRecom->save();

                return $this->redirect(['audit-step-two', 'id' => $model->id]);
            }
        }
        return $this->render('add_recommendation', [
            'model' => $model,
            'modelRecom' => $modelRecom,
        ]);
    }

    public function actionDeleteRecommendation($id)
    {
        $modelRecom = Recommendation::find()->where(['id' => $id])->one();
        if (!empty($modelRecom)) {
            $model = $this->findModel($modelRecom->audit_id);
            $modelRecom->delete();
            return $this->redirect(['audit-step-two', 'id' => $model->id]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->status == 0) {
            return $this->redirect(['audit-step-one', 'id' => $model->id]);
        } elseif ($model->status == 1) {
            return $this->redirect(['audit-step-two', 'id' => $model->id]);
        } elseif ($model->status == 2) {
            return $this->redirect(['index']);
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

    public function actionCvss()
    {
        if ($this->request->isPost && ($post = $this->request->post())) {

            $resultCvss = Audit::calculateCvss($post);
            return $this->render('cvss_result', [
                'resultCvss' => $resultCvss,
            ]);
        }
        return $this->render('cvss');
    }

    public function actionCvssThree()
    {
        if ($this->request->isPost && ($post = $this->request->post())) {

            $resultCvss = [];

            unset($post['_csrf']);
            $vector = 'CVSS:3.1';
            foreach ($post as $key => $value) {
                $vector .= "/".$key.":".$value;
            }

            $cvss = new ModelsCvss3();
            $cvss->register($vector);
            $scores = $cvss->getScores();
 
            $resultCvss['vector'] = $vector;
            $resultCvss['BaseScore'] = $scores['baseScore'];
            $resultCvss['Impact'] = $scores['impactSubScore'];
            $resultCvss['TemporalScore'] = $scores['temporalScore'];
            $resultCvss['EnvironmentalScore'] = $scores['envScore'];

            return $this->render('cvss_three_result', [
                'resultCvss' => $resultCvss,
            ]);
        }
        return $this->render('cvss_three');
    }

    public function calculatePriorityLogs($logs)
    {
        $resArr = [];

        $logPriority = [];
        if (!empty($logs)) {
            foreach ($logs as $log) {
                $logPriority[$log->priority] += 1;
            }
            $total = count($logs);
            foreach ($logPriority as $priority => $count) {
                $resArr[] = ['#' . $priority, round((($count / $total) * 100), 1)];
            }
        }

        return $resArr;
    }

    public function calculateCategoryLogs($logs)
    {
        $resArr = [];

        $logCats = [];
        if (!empty($logs)) {

            foreach ($logs as $log) {
                $logCats[$log->logCategory->name] += 1;
            }

            $total = count($logs);
            foreach ($logCats as $category => $count) {
                $resArr[] = [$category, round((($count / $total) * 100), 1)];
            }
        }

        return $resArr;
    }

    public function calculateThreatLogs($logs)
    {
        $resArr = [];

        $logThreats = [];
        if (!empty($logs)) {

            foreach ($logs as $log) {
                $logThreats[$log->threat->name] += 1;
            }

            $total = count($logs);
            foreach ($logThreats as $threat => $count) {
                $resArr[] = [$threat, round((($count / $total) * 100), 1)];
            }
        }

        return $resArr;
    }
}
