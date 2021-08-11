<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-4 col-md-offset-4">
			<?php $form = ActiveForm::begin([
				'id'     => 'login-form',
				'action' => Url::to(['login']),
			]) ?>
			<div class="form-group">
				<legend><b>LOGIN</b></legend>
			</div>
			<?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Email") ?>

			<?= $form->field($model, 'password')->passwordInput()->label('Password (' . Html::a('forgot password', ['site/register']) . ')') ?>

			<?= $form->field($model, 'rememberMe')->checkbox() ?>
			<p>If you already have an account, go to the <?= Html::a('<b>registration</b>', ['site/register']) ?> page.</p>
			<div class="form-group">
				<div class="col-md-6 col-xs-12" style="padding:5px">
					<button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
				</div>
				<div class="col-md-6 col-xs-12" style="padding:5px">
					<button type="reset" class="btn btn-warning" style="width: 100%;">Reset</button>
				</div>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>