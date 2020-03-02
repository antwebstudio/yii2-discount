<?php

namespace ant\discount\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use ant\discount\models\DiscountCouponForm;

/**
 * Default controller for the `discount` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	public function actionApplyCoupon() {
		$model = new DiscountCouponForm;
		
		if ($model->load(Yii::$app->request->post()) && $model->apply()) {
			
		} else {
			//throw new \Exception(print_r($model->errors,1 ));
			Yii::$app->session->setFlash('error', Html::errorSummary($model));
		}
		return $this->redirect(isset(Yii::$app->request->referrer) ? Yii::$app->request->referrer : ['/cart']);
	}
	
	public function actionRemoveCoupon($code) {
		$model = new DiscountCouponForm;
		$model->coupon = $code;
		
		if ($model->remove()) {
		}
		
		return $this->redirect(isset(Yii::$app->request->referrer) ? Yii::$app->request->referrer : ['/cart']);
	}
}
