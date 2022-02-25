@include("admin.layout.header")
<div class="body-content">
  <div class="card mb-4 border-info">
    <div class="card-header bg-info text-white">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="fs-17 font-weight-600 mb-0">Province List</h6>
        </div>
        <div class="text-right">
        </div>
      </div>
    </div>
    <form action="{{ (isset($get_data) and !empty($get_data))?route('province').'?id='.request('id'):route('province') }}" method="POST">
    @csrf
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          @if(session()->has("error"))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {!! session("error") !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
        </div>
        <div class="col-md-5">
          <fieldset>
            <legend>Add New Province</legend>
            @if(session()->has("success"))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session("success") !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            <div class="form-group">
              @php
                if (old('name')) {
                  $name = old('name');
                }elseif(isset($get_data) and !empty($get_data)){
                  $name = $get_data->name;
                }else{
                  $name = "";
                }
              @endphp
              <label for="" class="font-weight-600">Province Name <span class="required">*</span></label>
              <input type="text" name="name" class="form-control" value="{{ $name }}" placeholder="Enter Province Name"> 
                @if(count($errors) > 0)
                  @foreach($errors->get('name') as $error)
                    <div class="text-danger">{{ $error }}</div>
                  @endforeach 
                @endif
            </div>
            <button class="btn btn-success" name="{{ (isset($get_data) and !empty($get_data))?'edit':'add' }}">Submit</button>
          </fieldset>
        </div>
        <div class="col-md-7">
          <table class="table table-striped">
            <thead class="bg-info text-white">
              <tr>
                <th>Sr. No</th>
                <th>Province Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="sort">
            @if(count($record) > 0)
              @php $i = 0; @endphp
              @foreach($record as $value)
                <tr data-index = '{{ $value->id }}' data-position='{{ $value->sort }}' class="sort-tr">
                  <td>{{ ++$i }}</td>
                  <td>{{ $value->name }}</td>
                  <td>
                    <a href="{{ route('province').'?id='.$value->id }}"><i class="fa fa-edit"></i></a>
                    {{-- <a href="{{ route('province').'?del='.$value->id }}" onclick="return confirm('Are You Sure?');"><i class="fa fa-trash"></i></a> --}}
                  </td>
                </tr>
              @endforeach
            @else
              <tr class="text-center bg-info">
                <td colspan="3">There is no record</td>
              </tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </form>
  </div>
  </div><!--/.body content-->
  <script>
      $( "#sort" ).sortable({
        update:function(event,ui){
          $(this).children().each(function (index){
            if ($(this).attr('data-position')!= (index+1)) {
              $(this).attr('data-position',(index+1)).addClass('updated');
            }
          });
          var url = base_url+admin+"/positions";
          savenewposition(url,'province');
        }
      });
  </script>
@include("admin.layout.footer")