<?php

use yii\db\Migration;

/**
 * Class m180723_064449_config
 */
class m180723_064449_config extends Migration
{
    const CONFIG = '{{%config}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(static::CONFIG, [
            'id' => $this->primaryKey()->unique()->notNull(),
            'config_name' => $this->string(32)->unique()->notNull(),
            'config_content' => $this->text(),
            'config_description' => $this->string(1000)->notNull()->defaultValue(''),
            'create_at' => $this->dateTime()->notNull(),
            'update_at' => $this->dateTime()->Null(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //echo "m180723_064449_config cannot be reverted.\n";
        $this->dropTable(static::CONFIG);
    }
}
