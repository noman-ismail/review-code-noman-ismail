@php
$_username = Auth::user()->username;
$user = DB::table('admin')->where('username',$_username)->first();
if($user){
  if($user->type != "district"){
    $url = route('base_url').'/'.admin.'/404';
    echo "<script>
    window.location = '$url';
    </script>";
  }
}else{
  request()->session()->flush();
  $url = route('base_url').'/404';
  echo "<script>
  window.location = '$url';
  </script>";
}
$segment2 = Request::segment(2);
@endphp
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Apjea Admin Pannel">
    <meta name="author" content="dgaps">
    <meta name="robots" content="noindex, nofollow">
    <title>APJEA - {{ get_DeptName($user->dept_id , 'district') }} Pannel</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset("admin-assets/dist/img/favicon.png")}}">
    <!--Global Styles(used by all pages)-->
    <link href="{{ asset("admin-assets/plugins/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{ asset("admin-assets/plugins/metisMenu/metisMenu.min.css")}}" rel="stylesheet">
    <link href="{{ asset("admin-assets/plugins/fontawesome/css/all.min.css")}}" rel="stylesheet">
    <link href="{{ asset("admin-assets/plugins/typicons/src/typicons.min.css")}}" rel="stylesheet">
    <link href="{{ asset('assets/style/icomoon.css') }}" rel="stylesheet">
    <!--Third party Styles(used by this page)-->
    <!--Start Your Custom Style Now-->
    @if (Request::segment(2)=='faqs' || ( Request::segment(2)=='blogs' and Request::segment(3)=='category'))
    <!-- JQuery UI -->
    <link href="{{ asset("admin-assets/plugins/jquery-ui-1.12.1/jquery-ui.css")}}" rel="stylesheet">
    @endif
    @if (Request::segment(2)=='services')
    <!-- JQuery UI -->
    <link href="{{ asset("admin-assets/plugins/bootstrap4-toggle/css/bootstrap4-toggle.min.css")}}" rel="stylesheet">
    @endif
    <link href="{{ asset("admin-assets/dist/css/style.css")}}" rel="stylesheet">
    <link href="{{ asset("admin-assets/dist/css/custom.css")}}" rel="stylesheet">
    {{-- For Only Blog page --}}
    <link href="{{ asset("admin-assets/plugins/icheck/skins/all.css")}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset("admin-assets/dist/js/jquery.min.js")}}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    var base_url = '{{ route('base_url') }}';
    var baseURL = "{{route('base_url')}}/{{admin}}/";
    var _token = '{{ csrf_token() }}';
    var seg2 = "{{Request::segment(2)}}";
    var seg3 = "{{Request::segment(3)}}";
    var admin = '/{{ admin }}';
    </script>
  </head>
<body class="fixed">
        {{-- <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div> --}}
