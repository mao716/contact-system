<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
	public function toResponse($request)
	{
		// 非同期(ajax)なら204、通常はログイン画面へ
		return $request->wantsJson()
			? new JsonResponse('', 204)
			: redirect()->route('login');
	}
}
