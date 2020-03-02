<?php

namespace ant\discount\migrations\db;

use ant\db\Migration;

/**
 * Class M200301055931CreateDiscountCoupon
 */
class M200301055931CreateDiscountCoupon extends Migration
{
	public $tableName = '{{%discount_coupon}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->unsigned(),
			'rule_id' => $this->integer()->unsigned()->notNull(),
            'code' => $this->string(50)->defaultValue(null)->unique(),
			'usage_limit' => $this->smallInteger()->null()->defaultValue(null),
			'usage_per_user' => $this->smallInteger()->null()->defaultValue(null),
			'times_used' => $this->smallInteger()->notNull()->defaultValue(0),
			'status' => $this->smallInteger(3)->notNull()->defaultValue(0),
			'expire_at' => $this->timestamp()->defaultValue(null),
            'created_by' => $this->integer(11)->unsigned(),
            'updated_by' => $this->integer(11)->unsigned(),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => $this->timestamp()->defaultValue(null),
        ], $this->getTableOptions());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M200301055931CreateDiscountCoupon cannot be reverted.\n";

        return false;
    }
    */
}
