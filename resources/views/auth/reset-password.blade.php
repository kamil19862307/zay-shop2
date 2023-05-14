@extends('layouts.auth')

@section('title')
    {{__('Регистрация')}}
@endsection

@section('content')
    <!-- Start Register Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Восстановить пароль</h1>
        </div>
    </div>

    <div class="container py-5">
        <div class="row py-5">
            <form action="{{ route('password.update') }}" class="col-md-8 m-auto" method="POST" role="form">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                @if ($errors->any())
                    <div class="alert alert-danger row m-auto text-center">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row m-auto text-center">
                    <div class="form-group col-md-8 m-auto mb-3 @error('email') border-red-500 @enderror">
                        <input
                                type="email"
                                class="form-control mt-1"
                                id="email"
                                name="email"
                                value="{{ request('email') }}"
                                placeholder="E-mail"
                                style="line-height: 2.5;"
                        >
                    </div>
                    <div class="form-group col-md-8 m-auto mb-3 @error('password') border-red-500 @enderror">
                        <input
                                type="password"
                                class="form-control mt-1"
                                id="password" name="password"
                                placeholder="Пароль"
                                style="line-height: 2.5;"
                        >
                    </div>
                    <div class="form-group col-md-8 m-auto mb-3 @error('password_confirmation') border-red-500 @enderror">
                        <input
                                type="password"
                                class="form-control mt-1"
                                id="password_confirmation" name="password_confirmation"
                                placeholder="Подтверждение пароля"
                                style="line-height: 2.5;"
                        >
                    </div>

                    <div class="form-group col-md-8 m-auto mb-5">
                        <button type="submit" class="btn btn-success col-md-8 btn-lg px-3">Восстановить пароль</button>
                    </div>

                    <div class="form-group col-md-8 m-auto mb-3">
                        <button
                                type="submit"
                                class="btn btn-success col-md-8 btn-lg px-2"
                                style="background-color: #dfe7e1 !important; color: rgb(14, 27, 11);"
                        >Есть аккаунт?
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Register page -->

@endsection
