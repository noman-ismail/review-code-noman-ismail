@include('admin.layout.header')
@php
full_editor();
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Home Page </h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/homepage')}}" class="btn {{ Request::segment(2)=='homepage'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Home Meta</a>
                <a href="{{url('/'.admin.'/homepage/grants')}}" class="btn {{ Request::segment(2)=='homepage'  && Request::segment(3)=='grants'  ? 'btn-inverse' : 'btn-info' }} pull-right">Grants</a>
                
                <a href="{{url('/'.admin.'/homepage/interest')}}" class="btn {{ Request::segment(2)=='homepage'  && Request::segment(3)=='interest'  ? 'btn-inverse' : 'btn-info' }} pull-right">Success Score</a>
                <a href="{{url('/'.admin.'/homepage/initiatives')}}" class="btn {{ Request::segment(2)=='homepage'  && Request::segment(3)=='initiatives'  ? 'btn-inverse' : 'btn-info' }} pull-right">Initiatives</a>
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
          <form method="POST" action="/{{ admin }}/homepage" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-8">
                @php
                $m_data = json_decode($data->home_meta);
                @endphp
                @php
                $res = isset($data->text_sec1 )? json_decode($data->text_sec1 , true) : array();
               // dd($data);
                $ts_img1 = (isset($res["ts_img1"])) ? $res["ts_img1"]: "";
                $ts_title1 = (isset($res["ts_title1"])) ? $res["ts_title1"]: "";
                $ts_details1 = (isset($res["ts_details1"])) ? $res["ts_details1"]: "";
                @endphp
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Title</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ isset($m_data)?$m_data->meta_title:''}}" data-count="text">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ isset($m_data)?strlen($m_data->meta_title):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Description</label>
                  <div class="input-group">
                    <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ isset($m_data)?$m_data->meta_description:''}}</textarea>
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ isset($m_data)?strlen($m_data->meta_description):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Tags</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ isset($m_data)?$m_data->meta_tags:''}}">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ isset($m_data)?count(explode(",",$m_data->meta_tags)):'0'}}</span>
                    </div>
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
                      $style=(isset($schema[$n]["type"]) and $schema[$n]["type"] !="" ) ? 'style="display: none;"': "" ;
                      $icon=(isset($schema[$n]["type"]) and $schema[$n]["type"] !="") ? '<i class="fa fa-edit"></i>': '' ;
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
                    <a href="" class="btn btn-success add-more-schema text-white">Add More</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card">
                  <div class="card-header card bg-secondary text-white">
                    <b> OG Image &nbsp; &nbsp; &nbsp;  Min Size: 1200 x 627 </b>
                  </div>
                  <div class="card-body">
                    <div class="form-group col-lg-12 flex-center">
                      <label class="font-weight-600"></label> <br>
                      <div class="uc-image" style="width:150px;height:150px;">
                        <span class="clear-image-x">x</span>
                        <input type="hidden" name="og_image" value="{{ isset($m_data)?$m_data->og_image:''}}">
                        <div id="og_image" class="image_display">
                          @php
                          $og_image = (isset($m_data) !=""  and $m_data->og_image !="") ? "<img src=".$m_data->og_image." alt=''>" : "";
                          @endphp
                          {!! $og_image !!}
                        </div>
                        <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#og_image" data-link="og_image">Add Image</a></div>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <div class="card">
                  <div class="card-header card bg-secondary text-white">
                    <b> Text Section 1 Image &nbsp; &nbsp; Min Size: 460 x 623 </b>
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
              <div class="col-lg-12">
                <div class="form-group col-lg-12 col-md-12 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Text Section 1 </b>
                    </div>
                    <div class="card-body">
                      <div class="reviews">
                        <div class="form-rows">
                          <div class="new-review flex-center row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label>Details</label>
                                <textarea rows="15" name="ts_details1" class="form-control oneditor" placeholder="Enter Details" value="">{{ isset($data)? $ts_details1:"" }}</textarea>
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
              <div class="form-group col-md-12">
                <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Save Record </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')
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