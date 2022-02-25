@if (!empty($check))
	@php
		$cabinet_data = (!empty($check->cabinet_team))?json_decode($check->cabinet_team):array();
	@endphp
@else
	@php
		$cabinet_data = array();
	@endphp
@endif
@php
	if(count($team) > 0){
		foreach ($team as $value) {
			if(strtolower(get_user_designation($value->society_designation)) == 'chairman'){
				$chairman_data = $value;
			}
		}
	}else{
		$chairman_data = array();
	}
@endphp
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
						<li><span>Cabinet Team</span></li>
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
					<style>.phone span{cursor: pointer;}</style>
					<main class="col-lg-9 cabinet-main">
                        <div id="our-team" class="team-section cabinet-column">
							<h3 class="rounded-top">Cabinet Chairman</h3>
							@if (!empty($cabinet_data))
								{!! $cabinet_data->description !!}
							@endif
                            <div class="" id="sectionOne">
	                            <div class="row">
									<div class="col-md-12">
										@if (!empty($chairman_data))
											@php
												$chairman_social = (!empty($chairman_data->social_link))?json_decode($chairman_data->social_link):[];
											@endphp
											<div class="head-column">
												<h3 class="text-center">Chairman APJEA {{ $check->name }}</h3>
												<div class="row align-items-center">
													<div class="col-md-4 col-lg-4 col-xl-5 image-col">
														<img src="{{ is_image($chairman_data->cover_img) }}" class="img-fluid" alt="chairman-image" width="100%" height="">
													</div>

													<div class="col-md-8 col-lg-8 col-xl-7 text-col">
														<div class="head-top text-center">
															<h4>{{ GetLoginUserName($chairman_data->name) }}</h4>
															<p class="text-green">{{ get_user_designation($chairman_data->society_designation)  }}</p>
														</div>
		                                                
		                                                <table class="head-table">
			                                                @if (!empty($chairman_data->blood))
			                                                    <tr>
			                                                        <td>
			                                                            <i class="icon-droplet"></i>
			                                                            <span>Blood Group. : </span>
			                                                        </td>
			                                                        <td>{{ $chairman_data->blood }}</td>
			                                                    </tr>
			                                                @endif
			                                                @if (!empty($chairman_data->official_designation))
			                                                    <tr>
			                                                        <td>
			                                                            <i class="icon-user"></i>
			                                                            <span>Designation: </span>
			                                                        </td>
			                                                        <td>{{ get_user_off_dsg($chairman_data->official_designation) }}</td>
			                                                    </tr>
			                                                @endif
			                                                @if (!empty($chairman_data->joining_date))
			                                                    <tr>
			                                                        <td>
			                                                            <i class="icon-alarm"></i>
			                                                            <span>Experience: </span>
			                                                        </td>
			                                                        {{-- <td>17 Years</td> --}}
			                                                        <td>{{ date('d/m/Y', strtotime($chairman_data->joining_date)) }}</td>
			                                                    </tr>
			                                                @endif
			                                                @if (!empty($chairman_data->email))
			                                                    <tr>
			                                                        <td>
			                                                            <i class="icon-envelope"></i> 
			                                                            <span>Email: </span>
			                                                        </td>
			                                                        <td>{{ $chairman_data->email }}</td>
			                                                    </tr>
			                                                @endif
			                                                @if (!empty($chairman_data->contact))
			                                                    <tr>
																	<td class="phone-inner" data-hide="">
																		<i class="icon-phone"></i>
																		<span>Contact: </span>
																	</td>
																	<td class="phone" data-hide=""><span>{{ $chairman_data->contact }}</span></td>
			                                                    </tr>
			                                                @endif
			                                                @if (!empty($chairman_data->address))
			                                                    <tr>
			                                                        <td>
			                                                            <i class="icon-location"></i>
			                                                            <span>Address: </span>
			                                                        </td>
			                                                        <td>{{ $chairman_data->address }}</td>
			                                                    </tr>
			                                                @endif
		                                                </table>
		                                                @if (!empty($chairman_social->fb_link) and !empty($chairman_social->tw_link) and !empty($chairman_social->ln_link) and !empty($chairman_social->ins_link))
															<h5 class="social-head">Social Platform</h5>
															<ul class="social-nav">
																@if (!empty($chairman_social->fb_link))
																	<li>
																		<a href="{{ $chairman_social->fb_link }}" rel="nofollow noopener" target="_blank"><i class="icon-facebook"></i>
																		</a>
																	</li>
																@endif
																@if (!empty($chairman_social->tw_link))
																	<li>
																		<a href="{{ $chairman_social->tw_link }}" rel="nofollow noopener" target="_blank"><i class="icon-twitter"></i>
																		</a>
																	</li>
																@endif
																@if (!empty($chairman_social->ln_link))
																	<li>
																		<a href="{{ $chairman_social->ln_link }}" rel="nofollow noopener" target="_blank"><i class="icon-linkedin2"></i>
																		</a>
																	</li>
																@endif
																@if (!empty($chairman_social->ins_link))
																	<li>
																		<a href="{{ $chairman_social->ins_link }}" rel="nofollow noopener" target="_blank"><i class="icon-instagram"></i>
																		</a>
																	</li>
																@endif
															</ul>
		                                                @endif
													</div>
												</div>
											</div>
										@endif
										@if (!empty($cabinet_data))
											<div class="head-column">
												<h3 class="text-center">{{ $cabinet_data->message_heading }}</h3>
												{!! $cabinet_data->message_body !!}
											</div>
										@endif
									</div>
								</div>
							</div>
							<div class="" id="sectionTwo">
								@if (count($team))
									{{-- {{ dd($team) }} --}}
									<h3 class="cab-top">{{ $check->name }} District Cabinet</h3>
									<p></p>
									<div class="row team-slider">
										@foreach ($team as $value)
											@php
												$social = (!empty($value->social_link))?json_decode($value->social_link):array();
											@endphp
											<div class="col-sm-6 col-md-4">
												<div class="team-column">
													<div class="team-image">
														<img src="{{ is_image($value->cover_img )}}" class="img-fluid" alt="{{ get_alt($value->cover_img) }}" width="100%" height="">
														<div class="team-overlay"></div>
														<ul class="team-nav">
															@if (!empty($social) and !empty($social->fb_link))
																<li>
																	<a href="{{ $social->fb_link }}" target="_blank">
																		<i class="icon-facebook"></i>
																	</a>
																</li>
															@endif
															@if (!empty($social) and !empty($social->tw_link))
																<li>
																	<a href="{{ $social->tw_link }}" target="_blank">
																		<i class="icon-twitter"></i>
																	</a>
																</li>
															@endif
															@if (!empty($social) and !empty($social->ln_link))
																<li>
																	<a href="{{ $social->ln_link }}" target="_blank">
																		<i class="icon-linkedin2"></i>
																	</a>
																</li>
															@endif
															@if (!empty($social) and !empty($social->ins_link))
																<li>
																	<a href="{{ $social->ins_link }}" target="_blank">
																		<i class="icon-instagram"></i>
																	</a>
																</li>
															@endif
														</ul>
													</div>
													<div class="team-bottom">
														<p>{{ get_user_designation($value->society_designation) }}</p>
														<h4>{{ GetLoginUserName($value->name) }}</h4>
													</div>
												</div>
											</div>
										@endforeach
		                            </div>
								@endif
							</div>
							<div class="" id="sectionThree">
								@if ($panel == 'cities' and count($tehsil_team))
									@php
										$all_tehsil = DB::table('tehsil')->where('dept_id',$check->id)->orderby('sort','asc')->get();
										$tehss = array();
										$order_ = array();
										if (count($all_tehsil) > 0) {
											foreach ($all_tehsil as $value) {
												$order_[] = $value->id;
											}
										}
										foreach ($tehsil_team as $value) {
											$tehss[] = $value->tehsil;
										}
										$tehss = array_unique($tehss);
										usort($tehss,function ($a, $b) use ($order_) {
										  $pos_a = array_search($a, $order_);
										  $pos_b = array_search($b, $order_);
										  return $pos_a - $pos_b;
										});
									@endphp
									@if (count($tehss) > 0)
										@foreach ($tehss as $tt)
											@php
												$teh_detail = $all_tehsil->where('id',$tt)->first();
												$teh_name = ($teh_detail) ? $teh_detail->name : "";
											@endphp
				                            <h3 class="cab-top">{{ $teh_name }} Tehsil Cabinet</h3>
											<p></p>
											<div class="row team-slider">
												@foreach ($tehsil_team as $value)
													@if ($value->tehsil == $tt)
													@php
														$social = (!empty($value->social_link))?json_decode($value->social_link):array();
													@endphp
													<div class="col-sm-6 col-md-4">
														<div class="team-column">
															<div class="team-image">
																<img src="{{ is_image($value->cover_img )}}" class="img-fluid" alt="team-member" width="100%" height="">
																<div class="team-overlay"></div>
																<ul class="team-nav">
																	@if (!empty($social) and !empty($social->fb_link))
																		<li>
																			<a href="{{ $social->fb_link }}" target="_blank">
																				<i class="icon-facebook"></i>
																			</a>
																		</li>
																	@endif
																	@if (!empty($social) and !empty($social->tw_link))
																		<li>
																			<a href="{{ $social->tw_link }}" target="_blank">
																				<i class="icon-twitter"></i>
																			</a>
																		</li>
																	@endif
																	@if (!empty($social) and !empty($social->ln_link))
																		<li>
																			<a href="{{ $social->ln_link }}" target="_blank">
																				<i class="icon-linkedin2"></i>
																			</a>
																		</li>
																	@endif
																	@if (!empty($social) and !empty($social->ins_link))
																		<li>
																			<a href="{{ $social->ins_link }}" target="_blank">
																				<i class="icon-instagram"></i>
																			</a>
																		</li>
																	@endif
																</ul>
															</div>
															<div class="team-bottom">
																<p>{{ get_user_designation($value->society_designation) }}</p>
																<h4>{{ GetLoginUserName($value->name) }}</h4>
															</div>
														</div>
													</div>
														{{-- expr --}}
													@endif
												@endforeach
				                            </div>
											{{-- expr --}}
										@endforeach
										{{-- expr --}}
									@endif
								@endif
							</div>
                        </div>
                     </main>
                  </div>
              </div>
          </div>
		@include('front.layout.footer')
	</div>
