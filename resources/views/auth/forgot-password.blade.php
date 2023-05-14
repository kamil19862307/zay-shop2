@extends('layouts.auth')

@section('title')
{{__('Забыл пароль')}}
@endsection

@section('content')

<!-- Start forgot page -->
<div class="container-fluid bg-light py-5">
    <div class="col-md-6 m-auto text-center">
        <h1 class="h1">Забыл пароль</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row py-5">
        <form class="col-md-8 m-auto" method="POST" role="form" action="{{ route('password.email') }}">
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
                        type="email"
                        class="form-control mt-1"
                        id="email" name="email"
                        placeholder="E-mail"
                        value="{{ old('email') }}"
                        style="line-height: 2.5;"
                    >
                </div>

                <x-forms.primary-button>
                    Изменить пароль
                </x-forms.primary-button>

                <div class="form-group col-md-8 m-auto mb-3">
                    <button
                        type="button"
                        class="btn btn-success col-md-8 btn-lg px-2"
                        style="background-color: #dfe7e1 !important; color: rgb(14, 27, 11);"
                    >Вспомнил пароль
                    </button>
                </div>
                <div class="form-group col-md-8 m-auto mb-3">
                        <a href="#"><button
                                type="button"
                                class="btn btn-success col-md-8 btn-lg px-2"
                                style="background-color: #dfe7e1 !important; color: rgb(14, 27, 11);"
                            >Регистрация
                            </button>
                        </a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End forgot page -->

@endsection
