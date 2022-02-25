@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
  full_editor();
@endphp
@if($__userType == 'admin')
  @include('admin.layout.header')
@elseif($__userType == 'district')
  @include('admin.district.layouts.header')
@elseif($__userType == 'province')
  @include('admin.province.layouts.header')
@endif
<div class="body-content">
  <div class="row">
    <div class="col-md-10 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Jobs Meta</h6>
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
          <form method="POST" action="{{ route('district-jobs-meta') }}" enctype="multipart/form-data">
            @php
              $meta   = (!empty($data->jobs_meta))? json_decode($data->jobs_meta , true) : array();
              $schema = (isset($meta['schema'] ) and $meta['schema'] !="") ? json_decode($meta['schema'], true) : array();
            @endphp
            @csrf
            <div class="row">
              <div class="col-lg-10 col-md-12">
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <div class="form-group col-lg-12 p-0">
                  <label class="font-weight-600">Meta Title</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ (isset($data) and !empty($data->jobs_meta))?$meta['meta_title']:''}}" data-count="text">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ (isset($data) and !empty($data->jobs_meta))? strlen($meta['meta_title']):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-12 p-0">
                  <label class="font-weight-600">Meta Description</label>
                  <div class="input-group">
                    <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ (isset($data) and !empty($data->jobs_meta))?$meta['meta_description']:''}}</textarea>
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ (isset($data) and !empty($data->jobs_meta))? strlen($meta['meta_description']):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Tags</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ (isset($data) and !empty($data->jobs_meta))?$meta['meta_tags']:''}}">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ (isset($data) and !empty($data->jobs_meta))?count(explode(",",$meta['meta_tags'])):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-12 p-0">
                  <div class="schema">
                    <div class="schema-rows">
                      @php
                      $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
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

              </div>
              <div class="form-group col-lg-10 col-md-12">
                  <button type="submit" name="submit" value="submit" class="btn btn-info float-right">Submit <span class="fa fa-paper-plane"></span></button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@if($__userType == 'admin')
  @include('admin.layout.footer')
@elseif($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
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