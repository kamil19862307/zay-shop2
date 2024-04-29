<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Models\User;
use App\Support\SessionRegenerator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.index');
    }

    public function signUp(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.sign-up');
    }

    public function store(SignUpFormRequest $request): RedirectResponse
    {
        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        event(new Registered($user));

        SessionRegenerator::run(fn() => auth()->login($user));

        return redirect()->back();
    }

    public function forgot(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(ForgotPasswordFormRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === Password::RESET_LINK_SENT){
            flash()->info(__($status));

            return back();
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function reset($token): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.reset-password', [
            'token' => $token
        ]);
    }

    public function resetPassword(ResetPasswordFormRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ( $status === Password::PASSWORD_RESET){
            flash()->info(__($status));

            return redirect()->route('logIn');
        }
            return redirect()->route('logIn')->withErrors(['email' => [__($status)]]);
    }

    public function signIn(SignInFormRequest $request): RedirectResponse
    {
        if (!auth()->once($request->validated(), $request->get('remember'))) {
            return back()->withErrors([
                'email' => 'Введенные данные не совпадают с имеющимися в базе.',
            ])->onlyInput('email');
        }

        SessionRegenerator::run(fn() => auth()->login(
            auth()->user()
        ));

        return redirect()->intended(route('home'));
    }

    public function logOut(): RedirectResponse
    {
        SessionRegenerator::run(fn() => auth()->logout());

        return redirect()->back();
    }
}
