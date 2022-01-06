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
            [['name', 'description', 'result_need', 'dateNeed', 'priority', 'cost_need', 'priority'], 'required'],
            [['description', 'result_need', 'result_fact'], 'string'],
            [['audit_id', 'date', 'date_need_execut', 'date_fact_execut', 'priority', 'cost_need', 'cost_fact', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],

            ['date_need_execut', 'integer'], //проверка
            ['date_need_execut', 'default', 'value' => time()], //значение по умолчанию
            ['dateNeed', 'date', 'format' => 'php:d.m.Y H:i'], //формат модели с которой будем работать,

            ['date_fact_execut', 'integer'], //проверка
            ['date_fact_execut', 'default', 'value' => time()], //значение по умолчанию
            ['dateFact', 'date', 'format' => 'php:d.m.Y H:i'], //формат модели с которой будем работать,
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
            'audit_id' => 'Аудит ID',
            'date' => 'Дата создания',
            'date_need_execut' => 'Дата ожидаемого выполнения',
            'date_fact_execut' => 'Дата фактического выполнения',
            'dateNeed' => 'Дата ожидаемого выполнения',
            'dateFact' => 'Дата фактического выполнения',
            'priority' => 'Приоритет',
            'cost_need' => 'Ожидаемые затраты',
            'cost_fact' => 'Фактические затраты',
            'result_need' => 'Ожидаемый результат',
            'result_fact' => 'Фактический результат',
            'status' => 'Статус',
        ];
    }

    public function getDateNeed()
    {
        return $this->date_need_execut ? \DateTime::createFromFormat('U', $this->date_need_execut)
            ->modify('+3 hour')->format('d.m.Y H:i') : '';
    }

    public function setDateNeed($string)
    {
        $date = \DateTime::createFromFormat('d.m.Y H:i', $string);
        $this->date_need_execut = $date->format('U');
    }

    public function getDateFact()
    {
        return $this->date_fact_execut ? \DateTime::createFromFormat('U', $this->date_fact_execut)
            ->modify('+3 hour')->format('d.m.Y H:i') : '';
    }

    public function setDateFact($string)
    {
        $date = \DateTime::createFromFormat('d.m.Y H:i', $string);
        $this->date_fact_execut = $date->format('U');
    }

    public function getNameStatus()
    {
        $statuses = [
            0 => '<p style="color:#FF8C00;">#' . $this->status . ' Создана</p>',
            1 => '<p style="color:#8B0000;">#' . $this->status . ' Не выполнено</p>',
            2 => '<p style="color:DarkGreen;">#' . $this->status . ' Выполнено</p>',
        ];

        return $statuses[$this->status];
    }

    public static function getRecs()
    {
        return self::find()->where(['!=', 'status', 0])->count();
    }

    public static function getSuccessRecs()
    {
        return self::find()->where(['=', 'status', 1])->count();
    }

    public static function getErrorRecs()
    {
        return self::find()->where(['=', 'status', 2])->count();
    }

    public static function getNeedFactCosts()
    {
        $needCost = 0;
        $factCost = 0;

        $recs = self::find()->where(['=', 'status', 1])->all();
        if (!empty($recs)) {
            foreach ($recs as $rec) {
                $needCost += $rec->cost_need;
                $factCost += $rec->cost_fact;
            }
        }

        return ['needCost' => $needCost, 'factCost' => $factCost];
    }
}
