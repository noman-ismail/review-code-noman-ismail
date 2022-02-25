
@include('front.layout.header')
	<link rel="stylesheet" href="{{ asset('assets/style/all.cabinet.css') }}"/>
    <style>
      .isLoading{
        background-image:url("compress/loader.svg");
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
						<li><span>Cabinets</span></li>
					</ul>
				</div>
			</div>
		</header>
		@php
			$dd = (!empty($data->district_cabinet)) ? json_decode($data->district_cabinet) : "";
		@endphp
		<div class="main-content cabinet-content cabinet-section">
			<div class="container">
				<main class="row cabinet-main">
                  <div class="col-lg-8 col-xl-9">
                      <div id="overview" class="cabinet-column">
						<h3 class="rounded-top">APJEA Cabinets</h3>
						{!! (!empty($dd)) ? $dd->content : "" !!}

                        <div class="isLoading" id="sectionOne">
                           <div class="cabinet-child">
							<h3 class="cab-top">District Cabinets</h3>
							<div class="cabinet-toggle district-cabinet" id="cab-dist">
							  <form class="row">
							      <div class="col-md-8">
							          <div class="form-group">
							              <label>Choose District</label>
							              <select name="cities" class="ui-dropdown">
							              	<option value="">Choose an Option</option>
							              	@if (count($record) > 0)
							              		@foreach ($record as $element)
							              			<option value="{{ route('base_url')."/".$element->slug }}">{{ $element->name }}</option>
							              		@endforeach
							              	@endif
							              </select>
							          </div>
							      </div>
							      <div class="col-md-2">
							          <button class="btn btn-search" type="button">Go</button>
							      </div>
							  </form>
							</div>
							@if (count($record) > 0)
							<div class="row cabinet-toggle province-cabinet" id="cab-pro">
							  @foreach ($record as $value)
							    @php
							      $first_character = substr($value->name, 0,1);
							    @endphp
							    <div class="col-md-6 col-lg-6 col-xl-4">
							        <div class="cabinet-item">
							            <a class="outer" href="{{ route('base_url')."/".$value->slug }}">
							                <span class="cab-letter">{{ $first_character }}</span>
							            </a>
							            <a href="{{ route('base_url')."/".$value->slug }}">{{ $value->name }} Cabinet</a>
							        </div>
							    </div>
							  @endforeach
							</div>
							@endif
						   </div>
						</div>

                     </div> 
                  </div>
                  <!-- overview end -->
                    @include('front.sidebar.common')
                  <!-- <hr class="hr-green"/> -->
               </main>
			</div>
		</div>
		@include('front.layout.footer')
	</div>
	<script>
		$('form').on('submit',function(e){
			e.preventDefault();
	        var value = $('.ui-dropdown').val().trim();
	        if(value != ""){
	            window.location.href = value;
	        }
		})
	</script>
</body>
</html>