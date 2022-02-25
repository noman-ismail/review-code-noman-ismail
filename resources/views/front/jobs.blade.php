@include('front.layout.header')
	<link rel="stylesheet" href="{{asset('assets/style/all.job.css') }}">
	<link rel="stylesheet" href="{{asset('assets/style/chosen.css') }}">
</head>
<body>
	<div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu',['segment'=>'jobs'])
		<header class="job-header">
			<div class="header-text">
				<h1 class="header-title">We Create Opportunities</h1>
				<form role="search" action="{{ route('jobs') }}" class="row search-form">
					<div class="col-lg-4 col-xl-3 dropdown-column">
                        <div class="choose-icon">
                            <i class="icon-library"></i>
                        </div>
					   <select name="city" class="form-control dropdown-city">
					   	@php
					   		$cities = DB::table("cities")->orderBy('id' , 'desc')->get();
					   	@endphp
					   		<option value="">Choose City</option>
					   		@foreach ($cities as $k => $v)
						   		<option value="{{$v->id}}">{{ $v->name }}</option>
					   		@endforeach
					   </select>
					</div>
					<div class="col-lg-4 col-xl-6 middle-column">
					   <input type="text"  name="search" class="form-control" placeholder="Job Title or Keyword">
					</div>
					<div class="col-lg-4 col-xl-3">
						<button type="submit" class="btn-search">Search</button>
					</div>
				</form>
			</div>
		</header>

		<main>
			<!-- Job Description -->
			@if (!request()->has("search"))
				@php
					$job = DB::table('meta')->where("page_name" , "jobs")->select("content")->first();
				@endphp
				@isset ($job->content)
				 <div class="job-desc">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								{!!  $job->content !!}
							</div>
						</div>
					</div>
				</div>   
			@endisset
			@else

              <script>
                   $(function() { 
					 $('html, body').animate({
					    scrollTop: $('#job-list').offset().top-100}, 100);
					}); 
              </script>
			{{-- <div class="job-video" id="job-video">
				<div class="container">
					<div class="video-text">
						<h3 class="main-head text-center">Watch Our Video</h3>
					</div>
					<div class="play-icon" id="btn-popup">
						<i class="fa fa-play"></i>
					</div>
				</div>
			</div> --}}
			@endif
			<div class="job-list" id="job-list">
				<div class="container">
					<h3 class="main-head text-center">Available Jobs in Pakistan</h3>
					<div class="row">
						<div class="col-md-12">
							@php
								$count = 0;
							@endphp
							@foreach ($data as $k => $v)
								@php
									$count++;
									 $url = route('base_url')."/".$v->slug."-1".$v->id;
								@endphp
								<div class="outer-col">
									<div class="job-item row">
										<div class="col-12 col-md-6 col-lg-6">
											@isset ($v->title)
											<h4 class="job-title"><a href="{{$url}}">{{ $v->title }}</a></h4>
											<p>{{ $v->organization}}</p>
											@endisset										
										</div>
										<div class="col-6 col-md-2 col-lg-2 column-city">
											<div class="upper">{{ get_dept_name($v->district , "district") }}</div>
											<p>{{ get_dept_name($v->province , "province") }}</p>
										</div>
										<div class="col-6 col-md-3 col-lg-2">
											<div class="upper">{{ date("d M Y", strtotime($v->due_date) ) }}</div>
											@isset ($v->published_by)
											 <p>{{ $v->published_by }}</p>   
											@endisset
											
										</div>
										<div class="col-12 col-md-3 col-lg-2">
											<a href="{{ $url }}" class="button">Visit Job</a>
										</div>
									</div>
								</div>
							@endforeach							
						</div>
						@if ($count <= 0)
							<div class="col-md-12 text-center">
								<p>There is no record found</p>
							</div>
						@endif
						<div class="col-md-12">
							{{ $data->links('front.layout.pagination') }}
						</div>
					</div>
				</div>
			</div>

			<!-- video popup -->
			<div class="popup" id="myPopup">	
				<div class="popup-content">
					<div class="closebar">
						<button class="btnClose" type="button"><i class="fa fa-times"></i></button>
					</div>	
					<span class="close">Close &times;</span>
				</div>
			</div>

		</main>
	</div>
	 @php
      $res = DB::table("meta")->select("views")->where("page_name" , "jobs")->first();
      $views = $res->views;
      refresh_views($views , 0 , 0 , "jobs" );
     @endphp
    @include('front.layout.footer')
    <script src="{{asset('assets/js/chosen.js') }}"></script> 
	<script>
		$(".dropdown-city,.dropdown-loc").chosen();
	</script>
	<script>
			var popup  =  document.getElementById("myPopup");
			var button =  document.getElementById("btn-popup");
			var span   =  document.getElementsByClassName("close")[0];
			var close  =  document.getElementsByClassName("btnClose")[0];
			if (button != null) {
				button.onclick = function(e){
					e.preventDefault();
					popup.style.display = "block";
					var iframe = document.createElement("iframe");
					iframe.classList.add("ifr-video");
					iframe.src = "//www.youtube.com/embed/7e90gBu4pas?autoplay=1";
					document.getElementsByClassName("popup-content")[0].appendChild(iframe);
				}
			}
			span.onclick = function(){
				popup.style.display = "none";
				var iframe = document.getElementsByClassName('ifr-video')[0];
				iframe.parentNode.removeChild(iframe);
			}

			close.onclick = function(){
				popup.style.display = "none";
				var iframe = document.getElementsByClassName('ifr-video')[0];
				iframe.parentNode.removeChild(iframe);
			}

			window.onclick = function(event){
				if (event.target == popup) {
					popup.style.display = "none";
					var iframe = document.getElementsByClassName('ifr-video')[0];
				    iframe.parentNode.removeChild(iframe);
			    }
			}
			// src="https://www.youtube.com/embed/TOYA0RopPts" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen
		</script>
</body>
</html>
