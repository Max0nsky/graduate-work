<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "audit_log_category".
 *
 * @property int $id
 * @property int $audit_id
 * @property int $log_category_id
 */
class AuditLogCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_log_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['audit_id', 'log_category_id'], 'required'],
            [['audit_id', 'log_category_id'], 'integer'],
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
            'log_category_id' => 'Log Category ID',
        ];
    }
}
