@include('front.layout.header')
<link rel="stylesheet" href="{{ asset('assets/style/all.form.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/style/chosen.css') }}"/>
<link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
<script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
</head>
<body>
<div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu',['segment'=>'notification'])
  <header class="title-header main-header">
    <div class="container">
      <div class="header-text">
        <h1 class="header-title">Govt. Notifications</h1>
        <ul class="breadcrumb">
          <li><a href="{{ route('base_url') }}">Home</a></li>
          <li><span>Govt. Notifications</span></li>
        </ul>
      </div>
    </div>
  </header>
  <main class="download-section">
    <div class="container">
      <h3 class="main-head text-center">Govt. Notifications</h3>
      <form class="row search-row">
        <div class="col-md-12">
          <div class="input-group">
            <div class="flex-control">
              <i class="icon-search"></i>
              <input type="text" name="search" class="form-control" placeholder="Search Something" value="{{ request('search') }}">
            </div>
            <div class="flex-control">
              @php
                $ciit = DB::table('province')->orderby('id','asc')->get();
              @endphp
              <select name="province" class="form-control chosen-select" >
                <option value="">Select Province</option>
                @if (count($ciit) > 0)
                  @foreach ($ciit as $element)
                    <option value="{{ $element->id }}" {{ (request('province') == $element->id) ? "selected" : "" }}>{{ $element->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="flex-control">
              <input type="text" name="date_from" class="form-control" placeholder="Date From" value="{{ request('date_from') }}" id="date-from" autocomplete="off">
            </div>
            <div class="flex-control">
              <input type="text" name="date_to" class="form-control" placeholder="Date To" value="{{ request('date_to') }}" id="date-to" autocomplete="off">
              <button type="submit" class="btn btn-search">Search</button>
            </div>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-md-12">
          @if (count($record) > 0)
            @foreach ($record as $element)
              @php
                $dept_name = "";
                if($element->user_type == "admin"){
                  $dept_name = "admin";
                }elseif($element->user_type == "national"){
                  $dept_name = "pakistan";
                }elseif($element->user_type == "province"){
                  $dept_name = get_DeptName($element->province,'province');
                }
              @endphp
              <div class="outer-col">
                <div class="item-list row">
                  <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                    <div class="d-flex">
                      <div class="item-image">
                        <a href="{{ route('download')."?file=".$element->file }}" target="_blank">
                          @php
                            if(!empty($element->pdf_img)){
                              if(file_exists('downloads/'.$element->pdf_img)){
                                $pdf_img_path = asset('downloads/'.$element->pdf_img);
                              }else{
                                $pdf_img_path = asset('images/default-img.png');
                              }
                            }else{
                              $pdf_img_path = asset('images/default-img.png');
                            }
                          @endphp
                          <img src="{{ (!empty($element->mannual_image))?is_image($element->mannual_image):$pdf_img_path }}" class="img-fluid" alt="item-image">
                        </a>
                      </div>
                      <div class="item-col">
                        <h4><a href="{{ route('download')."?file=".$element->file }}" target="_blank">{{ $element->title }}</a></h4>
                        <p>{{ $element->description }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="item-col margin-md-col cabinet-col">
                          @if (!empty(trim($dept_name)))
                            @php
                              if(strtolower($dept_name) == "punjab"){
                                $_class = "badge-success";
                              }elseif(strtolower($dept_name) == "sindh"){
                                $_class = "badge-warning";
                              }elseif(strtolower($dept_name) == "blochistan"){
                                $_class = "badge-info";
                              }elseif(strtolower($dept_name) == "kpk"){
                                $_class = "badge-warning";
                              }else{
                                $_class = "badge-light";
                              }
                            @endphp
                            @if ($dept_name != "admin")
                              <h4>Govt. of</h4>
                              <span class="badge {{ $_class }}">{{ $dept_name }}</span>
                            @endif
                          @endif
                        </div>
                        <div class="item-col file-col text-center">
                          @if (!empty($element->size))
                            <h4>File Size</h4>
                            <p>{{ $element->size }}</p>
                          {{-- expr --}}
                          @endif
                        </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="d-flex align-items-center justify-content-between">
                      @if (!empty($element->date))
                        <div class="item-col margin-md-col text-center">
                          <h4>Date</h4>
                          <p>{{ date('d M, Y' , strtotime($element->date)) }}</p>
                        </div>
                      @endif
                      <div class="item-col">
                        <a href="{{ route('download')."?file=".$element->file }}" target="_blank" class="btn-download">Download</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="outer-col">
              <div class="item-list row">
                <div class="col-12 text-center">
                  <p>There is record</p>
                </div>
              </div>
            </div>

          @endif
        </div>
        
        <div class="col-md-12">
          {{-- {{ $record->links('login.layouts.pagination') }} --}}
        </div>
      </div>
    </div>
  </main>
</div>
     @php
      $res = DB::table("meta")->select("views")->where("page_name" , "notifications")->first();
      $views = $res->views;
      refresh_views($views , 0 , 0 , "notifications" );
     @endphp
@include('front.layout.footer')
<script src="{{ asset('assets/js/chosen.js') }}"></script>
<script src="{{ asset('assets/plugins/PhoneFormat/dist/jquery.samask-masker.js') }}"></script>
<script>
  var base_url = '{{ route('base_url') }}/downloads/';
  $('#date-to').samask("00/00/0000");
  $('#date-from').samask("00/00/0000");
  $("input[name='date_to']").datepicker({
      format:'dd/mm/yyyy',
      autoHide:true,
  });
  $("input[name='date_from']").datepicker({
      format:'dd/mm/yyyy',
      autoHide:true,
  });
  $('#date-to , #date-from').change(function(e){
    var new_val = $(this).val();
    var new_val = new_val.replace(/(\d{2})(\d{2})(\d{4})/, "$1/$2/$3");
    $(this).val(new_val);
  });
  $(".chosen-select").chosen({width: "100%"});
</script>
</body>
</html>