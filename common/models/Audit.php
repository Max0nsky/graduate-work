<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "audit".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int $date
 * @property int|null $date_start
 * @property int|null $date_finish
 * @property int $status
 */
class Audit extends \yii\db\ActiveRecord
{
    public $logCategories;
    public $objectCategories;
    public $objectSystems;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['date', 'status'], 'integer'],
            ['date', 'default', 'value' => time()],

            [['date_start', 'date_finish'], 'integer'],

            ['date_start', 'default', 'value' => time()],
            ['date_finish', 'default', 'value' => time()],

            ['dateTimeStart', 'date', 'format' => 'php:d.m.Y H:i'],
            ['dateTimeFinish', 'date', 'format' => 'php:d.m.Y H:i'],

            [['logCategories', 'objectCategories', 'objectSystems'], 'safe'],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'description' => 'Описание',
            'date' => 'Дата создания',
            'date_start' => 'Начальная дата',
            'date_finish' => 'Конечная дата',
            'dateTimeStart' => 'Начальная дата',
            'dateTimeFinish' => 'Конечная дата',
            'status' => 'Статус',
        ];
    }

    public function getDateTimeStart()
    {
        return $this->date ? \DateTime::createFromFormat('U', $this->date)
            ->modify('+3 hour')->format('d.m.Y H:i') : '';
    }

    public function getDateTimeFinish()
    {
        return $this->date ? \DateTime::createFromFormat('U', $this->date)
            ->modify('+3 hour')->format('d.m.Y H:i') : '';
    }

    public function setDateTimeStart($string)
    {
        $date = \DateTime::createFromFormat('d.m.Y H:i', $string);
        $this->date_start = $date->format('U');
    }


    public function setDateTimeFinish($string)
    {
        $date = \DateTime::createFromFormat('d.m.Y H:i', $string);
        $this->date_finish = $date->format('U');
    }

    public function getLogCategoryIds()
    {
        $ids = [];
        $models = AuditLogCategory::find()->where(['audit_id' => $this->id])->indexBy('id')->all();
        if(!empty($models)){
            foreach($models as $model){
                $ids[] = $model->log_category_id;
            }
        }
        return $ids;
    }

    public function getObjectCategoryIds()
    {
        $ids = [];
        $models = AuditObjectCategory::find()->where(['audit_id' => $this->id])->indexBy('id')->all();
        if(!empty($models)){
            foreach($models as $model){
                $ids[] = $model->object_category_id;
            }
        }
        return $ids;
    }

    public function getObjectSystemsIds()
    {
        $ids = [];
        $models = AuditObjectSystem::find()->where(['audit_id' => $this->id])->indexBy('id')->all();
        if(!empty($models)){
            foreach($models as $model){
                $ids[] = $model->object_system_id;
            }
        }
        return $ids;
    }

    public function saveLogCategories()
    {
        $logCategories = $this->logCategories;

        if (!empty($logCategories)) {
            AuditLogCategory::deleteAll(['audit_id' => $this->id]);
            foreach ($logCategories as $logCategory) {
                $auditLogCategory = new AuditLogCategory();
                $auditLogCategory->audit_id = $this->id;
                $auditLogCategory->log_category_id = (int)$logCategory;
                $auditLogCategory->save();
            }
        }
    }

    public function saveObjectCategories()
    {
        $objectCategories = $this->objectCategories;

        if (!empty($objectCategories)) {
            AuditObjectCategory::deleteAll(['audit_id' => $this->id]);
            foreach ($objectCategories as $objectCategory) {
                $auditObjectCategory = new AuditObjectCategory();
                $auditObjectCategory->audit_id = $this->id;
                $auditObjectCategory->object_category_id = (int)$objectCategory;
                $auditObjectCategory->save();
            }
        }
    }

    public function saveObjectSystems()
    {
        $objectSystems = $this->objectSystems;

        if (!empty($objectSystems)) {
            AuditObjectSystem::deleteAll(['audit_id' => $this->id]);
            foreach ($objectSystems as $objectSystem) {
                $auditObjectSystem = new AuditObjectSystem();
                $auditObjectSystem->audit_id = $this->id;
                $auditObjectSystem->object_system_id = (int)$objectSystem;
                $auditObjectSystem->save();
            }
        }
    }
}
