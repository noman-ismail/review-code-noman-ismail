@include('front.layout.header')
<link rel="stylesheet" href="{{asset('assets/style/all.job.css') }}">
</head>
<body>
<div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu',['segment'=>'jobs'])
  <header class="detail-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-2 col-md-2 col-lg-2">
          <img src="{{ get_post_thumbnail($res->cover) }}" class="img-fluid" alt="company-image">
        </div>
        <div class="col-10 col-md-10 col-lg-6">
          @isset ($res->title)
          <h2>{{$res->title}}</h2>
          @endisset
          @isset ($res->organization)
          <p>{{ $res->organization }}</p>
          @endisset
          
          <ul class="bottom-nav">
            @isset ($res->vacancies)
            <li><i class="icon-user"></i>&nbsp;{{ $res->vacancies }} Vacancies</li>
            @endisset
            @if (isset($res->district ) || isset($res->province))
            <li><i class="icon-location"></i>&nbsp;{{ get_dept_name($res->district , "district") }} &nbsp;   {{ get_dept_name($res->province , "province") }}</li>
            @endif
            <li><span class="vr-action"><i class="icon-checkmark"></i>&nbsp;Verified</span></li>
          </ul>
          @isset ($res->official_link)
          <ul class="bottom-nav">
            <li><i class="icon-sphere"></i>&nbsp;<span>Official Website:
              </span>&nbsp;<a href="{{ $res->official_link }}" class="web-link" rel="nofollow noopener" target="_blank" >{{ $res->official_link }}</a></li>
            </ul>
            @endisset
            
          </div>
          <div class="col-10 col-md-10 col-md-offset-2 col-lg-4 bl-grey">
            @isset ($res->job_type)
            <div class="detail-item row">
              <p class="col-6 col-sm-3 col-lg-6">Job Type</p>
              <p class="col-6 col-sm-9 col-lg-6">{{ str_replace(",", " | ", $res->job_type) }}</p>
            </div>
            @endisset
            @isset ($res->job_shift)
            <div class="detail-item row">
              <p class="col-6 col-sm-3 col-lg-6">Job Shift</p>
              <p class="col-6 col-sm-9 col-lg-6">{{ str_replace(",", " | ", $res->job_shift) }}</p>
            </div>
            @endisset
            @isset ($res->category)
            <div class="detail-item row">
              <p class="col-6 col-sm-3 col-lg-6">Category</p>
              <p class="col-6 col-sm-9 col-lg-6">{{ str_replace(",", " | ", $res->category) }}</p>
            </div>
            @endisset
            @isset ($res->due_date)
            <div class="detail-item row">
              <p class="col-6 col-sm-3 col-lg-6">Due Date</p>
              <p class="col-6 col-sm-9 col-lg-6">{{ date("d M Y", strtotime($res->due_date) ) }}</p>
            </div>
            @endisset
            {{--
            <ul class="social-nav">
              <li><a href="#"><i class="icon-facebook"></i></a></li>
              <li><a href="#"><i class="icon-twitter"></i></a></li>
              <li><a href="#"><i class="icon-instagram"></i></a></li>
              <li><a href="#"><i class="icon-linkedin2"></i></a></li>
            </ul> --}}
          </div>
        </div>
      </div>
    </header>
    <div class="container">
      <div class="content-section row">
        <main class="col-md-12" id="job-detail-main">
          <div class="content-column">
            <div class="apply-job-header">
              @isset ($res->title)
              <h4>{{ $res->title }}</h4>
              @endisset
              @isset ($res->organization)
              <a href="{{ route('base_url')."/".$res->slug."-1".$res->id }}" class="cl-success">
                <span><i class="icon-location"></i>{{ $res->organization }}</span></a>
                @endisset
              </div>
              <div class="apply-job-detail">
                {!! $res->content !!}
                <a class="btn btn-success mt-3" href="{{ $res->official_link }}" rel="nofollow noopener" target="_blank" style="float: right">Apply For This Job</a>
              </div>
            </div>
            <div class="container-detail-box job-list">
              <div class="row">
                <div class="col-md-12">
                  <h4>Similar Jobs</h4>
                  @foreach ($data as $k => $v)
                  @php
                  $url = route('base_url')."/".$v->slug."-1".$v->id;
                  @endphp
                  <div class="outer-col">
                    <div class="job-item row">
                      <div class="col-12 col-md-6 col-lg-6">
                        @isset ($v->title)
                        <h4 class="job-title"><a href="{{$url}}">{{ $v->title }}</a></h4>
                        <p>{{ $v->organization}}</p>
                        @endisset
                      </div>
                      <div class="col-6 col-md-2 col-lg-2 column-city">
                        <div class="upper">{{ get_dept_name($v->district , "district") }}</div>
                        <p>{{ get_dept_name($v->province , "province") }}</p>
                      </div>
                      <div class="col-6 col-md-3 col-lg-2">
                        <div class="upper">{{ date("d M Y", strtotime($v->due_date) ) }}</div>
                        @isset ($v->published_by)
                        <p>{{ $v->published_by }}</p>
                        @endisset
                        
                      </div>
                      <div class="col-12 col-md-3 col-lg-2">
                        <a href="{{$url}}" class="button">Visit Job</a>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>
  @php
       $views = $res->views;
      refresh_views($views , get_postid('post_id') , get_postid('page_id'), get_postid('full') );
    @endphp
  @include('front.layout.footer')
</body>
</html>