<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "threat".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $source
 * @property int $object_id
 * @property int $charact_k
 * @property int $charact_c
 * @property int $charact_d
 */
class Threat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'threat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'object_id', 'charact_k', 'charact_c', 'charact_d'], 'required'],
            [['description'], 'string'],
            [['object_id', 'charact_k', 'charact_c', 'charact_d'], 'integer'],
            [['name', 'source'], 'string', 'max' => 255],
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
            'source' => 'Источник',
            'object_id' => 'Объект',
            'charact_k' => 'Конфиденциальность',
            'charact_c' => 'Целостность',
            'charact_d' => 'Доступность',
        ];
    }

    public function getObjectSystem()
    {
        return $this->hasOne(ObjectSystem::class, ['id' => 'object_id']);
    }
    
    public static function getListYesNo($id = false) {
        $array = [
            'Нет',
            'Да',
        ];
        if (is_bool($id)) {
            return $array;
        }
        return $array[$id];
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
