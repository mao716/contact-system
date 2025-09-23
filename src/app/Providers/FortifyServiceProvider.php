<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use Laravel\Fortify\Fortify;
use App\Http\Requests\Auth\LoginRequest as AppLoginRequest;

class FortifyServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		$this->app->bind(FortifyLoginRequest::class, AppLoginRequest::class);
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		Fortify::loginView(function () {
			return view('auth.login');
		});

		Fortify::registerView(function () {
			return view('auth.register');
		});
	}
}
