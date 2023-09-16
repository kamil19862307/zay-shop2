@extends('layouts.app')

@section('title', $category->title ?? 'Каталог')

@section('content')
<!-- Start Content -->
<div class="container py-5">
    <div class="row">

        <div class="col-lg-3">
            <form action="{{ route('catalog', $category) }}">
            <h1 class="h2 pb-4">Фильтры</h1>
            <ul class="list-unstyled templatemo-accordion">
                <li class="pb-3">
                    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                        Цена
                        <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul class="collapse show list-unstyled pl-3">
                        <li>
                            <input type="number"
                                   name="filters[price][from]"
                                   value="{{ request('filters.price.from', 0) }}"
                                   placeholder="От">
                        </li>
                        <li class="mt-2">
                            <input type="number"
                                   name="filters[price][to]"
                                   value="{{ request('filters.price.to', 100000) }}"
                                   placeholder="До">
                        </li>
                    </ul>
                </li>
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
                        Бренд
                        <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul id="collapseThree" class="collapse list-unstyled pl-3">
                        @foreach($brands as $brand)
                            <li>
                                <input type="checkbox"
                                    name="filters[brands][{{ $brand->id }}]"
                                    value="{{ $brand->id }}"
                                    @checked(request('filters.brands.' . $brand->id))
                                    id="filters-brands-{{ $brand->id }}"
                                >
                                <label for="filters-brands-{{ $brand->id }}">
                                    <a class="text-decoration-none"
                                       href="{{ route('catalog') }}?filters[brands][{{ $brand->id }}]={{ $brand->id }}">
                                        {{ $brand->title }}
                                    </a>
                                </label>
                            </li>
                        @endforeach
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
                            <a class="h3 text-dark text-decoration-none mr-3" href="#">All</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none mr-3" href="#">Men's</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none" href="#">Women's</a>
                        </li>
                    </ul>
                </div>
                <div x-data="{}" class="col-md-6 pb-4">
                    <form x-ref="sortForm" action="{{ route('catalog', $category) }}">
                        <div class="d-flex">
                            <select name="sort"
                                    x-on:change="$refs.sortForm.submit()"
                                    class="form-control"
                            >
                                <option value="">Сортировать по умолчанию</option>
                                <option @selected(request('sort') === 'price') value="price">Сначала недорогие</option>
                                <option @selected(request('sort') === '-price') value="-price">Сначала дорогие</option>
                                <option @selected(request('sort') === 'title') value="title">По алфавиту</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @each('catalog.shared.product-catalog', $products, 'item')
            </div>
            <div div="row">
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
