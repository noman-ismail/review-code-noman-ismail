@php
	$link = $res->video_url;
	$type_youtube = strpos($link, "youtube");
	if($type_youtube){
		$isv = strpos($link , "?v=");
		if($isv){
			$link = getID_youtube($link);
		}else{
			$link = explode("/", $link);
			$link =  end($link);
		}
		$link = ['id'=>$link,'type'=>'youtube'];
	}else{
		$type_fb = strpos($link, "fb.");
		$type_fb2 = strpos($link, "facebook");
		if(!empty($type_fb2)){
			$isv = strpos($link , "?v=");
			if($isv){
				$link = getID_facebook($link);
				// dd($link);
			}else{
				$link = explode("/", $link);
				$link =  end($link);
			}
			$link = ['id'=>$link,'type'=>'facebook'];
		}elseif(!empty($type_fb)){
			$link_ = explode("/", $link);
			if($link_[count($link_)-1] == ""){
				$link = $link_[count($link_) - 2] ;
			}else{
				$link = end($link_);
			}
			$link = ['id'=>$link,'type'=>'fb'];
		}else{
			$link = array();
		}
	}
@endphp
<script>
	var ___link = @json($link);
</script>
@include('front.layout.header')
	<link rel="stylesheet" href="{{asset('assets/style/all.event.css') }}">