<div class="message-box2 login-box" style="display: none;">
  <div class="message-content">
    <h3 class="message-head">Login Required <span class="close">&times;</span></h3>
    <div class="message-text">
      <div class="icon">
        <i class="icon-info"></i>
      </div>
      <p></p>
    </div>
    <button class="btn-login">Login</button>
  </div>
</div>
	@if (!isset(auth('login')->user()->cnic))
		<script>
			var auth_user = false;
		</script>
	@else
		<script>
			var auth_user = true;
		</script>
	@endif
    <script>
		$(".team-column").hover(function(){
			$(this).find(".team-nav").addClass("fade");
		},function(){
			$(".team-column").find(".team-nav").removeClass("fade");
		});
		$("td.phone").each(function(){
			var phone = $(this).find('span').text();
			$(this).attr("data-hide",phone);
			var star  = phone.replace(phone,"********");
			$(this).find('span').text(star);
		});
		$("td.phone span").click(function(){
			if(auth_user == true){
				var phone = $(this).closest("td.phone").attr("data-hide");
				$(this).text(phone);
			}else{
				$(".message-box2").find('p').html('Please Login to View Contact No.');
				$(".message-box2").fadeIn("slow");
			}
		});
		$('.btn-login').click(function(){
	        window.location.href = "{{ route('login') }}";
		});
		$('.close').click(function(){
			$(".message-box2").fadeOut("slow");

		})
    </script>
</body>
</html>   