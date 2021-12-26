<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

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
            [['log_category_id', 'user_id', 'object_id', 'priority', 'damages', 'type'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['date', 'integer'], //проверка
            ['date', 'default', 'value' => time()], //значение по умолчанию
            ['dateTime', 'date', 'format' => 'php:d.m.Y H:i'], //формат модели с которой будем работать,
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

    public function getLogCategory()
    {
        return $this->hasOne(LogCategory::class, ['id' => 'log_category_id']);
    }

    public function getObjectSystem()
    {
        return $this->hasOne(ObjectSystem::class, ['id' => 'object_id']);
    }

    public function getDateTime()
    {
        return $this->date ? \DateTime::createFromFormat('U', $this->date)
            ->modify('+3 hour')->format('d.m.Y H:i') : '';
    }

    public function setDateTime($string)
    {
        $date = \DateTime::createFromFormat('d.m.Y H:i', $string);
        $this->date = $date->format('U');
    }

    public static function dropDown()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

    public static function getListForSelect( $attributeName = null )
    {
        $values = [];
        if ( ! is_null( $attributeName ) ) {
            $values =  ArrayHelper::map(self::find()->all(), 'id', $attributeName );
        }

        return $values;
    }
}
