<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - APJEA</title>
    <link rel="shortcut icon" href="{{ asset("admin-assets/dist/img/favicon.png")}}">
    <link href="{{ asset("admin-assets/plugins/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{ asset('admin-assets/dist/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assets/dist/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset("admin-assets/plugins/fontawesome/css/all.min.css")}}" rel="stylesheet">
    <link href="{{ asset('assets/style/icomoon.css') }}" rel="stylesheet">
  </head>
  <body class="bg-white">
    <div class="d-flex align-items-center justify-content-center text-center h-100vh">
      <div class="form-wrapper m-auto" style="padding: 0px !important;">
        <div class="form-container my-4">
          <div class="panel" style="padding: 0px !important; box-shadow: none; border: none;">
            <div class="panel-header text-center mb-3">
              <h3 class="fs-24">Sign into your account!</h3>
              <p class="text-muted text-center mb-0">Nice to see you! Please log in with your account.</p>
            </div>
            @if(count($errors) > 0)
                <ul class="alert alert-danger alert-dismissible fade show text-left" style="list-style: none;">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </ul>
            @endif
          @if(session()->has("error"))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {!! session("error") !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
            <form class="register-form" method="POST" action="{{ route('admin_login') }}">
              @csrf
              <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <input type="text" class="form-control" id="username" placeholder="Enter your valid Username" name="email" value="{{ old('username') }}" required autofocus>
              </div>
              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" id="password pass" placeholder="Password" name="password" required="">
                <span toggle="#password-field" class="fa fa-fw field-icon toggle-password fa-eye"></span>
              </div>
              <p class="loginsuccess">Select Your Membership &nbsp;
              </p>
            @php
              $type[] = ['title'=>'Admin','i'=>'fas fa-user-tie','value'=>'admin'];
              $type[] = ['title'=>'General','i'=>'fas fa-globe','value'=>'general'];
              $type[] = ['title'=>'District','i'=>'far fa-building','value'=>'district'];
              $type[] = ['title'=>'Province','i'=>'fa fa-landmark','value'=>'province'];
              $type[] = ['title'=>'National','i'=>'fab fa-font-awesome-flag','value'=>'national'];
              shuffle($type);
              $shuffle_img = get_security_img();
              shuffle($shuffle_img);
              $i = 1;
            @endphp
              <div class="security" style="box-sizing: border-box;">
                <div class="d-flex flex-row justify-content-center">
                  @foreach($type as $v)
                    <label title="{{ $v['title'] }}">
                      <input type="radio" name="membership" value="{{ $v['value'] }}" class="radio-input type"> 
                      <i class="{{ $v['i'] }}" aria-hidden="true"></i>
                    </label>
                  @endforeach
                </div>
              </div>
              <p class="loginsuccess">Select Your Security Image &nbsp;
              </p>

              <div class="security" style="box-sizing: border-box;">
                <div class="d-flex flex-row justify-content-center">
                  @foreach($shuffle_img as $key => $t)
                    @php
                      if($i < 5){
                        $i++;
                    @endphp
                    <label title="{{ $t['title'] }}">
                      <input type="radio" name="imageSecurity" value="{{ $t['value'] }}" class="radio-input security_image"> 
                      <i class="fa {{ $t['i'] }}" aria-hidden="true"></i>
                    </label>
                    @php
                      }else{
                        $i = 1;
                    @endphp
                      <label title="{{ $t['title'] }}">
                        <input type="radio" name="imageSecurity" value="{{ $t['value'] }}" class="radio-input security_image"> 
                        <i class="fa {{ $t['i'] }}" aria-hidden="true"></i>
                      </label>
                    </div>
                    <div class="d-flex flex-row justify-content-center">
                    @php
                      }
                    @endphp
                  @endforeach
                </div>
              </div>
              @if(session()->has("d"))
                <div class="row tryies" style="justify-content: space-evenly; margin-bottom: 10px; ">
                  @php
                    $d = session("d");
                    $u = 5 - $d;
                  @endphp
                  @for($i = 0; $i < $d; $i++)
                    <i class="fa fa-times" style="color: red;font-size: 20px"></i>
                  @endfor
                  @for($j = $u; $j > 0; $j--)
                    <i class="fa fa-circle" style="color: gray;font-size: 15px"></i>
                  @endfor
                </div>
              @endif
                <button type="submit" class="btn btn-success btn-block">Sign in</button>
              </form>
            </div>
            <div class="bottom-text text-center my-3">
              Powered by: <a href="http://dgaps.com/" class="font-weight-500" target="_blank" rel="noopener">Digital Applications</a>
            </div>
          </div>
        </div>
      </div>
      <script src="{{ asset('admin-assets/dist/js/jquery.min.js') }}"></script>
      <script src="{{ asset("admin-assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
      <script>
        $('.security_image').change(function(){
          $('.security_image').next("i").css('border','2px solid rgb(0, 128, 0)');
          $('.security_image').next("i").css('color','rgb(0, 128, 0)');
          if($(this).prop("checked") == true){
            $(this).parent().find('i').css('border','2px solid #b212e6');
            $(this).parent().find('i').css('color','#b212e6');
            // $(this).parent().find('i').css('padding','3px');
          }
          // $radio.closest('label') .css('color','green');
        })
        $('.type').change(function(){
          $('.type').next("i").css('border','2px solid rgb(0, 128, 0)');
          $('.type').next("i").css('color','rgb(0, 128, 0)');
          if($(this).prop("checked") == true){
            $(this).parent().find('i').css('border','2px solid #b212e6');
            $(this).parent().find('i').css('color','#b212e6');
            // $(this).parent().find('i').css('padding','3px');
          }
          // $radio.closest('label') .css('color','green');
        });
        var chp = 0;
        $(".toggle-password").click(function() {
          $(this).toggleClass("fa-eye fa-eye-slash");
          if (chp==0){
            $(this).closest("div").find("input").attr("type","text");
            chp = 1;
          }else{
            $(this).closest("div").find("input").attr("type","password");
            chp = 0;
          }

        });
      </script>
    </body>
  </html>