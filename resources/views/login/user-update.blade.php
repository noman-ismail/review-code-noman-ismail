@include('login.layouts.header')
  @php
    $shuffle_img = get_security_img();
  @endphp
  @if (session()->has('change_modal'))
	<div class="message-box2 alert-box" style="display: none;">
	  <div class="message-content">
	    <h3 class="message-head">Update Password</h3>
	    <div class="message-text">
	      <div class="icon">
	        <i class="icon-info"></i>
	      </div>
	      <p>Please update your login detail.</p>
	    </div>
	    <div class="butn-class">
		    <button class="btn-close btn-default">Make it Default</button>
		    <button class="btn-close">OK</button>
		</div>
	  </div>
	</div>
	<script>
		$(document).ready(function(){
			$(".message-box2").fadeIn("slow");
			$('.btn-default').click(function(){
		      $.ajax({
		        url:"{{ route('account-setting') }}",
		        method:'POST',
		        dataType:'json',
		        data:{
		          action:'update_pass',
		          _token:_token,
		        }, success:function(res){
		        	if(res == 'success'){
						$(".message-box2").find('p').html('Password updated successfully');
						$(".message-box2").fadeIn("slow");
						$('.message-box2').find('.btn-default').css('display','none');
		        	}else{
						$(".message-box2").find('p').html('Error to save password');
						$(".message-box2").fadeIn("slow");
						$('.message-box2').find('.btn-default').css('display','none');

		        	}
		        }, error:function(e){
					$(".message-box2").find('p').html('Error to save password. Please refresh page.');
					$(".message-box2").fadeIn("slow");
					$('.message-box2').find('.btn-default').css('display','none');
		        }
		      });
			})
		})
	</script>
	<input type="hidden" value="{{ session()->get('change_modal') }}">
  @endif
{{-- 	<header class="title-header main-header">
		<div class="container">
			<div class="header-text">
				<h1 class="header-title">Dashboard</h1>
				<ul class="breadcrumb" id="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><span>User Dashboard</span></li>
				</ul>
			</div>
		</div>
	</header> --}}
		<input type="hidden" class="_old" value="{{ base64_decode($user->enc) }}">
		<input type="hidden" class="_old2" value="{{ $user->reset_pass }}">
		<input type="hidden" class="_old_img" value="{{ base64_decode($user->s_img) }}">
	<main class="dashboard-section" id="breadcrumb">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-lg-3">
					<div class="dash-aside">
						@include('login.layouts.sidebar')
					</div>
				</div>
				<div class="col-lg-9">
					<div class="main-column user-Updateform">
						<h3 class="rounded-top">Account Setting</h3>
						<form action="{{ route('account-setting') }}" class="row password-row" method="post">
							@csrf
								@if(session()->has("success"))
		              <script>
		                $([document.documentElement, document.body]).animate({
		                  scrollTop: $("#breadcrumb").offset().top
		                }, 1000);
		              </script>
										<div class="col-md-12">
											<div class="message message-success">
												<span>{!! session("success") !!}</span>
												<i class="close close-message">×</i>
											</div>
										</div>
								@endif
								@if(session()->has("error"))
		              <script>
		                $([document.documentElement, document.body]).animate({
		                  scrollTop: $("#breadcrumb").offset().top
		                }, 1000);
		              </script>
										<div class="col-md-12">
											<div class="message message-error">
												<span>{!! session("error") !!}</span>
												<i class="close close-message">×</i>
											</div>
										</div>
								@endif
							<div class="col-lg-4">
								<img src="{{ asset('assets/compress/lock.png') }}" class="img-fluid" alt="lock-image">
							</div>
							<div class="col-lg-8">
								<div class="row">
									<div class="col-md-12 msgs_div">
									</div>
								</div>
								<div class="form-group">
									<div class="resp-text">
										<label>Your CNIC No.:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="text" class="form-control cnic" value="{{ (old())?old('cnic'):$user->cnic }}" name="cnic" disabled>
										<span class="icon">
											{{-- <i class="icon-check_circle_outline"></i> --}}
										</span>
									</div>
								</div>
								<div class="form-group password-group">
									<div class="resp-text">
										<label>Old Password:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="password" class="form-control password" name="password" value="">
										<span class="toggle-icon icon-eye"></span>
									</div>
								</div>
								<div class="form-group password-group">
									<div class="resp-text">
										<label>New Password:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="password" class="form-control newpassword" name="new_password">
										<span class="toggle-icon icon-eye"></span>
									</div>
								</div>
								<div class="form-group password-group">
									<div class="resp-text">
										<label>Confirm Password:</label>
										<span class="text"></span>
									</div>
									<div class="resp-icon">
										<input type="password" class="form-control reppassword" name="confirm_password">
										<span class="toggle-icon icon-eye"></span>
									</div>
								</div>
								@php
							    shuffle($shuffle_img);
							    $i = 1;
								@endphp
								<div class="icon-group icon_group">
									<div class="icon-group-error">
										<label>Choose Old Security Image</label>
										<span class="text"></span>
									</div>
									<div class="icon-list">
                    @foreach ($shuffle_img as $v)
                      <label title="{{ $v['title'] }}">
                          <i class="fa {{ $v['i'] }}"></i>
                          <input type="radio" name="old_security_img" value="{{ $v['value'] }}" class="security_img old_security_img">
                          <span class="icon-resp"></span>
                      </label>
                    @endforeach
									</div>
								</div>
								@php
							    shuffle($shuffle_img);
							    $i = 1;
								@endphp
								<div class="icon-group icon_group">
									<div class="icon-group-error">
										<label>Choose New Security Image</label>
										<span class="text"></span>
									</div>
									<div class="icon-list">
                    @foreach ($shuffle_img as $v)
                      <label title="{{ $v['title'] }}">
                          <i class="fa {{ $v['i'] }}"></i>
                          <input type="radio" name="new_security_img" value="{{ $v['value'] }}" class="security_img new_security_img">
                          <span class="icon-resp"></span>
                      </label>
                    @endforeach
									</div>
								</div>
	
								<div class="form-group">
									<button type="button" class="btn btn-submit"><i class="icon-check_circle_outline"></i>
									Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script>
		$(document).ready(function(){
			$('.password , .reppassword , .newpassword').click(function(){
					$(this).closest('.resp-icon').find('.icon').removeClass('icon-error').html(``);
					$(this).closest('.form-group').removeClass('input-group-error');
					$(this).closest('.form-group').find('.text').html(``);
			});
			$('.btn-submit').click(function(){
				var password = $('.password').val().trim();
				var newpassword = $('.newpassword').val().trim();
				var reppassword = $('.reppassword').val().trim();
				var old = $('._old').val();
				var old2 = $('._old2').val();
				var old_img = $('._old_img').val().trim();
				var s_img = $('input[name="old_security_img"]:checked').val();
				var new_s_img = $('input[name="new_security_img"]:checked').val();
				if(s_img == undefined){
					s_img = '';
				}
				if(new_s_img == undefined){
					new_s_img = '';
				}
				var i = 0;
				if(password == ""){
					$('.password').closest('.form-group').addClass('input-group-error');
					$('.password').closest('.form-group').find('.text').html(`Password Field is Required`);
					i = parseInt(i) + parseInt(1);
				}else if(password.length < 5){
					$('.password').closest('.form-group').addClass('input-group-error');
					$('.password').closest('.form-group').find('.text').html(`Password contains minimum 5 characters`);
					i = parseInt(i) + parseInt(1);
				}else if(old2 != "" && old != password && old2 != password){
					$('.password').closest('.form-group').addClass('input-group-error');
					$('.password').closest('.form-group').find('.text').html(`Old Password is incorrect`);
					i = parseInt(i) + parseInt(1);
				}if(newpassword == ""){
					$('.newpassword').closest('.form-group').addClass('input-group-error');
					$('.newpassword').closest('.form-group').find('.text').html(`Password Field is Required`);
					i = parseInt(i) + parseInt(1);
				}else if(newpassword.length < 5){
					$('.newpassword').closest('.form-group').addClass('input-group-error');
					$('.newpassword').closest('.form-group').find('.text').html(`New Password contains minimum 5 characters`);
					i = parseInt(i) + parseInt(1);
				}if(reppassword == ""){
					$('.reppassword').closest('.form-group').addClass('input-group-error');
					$('.reppassword').closest('.form-group').find('.text').html(`Confirm Password Field is Required`);
					i = parseInt(i) + parseInt(1);
				}else if(reppassword.length < 5){
					$('.reppassword').closest('.form-group').addClass('input-group-error');
					$('.reppassword').closest('.form-group').find('.text').html(`Repeat Password contains minimum 5 characters`);
					i = parseInt(i) + parseInt(1);
				}
				if(reppassword != newpassword){
					$('.reppassword').closest('.form-group').addClass('input-group-error');
					$('.reppassword').closest('.form-group').find('.text').html(`Password and Confirm Password does not match .`);
					i = parseInt(i) + parseInt(1);
				}
				if(new_s_img == ""){
					$('.new_security_img').closest('.icon-group').addClass('icon-group-error');
					$('.new_security_img').closest('.icon-group').find('.text').html(`Please select your new security image`);
					i = parseInt(i) + parseInt(1);
				}
				if(s_img == ""){
					$('.old_security_img').closest('.icon-group').addClass('icon-group-error');
					$('.old_security_img').closest('.icon-group').find('.text').html(`Please select your old security image`);
					i = parseInt(i) + parseInt(1);
				}else if(old_img != s_img){
					$('.old_security_img').closest('.icon-group').addClass('icon-group-error');
					$('.old_security_img').closest('.icon-group').find('.text').html(`Old security image is incorrect`);
					i = parseInt(i) + parseInt(1);
				}
				if(i == 0){
					$('form').submit();
				}else{
          $([document.documentElement, document.body]).animate({
              scrollTop: $("#breadcrumb").offset().top
          }, 1000);
        }
			})
		});
		$('.new_security_img , .old_security_img').click(function(){
			$(this).closest('.icon-group').removeClass('icon-group-error');
			$(this).closest('.icon-group').find('.text').html(``);
		});
        function toggleVisibilty(element){
            var parent = element.parentNode;
            var type = parent.children[0].type;
            // console.log(parent.children[0].type);
            if(type == "password"){
                parent.children[0].type = "text";
            }
            else{
                parent.children[0].type = "password";
            }
            if(element.classList.contains("icon-eye")){
                element.classList.add("icon-eye-blocked");
                element.classList.remove("icon-eye");
            }
            else{
                element.classList.add("icon-eye");
                element.classList.remove("icon-eye-blocked");
            }
        }
        var iconOne = document.getElementsByClassName("toggle-icon")[0];
        iconOne.addEventListener("click",function(){
           toggleVisibilty(this); 
        }) 
        var iconTwo = document.getElementsByClassName("toggle-icon")[1];
        iconTwo.addEventListener("click",function(){
           toggleVisibilty(this); 
        });
        var iconThree = document.getElementsByClassName("toggle-icon")[2];
        iconThree.addEventListener("click",function(){
           toggleVisibilty(this); 
        });
  </script>
@include('login.layouts.footer')