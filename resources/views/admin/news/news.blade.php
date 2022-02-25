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
        <div class="col-md-112 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if (request()->has('edit'))
                            <h6 class="fs-17 font-weight-600 mb-0">Edit News</h6>
                            @else
                            <h6 class="fs-17 font-weight-600 mb-0">Create News</h6>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="actions">
                             <a href="{{url('/'.admin.'/news')}}" class="btn {{ Request::segment(2)=='news'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                            <a href="{{url('/'.admin.'/news/list')}}" class="btn {{ Request::segment(2)=='news'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">News List</a>
                            @if ($__userType == 'admin')
                              <a href="{{ route('news-meta') }}" class="btn {{ Request::segment(2)=='news-meta'  ? 'btn-inverse' : 'btn-info' }} pull-right">News Meta</a>
                            @else
                              <a href="{{ route('district-news-meta') }}" class="btn {{ Request::segment(2)=='cabinet' &&  Request::segment(3)=='news-meta'  ? 'btn-inverse' : 'btn-info' }} pull-right">News Meta</a>
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
                        <strong>Whoops!</strong> Some Input Fields Are Missing.<br><br>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('news-create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                               
                                 @if (Request::get('edit') !="")
                                    <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                @endif
                                <div class="form-group">
                                    <label class="req">Page Title</label>
                                    @php
                                    if (old('title')) {
                                      $title = old('title');
                                    }elseif(isset($data) and !empty($data)){
                                      $title = $data->title;
                                    }else{
                                      $title = "";
                                    }
                                  @endphp
                                  @php
                                    $url = (Request::get('edit')) !="" ? "":"slug";
                                    @endphp
                                    <input type="text" name="title" class="form-control cslug" value="{{ $title }}" data-link="{{$url}}">
                                    @if(count($errors) > 0)
                                      @foreach($errors->get('title') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                      @endforeach 
                                    @endif
                                </div>
                                <div class="form-group">
                                    @php
                                    if (old('slug')) {
                                      $slug = old('slug');
                                    }elseif(isset($data) and !empty($data)){
                                      $slug = $data->slug;
                                    }else{
                                      $slug = "";
                                    }
                                  @endphp
                                    <label class="req">Slug</label>
                                    <input type="text" name="slug" value="{{ $slug }}" class="form-control">
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
                                        <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ $meta_title  }}" data-count="text">
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
                                        <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ $meta_description }}</textarea>
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
                                <div class="form-group p-0">
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
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Green Text </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="green">
                                                <div class="form-rows green-rows">
                                                    @php
                                                    if (old('green_body')) {
                                                       $blackText = old("green_body");
                                                        $res = array();
                                                        foreach($blackText as $k=>$v){
                                                            $res[] = array("green_body"=>$v);
                                                        }
                                                    }elseif(isset($data) and !empty($data)){
                                                        $res = isset($data)? json_decode($data->green_text , true) : array();
                                                    }else{
                                                      $res = array();
                                                    }
                                                    $g_text = (!empty($res) and count($res) > 0) ? count($res) - 1 : 0 ;
                                                    // $g_text = (empty($res) && count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$g_text; $n++){                                                         $gr_body=(isset($res[$n]["gr_body"])) ? $res[$n]["gr_body"]: "" ; @endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <div class="col-lg-12">
                                                            <p class="mx-auto text-center"><b> Green Text {{ $n+1 }}</b></p>
                                                            <div class="form-group">
                                                                <textarea rows="3" name="gr_body[]" class="form-control oneditor" placeholder="Answer"> {{ $gr_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-green"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Red Text </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="red">
                                                <div class="form-rows red-rows">
                                                    @php
                                                    if (old('red_body')) {
                                                       $blackText = old("red_body");
                                                        $res = array();
                                                        foreach($blackText as $k=>$v){
                                                            $res[] = array("red_body"=>$v);
                                                        }
                                                    }elseif(isset($data) and !empty($data)){
                                                        $res = isset($data)? json_decode($data->red_text , true) : array();
                                                    }else{
                                                      $res = array();
                                                    }
                                                    $r_text = (!empty($res) and count($res) > 0) ? count($res) - 1 : 0 ;
                                                    // $r_text = (empty($res) && count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$r_text; $n++){  $red_body=(isset($res[$n]["red_body"])) ? $res[$n]["red_body"]: "" ; @endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Red Text {{ $n+1 }}</b></p>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <textarea rows="3" name="red_body[]" class="form-control oneditor" placeholder="Answer"> {{ $red_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-red "><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Black Text </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="black">
                                                <div class="form-rows black-rows">
                                                    @php
                                                    if (old('black_body')) {
                                                       $blackText = old("black_body");
                                                        $res = array();
                                                        foreach($blackText as $k=>$v){
                                                            $res[] = array("black_body"=>$v);
                                                        }
                                                    }elseif(isset($data) and !empty($data)){
                                                        $res = isset($data)? json_decode($data->black_text , true) : array();
                                                    }else{
                                                      $res = array();
                                                    }
                                                    $b_text = (!empty($res) and count($res) > 0) ? count($res) - 1 : 0 ;
                                                    // $b_text = (empty($res) && count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$b_text; $n++){ $black_body=(isset($res[$n]["black_body"])) ? $res[$n]["black_body"]: "" ; @endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Black Text {{ $n+1 }}</b></p>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <textarea rows="3" name="black_body[]" class="form-control oneditor" placeholder="Answer"> {{ $black_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-black"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="req">Content:</label>
                                    <div>
                                        @php
                                        if (old('content')) {
                                          $content = old('content');
                                        }elseif(isset($data) and !empty($data)){
                                          $content = $data->content;
                                        }else{
                                          $content = "";
                                        }
                                      @endphp
                                      @if(count($errors) > 0)
                                      @foreach($errors->get('content') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                      @endforeach 
                                    @endif
                                        <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="editor" data-return="#oneditor" data-link="image" >Add Image</a> <a type="button" class="btn btn-info btn-sm float-right text-white " data-toggle="modal" data-target="#shortcode-model"><i class="fa fa-info"></i> &nbsp; Short Codes Discription</a> </div>
                                    </div>
                                    <textarea class="form-control oneditor" rows="25" name="content" id="oneditor">{{ $content }}</textarea>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> News FAQs </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="faqs">
                                                <div class="form-rows faqs-rows">
                                                    @php
                                                    $res = isset($data)? json_decode($data->faqs , true) : array();
                                                    $f_count = (!empty($res) and count($res) > 0) ? count($res) - 1 : 0 ;
                                                    // $f_count = (empty($res) && count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$f_count; $n++){ $question=(isset($res[$n]["question"])) ? $res[$n]["question"]: "" ; $answer=(isset($res[$n]["answer"])) ? $res[$n]["answer"]: "" ; @endphp <div class="new-faqs border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> FAQs {{ $n+1 }}</b></p>
                                                        <input type="hidden" name="num[]" value="{{ $n+1 }}">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Question</label>
                                                                <input type="text" name="question[]" placeholder="Question" class="form-control" value="{{ isset($data)? $question:"" }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Answer</label>
                                                                <textarea rows="3" name="answer[]" class="form-control oneditor" placeholder="Answer">{{ isset($data)? $answer:"" }}</textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                    }
                                                    @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-faqs"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                               <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <label class="font-weight-600 req"> News Type: </label>
                                        </div>
                                        <div class="card-body">
                                            <div class="skin-line">
                                                @php
                                                if (old('category')) {
                                                  $category = old('category');
                                                }elseif(isset($data) and !empty($data)){
                                                  $category =  $data->category;
                                                }else{
                                                  $category = array();
                                                }
                                                $shift = [
                                                    'green' => "Force to do News",
                                                    'orange' => "Not to do News",
                                                    'blue' => "Good Information",
                                                    'red' => "Bad Information"
                                                ];
                                                @endphp
                                                @foreach ($shift as $ct => $value)
                                                <div class="i-check">
                                                    <input tabindex="17" type="radio" value="{{ $ct}}" name="category" id="line-radio-1" {{ ($ct == $category)?'checked':''}}>
                                                    <label for="line-radio-1">{{ $value }}</label>
                                                </div>
                                                @endforeach
                                            </div>  
                                            @if(count($errors) > 0)
                                              @foreach($errors->get('category') as $error)
                                                <div class="text-danger">{{ $error }}</div>
                                              @endforeach 
                                            @endif                                          
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <span><b> Cover Image <small> 300 x 200</small> </b> <a  class="text-white float-right" href="" ></a></span>
                                        </div>
                                        <div class="card-body">
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
                                </div> --}}
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <span style="font-weight: 600;"> OG Image &nbsp; &nbsp; &nbsp;  Min Size: 1200 x 627 </span>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                if (old('og-image')) {
                                                  $og_image = old('og-image');
                                                }elseif(isset($data) and !empty($data)){
                                                  $og_image =  $data->og_image;
                                                }else{
                                                  $og_image = "";
                                                }
                                            @endphp
                                            @php
                                            $og = ($og_image !="") ? "<img src=".$og_image." alt=''>" : "";
                                            @endphp
                                            <div class="uc-image" style="width: 97%;">
                                                <input type="hidden" name="og-image" value="{{ $og_image }}">
                                                <div id="og-image" class="image_display">
                                                    {!! $og !!}
                                                </div>
                                                <div style="margin-top:10px;">
                                                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#og-image" data-link="og-image">Add Image</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                      $national = $data->national;
                                   }else{ 
                                     $district = $userdata['district'];
                                     $city = $userdata['city'];
                                     $type = $userdata['type'];
                                     $province = $userdata['province'];
                                     $national = $userdata['natonal'];
                                  } 
                                 @endphp
                            <input type="hidden" name="user_type" value="{{ $type }}">
                            <input type="hidden" name="national" value="{{ $national }}">
                            <input type="hidden" name="province" value="{{ $province }}">
                            <input type="hidden" name="district" value="{{ $district }}">
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                          Publish Date:
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-lg-12">
                                                <label for="example-date-input" class=" col-form-label font-weight-600 req" > Date</label>
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
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control" value="{{ $date }}" name="date" data-toggle="datepicker" id="date-picker" autocomplete="off"></p>
                                                </div>
                                                  @if(count($errors) > 0)
                                              @foreach($errors->get('date') as $error)
                                                <div class="text-danger">{{ $error }}</div>
                                              @endforeach 
                                            @endif  
                                            </div>
                                            <button type="submit" name="submit" value="draft" class="btn btn-info float-left">Draft </button>
                                            <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Publish </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="shortcode-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Description For Short Codes</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th> Short Code</th>
                        <th> Description</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td> Related Post: </td>
                        <td> [[related:2]] </td>
                        <td> [[related : Limits of url / Quantity]] <br> <b>For Example : [[related : 2]] </b> 2 Links will Generate where we use this code </td>
                    </tr>
                    <tr>
                        <td> 3 </td>
                        <td> Table of Content:</td>
                        <td> [[toc]] </td>
                        <td> use this code <b>[[toc]]</b> where u want to show table of content in article</b></td>
                    </tr>
                    <tr>
                        <td> 4 </td>
                        <td> Heading:</td>
                        <td> [[t]] Heading [[/t]] </td>
                        <td> <b>Example</b> Heading no 1 : [[t1]]Heading no 1[[/t1]] <br> Heading no 2 : [[t2]]Heading no 2[[/t2]] </td>
                    </tr>
                    <tr>
                        <td> 5 </td>
                        <td> Sub Heading:</td>
                        <td> [[t1-s1]] Sub Heading of Headin 1 [[/t1-s1]] </td>
                        <td> <b>Example</b> <b>1st Sub Heading of Heading 1 </b>: [[t1-s1]]1st Sub Heading of Heading 1[[/t1-s2]] <br> <b>2nd Sub Heading of Heading 1 </b>: [[t1-s2]]2nd Sub Heading of Heading 1[[/t1-s2]] </td>
                    </tr>
                    <tr>
                        <td> 6 </td>
                        <td> Child of Sub Heading:</td>
                        <td> [[t1-s1-c1]] chlid of1st Sub Heading of Headin 1 [[/t1-s1-c1]] </td>
                        <td> <b>Example</b> <b>Child of 1st Sub Heading of Heading 1 </b>: [[t1-s1-c1]] Child of 1st Sub Heading of Heading 1[[/t1-s1-c1]] </td>
                    </tr>
                    <tr>
                        <td> 8 </td>
                        <td> Green Text:</td>
                        <td> [[green:2]] </td>
                        <td> [[green : index of Green Text that is listed above]] <br> <b>For Example : [[green : 2]] </b> 2nd Green text will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 9 </td>
                        <td> Red Text:</td>
                        <td> [[red:2]] </td>
                        <td> [[red : index of Red Text that is listed above]] <br> <b>For Example : [[Red : 2]] </b> 2nd Red text will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 10 </td>
                        <td> Black Text:</td>
                        <td> [[black:2]] </td>
                        <td> [[black : index of Black Text that is listed above]] <br> <b>For Example : [[Black : 2]] </b> 2nd Green text will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 11 </td>
                        <td> Faqs </td>
                        <td> [[faqs:index of FAQs that is listed above]] </td>
                        <td> <b>Example</b> <b>[[faqs:1-4]]</b> place this code if u want to show faqs no 1 2 3 and 4
                        <br> <b>[[faqs:1,3,5,7]]</b> place this code if u want to show randomly faqs for example 1 3 5 7 </td>
                    </tr>
                </table>
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
    <script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
