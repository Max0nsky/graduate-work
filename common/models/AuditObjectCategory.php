<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "audit_object_category".
 *
 * @property int $id
 * @property int $audit_id
 * @property int $object_category_id
 */
class AuditObjectCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_object_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['audit_id', 'object_category_id'], 'required'],
            [['audit_id', 'object_category_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'audit_id' => 'Audit ID',
            'object_category_id' => 'Object Category ID',
        ];
    }
}
