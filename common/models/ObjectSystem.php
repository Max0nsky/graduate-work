<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "object_system".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $priority
 */
class ObjectSystem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_system';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['priority'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Наименование',
            'description' => 'Описание',
            'priority' => 'Приоритет',
        ];
    }
}
