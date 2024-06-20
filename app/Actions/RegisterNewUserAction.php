<?php

namespace App\Actions;

use App\Contracts\RegisterNewUserContract;
use App\DTOs\NewUserDTO;
use App\Models\User;
use App\Support\SessionRegenerator;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction implements RegisterNewUserContract
{

    public function __invoke(NewUserDTO $data)
    {
        $user = User::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
        ]);

        event(new Registered($user));

        SessionRegenerator::run(fn() => auth()->login($user));
    }
}
