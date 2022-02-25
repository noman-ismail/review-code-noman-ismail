@include('admin.layout.header')
<div class="body-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Footer Data </h6>
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
          <form method="POST" action="/{{ admin }}/footer" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-6">
                @php
                $m_data = json_decode($data->footer);
                @endphp
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <div class="form-group col-md-12 p-0">
                    <label class="font-weight-600">Address:</label>
                    <div class="input-group">
                      <textarea class="form-control" name="address" rows="2">{{ isset($m_data)?$m_data->address:''}}</textarea>
                    </div>
                  </div>
                   <div class="form-group col-md-12 p-0">
                    <label class="font-weight-600">Email</label>
                    <div class="input-group">
                      <textarea class="form-control" name="email" rows="2">{{ isset($m_data)?$m_data->email:''}}</textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12 p-0">
                    <label class="font-weight-600">Office Time</label>
                    <div class="input-group">
                      <textarea class="form-control" name="office_time" rows="2">{{ isset($m_data)?$m_data->office_time:''}}</textarea>
                    </div>
                  </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group col-md-12 p-0">
                    <label class="font-weight-600">Copyright Text</label>
                    <div class="input-group">
                      <input type="text" class="form-control tcount" placeholder="All Rights Reserved By:" name="copyrights" value="{{ isset($m_data)?$m_data->copyrights:''}}" data-count="text">
                    </div>
                  </div>
                   <div class="form-group col-md-12 p-0">
                    <label class="font-weight-600">Phone Number</label>
                    <div class="input-group">
                      <input type="text" class="form-control tcount" placeholder="+92-343-123-4786" name="phone" value="{{ isset($m_data)?$m_data->phone:''}}" data-count="text">
                    </div>
                  </div>
              </div>
              <div class="col-lg-12">
                @php
                  $social_links = ($data->social_links !="" )? json_decode($data->social_links , true) : array();
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
              <div class="col-lg-12">
                <br> <br>
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
  $( ".add-social" ).click( function () {
    var html_obj = $( ".social tr" ).first().clone();
    var ln = $( ".social tr" ).length;
    $( html_obj ).find( "input" ).each( function () {
      $( this ).attr( "value", "" );
    } );
    $( html_obj ).find( "textarea" ).each( function () {
      $( this ).text( "" );
    } );
    html_obj.find( "td:first-child" ).text( parseInt( ln ) + 1 );
    $( ".socialmedia .social" ).append( "<tr>" + html_obj.html() + "</tr>" );
    return false;
  } );
  $( document ).on( "click", ".clear-item", function () {
    var v = window.confirm( "Do you want to delete data?" );
    if ( v ) {
      $( this ).closest( "tr" ).remove();
    }
  } );
</script>