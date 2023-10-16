<li class="pb-3">
    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
        {{ $filter->title() }}
        <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
    </a>
    <ul class="collapse show list-unstyled pl-3">
        <li>
            <input type="number"
                   name="{{ $filter->name('from') }}"
                   id="{{ $filter->id('from') }}"
                   value="{{ $filter->requestValue('from', 0) }}"
                   placeholder="От">
        </li>
        <li class="mt-2">
            <input type="number"
                   name="{{ $filter->name('to') }}"
                   id="{{ $filter->id('to') }}"
                   value="{{ $filter->requestValue('to', 1000000) }}"
                   placeholder="До">
        </li>
    </ul>
</li>
