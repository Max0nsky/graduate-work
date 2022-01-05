<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "recommendation".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $audit_id
 * @property int $date Дата выдачи рекомендации
 * @property int|null $date_need_execut Дата, к которой выполнить
 * @property int|null $date_fact_execut Дата фактического выполнения
 * @property int|null $priority
 * @property int|null $cost
 * @property string|null $result_need
 * @property string|null $result_fact
 * @property int $status
 */
class Recommendation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recommendation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date'], 'required'],
            [['description', 'result_need', 'result_fact'], 'string'],
            [['audit_id', 'date', 'date_need_execut', 'date_fact_execut', 'priority', 'cost', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'audit_id' => 'Audit ID',
            'date' => 'Date',
            'date_need_execut' => 'Date Need Execut',
            'date_fact_execut' => 'Date Fact Execut',
            'priority' => 'Priority',
            'cost' => 'Cost',
            'result_need' => 'Result Need',
            'result_fact' => 'Result Fact',
            'status' => 'Status',
        ];
    }
}
