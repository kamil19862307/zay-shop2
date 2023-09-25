<ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
    @foreach($menu->all() as $item)
        <li class="nav-item">
            <a class="nav-link" @if($item->isActive()) style="color: #59AB6E" @endif href="{{ $item->link() }}">
                {{ $item->label() }}
            </a>
        </li>
    @endforeach
</ul>
