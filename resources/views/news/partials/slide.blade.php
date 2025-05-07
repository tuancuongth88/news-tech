<div class="flexslider mb25">
	<ul class="slides no-bullet inline-list m0">
        @foreach($posts as $post)
		<li>
     		<a href="post/{{ $post->slug }}.html">
                <img alt="{{ $post->feture }}" src="{{ $post->feture }}"> 
            </a>                    
     		<div class="flex-caption">
                <div class="desc">
                	<h1><a href="post/{{ $post->slug }}.html">{{ $post->title }}</a></h1>
                	<p>{{ $post->description }}</p>
                </div>
            </div>
		</li>
		@endforeach
	</ul>
</div>