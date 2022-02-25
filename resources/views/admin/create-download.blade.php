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
                            <h6 class="fs-17 font-weight-600 mb-0">Notifications And Downloads List</h6>
                        </div>
                        <div class="text-right">
                            <div class="actions">
                                <a href="{{ route('create-download') }}" class="btn {{ Request::segment(2)=='download'  &&  Request::segment(3)=='new'  ? 'btn-inverse' : 'btn-info' }} pull-right">Create New</a>
                                <a href="{{ route('download-list') }}" class="btn {{ Request::segment(2)=='download'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Document List</a>
                                @if ($__userType == 'province' || $__userType == 'national')
                                  <a href="{{ route('district-notifications-meta') }}" class="btn {{ Request::segment(3)=='notifications-meta' ? 'btn-inverse' : 'btn-info' }} pull-right">Notification Meta</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('create-download') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-md-12">
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
                                <strong>Whoops!</strong> Some Input Fields Are Missing.
                            </div>
                            @endif
                          </div>
                            <div class="col-lg-8">
                                @if (Request::get('edit') !="")
                                    <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                @endif
                                <div class="form-group p-0">
                                  @php
                                    if (old('title')) {
                                      $title = old('title');
                                    }elseif(isset($data) and !empty($data)){
                                      $title = $data->title;
                                    }else{
                                      $title = "";
                                    }
                                  @endphp
                                    <label class="font-weight-600 req">Document Title</label>
                                    <div class="input-group">
                                        @php
                                        $url = (Request::get('edit')) !="" ? "":"slug";
                                        @endphp
                                        <input type="text" name="title" class="form-control" placeholder="Document Title Here" value="{{ $title }}" data-link="{{ $url }}">
                                    </div>
                                    @if(count($errors) > 0)
                                      @foreach($errors->get('title') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                      @endforeach 
                                    @endif
                                </div>
                                <div class="form-group p-0">
                                  @php
                                    if (old('description')) {
                                      $description = old('description');
                                    }elseif(isset($data) and !empty($data)){
                                      $description = $data->description;
                                    }else{
                                      $description = "";
                                    }
                                  @endphp
                                  <label class="font-weight-600 req">Document Description</label>
                                        <textarea class="form-control tcount" id="exampleFormControlTextarea1" placeholder="Document Description Here" rows="3" name="description" data-count="text">{{ $description }}</textarea>
                                    @if(count($errors) > 0)
                                      @foreach($errors->get('description') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                      @endforeach 
                                    @endif
                                </div>
                                
                                <div class="form-group p-0">
                                    @php
                                      if (old('date')) {
                                        $date = old('date');
                                      }elseif(isset($data) and $data->date != Null){
                                        $date = explode("-",$data->date);
                                        $date = $date[2]."/".$date[1]."/".$date[0];
                                      }else{
                                        $date = "";
                                      }
                                    @endphp
                                    <label class="font-weight-600 req">Date:</label>
                                    <input type="text" class="form-control" data-toggle="datepicker" autocomplete="off" name="date" placeholder="DD/MM/YYYY" value="{{ $date }}" id="date-picker">
                                    @if(count($errors) > 0)
                                      @foreach($errors->get('date') as $error)
                                        <div class="text-danger">{{ $error }}</div>
                                      @endforeach 
                                    @endif
                                </div>
                                <div class="form-group">
                                  <label class="font-weight-600 req">Document Type</label>
                                  @php
                                    if (old('type')) {
                                      $type = old('type');
                                    }elseif(isset($data) and !empty($data)){
                                      $type = $data->type;
                                    }else{
                                      $type = "";
                                    }
                                  @endphp
                                  @php
                                  $ar = array(
                                      'imp-docs' => "Important Document",
                                      'govt-notification' => "Govt Notification"
                                  );
                                  @endphp
                                  <select name="type" class="form-control">
                                      <option value="">Please Select Document Type</option>
                                      @foreach ($ar as $k => $v)
                                      @php
                                      $selected = ($k == $type) ? "selected=selected" : "" ;
                                      @endphp
                                      <option value="{{ $k}}" {{ $selected }}>{{ $v}}</option>
                                      @endforeach
                                  </select>
                                   @if(count($errors) > 0)
                                    @foreach($errors->get('type') as $error)
                                      <div class="text-danger">{{ $error }}</div>
                                    @endforeach 
                                  @endif
                                </div>
                                <div class="form-group">
                                  <label class="font-weight-600">Watermark</label>
                                  @php
                                    if (old('watermark')) {
                                      $watermark = old('watermark');
                                    }elseif(isset($data) and !empty($data)){
                                      $watermark = $data->watermark;
                                    }else{
                                      $watermark = "";
                                    }
                                  @endphp
                                    <input type="text" name="watermark" class="form-control" value="{{ $watermark }}" placeholder="Example: APJEA.COM">
                                    @error('watermark')
                                      <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @php
                                    $style = "style='display:none;'";
                                    if (old('img_status')) {
                                      $img_status = old('img_status');
                                    }elseif(isset($data) and ($data->img_status =="on")){
                                      $img_status = "checked";
                                      $style  = "style='display:block;'";
                                    }else{
                                      $img_status = "";
                                      $style = "style='display:none;'";
                                    }
                                @endphp
                                <div class="form-group p-0">
                                  <div class="custom-control custom-switch">
                                    <input type="checkbox" {{ $img_status }}  class="custom-control-input change_status coupon_question" id="customSwitches" name="img_status">
                                    <label class="custom-control-label font-weight-600" for="customSwitches" style="padding: 8px 0px 0px 33px;">Mannual Image</label>
                                  </div>
                                </div>
                                <div class="form-group p-0 mannual-img" {!! $style !!}>
                                  <div class="card">
                                    <div class="card-header card bg-secondary text-white">
                                      <b> Mannual Image &nbsp; &nbsp; Min Size <small>70 x 90</small></b>
                                    </div>
                                    <div class="card-body">
                                      <div class="form-group col-lg-12 flex-center">
                                        <label class="font-weight-600"></label> <br>
                                        <div class="uc-image" style="width:150px;height:150px;">
                                          <span class="clear-image-x">x</span>
                                          <input type="hidden" name="mannual_image" value="{{ isset($data)?$data->mannual_image:''}}">
                                          <div id="mannual_image" class="image_display">
                                            @php
                                            $mannual_image = (isset($data) !=""  and $data->mannual_image !="") ? "<img src=".$data->mannual_image." alt=''>" : "";
                                            @endphp
                                            {!! $mannual_image !!}
                                          </div>
                                          <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#mannual_image" data-link="mannual_image">Add Image</a></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group p-0">
                                  <label class="font-weight-600 req">Upload PDF File:</label>
                                  @php
                                    if (old('file')) {
                                      $file = old('file');
                                      $pdf_image = "";
                                    }elseif(isset($data) and !empty($data)){
                                      $file = $data->file;
                                      $pdf_image = $data->pdf_img;
                                    }else{
                                      $file = $pdf_image = "";
                                    }
                                  @endphp
                                  <input type="file" name="file" class="input-file" value="{{ $file }}" id="files" >
                                  <div class="input-group col-xs-12">
                                      <span class="input-group-addon"><i class="fa fa-video-camera"></i></span>
                                      <input type="text" name="pdffile" value="{{ $file }}" class="form-control" disabled="" placeholder="Upload PDF">
                                      <input type="hidden" name="mypdf" value="{{ $file }}">
                                      <input type="hidden" name="pdf_name" value="{{ $pdf_image }}">
                                      <span class="input-group-btn">
                                          <button class="upload-field btn btn-info" type="button"><i class="fa fa-search"></i> Browse</button>
                                      </span>
                                  </div>
                                  @if(count($errors) > 0)
                                    @foreach($errors->get('file') as $error)
                                      <div class="text-danger">{{ $error }}</div>
                                    @endforeach 
                                  @endif
                                </div>
                                @php
                                   $userdata =  _user_data();                                       
                                   $type = $userdata['type'];
                                   $national = $userdata['natonal'];
                                   $province = $userdata['province'];
                                @endphp   
                                <input type="hidden" name="user_type" value="{{ $type }}">
                                <input type="hidden" name="national" value="{{ $national }}">
                                <input type="hidden" name="province" value="{{ $province }}">
                            </div>
                            <div class="col-lg-4" id="container">
                              <canvas id="the-canvas" style="height: 300px;width: 100%"></canvas>
                            </div>
                            <div class="col-md-8 form-group">
                              <input type="hidden" name="submit">
                              <button type="submit" value="publish" class="btn btn-info float-right submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <div class="gif-div">
    <img src="{{ asset('admin-assets/uploading-gif.gif') }}" alt="uploading gif">
  </div>
@if ($__userType == 'admin')
  @include('admin.layout.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif

  <script type="text/javascript">
    function submit_pdf(th) {
      $(th).attr('disabled',true)
    }
    $(".coupon_question").click(function() {
        if($(this).is(":checked")) {
            $(".mannual-img").show(300);
        } else {
            $(".mannual-img").hide(200);
        }
    });
    $(document).on('click', '.upload-field', function(){
      var file = $(this).parent().parent().parent().find('.input-file');
      file.trigger('click');
    });
    $(document).on('change', '.input-file', function(){
      $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.2.2/pdf.min.js"></script>
<script>
  const PDF_TYPE = "application/pdf";
  const TXT_TYPE = "text/plain";

  document.getElementById('files').addEventListener('change', handleFileSelect, false);


  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object
    for (var i = 0, f; f = files[i]; i++) {
      let fileType = files[i].type;
      if (fileType === PDF_TYPE) {
        handlePDFFile(files[i]);
      } else if (fileType === TXT_TYPE) {
        handleTxtFile(files[i])
      } else {
        console.error(`cannot handle file type: ${fileType}`)
      }
    }
  }

  function handleTxtFile(file) {
    var reader = new FileReader();
    reader.onload = (function(reader) {
      return function() {
        var contents = reader.result;
        var lines = contents.split('\n');

        document.getElementById('container').innerHTML = contents;
      }
    })(reader);

    reader.readAsText(file);
  }
  function handlePDFFile(file) {
    var reader = new FileReader();

    reader.onload = (function(reader) {
      return function() {
        var contents = reader.result;
        var loadingTask = pdfjsLib.getDocument(contents);

        loadingTask.promise.then(function(pdf) {
          pdf.getPage(1).then(function(page) {
            var scale = 1.5;
            var viewport = page.getViewport({
              scale: scale,
            });

            var canvas = document.getElementById('the-canvas');
            var context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;


            var renderContext = {
              canvasContext: context,
              viewport: viewport
            };
            page.render(renderContext);
          });
        });
      }
    })(reader);
    reader.readAsDataURL(file);
  }
      $(document).on('click', '.submit-btn', function(){
        // $('form').submit();
        // $(this).attr('disabled','true');
        $(".gif-div").css("display", "block");
      });
</script>