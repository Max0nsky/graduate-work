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

    public function getLogs()
    {
        $query = Log::find();

        $query->where(['>=', 'date', $this->date_start]);
        $query->andWhere(['<=', 'date', $this->date_finish]);

        $logCategoriesIds = $this->logCategoryIds;
        $objectCategoriesIds = $this->logCategoryIds;
        $objectSystemsIds = $this->ObjectSystemsIds;

        if (!empty($logCategoriesIds)) {
            $query->andWhere(['in', 'log_category_id', $logCategoriesIds]);
        }

        if (!empty($objectCategoriesIds)) {

            $objectCategories = ObjectSystem::find()->where(['in', 'object_category_id', $objectCategoriesIds])->all();
            foreach ($objectCategories as $objectCategory) {
                if (!in_array($objectCategory->id, $objectSystemsIds)) {
                    $objectSystemsIds[] = $objectCategory->id;
                }
            }
        }
        if (!empty($objectSystemsIds)) {
            $query->andWhere(['in', 'object_id', $objectSystemsIds]);
        }

        return $query->all();
    }

    public function getDateTimeStart()
    {
        return $this->date_start ? \DateTime::createFromFormat('U', $this->date_start)
            ->modify('+3 hour')->format('d.m.Y H:i') : '';
    }

    public function getDateTimeFinish()
    {
        return $this->date_finish ? \DateTime::createFromFormat('U', $this->date_finish)
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

    public function getRecommendations()
    {
        return $this->hasMany(Recommendation::className(), ['audit_id' => 'id']);
    }

    public function getModelsLogCategories()
    {
        return $this->hasMany(LogCategory::className(), ['id' => 'log_category_id'])
            ->viaTable(AuditLogCategory::tableName(), ['audit_id' => 'id']);
    }

    public function getModelsObjectCategories()
    {
        return $this->hasMany(ObjectCategory::className(), ['id' => 'object_category_id'])
            ->viaTable(AuditObjectCategory::tableName(), ['audit_id' => 'id']);
    }

    public function getModelsObjectSystems()
    {
        return $this->hasMany(ObjectSystem::className(), ['id' => 'object_system_id'])
            ->viaTable(AuditObjectSystem::tableName(), ['audit_id' => 'id']);
    }
    
    public function getLogCategoryIds()
    {
        $ids = [];
        $models = AuditLogCategory::find()->where(['audit_id' => $this->id])->indexBy('id')->all();
        if (!empty($models)) {
            foreach ($models as $model) {
                $ids[] = $model->log_category_id;
            }
        }
        return $ids;
    }

    public function getObjectCategoryIds()
    {
        $ids = [];
        $models = AuditObjectCategory::find()->where(['audit_id' => $this->id])->indexBy('id')->all();
        if (!empty($models)) {
            foreach ($models as $model) {
                $ids[] = $model->object_category_id;
            }
        }
        return $ids;
    }

    public function getObjectSystemsIds()
    {
        $ids = [];
        $models = AuditObjectSystem::find()->where(['audit_id' => $this->id])->indexBy('id')->all();
        if (!empty($models)) {
            foreach ($models as $model) {
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

    public function getNameStatus()
    {
        $statuses = [
            0 => 'Шаг 1',
            1 => 'Шаг 2',
            2 => 'Завершен',
            3 => 'Окончен',
        ];

        return $statuses[$this->status];
    }
}
