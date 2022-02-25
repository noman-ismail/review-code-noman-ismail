@include('admin.layout.header')
@php
$pages = array(
  "1" => "Trending Post",
  "2" => "Blog Category",

);
$page_name = (isset($_GET['pg'])) ? $_GET['pg'] : "";
$page =  str_replace("-", ' ', $page_name);
$ads =  DB::table("ads")->get();
if (count($ads) > 0) {
  $ads = json_decode($ads[0]->ads, true); 
}

$ads_ids = array();
foreach($ads as $k=>$v){
  $ads_ids[$v["ads_id"]] = $v;
}

$order = array();
$update = false;
$rec = DB::table("sidebar_settings")->where("page_name" , "=" , "$page_name")->get();
if($rec){
  if (!empty($rec[0]->data_order)){
    $order = explode(",",$rec[0]->data_order);
    $update = true;
  }
}
if ($page_name == "blog") {
    $page_name = "Blog Detail";
  }elseif($page_name == "blogs"){
    $page_name = "Blog List";
  }
@endphp

<div class="body-content">
  <div class="row">
    <div class="col-md-6 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0"><b>{{ $page_name }}</b> Sidebar Item</h6>
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
          <table class="table table-borderd"> 
                <tbody>
                  @php
                    foreach($pages as $k=>$v){
                      $sel = (in_array($k, $order)) ? "checked" : "";
                  @endphp
                  <tr>
                    <th>
                      {{ $k." - ".$v }}                      
                    </th>
                    <td><input type="checkbox" name="image" class="check_list" data-id="{{ $k }}" {{ $sel }}></td>              
                  </tr>
                  @php
                    }
                    foreach($ads as $k=>$v){
                      $kk  = $k+3;
                      $sel = (in_array($kk, $order)) ? "checked" : "";
                   @endphp
                  <tr>
                    <th>
                      {{ $kk." - ".$v["title"] }}
                    </th>
                    <td><input type="checkbox" name="image" class="check_list" data-id="{{ $kk }}" {{ $sel }}></td> 
                  </tr>
                  @php
                    }
                  @endphp
                </tbody>
              </table>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Order for <b>{{ $page_name }}</b></h6>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="/{{ admin }}/sorting" method="post">
            @csrf
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                @if (Session::has('sidebar_message'))
                <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>{!! Session('sidebar_message') !!}</strong>
                </div>
                @endif
              <div class="row">
                <form action="" method="post">
                    <div class="col-lg-12 col-sm-12">
                      <input type="hidden" name="page" value="{{ request('pg') }}">
                      <div class="form-group">
                        <ol class='m-t todo-list msortable'>
                          @php
                            foreach($order as $v){
                              if ($v > 2){
                                $ads = $ads_ids[$v-2];
                                $pg_name = $ads["title"];
                              }else{
                               $pg_name = (array_key_exists($v, $pages)) ? $pages[$v] : "";
                              }
                              if ($pg_name !="") {
                                echo "
                                  <li id='li$v'><b>$pg_name</b><input type='hidden' name='order[]' value='$v' class='form-control'/> <span class='menu-del float-right' data-id='x'>x</span>
                                  </li>
                                ";
                              }
                          
                          } 
                          @endphp
                        </ol>
                      </div>
                      <div class="form-group">
                        <input type="submit" name="submit" value="submit" class="btn btn-primary pull-right"/>
                      </div>
                    </div>
                  <br>
                </form>
              </div>
            </div>
          </div>
          <br>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<script>
      $(document).on("click" , ".check_list" , function(){
        var chk = $(this).is(":checked"); 
        var d = $(this).attr("data-id");
        if (chk){
            var v = $(this).closest("tr").find("th").text();
            var sp = v.split("-");
            var sn = sp[1];
            var li = "<li id='li"+d+"'><b>"+sn+"</b><input type='hidden' name='order[]' value='"+d+"' class='form-control'/><span class='menu-del float-right' data-id='"+d+"'>x</span></li>";
            $(".msortable").append(li);
        }else{
            $(".msortable #li"+d).remove();
        }
    });
     $( document ).ready( function () {
        $(".msortable" ).sortable();
    });
</script>
@include('admin.layout.footer')