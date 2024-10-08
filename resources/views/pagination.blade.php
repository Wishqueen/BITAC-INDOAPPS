<!-- resources/views/vendor/pagination/custom-pagination.blade.php -->
<nav aria-label="Page navigation example">
    <ul class="pagination">
      <!-- Previous Page Link -->
      @if ($paginator->onFirstPage())
        <li class="page-item disabled">
          <span class="page-link" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </span>
        </li>
      @else
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
      @endif
  
      <!-- Pagination Elements -->
      @foreach ($elements as $element)
        <!-- "Three Dots" Separator -->
        @if (is_string($element))
          <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
        @endif
  
        <!-- Array Of Links -->
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <li class="page-item active" aria-current="page">
                <span class="page-link">{{ $page }}</span>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
              </li>
            @endif
          @endforeach
        @endif
      @endforeach
  
      <!-- Next Page Link -->
      @if ($paginator->hasMorePages())
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      @else
        <li class="page-item disabled">
          <span class="page-link" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </span>
        </li>
      @endif
    </ul>
  </nav>
  