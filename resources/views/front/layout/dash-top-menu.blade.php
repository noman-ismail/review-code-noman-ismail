 <!-- Top navigation bar -->
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
                
                <div class="col-7 col-sm-6 col-md-4 col-lg-6 d-flex rlist-col justify-content-end align-items-center">
                    <div class="d-flex">
                        <ul class="dashtp-nav">
                            @php
                                $___userName = unslash( auth('login')->user()->name );
                                $short____userName = ( strlen( $___userName ) > 20 ) ? substr( $___userName, 0, 22 ) . "...": $___userName;
                            @endphp
                            <li><a href="{{ route('user-dashboard') }}"><i class="icon-user"></i>&nbsp;{{ $___userName }}</a></li>
                            <script>
                                
                                if ($(window).width() < 474) {
                                    $('.dashtp-nav li a').html('<i class="icon-user"></i>&nbsp;{{ $short____userName }}');
                                }else{
                                    $('.dashtp-nav li a').html('<i class="icon-user"></i>&nbsp;{{ $___userName }}');
                                }
                                $(window).resize(function(){
                                    var w = $(window).width();
                                    if (w < 474) {
                                        $('.dashtp-nav li a').html('<i class="icon-user"></i>&nbsp;{{ $short____userName }}');
                                    }else{
                                        $('.dashtp-nav li a').html('<i class="icon-user"></i>&nbsp;{{ $___userName }}');
                                    }
                                });
                            </script>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>