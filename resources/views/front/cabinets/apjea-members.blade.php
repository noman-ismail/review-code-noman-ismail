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
					<li><span>APJEA Members</span></li>
				</ul>
			</div>
		</div>
	</header>
	
	<div class="main-content cabinet-content" id="main-body">
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
					<div id="apjea-team" class="team-section cabinet-column">
						<h3 class="rounded-top">APJEA Members</h3>
						<div class="list-box" style="background:transparent;box-shadow:none;">
							<div class="list-detail" style="margin-top:0px">
								<form class="row search-row">
									<div class="col-md-12">
										<div class="input-group">
											<i class="icon-search"></i>
											<input type="text" class="form-control" placeholder="Search by Name, Desig, B.Group" name='search' value="{{ request('search') }}">
											<button type="submit" class="btn btn-search">Search</button>
										</div>
									</div>
								</form>
								
								<table cellspacing="0" class="apjea-table">
									@if (count($record) > 0)
										@php 
											$i = 1;
											$collection = collect(json_decode(json_encode($detail))); 
											// dd($collection);
										@endphp
										<tr>
											<th>Sr.</th>
											<th>Full Name</th>
											<th>Desig.</th>
											<th>Contact No</th>
											<th>B.Group</th>
										</tr>
										@foreach ($record as $key => $value)
											@php
												$collect = $collection->where('user_id',$value->id)->first();
												$social = (!empty($collect) and !empty($collect->social_links))?json_decode($collect->social_links):array();
											@endphp
											<tr>
												<td>{{ $i = 1 + $key }}</td>
												<td title="Click to View Profile">{{ $value->name }}</td>
												<td>{{ $value->designation }}</td>
												<td class="phone" data-hide=""><span>{{ $value->contact }}</span></td>
												<td>{{ (!empty($collect)) ? $collect->blood_group : "" }}</td>
											</tr>
											<tr class="profile-tr">
												<td colspan="6">
													<div class ="head-column">
														<div class="row align-items-center">
															<div class="col-md-4 col-lg-4 col-xl-5 image-col">
																<img src="{{ (!empty($collect)) ? get_post_mid($collect->img) : get_post_mid("") }}" class="img-fluid" alt="head-image">
															</div>
															<div class="col-md-8 col-lg-8 col-xl-7 text-col">
																<div class="head-top text-center">
																	<h4>{{ $value->name }}</h4>
																	<p class="text-green">{{ (!empty($value->designation)) ? $value->designation : "" }}</p>
																</div>
																<table class="head-table">
																	@if (!empty($collect) and !empty($collect->blood_group))
																		<tr>
																			<td><i class="icon-droplet"></i>
																				<span>Blood Group: </span>
																			</td>
																			<td>{{ (!empty($collect)) ? $collect->blood_group : "" }}</td>
																		</tr>
																		{{-- expr --}}
																	@endif
																	@if ($value->designation)
																		<tr>
																			<td>
																				<i class="icon-user"></i>
																				<span>Designation: </span>
																			</td>
																			<td>{{ $value->designation }}</td>
																		</tr>
																	@endif
																	@if (!empty($collect) and !empty($collect->appointment))
																		<tr>
																			<td>
																				<i class="icon-alarm"></i>
																				<span>Experience: </span>
																			</td>
																			<td>{{ (!empty($collect))?calculate_year($collect->appointment) : "" }} Years</td>
																		</tr>
																	@endif
																	@if (!empty($value->email))
																		<tr>
																			<td>
																				<i class="icon-envelope"></i>
																				<span>Email: </span>
																			</td>
																			<td>{{ $value->email }}</td>
																		</tr>
																	@endif
																	@if (!empty($value->contact))
																		<tr>
																			<td class="phone-inner" data-hide="">
																				<i class="icon-phone"></i>
																				<span>Contact: </span>
																			</td>
																			<td class="phone" data-hide=""><span>{{ $value->contact }}</span></td>
																		</tr>
																	@endif
																	@if (!empty($collect) and !empty($collect->address))
																		<tr>
																			<td>
																				<i class="icon-location"></i>
																				<span>Address: </span>
																			</td>
																			<td>{{ $collect->address }}</td>
																		</tr>
																	@endif
																</table>
																@if (!empty($social))
																	<div class="social-icons">
																		@if (!empty($social->fb_link))
																			<a href="{{ $social->fb_link }}" target="_blank"><i class="icon-facebook"></i></a>
																		@endif
																		@if (!empty($social->tw_link))
																			<a href="{{ $social->tw_link }}" target="_blank"><i class="icon-twitter"></i></a>
																		@endif
																		@if (!empty($social->linkedin_link))
																			<a href="{{ $social->linkedin_link }}" target="_blank"><i class="icon-linkedin2"></i></a>
																		@endif
																		@if (!empty($social->insta_link))
																			<a href="{{ $social->insta_link }}" target="_blank"><i class="icon-instagram"></i></a>
																		@endif
																	</div>
																	{{-- expr --}}
																@endif
															</div>
														</div>
													</div>
												</td>
											</tr>
										@endforeach
									@endif
								</table>
							</div>
						</div>
					</div>
					<!-- <hr class="hr-green"/> -->
				</main>
			</div>
		</div>
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
	@include('front.layout.footer')
	@if (request()->has('search'))
	  <script>
	        $([document.documentElement, document.body]).animate({
	            scrollTop: $("#main-body").offset().top - 120
	        }, 1000);
	  </script>
	@endif
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
		$(".message-box2").hide();
		$(".srch-toggle").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".apjea-table tr:not(.profile-tr)").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		});
		$("tr.profile-tr").hide();
$(".apjea-table tr>td:nth-child(2)").click(function(e){
if($(e.target).parents('.profile-tr').length > 0){
return false;
}
else{
$("tr.profile-tr").hide();
if($(this).closest("tr").next("tr.profile-tr").hasClass("visible")){
$(this).closest("tr").next("tr.profile-tr").hide(800);
$(this).closest("tr").next("tr.profile-tr").removeClass("visible");
}
else{
$(this).closest("tr").next("tr.profile-tr").show(800);
$(this).closest("tr").next("tr.profile-tr").addClass("visible");
}
}
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
	})

		if ($(window).width() < 470) {
			$('input[name="search"]').attr('placeholder','Search Record');
		}else{
			$('input[name="search"]').attr('placeholder','Search by Name, Desig, B.Group');
		}
		$(window).resize(function(){
		    var w = $(window).width();
		    if (w < 470){
				$('input[name="search"]').attr('placeholder','Search Record');
			}else{
				$('input[name="search"]').attr('placeholder','Search by Name, Desig, B.Group');
			}
		});
	</script>
</div>
</body>
</html>