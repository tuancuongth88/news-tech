<!-- Menu -->
<header class="clearfix">
	<nav id="main-menu" class="left navigation">
		<ul class="sf-menu no-bullet inline-list m0">
			<li><a href="">Trang Chủ</a></li>
			@foreach ($categories as $cate)
				<li>
					<a href="category/{{ $cate->slug }}">{{ $cate->name }}</a>
	    		</li>
			@endforeach
    		<li><a href="contact.html">Liên Hệ</a></li>
		</ul>
	</nav>

	<div class="search-bar right clearfix">
		<form action="{{route('search')}}" method="get">
			<input name="key" type="text" data-value="search" value="search">
			<input type="submit" value="">
		</form>
	</div>
</header>
