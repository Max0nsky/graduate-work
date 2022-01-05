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
            [['date_start', 'date_finish'], 'integer'],

            ['date_start', 'default', 'value' => time()],
            ['date_finish', 'default', 'value' => time()],

            ['dateTimeStart', 'date', 'format' => 'php:d.m.Y H:i'],
            ['dateTimeFinish', 'date', 'format' => 'php:d.m.Y H:i'],

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
            'date' => 'Date',
            'date_start' => 'Date Start',
            'date_finish' => 'Date Finish',
            'status' => 'Status',
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


}
