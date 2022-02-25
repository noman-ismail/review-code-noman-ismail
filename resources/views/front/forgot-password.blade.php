@include('front.layout.header')
  <link rel="stylesheet" href="{{ asset('assets/style/all.content.css') }}"/>
</head>
<body>
  <div class="wrapper">
    @include('front.layout.top-menu')
    @include('front.layout.main-menu')
{{--     <header class="title-header main-header">
      <div class="container">
        <div class="header-text">
          <h1 class="header-title">Forgot Password</h1>
          <ul class="breadcrumb" id="breadcrumb">
            <li><a href="{{ route('base_url') }}">Home</a></li>
            <li><span>Forgot Password</span></li>
          </ul>
        </div>
      </div>
    </header> --}}
    <div class="container-fluid jumbotron mb-0" id="breadcrumb">
      <div class="container mt-4 mb-5">
        <div class="row">
          <div class="col-md-8 col-lg-7 mx-auto">
            <div class="outer-box bg-white">
              <h3 class=" text-center">Reset Password</h3>
              <hr>
              <form action="{{ route('forgot-password') }}" class="forgot-form" method="post">
                @csrf
                @php
                  $__reset_by = $__cnic1 = $__cnic2 = $__email = $__phone = "";
                @endphp
                @if (session()->has('error'))
                  @php
                    $__reset_by = session('reset_by');
                    $__cnic1 = session('cnic1');
                    $__cnic2 = session('cnic2');
                    $__email = session('email');
                    $__phone = session('phone');
                  @endphp
                  <script>
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#breadcrumb").offset().top
                        }, 1000);
                  </script>
                  <div class="row main-column">
                    <div class="col-md-12">
                      <div class="message message-error">
                        <span>{!! session("error") !!}</span>
                        <i class="close close-message">×</i>
                      </div>
                    </div>
                  </div>
                @endif
                @if (session()->has('success'))
                  <script>
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#breadcrumb").offset().top
                        }, 1000);
                  </script>
                  <div class="row main-column">
                    <div class="col-md-12">
                      <div class="message message-success">
                        <span>{!! session("success") !!}</span>
                        <i class="close close-message">×</i>
                      </div>
                    </div>
                  </div>
                @endif
                <input type="hidden" class="_type" value="" name="reset_by" {{ $__reset_by }}>
                <div class="__empty"></div>
                <div class="content-column">
                  <h5>Choose An Option:</h5>
                  <div class="upper-menu">
                    <div class="option-group">
                      <div class="option-item option-lg green-item">
                        <div class="menu-item" data-href="email-tab">
                          <div class="icon">
                            <span data-title="By Email"><i class="icon-envelope"></i></span>
                          </div>
                          <h4>By Email</h4>
                        </div>
                      </div>
                      <div class="option-item option-lg dark-item">
                        <div class="menu-item" data-href="contact-tab">
                          <div class="icon">
                            <span data-title="By Contact No"><i class="icon-phone">
                            </i></span>
                          </div>
                          <h4>By Contact No</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group email-group" id="email-tab">
                    <label for="" class=" mt-3">Enter Your CNIC Number:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="icon-profile"></i>
                        </span>
                      </div>
                      <input type="tel" class="form-control cnicfp1" name="cnic1" placeholder="36103-1234567-3" value="{{ $__cnic1 }}">
                    </div>
                    <label for="" class=" mt-3">Enter Your Email:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="icon-envelope"></i>
                        </span>
                      </div>
                      <input type="email" class="form-control email" name="email" placeholder="{{ 'example@gmail.com' }}" value="{{ $__email }}">
                    </div>
                  </div>
                  <div class="form-group contact-group" id="contact-tab">
                    <label for="" class=" mt-3">Enter Your CNIC Number:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="icon-profile"></i>
                        </span>
                      </div>
                      <input type="tel" class="form-control cnicfp2" name="cnic2" placeholder="36103-1234567-3" value="{{ $__cnic2 }}">
                    </div>
                    <label for="" class=" mt-3">Enter Your Phone No:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="icon-phone"></i>
                        </span>
                      </div>
                      <input type="tel" class="form-control phone_no" name="phone_no" id="phone" placeholder="0300-1234567" value="{{ $__phone }}">
                    </div>
                  </div>
                  
                  <div class="text-center mt-3">
                    <button class="btn btn-submit  btn-round" type="button">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
  <script>
    var old_value = '{{ $__reset_by }}';
    function show_error(msg){
      $('.message-error').parent('div').remove();
      $([document.documentElement, document.body]).animate({
          scrollTop: $("#breadcrumb").offset().top
      }, 1000);
      var html = '<div class="col-md-12"><div class="message message-error"><span>'+msg+'</span><i class="close close-message">×</i></div></div>';
      $('.__empty').addClass('row main-column').html(html);
      $('.close').click(function(){
        $(this).parent(".message").fadeOut("slow");
      })
    }
    $('.close').click(function(){
      $(this).parent(".message").fadeOut("slow");
    });
    $('.cnicfp1').samask("00000-0000000-0");
    $('#phone').samask("0000-0000000");
    $('.cnicfp1').change(function(e){
      var new_val = $(this).val();
      var new_val = new_val.replace(/(\d{5})(\d{7})(\d{1})/, "$1-$2-$3");
      $(this).val(new_val);
    })
    $('#phone').change(function(e){
      var new_val = $(this).val();
      var new_val = new_val.replace(/(\d{4})(\d{7})/, "$1-$2");
      $(this).val(new_val);
    })
    $('.cnicfp2').samask("00000-0000000-0");
    $('.cnicfp2').change(function(e){
      var new_val = $(this).val();
      var new_val = new_val.replace(/(\d{5})(\d{7})(\d{1})/, "$1-$2-$3");
      $(this).val(new_val);
    });
    if(old_value != ""){
      if(old_value == 'email-tab'){
        $('*[data-href="'+old_value+'"]').addClass('active');
        $(".contact-group").hide();
      }else if(old_value == 'contact-tab'){
        $('*[data-href="'+old_value+'"]').addClass('active');
        $(".email-group").hide();        
      }
    }else{
      $(".contact-group").hide();
      $(".email-group").hide();
    }
    $(".menu-item").click(function(){
      $(".menu-item").removeClass("active");
      $(this).addClass("active");
      $(".form-group").removeClass("active"); 
      var dataId = $(this).attr("data-href");
      $(".form-group").each(function(){
        var formId = $(this).attr("id");
        if(formId == dataId){
          $(this).show();
        }
        else{
          $(this).hide();
        }
      });
    });
    $('.btn-submit').click(function(){
      var radio = $(".menu-item.active").attr('data-href');
      if(radio == undefined){
        show_error('Please Choose option for Reset Password');
      }else{
        let cnic = "";
        if(radio == 'email-tab'){
          cnic = $('.cnicfp1').val();
        }else if(radio == 'contact-tab'){
          cnic = $('.cnicfp2').val();
        }
        if(cnic.trim() == "" || cnic.length != 15){
          show_error('Please Enter Your Correct CNIC No.');
        }else{
          $('._type').val(radio);
          $(this).attr('disabled',true);
          $('form').submit();
        }
      }
    })
  </script>
@include('front.layout.footer')