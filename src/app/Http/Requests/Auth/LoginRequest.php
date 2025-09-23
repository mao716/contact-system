<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Http\Requests\LoginRequest as Base; // これを継承

class LoginRequest extends Base
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'email'    => ['required', 'email'], // ユーザー名@ドメイン形式
			'password' => ['required'],
		];
	}
	public function messages(): array
	{
		return [
			'email.required'    => 'メールアドレスを入力してください',
			'email.email'       => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
			'password.required' => 'パスワードを入力してください',
		];
	}
}
