@include('front.layout.header')
		<link rel="stylesheet" href="{{ asset('assets/style/all.cabinet.css') }}"/>
		<style>
			.isLoading{
				background-image:url("{{ asset('compress/loader.svg') }}");
				background-position: center;
				background-repeat: no-repeat;
				position: relative;
				content:"";
				min-height:60vh;
				margin-bottom:80px;
				height:100%;
				width:100%;
			}
			.isLoading>div{
				display: none;
			}
		</style>
		<!--Load different Section on scroll-->
    @php
    	$countarray = count($record);
    	$nameArray = array();
    	for ($i = 0; $i < $countarray ; $i++){
    		$nameArray[] = 'section'.$i;
    	}
    @endphp
    @if (!empty($nameArray))
			<script>
				window.addEventListener("load", (event) => { @json($nameArray).forEach(name =>{
					handleEachCategory(name);
					});
				}, false);

				function handleEachCategory(category) {
					let target = document.getElementById(category);
					let observer;
					let isVis;
					createObserver();

					function createObserver() {
							let options = {
								root: null,
								rootMargin: '0px',
								threshold: 0.2
							}
							observer = new IntersectionObserver(handleIntersect, options);
							observer.observe(target);
						}  

					function handleIntersect(entries, observer) {
						entries.forEach(entry => {
							if (entry.isIntersecting) {
								entry.target.classList.remove('isLoading');
								entry.target.childNodes[1].display = "block";
							}
						});
					}
				}
			</script>
		@endif
	</head>
	<body>
		<div class="wrapper">
			@include('front.layout.top-menu')
			@include('front.layout.main-menu',['segment'=>'cabinet'])
			<header class="title-header contact-header">
				<div class="container">
					<div class="header-text">
						<h1 class="header-title">Cabinets</h1>
						<ul class="breadcrumb">
							<li><a href="{{ route('base_url') }}">Home</a></li>
							@if ($panel === "national")
								<li><a href="{{ route('base_url')."/pakistan" }}">{{ $check->name }}</a></li>
							@else
								<li><a href="{{ route('base_url').'/'.$check->slug }}">{{ $check->name }}</a></li>
							@endif
							<li><span>Events</span></li>
						</ul>
					</div>
				</div>
			</header>
			<div class="main-content cabinet-content">
				<div class="container">
					<div class="row">
						@if($panel == 'national')
							@include('front.cabinets.national-sidebar')
						@elseif($panel == "cities")
							@include('front.cabinets.district-sidebar')
						@elseif($panel == 'province')
							@include('front.cabinets.province-sidebar')
						@endif
		        <main class="col-lg-9 cabinet-main">
		          <div id="cab-event" class="team-section cabinet-column">
		            <div class="event-section">
		              <h3 class="rounded-top">Events</h3>
		              <div class="row recent-row">
		              	@if (count($record) > 0)
		              		@php
		              			$i = 0;
		              		@endphp
		              		@foreach ($record as $key => $element)
		              			@php
		              				$social_links = (!empty($element->social_links))?json_decode($element->social_links):array();
		              				$classs = ($key >= 6) ? "hide-column" : "outer-column isLoading";
		              			@endphp
		              			@if ($key >= 6)
		              				@if ($i == 0)
						                <div class="col-md-12 column-button">
						                  <div class="button-bottom mx-auto">
						                    <button class="btn-load" type="button">Load More</button>
						                  </div>
						                </div>
						                @php
						                	$i++;
						                @endphp
		              				@endif
	              				@endif
				                <div class="col-md-6 col-lg-6 {{ $classs }}" id="section{{ $key }}">
				                  <div class="event-column">
				                    <a class="event-image" href="{{ route('base_url')."/".slugify($element->slug)."-2".$element->id }}">
											<img src="{{ is_image($element->cover_image )}}" class="img-fluid" alt="{{ get_alt($element->cover_image) }}" width="100%" height="">
				                      <div class="event-overlay"></div>
												@if (!empty($element->date))
					                      <div class="event-date">
											@php
												$data = date('d' , strtotime($element->date));
												$month = date('M' , strtotime($element->date));
											@endphp
					                        <span class="date">{{ $data }}</span>
					                        <span class="month">{{ $month }}</span>
					                      </div>
										   @endif
				                      @if (!empty($social_links))
					                      <ul class="social-list">
					                      	@if ($social_links->fb_link)
						                        <li><a href="{{ $social_links->fb_link }}" rel="nofollow noopener" target="_blank"><i class="icon-facebook"></i></a></li>
					                      	@endif
					                      	@if ($social_links->twitter_link)
						                        <li><a href="{{ $social_links->twitter_link }}" rel="nofollow noopener" target="_blank"><i class="icon-twitter"></i></a></li>
					                      	@endif
					                      	@if ($social_links->linkedin_link)
						                        <li><a href="{{ $social_links->linkedin_link }}" rel="nofollow noopener" target="_blank"><i class="icon-linkedin2"></i></a></li>
					                      	@endif
					                      	@if ($social_links->instagram_link)
						                        <li><a href="{{ $social_links->instagram_link }}" rel="nofollow noopener" target="_blank"><i class="icon-instagram"></i></a></li>
					                      	@endif
					                      </ul>
				                      @endif
				                    </a>
				                    <div class="event-bottom">
				                      <p>{{ $element->address }}</p>
				                      <h4><a href="{{ route('base_url')."/".slugify($element->slug)."-2".$element->id }}">{{ $element->title }}</a></h4>
				                    </div>
				                  </div>
				                </div>
		              		@endforeach
		              	@endif
		              </div>
		            </div>
		          </div>
		          <!-- <hr class="hr-green"/> -->
		        </main>
		      </div>
		    </div>
		  </div>
			@include('front.layout.footer')
		</div>
	  <script>
		  $(".hide-column").hide();
		  $(".btn-load").click(function(){
			  $(".btn-load").text("");
			  $(".btn-load").css({"background":"white url(compress/loader.gif) no-repeat center","background-size":"contain","padding":"20px 10px"});
			  setTimeout(function(){
				  showEvents();
			  },1000);
		  });
		  function showEvents(){
			  $(".hide-column").fadeIn("slow");
			  $(".btn-load").closest(".column-button").remove();
		  }
	  </script>
	</body>
</html>