<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<style>
.coupon { border: 1px #cccccc solid; }
</style>

<ul class="list-group">
<?php foreach ($coupons as $coupon): ?>
	<li class="list-group-item">
		<span class="float-left"><?= $coupon ?></span>
		<a class="float-right" href="<?= Url::to(['/discount/default/remove-coupon', 'code' => $coupon]) ?>"><i class="fa fa-trash"></i></a>
	</li>
<?php endforeach ?>
</ul>

<?php $form = ActiveForm::begin(['action' => $this->context->url]) ?>
	<?= $form->field($model, 'coupon') ?>
	<?= Html::submitButton(Yii::t('discount', 'Apply'), ['class' => 'btn btn-secondary']) ?>
<?php ActiveForm::end() ?>