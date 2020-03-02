<?php

namespace ant\discount\migrations\db;

use ant\db\Migration;

/**
 * Class M200301095942AlterDiscountRule
 */
class M200301095942AlterDiscountRule extends Migration
{
	public $tableName = '{{%discount_rule}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->renameColumn($this->tableName, 'class', 'class_id');
		$this->alterColumn($this->tableName, 'class_id', $this->morphClass());
		$this->dropColumn($this->tableName, 'code');
		$this->addColumn($this->tableName, 'setting', $this->text());
		$this->alterColumn($this->tableName, 'priority', $this->smallInteger(3)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->alterColumn($this->tableName, 'class_id', $this->string(512)->notNull());
		$this->renameColumn($this->tableName, 'class_id', 'class');
		$this->addColumn($this->tableName, 'code', $this->string(50)->defaultValue(NULL));
		$this->dropColumn($this->tableName, 'setting');
		$this->alterColumn($this->tableName, 'priority', $this->smallInteger(3)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M200301095942AlterDiscountRule cannot be reverted.\n";

        return false;
    }
    */
}
