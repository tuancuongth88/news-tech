@extends('news.theme-1.layout.layout')

@section('content')
    <!-- Tin Mới -->
    @include('news.theme-1.partials.tin-nong')
    <!-- Tin Nổi bật -->
    @include('news.theme-1.partials.tin-noi-bat')

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-3/4">
            <!-- Thời sự Section -->
            @foreach($cates as $cate)
                <section class="mb-10 news-category">
                    <div class="flex justify-between items-center mb-4">
                        <h2
                            class="text-xl font-bold inline-block news-category-title pb-2 text-primary"
                        >
                            {{ $cate->name }}
                        </h2>
                        <a href="{{ $cate->slug }}" class="text-sm text-gray-500 hover:text-primary">Xem thêm</a>
                    </div>
                    @php
                        $posts = $cate->posts->where('status',1)->sortByDesc('created_at')->take(4);
                        $post_1 = $posts->shift();
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($post_1)
                        <div>
                            <a href="post/{{$post_1['slug'] }}.html" class="block group">
                                <div class="overflow-hidden rounded-lg mb-3">
                                    <img
                                        src="{{ $post_1->feture }}"
                                        alt="Cuộc họp chính phủ"
                                        class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300"
                                    />
                                </div>
                                <h3 class="text-xl font-bold mb-2 group-hover:text-primary">
                                    {{ $post_1->title }}
                                </h3>
                                <p class="text-gray-700">
                                    {{ $post_1->description }}
                                </p>
                            </a>
                        </div>
                    @endif
                        <div class="space-y-4">
                            @foreach( $posts->all() as $post)
                            <a href="post/{{$post['slug'] }}.html" class="block group">
                                <div class="flex">
                                    <div class="w-1/3 mr-3">
                                        <div class="overflow-hidden rounded">
                                            @if($post->feture)
                                                    <?php $image = $post->feture; ?>
                                            @else
                                                    <?php $image = 'http://placehold.it/50x50'; ?>
                                            @endif
                                            <img
                                                src="{{ $image }}"
                                                alt="{{ $post->title }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                            />
                                        </div>
                                    </div>
                                    <div class="w-2/3">
                                        <h3 class="font-bold mb-1 group-hover:text-primary">
                                            {{ $post->title }}
                                        </h3>
                                        <p class="text-gray-700 text-sm">
                                            {{ $post->description }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
        <!-- Sidebar -->
        @include('news.theme-1.partials.sidebar')
    </div>
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
