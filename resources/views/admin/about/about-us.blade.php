@include('admin.layout.header')
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
              <h6 class="fs-17 font-weight-600 mb-0">About Us</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/about')}}" class="btn {{Request::segment(2)=='about'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Main Record</a>
                <a href="{{url('/'.admin.'/about/attorneys')}}" class="btn {{Request::segment(2)=='about'  &&  Request::segment(3)=='attorneys'  ? 'btn-inverse' : 'btn-info' }} pull-right">Attorneys</a>
                <a href="{{url('/'.admin.'/about/reviews')}}" class="btn {{Request::segment(2)=='about'  &&  Request::segment(3)=='reviews'  ? 'btn-inverse' : 'btn-info' }} pull-right">Reviews</a>
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
          @php
          
          $meta   = ($data->about_meta  !="" )? json_decode($data->about_meta , true) : array();
          $schema   = ($data->microdata  !="" )? json_decode($data->microdata , true) : array();
          @endphp
          <form method="POST" action="/{{ admin }}/about" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-8">
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <div class="form-group col-lg-12 p-0">
                  <label class="font-weight-600">Meta Title</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ isset($data)?$meta['meta_title']:''}}" data-count="text">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ isset($data)? strlen($meta['meta_title']):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-12 p-0">
                  <label class="font-weight-600">Meta Description</label>
                  <div class="input-group">
                    <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ isset($data)?$meta['meta_description']:''}}</textarea>
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ isset($data)? strlen($meta['meta_description']):'0'}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Tags</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ isset($data)?$meta['meta_tags']:''}}">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ isset($data)?count(explode(",",$meta['meta_tags'])):'0'}}</span>
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
              <div class="col-lg-4">
                  {{-- <div class="form-group col-lg-12">
                    <label class="font-weight-600">About-Us Image</label> <br>
                    <div class="uc-image mx-auto" style="width:150px;height:150px;">
                      <span class="clear-image-x">x</span>
                      <input type="hidden" name="about_image" value="{{ isset($data)?$meta['about_image']:''}}">
                      <div id="about_image" class="image_display">
                         @php
                      $about_image = (isset($data) !=""  and $meta['about_image'] !="") ? "<img src=".$meta['about_image']." alt=''>" : "";
                      @endphp
                        {!! $about_image !!}
                      </div>
                      <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#about_image" data-link="about_image">Add Image</a></div>
                    </div>
                  </div> --}}

                    <div class="card">
                        <div class="card-header card bg-secondary text-white">
                            <span style="font-weight: 600;"> OG Image &nbsp; &nbsp; &nbsp;  Min Size: 1200 x 627 </span>
                        </div>
                        <div class="card-body text-center">
                          <div class="uc-image mx-auto" style="width:150px;height:150px;">
                            <span class="clear-image-x">x</span>
                            <input type="hidden" name="og_image" value="{{ isset($data)?$data['og_image']:''}}">
                            <div id="og_image" class="image_display">
                              @php
                            $og_image = (isset($data) !=""  and $data['og_image'] !="") ? "<img src=".$data['og_image']." alt=''>" : "";
                            @endphp
                              {!! $og_image !!}
                            </div>
                            <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#og_image" data-link="og_image">Add Image</a></div>
                          </div>
                        </div>
                    </div>
              </div>
                <div class="form-group col-lg-12 col-md-12 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Text Section 1 </b>
                    </div>
                    <div class="card-body">
                      <div class="reviews">
                        @php
                        $res = isset($data->text_sec1 )? json_decode($data->text_sec1 , true) : array();
                        $ts_img1 = (isset($res["ts_img1"])) ? $res["ts_img1"]: "";
                        $ts_details1 = (isset($res["ts_details1"])) ? $res["ts_details1"]: "";
                        @endphp
                        <div class="form-rows">
                          <div class="new-review row">
                            <div class="form-group col-lg-3" style="text-align: center;">
                              <label><b>Cover Image</b> <b>Size : </b><small>450 x 350</small></label> <br>
                              <div class="uc-image" style="width:150px;height:150px;">
                                <span class="clear-image-x">x</span>
                                <input type="hidden" name="ts_img1" value="{{ isset($data)? $ts_img1:"" }}">
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
                            <div class="col-lg-9">
                              <div class="form-group">
                                <label>Details</label>
                                <textarea rows="3" name="ts_details1" class="form-control oneditor" placeholder="Enter Details" value="">{{ isset($data)? $ts_details1:"" }}</textarea>
                                <div class="text-danger"> </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Text Section 2 </b>
                    </div>
                    <div class="card-body">
                      <div class="reviews">
                        @php
                        $res = isset($data->text_sec2)? json_decode($data->text_sec2 , true) : array();
                        $ts_img2 = (isset($res["ts_img2"])) ? $res["ts_img2"]: "";
                        $ts_details2 = (isset($res["ts_details2"])) ? $res["ts_details2"]: "";
                        @endphp
                        <div class="form-rows">
                          <div class="new-review row">
                            <div class="form-group col-lg-3" style="text-align: center;">
                              <label><b>Cover Image</b> <b>Size : </b><small>450 x 350</small></label> <br>
                              <div class="uc-image" style="width:150px;height:150px;">
                                <span class="clear-image-x">x</span>
                                <input type="hidden" name="ts_img2" value="{{ isset($data)? $ts_img2:"" }}">
                                <div id="ts_img2" class="image_display">
                                  @php
                                $ts_img2 = (isset($data) !=""  and $ts_img2 !="") ? "<img src=".$ts_img2." alt=''>" : "";
                                @endphp
                                  {!! $ts_img2 !!}
                                </div>
                                <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#ts_img2" data-link="ts_img2">Add Image</a></div>
                              </div>
                              <br> <br>
                            </div>
                            <div class="col-lg-9">
                              <div class="form-group">
                                <label>Details</label>
                                <textarea rows="3" name="ts_details2" class="form-control oneditor" placeholder="Enter Details" value="">{{ isset($data )? $ts_details2:"" }}</textarea>
                                <div class="text-danger"> </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Text Section 3 </b>
                    </div>
                    <div class="card-body">
                      <div class="reviews">
                        @php
                        $res = isset($data->text_sec3)? json_decode($data->text_sec3 , true) : array();
                        $ts_img3 = (isset($res["ts_img3"])) ? $res["ts_img3"]: "";
                        $ts_details3 = (isset($res["ts_details3"])) ? $res["ts_details3"]: "";
                        @endphp
                        <div class="form-rows">
                          <div class="new-review row">
                            <div class="form-group col-lg-3" style="text-align: center;">
                              <label><b>Cover Image</b> <b>Size : </b><small>450 x 350</small></label> <br>
                              <div class="uc-image" style="width:150px;height:150px;">
                                <span class="clear-image-x">x</span>
                                <input type="hidden" name="ts_img3" value="{{ isset($data)? $ts_img3:"" }}">
                                <div id="ts_img3" class="image_display">
                                  @php
                                $ts_img3 = (isset($data) !=""  and $ts_img3 !="") ? "<img src=".$ts_img3." alt=''>" : "";
                                @endphp
                                  {!! $ts_img3 !!}
                                </div>
                                <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#ts_img3" data-link="ts_img3">Add Image</a></div>
                              </div>
                              <br> <br>
                            </div>
                            <div class="col-lg-9">
                              <div class="form-group">
                                <label>Details</label>
                                <textarea rows="3" name="ts_details3" class="form-control oneditor" placeholder="Enter Details" value="">{{ isset($data )? $ts_details3:"" }}</textarea>
                                <div class="text-danger"> </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <div class="form-group col-lg-12 pr-0">
                <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Save Record</button>
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
var cloneServices =
'<div class="new-services border row">'+
  '<span class="clear-data2">x</span>'+
  '<div class="col-lg-12">'+
    '<h4 class="text-center"> <b>Service <span class="no"></span> </b></h4>'+
    '<div class="form-row">'+
      '<div class="form-group col-lg-6">'+
        '<label>Name</label>'+
        '<input type="text" name="servc_name[]" placeholder="Name" class="form-control" value=""/>'+
        '<div class="text-danger">'+
        '</div>'+
      '</div>'+
      ' <div class="form-group col-lg-6">'+
        '<label>Icon</label>'+
        '<input type="text" name="servc_icon[]" placeholder="icon" class="form-control" value=""/>'+
        '<div class="text-danger"> </div>'+
      '</div>'+
    '</div>'+
    '<div class="form-group">'+
      '<label>Details</label>'+
      '<textarea rows="3" name="services_details[]" class="form-control oneditor" placeholder="Enter Details" >  </textarea>'+
      '<div class="text-danger">'+ '</div>'+
    '</div>'+
  '</div>'+
