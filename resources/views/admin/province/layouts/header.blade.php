@php
    $_username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$_username)->first();
    if($user){
        if($user->type != "province"){
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
        <title>APJEA - {{ get_DeptName($user->dept_id , 'province') }} Panel</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset("admin-assets/dist/img/favicon.png")}}">
        <!--Global Styles(used by all pages)-->
        <link href="{{ asset("admin-assets/plugins/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/metisMenu/metisMenu.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/fontawesome/css/all.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/typicons/src/typicons.min.css")}}" rel="stylesheet">
        <link href="{{ asset('assets/style/icomoon.css') }}" rel="stylesheet">
        <link href="{{ asset("admin-assets/dist/css/style.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/dist/css/custom.css")}}" rel="stylesheet">
        <link href="{{ asset('assets/style/icomoon.css') }}" rel="stylesheet">
        {{-- For Only Blog page --}}
        <link href="{{ asset("admin-assets/plugins/icheck/skins/all.css")}}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset("admin-assets/dist/js/jquery.min.js")}}"></script>
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
        <div class="page-loader-wrapper">
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
        </div>
<div class="wrapper">
    <!-- Sidebar  -->
    <nav class="sidebar sidebar-bunker">
        <div class="profile-element d-flex align-items-center flex-shrink-0">
            <div class="avatar online">
                <img src="{{ asset("admin-assets/dist/img/avatar-3.jpg")}}" class="img-fluid rounded-circle" alt="">
            </div>
            <div class="profile-text">
                <h6 class="m-0">{{ Auth::user()->username }}</h6>
                <span><a class="text-white" href="{{ route('base_url') }}" target="_blank" >View Website</a></span>
            </div>
            </div>
            <!--/.profile element-->
            <!--                <form class="search sidebar-form" action="#" method="get" >
                <div class="search__inner">
                    <input type="text" class="search__text" placeholder="Search...">
                    <i class="typcn typcn-zoom-outline search__helper" data-sa-action="search-close"></i>
                </div>
            </form>/.search-->
            <div class="sidebar-body">
                <nav class="sidebar-nav">
                        <ul class="metismenu">
                            <li class="nav-label">{{ get_DeptName($user->dept_id , 'province') }} Panel</li>
                            <li class="{{ (Request::segment(2) == 'province-dashboard')?"mm-active":"" }}">
                                <a href="{{ route('province-dashboard') }}">
                                    <i class="typcn typcn-home-outline mr-2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="has-arrow material-ripple" href="#">
                                    <i class="typcn typcn-flow-merge mr-2"></i>
                                    Province CMS
                                </a>
                                <ul class="nav-second-level">
                                    <li class="{{ (Request::segment(2) == 'about-cabinet'||Request::segment(2) == 'about-cabinet-meta')?"mm-active":"" }}">
                                        <a href="{{ route('about-cabinet') }}">About Cabinet</a>
                                    </li>
                                    <li class="{{ (Request::segment(2) == 'cabinet-team'||Request::segment(2) == 'cabinet-team-meta')?"mm-active":"" }}">
                                        <a href="{{ route('cabinet-content') }}">Cabinet Team</a>
                                    </li>
                                    <li class="{{ (Request::segment(2)=='news'||(Request::segment(2)=='cabinet'&&Request::segment(3)=='news-meta'))?"mm-active":"" }}">
                                        <a href="{{ route('news-list') }}">News and Updates</a>
                                    </li>
                                    <li class="{{ (Request::segment(2) == 'jobs')?"mm-active":"" }}">
                                        <a href="{{ route('job-list') }}">Jobs</a>
                                    </li>
                                    <li class="{{ (Request::segment(2) == 'event'||(Request::segment(2)=='cabinet'&&Request::segment(3)=='events-meta'))?"mm-active":"" }}">
                                        <a href="{{ route('event') }}">Event</a>
                                    </li>
                                    <li class="{{ (Request::segment(2) == 'download' || Request::segment(2) == 'downloads' || Request::segment(3) == 'notifications-meta')?"mm-active":"" }}">
                                        <a href="{{ route('download-list') }}">Notifications / Downloads</a>
                                    </li> 
                                    <li class="{{ Request::segment(2)=='blogs'  ? 'mm-active' : '' }}">
                                        <a class="has-arrow material-ripple" href="#">
                                            Blogs
                                        </a>
                                        <ul class="nav-third-level">
                                            <li class="{{ Request::segment(2)=='authors' || ( Request::segment(2)=='authors' && Request::segment(3)=='list' ) ? 'mm-active' : '' }}"><a href="{{url('/'.admin.'/authors')}}" >Add Authors</a></li>
                                            <li class="{{ Request::segment(2)=='blogs' && Request::segment(3)=='' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/blogs')}}">Add New Blog</a></li>
                                            <li class="{{ Request::segment(3)=='list' && Request::segment(2)=='blogs' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/blogs/list')}}">Blogs List</a></li>
                                        </ul>
                                    </li>
                                    <li class="{{ Request::segment(2)=='contact' ? 'mm-active' : '' }}">
                                        <a href="{{ url('/'.admin.'/contact')}}">
                                            Contact
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ (Request::segment(2) == 'cabinets' || Request::segment(2) == 'add-cabinets')?"mm-active":"" }}">
                                <a href="{{ route('cabinets') }}"><i class="typcn typcn-user mr-2"></i>Cabinet Members</a>
                            </li>
                            @php
                                $budgte_reqst = DB::table('budget_list')->where(['status'=>'pending','budget_type'=>'request','reqst_to'=>auth('admin')->user()->dept_id])->count();
                            @endphp
                            <li>
                                <a class="has-arrow material-ripple" href="#">
                                    <i class="typcn typcn-calculator mr-2"></i>
                                    Budget
                                    @if ($budgte_reqst > 0)
                                        <span class="badge badge-warning" style="margin-left:5%">{{ $budgte_reqst }}</span>
                                    {{-- expr --}}
                                    @endif
                                </a>
                                <ul class="nav-second-level">
                                    <li class="{{ (Request::segment(2) == 'add-budget')?"mm-active":"" }}">
                                        <a href="{{ route('add-budget') }}">New Budget Request</a>
                                    </li>
                                    <li class="{{ (Request::segment(2) == 'budget-list')?"mm-active":"" }}">
                                        <a href="{{ route('budget-list') }}">Budget List</a>
                                    </li>
                                    {{-- <li class="{{ (Request::segment(2) == 'budget-stat')?"mm-active":"" }}">
                                        <a href="{{ route('budget-stat') }}">
                                            Budget Stat
                                        </a>
                                    </li> --}}
                                    <li class="{{ (Request::segment(2) == 'budget-distribution' || Request::segment(2) == 'budget-allocate')?"mm-active":"" }}">
                                        <a href="{{ route('budget-distribution') }}">
                                            Budget Distribution
                                        </a>
                                    </li>
                                    <li class="{{ (Request::segment(2) == 'budget-request')?"mm-active":"" }}">
                                        <a href="{{ route('budget-request') }}">
                                            Budget Requests
                                            @if ($budgte_reqst > 0)
                                                <span class="badge badge-warning" style="margin-left:5%">{{ $budgte_reqst }}</span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @php
                                $fund_reqst = DB::table('district_ledger')->where(['status'=>'Deliver','ledger'=>'-','province'=>auth('admin')->user()->dept_id])->count();
                            @endphp
                            <li class="{{ (Request::segment(2) == 'fund-request')?"mm-active":"" }}">
                                <a href="{{ route('fund-request') }}">
                                    <i class="fas fa-dollar-sign mr-2" style="font-size: 18px;margin-left: 8px;width: 15px;"></i> Fund Request
                                    @if ($fund_reqst > 0)
                                        <span class="badge badge-warning" style="margin-left:5%">{{ $fund_reqst }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="{{ (Request::segment(2) == 'user-list')?"mm-active":"" }}">
                                <a href="{{ route('user-list') }}"> <i class="typcn typcn-group-outline mr-2"></i> Users </a>
                            </li>
                            <li class="{{ (Request::segment(2) == 'death-claim-requests')?"mm-active":"" }}">
                                <a href="{{ route('death-claim-requests') }}">
                                    <i class="typcn typcn-edit mr-2"></i> Death Claim
                                </a>
                            </li>
                            <li class="{{ (Request::segment(2) == 'expense-sheet' || Request::segment(2) == 'add-expense')?"mm-active":"" }}">
                                <a href="{{ route('expense-sheet') }}">
                                    <i class="typcn typcn-clipboard mr-2"></i> Expense Sheet
                                </a>
                            </li>
                            <li>
                                <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-document-text mr-2"></i> Reports
                                </a>
                                <ul class="nav-second-level">
                                  <li class="{{ (Request::segment(2) == 'budget-distribution-report')?"mm-active":"" }}">
                                    <a href="#" data-toggle="modal" data-target=".Distribution_Modal">Budget Allocation Report</a>
                                  </li>
                                  <li class="{{ (Request::segment(2) == 'budget-request-report')?"mm-active":"" }}">
                                    <a href="#" data-toggle="modal" data-target=".Budget_Modal">Budget Request Report</a>
                                  </li>
                                  <li class="{{ (Request::segment(2) == 'fund-request-report')?"mm-active":"" }}">
                                    <a href="#" data-toggle="modal" data-target=".Fund_Modal">Fund Request Report</a>
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
                                    <i class="typcn typcn-cog-outline mr-2"></i>
                                    Settings
                                </a>
                                <ul class="nav-second-level">
                                    <li class="{{ (Request::segment(2) == 'province-login-update')?"mm-active":"" }}">
                                        <a href="{{ route('province-login-update') }}">Update Login</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                </nav>
                </div><!-- sidebar-body -->
                
            </nav>
            <!-- Page Content  -->
            <div class="content-wrapper">
                <div class="main-content">
                    <nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
                        <div class="sidebar-toggle-icon" id="sidebarCollapse">
                            sidebar toggle<span></span>
                            </div><!--/.sidebar toggle icon-->
                            <div class="d-flex flex-grow-1">
                                <ul class="navbar-nav flex-row align-items-center ml-auto">
                                    <li class="nav-item dropdown user-menu">
                                        <a class="nav-link {{-- dropdown-toggle --}}" href="{{ route("base_url") }}/{{ admin }}/logout" {{-- data-toggle="dropdown" --}} title="Log Out">
                                            <!--<img src="assets/dist/img/user2-160x160.png" alt="">-->
                                            <span class="typcn typcn-export-outline"></span>
                                        </a>
                                        <!--        <div class="dropdown-menu dropdown-menu-right" >
                                            <div class="dropdown-header d-sm-none">
                                                <a href="#" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                                            </div>
                                            <div class="user-header">
                                                <div class="img-user">
                                                    <img src="{{ asset("admin-assets/dist/img/avatar-1.jpg")}}" alt="">
                                                </div>img-user
                                                <h6>Ghulam Abbas</h6>
                                                <span><a href="">dgaps.com@gmail.com</a></span>
                                            </div>user-header
                                            <a href="#" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                                            <a href="#" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                                            <a href="#" class="dropdown-item"><i class="typcn typcn-arrow-shuffle"></i> Activity Logs</a>
                                            <a href="#" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
                                            <a href="page-signin.html" class="dropdown-item"><i class="typcn typcn-key-outline"></i> Sign Out</a>
                                            --><!--/.dropdown-menu -->
                                        </li>
                                        </ul><!--/.navbar nav-->
                                        
                                    </div>
                                    </nav><!--/.navbar-->