@extends('news.layout.single')
@section('content')
<!-- Posts -->
@if(isset($tag))
@section('title')
| Tag {{ $tag->name}}
@endsection
<h4 class="cat-title mb25">Bài viết theo thẻ {{ $tag->name}}</h4>
<section class="row">
	<!-- Category posts -->
	@foreach($tag->posts as $post)
	<article class="post six column">
		<div class="post-image zoom-out">
			@if($post->feture) 
				<?php $image = $post->feture ?>
			@else 
				<?php $image = 'http://placehold.it/300x220'; ?>
			@endif
			<figure><a href="post/{{$post->slug}}.html"><img src="{{$image}}" alt="" style="width: 300px;height: 220px;"></a></figure>
		</div>

		<div class="post-container">
			><a href="post/{{$post->slug}}.html"><h2 class="post-title">{{$post->title}}</h2></a>
			<div class="post-content">
				<p>{{$post->description}}</p>
			</div>
		</div>

		<div class="post-meta">
			<span class="author"><a href="author/{{$post->admin->name}}">{{$post->admin->name}}</a></span>
			<span class="date"><a href="#">{{date('G:i d-m-Y', strtotime($post->created_at)) }}</a></span>
		</div>
	</article>
	@endforeach
@else
	<section class="row">
	<h4 class="cat-title mb25">Bài viết theo thẻ {{ $key}}</h4>
	<article class="post ten column">
		<h3>Không có bài viết nào được tìm thấy.</h3>
	</article>
@section('title')
| Không tìm thấy
@endsection
@endif
	<!-- End Category posts -->
</section>
@endsection