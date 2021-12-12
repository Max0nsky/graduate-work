<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int|null $log_category_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $user_id
 * @property int|null $object_id
 * @property int|null $priority
 * @property int|null $damages
 * @property int|null $type
 * @property int|null $date
 */
class Log extends \yii\db\ActiveRecord
{
    public $date_pick;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['log_category_id', 'user_id', 'object_id', 'priority', 'damages', 'type', 'date'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['date_pick'], 'string'],
            [['description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'log_category_id' => 'Категория логов',
            'name' => 'Наименование',
            'description' => 'Описание',
            'user_id' => 'Пользователь',
            'object_id' => 'Объект',
            'priority' => 'Приоритет',
            'damages' => 'Убытки',
            'type' => 'Тип',
            'date' => 'Дата',
        ];
    }
}
