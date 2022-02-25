<aside class="col-lg-3 outer-column sidebar-column">
	<div class="inner-column">
		<h3 class="sidebar-top">Cabinet Info</h3>
		<ul class="cabinet-nav">
			<li>
				<a href="{{ url('/'.Request::segment(1).'/') }}" class="{{ (Request::segment('2') == '')?"active":"" }}">
					<i class="icon-pencil"></i>About Cabinet
				</a>
			</li>
			<li>
				<a href="{{ url('/'.Request::segment(1).'/team') }}" class="{{ (Request::segment('2') == 'team')?"active":"" }}"><i class="icon-users"></i> Cabinet Team</a>
			</li>
			<li>
				<a href="{{ url('/'.Request::segment(1).'/news-updates') }}" class="{{ (Request::segment('2') == 'news-updates')?"active":"" }}"><i class="icon-bullhorn"></i> News & Updates</a>
			</li>
			<li>
				<a href="{{ url('/'.Request::segment(1).'/events') }}" class="{{ (Request::segment('2') == 'events')?"active":"" }}"><i class="icon-calendar"></i> Events </a>
			</li>
			<li>
				<a href="{{ url('/'.Request::segment(1).'/jobs') }}" class="{{ (Request::segment('2') == 'jobs')?"active":"" }}"><i class="icon-briefcase"></i> Jobs</a>
			</li>
			<li>
				<a href="{{ url('/'.Request::segment(1).'/notifications') }}" class="{{ (Request::segment('2') == 'notifications')?"active":"" }}"><i class="icon-users"></i> Govt. Notifications</a>
			</li>
			<li>
				<a href="{{ url('/'.Request::segment(1).'/contact-us') }}" class="{{ (Request::segment('2') == 'contact-us')?"active":"" }}"><i class="icon-phone"></i> Contact Us</a>
			</li>
		</ul>
	</div>
</aside>
@php
$views = 0;
$seg1 = Request::segment(1);
refresh_views($views , 0 , 0, $seg1 );
@endphp