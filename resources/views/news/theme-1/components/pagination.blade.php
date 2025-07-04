<div class="flex justify-center items-center space-x-2 mb-8">
    @if ($paginator->onFirstPage())
        <span class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full text-gray-500">
            <i class="ri-arrow-left-s-line"></i>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full text-gray-600 hover:border-primary hover:text-primary">
            <i class="ri-arrow-left-s-line"></i>
        </a>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="text-gray-500">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="page-link w-10 h-10 flex items-center justify-center border border-primary bg-primary text-white rounded-full">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-link w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full text-gray-600 hover:border-primary hover:text-primary">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full text-gray-600 hover:border-primary hover:text-primary">
            <i class="ri-arrow-right-s-line"></i>
        </a>
    @else
        <span class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full text-gray-500">
            <i class="ri-arrow-right-s-line"></i>
        </span>
    @endif
</div>