<div class="wrapper">
<!-- Sidebar  -->
<nav class="sidebar sidebar-bunker">
  <div class="profile-element d-flex align-items-center flex-shrink-0">
    <div class="avatar online"> <img src="{{ asset("admin-assets/dist/img/avatar-3.jpg")}}" class="img-fluid rounded-circle" alt=""> </div>
    <div class="profile-text">
      <h6 class="m-0">{{Auth::user()->username}}</h6>
      <span><a class="text-white" href="{{ route('base_url') }}" target="_blank" >View Website</a></span> </div>
    </div>
    <!--/.profile element-->
    
    <div class="sidebar-body">
      <nav class="sidebar-nav">
        <ul class="metismenu">
          <li class="nav-label">{{ get_DeptName($user->dept_id , 'district') }} Panel</li>
          <li class="{{ (Request::segment(2) == 'district-dashboard')?"mm-active":"" }}">
            <a href="{{ route('district-dashboard') }}"> <i class="typcn typcn-home-outline mr-2"></i> Dashboard
            </a>
          </li>
          <li>
            <a class="has-arrow material-ripple" href="#">
              <i class="typcn typcn-ticket mr-2"></i> District CMS
            </a>
            <ul class="nav-second-level">
              <li class="{{ (Request::segment(2) == 'about-cabinet'||Request::segment(2) == 'about-cabinet-meta')?"mm-active":"" }}">
                <a href="{{ route('about-cabinet') }}">About Cabinet</a>
              </li>
              <li class="{{ (Request::segment(2) == 'cabinet-team'||Request::segment(2) == 'cabinet-team-meta')?"mm-active":"" }}">
                <a href="{{ route('cabinet-content') }}">Cabinet Team</a>
              </li>
              <li class="{{ (Request::segment(2) == 'cabinet' && Request::segment(3) == 'members-meta')?"mm-active":"" }}">
                <a href="{{ route('district-members-meta') }}">Apjea Members</a>
              </li>
              <li class="{{ (Request::segment(2)=='news'||(Request::segment(2)=='cabinet' &&  Request::segment(3)=='news-meta'))?"mm-active":"" }}">
                <a href="{{ route('news-list') }}">News and Updates</a>
              </li>
              <li class="{{ (Request::segment(2)=='event'||(Request::segment(2)=='cabinet'&&Request::segment(3)=='events-meta'))?"mm-active":"" }}">
                <a href="{{ route('event') }}">Event</a>
              </li>
              <li class="{{ (Request::segment(2) == 'jobs' || (Request::segment(3) == 'jobs-meta' and Request::segment(2) == 'cabinet'))?"mm-active":"" }}">
                <a href="{{ route('job-list') }}">Jobs</a>
              </li>
              <li class="{{ (Request::segment(2) == 'contact')?"mm-active":"" }}">
                <a href="{{ route("contact-page")}}">Contact Us</a>
              </li>
            </ul>
          </li>
          @php
            $pending_users = DB::table('users')->where(['status'=>'pending','district'=>auth('admin')->user()->dept_id])->count();
          @endphp
          <li class="{{ (Request::segment(2) == 'user-list')?"mm-active":"" }}">
            <a href="{{ route('user-list') }}"> 
              <i class="typcn typcn-group-outline mr-2"></i> Users 
              @if ($pending_users > 0)
                <span class="badge badge-warning" style="margin-left:5%">{{ $pending_users }}</span>
              @endif
            </a>
          </li>
          <li >
            <a href="#" class="has-arrow material-ripple"> <i class="typcn typcn-calculator mr-2"></i> Budget Stats</a>
            <ul class="nav-second-level">
              <li class="{{ (Request::segment(2) == 'add-budget')?"mm-active":"" }}">
                <a href="{{ route('add-budget') }}">New Budget Request</a>
              </li>
              <li class="{{ (Request::segment(2) == 'budget-list')?"mm-active":"" }}">
                <a href="{{ route('budget-list') }}">Budget List</a>
              </li>
            </ul>
          </li>
          <li>
            <a class="has-arrow material-ripple" href="#">
              <i class="typcn typcn-arrow-loop mr-2"></i> Funds
            </a>
            <ul class="nav-second-level">
              <li class="{{ (Request::segment(2) == 'fund-collector')?"mm-active":"" }}">
                <a href="{{ route('fund-collector') }}">Add Fund Collector</a>
              </li>
              <li class="{{ (Request::segment(2) == 'collect-payment')?"mm-active":"" }}">
                <a href="{{ route('collect-payment') }}">Payment From FC</a>
              </li>
              <li class="{{ (Request::segment(2) == 'ledger')?"mm-active":"" }}">
                <a href="{{ route('ledger') }}">FC Ledger</a>
              </li>
              <li class="{{ (Request::segment(2) == 'fund-history' || Request::segment(2) == 'funds')?"mm-active":"" }}">
                <a href="{{ route('fund-history') }}">Funds from Users</a>
              </li>
              <li class="{{ (Request::segment(2) == 'transfer-to-province' || Request::segment(2) == 'transfer-payment')?"mm-active":"" }}">
                <a href="{{ route('transfer-to-province') }}">Transfer to Province</a>
              </li>
              <li class="{{ (Request::segment(2) == 'district-ledger')?"mm-active":"" }}">
                <a href="{{ route('district-ledger') }}">District Ledger</a>
              </li>
            </ul>
          </li>
          <li class="{{ (Request::segment(2) == 'death-claim-list' || Request::segment(2) == 'death-claim')?"mm-active":"" }}">
            <a href="{{ route('death-claim-list') }}"> <i class="typcn typcn-edit mr-2"></i> Death Claim
            </a>
          </li>
          <li class="{{ (Request::segment(2) == 'expense-sheet' || Request::segment(2) == 'add-expense')?"mm-active":"" }}">
            <a href="{{ route('expense-sheet') }}"> <i class="typcn typcn-clipboard mr-2"></i> Expense Sheet
            </a>
          </li>
          <li>
            <a class="has-arrow material-ripple" href="#">
              <i class="typcn typcn-document-text mr-2"></i> Reports
            </a>
            <ul class="nav-second-level">
              <li class="{{ (Request::segment(2) == 'fund-history-report')?"mm-active":"" }}">
                <a href="{{ route('fund-history-report') }}">Fund From User</a>
              </li>
              <li class="{{ (Request::segment(2) == 'fc-ledger-report')?"mm-active":"" }}">
                <a href="{{ route('fc-ledger-report') }}">FC Ledger Report</a>
              </li>
              <li class="{{ (Request::segment(2) == 'district-ledger-report')?"mm-active":"" }}">
                <a href="{{ route('district-ledger-report') }}">District Ledger Report</a>
              </li>
              <li class="{{ (Request::segment(2) == 'death-report')?"mm-active":"" }}">
                <a href="#" data-toggle="modal" data-target=".Death_Modal">Death Claim Report</a>
              </li>
              <li class="{{ (Request::segment(2) == 'expense-report')?"mm-active":"" }}">
                <a href="#" data-toggle="modal" data-target=".Expense_Modal">Expense Sheet Report</a>
              </li>
            </ul>
          </li>
          <li>
            <a class="has-arrow material-ripple" href="#">
              <i class="typcn typcn-cog-outline mr-2"></i> Settings
            </a>
            <ul class="nav-second-level">
              <li class="{{ (Request::segment(2) == 'tehsil-list')?"mm-active":"" }}">
                <a href="{{ route('tehsil') }}">Tehsil List</a>
              </li>
              <li class="{{ (Request::segment(2) == 'district-login-update')?"mm-active":"" }}">
                <a href="{{ route('district-login-update') }}">Update Login</a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
    <!-- sidebar-body -->
    
  </nav>
  <!-- Page Content  -->
  <div class="content-wrapper">
    <div class="main-content">
      <nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
        <div class="sidebar-toggle-icon" id="sidebarCollapse"> sidebar toggle<span></span> </div>
        <!--/.sidebar toggle icon-->
        <div class="d-flex flex-grow-1">
          <ul class="navbar-nav flex-row align-items-center ml-auto">
            <li class="nav-item dropdown user-menu"> <a class="nav-link {{-- dropdown-toggle --}}" href="{{ route("base_url") }}/{{ admin }}/logout" {{-- data-toggle="dropdown" --}} title="Log Out"> <span class="typcn typcn-export-outline"></span>
          </a>
        </li>
      </ul>
      <!--/.navbar nav-->
      
    </div>
  </nav>
  <!--/.navbar-->