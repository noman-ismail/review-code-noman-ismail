@include("admin.layout.header")
{{-- {{ dd($setting) }} --}}
<div class="body-content">
  <div class="card border-info">
    <div class="card-header bg-info">
      <div class="row">
        <div class="col-md-6">
          <div class="h5">SMS Setting</div>
        </div>
        <div class="col-md-6 text-right">
          {{-- <a href="{{ route('custom-sms') }}" class="btn btn-info">Custom SMS</a> --}}
        </div>
      </div>
    </div>
    <form action="{{ route('sms-setting') }}" method="POST">
      @csrf
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
            @if(count($errors) > 0)
                <ul class="alert alert-danger alert-dismissible fade show">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </ul>
            @endif
          </div>
          <div class="col-md-12">
            <fieldset style = "margin-top:10px;">
              <legend>Account Registration Message</legend>
              <div class="input-group mb-1">
                  <textarea name="acc_register" cols="30" rows="5" class="form-control count">{{ ((old('acc_register') != "")?old('acc_register'):(!empty($setting)))?$setting->acc_register:"" }}</textarea>
                  <div class="input-group-prepend ">
                    <div style="display: inline-grid; padding: 5px 3px 0px 10px; background-color: #efebe6">
                      <span class="">User Name: [[name]]</span>
                      <span class="">User CNIC: [[cnic]]</span>
                      <span class="">User City: [[city]]</span>
                    </div>
                  </div>
              </div>
              <div class="form-row mt-0 pr-2 pl-2">
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">SMS: <span class="sms"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Characters: <span class="counter"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Remaining: <span class="remaining"></span></span>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" {{ ($setting->ac_rgstr == "on")?'checked':"" }} class="custom-control-input" id="customSwitches" name="ac_rgstr">
                  <label class="custom-control-label font-weight-600" for="customSwitches" style="padding: 8px 0px 0px 33px;">Default SMS Button</label>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-12">
            <fieldset style = "margin-top:10px;">
              <legend>Account Approval Message</legend>
              <div class="input-group mb-1">
                  <textarea name="acc_aproval" cols="30" rows="5" class="form-control count">{{ ((old('acc_aproval') != "")?old('acc_aproval'):(!empty($setting)))?$setting->acc_aproval:"" }}</textarea>
                  <div class="input-group-prepend ">
                    <div style="display: inline-grid; padding: 5px 3px 0px 10px; background-color: #efebe6">
                      <span class="">User Name: [[name]]</span>
                      <span class="">User CNIC: [[cnic]]</span>
                      <span class="">User City: [[city]]</span>
                    </div>
                  </div>
              </div>
              <div class="form-row mt-0 pr-2 pl-2">
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">SMS: <span class="sms"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Characters: <span class="counter"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Remaining: <span class="remaining"></span></span>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" {{ ($setting->ac_apr == "on")?'checked':"" }} class="custom-control-input" id="customSwitches8" name="ac_apr">
                  <label class="custom-control-label font-weight-600" for="customSwitches8" style="padding: 8px 0px 0px 33px;">Default SMS Button</label>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-12">
            <fieldset style = "margin-top:10px;">
              <legend>Account Rejection Message</legend>
              <div class="input-group mb-1">
                  <textarea name="acc_rejection" cols="30" rows="5" class="form-control count">{{ ((old('acc_rejection') != "")?old('acc_rejection'):(!empty($setting)))?$setting->acc_rejection:"" }}</textarea>
                  <div class="input-group-prepend ">
                    <div style="display: inline-grid; padding: 5px 3px 0px 10px; background-color: #efebe6">
                      <span class="">User Name: [[name]]</span>
                      <span class="">User CNIC: [[cnic]]</span>
                      <span class="">User City: [[city]]</span>
                      <span class="">Reason: [[reason]]</span>
                    </div>
                  </div>
              </div>
              <div class="form-row mt-0 pr-2 pl-2">
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">SMS: <span class="sms"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Characters: <span class="counter"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Remaining: <span class="remaining"></span></span>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" {{ ($setting->ac_rej == "on")?'checked':"" }} class="custom-control-input" id="customSwitches2" name="ac_rej">
                  <label class="custom-control-label font-weight-600" for="customSwitches2" style="padding: 8px 0px 0px 33px;">Default SMS Button</label>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-12">
            <fieldset style = "margin-top:10px;">
              <legend>Forgot Password Message</legend>
              <div class="input-group mb-1">
                  <textarea name="forgot_password" cols="30" rows="4" class="form-control count">{{ ((old('forgot_password') != "")?old('forgot_password'):(!empty($setting)))?$setting->forgot_password:"" }}</textarea>
                  <div class="input-group-prepend ">
                    <div style="display: inline-grid; padding: 5px 3px 0px 10px; background-color: #efebe6">
                      <span class="">User Name: [[name]]</span>
                      <span class="">Password: [[password]]</span>
                      <span class="">Security Image: [[security_img]]</span>
                    </div>
                  </div>
              </div>
              <div class="form-row mt-0 pr-2 pl-2">
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">SMS: <span class="sms"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Characters: <span class="counter"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Remaining: <span class="remaining"></span></span>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" {{ ($setting->forgot_pass == "on")?'checked':"" }} class="custom-control-input" id="customSwitches3" name="forgot_pass">
                  <label class="custom-control-label font-weight-600" for="customSwitches3" style="padding: 8px 0px 0px 33px;">Default SMS Button</label>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-12">
            <fieldset style = "margin-top:10px;">
              <legend>Add Fund Message</legend>
              <div class="input-group mb-1">
                  <textarea name="add_fund" cols="30" rows="2" class="form-control count">{{ ((old('add_fund') != "")?old('add_fund'):(!empty($setting)))?$setting->add_fund:"" }}</textarea>
                  <div class="input-group-prepend ">
                    <div style="display: inline-grid; padding: 5px 3px 0px 10px; background-color: #efebe6">
                      <span class="">User Name: [[name]]</span>
                      <span class="">Receipt No: [[receipt-no]]</span>
                      <span class="">Fund Period: [[fund-period]]</span>
                      <span class="">Deposit To: [[collector]]</span>
                      <span class="">Amount: [[amount]]</span>
                    </div>
                  </div>
              </div>
              <div class="form-row mt-0 pr-2 pl-2">
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">SMS: <span class="sms"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Characters: <span class="counter"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Remaining: <span class="remaining"></span></span>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" {{ ($setting->add_fund_toggle == "on")?'checked':"" }} class="custom-control-input" id="customSwitches4" name="add_fund_toggle">
                  <label class="custom-control-label font-weight-600" for="customSwitches4" style="padding: 8px 0px 0px 33px;">Default SMS Button</label>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-12">
            <fieldset style = "margin-top:10px;">
              <legend>Death Request Message</legend>
              <div class="input-group mb-1">
                  <textarea name="death_req" cols="30" rows="2" class="form-control count">{{ ((old('death_req') != "")?old('death_req'):(!empty($setting)))?$setting->death_req:"" }}</textarea>
                  <div class="input-group-prepend ">
                    <div style="display: inline-grid; padding: 5px 3px 0px 10px; background-color: #efebe6">
                      <span class="">User Name: [[name]]</span>
                    </div>
                  </div>
              </div>
              <div class="form-row mt-0 pr-2 pl-2">
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">SMS: <span class="sms"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Characters: <span class="counter"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Remaining: <span class="remaining"></span></span>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" {{ ($setting->deth_req == "on")?'checked':"" }} class="custom-control-input" id="customSwitches5" name="deth_req">
                  <label class="custom-control-label font-weight-600" for="customSwitches5" style="padding: 8px 0px 0px 33px;">Default SMS Button</label>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-12">
            <fieldset style = "margin-top:10px;">
              <legend>Death Approval Message</legend>
              <div class="input-group mb-1">
                  <textarea name="death_aproval" cols="30" rows="2" class="form-control count">{{ ((old('death_aproval') != "")?old('death_aproval'):(!empty($setting)))?$setting->death_aproval:"" }}</textarea>
                  <div class="input-group-prepend ">
                    <div style="display: inline-grid; padding: 5px 3px 0px 10px; background-color: #efebe6">
                      <span class="">User Name: [[name]]</span>
                    </div>
                  </div>
              </div>
              <div class="form-row mt-0 pr-2 pl-2">
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">SMS: <span class="sms"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Characters: <span class="counter"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Remaining: <span class="remaining"></span></span>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" {{ ($setting->death_apr == "on")?'checked':"" }} class="custom-control-input" id="customSwitches7" name="death_apr">
                  <label class="custom-control-label font-weight-600" for="customSwitches7" style="padding: 8px 0px 0px 33px;">Default SMS Button</label>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-12">
            <fieldset style = "margin-top:10px;">
              <legend>Death Rejection Message</legend>
              <div class="input-group mb-1">
                  <textarea name="death_rejection" cols="30" rows="3" class="form-control count">{{ ((old('death_rejection') != "")?old('death_rejection'):(!empty($setting)))?$setting->death_rejection:"" }}</textarea>
                  <div class="input-group-prepend ">
                    <div style="display: inline-grid; padding: 5px 3px 0px 10px; background-color: #efebe6">
                      <span class="">User Name: [[name]]</span>
                      <span class="">Reason: [[reason]]</span>
                    </div>
                  </div>
              </div>
              <div class="form-row mt-0 pr-2 pl-2">
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">SMS: <span class="sms"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Characters: <span class="counter"></span></span>
                <span class="col-md-2 text-left" style="border: 1px solid seagreen;">Remaining: <span class="remaining"></span></span>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" {{ ($setting->death_rej == "on")?'checked':"" }} class="custom-control-input" id="customSwitches6" name="death_rej">
                  <label class="custom-control-label font-weight-600" for="customSwitches6" style="padding: 8px 0px 0px 33px;">Default SMS Button</label>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-12 text-right mt-3">
            <button class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>  
</div><!--/.body content-->
<script>
  $(document).ready(function(){
    var count = $('.count');
    $.each(count , function(i,v){
      var c = $(this).val().length;
      var sms = Math.ceil(parseInt(c)/parseInt(160));
      var rm = parseInt(160)-parseInt(c);
      if (rm < 0) {
        var t = parseInt(160)*parseInt(sms);
        rm = parseInt(t)-parseInt(c)
      }
      $(this).parent('div').next('.form-row').find('span .remaining').html(rm);
      $(this).parent('div').next('.form-row').find('span .sms').html(sms);
      $(this).parent('div').next('.form-row').find('span .counter').html(c);
    });
    $('.count').keyup(function(){
      var c = $(this).val().length;
      var sms = Math.ceil(parseInt(c)/parseInt(160));
      var rm = parseInt(160)-parseInt(c);
      if (rm < 0) {
        var t = parseInt(160)*parseInt(sms);
        rm = parseInt(t)-parseInt(c)
      }
      $(this).parent('div').next('.form-row').find('span .remaining').html(rm);
      $(this).parent('div').next('.form-row').find('span .sms').html(sms);
      $(this).parent('div').next('.form-row').find('span .counter').html(c);
    });
  })
</script>
@include("admin.layout.footer")