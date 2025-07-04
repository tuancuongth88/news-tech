<header class="sticky-header">
    <div
        class="container mx-auto px-4 py-4 flex justify-between items-center"
    >
        <a href="{{route('home')}}" class="text-3xl font-['Pacifico'] text-primary">News Tech</a>
        <div class="relative">
            <input
                type="text"
                placeholder="Tìm kiếm tin tức..."
                class="search-input pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm w-64 focus:border-primary"
            />
            <div
                class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400"
            >
                <i class="ri-search-line"></i>
            </div>
        </div>
    </div>
    <!-- Main Navigation -->
    <nav class="bg-primary text-white">
        <div class="container mx-auto px-4">
            <ul class="flex flex-wrap">
                <li class="relative group">
                    <a href="{{route('home')}}" class="
                    {{ request()->is('/') ? "block px-4 py-3 font-medium bg-red-800 whitespace-nowrap"
                                            : "block px-4 py-3 font-medium hover:bg-red-800 whitespace-nowrap" }}
                    ">Trang chủ</a>
                </li>
                @php
                 @endphp
                @foreach($categories as $category)
                    <li class="relative group">

                        <a href="/{{ $category->slug }}" class="
                        {{
                            request()->segment(1) == $category->slug ? "block px-4 py-3 font-medium bg-red-800 whitespace-nowrap"
                                                                : "block px-4 py-3 font-medium hover:bg-red-800 whitespace-nowrap"}}">
                            {{ $category->name }}
                        </a>
                        @if($category->children->isNotEmpty())
                            <div class="absolute hidden group-hover:block bg-white shadow-lg z-10 min-w-[200px]">
                                @foreach($category->children as $child)
                                    <a href="{{ url($child->slug) }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
