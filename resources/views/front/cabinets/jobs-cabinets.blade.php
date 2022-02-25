@include('front.layout.header')
		<link rel="stylesheet" href="{{ asset('assets/style/all.cabinet.css') }}"/>
    <style>
      .isLoading{
        background-image:url("{{ asset('compress/loader.svg') }}");
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        content:"";
        min-height:60px;
        max-height: auto;
        margin-bottom:80px;
        width:100%;
      }
      .isLoading>div{
        display: none;
      }
    </style>
    <!--Load different Section on scroll-->
    @if (count($record) > 0)
    	<script>
          window.addEventListener("load", (event) => { ['section4'].forEach(name =>{
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
							<li><span>Jobs</span></li>
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
							<div id="cab-news" class="cabinet-column">
								<h3 class="rounded-top">Latest Jobs</h3>
								<div class="row">
									<div class="col-lg-12 cabinet-inner cabinet-news">
									</div>
								</div>
		            <div class="job-list">
		              <div class="container">
		                <div class="row">
		                  <div class="col-md-12">
												@if (count($record) > 0)
													<div class="isLaoding" id="section4">
													@foreach ($record as $key => $value)
				              			@php
				              				$classs = ($key >= 6) ? "hide-column" : "outer-column";
				              			@endphp
				                    <div class="{{ $classs }}">
				                      <div class="job-item row">
				                        <div class="col-md-6 col-lg-6 col-xl-8">
				                          <h4 class="job-title">
				                          	<a href="{{ route('base_url')."/".$value->slug."-1".$value->id }}">{{ $value->title }}</a>
				                          </h4>
				                          <p>{{ $value->organization }}</p>
				                        </div>
				                        <div class="col-md-3 col-lg-3 col-xl-2">
				                          <div class="upper"> {{ date('d M, Y' ,strtotime($value->due_date)) }}</div>
				                          <p>The News</p>
				                        </div>
				                        <div class="col-md-3 col-lg-3 col-xl-2">
				                          <a href="{{ route('base_url')."/".$value->slug."-1".$value->id }}" class="button">Visit Job</a>
				                        </div>
				                      </div>
				                    </div>
													@endforeach
													</div>
												@endif
		                  </div>
		                  @if (count($record) > 6)
			                  <div class="col-md-12 column-button">
			                    <div class="button-bottom mx-auto">
			                      <button class="btn-load" type="button">Load More</button>
			                    </div>
			                  </div>
		                  @endif
		                </div>
		              </div>
		            </div>
							</div>
						</main>
		      </div>
		    </div>
		  </div>
			@include('front.layout.footer')
		</div>
	</body>
</html>