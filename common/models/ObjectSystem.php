<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

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
            [['priority', 'object_category_id'], 'integer'],
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
            'object_category_id' => 'Категория',
        ];
    }

    public function getObjectCategory()
    {
        return $this->hasOne(ObjectCategory::class, ['id' => 'object_category_id']);
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
