@extends('layouts.auth')

@section('title')
{{__('Зарегистрироваться')}}
@endsection

@section('content')

<!-- Start login page -->
<div class="container-fluid bg-light py-5">
    <div class="col-md-6 m-auto text-center">
        <h1 class="h1">Зарегистрироваться</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row py-5">
        <form class="col-md-8 m-auto" method="POST" role="form" action="{{ route('store') }}">
            @csrf

            @if ($errors->any())
            <div class="alert alert-danger row m-auto text-center">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="row m-auto  text-center">
                <div class="form-group col-md-8 m-auto mb-3 ">
                    <input
                        name="name"
                        id="name"
                        type="text"
                        class="form-control mt-1"
                        placeholder="Имя"
                        value="{{ old('name') }}"
                        style="line-height: 2.5;"
                    >
                </div>
                <div class="form-group col-md-8 m-auto mb-3 ">
                    <input
                        name="email"
                        id="email"
                        type="email"
                        class="form-control mt-1"
                        placeholder="E-mail"
                        value="{{ old('email') }}"
                        style="line-height: 2.5;"
                    >
                </div>
                <div class="form-group col-md-8 m-auto mb-3">
                    <input
                        type="password"
                        class="form-control mt-1"
                        id="password"
                        name="password"
                        placeholder="Пароль"
                        style="line-height: 2.5;"
                    >
                </div>

                <div class="form-group col-md-8 m-auto mb-3">
                    <input
                        type="password"
                        class="form-control mt-1"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Пароль ещё раз"
                        style="line-height: 2.5;"
                    >
                </div>

                <x-forms.primary-button>
                    Создать аккаунт
                </x-forms.primary-button>

                <div class="form-group col-md-8 m-auto mb-3">
                    <a href="{{ route('login') }}"><button
                        type="button"
                        class="btn btn-success col-md-8 btn-lg px-2"
                        style="background-color: #dfe7e1 !important; color: rgb(14, 27, 11);"
                    >Вспомнил пароль
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End login page -->

@endsection
