<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
    <div class="lg:col-span-2">
        <a href="post/{{$mostViewedPost['slug'] }}.html" class="block group">
            <div class="overflow-hidden rounded-lg mb-3">
                <img
                    src="{{ $mostViewedPost->feture }}"
                    alt="{{  $mostViewedPost->title  }}"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300"
                />
            </div>
            <h2 class="text-2xl font-bold mb-2 group-hover:text-primary">
                {{ $mostViewedPost->title ?? 'nan' }}
            </h2>
            <p class="text-gray-700 mb-2">
                {{ $mostViewedPost->description ?? 'Không có mô tả' }}
            </p>
            <p class="text-gray-500 text-sm"> {{ \Carbon\Carbon::parse($mostViewedPost->created_at)->diffForHumans() }}</p>
        </a>
    </div>
    <div class="space-y-4">
        @foreach($otherPosts as $post)
            <a href="post/{{$post['slug'] }}.html" class="block group">
                <div class="flex">
                    <div class="w-1/3 mr-3">
                        <div class="overflow-hidden rounded">
                            <img
                                src="{{ $post->feture }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            />
                        </div>
                    </div>
                    <div class="w-2/3">
                        <h3 class="font-bold mb-1 group-hover:text-primary">
                            {{ $post->title }}
                        </h3>
                        <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($mostViewedPost->created_at)->diffForHumans() }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