</head>
<body>
	<div class="wrapper">
		@include('front.layout.top-menu')
		@include('front.layout.main-menu',['segment'=>'events'])
		<header class="title-header main-header">
			<div class="container">
				<div class="header-text">
					<h1 class="header-title">Events Detail</h1>
					<ul class="breadcrumb">
						<li><a href="{{ route('base_url') }}">Home</a></li>
						<li><a href="{{ route('base_url') }}/events">Events</a></li>
						<li><span>{{ $res->title }}</span></li>
					</ul>
				</div>
			</div>
		</header>

		<main class="main-content">
			<!-- Event Intro -->
			@php
				$tx = isset($res->text_sec1 )? json_decode($res->text_sec1 , true) : array();
				$ts_details1 = (isset($tx["ts_details1"])) ? $tx["ts_details1"]: "";
			@endphp
			<div class="container event-intro">
				<div class="row bg-silver align-items-center" id="event-intro">
					<div class="col-md-12 col-lg-5 event-col">
						<figure class="main-figure">
							<img src="{{ is_image($tx["ts_img1"]) }}" alt="Event Image">
						</figure>
					</div>
					<div class="col-md-12 col-lg-7 event-col">
						{!! $ts_details1  !!}
					</div>
				</div>

				<div class="row detail-bottom" id="event-detail">
					<div class="col-lg-6 first-column">
						@if (!empty($res->address))
						<div class="detail-item row">
							<div class="contact-icon col-2">
								<i class="icon-location"></i>
							</div>
							<div class="contact-detail col-10">
								<h3>Location</h3>
								<p>{{ $res->address }}</p>
							</div>
						</div>
						@endif
						@if (!empty($res->time))
						<div class="detail-item row">
							<div class="contact-icon col-2">
								<i class="icon-calendar"></i>
							</div>
							<div class="contact-detail col-10">
								<h3>Event Schedule</h3>
								<p>{{ $res->time }}</p>
							</div>
						</div>
						@endif
						@if (!empty($res->chief_guest))
						<div class="detail-item row">
							<div class="contact-icon col-2">
							<i class="icon-user"></i>
							</div>
							<div class="contact-detail col-10">
								<h3>Chief Guest</h3>
								<p>{{ $res->chief_guest }}</p>
							</div>
						</div>
						@endif
					</div>
					<div class="col-lg-6 second-column">
						@php
							$mt = preg_match('/src="([^"]+)"/', $res->google_map, $match);
						@endphp
						@if ($mt)
						<iframe id="map-iframe" src="" width="100%" height="380" frameborder="0"
						style="background:transparent url('compress/loader.gif') no-repeat center center"></iframe>
						@endif
					</div>
				</div>
			</div>

			<div class="container-fluid event-video" id="event-video">
				<h3 class="main-head">Event Video</h3>
				<div class="container event-intro">
					<div class="row">
						<div class="col-md-12 col-lg-12 event-col">
							<figure class="main-figure">
								<img src="{{ is_image($res->cover_image) }}" alt="about-img">
								<div class="play-icon" id="btn-popup">
									<i class="icon-youtube"></i>
								</div>
							</figure>
						</div>
					</div>
				</div>
			</div>
		@php
          $guest   = ($res->guest  !="" )? json_decode($res->guest , true) : array();
        @endphp
        	@if (count($guest) > 0)
			<div class="container-fluid event-first event-section">
				<div class="container guest-container">
					<h3 class="main-head">Honourable Guest</h3>
					<div class="owl-carousel guest-slider event-slider">
						@foreach ($guest as $k => $v)
						@php
							$name = (isset($v["name"])) ? "<p>".$v["name"]."</p>": "";
							$img = (isset($v["img"])) ? "<img src='".$v["img"]."' alt='".$v['name']."'>": "";
							$designation = (isset($v["designation"])) ? "<h4>".$v["designation"]."</h4>": "";
							$details = (isset($v["details"])) ? $v["details"]: "";
						@endphp	
							<div class="item">
							<div class="event-column">
								<div class="event-image">
										<img src="{{ get_post_mid($v['img']) }}" class="img-fluid" alt="event-member">
									<div class="event-overlay"></div>
									<ul class="team-nav">
										 @isset ($v["fb_url"])
						                     <li><a href="{{$v["fb_url"]}}" rel="nofollow noopener" target="_blank"><i class="icon-facebook"></i></a> </li> 
						                  @endisset
						                  @isset ($v["twitter_url"])
						                     <li><a href="{{ $v["twitter_url"] }}" rel="nofollow noopener" target="_blank"><i class="icon-twitter"></i></a> </li> 
						                  @endisset
						                  @isset ($v["instagram_url"])
						                      <li><a href="{{ $v["instagram_url"] }}" rel="nofollow noopener" target="_blank"><i class="icon-linkedin2"></i></a> </li>
						                  @endisset
						                  @isset ($v["linkedin_url"])
						                      <li><a href="{{ $v["linkedin_url"] }}" rel="nofollow noopener" target="_blank"><i class="icon-instagram"></i></a> </li>
						                  @endisset
									</ul>
								</div>
								<div class="event-bottom">
									{!! $designation !!}
									{!! $name !!}
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			@endif
			@php
			$gallery   = ($res->gallery_image  !="" )? json_decode($res->gallery_image , true) : array();
			@endphp
			@if (count($gallery) > 0)
			<div class="container gallery-container">
				<div class="gallery-section">
					<h3 class="main-head">Event Gallery</h3>
					<div class="row gallery-row">
					  <div class="gallery-column">
					  	@foreach ($gallery as $k => $v)
					  		<img src="{{ is_image($v) }}" class="img-fluid" onclick="openModal();currentSlide({{$k+1}})" 
					    class="hover-shadow">
					  	@endforeach					    
					  </div>
					</div>
					<!-- The Modal/Lightbox -->
					<div id="myModal" class="modal">
					  <div class="modal-content">
						<span class="close-modal cursor" onclick="closeModal()">&times;</span>
						@foreach ($gallery as $k => $v)
							<div class="mySlides">
						      <div class="numbertext">{{$k +1}} / {{ count($gallery) }}</div>
						      <img src="{{$v}}" alt="event Image">
						    </div>
						@endforeach
						<!-- Next/previous controls -->
						    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
						    <a class="next" onclick="plusSlides(1)">&#10095;</a>
					    <!-- Caption text -->
					    <div class="caption-container">
					      <p id="caption"></p>
					    </div>
					  </div>
					</div>
				</div>
			</div>
			@endif
			<!-- Most Popular Events -->
			<div class="related-section event-section">
				<div class="container-fluid event-container">
					<h3 class="main-head">Related Events</h3>
					<div class="container">
						<div class="owl-carousel event-slider">
						  @foreach ($data as $k => $v)
				          @php
				            $title = unslash( $v->title );
				            $short_title = ( strlen( $title ) > 40 ) ? substr( $title, 0, 60 ) . "...": $title;
				            $image = $v->cover_image;
				            $url = route('base_url')."/".$v->slug."-2".$v->id;
				          @endphp
							<div class="item">
								<div class="event-column">
					              <a class="event-image" href="{{ $url }}">
					                <img src="{{ is_image($image) }}" class="img-fluid" alt="{{ $title }}">
					                <div class="event-overlay"></div>
					                @if ($v->date)
					                @php
					                  $date = date("d", strtotime($v->date) );
					                  $month = date("M", strtotime($v->date) );
					                @endphp
					                <div class="event-date"> <span class="date">{{ $date }}</span> <span class="month">{{ $month }}</span> </div>
					                @endif
					                </a>
					                @php
					                  $lk   = ($v->social_links  !="" )? json_decode($v->social_links , true) : array();
					                @endphp

					                <ul class="social-list">
					                  @isset ($lk["fb_link"])
					                     <li><a href="{{$lk["fb_link"]}}"><i class="icon-facebook"></i></a> </li> 
					                  @endisset
					                  @isset ($lk["twitter_link"])
					                     <li><a href="{{ $lk["twitter_link"] }}"><i class="icon-twitter"></i></a> </li> 
					                  @endisset
					                  @isset ($lk["instagram_link"])
					                      <li><a href="{{ $lk["instagram_link"] }}"><i class="icon-linkedin2"></i></a> </li>
					                  @endisset
					                  @isset ($lk["linkedin_link"])
					                      <li><a href="{{ $lk["linkedin_link"] }}"><i class="icon-instagram"></i></a> </li>
					                  @endisset
					                </ul>
					              
					              <div class="event-bottom">
					              	@isset ($v->address)
					              	 <p>{{ $v->address }}</p>    
					              	@endisset
					                <h4><a href="{{ $url }}">{{ $title }}</a></h4>
					              </div>
					            </div>
							</div>
						  @endforeach
						</div>
					</div>
				</div>
			</div>	
			<!-- video popup -->
			<div class="popup" id="myPopup">	
				<div class="popup-content">
					<div class="closebar">
						<button class="btnClose" type="button"><i class="icon-cancel-circle"></i></button>
					</div>
					<div class="rightbar">
						<button class="btnClose-right" type="button"><i class="icon-cancel-circle"></i></button>
					</div>	
					<span class="close">Close &times;</span>
				</div>
			</div>
		</main>
		@php
			$views = $res->views;
			refresh_views($views , get_postid('post_id') , get_postid('page_id'),  get_postid('full') );
		@endphp
		@include('front.layout.footer')
			<!--  Owl Carousel -->
		<script src="{{asset('assets/js/owl.js') }}"></script> 
		<script>
			@php
				$mt = preg_match('/src="([^"]+)"/', $res->google_map, $match);
				if($mt){
					$url = $url = $match[1];
				}else{
					$url = "";
				}
			@endphp	
			var map_src = '{!! $url !!}';
			$(window).scroll(function(e){
				if($(window).scrollTop() > $("#event-intro").offset().top -0){
					$("#map-iframe").attr("src", map_src);
					loadCarousel();
					$(this).off(e);
				}
			});

			function loadCarousel(){
					$(".event-slider,.guest-slider").owlCarousel({
					loop:true,
				    margin:20,
				    nav:false,
				    dots:true,
				    autoplay:true,
				    autoplayTimeout:3000,
				    autoplayHoverPause:true,
				    responsive:{
				        0:{
				           items:1
				        },
	                    576:{
				           items:1
				        },
				        768:{
				            items:2
				        },
				        992:{
				            items:3
				        }
				    }
				});
			}

			$(".event-column").hover(function(){
				$(this).find(".team-nav").addClass("fade");
			},function(){
				$(".event-column").find(".team-nav").removeClass("fade");
			});

			$(".gallery-column  img").hover(function(){
				$(this).css({"border":"3px solid orange"});
			},function(){
				$(this).css({"border":"3px solid #fff"});
			});
		</script>
		{{-- {{ dd($link) }} --}}
		<script>
			// https://www.youtube.com/watch?v=x3ptP78JOnM
			var popup  =  document.getElementById("myPopup");
			var button =  document.getElementById("btn-popup");
			var span   =  document.getElementsByClassName("close")[0];
			var close  =  document.getElementsByClassName("btnClose")[0];
			var rightClose  =  document.getElementsByClassName("btnClose-right")[0];
			var veido_youtube = '{{ (!empty($type_youtube))?'youtube':'facebook' }}';
			button.onclick = function(e){
				e.preventDefault();
				popup.style.display = "block";
				if(veido_youtube == 'youtube'){
					var iframe = document.createElement("iframe");
					iframe.classList.add("ifr-video");
					iframe.src = "https://www.youtube.com/embed/"+ ___link['id']+"?autoplay=1";
					document.getElementsByClassName("popup-content")[0].appendChild(iframe);
				}else{
					var fb__link = ___link['id'];
					var iframe = document.createElement("iframe");
					iframe.classList.add("ifr-video");
					iframe.setAttribute('allow','autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share');
					iframe.setAttribute('allow','autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share');
					if(___link['type'] == 'facebook'){
						iframe.src = "https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F"+ ___link['id']+"%2F&width=500&show_text=false&appId=843790069360043&height=280";
						document.getElementsByClassName("popup-content")[0].appendChild(iframe);
					}else{
						iframe.src = "https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Ffb.watch%2F"+ ___link['id']+"%2F&width=500&show_text=false&appId=843790069360043&height=280";
						document.getElementsByClassName("popup-content")[0].appendChild(iframe);
					}
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
			rightClose.onclick = function(){
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
		
		<script>
			// Open the Modal
			function openModal() {
			  document.getElementById("myModal").style.display = "block";
			}

			// Close the Modal
			function closeModal() {
			  document.getElementById("myModal").style.display = "none";
			}

			var slideIndex = 1;
			showSlides(slideIndex);

			// Next/previous controls
			function plusSlides(n) {
			  showSlides(slideIndex += n);
			}

			// Thumbnail image controls
			function currentSlide(n) {
			  showSlides(slideIndex = n);
			}

			function showSlides(n) {
			  var i;
			  var slides = document.getElementsByClassName("mySlides");
			  var dots   = document.getElementsByClassName("demo");
			  var captionText = document.getElementById("caption");
			  if (n > slides.length) {slideIndex = 1}
			  if (n < 1) {slideIndex = slides.length}
			  for (i = 0; i < slides.length; i++) {
			    slides[i].style.display = "none";
			  }
			  for (i = 0; i < dots.length; i++) {
			    dots[i].className = dots[i].className.replace("active", "");
			  }
			  slides[slideIndex-1].style.display = "block";
              /*dots[slideIndex-1].className += "active";
			  captionText.innerHTML = dots[slideIndex-1].alt;*/
			}
		</script>

	</div>
</body>
</html>