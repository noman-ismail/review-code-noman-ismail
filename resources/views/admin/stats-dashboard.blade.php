@include( 'admin.layout.header' )
<style>
	.card-header{
		padding: 6px !important;
	}
	.card-footer{
		padding: 0.75rem 0.5rem !important;
	}
	.card-stats .card-header+.card-footer {
		margin-top: 10px !important;
	}
  .card-header .card-icon {
    margin-left: 10px !important;
  }
</style>

@php
  $_provinces = DB::table('province')->get();
  $t_dist = 0; $t_users = 0; $t_province = count($_provinces); $appr_users = 0;
  $collected_fund = get_collected_fund();
  // $consumed_bdg = find_consumed_bdg();
  $total_allocated = DB::table('budget_list')->where([
      'year' => date('Y'),
      'budget_type' => 'allocate',
  ])->sum('amount');
  $total_used = DB::table('budget_list')->where([
      'year' => date('Y'),
      'budget_type' => 'request',
      'status' => 'delivered',
  ])->sum('amount');
  $total_pending = DB::table('budget_list')->where([
      'year' => date('Y'),
      'budget_type' => 'request',
  ])->where('status','!=','delivered')->where('status','!=','reject')->sum('amount');
  $total_remaining = $total_allocated - $total_used - $total_pending;
  // dd([
  //   'collected_fund' => $collected_fund,
  //   'remaining_allocated' => $remaining_allocated,
  //   'consumed_bdg' => $consumed_bdg,
  //   'pending_bdg' => $pending_bdg,
  // ]);
@endphp
@if ($t_province > 0)
  @foreach ($_provinces as $key => $value)
    @php
      $ap_users = DB::table('users')->where(['province'=>$value->id,'status'=>'approved'])->count();
      $appr_users += $ap_users;
      $total_users = DB::table('users')->where(['province'=>$value->id])->count();
      $cities = DB::table('cities')->where('province',$value->id)->count();
      $t_dist += $cities;
      $t_users += $total_users;
    @endphp
  @endforeach
