<?php

namespace ant\discount\models;

use Yii;
use ant\helpers\StringHelper as Str;

/**
 * This is the model class for table "discount_coupon".
 *
 * @property int $id
 * @property int $rule_id
 * @property string $code
 * @property int $usage_limit
 * @property int $usage_per_user
 * @property int $times_used
 * @property int $status
 * @property string $expire_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class DiscountCoupon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%discount_coupon}}';
    }
	
	public static function create($length = 8) {
		$model = new self;
		$model->code = strtoupper(Str::generateRandomString($length));
		
		//if (!$model->save()) throw new \Exception(print_r($model->errors, 1));
		
		return $model;
	}
	
	public function saveWithRule($rule, $attributes = []) {
		$rule = DiscountRule::createFrom($rule);
		$rule->attributes = $attributes;
		
		if (!$rule->save()) throw new \Exception(print_r($rule->errors, 1));
		
		$this->rule_id = $rule->id;
		
		if (!$this->save()) throw new \Exception(print_r($this->errors, 1));
		
		return $this;
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rule_id'], 'required'],
            [['rule_id', 'usage_limit', 'usage_per_user', 'times_used', 'status', 'created_by', 'updated_by'], 'integer'],
            [['expire_at', 'created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rule_id' => 'Rule ID',
            'code' => 'Code',
            'usage_limit' => 'Usage Limit',
            'usage_per_user' => 'Usage Per User',
            'times_used' => 'Times Used',
            'status' => 'Status',
            'expire_at' => 'Expire At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
