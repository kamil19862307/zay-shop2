<div class="card col-md-12 mb-4">
    <div class="product-wap rounded-0 row no-gutters">
        <div class="card rounded-0 col-md-4">
            <img class="card-img rounded-0 img-fluid" src="{{ $item->makeThumbnail('302x402') }}">
            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                <ul class="list-unstyled">
                    <li><a class="btn btn-success text-white" href="{{ route('product', $item) }}"><i class="far fa-heart"></i></a></li>
                    <li><a class="btn btn-success text-white mt-2" href="{{ route('product', $item) }}"><i class="far fa-eye"></i></a></li>
                    <li><a class="btn btn-success text-white mt-2" href="{{ route('product', $item) }}"><i class="fas fa-cart-plus"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-body col-md-8">
            <a href="{{ route('product', $item) }}" class="h3 text-decoration-none">{{ $item->title }}</a>
            <ul class="w-100 list-unstyled justify-content-between mb-0">
                <li><b>Вес: </b> 160г</li>
                <li><b>Размер: </b> 160г</li>
                <li><b>Тип сенсора: </b> 160г</li>
                <li><b>Подсветка: </b> 160г</li>

            </ul>
            <ul class="list-unstyled d-flex justify-content-lg-start mb-1">
                <li>
                    <i class="text-warning fa fa-star"></i>
                    <i class="text-warning fa fa-star"></i>
                    <i class="text-warning fa fa-star"></i>
                    <i class="text-muted fa fa-star"></i>
                    <i class="text-muted fa fa-star"></i>
                </li>
            </ul>
            <p class="text-center mb-0">{{ $item->price }}</p>
        </div>
    </div>
</div>
