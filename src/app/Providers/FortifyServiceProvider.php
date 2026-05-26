<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
    $this->app->instance(LoginResponse::class, new class implements LoginResponse {
    public function toResponse($request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/');
        }

        return redirect('/email/verify');
    }
});

$this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
    public function toResponse($request)
    {
        return redirect('/login');
    }
});

$this->app->instance(VerifyEmailResponse::class, new class implements VerifyEmailResponse {
    public function toResponse($request)
    {
        return redirect('/mypage/profile');
    }
});

$this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
    public function toResponse($request)
    {
        return redirect('/email/verify');
    }
});
    
    Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::authenticateUsing(function (LoginRequest $request) {
            $request->validated();

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });
        Fortify::verifyEmailView(function () {
    return view('auth.verify-email');
});
    }
}