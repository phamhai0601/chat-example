<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \app\form\RegisterForm $model */
$this->title                   = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="col-md-12">
		<div class="col-md-4 col-md-offset-4">
			<?php $form = ActiveForm::begin([
				'id'     => 'register-form',
				'action' => Url::to(['register']),
			]) ?>
			<div class="form-group">
				<legend><b>REGISTER</b></legend>
			</div>
			<?= $form->field($model, 'username')->textInput(['placeholder' => 'Enter username...']) ?>
			<?= $form->field($model, 'email')->textInput(['placeholder' => 'Enter email...']) ?>
			<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter password...']) ?>
			<?= $form->field($model, 're_password')->passwordInput(['placeholder' => 'Enter password...']) ?>
			<p>If you already have an account, go to the <?= Html::a('<b>login</b>', ['login']) ?> page</p>
			<div class="form-group">
				<div class="col-md-6 col-xs-12" style="padding:5px">
					<button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
				</div>
				<div class="col-md-6 col-xs-12" style="padding:5px">
					<button type="reset" class="btn btn-warning" style="width: 100%;">Reset</button>
				</div>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>