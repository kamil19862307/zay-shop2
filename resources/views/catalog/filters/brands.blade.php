<li class="pb-3">
    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
        {{ $filter->title() }}
        <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
    </a>
    <ul id="collapseThree" class="collapse list-unstyled pl-3">
        @foreach($filter->values() as $id => $label)
            <li>
                <input type="checkbox"
                       name="{{ $filter->name($id) }}"
                       value="{{ $id}}"
                       @checked($filter->requestValue($id))
                       id="{{ $filter->id($id) }}"
                >
                <label for="{{ $filter->id($id) }}">
                    <a class="text-decoration-none"
                       href="{{ route('catalog') }}?{{ $filter->name($id) }}={{ $id }}"
                    >
                        {{ $label }}
                    </a>
                </label>
            </li>
        @endforeach
    </ul>
</li>
