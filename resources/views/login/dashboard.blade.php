@include('login.layouts.header')
{{-- <header class="title-header main-header">
	<div class="container">
		<div class="header-text">
			<h1 class="header-title">Dashboard</h1>
			<ul class="breadcrumb">
				<li><a href="{{ route('user-dashboard') }}">Home</a></li>
				<li><span>Dashboard</span></li>
			</ul>
		</div>
	</div>
</header> --}}
<main class="dashboard-section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-3">
				<div class="dash-aside">
					@include('login.layouts.sidebar')
				</div>
			</div>
			<div class="col-md-12 col-lg-9 dash-main">
        <div class="row dashboxes">
          <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4">
            <div class="dash-box">
              <div class="dash-flex">
                <div class="dash-icon bg-grdgreen">
                  <i class="icon-coin-dollar"></i>
                </div>
                <div class="dash-detail">
                  <h3>Amount History</h3>
                  <p>{{ $amount_history['amount'] }}</p>
                </div>
              </div>
              {{-- @if (!empty($amount_history['date'])) --}}
	              <div class="dash-bottom">
	                <p>Last Updated:  {{ (!empty($amount_history['date'])) ? $amount_history['date'] : "" }}</p>
	              </div>
              	{{-- expr --}}
              {{-- @endif --}}
            </div>
          </div>
          @if (!empty($c_users) and !empty($c_users->collector) and $c_users->collector == 'yes')
	          <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4">
	            <div class="dash-box">
	              <div class="dash-flex">
	                <div class="dash-icon bg-grdorange">
	                  <i class="icon-money"></i>
	                </div>
	                <div class="dash-detail">
	                  {{-- <h3></h3> --}}
	                  <style>
	                  	.first_row{
	                  		display: flex;
	                  		justify-content: flex-end;;
	                  	}
	                  	.span_numb{
	                  		width: 40px;
	                  	}
	                  </style>
	                  <div style="font-size:12px;font-weight: 500;height:81px"> 
	                  	<div class="first_row">
	                  	<div class="span_nme" >Total Collection:</div> 
	                  	<div class="span_numb">{{ $fund_history['collection'] }} </div>
	                    </div>
	                 	<div class="first_row">   
	                  	<div class="span_nme" >Total Transferred:</div>
	                  	<div class="span_numb"> {{ $fund_history['collection']-$fund_history['remaining'] }}</div> 
	                  	 </div>
						<div class="first_row">
	                  	<div class="span_nme" >Total Remaining:</div>
	                  	<div class="span_numb"> {{ $fund_history['remaining'] }}</div>
	                  	</div>
	                  </div>
	                </div>
	              </div>
	              <div class="dash-bottom">
	                <p>Last Updated: {{ $fund_history['collected_date'] }} </p>
	              </div>
	            </div>
	          </div>
	          {{-- <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mx-auto">
	            <div class="dash-box lastbox">
	              <div class="dash-flex">
	                <div class="dash-icon bg-grdred">
	                  <i class="icon-briefcase"></i>
	                </div>
	                <div class="dash-detail">
	                  <h3>Total Remaining</h3>
	                  <p>{{ $fund_history['remaining'] }}</p>
	                </div>
	              </div>
	              <div class="dash-bottom">
	                <p>Last Updated: {{ $fund_history['remaining_date'] }} </p>
	              </div>
	            </div>
	          </div> --}}
          @endif
          <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mx-auto end_div">
	          @php
	          	$l_history = (!empty($c_users->last_login)) ? json_decode($c_users->last_login , true) : "";
	          	$key = (!empty($l_history)) ? count($l_history) : 0;
	          	if ($key > 1) {
	          		$key = $key-2;
	          	}elseif($key == 1){
	          		$key = $key - 1;
	          	}
	          	// $key = ($key > 1) ? $key-2 : $key;
	          	// dd([$l_history,$key]);
	          @endphp
            <div class="dash-box lastbox">
              <div class="dash-flex">
                <div class="dash-icon bg-grdred">
                  <i class="icon-briefcase"></i>
                </div>
                <div class="dash-detail">
                  <h3>Login Detail</h3>
                  {{-- <p>{{ $fund_history['remaining'] }}</p> --}}
                  <p>&nbsp;</p>
                </div>
              </div>
              <div class="dash-bottom">
                <p style="">Last Login: {{ (!empty($l_history)) ? $l_history[$key] : "" }} </p>
              </div>
            </div>
          </div>
        </div>
        @if (count($news) > 0)
		      <div class="row listboxes">
		        <div class="col-lg-12 col-xl-12">
		          <div class="isLoading" id="sectionOne">
		            <div class="list-box">
		              <div class="list-head bg-grdgreen">
		                <h3>Latest News</h3>
		              </div>
		              <div class="list-detail notif-list">
		              	@foreach ($news as $value)
		              		@php
					          $title = unslash( $value->title );
					          $short_title = ( strlen( $title ) > 40 ) ? substr( $title, 0, 75 ) . "...": $title;
					          $content = trim(trim_words( html_entity_decode($value->content), 25 ));
					          $content = clean_short_code(html_entity_decode($content));
					          $url = route('base_url')."/".$value->slug."-5".$value->id;
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


		              			$date = (!empty($value->date)) ? date('d' , strtotime($value->date)) : "" ;
		              			$month = (!empty($value->date)) ? date('M' , strtotime($value->date)) : "" ;
		              		@endphp
			                <div class="col-lg-12">
			                  <div class="dash-box {{ $class }}">
			                    <div class="dash-flex">
			                      <div class="dash-icon {{ $color }}">
			                      	{!! $icon !!}
			                      </div>
			                      @if (!empty($date) and $month)
				                      <div class="dash-date">
				                        <h4 style="">{{ $date }} <span>{{ $month }}</span></h4>
				                      </div>
			                      @endif
			                      <div class="dash-detail">
			                        <h3><a href="{{ $url }}">{{ $short_title }}</a></h3>
			                        <p>{{ $content }}</p>
			                      </div>
			                    </div>
			                  </div>
			                </div>
		              	@endforeach
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
		@else
			<div class="row listboxes">
				<div class="col-lg-12 col-xl-12">
					<div class="isLoading" id="sectionOne">
						<div class="list-box">
							<div class="list-head bg-grdgreen">
								<h3>Latest News</h3>
							</div>
							<div class="list-detail notif-list text-center">
								<h3>There is no record</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
        @endif
			</div>
		</div>
	</div>
</main>
	<script>
		$(".nt-dropdown span.toggle").click(function(){
			$(".nt-dropdown-content").slideToggle(500);
		});
		if ($(window).width() > 767) {
			$('.end_div').removeClass('mx-auto');
		}else{
			$('.end_div').addClass('mx-auto');
		}
		$(window).resize(function(){
		    var w = $(window).width();
			if (w > 767) {
				$('.end_div').removeClass('mx-auto');
			}else{
				$('.end_div').addClass('mx-auto');
			}
		});
	</script>
@include('login.layouts.footer')