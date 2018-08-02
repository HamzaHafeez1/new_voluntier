@if ($paginator->hasPages())
        <ul class="pagination flex-wrap justify-content-center">


            @if($paginator->currentPage() > 3)
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            @endif
            @if($paginator->currentPage() > 4)
                <li class="page-item disabled">
                    <span class="page-link">&hellip;</span>
                </li>
            @endif
            @foreach(range(1, $paginator->lastPage()) as $i)
                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" href="#">{{ $i }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach
            @if($paginator->currentPage() < $paginator->lastPage() - 3)
                <li class="page-item disabled">
                    <span class="page-link">&hellip;</span>
                </li>
            @endif
            @if($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item"><a class="page-link"
                                         href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                </li>
            @endif

        </ul>
@endif
