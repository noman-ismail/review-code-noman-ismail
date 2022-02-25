@include('front.layout.header')
  <link rel="stylesheet" href="{{ asset('assets/style/all.content.css') }}"/>
</head>
<body>
  <div class="wrapper">
    @include('front.layout.top-menu')
    @include('front.layout.main-menu')
{{-- 	<header class="title-header main-header">
		<div class="container">
			<div class="header-text">
				<h1 class="header-title">Register</h1>
				<ul class="breadcrumb" id="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><span>Register</span></li>
				</ul>
			</div>
		</div>
	</header> --}}
	<div class="container-fluid jumbotron mb-0" id="outer-container breadcrumb">
		<div class="container mt-4 mb-5">
			<div class="row register-row">
				<div class="col-md-12 col-lg-10 mx-auto">
					<div class="outer-box bg-white main-column">
						<h3 class="text-uppercase text-center">Register</h3>
						<hr>
						<form action="{{ route('register') }}" method="post" class="register-form user-form" id="contactform">
							@csrf
							<div class="row">
								@if(session()->has("success"))
								<script>
									$([document.documentElement, document.body]).animate({
										scrollTop: $("body").offset().top
									}, 1000);
								</script>
								<div class="col-md-12 main-column">
									<div class="message message-success">
										<span>{!! session("success") !!}</span>
										<i class="close close-message">×</i>
									</div>
								</div>
								@endif
								@if(session()->has("error"))
								<script>
									$([document.documentElement, document.body]).animate({
										scrollTop: $("body").offset().top
									}, 1000);
								</script>
								<div class="col-md-12">
									<div class="message message-error">
										<span>{!! session("error") !!}</span>
										<i class="close close-message">×</i>
									</div>
								</div>
								@endif
								<div class="col-md-12">
									<div class="form-group {{-- success-group --}}">
										<div class="resp-top">
											<label>Your Name: <span class="comp">*</span></label>
											<div class="text"></div>
										</div>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text bg-orange text-light">
													<i class="icon-user"></i>
												</span>
											</div>
											<input type="text" name="name" class="form-control name" placeholder="Enter Your Name">
											<span class="icon-resp"></span>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-lg-6">
									<div class="form-group">
										<div class="resp-top">
											<label for="" class=" mt-3">Official Designation: <span class="comp">*</span></label>
											<div class="text"></div>
										</div>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text  bg-orange text-light">
													<i class="icon-briefcase"></i>
												</span>
											</div>
											<select name="designation"class="ui-dropdown designation">
												<option value="">Choose an Option</option>
												@if (count($designation) > 0)
													@foreach ($designation as $value)
														<option value="{{ $value->id }}">{{ $value->name }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-lg-6">
									<div class="form-group">
										<div class="resp-top">
											<label for="" class=" mt-3">Province: <span class="comp">*</span></label>
											<div class="text"></div>
										</div>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text  bg-orange text-light">
													<i class="icon-briefcase"></i>
												</span>
											</div>
											<select name="province" class="ui-dropdown province">
												<option value="">Choose an Option</option>
												@if (count($provinces) > 0)
													@foreach ($provinces as $value)
														<option value="{{ $value->id }}">{{ $value->name }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-lg-6">
									<div class="form-group">
										<div class="resp-top">
											<label for="" class=" mt-3">Posting City: <span class="comp">*</span></label>
											<div class="text"></div>
										</div>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text  bg-orange text-light">
													<i class="icon-briefcase"></i>
												</span>
											</div>
											<select name="district" class="ui-dropdown district">
												<option value="">Choose an Option</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-lg-6">
									<div class="form-group">
										<div class="resp-top">
											<label for="" class=" mt-3">Residence City: <span class="comp">*</span></label>
											<div class="text"></div>
										</div>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text  bg-orange text-light">
													<i class="icon-briefcase"></i>
												</span>
											</div>
											<select name="residence" class="ui-dropdown residence">
												<option value="">Choose an Option</option>
												@if (count($cities) > 0)
													@foreach ($cities as $value)
														<option value="{{ $value->id }}">{{ $value->name }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-lg-12 col-xl-12">
									<div class="form-group">
										<div class="resp-top">
											<label for="" class=" mt-3">CNIC: <span class="comp">*</span></label>
											<div class="text"></div>
										</div>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text  bg-orange text-light">
													<i class="icon-user"></i>
												</span>
											</div>
											<input type="tel" name="CNIC" class="form-control CNIC" placeholder="Enter Your CNIC No" autocomplete="off">
											<span class="icon-resp"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-6">
									<div class="form-group">
										<div class="resp-top">
											<label>Email: <span class="comp">*</span></label>
											<div class="text"></div>
										</div>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text  bg-orange text-light">
													<i class="icon-envelope"></i>
												</span>
											</div>
											<input type="text" name="email" class="form-control email" placeholder="Enter Your Email Address">
											<span class="icon-resp"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-6">
									<div class="form-group">
										<div class="resp-top">
											<label>Mobile No: <span class="comp">*</span></label>
											<div class="text"></div>
										</div>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text  bg-orange text-light">
													<i class="icon-mobile"></i>
												</span>
											</div>
											<input type="tel" name="mobile" class="form-control contact" placeholder="Enter Your Mobile No">
											<span class="icon-resp"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-6">
									<div class="form-group">
										<div class="resp-top">
											<label for="" class=" mt-3">Password: <span class="comp">*</span></label>
											<div class="text"></div>
										</div>
										<div class="input-group password-group">
											<div class="input-group-prepend">
												<span class="input-group-text  bg-orange text-light">
													<i class="icon-lock"></i>
												</span>
											</div>
											<input type="password" name="password" class="form-control password" placeholder="Enter Your Password">
											<span class="toggle-icon icon-eye"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-6">
									<div class="form-group">
										<div class="resp-top">
											<label for="" class=" mt-3">Confirm Password: <span class="comp">*</span></label>
											<span class="text"></span>
										</div>
										<div class="input-group password-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="icon-lock"></i>
												</span>
											</div>
											<input type="password" name="rep_password" class="form-control rep_password" placeholder="Enter Your Repeat Password">
											<span class="toggle-icon icon-eye"></span>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									@php
									$shuffle_img = get_security_img();
									shuffle($shuffle_img);
									$i = 1;
									@endphp
									<div class="icon-group">
										<div class="icon-group-error">
											<label>Choose Security Image: <span class="comp">*</span></label>
											<div class="txt"></div>
										</div>
										<div class="icon-list">
											@foreach ($shuffle_img as $v)
											<label title="{{ $v['title'] }}">
												<i class="{{ $v['i'] }}"></i>
												<input type="radio" name="security_img" value="{{ $v['value'] }}" class="security_img">
											</label>
											@endforeach
										</div>
									</div>
								</div>
							</div>
							<div class="row form-footer">
								<div class="button-group" style="">
									<button class="btn btn-submit  btn-round contactform" type="submit">Register</button>
								</div>
								<div class="footer-text">
									Already Registered? &nbsp;<a href="{{ route('login') }}">Sign In</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
    <script src="{{ asset('assets/js/validate2.js') }}"></script>
    <script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
	<script>
		var button = document.getElementsByClassName("toggle-icon")[0];
		button.onclick = function(e){
			var parent     = button.parentNode;
			var type = parent.children[1].type;
			if(type == "password"){
				parent.children[1].type = "text";
			}
			else{
				parent.children[1].type = "password";
			}
			if(button.classList.contains("icon-eye")){
				button.classList.add("icon-eye-blocked");
				button.classList.remove("icon-eye");
			}
			else{
				button.classList.add("icon-eye");
				button.classList.remove("icon-eye-blocked");
			}
		}

		var conf = document.getElementsByClassName("toggle-icon")[1];
		conf.onclick = function(e){
			var parent     = conf.parentNode;
			var type 	   = parent.children[1].type;
			if(type == "password"){
				parent.children[1].type = "text";
			}
			else{
				parent.children[1].type = "password";
			}
			if(conf.classList.contains("icon-eye")){
				conf.classList.add("icon-eye-blocked");
				conf.classList.remove("icon-eye");
			}
			else{
				conf.classList.add("icon-eye");
				conf.classList.remove("icon-eye-blocked");
			}
		}
		$(".icon-list label").click(function(){
			$(this).closest(".icon-group").find(".icon-list label").removeClass("active");
			$(this).addClass("active");
		});
	</script>
	<script>
		$(document).ready(function(){
			$('.CNIC').samask("00000-0000000-0");
			$('.contact').samask("0000-0000000");
			$('.CNIC , .contact').keydown(function(e){ 96-105
				if ((e.keyCode >= 33 && e.keyCode <= 44) || e.keyCode == 46 || e.keyCode == 47  || (e.keyCode >= 58 && e.keyCode <= 95) || (e.keyCode >= 106 && e.keyCode <= 126) ) {
					return false; 
				}else {
					return true;
				}
			});
			$('.CNIC').change(function(e){
				var new_val = $(this).val();
				var new_val = new_val.replace(/(\d{5})(\d{7})(\d{1})/, "$1-$2-$3");
				$(this).val(new_val);
			})
			$('.contact').change(function(e){
				var new_val = $(this).val();
				var new_val = new_val.replace(/(\d{4})(\d{7})/, "$1-$2");
				$(this).val(new_val);
			})
			var base_url = '{{ route('base_url') }}';
			var login = base_url+'/login';
			var _token = '{{ csrf_token() }}';
			$('.ui-dropdown').change(function(){
				var tre = $(this).val();
				if(tre != ""){
					var selector = $(this).closest('.form-group');
					selector.removeClass('error-group').find('.text').html('');
					selector.find('.chosen-single-danger').removeClass('chosen-single-danger');
				}
			});
			$('.security_img').click(function(){
				var selecor = $(this).closest('.form-group');
				selecor.find('.icon-group-error').find('.txt').html('');
			})
			$('.province').change(function(){
				$('.district').html(new Option("Choose District Name", ""));
				$('.district').trigger("chosen:updated");
				var id = $(this).val();		
				var url = '{{ route('fetch-cities') }}';		
				$.ajax({
					url:url,
					method:'POST',
					dataType:'json',
					data:{
					action:'get-districts',
					id:id,
					_token:_token,
					}, success:function(res){
					if(res != ""){
						$('.district').html(new Option("Choose District Name", ""));
						$.each( res, function( key, value ) {
							var op = "<option value="+key+">"+value+"</option>";
							$('.district').append(op);
						});
						$('.district').chosen();
						$('.district').trigger("chosen:updated");
					}
					}, error:function(e){
						alert('Error to get districts. Refresh page and try again');
					}
				})
			})
        $('.icon-list label').css('margin','12px 8px');
		window._____ISERROR = false;
        _is_validate("#contactform", { name: {require: !0, min:3, max:30}, CNIC: {require: !0, CNIC: !0 }, security_img: {require: !0} , 
        	designation: {require: !0}, province: {require: !0}, district: {require: !0}, residence: {require: !0}, password: {require: !0, min:5}, 
        	rep_password: {require: !0, match:"password"}, email: {require: !0,email: !0}, mobile: {require: !0, phone: !0} });

        $(".contactform").click(function (e) {
	            e.preventDefault();
	            var r = $(this);
	              r.text('Please Wait...'),
	                $(".message-box").fadeIn("slow");
	                $('.message-box').find('.message-head').hide(),
	                $('.message-box').find('.icon').hide(),
	                $('.message-box').find('button').hide(),
	                $('.message-box').find('p').html('Please Wait .......');
              if (window._____ISERROR == false) {
	              a = r.closest("form"),
	              action = a.attr('action'),
	              t = r.closest("form").serializeArray();

				$.ajax({ headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }, type: "post", global: "false", datatype: "json", url: action, data: t })
                .done(function (e) {
	              r.text('Register');
					$(".message-box").fadeOut();
					$('.message-box').find('p').html('');
	                var uii = JSON.parse(e);
	                if (uii['type'] == 'success') {
						$('.form-group').find('error-group').removeClass('error-group').find('label:first').next('.text').html(''),
						r.closest("form").trigger("reset"),
						$("option[value='']").attr('selected', true),
						$('.ui-dropdown').trigger("chosen:updated"),
						$(".icon-list label").removeClass("active"),
						$('.icon-check_circle_outline').removeClass('icon-check_circle_outline'),
						$('.icon-icon-cancel-circle').removeClass('icon-icon-cancel-circle'),
						$('.success-group').removeClass('success-group');
	                  $([document.documentElement, document.body]).animate({
	                      scrollTop: $("body").offset().top
	                  }, 1000);
	                  a.prev('.row').remove();
	                  var bodd = '<div class="row main-column"><div class="col-md-12"><div class="message message-success"><span>'+uii['msg']+'</span><i class="close close-message">×</i></div></div></div>';
	                  $(bodd).insertBefore(a);
	                  $(".close-message").click(function(){
	                      $(".message").fadeOut("slow");
	                  });	
	              	}else if(uii['type'] == 'error'){
	                  $([document.documentElement, document.body]).animate({
	                      scrollTop: $("body").offset().top
	                  }, 1000);
	                  var bodd = '<div class="row main-column"><div class="col-md-12"><div class="message message-error"><span>'+uii['msg']+'</span><i class="close close-message">×</i></div></div></div>';
	                  $(bodd).insertBefore(a);
	                  $(".close-message").click(function(){
	                      $(".message").fadeOut("slow");
	                  });	
	              	}
                })
                .fail(function (e) {
					r.text('Register'),
					$(".message-box").fadeOut();
					$('.message-box').find('p').html(''),
                  r.attr('disabled',false);
                  $('.row.main-column').remove();
                  $("<p>", { id: "foo", class: "a" });
                  let t = e.responseJSON.errors;
                  r.attr("disabled", !1),
                  a.find("div.error-group").removeClass('error-group'),
                  a.find("div.success-group").removeClass('success-group'),
                  t.password && ($("input[name='password']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.password)),
                  t.rep_password && ($("input[name='rep_password']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.rep_password)),
                  t.CNIC && ($("input[name='CNIC']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.CNIC),$("input[name='CNIC']").next('.icon-resp').remove(),$("input[name='CNIC']").next('.toggle-icon').remove(),$("<span class='icon-resp'><i class='icon-cancel-circle'></i></span>").insertAfter($("input[name='CNIC']"))),
                  t.name && ($("input[name='name']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.name),$("input[name='name']").next('.icon-resp').remove(),$("input[name='name']").next('.toggle-icon').remove(),$("<span class='icon-resp'><i class='icon-cancel-circle'></i></span>").insertAfter($("input[name='name']"))),
                  t.mobile && ($("input[name='mobile']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.mobile),$("input[name='mobile']").next('.icon-resp').remove(),$("input[name='mobile']").next('.toggle-icon').remove(),$("<span class='icon-resp'><i class='icon-cancel-circle'></i></span>").insertAfter($("input[name='mobile']"))),
                  t.email && ($("input[name='email']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.email),$("input[name='email']").next('.icon-resp').remove(),$("input[name='email']").next('.toggle-icon').remove(),$("<span class='icon-resp'><i class='icon-cancel-circle'></i></span>").insertAfter($("input[name='email']"))),
                  t.designation && ($("select[name='designation']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.designation),$("select[name='designation']").next(".chosen-container").find('a').addClass('chosen-single-danger')),
                  t.province && ($("select[name='province']").next(".chosen-container").find('a').addClass('chosen-single-danger'),$("select[name='province']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.province)),
                  t.district && ($("select[name='district']").next(".chosen-container").find('a').addClass('chosen-single-danger'),$("select[name='district']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.district)),
                  t.residence && ($("select[name='residence']").next(".chosen-container").find('a').addClass('chosen-single-danger'),$("select[name='residence']").closest('.form-group').addClass('error-group').find('label:first').next('.text').html(t.residence)),
                  t.security_img && ($("#contactform input[name='security_img']").closest('.icon-group').addClass('form-group').find('.icon-group-error div.txt').html(t.security_img)),

                  $([document.documentElement, document.body]).animate({
                      scrollTop: $("form").find('.error-group').offset().top - 50
                  }, 1000);
                    // "undefined" != typeof grecaptcha && grecaptcha && grecaptcha.reset && grecaptcha.reset();
                });
              }else{
				r.text('Register');
                $(".message-box").fadeOut();
                $('.message-box').find('p').html('');
            }
        });
    });
	</script>
@include('front.layout.footer')