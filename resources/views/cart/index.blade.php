@extends('layouts.app')

@section('title', $category->title ?? 'Корзина')

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
{{--            <form class="col-md-9 m-auto" method="post" role="form">--}}

                @foreach($items as $item)
                    <div class="row">
                        <div class="form-group col-md-1 mb-3">
                            <form method="post" action="{{ route('cart.delete', $item) }}">
                                @csrf
                                @method('DELETE')
                                <label for="inputname">Delete</label>
                                <button type="submit" class="btn btn-success btn-sm mt-2">
                                    Удалить
                                </button>
                            </form>
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            <label for="inputname">Title</label>
                            <h4><a href="{{ route('product', $item->product->slug) }}" class="">
                                {{ $item->product->title }}
                            </a></h4>
                        </div>
                        <div class="form-group col-md-2 mb-3">
                            <label for="inputemail">Price</label>
                            <input type="text"
                                   name="price"
                                   class="form-control mt-1"
                                   id="price"
                                   value="{{ $item->price }}">
                        </div>

                        <div class="form-group col-md-1 mb-3">
                            <form action="{{ route('cart.quantity', $item) }}" method="post">
                                @csrf
                                <label for="inputemail">Quantity</label>
                                <input type="text"
                                       name="quantity"
                                       class="form-control mt-1"
                                       id="quantity"
                                       value="{{ $item->quantity }}">
                            </form>
                        </div>

                        <div class="form-group col-md-2 mb-3">
                            <label for="inputemail">Amount</label>
                            <input type="text"
                                   name="amount"
                                   class="form-control mt-1"
                                   id="amount"
                                   value="{{ $item->amount }}">
                        </div>
                        <div class="form-group col-md-2 mb-3">
                            <label for="inputemail">Характеристики</label>

                            @if($item->optionValues->isNotEmpty())
                                <ul class="list-group">
                                    @foreach($item->optionValues as $value)
                                        <li list-group-item>{{ $value->option->title }}: {{ $value->title }}</li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </div>
                @endforeach

                <div class="row d-flex justify-content-end">
                    <div class="form-group col-md-3 mb-3">
                        <input type="text"
                               class="form-control mt-1"
                               id="total"
                               name="total"
                               value="{{ cart()->amount() }}">
                    </div>
                    <div class="col-md-3 mb-3 d-flex justify-content-end">
                        <a href="{{ route('catalog') }}">
                            <button type="button" class="btn btn-success btn-lg px-3">Back to shopping</button>
                        </a>
                    </div>
                    <div class="col-md-2 mb-3 d-flex justify-content-end">
                        <form action="{{ route('cart.truncate') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-success btn-lg px-3">Очистить корзину</button>
                        </form>
                    </div>
                    <div class="col-md-2 mb-3 d-flex justify-content-end">
                        <a href="{{ route('order') }}">
                            <button type="button" class="btn btn-success btn-lg px-3">Buy</button>
                        </a>
                    </div>
                </div>

        </div>
    </div>
@endif
<!-- End Cart -->

<!-- End Content -->


@endsection
