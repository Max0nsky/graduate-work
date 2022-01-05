<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "audit_object_system".
 *
 * @property int $id
 * @property int $audit_id
 * @property int $object_system_id
 */
class AuditObjectSystem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_object_system';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['audit_id', 'object_system_id'], 'required'],
            [['audit_id', 'object_system_id'], 'integer'],
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
            'object_system_id' => 'Object System ID',
        ];
    }
}
