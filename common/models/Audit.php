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

            [['name'], 'required'],
            [['description'], 'required'],
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

    public static function calculateCvss($post)
    {
        $result = [];
        $values = self::getCvssValues();

        $vector = "AV:" . $post["AV"] . "/AC:" . $post["AC"] . "/Au:" . $post["Au"] . "/C:" . $post["C"] . "/I:" . $post["I"] .  "/A:" . $post["A"] .
            "/E:" . $post["E"] . "/RL:" . $post["RL"] . "/RC:" . $post["RC"] .
            "/CDP:" . $post["CDP"] . "/TD:" . $post["TD"] . "/CR:" . $post["CR"] . "/IR:" . $post["IR"] . "/AR:" . $post["AR"];

        //Базовые метрики (base)
        $Impact = 10.41 * (1 - (1 - $values["C"][$post["C"]]) * (1 - $values["I"][$post["I"]]) * (1 - $values["A"][$post["A"]]));
        $f = ($Impact == 0) ? 0 : 1.176;
        $Exploitability = 20 * $values["AV"][$post["AV"]] * $values["AC"][$post["AC"]] * $values["Au"][$post["Au"]];
        $BaseScore = round(((0.6 * $Impact) + (0.4 * $Exploitability) - 1.5) * $f, 1);

        //Временные метрики (time)
        $TemporalScore = round($BaseScore * $values["E"][$post["E"]] * $values["RL"][$post["RL"]] * $values["RC"][$post["RC"]], 1);

        //Контекстные метрики (environmental)
        $AdjustedImpact = min(10, 10.41 * (1 - (1 - $values["C"][$post["C"]] * $values["CR"][$post["CR"]]) * (1 - $values["I"][$post["I"]] * $values["IR"][$post["IR"]]) * (1 - $values["A"][$post["A"]] * $values["AR"][$post["AR"]])));
        $fa = ($AdjustedImpact == 0) ? 0 : 1.176;
        $AdjustedBase = ((0.6 * $AdjustedImpact) + (0.4 * $Exploitability) - 1.5) * $fa;
        $AdjustedTemporal = $AdjustedBase * $values["E"][$post["E"]] * $values["RL"][$post["RL"]] * $values["RC"][$post["RC"]];
        $EnvironmentalScore = round(($AdjustedTemporal + (10 - $AdjustedTemporal) * $values["CDP"][$post["CDP"]]) * $values["TD"][$post["TD"]], 1);

        $result['vector'] = $vector;
        $result['BaseScore'] = $BaseScore;
        $result['Impact'] = $Impact;
        $result['TemporalScore'] = $TemporalScore;
        $result['EnvironmentalScore'] = $EnvironmentalScore;

        return $result;
    }

    public static function lvlCvss($score)
    {
        $result = "Не найдено";

        if (0.0 <= $score and $score <= 3.9) {
            $result = "Низкий уровень опасности.";
        } elseif (4.0 <= $score and $score  <= 6.9) {
            $result = "Средний уровень опасности.";
        } elseif (7.0 <= $score and $score  <= 9.9) {
            $result = "Высокий уровень опасности.";
        } elseif ($score == 10.0) {
            $result = "Критический уровень опасности.";
        }

        return $result;
    }

    public static function getCvssValues()
    {
        $cvssValues = array(
            //Base
            "AV" => array(
                "L" => 0.395,
                "A" => 0.646,
                "N" => 1.0
            ),
            "AC" => array(
                "H" => 0.35,
                "M" => 0.61,
                "L" => 0.71
            ),
            "Au" => array(
                "M" => 0.45,
                "S" => 0.56,
                "N" => 0.704
            ),
            "C" => array(
                "N" => 0.0,
                "P" => 0.275,
                "C" => 0.660
            ),
            "I" => array(
                "N" => 0.0,
                "P" => 0.275,
                "C" => 0.660
            ),
            "A" => array(
                "N" => 0.0,
                "P" => 0.275,
                "C" => 0.660
            ),
            //Time
            "E" => array(
                "ND" => 1.00,
                "U" => 0.85,
                "POC" => 0.9,
                "F" => 0.95,
                "H" => 1.00
            ),
            "RL" => array(
                "ND" => 1.00,
                "OF" => 0.87,
                "T" => 0.90,
                "W" => 0.95,
                "U" => 1.00
            ),
            "RC" => array(
                "ND" => 1.00,
                "UC" => 0.90,
                "UR" => 0.95,
                "C" => 1.00
            ),
            //Environmental
            "CDP" => array(
                "ND" => 0,
                "N" => 0,
                "L" => 0.1,
                "LM" => 0.3,
                "MH" => 0.4,
                "H" => 0.5
            ),
            "TD" => array(
                "ND" => 1.00,
                "N" => 0,
                "L" => 0.25,
                "M" => 0.75,
                "H" => 1.00,
            ),
            "CR" => array(
                "ND" => 1.00,
                "L" => 0.5,
                "M" => 1.0,
                "H" => 1.51
            ),
            "IR" => array(
                "ND" => 1.00,
                "L" => 0.5,
                "M" => 1.0,
                "H" => 1.51
            ),
            "AR" => array(
                "ND" => 1.00,
                "L" => 0.5,
                "M" => 1.0,
                "H" => 1.51
            )
        );
        return $cvssValues;
    }
}
