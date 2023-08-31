<div class="col-12 col-md-4 mb-4">
    <div class="card h-100">
        <a href="#">
            <img src="{{ $item->makeThumbnail('414x310') }}" class="card-img-top" alt="{{ $item->title }}">
        </a>
        <div class="card-body">
            <ul class="list-unstyled d-flex justify-content-between">
                <li>
                    <i class="text-warning fa fa-star"></i>
                    <i class="text-warning fa fa-star"></i>
                    <i class="text-warning fa fa-star"></i>
                    <i class="text-muted fa fa-star"></i>
                    <i class="text-muted fa fa-star"></i>
                </li>
                <li class="text-muted text-right">{{ $item->price }}</li>
            </ul>
            <a href="#" class="h2 text-decoration-none text-dark">{{ $item->title }}</a>
            <p class="card-text">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere, ut.
            </p>
            <p class="text-muted">Reviews (24)</p>
        </div>
    </div>
</div>
