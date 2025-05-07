<!doctype html>
<html lang="en">
@include('news.partials.head')
<body>
	<!-- Header -->
	@include('news.partials.header')
	<!-- End Header -->

	<!-- Container -->
	<section class="container row clearfix">
		<!-- Menu top -->
		@include('news.partials.menu')
		<!-- Inner Container -->
		<section class="inner-container clearfix">

			<!-- Content -->
			<section id="content" class="eight column row pull-left">
				<!-- Slider -->
				@include('news.partials.slide')
				<!-- End Slider -->

				@yield('content')
				
			</section>
			<!-- End Content -->

			<!-- Sidebar -->
			@include('news.partials.sidebar')
			<!-- End Sidebar -->

			<!-- Footer -->
			@include('news.partials.footer')
			<!-- End Footer -->

		</section>
		<!-- End Inner Container -->
	</section>
	<!-- End Container -->

	<!-- Import js -->
	@include('news.partials.importjs')
	@yield('js')
</body>
</html>