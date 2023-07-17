@if ($paginator->hasPages())
    <style>
        main > nav {
            position: relative;
            bottom: .7em;
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            color: white;
            display: flex;
            justify-content: center;
            gap: 1em;
            -webkit-transform: translateX(-50%);
            -moz-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            -o-transform: translateX(-50%);
        }

        main > nav li,
        main > nav a {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #803ad0;
            width: 40px;
            height: 40px;
            border-radius: .2em;
            -webkit-border-radius: .2em;
            -moz-border-radius: .2em;
            -ms-border-radius: .2em;
            -o-border-radius: .2em;
            cursor: pointer;
        }

        main > nav li a {
            color: #551a8b;
        }

        main > nav li a i {
            color: white;
        }
    </style>
    <nav class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <i class='bx bx-chevron-left'></i>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <i class='bx bx-chevron-left'></i>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    <i class='bx bx-chevron-right' ></i>
                </a>
            </li>
        @else
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <i class='bx bx-chevron-right' ></i>
            </li>
        @endif
    </nav>
@endif
