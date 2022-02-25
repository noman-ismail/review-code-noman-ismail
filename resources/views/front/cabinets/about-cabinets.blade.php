@if (!empty($about))
	@php
		$about = json_decode($about);
	@endphp
@endif
@include('front.layout.header')
	<link rel="stylesheet" href="{{ asset('assets/style/all.cabinet.css') }}"/>
    <style>
		@if ($panel == 'national')
	      .isLoading{
	        position: relative;
	        content:"";
	        min-height:100vh;
	        margin-bottom:80px;
	        height:100%;
	        width:100%;
	      }
	    @else
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
		@endif
		.isLoading>div{
			display: none;
		}
    </style>
    <!--Load different Section on scroll-->
    <script>
          window.addEventListener("load", (event) => {["sectionOne"].forEach(name =>{
              handleEachCategory(name);
            });
          }, false);

          function handleEachCategory(category) {
            let target = document.getElementById(category);
            let observer;
            let isVis;
            createObserver();

          function createObserver() {
		@if ($panel == 'national')
            let options = {
              root: null,
              rootMargin: '0px',
              threshold: 0.1
            }
		@elseif ($panel == 'province')
            let options = {
              root: null,
              rootMargin: '0px',
              threshold: 0.2
            }
		@elseif ($panel == 'cities')
            let options = {
              root: null,
              rootMargin: '0px',
              threshold: 0.10
            }
		@endif
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
						<li><span>{{ $check->name }}</span></li>
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
				        <div id="overview" class="cabinet-column active">
                            <div class="isLoading" id="sectionOne">
                                <div class="cabinet-child">
                                    <h3 class="rounded-top">Overview</h3>
									@php
										if(!empty($about)){
											$content = about_cabinet_short_codes($about->detail,$about,$check,$panel);
										}else{
											$content = "";
										}
									@endphp
									{!! $content !!}
                                </div>
                            </div>
						</div> <!-- overview end -->
                    </main>
                </div>
            </div>
        </div>
        <script>
			$('#sectionOne').find('ul').addClass('cabinet-custom');
			$('#sectionOne').find('blockquote').addClass('green-note');
			$('#sectionOne').find('cite').addClass('text-green');
        </script>

		@include('front.layout.footer')
		</div>
	</div>
</body>
</html>