@endif
<div class="body-content">
  <div class="row">
    {{-- <div class="col-xl-5 col-lg-3 col-md-3 col-sm-6">
      <div class="card card-stats statistic-box mb-4">
        <div class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center">
            <i class="typcn typcn-clipboard"></i>
          </div>
          <div class="row">
            <div class="col-md-4">
              <p class="card-category text-uppercase fs-10 font-weight-bold text-muted pt-2">Provinces</p>
              <h3 class="card-title fs-18 font-weight-bold text-center mt-2">{{ $t_province }}</h3>
            </div>
            <div class="col-md-4">xl
              <p class="card-category text-uppercase fs-10 font-weight-bold text-muted pt-2">Districts</p>
              <h3 class="card-title fs-18 font-weight-bold text-center mt-2">{{ $t_dist }}</h3>
            </div>
            <div class="col-md-4">
              <p class="card-category text-uppercase fs-10 font-weight-bold text-muted pt-2">Total Users</p>
              <h3 class="card-title fs-18 font-weight-bold text-center mt-2">{{ $appr_users }}/{{ $t_users }}</h3>
            </div>
          </div>
        </div>
        <div class="card-footer p-3">
          <div class="stats">
            <a href="#" class="warning-link">Province</a>
          </div>
        </div>
      </div>
    </div> --}}
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
      <div class="card card-stats statistic-box province-card __card" style="cursor:pointer">
        <div class="card-header card-header-info card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fa fa-landmark"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Provinces</p>
          <h3 class="card-title fs-18 font-weight-bold">{{ $t_province }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Total Provinces </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
      <div class="card card-stats statistic-box district-card __card" style="cursor:pointer">
        <div class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out far fa-building"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Districts</p>
          <h3 class="card-title fs-18 font-weight-bold">{{ $t_dist }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Total Districts </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
      <div class="card card-stats statistic-box users-card __card" style="cursor:pointer">
        <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fas fa-users"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Users</p>
          <h3 class="card-title fs-21 font-weight-bold">{{ $appr_users.' / '.$t_users }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> APJEA Members </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
      <div class="card card-stats statistic-box fund-card __card" style="cursor:pointer">
        <div class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fa fa-retweet"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Collected Fund</p>
          {{-- <h3 class="card-title fs-21 font-weight-bold">{{number_format('50000') }}</h3> --}}
          <h3 class="card-title fs-21 font-weight-bold">{{number_format($collected_fund) }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Collected Funds by All Provinces </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
      <div class="card card-stats statistic-box available-budget-card __card" style="cursor:pointer">
        <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fa fa-fax"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Available Budget</p>
          {{-- <h3 class="card-title fs-21 font-weight-bold">{{number_format('20000') }}</h3> --}}
          <h3 class="card-title fs-21 font-weight-bold">{{number_format($collected_fund - $total_allocated) }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Saving of APJEA </div>
        </div>
      </div>
    </div>    
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
      <div class="card card-stats statistic-box allocate-budget-card __card" style="cursor:pointer">
        <div class="card-header card-header-info card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fa fa-binoculars"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Allocated Budget</p>
          {{-- <h3 class="card-title fs-21 font-weight-bold">{{number_format('30000') }}</h3> --}}
          <h3 class="card-title fs-21 font-weight-bold">{{number_format($total_allocated) }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Allocated Budget </div>
        </div>
      </div>
    </div>    
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
      <div class="card card-stats statistic-box used-budget-card __card" style="cursor:pointer">
        <div class="card-header card-header-danger card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fas fa-coins"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Used Budget</p>
          {{-- <h3 class="card-title fs-21 font-weight-bold">{{number_format('20000') }}</h3> --}}
          <h3 class="card-title fs-21 font-weight-bold">{{number_format($total_used) }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Total Used Budget </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
      <div class="card card-stats statistic-box pending-budget-card __card" style="cursor:pointer">
        <div class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fa fa-credit-card __card"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Pending Budget</p>
          {{-- <h3 class="card-title fs-21 font-weight-bold">{{number_format('10000') }}</h3> --}}
          <h3 class="card-title fs-21 font-weight-bold">{{number_format($total_pending) }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Pending Budget </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
      <div class="card card-stats statistic-box remaining-budget-card __card" style="cursor:pointer">
        <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fa fa-columns __card"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Remaining Budget</p>
          {{-- <h3 class="card-title fs-21 font-weight-bold">{{number_format('10000') }}</h3> --}}
          <h3 class="card-title fs-21 font-weight-bold">{{number_format($total_remaining) }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Remaining Budget </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row details-section card-detail">
  </div>
  <div class="row card-second-detail mt-3">
  </div>
  <br>
  <br>
</div>
<!--/.body content--> 
<script>
  $(document).ready(function(){
    $('.__card').click(function(){
      $('.card-second-detail').html('');
    })
    $('.fund-card').click(function(){
      $('.card-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'funds-detail',
          _token:_token,
        },success:function(res){
          $('.card-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
        },error:function(error){
          alert(error);
        }
      })
    });
    $('.remaining-budget-card').click(function(){
      $('.card-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'remaining-bdg',
          _token:_token,
        },success:function(res){
          $('.card-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
        },error:function(error){
          alert(error);
        }
      })
    });
    $('.pending-budget-card').click(function(){
      $('.card-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'pending-bdg',
          _token:_token,
        },success:function(res){
          $('.card-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
        },error:function(error){
          alert(error);
        }
      })
    });
    $('.used-budget-card').click(function(){
      $('.card-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'used-bdg',
          _token:_token,
        },success:function(res){
          $('.card-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
        },error:function(error){
          alert(error);
        }
      })
    });
    $('.allocate-budget-card').click(function(){
      $('.card-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'allocated-bdg',
          _token:_token,
        },success:function(res){
          $('.card-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
        },error:function(error){
          alert(error);
        }
      })
    });
    $('.available-budget-card').click(function(){
      $('.card-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'available-bdg',
          _token:_token,
        },success:function(res){
          $('.card-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
        },error:function(error){
          alert(error);
        }
      })
    });
    $('.district-card').click(function(){
      $('.card-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'districts',
          _token:_token,
        },success:function(res){
          $('.card-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
        },error:function(error){
          alert(error);
        }
      })
    });
    $('.users-card').click(function(){
      $('.card-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'users',
          _token:_token,
        },success:function(res){
          $('.card-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
        },error:function(error){
          alert(error);
        }
      })
    });
    $('.province-card').click(function(){
      $('.card-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'province',
          _token:_token,
        },success:function(res){
          $('.card-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
          $('.single-province').click(function(){
            $('.card-second-detail').addClass('text-center').css({'font-size':'140px','margin-top':'125px','margin-left':'500px'}).html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
            single_province($(this));
          })
        },error:function(error){
          alert(error);
        }
      })
    });
    function single_province(selector){
      var id = selector.attr('data-id');
      $.ajax({
        url: '{{ route('stats-dashboard') }}',
        method: 'post',
        dataType: 'html',
        data:{
          action:'single-province',
          id:id,
          _token:_token,
        },success:function(res){
          $('.card-second-detail').removeClass('text-center').css({'font-size':'inherit','margin-top':'-10px','margin-left':'-10px'}).html(res);
        },error:function(error){
          alert(error);
        }
      })
    }
  })
</script>
@include('admin.layout.footer')