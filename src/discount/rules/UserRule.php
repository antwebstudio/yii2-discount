<?php
namespace ant\discount\rules;

use yii\helpers\ArrayHelper;

class UserRule extends DiscountRule {
	protected function shouldApplyToCart($cart) {
		return $this->matchUsers();
	}
	
	protected function shouldApplyToCartItem($cartItem) {
		return $this->matchUsers();
	}
	
	protected function matchUsers() {
		if (!\Yii::$app->user->isGuest && count($this->users)) {
			return ArrayHelper::isIn(\Yii::$app->user->id, $this->users);
		}
		return false;
	}
}