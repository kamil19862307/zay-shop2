@extends('layouts.app')

{{--@section('title', $category->title ?? 'Каталог')--}}

@section('content')
<!-- Start Content -->
<div class="container py-5">
    <div class="row">

        <div class="col-lg-3">
            <form action="{{ route('catalog', $category) }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <h1 class="h2 pb-4">Фильтры</h1>
                <ul class="list-unstyled templatemo-accordion">

                    {{-- Filters --}}
                    @foreach(filters() as $filter)
                        {!! $filter !!}
                    @endforeach

                    <li class="pb-3">
                        <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                            Пол
                            <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>
                        <ul class="collapse show list-unstyled pl-3">
                            <li><a class="text-decoration-none" href="#">Men</a></li>
                            <li><a class="text-decoration-none" href="#">Women</a></li>
                        </ul>
                    </li>
                    <li class="pb-3">
                        <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                            Цвет
                            <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>
                        <ul id="collapseTwo" class="collapse list-unstyled pl-3">
                            <li><a class="text-decoration-none" href="#">Белый</a></li>
                            <li><a class="text-decoration-none" href="#">Черный</a></li>
                            <li><a class="text-decoration-none" href="#">Крассный</a></li>
                            <li><a class="text-decoration-none" href="#">Зеленый</a></li>
                            <li><a class="text-decoration-none" href="#">Желтый</a></li>
                            <li><a class="text-decoration-none" href="#">Синий</a></li>
                        </ul>
                    </li>
                    <li class="pb-3">
                        <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                            Категории
                            <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>
                        <ul id="collapseThree" class="collapse list-unstyled pl-3">
                            @each('catalog.shared.category-catalog', $categories, 'item')
                        </ul>
                    </li>
                </ul>
                    <button type="submit" class="btn btn-success btn-lg">
                        Применить
                    </button>
                    @if(request('filters') || request('sort'))
                        <a href="{{ route('catalog') }}">
                            <button type="button" class="btn btn-success btn-lg">
                                Сбросить
                            </button>
                        </a>
                    @endif
            </form>
        </div>

        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-inline shop-top-menu pb-3 pt-1">
                        <li class="list-inline-item">
                            <a href="{{ filter_url($category, ['view' => 'grid']) }}"
                               class="@if(is_catalog_view('grid')) h2 @else h3 @endif text-dark text-decoration-none" >
                                <i class="fa fa-th" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ filter_url($category, ['view' => 'list']) }}"
                               class="@if(is_catalog_view('list')) h2 @else h3 @endif text-dark text-decoration-none" >
                                <i class="fa fa-list" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div x-data="{sort:'{{ filter_url($category, ['sort' => request('sort')]) }}'}" class="col-md-6 pb-4">
                        <div class="d-flex">
                            <select name="sort"
                                    x-model="sort"
                                    x-on:change="window.location = sort"
                                    class="form-control"
                            >
                                <option value="{{ filter_url($category, ['sort' => '']) }}">Сортировка по умолчанию</option>
                                <option value="{{ filter_url($category, ['sort' => 'price']) }}">Сначала недорогие</option>
                                <option value="{{ filter_url($category, ['sort' => '-price']) }}">Сначала дорогие</option>
                                <option value="{{ filter_url($category, ['sort' => 'title']) }}">По наименованию</option>
                            </select>
                        </div>
                </div>
            </div>
            <div class="row">
                @each('product.shared.product-catalog' . (is_catalog_view('list') ? '-list' : ''), $products, 'item')
            </div>
            <div class="row">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</div>
<!-- End Content -->

<!-- Start Brands -->
<section class="bg-light py-5">
    <div class="container my-4">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Our Brands</h1>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    Lorem ipsum dolor sit amet.
                </p>
            </div>
            <div class="col-lg-9 m-auto tempaltemo-carousel">
                <div class="row d-flex flex-row">
                    <!--Controls-->
                    <div class="col-1 align-self-center">
                        <a class="h1" href="#multi-item-example" role="button" data-bs-slide="prev">
                            <i class="text-light fas fa-chevron-left"></i>
                        </a>
                    </div>
                    <!--End Controls-->

                    <!--Carousel Wrapper-->
                    <div class="col">
                        <div class="carousel slide carousel-multi-item pt-2 pt-md-0" id="multi-item-example" data-bs-ride="carousel">
                            <!--Slides-->
                            <div class="carousel-inner product-links-wap" role="listbox">

                                <!--First slide-->
                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_01.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_02.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_03.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_04.png" alt="Brand Logo"></a>
                                        </div>
                                    </div>
                                </div>
                                <!--End First slide-->

                                <!--Second slide-->
                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_01.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_02.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_03.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_04.png" alt="Brand Logo"></a>
                                        </div>
                                    </div>
                                </div>
                                <!--End Second slide-->

                                <!--Third slide-->
                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_01.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_02.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_03.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="../../storage/app/public/img/brand_04.png" alt="Brand Logo"></a>
                                        </div>
                                    </div>
                                </div>
                                <!--End Third slide-->

                            </div>
                            <!--End Slides-->
                        </div>
                    </div>
                    <!--End Carousel Wrapper-->

                    <!--Controls-->
                    <div class="col-1 align-self-center">
                        <a class="h1" href="#multi-item-example" role="button" data-bs-slide="next">
                            <i class="text-light fas fa-chevron-right"></i>
                        </a>
                    </div>
                    <!--End Controls-->
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Brands-->


@endsection
