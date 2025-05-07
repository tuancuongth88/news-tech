@extends('news.layout.single')

@section('content')
<section class="row">
	<article class="post column">
	<h1 class="post-title">Get in touch with us</h1>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ultrices elementum odio, ac fermentum justo sodales vel. Suspendisse potenti. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam scelerisque, massa quis pulvinar accumsan, leo sem iaculis enim, feugiat elementum erat lacus id eros. Nam at nunc metus, sit amet lobortis sem. Etiam ut mauris quis magna condimentum porttitor. Duis sit amet erat porttitor erat dictum molestie quis sit amet mi. Nullam risus massa, euismod id venenatis ut, tempus et eros.</p>
	<!-- Map -->
	<div id="map" class="row flex-video widescreen"></div>
	<!-- End Map -->
</article>
</section>
@endsection
@section('js')
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="js/gmap3.min.js"></script>
@endsection