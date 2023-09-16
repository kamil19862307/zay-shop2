<div class="col-12 col-md-4 p-5 mt-3">
    <a href="{{ route('catalog', $item) }}"><img src="{{ $item->makeThumbnail('336x336') }}" class="rounded-circle img-fluid border"></a>
    <h5 class="text-center mt-3 mb-3">{{ $item->title }}</h5>
    <p class="text-center"><a class="btn btn-success">Go Shop</a></p>
</div>
