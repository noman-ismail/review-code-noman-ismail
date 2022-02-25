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
        <h1 class="header-title">Frequently Asked Questions</h1>
        <ul class="breadcrumb">
          <li><a href="{{ route('base_url') }}">Home</a></li>
          <li><a href="{{ route('base_url') }}/faqs">FAQ's</a></li>
        </ul>
      </div>
    </div>
  </header>
  
  <main class="main-content single-section">
    <div class="container">
      <div class="row">
        <article class="col-md-12">
          <h2 class="text-success faqs-head">Frequently Asked Questions</h2>
          <div class="row">
            <div class="col-lg-8">
               @foreach ($data as $k =>  $v)
              @php
                $num = $k+1 . ".";
                $visible = ($k==0) ? "visible" : "" ;
                $icon = ($k==0) ? "icon-chevron-up" : "icon-chevron-down" ;
              @endphp
              <div class="ex-faqs-item {{$visible}}">
                <div class="ex-faqs-header">
                  <h3>
                        <span class="faqs-text">{{ $num }} - {{ $v['question'] }}</span>
                        <span class="faqs-icon"><i class="{{ $icon }}"></i></span>
                  </h3>
                </div>
                <div class="ex-faqs-body">
                 {!! $v['answer'] !!}
                </div>
              </div>
              @endforeach
            </div>
            <div class="col-lg-4">
              <div class="faqs-form">
                <h3>Can't Find The <span>Answers?</span></h3>
                <p>Fill all information details to consult with our  best Attorneys advices.</p>
                <form action="" id="faqsform">
                <div class="input-group">
                  <input type="text" name="name" placeholder="Name">
                </div>
                <div class="input-group">
                  <input type="text" name="email" placeholder="Email">
                </div>
                <div class="input-group">
                  <textarea name="question" placeholder="Enter Message"></textarea>
                </div>
                <div class="input-group">
                  <button type="submit" name="submit" class="faqs_button">Submit</button>
                </div>  
                </form>
              </div>
              <div class="ad-box">
                <img src="compress/ad-image.jpg" class="img-fluid" alt="ads-image">
              </div>
            </div>
          </div>
        </article>
      </div>
    </div>
  </main>
   @php
      $res = DB::table("meta")->select("views")->where("page_name" , "faqs")->first();
      $views = $res->views;
      refresh_views($views , 0 , 0 , "faqs" );
     @endphp
  @include('front.layout.footer')
  <script>
    $(".faqs_button").click(function (event) {
    event.preventDefault();
    var el = $(this);
    var data = el.closest("form").serializeArray();
    el.attr("disabled", true);
    $.ajax({
      headers: {
        'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')
      },
      type: "post",
      global: "false",
      datatype: "html",
      url: "/faqsform",
      data: data,
    }).done(function (d) {
      el.closest("form").trigger("reset");
      el.closest("div").find("img").remove();
      el.attr("disabled", false);
      $('#errors').html("<div class='alert alert-success alert-dismissible'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <strong>Success!</strong> Your message has been submitted. You will get a response very soon.</div>");
    }).fail(function (errors) {
      var h_error = '';
      var $div = $("<p>", {
        id: "foo",
        "class": "a"
      });
      let error = errors.responseJSON['errors'];
      el.closest("div").find("img").remove();
      el.attr("disabled", false);
      if (error.name) {
        h_error += '<p class="text-danger"><b>' + error.name + '</b></p>';
      } else if (error.question) {
        h_error += '<p class="text-danger"><b>' + error.question + '</b></p>';
      } else if (error.email) {
        h_error += '<p class="text-danger"><b>' + error.email + '</b></p>';
      }
      $('#errors').html(h_error);
      return false;
    });
    event.preventDefault();
  });
  $(".ex-faqs-item:not(.visible)").find(".ex-faqs-body").hide();
  $(".ex-faqs-header").click(function(){
  var current = $(this).next(".ex-faqs-body");
  $(".ex-faqs-body").not(current).slideUp(500);
  $(".ex-faqs-body").not(current).parent(".ex-faqs-item").removeClass("visible");
  if ($(this).parent().is('.visible')){
  $(this).closest('.ex-faqs-item').find('.ex-faqs-body').slideUp(500);
  $(this).closest('.ex-faqs-item').removeClass('visible');
  $(".ex-faqs-header .faqs-icon i").addClass("icon-chevron-down");
  $(".ex-faqs-header .faqs-icon i").removeClass("icon-chevron-up");
  }
  else{
  $(this).closest('.ex-faqs-item').find('.ex-faqs-body').slideDown(500);
  $(this).closest('.ex-faqs-item').addClass('visible');
  $(".ex-faqs-header .faqs-icon i").addClass("icon-chevron-down");
  $(".ex-faqs-header .faqs-icon i").removeClass("icon-chevron-up");
  $(this).find(".faqs-icon i").addClass("icon-chevron-up");
  $(this).find(".faqs-icon i").removeClass("icon-chevron-down");
  }
  });
  </script>
  
</div>
</body>
</html>