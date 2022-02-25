@php
    $_username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$_username)->first();
    if($user){
        if($user->type != "admin"){
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
        <title>Admin - APJEA</title>
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
            var baseURL = "{{route('base_url')}}/{{admin}}/";
            var admin = "/{{admin}}";
            base_url = "{{route('base_url')}}";
        </script>
        <style>
            #sort{
              cursor: grab;
            }
            .sort-tr{
                background: #f3f3f4;
                border-left: 6px solid #e7eaec;
                border-right: 6px solid #e7eaec;
                border-radius: 4px;
                color: inherit;
                margin-bottom: 2px;
                padding: 10px;
            }
        </style>
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
                <h6 class="m-0">{{Auth::user()->username}}</h6>
                <span><a class="text-white" href="{{ route('base_url') }}" target="_blank" >View Website</a></span>
            </div>
            </div><!--/.profile element-->
            <!--                <form class="search sidebar-form" action="#" method="get" >
                <div class="search__inner">
                    <input type="text" class="search__text" placeholder="Search...">
                    <i class="typcn typcn-zoom-outline search__helper" data-sa-action="search-close"></i>
                </div>
            </form>/.search-->
            <div class="sidebar-body">
                <nav class="sidebar-nav">
                    <ul class="metismenu">
                        <li class="nav-label">Main Menu</li>
                        <li>
                          <a href="#" class="has-arrow material-ripple">
                            <i class="typcn typcn-home-outline mr-2"></i>
                            Dashboard 
                          </a>
                          <ul class="nav-second-level">
                            <li class="{{ Request::segment(2)=='dashboard' ? 'mm-active' : '' }}">
                                <a href="{{ route('admin-dashboard') }}">Dashbaod</a>
                            </li>
                            <li class="{{ Request::segment(2)=='stats-dashboard' ? 'mm-active' : '' }}">
                                <a href="{{ route('stats-dashboard') }}">Stats Dashboard</a>
                            </li>
                          </ul>
                        </li>
                        {{-- <li class="{{ Request::segment(2)=='dashboard' ? 'mm-active' : '' }}">
                            <a href="{{url('/'.admin.'/dashboard')}}"><i class="typcn typcn-home-outline mr-2"></i> Dashboard</a>
                        </li> --}}
                        @php
                          $segment2 = Request::segment(2);
                        @endphp

                        <li>
                          <a href="#" class="has-arrow material-ripple">
                            <i class="typcn typcn-flag mr-2"></i>
                            National Panel
                          </a>
                          <ul class="nav-second-level">
                            <li class="{{ ($segment2 == 'add-national-user')?"mm-active":"" }}">
                                <a href="{{ route('add-n-user') }}">Add User</a>
                            </li>
                            <li class="{{ ($segment2 == 'national-user-list')?"mm-active":"" }}">
                                <a href="{{ route('national-u-list') }}">User List</a>
                            </li>
                          </ul>
                        </li>
                        <li>
                          <a href="#" class="has-arrow material-ripple">
                            <i class="fa fa-landmark mr-2"></i>
                            Province Panel
                          </a>
                          <ul class="nav-second-level">
                            <li class="{{ ($segment2 == 'add-province-user')?"mm-active":"" }}">
                                <a href="{{ route('add-p-user') }}">Add User</a>
                            </li>
                            <li class="{{ ($segment2 == 'province-user-list')?"mm-active":"" }}">
                                <a href="{{ route('province-u-list') }}">User List</a>
                            </li>
                          </ul>
                        </li>
                        <li>
                          <a href="#" class="has-arrow material-ripple">
                            <i class="far fa-building mr-2"></i>
                            District Panel
                          </a>
                          <ul class="nav-second-level">
                            <li class="{{ ($segment2 == 'add-district-user')?"mm-active":"" }}">
                                <a href="{{ route('add-d-user') }}">Add User</a>
                            </li>
                            <li class="{{ ($segment2 == 'district-user-list')?"mm-active":"" }}">
                                <a href="{{ route('district-u-list') }}">User List</a>
                            </li>
                          </ul>
                        </li>
                        <li class="{{ Request::segment(2)=='contact' || Request::segment(2)=='terms-condition' || Request::segment(2)=='privacy-policy' || Request::segment(2)=='faqs'  ? 'mm-active' : '' }}">
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn typcn-tabs-outline mr-2"></i>
                                CMS
                            </a>
                            <ul class="nav-second-level">
                                <li class="{{ Request::segment(2)=='homepage' ? 'mm-active' : '' }}">
                                    <a href="{{url('/'.admin.'/homepage')}}"> Home Page</a>
                                </li>
                                <li class="{{ Request::segment(2)=='about' ? 'mm-active' : '' }}">
                                    <a href="{{url('/'.admin.'/about')}}"> About Us</a>
                                </li>
                                <li class="{{ (Request::segment(2) == 'welfare-benefits')?"mm-active":"" }}">
                                    <a href="{{ route('welfare-benefits') }}">Welfare Benefits</a>
                                </li>
                                <li class="{{ (Request::segment(2) == 'notifications-meta')?"mm-active":"" }}">
                                    <a href="{{ route('notifications-meta') }}">Notifications Meta</a>
                                </li>
                                 <li class="{{ (Request::segment(2) == 'documents-meta')?"mm-active":"" }}">
                                    <a href="{{ route('documents-meta') }}">Documents Meta</a>
                                </li>
                                <li class="{{ (Request::segment(2) == 'district-cabinet')?"mm-active":"" }}">
                                    <a href="{{ route('district-cabinet-setting') }}">
                                        District Cabinet
                                    </a>
                                </li>
                                <li class="{{ (Request::segment(2) == 'official-brands')?"mm-active":"" }}">
                                    <a href="{{ route('official-brands') }}">Official Brands</a>
                                </li>
                                <li class="{{ (Request::segment(2) == 'footer')?"mm-active":"" }}">
                                    <a href="{{ route('footer') }}">Footer</a>
                                </li>
                                <li class="{{ Request::segment(2)=='contact' ? 'mm-active' : '' }}">
                                    <a href="{{ url('/'.admin.'/contact')}}">Contact</a>
                                </li>
								<li class="{{ (Request::segment(2) == 'faqs')?"mm-active":"" }}">
                                    <a href="{{ route('faqs') }}">FAQs</a>
                                </li>
								<li class="{{ (Request::segment(2) == 'terms-condition')?"mm-active":"" }}">
                                    <a href="{{ route('terms') }}">Terms Condition</a>
                                </li>
								<li class="{{ (Request::segment(2) == 'privacy-policy')?"mm-active":"" }}">
                                    <a href="{{ route('privacy') }}">Privacy</a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ (Request::segment(2) == 'event'||Request::segment(2) == 'event-meta')?"mm-active":"" }}">
                            <a href="{{ route('event') }}">
                                <i class="typcn typcn typcn-anchor mr-2"></i>Event
                            </a>
                        </li>
                        <li class="{{ Request::segment(2)=='blogs'  ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="typcn typcn-device-desktop mr-2"></i>
                            Blogs
                        </a>
                        <ul class="nav-second-level">
                            <li class="{{ Request::segment(2)=='authors' || ( Request::segment(2)=='authors' && Request::segment(3)=='list' )  ? 'mm-active' : '' }}"><a href="{{url('/'.admin.'/authors')}}" >Add Authors</a></li>
                            <li class="{{ Request::segment(2)=='blogs' && Request::segment(3)=='' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/blogs')}}">Add New Blog</a></li>
                            <li class="{{ Request::segment(3)=='list' && Request::segment(2)=='blogs' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/blogs/list')}}">Blogs List</a></li>
                            <li class="{{ Request::segment(2)=='ads' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/ads')}}">Ads</a></li>
                        </ul>
                        </li> 
                            <li class="{{ (Request::segment(2) == 'user-list')?"mm-active":"" }}">
                            <a href="{{ route('user-list') }}"> <i class="typcn typcn-group-outline mr-2"></i> Users
                            </a>
                        </li>
                        <li class="{{ (Request::segment(2) == 'cabinets'||Request::segment(2) == 'add-cabinets')?"mm-active":"" }}">
                            <a href="{{ route('cabinets') }}"><i class="typcn typcn-user mr-2"></i> Cabinet Members</a>
                        </li>
                        <li class="{{ (Request::segment(2) == 'jobs' || Request::segment(2) == 'jobs-meta')?"mm-active":"" }}">
                            <a href="{{ route('job-list') }}">
                                <i class="typcn typcn-mortar-board mr-2"></i> Jobs
                            </a>
                        </li>
                        <li class="{{ (Request::segment(2) == 'download' || Request::segment(2) == 'downloads')?"mm-active":"" }}">
                            <a href="{{ route('download-list') }}">
                                <i class="typcn typcn-arrow-down-thick mr-2"></i>Notifications / Downloads
                            </a>
                        </li> 
                        <li class="{{ (Request::segment(2) == 'news' || Request::segment(2) == 'news-meta')?"mm-active":"" }}">
                            <a href="{{ route('news-list') }}">
                                <i class="typcn typcn-news mr-2"></i>News
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn typcn-calculator mr-2"></i>
                                Calculators
                            </a>
                            <ul class="nav-second-level">
                                <li class="{{ (Request::segment(2) == 'pension-calculator'||Request::segment(2) == 'pension-calculator-meta')?"mm-active":"" }}">
                                    <a href="{{ route('pension-calculator') }}">Pension Calculator</a>
                                </li>
                                <li class="{{ (Request::segment(2) == 'pension-paper'||Request::segment(2) == 'pension-paper-meta')?"mm-active":"" }}">
                                    <a href="{{ route('pension-paper') }}">Pension Paper</a>
                                </li>
                                <li class="{{ (Request::segment(2) == 'gp-fund'||Request::segment(2) == 'gp-fund-meta')?"mm-active":"" }}">
                                    <a href="{{ route('gp-fund') }}">GP Fund Calculator</a>
                                </li>
                            </ul>
                        </li>
                         <li class="{{ Request::segment(2)=='sidebar-settings' ? 'mm-active' : '' }}">
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn icon typcn-th-menu-outline mr-2"></i>
                                Sidebar Settings
                            </a>
                            <ul class="nav-second-level">
                                <li class="{{ Request::segment(2)=='sidebar-settings?pg=welfare-benefits' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/sidebar-settings?pg=welfare-benefits')}}">Wellfare Benefits</a></li>
                                <li class="{{ Request::segment(2)=='sidebar-settings?pg=district' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/sidebar-settings?pg=district')}}">District</a></li>
                                <li class="{{ Request::segment(2)=='sidebar-settings?pg=blog' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/sidebar-settings?pg=blog')}}">Blog Detail</a></li>
                                 <li class="{{ Request::segment(2)=='sidebar-settings?pg=news' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/sidebar-settings?pg=news')}}">News Detail</a></li>
                               
                                <li class="{{ Request::segment(2)=='sidebar-settings?pg=privacy-policy' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/sidebar-settings?pg=privacy-policy')}}">Privacy Policy</a></li>
                                <li class="{{ Request::segment(2)=='sidebar-settings?pg=terms-conditions' ? 'mm-active' : '' }}"><a href="{{ url('/'.admin.'/sidebar-settings?pg=terms-conditions')}}">Terms & Conditions</a></li>
                            </ul>
                        </li> 
                        <li class="{{ (Request::segment(2) == 'icons')?"mm-active":"" }}">
                            <a href="{{ route('icons') }}">
                                <i class="typcn typcn-news mr-2"></i>Icons
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn typcn typcn-cog mr-2"></i>
                                Settings
                            </a>
                            <ul class="nav-second-level">
                                {{-- <li class="{{ Request::segment(2)=='log-book' ? 'mm-active' : '' }}"><a href="{{url('/'.admin.'/log-book')}}">Log Book</a></li> --}}
                                <li class="{{ (Request::segment(2) == 'fund-periods')?"mm-active":"" }}">
                                    <a href="{{ route('fund-periods') }}">Funds Period</a>
                                </li>
								<li class="{{ Request::segment(2)=='general-setting' ? 'mm-active' : '' }}"><a href="{{url('/'.admin.'/general-setting')}}">General Setting</a></li>
                                <li class="{{ Request::segment(2)=='sms-setting' ? 'mm-active' : '' }}">
                                    <a href="{{ route('sms-setting') }}">SMS Setting</a>
                                </li>
                                <li class="{{ Request::segment(2)=='email-setting' ? 'mm-active' : '' }}">
                                    <a href="{{ route('email-setting') }}">Email Setting</a>
                                </li>
                                <li class="{{ ($segment2 == 'society-designations')?"mm-active":"" }}">
                                    <a href="{{ route('society_dsg') }}">Society Designations</a>
                                </li>
                                <li class="{{ ($segment2 == 'official-designations')?"mm-active":"" }}">
                                    <a href="{{ route('ofc_dsg') }}">Official Designations</a>
                                </li>
                                <li class="{{ ($segment2 == 'city-list')?"mm-active":"" }}">
                                    <a href="{{ route('cities') }}">City Settings</a>
                                </li>
                                <li class="{{ ($segment2 == 'province')?"mm-active":"" }}">
                                    <a href="{{ route('province') }}">Province Setting</a>
                                </li>
                                <li class="{{ Request::segment(2)=='update-login' ? 'mm-active' : '' }}">
                                  <a href="{{ route('login-update') }}">Login Setting</a>
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