@if ($paginator->hasPages())
    
        <ul class="paging-container">
            @if ($paginator->onFirstPage())
                <li class="disabled"><span><i class="fas fa-chevron-left"></i> Previous</span></li>
            @else
                <li class="disabled"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i> Previous</a></li>
            @endif
        
            @foreach ($elements as $element)
            
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active my-active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="disabled"><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next <i class="fas fa-chevron-right"></i></a></li>
            @else
                <li class="disabled"><span>Next <i class="fas fa-chevron-right"></i></span></li>
            @endif
        </ul>
@endif 