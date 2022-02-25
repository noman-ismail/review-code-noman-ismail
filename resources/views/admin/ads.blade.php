@include('admin.layout.header')
<div class="body-content">
  <div class="row">
    <div class="col-md-10 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Ads </h6>
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
          <form method="POST" action="/{{ admin }}/ads" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-10 col-md-12">
                @php             
                  $m_data   = (!empty($data->ads))? json_decode($data->ads , true) : array();
                @endphp
               <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <div class="ADs">
                  <div class="form-rows">
                    @php
                      $rev_count = (count($m_data)==0) ? 0 : count($m_data) - 1;
                        for ($n=0; $n <=$rev_count; $n++){
                          $title = (isset($m_data[$n]["title"])) ? $m_data[$n]["title"]: "";
                          $alt = (isset($m_data[$n]["alt"])) ? $m_data[$n]["alt"]: "";
                          $url = (isset($m_data[$n]["url"])) ? $m_data[$n]["url"]: "";
                          $img = (isset($m_data[$n]["img"])) ? $m_data[$n]["img"]: "";
                    @endphp
                    <div class="new-Ads border row">
                      <span class="clear-data">x</span>
                    <div class="form-group col-lg-5" style="text-align: center;">
                      <h6> <b>Ads {{ $n+1 }}</b></h6>
                      <br>
                      <div class="uc-image" style="width:150px;height:150px;">
                            <span class="clear-image-x">x</span>
                            <input type="hidden" name="img<?php echo $n; ?>" value="<?php echo $img ?>">
                             @php
                              $ad_img = ($img !="") ? "<img src=".$img." alt=''>" : "";
                              @endphp
                            <div id="img<?php echo $n; ?>" class="image_display">
                              {!! $ad_img !!}
                            </div>
                            <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img<?php echo $n; ?>" data-link="img<?php echo $n; ?>">Add Image</a></div>
                      </div>
                      <br> <br>
                    </div>
                    <div class="col-lg-7">
                      <input type="hidden" name="ads_id[]" value="{{ $n+1 }}">
                      <div class="form-group">
                        <label class="font-weight-600">Title :</label>
                        <input type="text" name="title[]" class="form-control" value="{{ $title }}"/>
                        <div class="text-danger"> </div>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-600">Alt Text :</label>
                        <input type="text" name="alt[]" class="form-control" value="{{ $alt }}"/>
                        <div class="text-danger"> </div>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-600">URL :</label>
                        <input type="text" name="url[]" class="form-control" value="{{ $url }}"/>
                        <div class="text-danger"> </div>
                      </div>
                    </div>
                  </div>
                  @php
                    }
                  @endphp
                  </div>
                </div>
                <br>
                <div style="text-align:right;">
                  <a href="" class="btn btn-success add-Ads">Add More</a>
                </div>
                <div class="form-group col-md-12 p-0">
                  <button type="submit" name="submit" value="publish" class="btn btn-info float-left">Save Record </button>
                </div>
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
    var clone = '<div class="new-Ads border row">'+
                  '<span class="clear-data">x</span>'+
                '<div class="form-group col-lg-5" style="text-align: center;">'+
                  '<h6> <b>Ads <span class="no" ></span> </b></h6>'+
                  '<br>'+
                  '<div class="uc-image" style="width:150px;height:150px;">'+
                        '<span class="clear-image-x">x</span>'+
                        '<input type="hidden" name="img" >'+
                        '<div id="img" class="image_display"><img src="" alt=""></div>'+
                        '<div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#img" data-link="img">Add Image</a></div>'+
                  '</div><br> <br></div>'+
              ' <div class="col-lg-7">'+
                    '<input type="hidden" name="ads_id[]" value="">'+
                     ' <div class="form-group">'+
                       ' <label class="font-weight-600">Title :</label>'+
                      '  <input type="text" name="title[]" class="form-control" value=""/>'+
                       ' <div class="text-danger"> </div>'+
                     ' </div>'+
                     ' <div class="form-group">'+
                      '  <label class="font-weight-600">Alt Text :</label>'+
                       ' <input type="text" name="alt[]" class="form-control" value=""/>'+
                        '<div class="text-danger"> </div>'+
                      '</div>'+
                      '<div class="form-group">'+
                       ' <label class="font-weight-600">URL :</label>'+
                       ' <input type="text" name="url[]" class="form-control" value=""/>'+
                        '<div class="text-danger"> </div>'+
                      '</div>'+
                   ' </div>'+
              '</div>'
      $(".add-Ads").click(function(e) {
        e.preventDefault();
        var html_obj = clone;
        var ln = $(".form-rows .row").length;
        $(html_obj).find("input").each(function(){
          $(this).attr("value", "");
        });
        $(html_obj).find("textarea").each(function(){
          $(this).text("");
        });
        $(html_obj).find("img").remove();
        
        $(".ADs .form-rows").append(html_obj);
        var n = $(".ADs .form-rows").find(".new-Ads").length;
        var el =  $(".ADs .form-rows .new-Ads:nth-child("+n+")");
        el.find(".uc-image").find("#img").attr("id", "img"+ln);
        el.find(".uc-image").find(".img").attr("class", "img"+ln);
        el.find(".uc-image").find(".image_display").attr("id", "img"+ln);
        el.find(".uc-image").find("input").attr("name", "img"+ln);
        el.find(".uc-image").find("a").attr("data-return", "#img"+ln);
        el.find(".uc-image").find("a").attr("data-link", "img"+ln);
         el.find(".no").text(n);
        el.find("input[type=hidden").attr("value"  , n);
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