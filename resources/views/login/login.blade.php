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
          <h1 class="header-title">Login</h1>
          <ul class="breadcrumb" id="breadcrumb">
            <li><a href="{{ route('base_url') }}">Home</a></li>
            <li><span>Login</span></li>
          </ul>
        </div>
      </div>
    </header> --}}
    <div class="container-fluid jumbotron mb-0" id="breadcrumb">
      <div class="container mt-4 mb-5">
        <div class="row login-row" id="loginSectionId">
          <div class="col-sm-12 col-md-10 col-lg-6 mx-auto">
            <div class="outer-box bg-white">
              <h3 class="text-uppercase text-center">Login</h3>
              <hr>
              <form action="{{ route('user_login') }}" method="post" class="user-form" id="contactform">
                @csrf
                @if (session()->has('error'))
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
				<div class="form-group">
					<div class="resp-top">
						<label for="" class="text-uppercase mt-3">CNIC: <span class="comp">*</span></label>
						<div class="text"></div>
					</div>
					<div class="input-group">
						<div class="input-group-prepend">
							 <span class="input-group-text bg-orange text-light">
							 	<i class="icon-user"></i>
							 </span>
						</div>
	                    <input type="tel" class="form-control cnic" name="CNIC" placeholder="36103-1234567-3">
					</div>
				</div>
                
				<div class="form-group">
					<div class="resp-top">
						<label for="" class="text-uppercase mt-3">Password: <span class="comp">*</span></label>
						<div class="text"></div>
					</div>
					<div class="input-group password-group">
						<div class="input-group-prepend">
							 <span class="input-group-text bg-orange text-light">
							 	<i class="icon-lock"></i>
							 </span>
						</div>
	                    <input type="password" class="form-control password" name="password" placeholder="Enter Your Password">
	                    <span class="toggle-icon icon-eye"></span>
					</div>
				</div>
                @php
                  $shuffle_img = get_security_img();
                  shuffle($shuffle_img);
                  $i = 1;
                @endphp
                <div class="form-group icon-group">
                    <div class="icon-group-error">
                        <label>Choose Security Image: <span class="comp">*</span></label>
                    </div>
                    {{-- <label>Choose Security Image: <span class="comp">*</span></label> --}}
                    <div class="icon-list">
                        @foreach ($shuffle_img as $v)
                          <label title="{{ $v['title'] }}">
                              <i class="{{ $v['i'] }}"></i>
                              <input type="radio" name="security_img" value="{{ $v['value'] }}" class="security_img">
                              <span class="icon-resp"></span>
                          </label>
                        @endforeach
                    </div>
                </div>
                <div class="alert alert-warning" style="display: none">
                  <b>Warning:</b> You will be blocked automatically after a few more wrong attempts
                </div>
                <div class="form-group attempt-group" style="display:none">
                    <div class="input-group">
                      <input type="text" readonly="true" class="form-control" placeholder="Total No. of Attempts" disabled="disabled">
                      <span class="attempts">
                          <i class="icon-cancel-circle"></i>
                          <i class="icon-cancel-circle"></i>  
                          <i class="icon-cancel-circle"></i> 
                          <i class="icon-cancel-circle"></i>  
                          <i class="icon-cancel-circle"></i>  
                          <i class="icon-cancel-circle"></i>  
                          <i class="icon-cancel-circle"></i>  
                          <i class="icon-cancel-circle"></i>  
                      </span>
                    </div>
                </div>
                <div class="text-center mt-3">
                  <button class="btn btn-submit text-uppercase btn-round login-btn contactform" type="submit">Login</button>
                </div>
              
                <div class="row form-footer">
                  <div class="col-md-12 col-xl-8">
                    Don't have an account <a href="{{ route('register') }}"> Sign Up</a>
                  </div>
                  <div class="col-md-12 col-xl-4 float-right">
                    <a href="{{ route('forgot-password') }}">Forgot Password ?</a>
                  </div>
                </div>  
              </form>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
  @php
    $__back = url()->previous();
    $_findBack = strstr($__back,"apjea-members");
    $_findBack2 = strstr($__back,"team");
  @endphp
  @if ($_findBack == false && $_findBack2 == false)
    <script>
      var afterRedirect = "{{ route('user-dashboard') }}";
    </script>
  @else
    <script>
      var afterRedirect = "{{ $__back }}";
    </script>
  @endif
    <script src="{{ asset('assets/js/validate2.js') }}"></script>
    <script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
  <script>
    $(document).ready(function(){
      $('.cnic').samask("00000-0000000-0");
    	$('.cnic').change(function(e){
    		var new_val = $(this).val();
    		var new_val = new_val.replace(/(\d{5})(\d{7})(\d{1})/, "$1-$2-$3");
    		$(this).val(new_val);
    	})
    _is_validate("#contactform", { password: { require: !0}, CNIC: { require: !0, CNIC: !0 }, security_img: { require: !0} }),
        $(".contactform").click(function (e) {
            e.preventDefault();
            var r = $(this);
                r.text('Please Wait...'),
                $(".message-box").fadeIn("slow");
                $('.message-box').find('.message-head').hide(),
                $('.message-box').find('.icon').hide(),
                $('.message-box').find('button').hide(),
                $('.message-box').find('p').html('Please Wait .......'),
                a = r.closest("form"),
                action = a.attr('action'),
                t = r.closest("form").serializeArray();
                // r.attr("disabled", false),
                $.ajax({ headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }, type: "post", global: "false", datatype: "json", url: action, data: t })
                    .done(function (e) {
                        if(JSON.parse(e) == 'success'){
                            r.closest("form").trigger("reset"),
                            window.location.href = afterRedirect;
                        }else{
                            $(".message-box").fadeOut();
                            $('.message-box').find('p').html(''),
                            r.text('Login');
                            r.attr('disabled',false);
                            $('.row.main-column').remove();
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("#breadcrumb").offset().top
                            }, 1000);
                            var error_msg = JSON.parse(e);
                            var attempts = error_msg.attempts;
                            if(attempts != ""){
                              $('.alert-warning').fadeIn('slow');
                              $(".attempt-group").fadeIn('slow');
                              $('.attempts i').removeClass('error');
                              $('.attempts i').each(function(index) {
                                if(index < attempts){
                                  $(this).addClass('error');
                                }else{
                                  return false;
                                }
                              });
                              // $(".attempts i:first-child").addClass("error");
                            }else{
                              $('.alert-warning').fadeOut('slow');
                              $(".attempt-group").fadeOut('slow');                              
                            }
                            var bodd = '<div class="row main-column"><div class="col-md-12"><div class="message message-error"><span style="font-size: 14px">'+error_msg.msg+'</span><i class="close close-message">×</i></div></div></div>';
                            $(bodd).insertBefore(a);
                            $(".close-message").click(function(){
                                $(".message").fadeOut("slow");
                            });
                        }
                    })
                    .fail(function (e) {
                      $(".message-box").fadeOut();
                      $('.message-box').find('p').html(''),
                      r.text('Login');
                      r.attr('disabled',false);
                      $('.row.main-column').remove();
                      $("<p>", { id: "foo", class: "a" });
                      let t = e.responseJSON.errors;
                        r.attr("disabled", !1),
                        a.find("div.error-group").remove(),
                        a.find("input").next(".icon-resp").remove(),
                        t.password && ($("input[name='password']").closest('.icon-group').find('label:first').next('.text').html(t.password)),
                        t.cnic && ($("input[name='cnic']").closest('.icon-group').find('label:first').next('.text').html(t.password),$("input[name='cnic']").next('.icon-resp').remove(),$("input[name='cnic']").next('.toggle-icon').remove(),$("<span class='icon-resp'><i class='icon-check_circle_outline'></i></span>").insertAfter($("input[name='cnic']"))),
                        t.security_img && ($("input[name='security_img']").field.closest('.icon-group').find('label:first').next('.text').html(t.security_img))
                        // "undefined" != typeof grecaptcha && grecaptcha && grecaptcha.reset && grecaptcha.reset();
                    }),
                e.preventDefault();
        });
    });
  </script>
    <script>
        var button = document.querySelector(".toggle-icon");
        button.onclick = function(e){
            var parent     = document.querySelector(".password-group");
            var type = parent.children[1].type;
            if(type == "password"){
                parent.children[1].type = "text";
            }
            else{
                parent.children[1].type = "password";
            }
            if(button.classList.contains("icon-eye")){
                button.classList.add("icon-eye-blocked");
                button.classList.remove("icon-eye");
            }
            else{
                button.classList.add("icon-eye");
                button.classList.remove("icon-eye-blocked");
            }
        }
    </script>
    <script>
        $(".icon-list label").click(function(){
            $(this).closest(".icon-group").find(".icon-list label").removeClass("active");
            $(this).addClass("active");
        });
    </script>
  @include('front.layout.footer')