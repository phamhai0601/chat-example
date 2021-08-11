<?php

namespace app\form;

use app\models\User;
use yii\base\Model;

class RegisterForm extends Model {

	public $email;

	public $username;

	public $password;

	public $re_password;

	public function rules() {
		return [
			[
				[
					'email',
					'username',
					'password',
					're_password',
				],
				'required',
			],
			[
				'email',
				'email',
			],
			[
				[
					'password',
					're_password',
				],
				'string',
				'min' => 6,
			],
			[
				're_password',
				'compare',
				'compareAttribute' => 'password',
			],
		];
	}

	/**
	 * Register user.
	 *
	 * @return void
	 */
	public function register() {
		if (!$this->validate()) {
			return false;
		}
		$user = User::newInstance($this);
		if ($user) {
			return $user;
		}
		return null;
	}
}