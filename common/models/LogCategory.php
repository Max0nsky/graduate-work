<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "log_category".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 */
class LogCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
            [['priority',], 'integer'],
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
