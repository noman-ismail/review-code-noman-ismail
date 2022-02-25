@php
  $admin_r_email = "";
	if(!empty($admin_contact)){
		$admin_detail = (!empty($admin_contact->profile))?json_decode($admin_contact->profile):array();
		$admin_r_email = $admin_contact->r_email;
	}else{
		$admin_detail = array();
	}
	if(!empty($national_contact)){
		$national_detail = (!empty($national_contact->profile))?json_decode($national_contact->profile):array();
		$national_r_email = $national_contact->r_email;
	}else{
		$national_detail = array();
		$national_r_email = "";
	}
@endphp
@include('front.layout.header')
<link rel="stylesheet" href="{{ asset('assets/style/all.contact.css') }}"/>
</head>
<body>
<div class="wrapper">
	@include('front.layout.top-menu')
	@include('front.layout.main-menu',['segment'=>'contact'])
  <header class="title-header contact-header">
    <div class="container">
      <div class="header-text">
        <h1 class="header-title">Contact Us</h1>
        <ul class="breadcrumb">
          <li><a href="{{ route('base_url') }}">Home</a></li>
          <li><span>Contact Us</span></li>
        </ul>
      </div>
    </div>
  </header>
  
  <main class="main-content" id="main-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 contact-col person-column">
          <div class="content-column">
            <h5>Choose An Option:</h5>
            <div class="upper-menu">
              <div class="option-group">
                <div class="option-item option-lg green-item">
                  <div class="menu-item" data-value="admin" data-href="admin-tab">
                    <div class="icon">
                      <span data-title="Web Admin"><i class="icon-user"></i></span>
                    </div>
                    <h4>Web Admin</h4>
                  </div>
                </div>
                <div class="option-item option-lg dark-item">
                  <div class="menu-item" data-value="national" data-href="national-tab">
                    <div class="icon">
                      <span data-title="National Cabinet"><i class="icon-flag"></i></span>
                    </div>
                    <h4>National Cabinet</h4>
                  </div>
                </div>
                <div class="option-item option-lg dark-item">
                  <div class="menu-item" data-value="province" data-href="province-tab">
                    <div class="icon">
                      <span data-title="Provincial Cabinet">
                        <i class="icon-library"></i>
                      </span>
                    </div>
                    <h4>Provincial Cabinet</h4>
                  </div>
                </div>
                <div class="option-item option-lg green-item">
                  <div class="menu-item" data-value="district" data-href="district-tab">
                    <div class="icon">
                      <span  data-title="District Cabinet"><i class="icon-office"></i>
                      </span>
                    </div>
                    <h4>District Cabinet</h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="team-section tab-section" id="admin-tab">
              <h5 class="mb-12 text-center">This Query will be send to</h5>
              <div class="row">
                <div class="col-md-12">
                  <div class="head-column">
                    <div class="row align-items-center">
                      <div class="col-md-5 image-col">
                      	@if ($admin_detail)
	                        <img src="{{ get_post_mid($admin_detail->person_image) }}" class="img-fluid" alt="head-image">
	                      @endif
                      </div>
                      <div class="col-md-7 text-col">
                        <div class="head-top text-center">
                          <h4>{{ ($admin_detail)?$admin_detail->pr_name:"" }}</h4>
                          <p class="text-green">{{ ($admin_detail)?$admin_detail->pr_designation:"" }}</p>
                        </div>
                      	@if ($admin_detail)
	                        <ul class="head-nav">
	                        	@if (!empty($admin_detail->pr_email))
		                          <li><i class="icon-envelope"></i>
		                            <span>{{ ($admin_detail)?$admin_detail->pr_email:"" }}</span>
		                          </li>
		                        @endif
	                        	@if (!empty($admin_detail->pr_phone))
		                          <li><i class="icon-phone"></i>
		                            <span>
		                            	<em>{{ ($admin_detail)?$admin_detail->pr_phone:"" }}</em>
		                            </span>
		                          </li>
		                        @endif
	                        	@if (!empty($admin_detail->pr_web_url))
		                          <li><i class="icon-sphere"></i>
		                            <span>{{ ($admin_detail)?$admin_detail->pr_web_url:"" }}</span>
		                          </li>
		                        @endif
	                        	@if (!empty($admin_detail->pr_address))
		                          <li><i class="icon-location"></i>
		                            <span>{{ ($admin_detail)?$admin_detail->pr_address:"" }}</span>
		                          </li>
		                        @endif
	                        </ul>
                          {{-- {{ dd($admin_detail) }} --}}
	                        @if (!empty($admin_detail->pr_fb_url) || !empty($admin_detail->pr_twitter_url) || !empty($admin_detail->pr_linkedin_url) || !empty($admin_detail->pr_instagram_url))
		                        <h5 class="social-head">Social Platform</h5>
		                        <ul class="social-nav">
		                        	@if (!empty($admin_detail->pr_fb_url))
			                          <li>
			                          	<a href="{{ $admin_detail->pr_fb_url }}" rel="nofollow noopener" target="_blank"><i class="icon-facebook"></i></a>
			                          </li>
		                        	@endif
		                        	@if (!empty($admin_detail->pr_twitter_url))
			                          <li>
			                          	<a href="{{$admin_detail->pr_twitter_url}}" rel="nofollow noopener" target="_blank"><i class="icon-twitter"></i></a>
			                          </li>
		                        	@endif
		                        	@if (!empty($admin_detail->pr_linkedin_url))
			                          <li>
			                          	<a href="{{ $admin_detail->pr_linkedin_url }}" rel="nofollow noopener" target="_blank"><i class="icon-linkedin2"></i></a>
			                          </li>
		                        	@endif
		                        	@if (!empty($admin_detail->pr_instagram_url))
			                          <li>
			                          	<a href="{{ $admin_detail->pr_instagram_url }}" rel="nofollow noopener" target="_blank"><i class="icon-instagram"></i></a>
			                          </li>
		                        	@endif
		                        </ul>
		                       @endif
	                      @endif
                      </div>
                    </div>
                  </div>
                  @if ($admin_contact)
	                  <div class="item-list">
	                    <h5 class="text-center">This Query will be send to</h5>
	                    @if (!empty($admin_contact->address))
		                    <div class="contact-item row">
		                      <div class="contact-icon  col-2 col-sm-2 col-md-2 col-lg-3">
		                        <i class="icon-location"></i>
		                      </div>
		                      <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
		                        <h3>Office Address</h3>
		                        <p>{{ $admin_contact->address }}</p>
		                      </div>
		                    </div>
	                    @endif
	                    @if (!empty($admin_contact->phone))
		                    <div class="contact-item row">
		                      <div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-3">
		                        <i class="icon-phone"></i>
		                      </div>
		                      <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
		                        <h3>Quick Contact</h3>
		                        <p>{!! nl2br($admin_contact->phone) !!}</p>
		                      </div>
		                    </div>
	                    	{{-- expr --}}
	                    @endif
	                    @if (!empty($admin_contact->email))
		                    <div class="contact-item row">
		                      <div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-3">
		                        <i class="icon-envelope"></i>
		                      </div>
		                      <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
		                        <h3>Our Email</h3>
		                        <p>{!! nl2br($admin_contact->email) !!}</p>
		                      </div>
		                    </div>
	                    	{{-- expr --}}
	                    @endif
	                  </div>
	                @endif
                </div>
              </div>
            </div>
            <div class="national-section tab-section" id="national-tab">
              <div class="head-column">
                <div class="row align-items-center">
                  <div class="col-md-5 image-col">
                  	@if ($national_detail)
                      <img src="{{ get_post_mid($national_detail->person_image) }}" class="img-fluid" alt="head-image">
                    @endif
                  </div>
                  <div class="col-md-7 text-col">
                    <div class="head-top text-center">
                      <h4>{{ ($national_detail)?$national_detail->pr_name:"" }}</h4>
                      <p class="text-green">{{ ($national_detail)?$national_detail->pr_designation:"" }}</p>
                    </div>
                  	@if ($national_detail)
                      <ul class="head-nav">
                      	@if (!empty($national_detail->pr_email))
                          <li><i class="icon-envelope"></i>
                            <span>{{ ($national_detail)?$national_detail->pr_email:"" }}</span>
                          </li>
                        @endif
                      	@if (!empty($national_detail->pr_phone))
                          <li><i class="icon-phone"></i>
                            <span>
                            	<em>{{ ($national_detail)?$national_detail->pr_phone:"" }}</em>
                            </span>
                          </li>
                        @endif
                      	@if (!empty($national_detail->pr_web_url))
                          <li><i class="icon-sphere"></i>
                            <span>{{ ($national_detail)?$national_detail->pr_web_url:"" }}</span>
                          </li>
                        @endif
                      	@if (!empty($national_detail->pr_address))
                          <li><i class="icon-location"></i>
                            <span>{{ ($national_detail)?$national_detail->pr_address:"" }}</span>
                          </li>
                        @endif
                      </ul>
                      @if (empty($national_detail->pr_fb_url) and empty($national_detail->pr_twitter_url) and empty($national_detail->pr_linkedin_url) and empty($national_detail->pr_instagram_url))
                        <h5 class="social-head">Social Platform</h5>
                        <ul class="social-nav">
                        	@if (!empty($national_detail->pr_fb_url))
	                          <li>
	                          	<a href="#"><i class="icon-facebook"></i></a>
	                          </li>
                        	@endif
                        	@if (!empty($national_detail->pr_twitter_url))
	                          <li>
	                          	<a href="#"><i class="icon-twitter"></i></a>
	                          </li>
                        	@endif
                        	@if (!empty($national_detail->pr_linkedin_url))
	                          <li>
	                          	<a href="#"><i class="icon-linkedin2"></i></a>
	                          </li>
                        	@endif
                        	@if (!empty($national_detail->pr_instagram_url))
	                          <li>
	                          	<a href="#"><i class="icon-instagram"></i></a>
	                          </li>
                        	@endif
                        </ul>
                       @endif
                    @endif
                  </div>
                </div>
              </div>
              @if ($admin_contact)
                <div class="item-list">
                  <h5 class="text-center">This Query will be send to</h5>
                  @if (!empty($admin_contact->address))
                    <div class="contact-item row">
                      <div class="contact-icon  col-2 col-sm-2 col-md-2 col-lg-3">
                        <i class="icon-location"></i>
                      </div>
                      <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
                        <h3>Office Address</h3>
                        <p>{{ $admin_contact->address }}</p>
                      </div>
                    </div>
                  @endif
                  @if (!empty($admin_contact->phone))
                    <div class="contact-item row">
                      <div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-3">
                        <i class="icon-phone"></i>
                      </div>
                      <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
                        <h3>Quick Contact</h3>
                        <p>{{ $admin_contact->phone }}</p>
                      </div>
                    </div>
                  	{{-- expr --}}
                  @endif
                  @if (!empty($admin_contact->email))
                    <div class="contact-item row">
                      <div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-3">
                        <i class="icon-envelope"></i>
                      </div>
                      <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
                        <h3>Our Email</h3>
                        <p>{{ $admin_contact->email }}</p>
                      </div>
                    </div>
                  	{{-- expr --}}
                  @endif
                </div>
              @endif
            </div>
            <div class="province-section tab-section" id="province-tab">
              <h5>Choose Province:</h5>
              <div class="row province-row">
              	@if(count($province) > 0)
	              	@foreach ($province as $key => $value)
	              		@php
	              			$i = $key+1;
	              		@endphp
		                <div class="col-sm-6 col-md-4 outer-column">
		                  <div class="province-column __provinceRecord" data-value="{{ province_r_email($value->id) }}" data-name="{{ $value->id }}">
		                    <img src="{{ asset('compress/province-0'.$i.'.jpg') }}" class="img-fluid" alt="province-image">
		                    <div class="hvr-outline-corner">
		                      <em>{{ $value->name }}</em>
		                      <p>{{ $value->name }} Cabinet</p>
		                      <span class="border-tl"></span>
		                      <span class="border-tr"></span>
		                      <span class="border-rb"></span>
		                      <span class="border-lb"></span>
		                    </div>
		                  </div>
		                </div>
	              		{{-- expr --}}
	              	@endforeach
	              @endif
              </div>
              <div class="item-list" style="display:none;">
              </div>
            </div>
            <div class="district-section tab-section" id="district-tab">
              <div class="row contact-form">
                <div class="col-xl-12">
                  <div class="input-group">
                    <label>Choose District:</label>
                    <select  class="dist-dropdown">
                      <option value=""> Choose an Option </option>
                      @if (count($cities) > 0)
                     		@foreach ($cities as $value)
                     			<option value="{{ $value->id }}">{{ $value->name }}</option>
                     		@endforeach
                      @endif
                    </select>
                  </div>
                </div>
              </div>
              {{-- <div class="item-list" style="display:none">
                <h5 class="mt-10 text-center">This Query will be send to</h5>
                <div class="contact-item row">
                  <div class="contact-icon  col-2 col-sm-2 col-md-2 col-lg-3">
                    <i class="icon-location"></i>
                  </div>
                  <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
                    <h3>Office Address</h3>
                    <p>6281 Miana Esteions, LxemePort Ashlydeen, USA</p>
                  </div>
                </div>
                <div class="contact-item row">
                  <div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-3">
                    <i class="icon-phone"></i>
                  </div>
                  <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
                    <h3>Quick Contact</h3>
                    <p>+92-323-778-4054</p>
                    <p>+92-784-256-1024</p>
                  </div>
                </div>
                <div class="contact-item row">
                  <div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-3">
                    <i class="icon-envelope"></i>
                  </div>
                  <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
                    <h3>Our Email</h3>
                    <p>info@example.com</p>
                    <p>admin@dgaps.com</p>
                  </div>
                </div>
              </div> --}}
            </div>
          </div>
        </div>
        <div class="col-lg-6 bg-silver contact-col">
          <div class="content-column">
            <h2 class="text-green proceed-head">Choose an Option</h2>
            <div class="contact-form">
              <h2 class="text-green">Query From</h2>
              <form class="row" id="contactform">
              	<input type="hidden" id="r_email" name="r_email" value="">
              	<input type="hidden" id="user_type" name="r_type" value="">
                <div class="input-group col-xl-12">
                  <label>Your Name:</label>
                  <input type="text" placeholder="Name" name="name">
                </div>
                <div class="input-group col-xl-12">
                  <label>Your City:</label>
                  <select  class="city-dropdown" name="city">
                    <option value=""> Select Your City </option>
                    @if (count($cities) > 0)
                   		@foreach ($cities as $value)
                   			<option value="{{ $value->id }}">{{ $value->name }}</option>
                   		@endforeach
                    @endif
                  </select>
                </div>
                <div class="input-group input-group-email col-xl-12">
                  <label>Email:</label>
                  <input type="text" placeholder="Email" name="email">
                </div>
                <div class="input-group input-group-contact col-xl-12">
                  <label>Contact:</label>
                  <input type="text" placeholder="Phone Number" name="contact" class="contact">
                </div>
                <div class="input-group col-xl-12">
                  <label>Enter Subject:</label>
                  <input type="text" placeholder="Subject" name="subject">
                </div>
                <div class="input-group col-xl-12">
                  <label>Your Message:</label>
                  <textarea placeholder="Enter Message" name="message"></textarea>
                </div>
                <div class="input-group col-xl-12 ml-auto">
                  <button type="submit" class="btn btn-contact contactform">Send Message</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid map-container" id="map-container">
      <div class="contact-strip">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12 col-md-9 col-lg-9 strip-detail d-flex align-items-center">
              <div class="strip-icon">
                <i class="icon-library"></i>
              </div>
              <h3>Why You Need the Top Lawyers in our Firm</h3>
            </div>
            <div class="col-5 col-md-3 col-lg-3 mx-sm-auto">
              <a href="mailto:apjea@gmail.com" class="button">Email Us</a>
            </div>
          </div>
        </div>
      </div>
      <div class="contact-map" id="contact-map">
        <iframe id="map-iframe"  width="600" height="450"  style="border:0;background:transparent url('{{ asset('compress/loader-sm.gif') }}') no-repeat center center" allowfullscreen="">
        </iframe>
      </div>
    </div>
  </main>
  @include('front.layout.footer')
  <script src="{{ asset('assets/js/chosen.js') }}"></script>
  <script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
  <script>
    function loadMap(){
      var iframe = document.getElementById("map-iframe");
      iframe.src = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3444.9653028047546!2d71.9157354150887!3d30.295049381791863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x393b554b068b1b21%3A0x7517d8adc887c625!2sDigital+Applications!5e0!3m2!1sen!2s!4v1540552186821';
    }
  </script>
  <script>
    $(".city-dropdown").chosen();
    $(".dist-dropdown").chosen();
    $(".tab-section").hide();
  $(".contact-form").hide();
  $('#contactform').hide();
  $(window).on("scroll",function(){
  var firstHeight  = $(".contact-col:first-child .content-column").height();
  var secondHeight = $(".contact-col:nth-child(2) .content-column").height();
  });
  
  $(".menu-item").click(function(){
	  $(".item-list:not(.national-list)").hide();
	  $(this).closest(".option-group").css({"justify-content":"center"});
	  $(this).closest(".upper-menu").prev("h5").css({"text-align":"center"});
	  $(".option-item").addClass("option-sm");
	  $(".option-item").removeClass("option-lg");
	  $(".option-item .menu-item").css({"background":"#fff"});
	  $(".menu-item").removeClass("active");
	  $(this).addClass("active");
	  $(".province-section .province-column").removeClass("active");
	  var dataId = $(this).attr("data-href");
	  var data_value = $(this).attr('data-value').trim();
	  if(data_value == "admin"){
      $('#contactform').show();
		  $('#r_email').val('{{ $admin_r_email }}');
		  $('#user_type').val('admin');
	  }else if(data_value == "national"){
      $('#contactform').show();
		  $('#r_email').val('{{ $national_r_email }}');
		  $('#user_type').val('national');
	  }else{
      $('#contactform').hide();
    }
	  $(".tab-section").each(function(){
		  var formId = $(this).attr("id");
		  if(formId == dataId){
			  $(this).show();
			  $(".contact-form").show();
			  $("h2.proceed-head").remove();
		  }
		  else{
			  $(this).hide();
		  }
	  });
  });
  
    $(".cabinet-toggle .cabinet-item").click(function(e){
      e.preventDefault();
      $(this).closest(".cabinet-toggle").next(".item-list").fadeIn("slow");
      $(".cabinet-toggle").fadeOut("slow");
    });
    $(".dist-dropdown").chosen().change(function(){
    	var district = $(this).val().trim();
		  $('#r_email').val(district);
		  $('#user_type').val('district');
      $(".cabinet-toggle").next(".item-list").show();
      if(district == ""){
        $('#contactform').hide();
      }else{
        $('#contactform').show();
      }
    });
    $(".province-section .province-column").click(function(){
      $('#contactform').show();
    	$('#user_type').val('province');
			$(".province-section .province-column").removeClass("active");
			$(this).addClass("active");
			$(".item-list").show();
			$(".province-section .outer-column").each(function(){
				$(this).addClass("col-md-2");
				$(this).addClass("col-sm-4");
				$(this).addClass("col-6");
				$(this).addClass("small-col");
				$(this).removeClass("col-md-4");
			});
			if($(window).width() <768){
				$("html,body").animate({scrollTop:$(".province-section .item-list").offset().top +0},"slow");
			}
    });
    $('.__provinceRecord').click(function(){
      var province_name = $(this).attr('data-name');
      $.ajax({
        url:'{{ route('fetch-cities') }}',
        method:'POST',
        dataType:'html',
        data:{
          action:'find-province',
          province:province_name,
          _token:'{{ csrf_token() }}',
        },success:function(res){
          $(".province-section .item-list").html(res);
          $(".province-section .item-list").show();
        },error:function(res){
          console.log(res);
        }
      })
    })
    $(window).scroll(function(e){
      if($(window).scrollTop() > $("#main-content").offset().top + 10){
        loadMap();
        $(this).off(e);
      }
    });
  </script>
