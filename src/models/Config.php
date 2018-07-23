<?php

namespace toshcn\yii2\configurator\models;

use Yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property int $id
 * @property string $config_name
 * @property string $config_content
 * @property string $config_description
 * @property string $create_at
 * @property string $update_at
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['config_name', 'config_content', 'create_at'], 'required'],
            [['config_content'], 'string'],
            [['config_description'], 'default', 'value' => ''],
            [['create_at', 'update_at', 'config_description'], 'safe'],
            [['config_name'], 'string', 'max' => 32],
            [['config_content'], 'string', 'max' => 65000],
            [['config_description'], 'string', 'max' => 1000],
            [['config_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'config_name' => 'Config Name',
            'config_content' => 'Config Content',
            'config_description' => 'Config Description',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * Find config by config_id
     *
     * @param integer $id
     * @return null|static
     */
    public static function findById($id)
    {
        return static::findOne(['config_id' => $id]);
    }

    /**
     * Find config by config_name
     *
     * @param string $name
     * @return null|static
     */
    public static function findByConfigName($name)
    {
        return static::findOne(['config_name' => $name]);
    }
}
