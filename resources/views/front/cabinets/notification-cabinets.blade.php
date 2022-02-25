@include('front.layout.header')
	<link rel="stylesheet" href="{{ asset('assets/style/all.cabinet.css') }}"/>
	<link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
	<script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
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
							@php
								$__segment2 = Request::segment(2);
							@endphp
							<li><a href="{{ route('base_url') }}">Home</a></li>
							@if ($panel === "national")
								<li><a href="{{ route('base_url')."/pakistan" }}">{{ $check->name }}</a></li>
							@else
								<li><a href="{{ route('base_url').'/'.$check->slug }}">{{ $check->name }}</a></li>
							@endif
							<li><span>Govt. Notifications</span></li>
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
				          <div id="cab-notif" class="cabinet-column">
				            <h3 class="rounded-top">Govt .Notifications</h3>
				            <form class="row search-row">
				              <div class="col-md-12">
				                <div class="input-group">
				                  <div class="flex-control">
				                    <i class="icon-search"></i>
				                    <input type="text" class="form-control" placeholder="Search Something" name="search" value="{{ request('search') }}">
				                  </div>
				                  <div class="flex-control">
									<input type="text" name="date_from" class="form-control" placeholder="Date From" value="{{ request('date_from') }}" id="date-from" autocomplete="off">
				                  </div>
				                  <div class="flex-control">
									<input type="text" name="date_to" class="form-control" placeholder="Date To" value="{{ request('date_to') }}" id="date-to" autocomplete="off">
				                    <button type="submit" class="btn btn-search">Search</button>
				                  </div>
				                </div>
				              </div>
				            </form>
				            <div class="row download-section">
				              <div class="col-md-12">
				              	@if (count($record) > 0)
				              		@foreach ($record as $key => $element)
					                <div class="isLoading" id="section{{ $key }}">
					                  <div class="outer-col">
					                    <div class="item-list row">
					                      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-8">
					                        <div class="d-flex">
					                          <div class="item-image">
					                          	@php
					                          		if(!empty($element->mannual_image)){
					                          			$pdf_img_path = get_post_thumbnail($element->mannual_image);
					                          		}else{
							                            if(!empty($element->pdf_img)){
							                              if(file_exists('downloads/'.$element->pdf_img)){
							                                $pdf_img_path = asset('downloads/'.$element->pdf_img);
							                              }else{
							                                $pdf_img_path = asset('images/default-img.png');
							                              }
							                            }else{
							                              $pdf_img_path = asset('images/default-img.png');
							                            }
					                          		}
					                          	@endphp
					                            <a href="{{ route('download')."?file=".$element->file }}" target="_blank" class="btn-download">
					                            	{{-- @if ($element->mannual_image) --}}
						                              <img src="{{ $pdf_img_path }}" class="img-fluid" alt="item-image">
					                            	{{-- @endif --}}
					                            </a>
					                          </div>
					                          <div class="item-col">
					                            <h4><a href="{{ route('download')."?file=".$element->file }}" target="_blank" class="btn-download">{{ $element->title }}</a></h4>
					                            @php
					                            	$decs = ( strlen( $element->description ) > 100 ) ? substr( $element->description, 0, 150 ) . "...": $element->description
					                            @endphp
					                            <p>{{ $decs }}</p>
					                          </div>
					                        </div>
					                      </div>
					                      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
					                        <div class="d-flex align-items-center justify-content-between">
					                        	@if (!empty($element->date))
						                          <div class="item-col margin-md-col text-center">
						                            <h4>Date</h4>
						                            <p>{{ date('d M, Y', strtotime($element->date) ) }}</p>
						                          </div>
					                        	@endif
					                          <div class="item-col">
					                          	<a href="{{ route('download')."?file=".$element->file }}" target="_blank" class="btn-download btn-dwnld">Download</a>
					                          </div>
					                        </div>
					                      </div>
					                    </div>
					                  </div>
					                </div>
				              		@endforeach
				              	@else
				              		<div class="text-center">
				              			<p>There is no record</p>
				              		</div>
				              		{{-- expr --}}
				              	@endif
				              </div>
				            </div>
				          </div>
				        </main>
					</div>
				</div>
			</div>
			@include('front.layout.footer')
			<script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
			<script>
				$('#date-to').samask("00/00/0000");
				$('#date-from').samask("00/00/0000");
				$("input[name='date_to']").datepicker({
				  format:'dd/mm/yyyy',
				  autoHide:true,
				});
				$("input[name='date_from']").datepicker({
				  format:'dd/mm/yyyy',
				  autoHide:true,
				});
				$('#date-to , #date-from').change(function(e){
					var new_val = $(this).val();
					var new_val = new_val.replace(/(\d{2})(\d{2})(\d{4})/, "$1/$2/$3");
					$(this).val(new_val);
				});
			</script>
		</div>
	</body>
</html>