@include("admin.layout.header")
<style>
  .security label{
    display: inline-block;
     width: 45px;
    height: 45px;
    margin: 7px;
    /*margin: 6px 14px 6px;*/
  }
  .security label > input:checked + i{
    border: 3px solid #b212e6;
    color: #b212e6;
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
          <h6 class="fs-17 font-weight-600 mb-0">Province User List</h6>
        </div>
        {{-- <div class="text-right">
          <a href="{{ route('copyist-u-list') }}" class="btn btn-sm btn-secondary">Agency User List</a>
          <a href="{{ route('add-copyist-user') }}" class="btn btn-sm btn-info">Add New</a>
        </div> --}}
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
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
          <div class="_msgtop"></div>
        </div>
        @if(!isset($user))
          <div class="col-md-12">
            <table class="table">
              <thead class="bg-info text-white">
                <tr>
                  <th>Name</th>
                  <th>Username</th>
                  <th>
                    @if(request()->has('sort'))
                      @if(request('sort') == 'asc')
                        <a href="{{ route('province-u-list')."?sort=desc" }}" title="Desending" style="color: white">Panel Name</a>
                      @php
                        $record = ArrangeCity($record , request('sort') , 'province')
                      @endphp
                      @elseif(request('sort') == 'desc')
                        <a href="{{ route('province-u-list')."?sort=asc" }}" title="Ascending" style="color: white">Panel Name</a>
                      @php
                        $record = ArrangeCity($record , request('sort') , 'province')
                      @endphp
                      @else
                        <a href="{{ route('province-u-list')."?sort=asc" }}" title="Ascending" style="color: white">Panel Name</a>                      
                      @endif
                    @else
                      <a href="{{ route('province-u-list')."?sort=asc" }}" title="Ascending" style="color: white">Panel Name</a>
                    @endif
                  </th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="text-dark">
              @if(count($record) > 0)
                @php
                  $i=1;
                @endphp
                @foreach($record as $value)
                  <tr class="{{ ($value->status == "off")?"":"table-success" }}" >
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->username }}</td>
                    <td>{{ get_dept_name($value->dept_id,'province') }}</td>
                    <td>{{ date('d/m/Y H:i:s a',strtotime($value->created_at)) }}</td>
                    <td>
                      @if($value->status == 'off')
                        <div class="custom-control custom-switch">
                          <input type="checkbox" data-id = '{{ $value->id }}' class="custom-control-input change_status" id="customSwitches{{ $i }}" name="court_sms" data-status = "off">
                          <label class="custom-control-label font-weight-600" for="customSwitches{{ $i }}" style="padding: 8px 0px 0px 33px;margin-top: -7px;"></label>
                        </div>
                      @elseif($value->status == 'on')
                        <div class="custom-control custom-switch">
                          <input type="checkbox" data-id = '{{ $value->id }}' checked class="custom-control-input change_status" id="customSwitches{{ $i }}" data-status = "on" name="court_sms">
                          <label class="custom-control-label font-weight-600" for="customSwitches{{ $i }}" style="padding: 8px 0px 0px 33px;margin-top: -7px;"></label>
                        </div>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('province-u-list').'?id='.$value->id }}"><i class="fa fa-edit"></i></a>
                      <a href="{{ route('province-u-list').'?del='.$value->id }}" onclick="return confirm('Are You Sure?');"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  @php
                    $i++;
                  @endphp
                @endforeach
              @else
                <tr class="text-center bg-info">
                  <td colspan="7">There is no record</td>
                </tr>
              @endif
              </tbody>
            </table>
          </div>
        @endif
        <div class="col-md-12">
          @if(isset($user))
            <form action="{{ route('province-u-list').'?id='.request('id')  }}" method="POST">
            @csrf
              <fieldset>
                <legend>Update User</legend>
                <div class="row">
                  <div class="col-md-6 col-6">
                    <div class="form-group">
                      <label for="">Panel For <span class="required">*</span></label>
                      {{-- <input type="text" name="panel_for" class="panel_for form-control" value="Pakistan" readonly> --}}
                      <select name="panel_for" class="form-control form-control-chosen panel_for">
                        <option value="">Choose an Option</option>
                        @if(count($province) > 0)
                          @foreach($province as $value)
                            <option value="{{ $value->id }}" {{ ((old('panel_for') == $value->id)?"selected":($user->dept_id == $value->id))?'selected':"" }}>{{ $value->name }}</option>
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
                      <input type="text" name="user_name" class="user_name form-control" placeholder="Enter User Full Name" value="{{ (old('user_name') != "")?old('user_name'):$user->name }}" >
                      <div style="color:red" class="_erruserfullname"></div>
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
                            <option value="{{ $value->id }}" {{ ((old('official_designation') == $value->id)?"selected":($user->official_dsg == $value->id))?'selected':"" }}>{{ $value->name }} </option>
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
                      <select name="society_designation" class="form-control form-control-chosen">
                        <option value="">Select an Option</option>
                        @if(count($society_dsg) > 0)
                          @foreach($society_dsg as $value)
                            <option value="{{ $value->id }}" {{ ((old('society_designation') == $value->id)?"selected":($user->society_dsg == $value->id))?'selected':"" }}>{{ $value->name }} </option>
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
                      <select name="city" class="form-control form-control-chosen">
                        <option value="">Select an Option</option>
                        @if(count($cities) > 0)
                          @foreach($cities as $value)
                            <option value="{{ $value->id }}" {{ ((old('city') == $value->id)?"selected":($user->city == $value->id))?'selected':"" }}>{{ $value->name }} </option>
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
                      <label for="">Contact No<span class="required">*</span></label>
                      <input type="text" name="mobile" id="mobile" class="form-control" value="{{ (old('mobile')!="")?old('mobile'):$user->mobile }}">
                        <div style="color:red" class="_errobile"></div>
                      @if(count($errors) > 0)
                        @foreach($errors->get('mobile') as $error)
                          <div class="text-danger">{{ $error }}</div>
                        @endforeach 
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="">Email</label>
                      <input type="text" name="email" id="email" class="form-control email" value="{{ (old('email')!="")?old('email'):$user->email }}">
                        <div style="color:red" class="_erremail"></div>
                      @if(count($errors) > 0)
                        @foreach($errors->get('email') as $error)
                          <div class="text-danger">{{ $error }}</div>
                        @endforeach 
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="">Username <span class="required">*</span> 
                        <span class="text-right"><i style="cursor: hand; font-size: 25px; color: green; vertical-align: middle; cursor: pointer;" class="fa fa-question-circle" title="Username has only Small letters , Numbers , Dashes( - ) and Underscors( _ ) "></i></span>
                      </label>
                      <input type="text" readonly name="username" class="username form-control"value="{{ (old('username') != '')?old('username'):$user->username  }}" > 
                      <div style="color:red" class="_errusername"></div>
                      @if(count($errors) > 0)
                        @foreach($errors->get('username') as $error)
                          <div class="text-danger">{{ $error }}</div>
                        @endforeach 
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="">Password <span class="required">*</span></label>
                      <input type="password" name="password" class="form-control password" value="{{ base64_decode($user->enc) }}">
                      <span toggle="#password-field" class="fa fa-fw field-icon toggle-password fa-eye"></span>
                      <div style="color:red" class="_errpassword"></div>
                      @if(count($errors) > 0)
                        @foreach($errors->get('password') as $error)
                          <div class="text-danger">{{ $error }}</div>
                        @endforeach 
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="">Security Image  <span class="required">*</span></label>
                      <div style="color: red" class="_errsecurity_img"></div>
                      @if(count($errors) > 0)
                        @foreach($errors->get('security_image') as $error)
                          <div class="text-danger">{{ $error }}</div>
                        @endforeach 
                      @endif
                      <div class="security" style="box-sizing: border-box;">
                        <div class="d-flex flex-row mb-3 "  style="flex-wrap: wrap;">
                          @php 
                            $shuffle_img = get_security_img();
                          @endphp
                          @foreach($shuffle_img as $v)
                            <label title="{{ $v['title'] }}">
                              <input type="radio" name="security_image" value="{{ $v['value'] }}" class="radio-input security_image" {{ ($v['value'] == base64_decode($user->s_img))?'checked':"" }}> 
                              <i class="fa {{ $v['i'] }}" aria-hidden="true"></i>
                            </label>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-6">
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
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6 pl-4">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" checked class="custom-control-input" id="customSwitches3" name="sms">
                          <label class="custom-control-label font-weight-600" for="customSwitches3" style="padding: 8px 0px 0px 33px;">SMS</label>
                        </div>
                      </div>
                      <div class="text-right pr-4">
                        <button class="btn btn-success submit" type="submit">Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>
  </div><!--/.body content-->
  <script>
    $(document).ready(function(){
      var SMSformat = {
        name : "",
        line1 : "You have been added as new ",
        line3 : " member. ",
        line2 : "URL: "+base_url+admin,
        username : "",
        password : "",
        security_img : "",
        panel : "[[panel]]",
        display:function(){
          var html = "Dear "+this.name+"\n";
          html+=this.line1+this.panel+this.line3+"\n";
          html+=this.line2+"\n";
          html+="Username: "+this.username+"\n";
          html+="Password: "+this.password+"\n";
          html+="Security image is: "+this.security_img;
          $(".sms_format").val(html);
          $(".character").text(html.length);
          $(".word").text(html.split(" ").length);
          $(".t_sms").text(Math.ceil(parseInt(html.length) / parseInt(160)));
        }
      };
      SMSformat.name = $('.user_name').val();
      SMSformat.username = $('.username').val();
      SMSformat.password = $('.password').val();
      SMSformat.security_img = $('input[name="security_image"]:checked').parent().attr('title');
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
      var valdfa = $('.panel_for option:selected');
      if(valdfa.val() > 0){
        SMSformat.panel = valdfa.html();
        SMSformat.display();
      }
      $('.panel_for').change(function(){
        $('._errpanel_for').text('');
        var val = $('.panel_for option:selected');
        if(val.val() > 0){
          SMSformat.panel = val.html();
          SMSformat.display();
        }
      })
      $('.radio-input').change(function(){
        $('.radio-input').next("i").css('border','2px solid rgb(0, 128, 0)');
        $('.radio-input').next("i").css('color','rgb(0, 128, 0)');
        SMSformat.security_img = "[[img]]";
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
    })
    $('.change_status').click(function() {
      var thi = $(this);
      var id = $(this).attr('data-id');
      var status = $(this).attr('data-status');
      var url = base_url+admin+'/change-status';
      $.ajax({
        url:url,
        method:'POST',
        dataType:'json',
        data:{
          action:'change',
          id:id,
          status:status,
          _token:_token,
        }, success:function(res){
          if(res == 'success'){
            $('._msgtop').text('Status is changed successfully');
            $('._msgtop').addClass('alert alert-success');
            if(status == 'on'){
              console.log('if');
              thi.prop('checked',false);
              thi.closest('tr').removeClass('table-success');
              thi.attr('data-status','off');
            }else{
              console.log('elseif');
              thi.prop('checked',true);
              thi.closest('tr').addClass('table-success');
              thi.attr('data-status','on');
            }
          }else{
            console.log('else');
            thi.prop('checked',false);
            $('._msgtop').text(res);
            $('._msgtop').addClass('alert alert-danger');
          }
        }, error:function(e){
          alert(e);
        }
      })
    });
    $('.radio-input').change(function(){
      $('.radio-input').next("i").css('border','2px solid rgb(0, 128, 0)');
      $('.radio-input').next("i").css('color','rgb(0, 128, 0)');
      if($(this).prop("checked") == true){
        $(this).parent().find('i').css('border','3px solid #b212e6');
        $(this).parent().find('i').css('color','#b212e6');
      }
      // $radio.closest('label') .css('color','green');
    })
    $('.national_name').change(function(){
      $('._errnational_name').text('');
    })
      $('.panel_for').change(function(){
        $('._errpanel_for').text('');
      })
    $('.user_name').focus(function(){
      $('._erruserfullname').text('');
    })
      $('.email').focus(function(){
        $('._erremail').text('');
      })
    $('.username').focus(function(){
      $('._errusername').text('');
    })
    $('.password').focus(function(){
      $('._errpassword').text('');
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
          var action = 'copyist';
          var full_name = $('.user_name').val();
          var staff_designation = $('.panel_for').val();
          var username = $('.username').val();
          var password = $('.password').val();
          var email = $('.email').val().trim();
          var mobile = $('#mobile').val();
          mobile = mobile.replace(/[^0-9]/g,'');
            if($('.security_image').is(':checked')){
              var security_image = $('.security_image').val();
            }else{
              var security_image = '';
            }if(security_image == ''){
              $('._errsecurity_img').text('Please select your security image');
              eee++;
            }if(staff_designation == ''){
              $('._errpanel_for').text('Choose an option for panel');
              eee++;
            }if(password == ''){
              $('._errpassword').text('Password field is required');
              eee++;
            }else if(password.length < 5){
              $('._errpassword').text('Password field contains minimum 4 characters');
            }
          if(username == ''){
            $('._errusername').text('Username field is required');
            eee++;
          }else if(username.length < 5){
            $('._errusername').text('Username contains minimum 5 characters');
            eee++;
          }if(full_name == ''){
            $('._erruserfullname').text('Full name field is required');
            eee++;
          }if(email != ""){
            if(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(email) === false) {
              $('._erremail').text('Email format is invalid');
              eee++;
            }
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
        }  else{
        console.log('kk');
        return false;
      }
    })      
    $('.username').bind('keyup blur',function(){
        var node = $(this);
        node.val(node.val().replace(/[^a-z0-9-_]/g,'') ); }
    );
  </script>
@include("admin.layout.footer")