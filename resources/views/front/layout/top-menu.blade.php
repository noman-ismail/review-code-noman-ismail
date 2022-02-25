<!-- Top navigation bar -->
@if (isset(auth('login')->user()->cnic))
    @include('front.layout.dash-top-menu')
@else
    <div class="topnav">
        <div class="container">
            <div class="row topnav-row">
                <div class="col-5 col-sm-6 col-md-8 col-lg-6 llist-col">
                    <div class="d-flex align-items-center w-100">
                        <ul class="left-menu">
                            <li class="green-block"><a href="{{ route('pension_view') }}">Pension Calculator</a></li>
                            <li class="purple-block"><a href="#">Pension Paper</a></li>
                            <li class="cadetblue-block"><a href="#">GP Fund Calculator</a></li>
                        </ul>
                        <ul class="mobile-menu">
                            <li class="calc-item"><a href="#">Pension Calculations</a>
                                <div class="mobile-dropdown">
                                    <ul>
                                        <li><a href="{{ route('pension_view') }}">Pension Calculator</a></li>
                                        <li><a href="#">Pension Paper</a></li>
                                        <li><a href="#">GP Fund Calculator</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-7 col-sm-6 col-md-4 col-lg-6 rlist-col">
                    <div class="d-flex">
                        <ul class="top-pages">
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif



