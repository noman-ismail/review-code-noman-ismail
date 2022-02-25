<div class="logo-line">
     @php
         $rec = DB::table("generalsettings")->first();
    @endphp
    <div class="container">
        <div class="row align-items-center">
            <div class="col-8 col-sm-8 col-md-6 col-lg-6">
                <a href="{{ route('base_url') }}" class="site_logo">
                     @if ($rec->logo !="")
                    <img src="{{ $rec->logo  }}" class="img-fluid" width="300" height="58" alt="All Pakistan Judicial Employees Association">
                    @endif
                </a>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 remove-site-mobile text-right">
                <a  class="site_ayat">
                    <img src="{{ asset('assets/compress/ayat.png') }}" class="img-fluid" alt="site-ayat">
                </a>
            </div>
            @php
                if(!isset($segment)){
                    $segment = "";
                }
            @endphp

            <!-- Main Navigation Bar -->

            <div class="col-4 col-sm-4 col-md-4 col-lg-12">
                <button class="btn-toggle" type="button"><i class="icon-bars"></i></button>
            </div>
            <div class="col-12 col-sm-12 col-md-12 main-nav">
                <div class="nav-container">
                    <div class="sticky-container">
                        <ul class="main-menu">
                            <li class="logo">
                                @if ($rec->favicon !="")
                                <a href="{{ route('base_url') }}">
                                    <img src="{{ $rec->favicon }}" class="img-fluid" alt="All Pakistan Judicial Employees Association">
                                </a>
                                @endif
                            </li>
                            <li class="main {{ ($segment == "")?"active":"" }}">
                                <a href="{{ route('base_url') }}"><i class="icon-home"></i></a>
                            </li>
                            <li class="{{ ($segment == "about")?"active":"" }}"><a href="{{ route('about_us') }}">About Us</a></li>
                            <li class="topli-visible-md {{ ($segment == "welfare")?"active":"" }}" ><a href="{{ route('wellfare_benefits') }}">Welfare Benefits</a></li>

                            <li class="dropdown {{ ($segment == "cabinet")?"active":"" }}">
                                <a href="#">Cabinets <i class="icon-chevron-down"></i>
                                    <span class="icon-md">
                                        <i class="icon-plus"></i>
                                    </span>
                                </a>
                                @php
                                    $__record = DB::table('province')->orderby('name','asc')->get();
                                    $__record2 = DB::table('cities')->orderby('name','asc')->get();
                                @endphp
                                <ul class="dropdown-content">
                                    <li>
                                        <a href="{{ route('base_url').'/pakistan' }}">Pakistan Cabinet</a>
                                    </li>
                                    @if (count($__record) > 0)
                                        @foreach ($__record as $val)
                                            <li>
                                                <a href="{{ route('base_url').'/'.strtolower($val->slug) }}">{{ $val->name }} Cabinet</a>
                                            </li>
                                        @endforeach
                                    @endif
                                    <li><a href="{{ route('district-cabinet') }}">District Cabinet</a></li>
                                </ul>
                            </li>

                            <li class="{{ ($segment == "events")?"active":"" }}"><a href="{{ route('events') }}">Events</a></li>
                            <li class="{{ ($segment == "jobs")?"active":"" }}"><a href="{{ route('jobs') }}">Jobs</a></li>
                            <li class="{{ ($segment == "news")?"active":"" }}"><a href="{{ route('news') }}">News & Updates</a></li>
                            <li class="topli-visible-lg {{ ($segment == 'notification')?"active":"" }}">
                                <a href="{{ route('govt-notifications') }}">Govt. Notifications</a>
                            </li>
                            <li class="topli-visible-lg {{ ($segment == "imp-document")?"active":"" }}">
                                <a href="{{ route('imp-document') }}">Important Docs</a>
                            </li>
                            <li class="topli-visible-md {{ ($segment == "blog")?"active":"" }}"><a href="{{ route('blogs') }}">Blog</a></li>
                            <li class="{{ ($segment == "contact")?"active":"" }}"><a href="{{ route('contact-us') }}">Contact Us</a></li>
                             <li class="dropdown dropdown-more {{ ($segment == "blog"||$segment == "imp-document"||$segment == "notification"||$segment == "welfare")?"active":"" }}">
                                <a href="#">More <i class="icon-chevron-down"></i>
                                    <span class="icon-md">
                                        <i class="icon-plus"></i>
                                    </span> 
                                </a>
                                <ul class="dropdown-content">
                                    <li>
                                        <a href="{{ route('wellfare_benefits') }}">Welfare Benefits</a>
                                    </li>
                                    <li><a href="{{ route('govt-notifications') }}">Govt. Notifications</a>
                                    </li>
                                    <li><a href="{{ route('imp-document') }}">Important Docs</a>
                                    </li>
                                    <li><a href="{{ route('blogs') }}">Blog</a></li>
                                </ul>
                            </li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>