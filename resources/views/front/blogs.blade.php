@include('front.layout.header')
<link rel="stylesheet" href="{{asset('assets/style/all.blog.css') }}"></head>
<body>
	<div class="wrapper">
		@include('front.layout.top-menu')
		@include('front.layout.main-menu',['segment'=>'blog'])
		<header class="title-header main-header">
			<div class="container">
				<div class="header-text">
					<h1 class="header-title">Our Blog</h1>
					<ul class="breadcrumb">
						<li><a href="{{ route('base_url') }}">Home</a></li>
						<li><span>Our Blog</span></li>
					</ul>
				</div>
			</div>
		</header>
		<main class="main-content blog-section">
			<div class="container">
				<form class="row search-row">
					<div class="col-md-12">
						<i class="icon-search"></i>
						<input type="text" name="search" class="form-control" placeholder="Search Something" autocomplete="off">
						<button type="submit" class="btn btn-search">Search</button>
					</div>
				</form>
				<div class="row">
					@foreach ($data as $k => $v)
					@php
						$title = unslash( $v->title );
			            $short_title = ( strlen( $title ) > 40 ) ? substr( $title, 0, 60 ) . "...": $title;
			            $image = $v->cover;
			            $url = route('base_url')."/".$v->slug."-3".$v->id;
			            $cat = explode(",", $v->category);
			            $id = $v->id;
					@endphp	
					<div class="col-sm-6 col-md-6 col-lg-4 col-exl-3 outer-col">
						<div class="blog-column">
							<div class="blog-image">
								<a href="{{ $url }}">
									<img src="{{ get_post_mid($image) }}"  height="555" class="img-fluid" srcset="{{ get_post_mid($image) }} 400w,{{ get_post_mid($image) }} 992w,{{ get_post_mid($image) }} 1920w" sizes="100vw" alt="{{get_alt($image) }}">
									<div class="img-hvr"></div>
									 @php
					                  $date = date("d", strtotime($v->date) );
					                  $month = date("M", strtotime($v->date) );
					                @endphp
									<div class="blog-date">
										<span class="date">{{$date}}</span>
										<span class="month">{{$month}}</span>
									</div>
								</a>
							</div>
							<div class="blog-bottom">
								<ul class="blog-feat">
									<li><i class="icon-user"></i><a href="#">Admin</a></li>
									<li><i class="icon-price-tags"></i>
										@foreach ($cat as $k => $v )
										@php
											$name = get_catByname($v);
										@endphp
										<a href="{{get_catUrl($v) }}">{{ $name }}</a>
										@endforeach
										
									</li>
									<li><i class="icon-eye"></i><a href="#">{{ total_views(3 , $id ) }}</a></li>
								</ul>
								<h3>
								<a href="{{$url}}">{{$title}}</a>
								</h3>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</main>
		@if (get_postid('page_id'))
			@php
			$views = $cats['views'];
			refresh_views($views , get_postid('post_id') , get_postid('page_id'), get_postid('full'));
			@endphp
		@else
			@php
			$res = DB::table("meta")->select("views")->where("page_name" , "blogs")->first();
			$views = $res->views;
			refresh_views($views , 0 , 0 , "blogs" );
			@endphp
		@endif	
		@include('front.layout.footer')
	</div>
</body>
</html>