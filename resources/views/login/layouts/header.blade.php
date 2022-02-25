@include('front.layout.header')

        @if ( (Request::segment(1) == 'login' or Request::segment(1) == 'register') and Request::segment(2) == 'dashboard')
            <title>{{ Auth::user()->name }} - Dashboard - APJEA</title>
        @elseif( (Request::segment(1) == 'login' or Request::segment(1) == 'register') and Request::segment(2) == 'personal-information' )
            <title>{{ Auth::user()->name }} - Personal Information - APJEA</title>
        @elseif( (Request::segment(1) == 'login' or Request::segment(1) == 'register') and Request::segment(2) == 'nominee-information' )
            <title>{{ Auth::user()->name }} - Nominee Information - APJEA</title>
        @endif
        @if ( (Request::segment(1) == 'login' or Request::segment(1) == 'register') and (Request::segment(2) == 'dashboard' or Request::segment(2) == 'personal-information' or Request::segment(2) == 'nominee-information' or Request::segment(2) == 'family-information' or Request::segment(2) == 'account-setting') or Request::segment(2) == 'add-funds' or Request::segment(2) == 'funds-history' or Request::segment(2) == 'amount-history')
            <link rel="stylesheet" href="{{ asset('assets/style/all.dashboard.css') }}"/>
        @else
            <link rel="stylesheet" href="{{ asset('assets/style/all.content.css') }}"/>
        @endif
        @if(Request::segment(1) == 'login' and Request::segment(2) == 'personal-information')
            <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
            <script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
        @endif
        <script>
            var baseURL = "{{route('base_url')}}/login/";
            var admin = "/login";
            base_url = "{{route('base_url')}}";
            var _token ="{{csrf_token()}}";
        </script>
</head>
<body>
    <div class="wrapper">
    @include('front.layout.dash-top-menu')
    @include('front.layout.main-menu')