<div class="bg-red-50 border-l-4 border-primary p-3 mb-6 flex items-center">
    <div class="w-auto h-6 flex items-center justify-center mr-3 bg-primary text-white px-3 rounded-button whitespace-nowrap">
        <span class="font-bold text-sm">Tin nóng</span>
    </div>
    <div class="overflow-hidden">
        <div class="animate-marquee whitespace-nowrap">
            @foreach($posts as $post)
            <span class="text-sm mr-8">
                <a href="post/{{ $post->slug }}.html">{{ $post->title }}</a>
            </span>
            @endforeach

        </div>
    </div>
</div>
