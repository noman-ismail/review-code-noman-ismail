@include('front.layout.header')
<link rel="stylesheet" href="{{asset('assets/style/all.content.css') }}">
</head>
<body>
    <div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu')
        <header class="title-header main-header">
            <div class="container">
                <div class="header-text">
                    <h1 class="header-title">Privacy Policy</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('base_url') }}">Home</a></li>
                        <li><a href="{{ route('base_url') }}/privacy-policy">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </header>
        
        <main class="main-content content-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-xl-9 article-column">
                        <h3 class="rounded-top">Privacy Policy</h3>
                        @php
                        $content = ($data["content"] !="" ) ? $data["content"]: "";
                        @endphp
                        {!! $content !!}
                    </div>
                    
                    @include('front.sidebar.common')
                </div>
            </div>
        </main>
        @php
            $row = DB::table("privacies")->select('views')->first();
            refresh_views($row->views , 0 , 0 , get_postid('full'));
        @endphp
        @include('front.layout.footer')
    </div>
</body>
</html>