'</div>';
$(".add-more-service").click(function(e) {
e.preventDefault();
var html_obj = cloneServices;
$(".services .services-rows").append(html_obj);
var n = $(".services .services-rows").find(".new-services").length;
var el =  $(".services .services-rows .new-services:nth-child("+n+")");
el.find(".no").text(n);
__tinyEd();
return false;
});
var quotes1Clone1 =
'<div class="new-quotes1 border row">'+
  '<span class="clear-data2">x</span>'+
  '<div class="col-lg-12">'+
    '<div class="form-row">'+
      '<div class="form-group col-lg-12">'+
        '<div style="text-align: center;"><b> Quotes <span class="no"></span></b> </div> <br>'+
        '<textarea rows="3" name="quotes1[]" class="form-control" placeholder="type Your Quotes heere..."  >  </textarea>'+
        '<label class="font-weight-600">Author Name</label>'+
        '<input type="text" name="auth_name1[]"  class="form-control" value="" placeholder="Author Name">'+
      '</div>'+
    '</div>'+
  '</div>'+
'</div>';
$(".add-more-quotes1").click(function() {
var html_obj = quotes1Clone1;
$(".quotes1 .quotes1-rows").append(html_obj);
var n = $(".quotes1 .quotes1-rows").find(".new-quotes1").length;
var el =  $(".quotes1 .quotes1-rows .new-quotes1:nth-child("+n+")");
el.find(".no").text(n);
return false;
});
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
var quotes1Clone2 =
'<div class="new-quotes2 border row">'+
  '<span class="clear-data2">x</span>'+
  '<div class="col-lg-12">'+
    '<div class="form-row">'+
      '<div class="form-group col-lg-12">'+
        '<div style="text-align: center;"><b> Quotes <span class="no"></span></b> </div> <br>'+
        '<textarea rows="3" name="quotes2[]" class="form-control" placeholder="type Your Quotes heere..."  >  </textarea>'+
        '<label class="font-weight-600">Author Name</label>'+
        '<input type="text" name="auth_name2[]"  class="form-control" value="" placeholder="Author Name">'+
      '</div>'+
    '</div>'+
  '</div>'+
'</div>';
$(".add-more-quotes2").click(function() {
var html_obj = quotes1Clone2;
$(".quotes2 .quotes2-rows").append(html_obj);
var n = $(".quotes2 .quotes2-rows").find(".new-quotes2").length;
var el =  $(".quotes2 .quotes2-rows .new-quotes2:nth-child("+n+")");
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