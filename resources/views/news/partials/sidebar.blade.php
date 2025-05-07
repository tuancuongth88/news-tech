<aside id="sidebar" class="four column pull-right">
	<ul class="no-bullet">
		<li class="widget tabs-widget clearfix">
    		<ul class="tab-links no-bullet clearfix">
    			<li class="active"><a href="#popular-tab">Nổi Bật</a></li>
    			<li><a href="#recent-tab">Gần Đây</a></li>
    			<li><a href="#view-tab">Top View</a></li>
    		</ul>

    		<div id="popular-tab" class="shine">
    			<ul>
    				<?php $post_hot = $posts->where('hot',1)->take(4); ?>
    				@foreach($post_hot as $post)
    				<li class="shine-o">
    					@if($post->feture)
							<?php $image = $post->feture; ?>
						@else
							<?php $image = 'http://placehold.it/60x60'; ?>
						@endif
    					<a href="post/{{ $post->slug }}.html"><img alt="" src="{{$image}}"></a>
    					<h3><a href="post/{{ $post->slug }}.html">{{ $post->title }}</a></h3>
    					<div class="post-date">{{date('G:i d-m-Y', strtotime($post->created_at)) }}</div>
    				</li>
    				@endforeach
    			</ul>
    		</div>

    		<div id="recent-tab" class="shine">
    			<ul>
    				<?php $post_recent = $posts->where('post_type','text')->take(4); ?>
    				@foreach($post_recent as $post)
    				<li class="shine-o">
    					@if($post->feture)
							<?php $image = $post->feture ?>
						@else
							<?php $image = 'http://placehold.it/60x60'; ?>
						@endif
    					<a href="post/{{ $post->slug }}.html"><img alt="" src="{{$image}}"></a>
    					<h3><a href="post/{{ $post->slug }}.html">{{ $post->title }}</a></h3>
    					<div class="post-date">{{date('G:i d-m-Y', strtotime($post->created_at)) }}</div>
    				</li>
    				@endforeach
    			</ul>
    		</div>

   			<div id="view-tab" class="shine">
   				<ul>
   					<?php $post_recent = $posts->sortByDesc('view')->take(4); ?>
    				@foreach($post_recent as $post)
    				<li class="shine-o">
    					@if($post->feture)
							<?php $image = $post->feture; ?>
						@else
							<?php $image = 'http://placehold.it/60x60'; ?>
						@endif
    					<a href="post/{{ $post->slug }}.html"><img alt="" src="{{$image}}"></a>
    					<h3><a href="post/{{ $post->slug }}.html">{{ $post->title }}</a></h3>
    					<div class="post-view">{{$post->view}} views</div>
    				</li>
    				@endforeach
    			</ul>
    		</div>
		</li>
		<li class="widget subscribe-widget clearfix">
			<h3 class="widget-title">Subscribe via email</h3>
			<form>
				<input type="text" data-value="Enter your email address" value="Enter your email address">
				<input type="submit" value="Submit">
			</form>
		</li>
		<li class="widget widget_ads_big clearfix">
			<h3 class="widget-title">Quảng Cáo</h3>
			<div class="clearfix">
				<a href=""><img alt="" src="images/logo/qc.jpg"></a>
			</div>
		</li>
		<li class="widget widget_facebook_box clearfix">
			<h3 class="widget-title">Fanpage Facebook </h3>
			<iframe src="http://www.facebook.com/plugins/likebox.php?href=http://facebook.com/laravelvn	&amp;width=285&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;height=300" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
		</li>
		<li class="widget widget_video clearfix">
			<h3 class="widget-title">Video Nổi Bật</h3>
			<div class="flex-video widescreen">
				<?php $post_video = $posts->sortByDesc('created_at')->where('post_type','video')->take(1); ?>
				<video src="{{ @$post_video[0]->feture }}" alt="{{ @$post_video[0]->title}}" style="width: 100%" controls></video>
			</div>
		</li>
		<li class="widget widget_social_media clearfix">
			<h3 class="widget-title">Follow us</h3>
			<ul class="no-bullet">
				<li class="twitter">
					<div class="btn">
						<a href="https://twitter.com/nextWPthemes" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @nextWPthemes</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>
				</li>
				<li class="google_plus">
					<div class="btn">
						<!-- Place this tag where you want the +1 button to render. -->
						<div class="g-plusone" data-size="medium"></div>

						<!-- Place this tag after the last +1 button tag. -->
						<script type="text/javascript">
						  (function() {
							var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							po.src = 'https://apis.google.com/js/plusone.js';
							var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
						  })();
						</script>
					</div>
				</li>
				<li class="facebook">
					<div class="btn">
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));
						</script>

						<div class="fb-like" data-href="http://www.nextwpthemes.com/" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
					</div>
				</li>
				<li class="pinterest">
					<div class="btn">
						<a href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fthemeforest.net%2Fitem%2Fnext-magazine-responsive-magazine-template%2F2576082&amp;media=http%3A%2F%2F1.s3.envato.com%2Ffiles%2F29793891%2Fscreenshots%2F00_preview.__large_preview.jpg&amp;description=Next+Magazine+-+Responsive+Magazine+Template" class="pin-it-button" count-layout="horizontal"><img alt="Pin It" border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
					</div>
				</li>
			</ul>
		</li>
		<li class="widget widget_tag_cloud clearfix">
			<h3 class="widget-title">Tags</h3>
			<div class="tagcloud">
				@foreach($tags as $tag)
					<a href="tag/{{ $tag->slug }}" title="3 topics" style="font-size: 22pt;">{{ $tag->name }}</a>
				@endforeach
			</div>
		</li>
	</ul>
</aside>
