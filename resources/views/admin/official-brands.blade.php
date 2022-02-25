@include('admin.layout.header')
@php

  if(!empty(old())){
    $url = old('url');
    $cover_img = old('cover_img');
  }elseif(isset($get_data) and !empty($get_data)){
    $url = $get_data->url;
    $cover_img = $get_data->image;
  }else{
    $url = $cover_img = "" ;
  }
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Official Brands</h6>
            </div>
             <div class="text-right">
            <a href="{{ route('official-brands') }}" class="btn btn-sm btn-info">Add New</a>
          </div>
          </div>
        </div>
        <div class="card-body">
           @if(session()->has("success"))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session("success") !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
          @if(session()->has("error"))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {!! session("error") !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif  

          <form action="{{ (isset($get_data) and !empty($get_data))?route('official-brands')."?id=".request('id'):route('official-brands') }}" method="post">
            @csrf
            <div class="form-group">
              <label class="req">URL</label>
              <input type="text" name="url" value="{{ $url }}" class="form-control">
               @if(count($errors) > 0)
                  @foreach($errors->get('url') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
            </div>
            <div class="card mt-3 col-md-12">
              <div class="card-header bg-secondary text-white">Brand Image <span class="font-weight-lighter">(300 x 340)</span></div>
                @if(count($errors) > 0)
                    @foreach($errors->get('image') as $error)
                      <div class="text-danger">{{ $error }}</div>
                    @endforeach 
                  @endif
              <div class="card-body">
                <div class="uc-image">
                  <input type="hidden" name="cover_img" value="{{ $cover_img}}">
                  <div id="cover_img" class="image_display" style="background-color: #17a2b8;">
                    @if ($cover_img!= "")
                    <img src="{{ $cover_img}}" alt="Cover Image">
                    @endif
                  </div>
                  <div style="margin-top:10px;">
                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#cover_img" data-link="cover_img">Add Image</a>
                  </div>
                </div>
              </div>
            </div>

            <br> <br>
            <div class="form-group">
              <input type="submit" name="save" value="{{ (isset($get_data) and !empty($get_data))?"update":"submit" }}"  class="btn btn-info float-right">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0"> List </h6>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped table-hover bg-white m-0 card-table">
                <thead>
                  <tr>
                    <td><strong>#</strong></td>
                    <td><strong>Image</strong></td>
                    <td><strong>Url</strong></td>
                    <td><strong>Action</strong></td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($brands as $k => $key)
                  <tr>
                    <td>{{$key->id}}</td>
                    <td style="width: 20%;background-color: #17a2b8;"><div><img src="{{$key->image}}" alt=""></div></td>
                    <td> {{$key->url}}   </td>
                    <td>
                      <a href="{{route('official-brands')."?id=".$key->id}}" class="-soft  mr-1 fa fa-edit" title="Edit"></a>
                      <a href="{{route('official-brands')."?del=".$key->id}}" class="btn-danger-soft  fa fa-trash sconfirm" title="Delete"></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')