<?php
namespace ant\discount\components;

use Yii;
use ant\discount\helpers\Discount;
use ant\discount\models\DiscountRule;
use ant\discount\components\DiscountCalculator;

class DiscountManager extends \yii\base\Component {
	
	public $overrideMethods = [];
	public $rules = [];
	
	protected $_initRules = false;
	protected $_calculator;
	protected $_context = [];
	
	public function setContext($name, $value) {
		$this->_context[$name] = $value;
	}
	
	public function getCalculator() {
		if (!isset($this->_calculator)) {
			$rules = [];
			
			// Init set rules
			foreach ($this->rules as $rule) {
				$rules[] = Yii::createObject($rule);
			}
			
			// Load db rules
			$dbRules = \ant\discount\models\DiscountRule::find()->all();
			foreach ($dbRules as $rule) {
				$rules[] = $rule->getRule();
			}
			
			$this->_calculator = DiscountCalculator::with($this->_context)->addRules($rules);
		}
		return $this->_calculator;
	}
	
	public function getDiscountForForm($formModel) {
		
		if (isset($this->overrideMethods['getDiscountForForm']) && is_callable($this->overrideMethods['getDiscountForForm'])) {
			return call_user_func_array($this->overrideMethods['getDiscountForForm'], [$formModel]);
		}
		
		return Discount::percent($this->_getDiscountForItem($formModel->item, $formModel->quantity) * 100);
	}
	
	public function getDiscountAmountForForm($formModel) {
		
	}
	
	public function getDiscountAmountForItem($item, $price, $quantity) {
		$rate = $this->getDiscountForItem($item, $quantity);
		return $price * $rate;
	}
	
	// Return value > 0 for percentage discount, return value < 0 for amount discount
	protected function _getDiscountForItem($item, $quantity) {
		if (isset($this->overrideMethods['getDiscountAmountForItem']) && is_callable($this->overrideMethods['getDiscountAmountForItem'])) {
			return call_user_func_array($this->overrideMethods['getDiscountAmountForItem'], [$item, $quantity]);
		}
		if (!\Yii::$app->user->isGuest) {
			$percentage = \Yii::$app->user->identity->getDynamicAttribute('discountRate');
			
			$rules = DiscountRule::find()->andWhere(['class' => \ant\discount\rule\CatalogRule::className()])->all();
			
			if (isset($rules)) {
				return $percentage / 100;
			}
		}
	}
	
	public function getDiscountForCart($cart) {
		if (isset($this->overrideMethods['getDiscountForCart']) && is_callable($this->overrideMethods['getDiscountForCart'])) {
			return call_user_func_array($this->overrideMethods['getDiscountForCart'], [$cart]);
		}
		$this->calculator->cart = $cart;
		return $this->calculator->getCartDiscount();
	}
	
	public function getDiscountForCartItem($cartItem) {
		if (isset($this->overrideMethods['getDiscountForCartItem']) && is_callable($this->overrideMethods['getDiscountForCartItem'])) {
			return call_user_func_array($this->overrideMethods['getDiscountForCartItem'], [$cartItem]);
		}
		return $this->calculator->getCartItemDiscount($cartItem);
	}
}