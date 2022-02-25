@include("admin.layout.header")
<style>
  .security label{
    display: inline-block;
     width: 45px;
    height: 45px;
    margin: 7px;
    /*margin: 6px 14px 6px;*/
  }
  .security label > input {
    visibility: hidden;
    position: absolute;
  }
  .security label > i {
    vertical-align: middle;
    font-size: 28px;
    color: green;
  }
  .security label > input + i {
    cursor: pointer;
    border: 2px solid rgb(0, 128, 0);
    margin: 0px 5px 0px 0px;
    padding: 3px;
    border-radius: 5px;
    box-shadow: 0 0 black;
    width: 100%;
    text-align: center;
  }
</style>
<div class="body-content">
  <div class="card mb-4 border-info">
    <div class="card-header bg-info text-white">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Add Province User</h6>
        </div>{{-- 
        <div class="text-right">
          <a href="{{ route('librarian-u-list') }}" class="btn btn-sm btn-info">Librarian List</a>
          <a href="{{ route('add-library-user') }}" class="btn btn-sm btn-secondary">Add New</a>
        </div> --}}
      </div>
    </div>
    <form action="{{ route('add-p-user') }}" method="post" class="add-user-form">
      @csrf
      <div class="card-body">
            @if(session()->has("success"))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session("success") !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
          @if(session()->has("error"))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {!! session("error") !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
        <fieldset>
          <legend>Add New User</legend>
          {{-- @if(count($errors) > 0)
            @foreach($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
            @endforeach 
          @endif --}}
          <div class="__error" style="color: red"></div>
          <div class="row">
            <div class="col-md-12 mt-4">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Panel For <span class="required">*</span></label>
                    {{-- <input type="text" name="panel_for" class="panel_for form-control" value="Pakistan" readonly> --}}
                    <select name="panel_for" class="form-control form-control-chosen panel_for">
                      <option value="">Choose an Option</option>
                      @if(count($province) > 0)
                        @foreach($province as $value)
                          <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                      @endif
                    </select>
                    <div style="color:red" class="_errpanel_for"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('panel_for') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">User Full Name <span class="required">*</span></label>
                    <input type="text" name="user_name" class="user_name form-control" placeholder="Enter User Full Name" value="{{ old('user_name') }}" >
                    <div style="color:red" class="_errcourtname"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('user_name') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">Choose Official Designation </label>
                    <select name="official_designation" class="designation form-control form-control-chosen">
                      <option value="">Select an Option</option>
                      @if(count($ofc_dsg) > 0)
                        @foreach($ofc_dsg as $value)
                          <option value="{{ $value->id }}" {{ ((old('official_designation') == "")?"":(old('official_designation') == $value->id))?'selected':"" }}>{{ $value->name }} </option>
                        @endforeach
                      @endif
                    </select>
                    <div style="color:red" class="_errofcdesignation"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('official_designation') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">Choose Society Designation </label>
                    <select name="society_designation" class="designation form-control form-control-chosen">
                      <option value="">Select an Option</option>
                      @if(count($society_dsg) > 0)
                        @foreach($society_dsg as $value)
                          <option value="{{ $value->id }}" {{ ((old('society_designation') == "")?"":(old('society_designation') == $value->id))?'selected':"" }}>{{ $value->name }} </option>
                        @endforeach
                      @endif
                    </select>
                    <div style="color:red" class="_errdesignation"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('society_designation') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">Choose City </label>
                    <select name="city" class="designation form-control form-control-chosen">
                      <option value="">Select an Option</option>
                      @if(count($cities) > 0)
                        @foreach($cities as $value)
                          <option value="{{ $value->id }}" {{ ((old('city') == "")?"":(old('city') == $value->id))?'selected':"" }}>{{ $value->name }} </option>
                        @endforeach
                      @endif
                    </select>
                    <div style="color:red" class="_errcity"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('city') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">Contact No <span class="required">*</span></label>
                    <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}" placeholder="0300-1234567">
                    <div style="color:red" class="_errobile"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('mobile') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">Email </label>
                    <input type="email" name="email" class="form-control email" placeholder="Email" value="{{ old('email') }}" onkeyup="this.value=removeSpaces(this.value);">
                    <div style="color:red" class="_erremail"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('email') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">Username <span class="required">*</span> 
                      <span class="text-right"><i style="cursor: hand; font-size: 20px; color: green; vertical-align: middle; cursor: pointer;" class="fas fa-info-circle" title="Username has only Small letters , Numbers , Dashes( - ) and Underscors( _ ) "></i></span>
                    </label>
                    <input type="text" name="username" class="form-control username" placeholder="Username" value="{{ old('username') }}" onkeyup="this.value=removeSpaces(this.value);">
                    <div style="color:red" class="_errusername"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('username') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">Password <span class="required">*</span></label>
                    <input type="password" name="password" class="password form-control" placeholder="Password" value="{{ old('password') }}">
                    <div style="color:red" class="_errpassword"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('password') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="">Security Image <span class="required">*</span></label>
                    <div style="color: red" class="_errsecurity_img"></div>
                    @if(count($errors) > 0)
                      @foreach($errors->get('security_image') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                    <div class="security" style="box-sizing: border-box;">
                      <div class="d-flex flex-row mb-3 " style="flex-wrap: wrap;">
                        @php 
                          $shuffle_img = get_security_img();
                        @endphp
                        @foreach($shuffle_img as $v)
                          <label title="{{ $v['title'] }}">
                            <input type="radio" name="security_image" value="{{ $v['value'] }}" class="radio-input security_image"> 
                            <i class="fa {{ $v['i'] }}" aria-hidden="true"></i>
                          </label>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">SMS Format<span class="required">*</span></label>
                    <textarea class="form-control sms_format" name="sms_format" rows="10"></textarea>
                    @if(count($errors) > 0)
                      @foreach($errors->get('sms_format') as $error)
                        <div class="text-danger">{{ $error }}</div>
                      @endforeach 
                    @endif
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      Total Characters <span class="character badge badge-sm badge-success"></span>
                    </div>
                    <div class="col-md-4">
                      Total Words <span class="word badge badge-sm badge-success"></span>
                    </div>
                    <div class="col-md-4">
                      Total SMS <span class="t_sms badge badge-sm badge-success"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-2 pl-4">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" checked class="custom-control-input" id="customSwitches" name="sms">
                        <label class="custom-control-label font-weight-600" for="customSwitches" style="padding: 8px 0px 0px 33px;">SMS</label>
                      </div>
                    </div>
                    <div class="col-md-2 pl-4">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" checked class="custom-control-input" id="customSwitches2"name="status">
                        <label class="custom-control-label font-weight-600" for="customSwitches2" style="padding: 8px 0px 0px 33px;">Status</label>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button class="btn btn-success submit" type="submit">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </fieldset>
      </div>
    </form>
  </div>
  </div><!--/.body content-->
  <script>
    function removeSpaces(string) {
     return string.split(' ').join('');
    }
    $(document).ready(function(){
      var SMSformat = {
        name : "[[name]]",
        line1 : "You have been added as new ",
        line3 : " member. ",
        line2 : "URL: "+base_url+admin,
        username : "[[username]]",
        password : "[[password]]",
        security_img : "[[security-img]]",
        panel : "[[panel]]",
        display:function(){
          var html = "Dear "+this.name+"\n";
          html+=this.line1+this.panel+this.line3+"\n";
          html+=this.line2+"\n";
          html+="Username: "+this.username+"\n";
          html+="Password: "+this.password+"\n";
          html+="Security image is "+this.security_img;
          $(".sms_format").val(html);
          $(".character").text(html.length);
          $(".word").text(html.split(" ").length);
          $(".t_sms").text(Math.ceil(parseInt(html.length) / parseInt(160)));
        }
      };
      SMSformat.display();
      $('.user_name , .username , .password').keyup(function(){
        var name = $('.user_name').val().trim();
        if(name==""){
          SMSformat.name = "[[name]]";
        }else{
          SMSformat.name = name;
        }
        var username = $('.username').val().trim();
        if(username==""){
          SMSformat.username = "[[username]]";
        }else{
          SMSformat.username = username;
        }
        var password = $('.password').val().trim();
        if(password==""){
          SMSformat.password = "[[password]]";
        }else{
          SMSformat.password = password;
        }
          SMSformat.display();
      });
      $('.radio-input').change(function(){
        $('.radio-input').next("i").css('border','2px solid rgb(0, 128, 0)');
        $('.radio-input').next("i").css('color','rgb(0, 128, 0)');
        // SMSformat.security_img = "[[img]]";
        if($(this).prop("checked") == true){
          $(this).parent().find('i').css('border','3px solid #b212e6');
          $(this).parent().find('i').css('color','#b212e6');
          var img = $(this).parent().attr('title');
            SMSformat.security_img = img;
        }
            SMSformat.display();
        $radio.closest('label') .css('color','green');
      })
      $('.sms_format').on('keypress , keyup' , function(){
        var dfadfa = $(this).val().trim();
        $('.word').text(dfadfa.split(" ").length);
        $('.character').text(dfadfa.length);
        $(".t_sms").text(Math.ceil(parseInt(dfadfa.length) / parseInt(160)));
      })
      $('.panel_for').change(function(){
        $('._errpanel_for').text('');
        var val = $('.panel_for option:selected');
        if(val.val() > 0){
          SMSformat.panel = val.html();
          SMSformat.display();
        }
      })
      $('.user_name').focus(function(){
        $('._errcourtname').text('');
      })
      $('.username').focus(function(){
        $('._errusername').text('');
      })
      $('.password').focus(function(){
        $('._errpassword').text('');
      })
      $('.email').focus(function(){
        $('._erremail').text('');
      })
      $('#mobile').focus(function(){
        $('._errobile').text('');
      })
      $('.security_image').click(function(){
        $('._errsecurity_img').text('');
      })
      $('.submit').click(function(e){
          e.preventDefault();
          var eee = 0;
          var action = 'national';
          var full_name = $('.user_name').val();
          var staff_designation = $('.panel_for').val();
          var username = $('.username').val();
          var email = $('.email').val().trim();
          var password = $('.password').val();
          if($('.security_image').is(':checked')){
            var security_image = $('.security_image').val();
          }else{
            var security_image = '';
          }
          var pass_length = password.length;
          var mobile = $('#mobile').val();
          if(mobile.length != 12){
            eee++;
            $('._errobile').text('Mobile format is invalid');
          }
          mobile = mobile.replace(/[^0-9]/g,'');
          if(username == ''){
            $('._errusername').text('Username field is required');
            eee++;
          }else if(username.length < 5){
            $('._errusername').text('Username contains minimum 5 characters');
            eee++;
          }if(full_name == ''){
            $('._errcourtname').text('Full name field is required');
            eee++;
          }if(security_image == ''){
            $('._errsecurity_img').text('Select one security image');
            eee++;
          }if(staff_designation == ''){
            $('._errpanel_for').text('Choose an option for panel');
            eee++;
          }if(email != ""){
            if(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(email) === false) {
              $('._erremail').text('Email format is invalid');
              eee++;
            }
          }
          if(password == ''){
            $('._errpassword').text('Password field is required');
            eee++;
          }else if(pass_length < 4){
            $('._errpassword').text('Password contain minimum 4 characters.');
            eee++;              
          }else if(pass_length > 20 ){
            $('._errpassword').text('Password contain maximum 20 characters.');
            eee++;              
          }
          if(mobile == ''){
            $('._errobile').text('Mobile field is required');
            eee++;
          }else if (mobile.length != 11)
          {
            $('._errobile').text('Mobile formate is incorrect');
            eee++;
          }
          if(eee == 0){
              $('form').submit();
          }else{
            return false;
          }
      })      
      $('.username').bind('keyup blur',function(){
          var node = $(this);
          node.val(node.val().replace(/[^a-z0-9-_]/g,'') ); }
      );
    })
  </script>
@include("admin.layout.footer")