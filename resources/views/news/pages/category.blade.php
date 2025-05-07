@extends('news.layout.single')

@section('content')
<!-- Posts -->
<?php
?>
@if(!isset($key))
<h4 class="cat-title mb25">{{ $cate}}</h4>
@section('title')
| {{ $cate}}
@endsection
<section class="row">
	<!-- Category posts -->
	@foreach($posts as $post)
	<article class="post six column">
		@if($post->post_type=='video')
			<div class="post-image zoom-out">
				<a href="post/{{$post->slug}}.html"><video src="{{ $post->feture}}" alt="" style="width: 100%"></video></a>
			</div>
		@else
			<div class="post-image zoom-out">
				@if($post->feture) 
					<?php $image = $post->feture; ?>
				@else 
					<?php $image = 'http://placehold.it/300x220'; ?>
				@endif
				<figure><a href="post/{{$post->slug}}.html"><img src="{{$image}}" alt="" style="width: 300px;height: 220px;"></a></figure>
			</div>
		@endif
		@if($post->post_type=='text')
			<div class="post-container">
				<a href="post/{{$post->slug}}.html"><h2 class="post-title">{{$post->title}}</h2></a>
				<div class="post-content">
					<p>{{$post->description}}</p>
				</div>
			</div>
		@else
			<a href="post/{{$post->slug}}.html"><h2 class="post-title">{{$post->title}}</h2></a>
		@endif

		<div class="post-meta">
			<span class="view"><a href="">{{$post->view}} views</a></span>
			<span class="author"><a href="author/{{$post->admin->name}}">{{$post->admin->name}}</a></span>
			<span class="date"><a href="#">{{date('G:i d-m-Y', strtotime($post->created_at)) }}</a></span>
		</div>
	</article>
	@endforeach
	{!! $posts->render() !!}
	<!-- End Category posts -->
</section>
@else
<section class="row">
	<h4 class="cat-title mb25">Chuyên Mục {{ $key}}</h4>
	<article class="post ten column">
		<h3>Không có bài viết nào được tìm thấy.</h3>
	</article>
</section>
@section('title')
| Không có bài viết
@endsection
@endif
@endsection