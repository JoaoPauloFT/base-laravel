{{-- Navbar notification --}}

<li class="nav-item dropdown" id="{{ $id }}">

    {{-- Link --}}
    <a @if($enableDropdownMode) href="" @endif class="nav-link" data-toggle="dropdown">

        {{-- Icon --}}
        <i class="{{ $icon }}"></i>
        <span>{{ __('message.' . Lang::locale()) }}</span>

    </a>

    {{-- Dropdown Menu --}}
    @if($enableDropdownMode)

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-language">

            @foreach($languages as $key => $language)
                <a href="{{ route('user.change_language', $key) }}" class="item-language">
                    <img src="{{ asset('images/'.$key.'.png') }}">
                    <span>{{ $language }}</span>
                </a>
            @endforeach

        </div>

    @endif

</li>
