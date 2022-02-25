@include('front.layout.header')
<link rel="stylesheet" href="{{asset('assets/style/all.content.css') }}">
</head>
<body>
<div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu',['segment'=>'news'])
  <header class="title-header main-header">
    <div class="container">
      <div class="header-text">
        <h1 class="header-title">News & Updates</h1>
        <ul class="breadcrumb">
          <li><a href="{{ route('base_url') }}">Home</a></li>
          <li><span>News & Updates</span></li>
        </ul>
      </div>
    </div>
  </header>
  <main class="main-section">
    <div class="container">
      <h2 class="text-success faqs-head">News & Updates</h2>
      <div class="row dashboxes">
        @foreach ($data as $k => $v)
        @php
          $title = unslash( $v->title );
          $short_title = ( strlen( $title ) > 40 ) ? substr( $title, 0, 75 ) . "...": $title;
          $content = trim(trim_words( html_entity_decode($v->content), 25 ));
          $content = clean_short_code(html_entity_decode($content));
          $image = $v->cover;
          $url = route('base_url')."/".$v->slug."-5".$v->id;
        if($v->category == "green"){
          $class = "dash-success";
          $color = "bg-grdgreen";
          $icon  =  "<i class='icon-check_circle_outline'></i>";
        }elseif($v->category == "orange"){
          $class = "dash-warn";
          $color = "bg-grdorange";
          $icon  =  "<i class='icon-info'></i>";
        }elseif($v->category == "blue"){
          $class = "dash-info";
          $color = "bg-info";
          $icon  =  "<i class='icon-info'></i>";
        }elseif($v->category == "red"){
          $class = "dash-error";
          $color = "bg-grdred";
          $icon  =  "<i class='icon-cancel-circle'></i>";
        }else{
          $class = "";
          $color = "";
          $icon = "";
        }
        @endphp
        <div class="col-lg-6">
          <div class="dash-box {{ $class }}">
            <div class="dash-flex">
              <div class="dash-icon {{ $color }}"> {!! $icon !!} </div>
              <div class="dash-date">
                @if ($v->date)
                @php
                $date = date("d", strtotime($v->date) );
                $month = date("M", strtotime($v->date) );
                @endphp
                <h4 style="">{{ $date }} <span>{{ $month }}</span></h4>
                @endif
              </div>
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
  </main>
     @php
      $res = DB::table("meta")->select("views")->where("page_name" , "news")->first();
      $views = $res->views;
      refresh_views($views , 0 , 0 , "news" );
     @endphp
  @include('front.layout.footer')
</div>
</body>
</html>