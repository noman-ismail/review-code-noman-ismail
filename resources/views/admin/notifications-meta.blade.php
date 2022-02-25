
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
              <h6 class="fs-17 font-weight-600 mb-0">Notifications Meta</h6>
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
          <form method="POST" action="{{ route('notifications-meta') }}" enctype="multipart/form-data">
            @csrf
		
            <div class="row">
              <div class="col-lg-8 col-md-8">
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <input type="hidden" name="page_name" value="{{ isset($data)?$data->page_name:''}}">
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Page Title</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" placeholder="page title..." name="page_title" value="{{ isset($data)?$data->page_title:''}}" data-count="text">
                  </div>
                </div>
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
                  <label class="font-weight-600">Pagination Limit</label>
                  <div class="input-group">
                    <input type="number" class="form-control tcount" placeholder="" name="pagination" value="{{ ($data !="")?$data->pagination:''}}" >
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <div class="schema">
                    <div class="schema-rows">
                      @php
                      $schema   = ($data->microdata  !="" )? json_decode($data->microdata , true) : array();
                      $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                      for ($n=0; $n <=$t_quotes; $n++){
                      $schema_d = (isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "";
                      $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                      $style=(isset($schema[$n]["type"]) and  $schema[$n]["type"] !="" ) ? 'style="display: none;"': "" ;
                      $icon=( isset($schema[$n]["type"]) and $schema[$n]["type"] !="") ? '<i class="fa fa-edit"></i>': '' ;
                      @endphp
                      <div class="new-schema border row p-2">
                        <span class="clear-data2">x</span>
                        <div class="col-lg-12">
                          <div class="flex-center"><b><span class="no">{{ $n+1 }} &nbsp; - &nbsp; </span></b> <span class="schma_type">{{ $type }} {!! $icon !!}</span> <input  type="text" name="type[]" placeholder="schema name here" value="{{ $type }}"  {!! $style !!} >  </div> <br>
                          <div class="form-row">
                            <div class="form-group col-lg-12">
                              <textarea rows="6" name="schema[]" class="form-control" placeholder="type Your Quotes heere..." >{!! $schema_d !!}</textarea>
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
                    <a href="" class="btn btn-info add-more-schema text-white" title="Add More"><i class="fa fa-plus"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card">
                    <div class="card-header card bg-secondary text-white">
                        <span style="font-weight: 600;"> OG Image &nbsp; &nbsp; &nbsp;  Min Size: 1200 x 627 </span>
                    </div>
                    <div class="card-body text-center">
                      <div class="uc-image" style="width:150px;height:150px;">
                        <input type="hidden" name="og_image" value="{{ isset($data)?$data->og_image:''}}">
                        <div id="og_image" class="image_display">
                           @php
                            $og_image = (isset($data) !=""  and $data->og_image !="") ? "<img src=".$data->og_image." alt=''>" : "";
                            @endphp
                            {!! $og_image !!}
                        </div>
                        <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#og_image" data-link="og_image">Add Image</a></div>
                      </div>
                    </div>
                </div>
              </div>
              {{-- <div class="col-lg-12">
                <div class="form-group">
                  <label>Content</label>
                 <textarea name="content" class="form-control oneditor" id="oneditor" rows="20"  aria-hidden="true">{{$data?$data->content:''}}</textarea>
                </div>
              </div> --}}
              <div class="form-group col-lg-12">
                  <button type="submit" name="submit" value="submit" class="btn btn-info float-right">Submit <span class="fa fa-paper-plane"></span></button>
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