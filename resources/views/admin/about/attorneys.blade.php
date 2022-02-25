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
              <h6 class="fs-17 font-weight-600 mb-0">Attorneys</h6>
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
          $res   = ($data->attorneys  !="" )? json_decode($data->attorneys , true) : array();
          $attorneys = (isset($res['attorneys'])) ?  $res['attorneys'] : array();
          @endphp
          <form method="POST" action="/{{ admin }}/about/attorneys" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}"> 
                <div class="form-group">
                  <label class="font-weight-600">Heading</label>
                  <input type="text" name="m_heading" class="form-control" placeholder="Main Heading" value="{{ isset($res['m_heading'])?$res['m_heading']:''}}">
                </div>
                <div class="reviews">
                  <div class="form-rows">
                    @php
                      $rev_count = (count($attorneys)==0) ? 0 : count($attorneys) - 1;
                        for ($n=0; $n <=$rev_count; $n++){
                          $name = (isset($attorneys[$n]["name"])) ? $attorneys[$n]["name"]: "";
                          $img = (isset($attorneys[$n]["img"])) ? $attorneys[$n]["img"]: "";
                          $designation = (isset($attorneys[$n]["designation"])) ? $attorneys[$n]["designation"]: "";
                          $fb_url = (isset($attorneys[$n]["fb_url"])) ? $attorneys[$n]["fb_url"]: "";
                          $twitter_url = (isset($attorneys[$n]["twitter_url"])) ? $attorneys[$n]["twitter_url"]: "";
                          $instagram_url = (isset($attorneys[$n]["instagram_url"])) ? $attorneys[$n]["instagram_url"]: "";
                          $linkedin_url = (isset($attorneys[$n]["linkedin_url"])) ? $attorneys[$n]["linkedin_url"]: "";
                          $details = (isset($attorneys[$n]["details"])) ? $attorneys[$n]["details"]: "";
                    @endphp
                    <div class="new-review border row">
                      <span class="clear-data">x</span>
                    <div class="form-group col-lg-3" style="text-align: center;">
                      <h6> <b>Attorney {{ $n+1 }}</b></h6>
                      <label><b>Image</b> <b>Size : </b><small> <b>350 x 400</b></small></label> <br>
                      <div class="uc-image" style="width:150px;height:150px;">
                            <span class="clear-image-x">x</span>
                            <input type="hidden" name="img<?php echo $n; ?>" value="<?php echo $img ?>">
                            <div id="img<?php echo $n; ?>" class="image_display">
                               @php
                            $img = ($img !="") ? "<img src=".$img." alt=''>" : "";
                            @endphp
                             {!! $img !!}
                            </div>
                            <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img<?php echo $n; ?>" data-link="img<?php echo $n; ?>">Add Image</a></div>
                      </div>
                      <br> <br>
                    </div>
                    <div class="col-lg-9">
                    <div class="form-row">
                      <div class="form-group col-lg-6">
                        <label>Name</label>
                        <input type="text" name="name[]" class="form-control" value="{{ $name }}"/>
                        <div class="text-danger"> </div>
                      </div>
                      <div class="form-group col-lg-6">
                        <label>Designation</label>
                        <input type="text" name="designation[]" class="form-control" value="{{ $designation }}"/>
                        <div class="text-danger"> </div>
                      </div>
                    </div>
                      <div class="form-group">
                        <label>Facebook Link</label>
                        <input type="text" name="fb_url[]" class="form-control" value="{{ $fb_url }}"/>
                        <div class="text-danger"> </div>
                      </div>
                       <div class="form-group">
                        <label>Twitter Link</label>
                        <input type="text" name="twitter_url[]" class="form-control" value="{{ $twitter_url }}"/>
                        <div class="text-danger"> </div>
                      </div>
                      <div class="form-group">
                        <label>Linkedin Link</label>
                        <input type="text" name="linkedin_url[]" class="form-control" value="{{ $linkedin_url }}"/>
                        <div class="text-danger"> </div>
                      </div>
                      <div class="form-group">
                        <label>Instagram Link</label>
                        <input type="text" name="instagram_url[]" class="form-control" value="{{ $instagram_url }}"/>
                        <div class="text-danger"> </div>
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
              <div class="form-group col-lg-12">
                <br>
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
    $(document).ready(function() {  
    var clone = '<div class="new-review border row">'+
                  '<span class="clear-data">x</span>'+
                '<div class="form-group col-lg-3" style="text-align: center;">'+
                  '<h6> <b>Attorney <span class="num"> </span> </b></h6>'+
                  '<label><b>Image</b> <b>Size : </b><small> <b>350 x 400</b></small></label> <br>'+
                  '<div class="uc-image" style="width:150px;height:150px;">'+
                        '<span class="clear-image-x">x</span>'+
                        '<input type="hidden" name="img" value="">'+
                        '<div id="img" class="image_display"></div>'+
                        '<div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img" data-link="img">Add Image</a></div>'+
                  '</div><br> <br></div>'+
                '<div class="col-lg-9">'+
                    '<div class="form-row">'+
                      '<div class="form-group col-lg-6">'+
                        '<label>Name</label>'+
                        '<input type="text" name="name[]" class="form-control" value=""/>'+
                      '</div>'+
                      '<div class="form-group col-lg-6">'+
                        '<label>Designation</label>'+
                        '<input type="text" name="designation[]" class="form-control" value=""/>'+
                      '</div>'+
                    '</div>'+
                      '<div class="form-group">'+
                        '<label>Facebook Link</label>'+
                        '<input type="text" name="fb_url[]" class="form-control" value=""/>'+
                      '</div>'+
                       '<div class="form-group">'+
                        '<label>Twitter Link</label>'+
                        '<input type="text" name="twitter_url[]" class="form-control" value=""/>'+
                      '</div>'+
                      '<div class="form-group">'+
                        '<label>Linkedin Link</label>'+
                        '<input type="text" name="linkedin_url[]" class="form-control" value=""/>'+
                      '</div>'+
                      '<div class="form-group">'+
                        '<label>Instagram Link</label>'+
                        '<input type="text" name="instagram_url[]" class="form-control" value=""/>'+
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
