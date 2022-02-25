@include('front.layout.header')
<link rel="stylesheet" href="{{ asset('assets/style/all.content.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/style/chosen.css') }}"/>
<link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
<script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
</head>
<body>
<div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu',['segment'=>'pension-calculator'])
  <header class="title-header main-header">
    <div class="container">
      <div class="header-text">
        <h1 class="header-title">Pension Calculator</h1>
        <ul class="breadcrumb">
          <li><a href="{{ route('base_url') }}">Home</a></li>
          <li><span>Pension Calculator</span></li>
        </ul>
      </div>
    </div>
  </header>
  @php
    $cities = DB::table('cities')->orderby('name','asc')->get();
    $content = DB::table('meta')->where(['page_name'=>'pension-calculator'])->first();
  @endphp
  <div class="container-fluid jumbotron pension-container mb-0" style="background: url(images/calculation.webp) no-repeat;background-size:100% 100%;background-position:center">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-success faqs-head">Pension Calculator</h2>
          @if (!empty($content) and !empty($content->content))
            {!! $content->content !!}
          @endif
        </div>
      </div>
    </div>
    <div class="container mt-4 mb-5">
      <div class="row">
        <div class="col-md-12 col-lg-12 mx-auto">
          <div class="outer-box" style="margin: 20px 0;">
            <h3 class="text-uppercase text-center">Pension Calculator</h3>
            <hr>
            <form action="" method="post" class="pension-form user-form">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="resp-top">
                      <label>Full Name: <span class="comp">*</span></label>
                      <div class="text"></div>
                    </div>
                    <div class="input-group">
                      <input type="text" name="full_name" class="form-control full_name" placeholder="Enter Your Full Name">
                      <span class="icon-resp"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="resp-top">
                      <label for="" class=" mt-3">Select Your City: <span class="comp">*</span></label>
                      <div class="text"></div>
                    </div>
                    <div class="input-group">
                      <select name="city"class="ui-dropdown city">
                        <option value="">Select One</option>
                        @if (count($cities) > 0)
                          @foreach ($cities as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="resp-top">
                      <label>Enter Your Organization: <span class="comp">*</span></label>
                      <div class="text"></div>
                    </div>
                    <div class="input-group">
                      <input type="text" name="organization" class="form-control organization" placeholder="Enter Your Organization Name">
                      <span class="icon-resp"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="resp-top">
                      <label>Enter Your Designation: <span class="comp">*</span></label>
                      <div class="text"></div>
                    </div>
                    <div class="input-group">
                      <input type="text" name="designation" class="form-control designation" placeholder="Enter Your Designation">
                      <span class="icon-resp"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="resp-top">
                      <label for="" class=" mt-3">Pension Type: <span class="comp">*</span></label>
                      <div class="text"></div>
                    </div>
                    <div class="input-group">
                      <select name="pension_type"class="ui-dropdown pension_type">
                        <option value="">Select One</option>
                        <option value="Supperannuation">Supperannuation</option>
                        <option value="Family">Family</option>
                        <option value="Medical / Invalid">Medical / Invalid</option>
                        <option value="Retiring">Retiring</option>
                        <option value="Compulsory Retire">Compulsory Retire</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="resp-top">
                          <label for="" class=" mt-3">Pay Scale: <span class="comp">*</span></label>
                          <div class="text"></div>
                        </div>
                        <div class="input-group">
                          <select class="ui-dropdown pay_scal" name="pay_scal">
                            <option value="">Select One</option>
                            @for ($i = 22; $i > 0 ; $i--)
                              <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="resp-top">
                          <label>Enter Basic Pay: <span class="comp">*</span></label>
                          <div class="text"></div>
                        </div>
                        <div class="input-group">
                          <input type="text" class="form-control pay" placeholder="Enter Your Basic Pay" name="pay">
                          <span class="icon-resp"></span>
                        </div>
                      </div>
                    </div>
                  </div>                  
                </div>
                <div class="col-md-6">
                  <label for="" class="text-green ftw-600">Non Qualify Service (Optional)</label>
                  <div class="row">
                    <div class="col-md-6 col-lg-4 form-group">
                      <div class="input-group">
                        <select class="form-control ny" name="non-year">
                          <option value="">Select Year</option>
                          @for ($i = 1; $i <= 22; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-4 form-group">
                      <div class="input-group">
                        <select class="form-control nm" name="non-month">
                          <option value="">Select Month</option>
                          @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12 col-lg-4 form-group">
                      <div class="input-group">
                        <select class="form-control nd" name="non-day">
                          <option value="">Select Day</option>
                          @for ($i = 1; $i <= date('t'); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="resp-top">
                      <label>Date of Birth: <span class="comp">*</span></label>
                      <div class="text"></div>
                    </div>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="dd/mm/YYYY" name="dob" id="dob" autocomplete="off">
                      <span class="icon-resp"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="resp-top">
                      <label>Date of Appointment: <span class="comp">*</span></label>
                      <div class="text"></div>
                    </div>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="dd/mm/YYYY" name="appointment" id="appointment" autocomplete="off">
                      <span class="icon-resp"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="resp-top">
                      <label>Date of Retirement: <span class="comp">*</span></label>
                      <div class="text"></div>
                    </div>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="dd/mm/YYYY" name="retirement" id="retirement" autocomplete="off">
                      <span class="icon-resp"></span>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="text-center mt-3">
                <button class="btn btn-submit text-uppercase btn-round" type="submit">
                Calculate
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <section class="pension-detail"></section>
    </div>
  </div>
</div>
{{-- <div class="message-box success-box sent-box" style="display: none">
      <div class="message-content">
          <h3 class="message-head" style="margin-bottom:10px;">Receive via Email <span class="close">×</span></h3>
          <span class="error-msg" style="color:red;margin-left:20px"></span>
          <div class="message-text">
              <input type="text" class="form-control" placeholder="Enter Your Email" name="pdf-email" autocomplete="off">
          </div>
          <button class="send-mail btn-mail2" type="button">Submit</button>
      </div>
</div> --}}
@php
  $res = DB::table("meta")->select("views")->where("page_name" , "pension-calculator")->first();
  $views = $res->views;
  refresh_views($views , 0 , 0 , "pension-calculator" );
@endphp
@include('front.layout.footer')
<script src="{{ asset('assets/js/chosen.js') }}"></script>
<script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
<script>
  var base_url = '{{ route('base_url') }}/downloads/';
  $('#dob').samask("00/00/0000");
  $('#appointment').samask("00/00/0000");
  $('#retirement').samask("00/00/0000");
  $("#dob,#appointment,#retirement").datepicker({
      format:'dd/mm/yyyy',
      autoHide:true,
  });
  $('#dob,#appointment,#retirement').change(function(e){
    var new_val = $(this).val();
    var new_val = new_val.replace(/(\d{2})(\d{2})(\d{4})/, "$1/$2/$3");
    $(this).val(new_val);
  });
  $('.full_name').on('keyup',function(){
    input_messages($(this),'Name');
  })
  $('.city').on('keyup',function(){
    input_messages($(this),'City');
  })
  $('.organization').on('keyup',function(){
    input_messages($(this),'Organization');
  })
  $('.designation').on('keyup',function(){
    input_messages($(this),'Designation');
  })
  $('.pay').on('keyup',function(){
    input_messages($(this),'Salary');
  })
  $('#dob').on('keyup',function(){
    date_messages($(this),'Date of Birth');
  })
  $('#retirement').on('keyup',function(){
    date_messages($(this),'Date of Retirement');
  })
  $('#appointment').on('keyup',function(){
    date_messages($(this),'Date of Appointment');
  })
  $('.pension_type').on('change',function(){
    dropdown_messages($(this),'Pension Type');
  });
  $('.pay_scal').on('change',function(){
    dropdown_messages($(this),'Pay Scale');
  });
  $('.pay').on('keypress',function(event){
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
  });
  function dropdown_messages(selector,name) {
    var value = selector.val().trim();
    if(value == ""){
      selector.next(".chosen-container").find('a').addClass('chosen-single-danger');
      selector.closest('.form-group').addClass('error-group').find('label:first').next('.text').html(name+' is required');
      return 'false';
    }else{
      selector.next(".chosen-container").find('a').removeClass('chosen-single-danger');
      selector.closest('.form-group').removeClass('error-group').find('label:first').next('.text').html('');
      return 'true';
    }
  }
  function date_messages(selector,name) {
    var value = selector.val().trim();
    var split = value.split('/');
    if(value == ""){
      selector.closest('.form-group').addClass('error-group').removeClass('success-group').find('label:first').next('.text').html(name+" is required");
      selector.next('.icon-resp').remove();
      selector.next('.toggle-icon').remove();
      $("<span class='icon-resp'><i class='icon-cancel-circle'></i></span>").insertAfter(selector);
      return 'false';
    }else if(split.length != 3 || split[0].length != 2 || split[1].length != 2 || split[2].length != 4){
      selector.closest('.form-group').addClass('error-group').removeClass('success-group').find('label:first').next('.text').html(name+" format is invalid");
      selector.next('.icon-resp').remove();
      selector.next('.toggle-icon').remove();
      $("<span class='icon-resp'><i class='icon-cancel-circle'></i></span>").insertAfter(selector);
      return 'false';
    }else{
      selector.closest('.form-group').removeClass('error-group').addClass('success-group').find('label:first').next('.text').html("");
      selector.next('.icon-resp').remove();
      selector.next('.toggle-icon').remove();
      $("<span class='icon-resp'><i class='icon-check_circle_outline'></i></span>").insertAfter(selector);
      return 'true';
    }
  }
  function input_messages(selector,name) {
    var value = selector.val().trim();
    if(value == ''){
      selector.closest('.form-group').addClass('error-group').removeClass('success-group').find('label:first').next('.text').html(name+" is required");
      selector.next('.icon-resp').remove();
      selector.next('.toggle-icon').remove();
      $("<span class='icon-resp'><i class='icon-cancel-circle'></i></span>").insertAfter(selector);
      return 'false';
    }else if(value.length < 3){
      selector.closest('.form-group').addClass('error-group').removeClass('success-group').find('label:first').next('.text').html("Min 3 ch are required");
      selector.next('.icon-resp').remove();
      selector.next('.toggle-icon').remove();
      $("<span class='icon-resp'><i class='icon-cancel-circle'></i></span>").insertAfter(selector);
      return 'false';
    }else if(value.length > 30){
      selector.closest('.form-group').addClass('error-group').removeClass('success-group').find('label:first').next('.text').html("Max 30 ch are required");
      selector.next('.icon-resp').remove();
      selector.next('.toggle-icon').remove();
      $("<span class='icon-resp'><i class='icon-cancel-circle'></i></span>").insertAfter(selector);
      return 'false';
    }else{
      selector.closest('.form-group').removeClass('error-group').addClass('success-group').find('label:first').next('.text').html("");
      selector.next('.icon-resp').remove();
      selector.next('.toggle-icon').remove();
      $("<span class='icon-resp'><i class='icon-check_circle_outline'></i></span>").insertAfter(selector);
      return 'true';
    }
  }
  $('.pension-form').on('submit',function(event){
    event.preventDefault();
    var name = $('.full_name').val();
    var organization = $('.organization').val();
    var designation = $('.designation').val();
    var pay = $('.pay').val();
    var city = $('.city').val();
    var type = $('.pension_type').val();
    var scale = $('.pay_scal').val();
    var ny = $('.ny').val();
    var nm = $('.nm').val();
    var nd = $('.nd').val();
    var retirement = $('#retirement').val();
    var appointment = $('#appointment').val();
    var birth = $('#dob').val();
    var url = '{{ route('calculate-pension') }}';
    var _token = '{{ csrf_token() }}';
    var error = 0;
    if(input_messages($('.full_name'),'Name') == 'false'){
      error = 1;
    }if(input_messages($('.organization'),'Organization') == 'false'){
      error = 1;
    }if(input_messages($('.designation'),'Designation') == 'false'){
      error = 1;
    }if(input_messages($('.pay'),'Pay') == 'false'){
      error = 1;
    }if(dropdown_messages($('.city'),'City') == 'false'){
      error = 1;
    }if(dropdown_messages($('.pension_type'),'Pension Type') == 'false'){
      error = 1;
    }if(dropdown_messages($('.pay_scal'),'Pay Scale') == 'false'){
      error = 1;
    }if(date_messages($('#dob'),'Date of Birth') == 'false'){
      error = 1;
    }if(date_messages($('#retirement'),'Date of Retirement') == 'false'){
      error = 1;
    }if(date_messages($('#appointment'),'Date of Appointment') == 'false'){
      error = 1;
    }
    if(error == 0){
      $.ajax({
        url:url,
        method:'POST',
        dataType:'html',
        data:{
          name:name,
          city:city,
          organization:organization,
          designation:designation,
          type:type,
          pay:pay,
          scale:scale,
          ny:ny,
          nm:nm,
          nd:nd,
          retirement:retirement,
          appointment:appointment,
          birth:birth,
          _token:_token,
        }, success:function(res){
          $('.pension-detail').html(res);
          $('.btn-email').click(function(){
            $(".sent-box").show(); 
            $('.send-mail').click(function(){
              alert('asd');
              var email = $('input[name="pdf-email"]').val().trim();
              var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

              if(pattern.test(email)){alert(email);}else{console.log('asdfas');$('.error-msg').html('Email format is invalid');}
            })
          })
          $([document.documentElement, document.body]).animate({
              scrollTop: $(".pension-detail").offset().top - 55
          }, 1000);
        }, error:function(e){
          console.log('error'+e);
        }
      });
    }
  })
</script>
</body>
</html>