 @include('admin.layout.header')
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
                            <h6 class="fs-17 font-weight-600 mb-0">Welfare Benefits</h6>
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
                    <form method="POST" action="{{ route('welfare-benefits') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                @php
                                @endphp
                                    <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
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
                                    <input type="text" name="title" class="form-control cslug" value="{{ $title }}" data-link="slug">
                                    @if(count($errors) > 0)
                                      @foreach($errors->get('title') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                      @endforeach 
                                    @endif
                                </div>
                                {{-- <div class="form-group">
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
                                </div> --}}
                                <div class="form-group col-md-12 p-0">
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
                                <div class="form-group col-md-12 p-0">
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
                                <div class="form-group col-lg-12 col-md-12 p-0">
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
                                                    $res = isset($data)? json_decode($data->green_text , true) : array();
                                                   
                                                    for ($n=0; $n <2; $n++){ 
                                                    	$gr_heading=(isset($res[$n]["gr_heading"])) ? $res[$n]["gr_heading"]: "" ;
                                                    	$gr_icon=(isset($res[$n]["gr_icon"])) ? $res[$n]["gr_icon"]: "" ; 
                                                    	$gr_body=(isset($res[$n]["gr_body"])) ? $res[$n]["gr_body"]: "" ; 
                                                    	@endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <div class="col-lg-12">
                                                            <p class="mx-auto text-center"><b> Green Text {{ $n+1 }}</b></p>
                                                            <div class="form-row">
                                                            	<div class="form-group col-lg-6">
                                                                <label>Heading</label>
                                                                <input type="text" name="gr_heading[]" placeholder="Heading Title" class="form-control" value="{{ $gr_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>Icon</label>
                                                                <input type="text" name="gr_icon[]" placeholder="<i class='fa fa-icon'></i>" class="form-control" value="{{ $gr_icon }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                <textarea rows="3" name="gr_body[]" class="form-control oneditor" placeholder="quote"> {{ $gr_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
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
                                                    $res = isset($data)? $data->black_text  : "";
                                                     @endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <textarea rows="3" name="black_body" class="form-control oneditor" placeholder="quote"> {!! $res !!} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Hadees / Quotes </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="quote">
                                                <div class="form-rows quote-rows">
                                                    @php
                                                    $res = isset($data)? json_decode($data->quote , true) : array();
                                                    $f_count = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$f_count; $n++){ $reference=(isset($res[$n]["reference"])) ? $res[$n]["reference"]: "" ; $quote=(isset($res[$n]["quote"])) ? $res[$n]["quote"]: "" ; @endphp <div class="new-quote border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Quote {{ $n+1 }}</b></p>
                                                        <input type="hidden" name="num[]" value="{{ $n+1 }}">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Reference</label>
                                                                <input type="text" name="reference[]" placeholder="reference" class="form-control" value="{{ isset($data)? $reference:"" }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Quote</label>
                                                                <textarea rows="3" name="quote[]" class="form-control oneditor" placeholder="quote">{{ isset($data)? $quote:"" }}</textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                    }
                                                    @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-quote"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
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
                                        <div style="margin-top:10px;"> 
                                            <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="editor" data-return="#oneditor" data-link="image" >Add Image</a> 
                                            <a type="button" class="btn btn-info btn-sm float-right " data-toggle="modal" data-target="#shortcode-model"><i class="fa fa-info"></i> &nbsp; Short Codes Discription</a> 
                                        </div>
                                    </div>
                                    <textarea class="form-control oneditor" rows="25" name="content" id="oneditor">{{ $content }}</textarea>
                                </div>
                                
                            </div>
                            <div class="col-lg-4 col-md-12">
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
                                    <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Publish </button>
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
                        <td> Black Green Box: </td>
                        <td> [[black-green-box]] </td>
                        <td> Black and Green box data will be replaced by this short code. For Example: <a href="{{ asset('assets/compress/black-green-box.png') }}" target="_blank">Click Here</a> </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
  @include('admin.layout.footer')
<script>
$(document).ready(function() {
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
var clonequote = '<div class="new-quote border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> quote <span class="no"></span> </b></p>' +
    '<input type="hidden" name="num[]" value="">' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Reference</label>' +
            '<input type="text" name="reference[]" placeholder="reference" class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        ' <div class="form-group">' +
            '<label>Quote</label>' +
            '<textarea rows="3" name="quote[]" class="form-control oneditor" placeholder="quote" ></textarea>' +
            '<div class="text-danger"> </div>' +
        ' </div>' +
    '</div>' +
'</div>';
$(".add-quote").click(function(e) {
e.preventDefault();
var html_obj = clonequote;
$(".quote .quote-rows").append(html_obj);
var n = $(".quote .quote-rows").find(".new-quote").length;
var el = $(".quote .quote-rows .new-quote:nth-child(" + n + ")");
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