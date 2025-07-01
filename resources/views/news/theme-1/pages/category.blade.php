@extends('news.theme-1.layout.layout')

@section('content')
    <!-- Breadcrumb -->
    <div class="flex items-center text-sm text-gray-500 mb-4">
        <a href="#" class="hover:text-primary">Trang chủ</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">{{ $cate->name }}</span>
        @if(@$sub_cate)
            <span class="mx-2">/</span>
            <span class="text-gray-700 font-medium">{{ $sub_cate->name }}</span>
        @endif
    </div>
    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $cate->name }}</h1>
    </div>
    <!-- Filter Bar -->
    <div class="bg-white shadow-sm rounded-lg p-4 mb-8">
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex space-x-4 mb-2 md:mb-0">
                <a href="/{{$cate->slug}}" class="py-2 {{ request()->segment(1) == $cate->slug && !request()->segment(2) ? 'filter-active' : '' }}">Tất cả</a>
                @foreach($listCategory as $category)
                    <a href="/{{ $category->slug }}"
                       class="{{ request()->path() === $category->slug ? 'py-2 filter-active' : 'py-2 text-gray-600 hover:text-primary' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
            <div class="flex items-center">
                <span class="text-sm text-gray-500 mr-2">Sắp xếp:</span>
                <select class="border border-gray-300 rounded text-sm py-1 px-2 pr-8 focus:outline-none focus:border-primary">
                    <option>Mới nhất</option>
                    <option>Xem nhiều nhất</option>
                </select>
            </div>
        </div>
    </div>
    <!-- Featured News -->
    @php
        $listHotFirst = $listHot->first();
        $listHot = $listHot->take(4);
    @endphp
    @if($listHotFirst)
        <div class="bg-white shadow-sm rounded-lg p-6 mb-8">
            <h2 class="text-xl font-bold mb-6">Tin nổi bật</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <a href="/post/{{$listHotFirst['slug'] }}.html" class="block group">
                        <div class="overflow-hidden rounded-lg mb-3">
                            <img
                                src="{{ $listHotFirst['feture'] }}"
                                alt="{{ $listHotFirst['title'] }}"
                                class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300"
                            />
                        </div>
                        <span class="inline-block bg-red-100 text-primary text-xs px-2 py-1 rounded mb-2">{{ $listHotFirst->category->name }}</span>
                        <h2 class="text-2xl font-bold mb-2 group-hover:text-primary">
                            {{ $listHotFirst->title }}
                        </h2>
                        <p class="text-gray-700 mb-2">
                            {{ $listHotFirst->description }}
                        </p>
                        <p class="text-gray-500 text-sm"> {{ \Carbon\Carbon::parse($listHotFirst->created_at)->format('Y-m-d H:i') }}</p>
                    </a>
                </div>
                <div class="space-y-4">
                    @foreach($listHot as $post)
                        <a href="/post/{{$post['slug'] }}.html" class="block group">
                            <div class="flex">
                                <div class="w-1/3 mr-3">
                                    <div class="overflow-hidden rounded">
                                        <img
                                            src="{{ $post->feture }}"
                                            alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                                    </div>
                                </div>
                                <div class="w-2/3">
                                    <span class="inline-block bg-red-100 text-primary text-xs px-2 py-1 rounded mb-1">
                                        {{ $post->category->name }}
                                    </span>
                                    <h3 class="font-bold mb-1 group-hover:text-primary">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($listHotFirst->created_at)->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <!-- News List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        @foreach($posts as $post)
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <a href="/post/{{$post['slug'] }}.html" class="block group">
                    <div class="overflow-hidden h-48">
                        <img src="{{ $post->feture }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                    </div>
                    <div class="p-4">
                        <span class="inline-block bg-red-100 text-primary text-xs px-2 py-1 rounded mb-2">{{ $post->category->name }}</span>
                        <h3 class="text-xl font-bold mb-2 group-hover:text-primary">
                            {{ $post->title }}
                        </h3>
                        <p class="text-gray-700 mb-3">
                            {{ $post->description }}
                        </p>
                        <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($post->created_at)->format('Y/m/d H:i') }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <!-- Pagination -->
    {!! $posts->render() !!}
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $('.video a').fancybox({
                helpers: {  title : { type : 'over' } },
                type: 'iframe'
            });
        });
    </script>
@endsection