</div>
<script src="{{ asset('assets/js/validate.js') }}"></script>
<script>
	$(document).ready(function () {
    $('.contact').samask("0000-0000000");
  	$('.contact').change(function(e){
  		var new_val = $(this).val();
  		var new_val = new_val.replace(/(\d{4})(\d{7})/, "$1-$2");
  		$(this).val(new_val);
  	})
    $(".close").on("click", function(){
        $(this).closest("div").remove();
    });
    _is_validate("#contactform", { name: { require: !0, min: 3, max: 35 }, contact: { require: !0, min: 12, max: 12 }, email: { require: !0, email: !0 }, subject: { require: !0, min: 5, max: 100 }, message: { require: !0, min: 10, max: 5000 } }),
        $(".contactform").click(function (e) {
            e.preventDefault();
            $(this).attr('disabled',true);
            var r = $(this),
            a = r.closest("form"),
            t = r.closest("form").serializeArray();
            r.attr("disabled", !0),
            $.ajax({ headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }, type: "post", global: "false", datatype: "html", url: "/contactform", data: t })
              .done(function (e) {
                $(this).attr('disabled',false);
                r.closest("form").trigger("reset"),
                r.closest("form").closest("div").find("img").remove(),
                r.closest("form").find(".dg-b-icon").remove(),
                r.attr("disabled", !1),
                $('.message-box').find('p').html(' Your message has been sent.'),
                $(".message-box").fadeIn("slow"),
                "undefined" != typeof grecaptcha && grecaptcha && grecaptcha.reset && grecaptcha.reset();
              })
              .fail(function (e) {
                $(this).attr('disabled',false);
                $("<p>", { id: "foo", class: "a" });
                let t = e.responseJSON.errors;
                r.closest("div").find("img").remove(),
                r.attr("disabled", !1),
                a.find("div.error").remove(),
                a.find("input").prevAll("._dg_error").remove(),
                a.find("textarea").prevAll("._dg_error").remove(),
                t.name && ($("input[name='name']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + t.name + "</div>").insertBefore("#contactform input[name='name']")),
                t.message && ($("textarea[name='message']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + t.message + "</div>").insertBefore($("textarea[name='message']"))),
                t.contact && ($("input[name='contact']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + t.contact + "</div>").insertBefore("#contactform input[name='contact']")),
                t.email && ($("#contactform input[name='email']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + t.email + "</div>").insertBefore($("#contactform input[name='email']"))),
                t.phone && ($("input[name='phone']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + t.phone + "</div>").insertBefore($("input[name='phone']"))),
                t.subject && ($("input[name='subject']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + t.subject + "</div>").insertBefore($("input[name='subject']"))),
                $("#errors").html(""),
                "undefined" != typeof grecaptcha && grecaptcha && grecaptcha.reset && grecaptcha.reset();
              }),
            e.preventDefault();
        });
		});
</script>
</body>
</html>