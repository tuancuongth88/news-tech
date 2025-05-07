<header class="clearfix">
	<!-- Top Menu -->
	<nav id="top-menu" class="clearfix">
		<ul class="no-bullet inline-list m0 pull-right">
			<li>
				@if(Auth::check())
					<a href="admin">Quản Trị</a>
				@else
					<a href="login">Login</a>
				@endif
			</li>
		</ul>
	</nav>
	<!-- End Top Menu -->

	<div class="inner-header clearfix">
		<div id="logo" class="left">
			<h1><a href=""><img alt="" src="images/logo/logo.png"></a></h1>
		</div>

		<div class="ads-728x90 right">
			<a href="#"><img alt="" src="images/logo/logo2.gif"></a>
		</div>
	</div>
</header>
