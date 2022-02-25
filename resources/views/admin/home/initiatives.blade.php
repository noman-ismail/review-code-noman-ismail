@include('admin.layout.header')
@php
tiny_editor();
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-md-10 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Initiatives</h6>
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
          @php
          $initiative  = ($data->initiatives  !="" )? json_decode($data->initiatives , true) : array();
          $initiatives = isset($initiative["initiatives"])? $initiative["initiatives"] : array();
          @endphp
          <form method="POST" action="/{{ admin }}/homepage/initiatives" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}"> 
                <div class="form-group">
                  <label class="font-weight-600">Heading</label>
                  <input type="text" name="m_heading" class="form-control" value="{{ isset($initiative['m_heading'])?$initiative['m_heading']:''}}">
                </div>
                <div class="reviews">
                  <div class="form-rows">
                    @php
                      $rev_count = (count($initiatives)==0) ? 0 : count($initiatives) - 1;
                        for ($n=0; $n <=$rev_count; $n++){
                          $title = (isset($initiatives[$n]["title"])) ? $initiatives[$n]["title"]: "";
                          $img = (isset($initiatives[$n]["img"])) ? $initiatives[$n]["img"]: "";
                          $anchor_url = (isset($initiatives[$n]["anchor_url"])) ? $initiatives[$n]["anchor_url"]: "";
                          $anchor_text  = (isset($initiatives[$n]["anchor_text"])) ? $initiatives[$n]["anchor_text"]: "";
                          $description  = (isset($initiatives[$n]["description"])) ? $initiatives[$n]["description"]: "";
                    @endphp
                    <div class="new-review flex-center border row">
                      <span class="clear-data">x</span>
                    <div class="form-group col-lg-3" style="text-align: center;">
                      <h6> <b>Initiatives {{ $n+1 }}</b></h6>
                      <label><b>Image</b> <b>Size : </b><small> <b> 50 x 50 </b></small></label> <br>
                      <div class="uc-image" style="width:150px;height:150px;">
                          <span class="clear-image-x">x</span>
                           <input type="hidden" name="img<?php echo $n; ?>" value="<?php echo $img ?>">
                           <div id="img<?php echo $n; ?>" class="image_display">
                             @php
                            $img = ($img !="") ? "<img src=".$img." alt=''>" : "";
                            @endphp
                             {!! $img !!}
                           </div>
                          <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img<?php echo $n; ?>" data-link="img<?php echo $n; ?>">Add Image</a>
                          </div>
                      </div>
                      <br> <br>
                    </div>
                    <div class="col-lg-9">
                    <div class="form-row">
                      <div class="form-group col-12">
                        <label><b>Title</b></label>
                        <input type="text" name="title[]" class="form-control" value="{{ $title }}"/>                        
                      </div>
                      <div class="form-group col-12">
                        <label><b>Anchor Text</b></label>
                        <input type="text" name="anchor_text[]" class="form-control" value="{{ $anchor_text }}"/>                        
                      </div>
                      <div class="form-group col-12">
                        <label><b>Achor Url</b></label>
                        <input type="text" name="anchor_url[]" class="form-control" value="{{ $anchor_url }}"/>                        
                      </div>
                    </div>
                     <div class="form-group">
                        <label><b>Description</b></label>
                        <textarea rows="5" name="description[]" class="form-control" placeholder="Enter Details">{{ isset($data)? $description:"" }}</textarea>                          
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
              <div class="form-group col-lg-12 pr-0">
                <br>
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
    $(document).ready(function() {  
    var clone = '<div class="new-review flex-center border row">'+
                  '<span class="clear-data">x</span>'+
                '<div class="form-group col-lg-3" style="text-align: center;">'+
                  '<h6> <b>Initiatives <span class="num"> </span> </b></h6>'+
                  '<label><b>Image</b> <b>Size : </b><small> <b>3 : 2</b></small></label> <br>'+
                  '<div class="uc-image" style="width:150px;height:150px;">'+
                        '<span class="clear-image-x">x</span>'+
                        '<input type="hidden" name="img" value="">'+
                        '<div id="img" class="image_display"></div>'+
                        '<div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img" data-link="img">Add Image</a></div>'+
                  '</div><br> <br></div>'+
                '<div class="col-lg-9">'+
                    '<div class="form-row">'+
                      '<div class="form-group col-lg-12">'+
                        '<label><b>Title</b></label>'+
                        '<input type="text" name="title[]" class="form-control" value=""/>'+
                      '</div>'+
                      '<div class="form-group col-lg-12">'+
                        '<label><b>Anchor Text</b></label>'+
                        '<input type="text" name="anchor_text[]" class="form-control" value=""/>'+
                      '</div>'+
                    '</div>'+
                      '<div class="form-group">'+
                        '<label>Achor Url</label>'+
                        '<input type="text" name="anchor_url[]" class="form-control" value=""/>'+
                      '<div class="form-group">'+
                        '<label><b>Description</b></label>'+
                        '<textarea rows="5" name="description[]" class="form-control" placeholder="Enter Details" value=""></textarea> '+                       
                      '</div>'+
                    '</div>'+
              '</div>';
      $(".add-review").click(function(e) {
        e.preventDefault();
        var html_obj = clone;
        var ln = $(".form-rows .row").length;
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
      $(document).on("click", ".clear-data", function() {
        var v = window.confirm("Do you want to delete data?");
        if (v) {
          $(this).closest(".row").remove();
        }
      });
    });

  </script>
