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
                            <h6 class="fs-17 font-weight-600 mb-0">Edit job</h6>
                            @else
                            <h6 class="fs-17 font-weight-600 mb-0">Create New job</h6>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="actions">
                                <a href="{{url('/'.admin.'/jobs')}}" class="btn {{ Request::segment(2)=='jobs'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                                <a href="{{url('/'.admin.'/jobs/list')}}" class="btn {{ Request::segment(2)=='jobs'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">jobs List</a>
                                @if ($__userType == 'admin')
                                  <a href="{{ route('jobs-meta') }}" class="btn {{ Request::segment(2)=='jobs-meta'  ? 'btn-inverse' : 'btn-info' }} pull-right">jobs Meta</a>
                                @elseif($__userType == 'district' || $__userType == 'province')
                                  <a href="{{ route('district-jobs-meta') }}" class="btn {{ Request::segment(2)=='cabinet' &&  Request::segment(3)=='jobs-meta'  ? 'btn-inverse' : 'btn-info' }} pull-right">jobs Meta</a>
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
                    <form method="POST" action="{{ route('jobs-create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                @php
                                // dd($data);
                                @endphp
                                @if (Request::get('edit') !="")
                                    <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                @endif
                                
                                <div class="form-group">
                                    <label class="req">Job Title</label>
                                    @php
                                      $url = (Request::get('edit')) !="" ? "":"slug";
                                    @endphp
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
                                 @php
                                    if (old('organization')) {
                                      $organization = old('organization');
                                    }elseif(isset($data) and !empty($data)){
                                      $organization = $data->organization;
                                    }else{
                                      $organization = "";
                                    }
                                  @endphp
                                <div class="form-group">
                                    <label class="req">Organization Name</label>
                                    <input type="text" name="organization" class="form-control cslug" value="{{ $organization }}" placeholder="District and Session/Civil Judge khanewal" >
                                </div>
                                @if(count($errors) > 0)
                                  @foreach($errors->get('organization') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                  @endforeach 
                                @endif
                                @php
                                    if (old('official_link')) {
                                      $official_link = old('official_link');
                                    }elseif(isset($data) and !empty($data)){
                                      $official_link = $data->official_link;
                                    }else{
                                      $official_link = "";
                                    }
                                  @endphp
                                <div class="form-group">
                                    <label class="">Official URL</label>
                                    <input type="text" name="official_link" class="form-control cslug" placeholder="Official URL" value="{{ $official_link }}" >
                                </div>
                                @if(count($errors) > 0)
                                      @foreach($errors->get('official_link') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                      @endforeach 
                                    @endif
                               
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600 req">Meta Title</label>
                                    <div class="input-group">
                                        @php
                                            if (old('meta_title')) {
                                              $meta_title = old('meta_title');
                                            }elseif(isset($data) and !empty($data)){
                                              $meta_title = $data->meta_title;
                                            }else{
                                              $meta_title = "";
                                            }
                                          @endphp
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
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600 req">Meta Description</label>
                                    <div class="input-group">
                                        @php
                                            if (old('meta_description')) {
                                              $meta_description = old('meta_description');
                                            }elseif(isset($data) and !empty($data)){
                                              $meta_description = $data->meta_description;
                                            }else{
                                              $meta_description = "";
                                            }
                                          @endphp
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
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600 req">Meta Tags</label>
                                    <div class="input-group">
                                    @php
                                        if (old('meta_tags')) {
                                          $meta_tags = old('meta_tags');
                                        }elseif(isset($data) and !empty($data)){
                                          $meta_tags = $data->meta_tags;
                                        }else{
                                          $meta_tags = "";
                                        }
                                    @endphp
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
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Schema </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="schema">
                                                <div class="schema-rows">
                                                    @php
                                                       // dd($schema);6
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
                                                    for ($n=0; $n <=$t_quotes; $n++){
                                                    $schema_d=(isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "" ;
                                                    $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                                                    $style=(isset($schema[$n]["type"]) and Request::get('edit') and $schema[$n]["type"] !="" ) ? 'style="display: none;"': "" ;
                                                    $icon=(isset($schema[$n]["type"]) and Request::get('edit') and $schema[$n]["type"] !="") ? '<i class="fa fa-edit"></i>': '' ;
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
                                <div class="form-group">
                                    <label class="font-weight-600 req">Content:</label>
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
                                    <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="editor" data-return="#oneditor" data-link="image" >Add Image</a> </div>
                                    </div>
                                    
                                    <textarea class="form-control oneditor" rows="25" name="content" id="oneditor">{{ $content }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                           <label class="font-weight-600 req"> Category: </label>
                                        </div>
                                        <div class="card-body">
                                            <div class="skin-line">
                                              @php
                                                if (old('category')) {
                                                  $category = old('category');
                                                }elseif(isset($data) and !empty($data)){
                                                  $category = $data->category;
                                                }else{
                                                  $category = '';
                                                }
                                                $cats = [
                                                  '1' => "Govt",
                                                  '2' => "Private",
                                                  '3' => "Contract"
                                                ];
                                                @endphp
                                                @foreach ($cats as $ct => $value)
                                                <div class="i-check">
                                                    <input tabindex="17" type="radio" value="{{ $value}}" name="category" id="line-radio-1" {{ ($value == $category)?'checked':''}}>
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
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <label class="font-weight-600 req"> Job Type: </label>
                                        </div>
                                        <div class="card-body">
                                            <div class="skin-line">
                                              @php
                                                if (old('job_type')) {
                                                  $job_type = old('job_type');
                                                }elseif(isset($data) and !empty($data)){
                                                  $job_type = explode("," , $data->job_type);
                                                }else{
                                                  $job_type = array();
                                                }

                                                $typ = [
                                                '1' => "Full Time",
                                                '2' => "Part Time"
                                                ];
                                                @endphp
                                                @foreach ($typ as $ct => $value)
                                                <div class="i-check">
                                                    <input tabindex="17" type="checkbox" value="{{ $value}}" name="job_type[]" id="line-checkbox-1" {{ (in_array($value, $job_type))?'checked':''}}>
                                                    <label for="line-checkbox-1">{{ $value }}</label>
                                                </div>
                                              @endforeach
                                            </div>
                                            @if(count($errors) > 0)
                                              @foreach($errors->get('job_type') as $error)
                                                <div class="text-danger">{{ $error }}</div>
                                              @endforeach 
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <label class="font-weight-600 req"> Job Shift: </label>
                                        </div>
                                        <div class="card-body">
                                            <div class="skin-line">
                                                @php
                                                if (old('job_shift')) {
                                                  $job_shift = old('job_shift');
                                                }elseif(isset($data) and !empty($data)){
                                                  $job_shift = explode("," , $data->job_shift);
                                                }else{
                                                  $job_shift = array();
                                                }
                                                $shift = [
                                                '1' => "Morning",
                                                '2' => "Evening",
                                                '3' => "Night"
                                                ];
                                                @endphp
                                                @foreach ($shift as $ct => $value)
                                                <div class="i-check">
                                                    <input tabindex="17" type="checkbox" value="{{ $value}}" name="job_shift[]" id="line-checkbox-1" {{ (in_array($value, $job_shift))?'checked':''}}>
                                                    <label for="line-checkbox-1">{{ $value }}</label>
                                                </div>
                                                @endforeach
                                            </div>  
                                            @if(count($errors) > 0)
                                              @foreach($errors->get('job_shift') as $error)
                                                <div class="text-danger">{{ $error }}</div>
                                              @endforeach 
                                            @endif                                          
                                        </div>
                                    </div>
                                </div>
                                @if ($__userType != "admin")
                                  <div class="form-group col-lg-12 col-md-12">
                                      <div class="card">
                                          <div class="card-header card bg-secondary text-white">
                                              <b> District / Location </b>
                                          </div>
                                          <div class="card-body">
                                              <div class="col-lg-12">
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
                                                  <input type="hidden" name="province" value="{{ $province }}">
                                                  <input type="text" class="form-control" name="" value="{{ $city }}"  readonly="true">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  {{-- expr --}}
                                @endif
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <label class="font-weight-600 req"> Due Date: </label>
                                        </div>
                                       
                                        @php
                                            if (old('due_date')) {
                                              $due_date = old('due_date');
                                            }elseif(isset($data) and !empty($data)){
                                              $due_date = date("d/m/Y" ,  strtotime($data->due_date));
                                            }else{
                                              $due_date = "";
                                            }
                                        @endphp
                                        <div class="card-body">
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control" data-toggle="datepicker" autocomplete="off" name="due_date" placeholder="DD/MM/YYYY" value="{{ $due_date }}" id="date-picker">

                                                @if(count($errors) > 0)
                                                  @foreach($errors->get('due_date') as $error)
                                                    <div class="text-danger">{{ $error }}</div>
                                                  @endforeach 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Vacancies </b>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                if (old('vacancies')) {
                                                  $vacancies = old('vacancies');
                                                }elseif(isset($data) and !empty($data)){
                                                  $vacancies = $data->vacancies;
                                                }else{
                                                  $vacancies = "";
                                                }
                                            @endphp
                                            <div class="col-lg-12">
                                                <input type="number" min="1" max="10000"class="form-control" placeholder="Number of Vacancies" name="vacancies" value="{{ $vacancies }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Published By </b>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                if (old('published_by')) {
                                                  $published_by = old('published_by');
                                                }elseif(isset($data) and !empty($data)){
                                                  $published_by = $data->published_by;
                                                }else{
                                                  $published_by = "";
                                                }

                                            @endphp
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control" placeholder="e.g: Express News" name="published_by" value="{{ $published_by }}">
                                                @if(count($errors) > 0)
                                                  @foreach($errors->get('published_by') as $error)
                                                    <div class="text-danger">{{ $error }}</div>
                                                  @endforeach 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
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
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <span style="font-weight: 600;"> OG Image &nbsp; &nbsp; &nbsp;  Min Size: 1200 x 627 </span>
                                        </div>
                                        <div class="card-body">
                                            @php
                                            $og_image = (isset($data) !=""  and $data->og_image !="") ? "<img src=".$data->og_image." alt=''>" : "";
                                            @endphp
                                            <div class="uc-image" style="width: 97%;">
                                                <input type="hidden" name="og-image" value="{{ isset($data->og_image)?$data->og_image :"" }}">
                                                <div id="og-image" class="image_display">
                                                    {!! $og_image !!}
                                                </div>
                                                <div style="margin-top:10px;">
                                                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#og-image" data-link="og-image">Add Image</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Submit Record <span class="float-right">
                                            </div>
                                            <div class="card-body">
                                                <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Publish </button>
                                                <button type="submit" name="submit" value="draft" class="btn btn-info float-left">Draft </button>
                                                <br><br>
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
    $(document).on("click", ".clear-data2", function() {
    var v = window.confirm("Do you want to delete data?");
    if (v) {
    $(this).closest(".row").remove();
    }
    });
    </script>