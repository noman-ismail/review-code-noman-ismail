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
full_editor();
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-md-10 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Event</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/event/new')}}" class="btn {{ Request::segment(2)=='event'  &&  Request::segment(3)=='new'  ? 'btn-inverse' : 'btn-info' }} pull-right">Create New</a>
                <a href="{{url('/'.admin.'/event')}}" class="btn {{ Request::segment(2)=='event'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Event List</a>
                @if ($__userType != 'admin')
                <a href="{{ route('district-events-meta') }}" class="btn {{ Request::segment(2)=='cabinet' &&  Request::segment(3)=='events-meta'  ? 'btn-inverse' : 'btn-info' }} pull-right">Events Meta</a>
                @else
                <a href="{{ route('event-meta') }}" class="btn {{ Request::segment(3)=='event-meta'  ? 'btn-inverse' : 'btn-info' }} pull-right">Events Meta</a>
                @endif
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
          @if (Session::has('success'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('success') !!}</strong>
          </div>
          @endif
          @if (count($errors) > 0)
          <div class="alert alert-danger">
            <strong>Whoops!</strong> Some Input Fields Are Missing.
          </div>
          @endif
          <form method="POST" action="/{{ admin }}/event/new" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                @if (Request::get('edit') !="")
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                @endif
                <div class="row">
                  <div class="col-lg-8">
                    @php
                    $res = isset($data->text_sec1 )? json_decode($data->text_sec1 , true) : array();
                    $ts_img1 = (isset($res["ts_img1"])) ? $res["ts_img1"]: "";
                    $ts_title1 = (isset($res["ts_title1"])) ? $res["ts_title1"]: "";
                    $ts_details1 = (isset($res["ts_details1"])) ? $res["ts_details1"]: "";
                    @endphp
                    <div class="form-group ">
                      @php
                      if (old('title')) {
                      $title = old('title');
                      }elseif(isset($data) and !empty($data)){
                      $title = $data->title;
                      }else{
                      $title = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Page Title</label>
                      <div class="input-group">
                        @php
                        $url = (Request::get('edit')) !="" ? "":"slug";
                        @endphp
                        <input type="text" name="title" class="form-control cslug" placeholder="title" value="{{ $title }}" data-link="{{ $url }}">
                      </div>
                      @if(count($errors) > 0)
                      @foreach($errors->get('title') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                    <div class="form-group ">
                      @php
                      if (old('slug')) {
                      $slug = old('slug');
                      }elseif(isset($data) and !empty($data)){
                      $slug = $data->slug;
                      }else{
                      $slug = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Slug</label>
                      <div class="input-group">
                        <input type="text" name="slug" value="{{ $slug }}" placeholder="slug" class="form-control">
                      </div>
                      @if(count($errors) > 0)
                      @foreach($errors->get('slug') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                    <div class="form-group p-0">
                      @php
                      if (old('meta_title')) {
                      $meta_title = old('meta_title');
                      }elseif(isset($data) and !empty($data)){
                      $meta_title = $data->meta_title;
                      }else{
                      $meta_title = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Meta Title</label>
                      <div class="input-group">
                        <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ $meta_title }}" data-count="text">
                        <div class="input-group-append">
                          <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_title):'0'}}</span>
                        </div>
                      </div>
                      @if(count($errors) > 0)
                      @foreach($errors->get('meta_title') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                    <div class="form-group p-0">
                      @php
                      if (old('meta_description')) {
                      $meta_description = old('meta_description');
                      }elseif(isset($data) and !empty($data)){
                      $meta_description = $data->meta_description;
                      }else{
                      $meta_description = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Meta Description</label>
                      <div class="input-group">
                        <textarea class="form-control tcount" id="exampleFormControlTextarea1" placeholder="meta description" rows="3" name="meta_description" data-count="text">{{ $meta_description }}</textarea>
                        <div class="input-group-append">
                          <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_description):'0'}}</span>
                        </div>
                      </div>
                      @if(count($errors) > 0)
                      @foreach($errors->get('meta_description') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                    <div class="form-group col-md-12 p-0">
                      @php
                      if (old('meta_tags')) {
                      $meta_tags = old('meta_tags');
                      }elseif(isset($data) and !empty($data)){
                      $meta_tags = $data->meta_tags;
                      }else{
                      $meta_tags = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Meta Tags</label>
                      <div class="input-group">
                        <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ $meta_tags }}">
                        <div class="input-group-append">
                          <span class="input-group-text count countshow">{{ isset($data)?count(explode(",",$data->meta_tags)):'0'}}</span>
                        </div>
                      </div>
                      @if(count($errors) > 0)
                      @foreach($errors->get('meta_tags') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                    <div class="form-group p-0">
                      <div class="card">
                        <div class="card-header card bg-secondary text-white">
                          <b> Schema </b>
                        </div>
                        <div class="card-body">
                          <div class="schema">
                            <div class="schema-rows">
                              @php
                              if(!empty(old("schema"))){
                              $schema_g = old("schema");
                              $type_g = old("type");
                              $t_quotes = count($schema_g);
                              $schema = array();
                              foreach($schema_g as $k=>$v){
                              $type = $type_g[$k];
                              $schema[] = array("schema"=>$v, "type"=>$type);
                              }
                              }else{
                              $schema = isset($data)? json_decode($data->microdata , true) : array();
                              }
                              $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                              for ($n=0; $n <=$t_quotes; $n++){ $schema_d=(isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "" ;
                              $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                              $style=(Request::get('edit') and isset($schema[$n]["type"])  ) ? 'style="display: none;"': "" ;
                              $icon=(Request::get('edit') and isset($schema[$n]["type"] )) ? '<i class="fa fa-edit"></i>': '' ;
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
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-header card bg-secondary text-white">
                        <b> Cover Image</b> <span><b>Size: <small>350 x 230 </small> </b></span>
                      </div>
                      @php
                        // dd(old('cover_image'));
                        if (old('cover_image') != "") {
                          $__imgName = old('cover_image');
                          $cover_image = "<img src=".old('cover_image')." alt=''>";
                        }elseif(!empty($data) and !empty($data->cover_image)){
                          $__imgName = $data->cover_image;
                          $cover_image = "<img src=".$data->cover_image." alt=''>";

                        }else{
                          $__imgName = '';
                          $cover_image = "";

                        }
                      @endphp
                      <div class="card-body">
                        <div class="form-group col-lg-12 flex-center">
                          <label class="font-weight-600"></label> <br>
                          <div class="uc-image" style="width:150px;height:150px;">
                            <span class="clear-image-x">x</span>
                            <input type="hidden" name="cover_image" value="{{ $__imgName }}">
                            <div id="cover_image" class="image_display">
                              @php
                              $cover_image = (isset($data) !=""  and $data->cover_image !="") ? "<img src=".$data->cover_image." alt=''>" : "";
                              @endphp
                              {!! $cover_image !!}
                            </div>
                            <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#cover_image" data-link="cover_image">Add Image</a>
                              @if ($__userType == "admin")
                                <a type="button" class="btn btn-crop btn-sm float-right " id="cropieimg">crop</a>
                              @endif                             
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="card">
                      <div class="card-header card bg-secondary text-white">
                        <b> Text Section 1 Image &nbsp; &nbsp; Min Size <small>475 x 317</small></b>
                      </div>
                      <div class="card-body">
                        <div class="form-group col-lg-12 flex-center">
                          <label><b></b></small></label> <br>
                          <div class="uc-image" style="width:150px;height:150px;">
                            <span class="clear-image-x">x</span>
                            <input type="hidden" name="ts_img1" value="{{ isset($data)? $ts_img1  :"" }}">
                            <div id="ts_img1" class="image_display">
                              @php
                              $ts_img1 = (isset($data) !=""  and $ts_img1 !="") ? "<img src=".$ts_img1." alt=''>" : "";
                              @endphp
                              {!! $ts_img1 !!}
                            </div>
                            <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#ts_img1" data-link="ts_img1">Add Image</a></div>
                          </div>
                          <br> <br>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="row">
                    @php
                    $social   = (isset($data) and $data->social_links  !="" )? json_decode($data->social_links , true) : array();
                    $fb_link = (isset($social["fb_link"])) ? $social["fb_link"]: "";
                    $twitter_link = (isset($social["twitter_link"])) ? $social["twitter_link"]: "";
                    $instagram_link = (isset($social["instagram_link"])) ? $social["instagram_link"]: "";
                    $linkedin_link = (isset($social["linkedin_link"])) ? $social["linkedin_link"]: "";
                    @endphp
                    <div class="form-group col-lg-6">
                      <label>Facebook Link</label>
                      <input type="text" name="fb_link" class="form-control" value="{{ $fb_link }}"/>
                    </div>
                    <div class="form-group col-lg-6">
                      <label>Twitter Link</label>
                      <input type="text" name="twitter_link" class="form-control" value="{{ $twitter_link }}"/>
                    </div>
                    <div class="form-group col-lg-6">
                      <label>Linkedin Link</label>
                      <input type="text" name="linkedin_link" class="form-control" value="{{ $linkedin_link }}"/>
                    </div>
                    <div class="form-group col-lg-6">
                      <label>Instagram Link</label>
                      <input type="text" name="instagram_link" class="form-control" value="{{ $instagram_link }}"/>
                    </div>
                    <div class="form-group col-lg-6 ">
                      @php
                      if (old('date')) {
                      $date = old('date');
                      }elseif(isset($data) and $data->date != Null){
                      $date = explode("-",$data->date);
                      $date = $date[2]."/".$date[1]."/".$date[0];
                      }else{
                      $date = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Date:</label>
                      <input type="text" class="form-control" data-toggle="datepicker" autocomplete="off" name="date" placeholder="DD/MM/YYYY" value="{{ $date }}" id="date-picker">
                      @if(count($errors) > 0)
                      @foreach($errors->get('date') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                    <div class="form-group col-lg-6 ">
                      @php
                      if (old('time')) {
                      $time = old('time');
                      }elseif(isset($data) and !empty($data)){
                      $time = $data->time;
                      }else{
                      $time = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Schedule:</label>
                      <span class="float-right" style="font-size: 12px;">Example: 10:00 AM - 04:00 PM</span>
                      <input type="text" class="form-control " value="{{ $time }}" name="time" placeholder="10:00 AM - 04:00 PM ">
                      @if(count($errors) > 0)
                      @foreach($errors->get('time') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                    <div class="form-group col-lg-6 ">
                      @php
                      if (old('address')) {
                      $address = old('address');
                      }elseif(isset($data) and !empty($data)){
                      $address = $data->address;
                      }else{
                      $address = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Address:</label>
                      <input type="text" class="form-control " value="{{ $address }}" name="address" placeholder="Address ">
                      @if(count($errors) > 0)
                      @foreach($errors->get('address') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                    <div class="form-group col-lg-6 ">
                      @php
                      if (old('chief_guest')) {
                      $chief_guest = old('chief_guest');
                      }elseif(isset($data) and !empty($data)){
                      $chief_guest = $data->chief_guest;
                      }else{
                      $chief_guest = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Chief Guest:</label>
                      <input type="text" class="form-control " value="{{ $chief_guest }}" name="chief_guest" placeholder="Chief Guest ">
                      @if(count($errors) > 0)
                      @foreach($errors->get('chief_guest') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                    <div class="form-group col-lg-6 ">
                      @php
                      if (old('video_url')) {
                        $video_url = old('video_url');
                      }elseif(isset($data) and !empty($data)){
                        $video_url = $data->video_url;
                      }else{
                        $video_url = "";
                      }
                      @endphp
                      <label class="font-weight-600 req">Video Url:</label>
                        <input type="text" class="form-control " value="{{ $video_url }}" name="video_url" placeholder="Video link of Youtube / Facebook">
                        @if(count($errors) > 0)
                        @foreach($errors->get('video_url') as $error)
                          <div class="text-danger">{{ $error }}</div>
                        @endforeach
                      @endif
                    </div>
                      @php
                      $userdata =  _user_data();
                      if (isset($data)){
                        if(!empty($data->district)){
                          $city_detail = DB::table("cities")->where('id' , $data->district)->select("name")->first();
                          $city = ($city_detail)?$city_detail->name:"admin";
                        }elseif(!empty($data->province)){
                          $province_detail = DB::table("province")->where('id' , $data->province)->select("name")->first();
                          $city = ($province_detail)?$province_detail->name:"admin";
                        }elseif($data->user_type == 'national'){
                         $city = 'national';
                        }else{
                          $city = 'Pakistan';
                        }
                          $district = $data->district;
                          $province = $data->province;
                          $type = $data->user_type;
                        }else{
                          $district = $userdata['district'];
                          $city = $userdata['city'];
                          $type = $userdata['type'];
                          $province = $userdata['province'];
                        }
                      @endphp
                      
                      <input type="hidden" name="user_type" value="{{ $type }}">
                      <input type="hidden" name="district" value="{{ $district }}">
                      <input type="hidden" name="province" value="{{ $userdata['province'] }}">
                      <input type="hidden" class="form-control" name="" value="{{ $city }}"  readonly="true">

                    <div class="form-group col-lg-6">
                      @php
                      if (old('google_map')) {
                      $google_map = old('google_map');
                      }elseif(isset($data) and !empty($data)){
                      $google_map = $data->google_map;
                      }else{
                      $google_map = "";
                      }
                      @endphp
                      <div class="row">
                        <div class="col-md-6"><label class="font-weight-600 req">Google Map: </label></div>
                        <div class="col-md-6 text-right mb-1">
                          {{-- <button class="btn btn-sm btn-info" type="button"></button> --}}
                          <button class="btn btn-success btn-info md-trigger mb-2 mr-1" data-modal="modal-2" type="button">Watch Toturial</button>
                        </div>
                      </div>
                      
                      <textarea class="form-control" rows="5" name="google_map">{{ $google_map }}</textarea>
                      @if(count($errors) > 0)
                      @foreach($errors->get('google_map') as $error)
                      <div class="text-danger">{{ $error }}</div>
                      @endforeach
                      @endif
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Introduction Section </b>
                    </div>
                    <div class="card-body">
                      <div class="reviews2">
                        <div class="form-rows">
                          <div class="flex-center row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                @php
                                if (old('ts_details1')) {
                                $ts_details1 = old('ts_details1');
                                }elseif(isset($data) and isset($res["ts_details1"])){
                                $ts_details1 = $res["ts_details1"];
                                }else{
                                $ts_details1 = "";
                                }
                                @endphp
                                <label class="req">Details</label>
                                <textarea rows="15" name="ts_details1" class="form-control oneditor" placeholder="Enter Details">{{ $ts_details1 }}</textarea>
                                @if(count($errors) > 0)
                                @foreach($errors->get('ts_details1') as $error)
                                <div class="text-danger">{{ $error }}</div>
                                @endforeach
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-12 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Gallery Images  </b>
                    </div>
                    <div class="card-body">
                      @php
                      if(!empty(old('total_images'))){
                      $total = old('total_images');
                      $gallery_image = array();
                      for ($n=0; $n < $total; $n++){
                      // echo(old("image".($n+1)));
                      if (!empty(old("image".($n+1)))){
                      $gallery_image[] = old("image".($n+1));
                      }
                      }
                      }else{
                      $gallery_image = ( isset($data) and $data->gallery_image !="" )? json_decode($data->gallery_image , true) : array();
                      }
                      // die();
                      $total = count($gallery_image);
                      $stotal = ($total == 0)? 1: $total;
                      $t_total = ($total==0) ? 0 : $total-1;
                      @endphp
                      <input type="hidden" name="total_images" value="{{ $stotal }}"/>
                      @php
                      for($n=0; $n <= $t_total; $n++){
                      $image = (isset($gallery_image[$n])) ? $gallery_image[$n] : "";
                      @endphp
                      <div class="uc-image2" style="width:150px;height:150px;">
                        <?php
                        //if ($n > 0){
                        ?>
                        <span class="close-image-x2">x</span>
                        <?php //} ?>
                        <input type="hidden" name="image{{ $n+1 }}"
                        value="{{ $image }}"/>
                        <div class="image{{ $n+1 }} image_display">
                          @php if ($image!=""){ @endphp
                          <img src="{{ $image }}" alt='Product Image'/>
                          @php } @endphp
                        </div>
                        <div style="margin-top:10px;">
                          <a class="insert-media btn btn-danger btn-sm" data-type="image"
                            data-for="display"
                            data-return=".image{{ $n+1 }}"
                          data-link="image{{ $n+1 }}">Add Image</a>
                        </div>
                      </div>
                      @php  } @endphp
                      
                      <div class="ext-image">
                        
                      </div>
                      
                      <div class="add-more-images">
                        <a href="#" class="btn btn-success float-right">Add More</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-12 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Honorable Guest  </b>
                    </div>
                    <div class="card-body">
                      <p>
                        <b class="text-danger">Note: </b> Guest image is necessary
                      </p>
                      <div class="reviews">
                        <div class="form-rows">
                          @php
                          $guests   = (isset($data) and $data->guest  !="" )? json_decode($data->guest , true) : array();
                          @endphp
                          @php
                          $rev_count = (count($guests)==0) ? 0 : count($guests) - 1;
                          for ($n=0; $n <=$rev_count; $n++){
                          $name = (isset($guests[$n]["name"])) ? $guests[$n]["name"]: "";
                          $img = (isset($guests[$n]["img"])) ? $guests[$n]["img"]: "";
                          $designation = (isset($guests[$n]["designation"])) ? $guests[$n]["designation"]: "";
                          $fb_url = (isset($guests[$n]["fb_url"])) ? $guests[$n]["fb_url"]: "";
                          $twitter_url = (isset($guests[$n]["twitter_url"])) ? $guests[$n]["twitter_url"]: "";
                          $instagram_url = (isset($guests[$n]["instagram_url"])) ? $guests[$n]["instagram_url"]: "";
                          $linkedin_url = (isset($guests[$n]["linkedin_url"])) ? $guests[$n]["linkedin_url"]: "";
                          $details = (isset($guests[$n]["details"])) ? $guests[$n]["details"]: "";
                          @endphp
                          <div class="new-review border row">
                            <span class="clear-data">x</span>
                            <div class="form-group col-lg-3" style="text-align: center;">
                              <h6> <b>Guest {{ $n+1 }}</b></h6>
                              <label><b>Image</b> <b>Size : </b><small> <b>350 x 400</b></small></label> <br>
                              <div class="uc-image" style="width:150px;height:150px;">
                                <span class="clear-image-x">x</span>
                                <input type="hidden" name="img<?php echo $n; ?>" value="<?php echo $img ?>">
                                <div id="img<?php echo $n; ?>" class="image_display">
                                  @php
                                  $img = ($img !="") ? "<img src=".$img." alt=''>" : "";
                                  @endphp
                                  {!! $img !!}
                                </div>
                                <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img<?php echo $n; ?>" data-link="img<?php echo $n; ?>">Add Image</a></div>
                              </div>
                              <br> <br>
                            </div>
                            <div class="col-lg-9">
                              <div class="form-row">
                                <div class="form-group col-lg-6">
                                  <label>Name</label>
                                  <input type="text" name="name[]" class="form-control" value="{{ $name }}"/>
                                  <div class="text-danger"> </div>
                                </div>
                                <div class="form-group col-lg-6">
                                  <label>Designation</label>
                                  <input type="text" name="designation[]" class="form-control" value="{{ $designation }}"/>
                                  <div class="text-danger"> </div>
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-lg-12">
                                  <label>Facebook Link</label>
                                  <input type="text" name="fb_url[]" class="form-control" value="{{ $fb_url }}"/>
                                  <div class="text-danger"> </div>
                                </div>
                                <div class="form-group col-lg-12">
                                  <label>Twitter Link</label>
                                  <input type="text" name="twitter_url[]" class="form-control" value="{{ $twitter_url }}"/>
                                  <div class="text-danger"> </div>
                                </div>
                                <div class="form-group col-lg-12">
                                  <label>Linkedin Link</label>
                                  <input type="text" name="linkedin_url[]" class="form-control" value="{{ $linkedin_url }}"/>
                                  <div class="text-danger"> </div>
                                </div>
                                <div class="form-group col-lg-12">
                                  <label>Instagram Link</label>
                                  <input type="text" name="instagram_url[]" class="form-control" value="{{ $instagram_url }}"/>
                                  <div class="text-danger"> </div>
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
                        <a href="" class="btn btn-success add-review"><i class="fa fa-plus"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12">
                <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Submit</button>
              </div>
            </form>
          </div>
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
                {{-- <source src="movie.ogg" type="video/ogg"> --}}
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
          '<textarea rows="6" name="schema[]" class="form-control" placeholder="Schema tag here..."  ></textarea>' +
        '</div>' +
      '</div>' +
    '</div>' +
  '</div>';
  $(".add-more-schema").click(function() {
  var html_obj = cloneSchema;
  $(".schema .schema-rows").append(html_obj);
  var n = $(".schema .schema-rows").find(".new-schema").length;
  var el = $(".schema .schema-rows .new-schema:nth-child(" + n + ")");
  el.find(".no").text(n);
  return false;
  });
  $(document).ready(function() {
  var clone = '<div class="new-review border row">'+
    '<span class="clear-data">x</span>'+
    '<div class="form-group col-lg-3" style="text-align: center;">'+
      '<h6> <b>Guest <span class="num"> </span> </b></h6>'+
      '<label><b>Image</b> <b>Size : </b><small> <b>350 x 400</b></small></label> <br>'+
      '<div class="uc-image" style="width:150px;height:150px;">'+
        '<span class="clear-image-x">x</span>'+
        '<input type="hidden" name="img" value="">'+
        '<div id="img" class="image_display"></div>'+
        '<div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img" data-link="img">Add Image</a></div>'+
      '</div><br> <br></div>'+
      '<div class="col-lg-9">'+
        '<div class="form-row">'+
          '<div class="form-group col-lg-6">'+
            '<label>Name</label>'+
            '<input type="text" name="name[]" class="form-control" value=""/>'+
          '</div>'+
          '<div class="form-group col-lg-6">'+
            '<label>Designation</label>'+
            '<input type="text" name="designation[]" class="form-control" value=""/>'+
          '</div>'+
        '</div>'+
        '<div class="form-row">'+
          '<div class="form-group col-lg-6">'+
            '<label>Facebook Link</label>'+
            '<input type="text" name="fb_url[]" class="form-control" value=""/>'+
          '</div>'+
          '<div class="form-group col-lg-6">'+
            '<label>Twitter Link</label>'+
            '<input type="text" name="twitter_url[]" class="form-control" value=""/>'+
          '</div>'+
          '<div class="form-group col-lg-6">'+
            '<label>Linkedin Link</label>'+
            '<input type="text" name="linkedin_url[]" class="form-control" value=""/>'+
          '</div>'+
          '<div class="form-group col-lg-6">'+
            '<label>Instagram Link</label>'+
            '<input type="text" name="instagram_url[]" class="form-control" value=""/>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>';
    $(".add-review").click(function(e) {
    e.preventDefault();
    var html_obj = clone;
    var ln = $(".form-rows .new-review").length;
    $(".reviews .form-rows").append(html_obj);
    var n = $(".reviews .form-rows").find(".new-review").length;
    var el =  $(".reviews .form-rows .new-review:nth-child("+n+")");
    el.find(".uc-image").find("#img").attr("id", "img"+ln);
    el.find(".uc-image").find(".img").attr("class", "img"+ln);
    el.find(".uc-image").find(".image_display").attr("id", "img"+ln);
    el.find(".uc-image").find("input").attr("name", "img"+ln);
    el.find(".uc-image").find("a").attr("data-return", "#img"+ln);
    el.find(".uc-image").find("a").attr("data-link", "img"+ln);
    el.find(".num").text(n)
    return false;
    });
    $(document).on("click", ".clear-data , .clear-data2", function() {
    var v = window.confirm("Do you want to delete data?");
    if (v) {
    $(this).closest(".row").remove();
    }
    });

    });
    $('.md-trigger').click(function(){
      $('video').css('display','block');
    })
    </script>