<script>
$(document).ready(function() {
      $('#date-picker').samask("00/00/0000");
      $('#date-picker').change(function(e){
        var new_val = $(this).val();
        var new_val = new_val.replace(/(\d{2})(\d{2})(\d{4})/, "$1/$2/$3");
        $(this).val(new_val);
      });
      $('#date-picker').keydown(function(e){
        if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
          return true; 
        }  else {
          return false;
        } 
      });
var cloneg = '<div class="new-review border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Green Text <span class="no"></span> </b></p>' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<textarea rows="3" name="gr_body[]" class="form-control oneditor" placeholder="Body text..." ></textarea>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
    '</div>' +
'</div>'
$(".add-green").click(function(e) {
e.preventDefault();
var html_obj = cloneg;
var ln = $(".form-rows .row").length;
$(html_obj).find("input").each(function() {
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function() {
$(this).text("");
});
$(html_obj).find("img").remove();
$(".green .form-rows").append(html_obj);
var n = $(".green .form-rows").find(".new-review").length;
var el = $(".green .form-rows .new-review:nth-child(" + n + ")");
el.find(".no").text(n);
_full_Ed();
return false;
});
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
var cloner = '<div class="new-review border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Red Text <span class="no"></span> </b></p>' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<textarea rows="3" name="red_body[]" class="form-control oneditor" placeholder="Body text..." ></textarea>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
    '</div>' +
'</div>'
$(".add-red").click(function(e) {
e.preventDefault();
var html_obj = cloner;
var ln = $(".form-rows .row").length;
$(html_obj).find("input").each(function() {
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function() {
$(this).text("");
});
$(html_obj).find("img").remove();
$(".red .form-rows").append(html_obj);
var n = $(".red .form-rows").find(".new-review").length;
var el = $(".red .form-rows .new-review:nth-child(" + n + ")");
el.find(".no").text(n);
_full_Ed();
return false;
});
var cloneb = '<div class="new-review border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Black Text <span class="no"></span> </b></p>' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<textarea rows="3" name="black_body[]" class="form-control oneditor" placeholder="body tex...t" ></textarea>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
    '</div>' +
'</div>'
$(".add-black").click(function(e) {
e.preventDefault();
var html_obj = cloneb;
var ln = $(".form-rows .row").length;
$(html_obj).find("input").each(function() {
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function() {
$(this).text("");
});
$(html_obj).find("img").remove();
$(".black .form-rows").append(html_obj);
var n = $(".black .form-rows").find(".new-review").length;
var el = $(".black .form-rows .new-review:nth-child(" + n + ")");
el.find(".no").text(n);
_full_Ed();
return false;
});
var clonefaqs = '<div class="new-faqs border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> FAQs <span class="no"></span> </b></p>' +
    '<input type="hidden" name="num[]" value="">' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Question</label>' +
            '<input type="text" name="question[]" placeholder="Question" class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        ' <div class="form-group">' +
            '<label>Answer</label>' +
            '<textarea rows="3" name="answer[]" class="form-control oneditor" placeholder="Answer" ></textarea>' +
            '<div class="text-danger"> </div>' +
        ' </div>' +
    '</div>' +
'</div>';
$(".add-faqs").click(function(e) {
e.preventDefault();
var html_obj = clonefaqs;
$(".faqs .faqs-rows").append(html_obj);
var n = $(".faqs .faqs-rows").find(".new-faqs").length;
var el = $(".faqs .faqs-rows .new-faqs:nth-child(" + n + ")");
el.find(".no").text(n);
el.find('input[name="num[]"]').val(n);
_full_Ed();
return false;
});
$(document).on("click", ".clear-data2", function() {
var v = window.confirm("Do you want to delete data?");
if (v) {
$(this).closest(".row").remove();
}
});
});
</script>