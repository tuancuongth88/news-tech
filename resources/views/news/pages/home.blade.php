@extends('news.layout.layout')

@section('content')
<section class="row">
	<!-- Category posts -->
	@foreach($cates as $cate)
		<article class="six column">
			<h4 class="cat-title"><a href="category/{{ $cate->slug }}">{{ $cate->name }} ( {{ $cate->posts->where('status',1)->count() }} )</a></h4>
			<?php 
				$posts = $cate->posts->where('status',1)->sortByDesc('created_at')->take(4);
				$post_1 = $posts->shift();
			?>
			{{-- Neu co 1 bai viet --}}
			@if($post_1)
				<div class="post-image zoom-out">
					@if($post_1->feture) 
						<?php $image = $post_1->feture;?>
					@else 
						<?php $image = 'http://placehold.it/300x220'; ?>
					@endif
					<figure><a href="post/{{$post_1->slug}}.html"><img src="{{ $image }}" alt="" style="width:300px;height:220px"></a>
					</figure>
				</div>
				<div class="post-container">
					<a href="post/{{$post_1->slug}}.html"><h2 class="post-title">{{ $post_1->title }}</h2></a>
					<div class="post-content">
						<p>{{ $post_1->description }}</p>
					</div>
				</div>
				<div class="post-meta">
					<span class="view"><a href="post/{{$post_1->slug}}.html">{{ $post_1->view }} views</a></span>
					<span class="author"><a href="author/{{ $post_1->admin->name }}">{{ $post_1->admin->name }}</a></span>
					<span class="date"><a href="#">{{date('G:i d-m-Y', strtotime($post_1->created_at)) }}</a></span>
				</div>
			@endif
				@foreach( $posts->all() as $post)
				<div class="other-posts speia">
					<ul class="no-bullet ">
						<li class="opac">
							@if($post->feture)
								<?php $image = $post->feture; ?>
							@else
								<?php $image = 'http://placehold.it/50x50'; ?>
							@endif
							<a href="#"><img src="{{$image}}" alt="image" style="width:50px;height:50px"></a>
							<h3 class="post-title"><a href="post/{{$post['slug'] }}.html">{{$post['title'] }}</a></h3>
							<span class="date"><a href="#">{{date('G:i d-m-Y', strtotime($post['created_at'])) }}</a></span>
						</li>
					</ul>
				</div>
				@endforeach
		</article>
	@endforeach
</section>
<!-- End Carousel Posts -->
<!-- Gallery Posts -->
<div class="clearfix mb25 oh">
	<a href="category/video"><h4 class="cat-title">Video Nổi Bật</h4></a>
	<!-- jCarousel -->
	<div class="carousel-container">
		<div class="carousel-navigation">
			<a class="carousel-prev"></a>
			<a class="carousel-next"></a>
		</div>
		<div class="carousel-item-holder gallery row" data-index="0">
			@foreach( $videos as $video)
			<div class="four column carousel-item">
				<div class="video">
				  <a href="{{$video->feture}}" title="{{$video->title}}">
				  	<video src="{{$video->feture}}" style="width: 100%"></video>
				  </a>       
				</div>
			</div>
			@endforeach
		</div>
	</div>
	<!-- End jCarousel -->
</div>
<!-- End Gallery Posts -->
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
