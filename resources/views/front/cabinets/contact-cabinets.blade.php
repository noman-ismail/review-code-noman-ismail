@include('front.layout.header')
		<link rel="stylesheet" href="{{ asset('assets/style/all.cabinet.css') }}"/>
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
							<li><span>Contact Us</span></li>
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
							<div id="cab-contact" class="cabinet-column">
								<h3 class="rounded-top">Contact Us</h3>
								<div class="row">
									@if(!empty($record->address) and !empty($record->phone) and !empty($record->email))
										<div class="col-lg-12 contact-col">
											<h2 class="text-green">Visit Our Place</h2>
											<div class="item-list">
												@if (!empty($record->address))
													<div class="contact-item row">
														<div class="contact-icon  col-2 col-sm-2 col-md-2 col-lg-2">
															<i class="icon-location"></i>
														</div>
														<div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-10">
															<h3>{{ $record->address_title }}</h3>
															<p>{{ $record->address }}</p>
														</div>
													</div>
												@endif
												@if (!empty($record->phone))
													<div class="contact-item row">
														<div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-2">
															<i class="icon-phone"></i>
														</div>
														<div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-10">
															<h3>{{ $record->phone_title }}</h3>
															<p>{{ $record->phone }}</p>
														</div>
													</div>
												@endif
												@if (!empty($record->email))
													<div class="contact-item row">
														<div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-2">
															<i class="icon-envelope"></i>
														</div>
														<div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-10">
															<h3>{{ $record->email_title }}</h3>
															<p>{!! nl2br($record->email) !!}</p>
														</div>
													</div>
												@endif
											</div>
										</div>
									@endif
									<div class="col-lg-12 bg-silver contact-col">
										<h2 class="text-green">Drop Us A Line</h2>
										<form class="row contact-form" id="contactform">
											@php
												if($panel == 'cities'){
													$r_typpe = 'district';
												}else{
													$r_typpe = $panel;
												}
											@endphp
							              	<input type="hidden" id="r_email" name="r_email" value="{{ $r_email }}">
							              	<input type="hidden" id="user_type" name="r_type" value="{{ $r_typpe }}">
											<div class="input-group col-xl-6">
												<label>Your Name:</label>
												<input type="text" placeholder="Name" name="name">
											</div>
											<div class="input-group col-xl-6">
												<label>Your City:</label>
												<select placeholder="City" class="city-dropdown" name="city">
													<option> Select City </option>
													@if (count($cities) > 0)
														@foreach ($cities as $value)
															<option value="{{ $value->id }}">{{ $value->name }}</option>
														@endforeach
													@endif
												</select>
											</div>
											<div class="input-group col-xl-6">
												<label>Your Email:</label>
												<input type="text" placeholder="Email" name="email">
											</div>
											<div class="input-group col-xl-6">
												<label>Your Contact:</label>
												<input type="text" placeholder="Phone Number" class="contact" name="contact">
											</div>
											<div class="input-group col-xl-12">
												<label>Enter Subject:</label>
												<input type="text" placeholder="Subject" name="subject">
											</div>
											<div class="input-group col-xl-12">
												<label>Your Message:</label>
												<textarea placeholder="Enter Message" name="message"></textarea>
											</div>
											<div class="input-group col-xl-6 ml-auto">
												<button type="submit" class="btn btn-contact contactform">Send Message</button>
											</div>
										</form>
									</div>
								</div>
								<div class="container-fluid map-container" id="map-container">
									<div class="contact-strip">
										<div class="container">
											<div class="row align-items-center">
												<div class="col-4 col-md-3 col-lg-2 strip-icon">
													<i class="icon-library"></i>
												</div>
												<div class="col-8 col-md-9 col-lg-10 strip-detail">
													<h3>Why You Need the Top Lawyers</h3>
												</div>
											</div>
										</div>
									</div>
									@if(!empty($record->google_map))
										<div class="contact-map" id="contact-map">
											<input type="hidden" class="map__src" value="{{ $record->google_map }}">
											{{-- <iframe id="map-iframe" src="" width="600" height="450" frameborder="0" style="border:0;background:transparent url('{{ asset('compress/loader.svg') }}') no-repeat center center" allowfullscreen=""></iframe> --}}
										</div>
									@endif
								</div>
							</div>
						</main>
		      		</div>
		    	</div>
		  	</div>
			@include('front.layout.footer')
			<link rel="stylesheet" href="{{ asset('assets/style/chosen.css') }}">
			<script src="{{ asset('assets/js/chosen.js') }}"></script>
			<script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
			<script src="{{ asset('assets/js/validate.js') }}"></script>
			<script>
				function loadMap(){
					var img_path = '{{ asset('compress/loader.svg') }}';
					var src = $('#contact-map .map__src').val();
					$('#contact-map').html(src);
					$('#contact-map').css('{border:0,background:transparent url('+img_path+') no-repeat center center}')
				}
			</script>
			<script>
				$(".city-dropdown").chosen();
				$(".text").show();
				$(".icon-resp").show();
				$(window).scroll(function(e){
					if($(window).scrollTop() > $("#map-container").offset().top - 10){
						loadMap();
						$(this).off(e);
					}
				})
			</script>
			<script>
				$(document).ready(function(){
				    $('.contact').samask("0000-0000000");
				  	$('.contact').change(function(e){
				  		var new_val = $(this).val();
				  		var new_val = new_val.replace(/(\d{4})(\d{7})/, "$1-$2");
				  		$(this).val(new_val);
				  	})
				    _is_validate("#contactform", { name: { require: !0, max: 35 }, contact: { require: !0, }, email: { require: !0, email: !0 }, subject: { require: !0, min: 5, max: 100 }, message: { require: !0, min: 10, max: 5000 } }),
			        $(".contactform").click(function (e) {
			            e.preventDefault();
			            $(this).attr('disabled',true);
			            var rText = $(this).text();
			            var r = $(this);
			            $(this).text('Sending.....');
		                a = r.closest("form"),
		                t = r.closest("form").serializeArray();
			            r.attr("disabled", !0),
		                $.ajax({ headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }, type: "post", global: "false", datatype: "html", url: "/contactform", data: t })
		                    .done(function (e) {
					            $(this).attr('disabled',false);
					            r.text(rText),
								$('.city-dropdown').val('');
								$('.city-dropdown').chosen();
								$('.city-dropdown').trigger("chosen:updated");
		                        r.closest("form").trigger("reset"),
	                            r.closest("form").closest("div").find("img").remove(),
	                            r.closest("form").find(".dg-b-icon").remove(),
	                            r.attr("disabled", !1),
	                            $('.message-box').find('p').html(' Your message has been submitted.'),
	                            $(".message-box").fadeIn("slow"),
	                            $('.dg-b-success').removeClass();
	                            "undefined" != typeof grecaptcha && grecaptcha && grecaptcha.reset && grecaptcha.reset();
		                    })
		                    .fail(function (e) {
					            $(this).attr('disabled',false);
					            r.text(rText);
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
				})
			</script>
		</div>
	</body>
</html>