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
@elseif($__userType == 'province')
  @include('admin.province.layouts.header')
@elseif($__userType == 'national')
  @include('admin.national.layouts.header')
@endif
<div class="body-content">
  <div class="row">
    <div class="col-md-6 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Add Category</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/blogs')}}" class="btn {{ Request::segment(2)=='blogs'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                <a href="{{url('/'.admin.'/blogs/list')}}" class="btn {{ Request::segment(2)=='blogs'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">Blogs List</a>
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
          <form method="POST" action="/{{ admin }}/blogs/cats-store" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-12 col-md-12">
                 <input type="hidden" name="id" value="{{ ($edit !="")?$edit->id:''}}">
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600 req">Page Title</label>
                  <input type="text" name="title" class="form-control cslug"  value="{{ ($edit !="")?$edit->title:''}}" data-link="slug">
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600 req">Slug</label>
                  <input type="text" name="slug" value="{{ ($edit !="")?$edit->slug:''}}" class="form-control">
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Title</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ ($edit !="")?$edit->meta_title:''}}" data-count="text">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ ($edit !="")?strlen($edit->meta_title):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Description</label>
                  <div class="input-group">
                    <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ ($edit !="")?$edit->meta_description:''}}</textarea>
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ ($edit !="")?strlen($edit->meta_description):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Tags</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ ($edit !="")?$edit->meta_tags:''}}">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ ($edit !="")?count(explode(",",$edit->meta_tags)):'0'}}</span>
                    </div>
                  </div>
                </div>
          @php 
            $schema = (!empty($edit) and !empty($edit->microdata))? json_decode($edit->microdata , true) : array();
          @endphp         
                <div class="form-group col-md-12 p-0">
                   <div class="schema">
                    <div class="schema-rows">
                      @php
                      // $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                      $t_quotes = (count($schema) > 0) ? count($schema) - 1 : 0;
                      for ($n=0; $n <=$t_quotes; $n++){
                      $schema_d = (isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "";
                       $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                      $style=(isset($schema[$n]["type"]) and $schema[$n]["type"] !="" ) ? 'style="display: none;"': "" ;
                      $icon=(isset($schema[$n]["type"]) and $schema[$n]["type"] !="") ? '<i class="fa fa-edit"></i>': '' ;
                      @endphp
                      <div class="new-schema border row p-2">
                        <span class="clear-data2">x</span>
                        <div class="col-lg-12">
                          <div class="flex-center"><b><span class="no">{{ $n+1 }} &nbsp; - &nbsp; </span></b> <span class="schma_type">{{ $type }} {!! $icon !!}</span> <input  type="text" name="type[]" placeholder="schema name here" value="{{ $type }}"  {!! $style !!} >  </div> <br>
                          <div class="form-row">
                            <div class="form-group col-lg-12">
                              <textarea rows="6" name="schema[]" class="form-control" placeholder="type Your Quotes heere..." > {!! $schema_d !!} </textarea>
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
                    <a href="" class="btn btn-success add-more-schema text-white">Add More</a>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Details</label>
                  <div class="input-group">
                    <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="5" name="details" data-count="text">{{ ($edit !="")?$edit->details:''}}</textarea>
                  </div>
                </div>
                <div class="form-group col-lg-6">
                  <label class="font-weight-600">OG Image</label> <br>
                  <div class="uc-image" style="width:150px;height:150px;">
                    <input type="hidden" name="og_image" value="{{ isset($data)?$data->og_image:''}}">
                     @php
                      $og_image = (isset($data) !=""  and $data->og_image !="") ? "<img src=".$data->og_image." alt=''>" : "";
                     @endphp
                    <div id="og_image" class="image_display">
                      {!! $og_image !!}
                    </div>
                    <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#og_image" data-link="og_image">Add Image</a></div>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <button type="submit" name="submit" value="submit" class="btn btn-info float-right">Submit <span class="fa fa-paper-plane"></span></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Category List For Order</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/blogs/meta')}}" class="btn {{Request::segment(2)=='blogs'  &&  Request::segment(3)=='meta'  ? 'btn-inverse' : 'btn-info' }} pull-right">Meta Settings</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="/<?= admin ?>/category/order" method="post">
            @csrf
            <div class="row">
              <div class="col-lg-10 col-sm-12 col-lg-offset-1">
                <h3>Please Select Order</h3>
                <div class="form-group">
                  <ol id="sortable" class="m-tbc todo-list msortable ui-sortable">
                    @foreach($cats as $cat)
                    
                    <li title=""><input type="hidden" name="order[]" value="{{ $cat->id }}" class="form-control"/>
                    <b>{{$cat->title}}</b>
                    <div class="float-right">
                      <a href="{{url('/'.admin.'/blogs/category?edit='.$cat->id)}}" class="-soft  mr-1 fa fa-edit fa-lg" title="Edit"></a>
                      <a href="{{url('/'.admin.'/blogs/category?del='.$cat->id)}}" class="btn-danger-soft  fa fa-trash fa-lg sconfirm" title="Delete"></a>
                    </div>
                  </li>
                  @endforeach
                </ol>
              </div>
              <div class="form-group">
                <input type="submit" name="submit" value="submit" class="btn btn-info float-right"/>
              </div>
            </div>
          </div>
          <br>
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
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@else
  @php
      request()->session()->flush();
      $url = route('base_url').'/404';
      echo "<script>
      window.location = '$url';
      </script>";
  @endphp
@endif
<script>
var cloneSchema =
        '<div class="new-schema border row">' +
            '<span class="clear-data2">x</span>' +
            '<div class="col-lg-12">' +
                '<div class="form-row">' +
                    '<div class="form-group col-lg-12">' +
                        '<div class="flex-center"><b>  <span class="no"> </span> &nbsp; - &nbsp;</b> <input type="text" name="type[]" placeholder="schema name here" value=""  > </div> <br>' +
                        '<textarea rows="6" name="schema[]" class="form-control" placeholder="type Your Schema heere..."  >  </textarea>' +
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
</script>