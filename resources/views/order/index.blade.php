@extends('layouts.app')

{{--@section('title', $seo->title ?? 'Оформление заказа')--}}

@section('content')

<!-- Start Content -->

<!-- Start Cart -->
@if($items->isEmpty())
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Корзина пуста</h1>
            <a href="{{ route('catalog') }}">
                <button type="button" class="btn btn-success btn-lg px-3">Back to shopping</button>
            </a>
        </div>
    </div>

@else
    <div class="container py-5">
        <div class="row py-5">
            <form action="{{ route('order.handle') }}" method="POST">
                @csrf
                <div class="row">

{{--                Контактная информация--}}
                    <div class="form-group col-md-4 mb-3 border">
                        <h3>Контактная информация</h3>
                        <input type="text"
                               name="customer[first_name]"
                               class="form-control mt-1"
                               id="customer[first_name]"
                               value="{{ old('customer.first_name') }}"
                               placeholder="Имя"
                        >

                        @error('customer.first_name')
                            {{ $message }}
                        @enderror

                        <input type="text"
                               name="customer[last_name]"
                               class="form-control mt-1"
                               id="customer[last_name]"
                               value="{{ old('customer.last_name') }}"
                               placeholder="Фамилия"
                        >

                        @error('customer.last_name')
                            {{ $message }}
                        @enderror

                        <input type="text"
                               name="customer[email]"
                               class="form-control mt-1"
                               id="customer[email]"
                               value="{{ old('customer.email') }}"
                               placeholder="Email"
                        >

                        @error('customer.email')
                            {{ $message }}
                        @enderror

                        <input type="text"
                               name="customer[phone]"
                               class="form-control mt-1"
                               id="customer[phone]"
                               value="{{ old('customer.phone') }}"
                               placeholder="Телефон"
                        >

                        @error('customer.phone')
                            {{ $message }}
                        @enderror

                        <input type="checkbox"
                               name="create_account"
                               id="checkout-create-account"
                               value="1"
                        />
                        <label for="checkout-create-account">Зарегистрироваться</label>

                        <input type="password"
                               name="password"
                               class="form-control mt-1"
                               placeholder="Пароль"
                        >

                        @error('password')
                            {{ $message }}
                        @enderror

                        <input type="password"
                               name="password_confirmation"
                               class="form-control mt-1"
                               placeholder="Повторите пароль"
                        >

                        @error('password_confirmation')
                            {{ $message }}
                        @enderror
                    </div>

    {{--                Способ доставки--}}
                    <div class="form-group col-md-4 mb-3 border">
                        <h3>Способ доставки</h3>
                        @foreach($deliveries as $delivery)
                            <input type="radio"
                                   name="delivery_type_id"
                                   id="delivery-method-address-{{ $delivery->id }}"
                                   value="{{ $delivery->id }}"
                                   @checked($loop->first || old('delivery_id') === $delivery->id)
                            />
                            <label for="delivery-method-address-{{ $delivery->id }}" class="form-radio-label">
                                {{ $delivery->title }}
                            </label>

                            @if($delivery->with_address)
                                <input type="text"
                                       name="customer[city]"
                                       class="form-control mt-1"
                                       value="{{ old('customer.city') }}"
                                       placeholder="Город"
                                >
                                @error('customer.city')
                                    {{ $message }}
                                @enderror

                                <input type="text"
                                       name="customer[address]"
                                       class="form-control mt-1"
                                       value="{{ old('customer.address') }}"
                                       placeholder="Адрес"
                                >
                                @error('customer.address')
                                    {{ $message }}
                                @enderror
                            @endif
                        @endforeach

                        @foreach($payments as $payment)
                            <input type="radio"
                                   name="payment_method_id"
                                   id="payment-method-{{ $payment->id }}"
                                   value="{{ $payment->id }}"
                                @checked($loop->first || old('payment_method_id') === $payment->id)
                            />
                            <label for="payment-method-address-{{ $payment->id }}" class="form-radio-label">
                                {{ $payment->title }}
                            </label>
                        @endforeach
                    </div>

    {{--                Заказ--}}
                    <div class="form-group col-md-4 mb-3 border">
                        <h3>Заказ</h3>
                        <table class="table">
                            <thead>
                                <th scope="col">Товар</th>
                                <th scope="col">К-во</th>
                                <th scope="col">Сумма</th>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td scope="row">
                                            <h4>
                                                <a href="{{ route('product', $item->product) }}">
                                                    {{ $item->product->title }}
                                                </a>
                                            </h4>
                                            @if($item->optionValues->isNotEmpty())
                                                <ul>
                                                    @foreach($item->optionValues as $value)
                                                        <li>{{ $value->option->title }}: {{ $value->title }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td scope="row">{{ $item->quantity }} шт.</td>
                                        <td scope="row">{{ $item->amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            Всего: {{ cart()->amount() }}
                        </div>
                        <div>
                            Итого: {{ cart()->amount() }}
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success btn-md px-3">Оформить заказ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
<!-- End Cart -->

<!-- End Content -->


@endsection
