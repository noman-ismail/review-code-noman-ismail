@include('front.layout.header')
		<link rel="stylesheet" href="{{ asset('assets/style/all.cabinet.css') }}"/>
    <style>
      .isLoading{
        background-image: url(http://apjea.unifyp.com/compress/loader.svg);
	    background-position: center;
	    background-repeat: no-repeat;
	    position: relative;
	    content: "";
	    min-height: 60vh;
	    margin-bottom: 80px;
	    height: 100%;
	    width: 100%;
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
							<li><span>News & Updates</span></li>
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
								<h3 class="rounded-top">Latest News</h3>
								<div class="row">
									<div class="col-lg-12 cabinet-inner cabinet-news">
										@if (count($record) > 0)
											<div class="isLoading" id="section4">
											@foreach ($record as $key => $value)
												@php
													$title = unslash( $value->title );
				                  $short_title = ( strlen( $title ) > 40 ) ? substr( $title, 0, 60 ) . "...": $title;
				                  $content = trim(trim_words( html_entity_decode($value->content), 12 ));
				                  $content = clean_short_code(html_entity_decode($content));
				                  if($value->category == "green"){
				                    $class = "dash-success";
				                    $color = "bg-grdgreen";
				                    $icon  =  "<i class='icon-check_circle_outline'></i>";
				                  }elseif($value->category == "orange"){
				                    $class = "dash-warn";
				                    $color = "bg-grdorange";
				                    $icon  =  "<i class='icon-info'></i>";
				                  }elseif($value->category == "blue"){
				                    $class = "dash-info";
				                    $color = "bg-info";
				                    $icon  =  "<i class='icon-info'></i>";
				                  }elseif($value->category == "red"){
				                    $class = "dash-error";
				                    $color = "bg-grdred";
				                    $icon  =  "<i class='icon-cancel-circle'></i>";
				                  }else{
				                    $class = "";
				                    $color = "";
				                    $icon = "";
				                  }
												@endphp
													<div class="dash-box {{ $class }}">
														<div class="dash-flex">
															<div class="dash-icon {{ $color }}">
																{!! $icon !!}
															</div>
															<div class="dash-date">
																@if (!empty($value->date))
																	@php
																		$date = date('d' , strtotime($value->date));
																		$month = date('M' , strtotime($value->date));
																	@endphp
							                    <h4 style="">{{ $date }} <span>{{ $month }}</span></h4>
																@endif
															</div>
															<div class="dash-detail">
						                    <h3><a href="{{ route('base_url')."/".$value->slug."-5".$value->id }}">{{ $short_title }}</a></h3>
						                    <p>{{ $content }}</p>
															</div>
														</div>
													</div>
											@endforeach
											</div>
										@endif
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