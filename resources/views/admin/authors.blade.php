@if (auth('admin')->user()->type == 'province')
    @include('admin.province.layouts.header')
@elseif(auth('admin')->user()->type == 'admin')
    @include('admin.layout.header')
@elseif(auth('admin')->user()->type == 'national')
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
                            <h6 class="fs-17 font-weight-600 mb-0">Edit Author</h6>
                            @else
                            <h6 class="fs-17 font-weight-600 mb-0">Create New Author</h6>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="actions">
                                <a href="{{url('/'.admin.'/authors')}}" class="btn {{ Request::segment(2)=='authors'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                                <a href="{{url('/'.admin.'/authors/list')}}" class="btn {{ Request::segment(2)=='authors'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">Authors List</a>
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
                    <form method="POST" action="/{{ admin }}/authors/save" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                <input type="hidden" name="date" value="{{ isset($data)? $data->date : time() }}">
                                <div class="form-group">
                                    <label class="req">Author Name</label>
                                    @php
                                    $url = (Request::get('edit')) !="" ? "":"slug";
                                    @endphp
                                    <input type="text" name="name" class="form-control cslug" value="{{ isset($data)?$data->name:''}}" data-link="{{ $url }}">
                                </div>
                                <div class="col-lg-12 p-0">
                                    @php
                                    $social_links = isset($data)? json_decode($data->social_links , true) : array();
                                    @endphp
                                   <div class="card">
                                    <div class="card-header card bg-secondary text-white">
                                      <b> Social Media Links</b>
                                    </div>
                                    <div class="card-body">
                                      <div class="socialmedia">
                                        <div class="form-rows">
                                          <table class="table table-bordered">
                                            <thead>
                                              <tr>
                                                <th>#</th>
                                                <th>link</th>
                                                <th>icon</th>
                                                <th></th>
                                              </tr>
                                            </thead>
                                            <tbody  id="sortable" class=" social m-tbc todo-list msortable ui-sortable">
                                              
                                              @php 
                                              $res = $social_links; $rev_count = (count($res)==0) ? 0 : count($res) - 1; 
                                              for ($n=0; $n<=$rev_count; $n++){ 
                                                $link=( isset($res[$n][ "link"])) ? $res[$n][ "link"]: ""; 
                                                $icon=( isset($res[$n][ "icon"])) ? $res[$n][ "icon"]: "";
                                            @endphp
                                                  <tr class="tr-row">
                                                <td>{{ $n+1 }}</td>
                                                <td>
                                                  <div class="form-group m-0">
                                                    <input type="text" name="link[]" placeholder="Eg: https://fb.com/dgaps" class="form-control" value="{{ $link }}"/>
                                                    <div class="text-danger"> </div>
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="form-group m-0">
                                                    <div class="input-group">
                                                      <input type="text"  name="icon[]" placeholder="Eg: <i class='icon-facebook'></i>" class="form-control" value="{{ $icon }}"/>
                                                    </div>
                                                  </div>
                                                </td>
                                                <td class="text-center"> <i class="fa fa-trash text-danger clear-item mx-auto my-auto"></i>
                                                </td>
                                              </tr>
                                              @php } @endphp
                                            </tbody>
                                          </table>
                                          <div style="text-align:right;">
                                            <a href="" class="btn btn-success add-social text-white"><i class="fa fa-plus"></i></a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>   
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="req">Detail:</label>
                                    <textarea class="form-control oneditor" rows="5" name="details" id="oneditor">{{ isset($data)?$data->details:''}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group col-lg-12 col-md-12">
                                    <label for=""></label>
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <span><b> Cover Image <small> 300 x 300</small> </b> </span>
                                        </div>
                                        <div class="card-body">
                                            @php
                                            $cover = (isset($data) !="") ? $data->cover : "";
                                            @endphp
                                            <div class="uc-image" style="width: 97%;">
                                                <input type="hidden" name="cover-image" value="{{ $cover }}">
                                                <div id="coover" class="image_display">
                                                    @php
                                                  $cover = (isset($data) !=""  and $data->cover !="") ? "<img src=".$data->cover." alt=''>" : "";
                                                  @endphp
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
                                    <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Submit </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if (auth('admin')->user()->type == 'province')
    @include('admin.province.layouts.footer')
@elseif(auth('admin')->user()->type == 'admin')
    @include('admin.layout.footer')
@elseif(auth('admin')->user()->type == 'national')
    @include('admin.national.layouts.footer')
@endif
<script>
    $(".add-social").click(function() {
        var html_obj = $(".social tr").first().clone();
        var ln = $(".social tr").length;
        $(html_obj).find("input").each(function() {
            $(this).attr("value", "");
        });
        $(html_obj).find("textarea").each(function() {
            $(this).text("");
        });
        html_obj.find("td:first-child").text(parseInt(ln) + 1);
        $(".socialmedia .social").append("<tr>" + html_obj.html() + "</tr>");
        return false;
    });
    $(document).on("click", ".clear-item", function() {
        var v = window.confirm("Do you want to delete data?");
        if (v) {
            $(this).closest("tr").remove();
        }
    });

</script>
