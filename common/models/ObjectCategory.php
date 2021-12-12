<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "objectct_category".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $priority
 */
class ObjectCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objectct_category';
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
