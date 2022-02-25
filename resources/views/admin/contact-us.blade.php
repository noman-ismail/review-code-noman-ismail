@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
@endphp
@if ($__userType == 'admin')
  @include('admin.layout.header')
@elseif($__userType == 'district')
  @include('admin.district.layouts.header')
@elseif($__userType == 'province')
  @include('admin.province.layouts.header')
@elseif($__userType == 'national')
  @include('admin.national.layouts.header')
@endif
@php
tiny_editor();
@endphp
<div class="body-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Contact us </h6>
                        </div>
                        <div class="text-right">
                            <div class="actions">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (Session::has('flash_message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! Session('flash_message') !!}</strong>
                    </div>
                    @endif
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="/<?=admin?>/contactus/store" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                @php
                                    $url = (Request::get('edit')) !="" ? "":"slug";
                                @endphp
                                    <div class="form-group col-md-12 p-0">
                                        <label class="font-weight-600">Meta Title</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ isset($data)?$data->meta_title:''}}" data-count="text">
                                            <div class="input-group-append">
                                                <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_title):'0'}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 p-0">
                                        <label class="font-weight-600">Meta Description</label>
                                        <div class="input-group">
                                            <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ isset($data)?$data->meta_description:''}}</textarea>
                                            <div class="input-group-append">
                                                <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_description):'0'}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 p-0">
                                        <label class="font-weight-600">Meta Tags</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ isset($data)?$data->meta_tags:''}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text count countshow">{{ isset($data)?count(explode(",",$data->meta_tags)):'0'}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 p-0">
                                        <div class="schema-rows">
                                            @php
                                            $schema = isset($data)? json_decode($data->microdata , true) : array();
                                            $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                                            for ($n=0; $n <=$t_quotes; $n++){ $schema_d=(isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "" ;
                                             $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                                            $style=( isset($schema[$n]["type"]) and $schema[$n]["type"] !="" ) ? 'style="display: none;"': "" ;
                                            $icon=(isset($schema[$n]["type"]) and $schema[$n]["type"] !="") ? '<i class="fa fa-edit"></i>': '' ;
                                            @endphp <div class="new-schema border row p-2">
                                                <span class="clear-data2">x</span>
                                                <div class="col-lg-12">
                                                    <div class="flex-center"><b><span class="no">{{ $n+1 }} &nbsp; - &nbsp; </span></b> <span class="schma_type">{{ $type }} {!! $icon !!}</span> <input  type="text" name="type[]" placeholder="schema name here" value="{{ $type }}"  {!! $style !!} >  </div> <br>
                                                    <div class="form-row">
                                                        <div class="form-group col-lg-12">
                                                            <textarea rows="6" name="schema[]" class="form-control" placeholder="Schema tag here...">{!! $schema_d !!}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                            }
                                            @endphp
                                        </div>
                                    </div>
                                    <div style="text-align:right;">
                                        <a href="" class="btn btn-info add-more-schema text-white"><b>Add More</b></a>
                                    </div>
                                
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Receiving Email <small> Multiple Emails seprated by comma</small></label>
                                    <input type="text" name="r_email" class="form-control" placeholder="{{ 'example@gmail.com , example2@gmail.com' }}"  value="{{ isset($data)?$data->r_email:''}}" >
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Contact TItle" value="{{ isset($data)?$data->title:''}}" >
                                </div>
                                <div class="form-group">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Google Map </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-md-12 p-0">
                                                <div class="row">
                                                    <div class="col-md-6"><label class="font-weight-600">Google Map: </label></div>
                                                    <div class="col-md-6 text-right mb-1">
                                                    {{-- <button class="btn btn-sm btn-info" type="button"></button> --}}
                                                        <button class="btn btn-success btn-info md-trigger mb-2 mr-1" data-modal="modal-2" type="button">Watch Toturial</button>
                                                    </div>
                                                </div>
                                                <textarea class="form-control" rows="5" name="google_map" id="oneditor">{{ isset($data)?$data->google_map:''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6" style="display: {{ (auth('admin')->user()->type == 'admin') ? "none" : "block" }}">
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Office Details </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-md-12 p-0">
                                                <label class="font-weight-600">Email Title</label>
                                                <input type="text" name="email_title" placeholder="e.g Our Emails" class="form-control"  value="{{ isset($data)?$data->email_title:''}}" >
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 col-md-12 ">
                                                    <label class="font-weight-600">Email</label>
                                                    <textarea class="form-control" rows="2" name="email" placeholder="{{ 'example@gmail.com' }}">{{ isset($data)?$data->email:''}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 p-0">
                                                <label class="font-weight-600">Phone Title</label>
                                                <input type="text" name="phone_title" placeholder="e.g Our Contact Number" class="form-control"  value="{{ isset($data)?$data->phone_title:''}}" >
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 col-md-12 ">
                                                    <label class="font-weight-600">Phone </label>
                                                    <textarea class="form-control" rows="2" name="phone" placeholder="0303-7861234">{{ isset($data)?$data->phone:''}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 p-0">
                                                <label class="font-weight-600">Address Title</label>
                                                <input type="text" name="address_title" placeholder="e.g Office Address" class="form-control"  value="{{ isset($data)?$data->address_title:''}}" >
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 col-md-12 ">
                                                    <label class="font-weight-600">Address </label>
                                                    <textarea class="form-control" rows="2" name="address" >{{ isset($data)?$data->address:''}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Cover Image </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-lg-6 col-md-6">
                                                @php
                                                $cover = (isset($data) !="" and $data->cover !="") ? "<img src=".$data->cover." alt=''>" : "";
                                                @endphp
                                                <div class="uc-image" style="width: 97%;">
                                                    <input type="hidden" name="cover-image" value="{{ isset($data)? $data->cover :"" }}">
                                                    <div id="coover" class="image_display">
                                                        {!! $cover !!}
                                                    </div>
                                                    <div style="margin-top:10px;">
                                                        <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#coover" data-link="cover-image">Add Image</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                               $userdata =  _user_data();
                            @endphp
                            <input type="hidden" name="user_type" value="{{ $userdata['type'] }}">
                            <input type="hidden" name="district" value="{{ $userdata['district'] }}">
                            <input type="hidden" name="province" value="{{ $userdata['province'] }}">
                            <input type="hidden" name="natonal" value="{{ $userdata['natonal'] }}">
                            <input type="hidden" name="admin" value="{{ $userdata['admin'] }}">
                            @if ($__userType == 'admin' || $__userType == 'national')
                            <div class="form-group col-lg-12 col-md-12 p-0">
                                <div class="card">
                                    <div class="card-header card bg-secondary text-white">
                                        <b> Personal Details </b>
                                    </div>
                                    <div class="card-body">
                                        <div class="reviews">
                                        @php
                                        $res = isset($data->profile )? json_decode($data->profile , true) : array();
                                        $person_image = (isset($res["person_image"])) ? $res["person_image"]: "";
                                        $pr_name = (isset($res["pr_name"])) ? $res["pr_name"]: "";
                                        $pr_email = (isset($res["pr_email"])) ? $res["pr_email"]: "";
                                        $pr_designation = (isset($res["pr_designation"])) ? $res["pr_designation"]: "";
                                        $pr_phone = (isset($res["pr_phone"])) ? $res["pr_phone"]: "";
                                        $pr_address = (isset($res["pr_address"])) ? $res["pr_address"]: "";
                                        $pr_web_url = (isset($res["pr_web_url"])) ? $res["pr_web_url"]: "";
                                        $pr_fb_url = (isset($res["pr_fb_url"])) ? $res["pr_fb_url"]: "";
                                        $pr_twitter_url = (isset($res["pr_twitter_url"])) ? $res["pr_twitter_url"]: "";
                                        $pr_instagram_url = (isset($res["pr_instagram_url"])) ? $res["pr_instagram_url"]: "";
                                        $pr_linkedin_url = (isset($res["pr_linkedin_url"])) ? $res["pr_linkedin_url"]: "";
                                        @endphp
                                            <div class="form-rows">
                                                <div class="new-review row">
                                                    <div class="form-group col-lg-4" style="text-align: center;">
                                                        <label><b>Profile Image</b> <b>Size : </b><small>350 x 400</small></label> <br>
                                                        <div class="uc-image" style="width:150px;height:150px;">
                                                            <span class="clear-image-x">x</span>
                                                            <input type="hidden" name="person_image" value="{{ isset($data)? $person_image:"" }}">
                                                            <div id="person_image" class="image_display">
                                                                 @php
                                                                  $person_image = (isset($person_image) !=""  and $person_image !="") ? "<img src=".$person_image." alt=''>" : "";
                                                                  @endphp
                                                                    {!! $person_image !!}
                                                            </div>
                                                            <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#person_image" data-link="person_image">Add Image</a></div>
                                                        </div>
                                                        <br> <br>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6">
                                                                <label> Name</label>
                                                                <input type="text" name="pr_name" placeholder="Name" class="form-control" value="{{ $pr_name }}"/>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>Designation</label>
                                                                <input type="text" name="pr_designation" placeholder="Designation" class="form-control" value="{{ $pr_designation }}"/>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6">
                                                                <label>Email:</label>
                                                                <input type="text" name="pr_email" placeholder="{{ 'example@gmail.com' }}" class="form-control" value="{{ $pr_email }}"/>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>Phone Number</label>
                                                                <input type="text" name="pr_phone" placeholder="0303-786123" class="form-control" value="{{ $pr_phone }}"/>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6">
                                                                <label>Website URL</label>
                                                                <input type="text" name="pr_web_url" placeholder="e.g https://engrabbas.com/" class="form-control" value="{{ $pr_web_url }}"/>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>Address</label>
                                                                <textarea class="form-control" rows="2" name="pr_address" >{{ $pr_address }}</textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6">
                                                                <label>Facebook URL:</label>
                                                                <input type="text" name="pr_fb_url" placeholder="https://www.facebook.com/Engr.GA" class="form-control" value="{{ $pr_fb_url }}"/>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>Twitter URL</label>
                                                                <input type="text" name="pr_twitter_url" placeholder="https://www.twitter.com/Engr.GA" class="form-control" value="{{ $pr_twitter_url }}"/>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6">
                                                                <label>Linkedin URL</label>
                                                                <input type="text" name="pr_linkedin_url" placeholder="https://www.linkedin.com/Engr.GA" class="form-control" value="{{ $pr_linkedin_url }}"/>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>Instagram URL</label>
                                                                <input type="text" name="pr_instagram_url" placeholder="https://www.instagram.com/Engr.GA" class="form-control" value="{{ $pr_instagram_url }}"/>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                {{-- expr --}}
                            @endif
                            <div class="form-group col-lg-12 col-md-12">
                                <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Publish </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($__userType == 'admin')
  @include('admin.layout.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif

  <div class="md-modal md-effect-2" id="modal-2">
      <div class="md-content">
          <h4 class="font-weight-600 mb-0">How to Get Google Map ifram Code</h4>
          <div class="n-modal-body">
              <video width="100%" height="auto" controls style="display: none">
                <source src="{{ asset('admin-assets/dist/img/google-map.webm') }}" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              <button class="btn btn-success md-close mt-3">Close me!</button>
          </div>
      </div>
  </div>
  <div class="md-overlay"></div>

  <link href="{{ asset('admin-assets/plugins/modals/component.css') }}" rel="stylesheet">
  <script src="{{ asset('admin-assets/plugins/modals/classie.js') }}"></script>
  <script src="{{ asset('admin-assets/plugins/modals/modalEffects.js') }}"></script>
<script>
var cloneSchema =
'<div class="new-schema border row">' +
    '<span class="clear-data2">x</span>' +
    '<div class="col-lg-12">' +
        '<div class="form-row">' +
            '<div class="form-group col-lg-12">' +
                '<div class="flex-center"><b>  <span class="no"> </span> &nbsp; - &nbsp;</b> <input type="text" name="type[]" placeholder="schema name here" value=""  > </div> <br>' +
                '<textarea rows="6" name="schema[]" class="form-control" placeholder="type Your Schema heere..."  ></textarea>' +
            '</div>' +
        '</div>' +
    '</div>' +
'</div>';
$(".add-more-schema").click(function() {
var html_obj = cloneSchema;
$(".schema .schema-rows").append(html_obj);
var n = $(".schema .schema-rows").find(".new-schema").length;
var el =  $(".schema .schema-rows .new-schema:nth-child("+n+")");
el.find(".no").text(n);
return false;
});
$(document).on("click", ".clear-data2", function() {
var v = window.confirm("Do you want to delete data?");
if (v) {
$(this).closest(".row").remove();
}
});
$('.md-trigger').click(function(){
    $('video').css('display','block');
})
</script>