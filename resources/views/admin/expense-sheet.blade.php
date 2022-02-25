@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
@endphp
@if($__userType == 'district')
  @include('admin.district.layouts.header')
@elseif($__userType == 'province')
  @include('admin.province.layouts.header')
@elseif($__userType == 'national')
  @include('admin.national.layouts.header')
@endif

<div class="body-content">
  <div class="card border-info">
      <div class="card-header bg-info text-white">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fs-17 font-weight-600 mb-0">Expense Sheet </h6>
          </div>
          <div class="text-right">
            <button class="btn btn-success btn-sm md-trigger search-modal" data-modal="modal-2">Search</button>
            <a href="{{ route('expense-sheet') }}" class="btn btn-sm btn-secondary">Expense Sheet</a>
            <a href="{{ route('add-expense') }}" class="btn btn-sm btn-success">Add New</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
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
            <div class="_msgtop"></div>
          </div>
          <div class="col-md-12">
            <table class="table">
              <thead class="bg-info text-white">
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Amount</th>
                  <th>Entry Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="text-dark">
              @if(count($record) > 0)
                @php
                  $i=1;
                @endphp
                @foreach($record as $value)
                  <tr class="" >
                    <td>{{ $i++ }}</td>
                    <td>{{ $value->title }}</td>
                    <td>{{ $value->amount }}</td>
                    <td>{{ ($value->entry_date != null)?date('d/m/Y',strtotime($value->entry_date)):"" }}</td>
                    <td>
                      <a href="{{ route('add-expense').'?id='.$value->id }}"><i class="fa fa-edit"></i></a>
                      <a href="{{ route('add-expense').'?del='.$value->id }}" onclick="return confirm('Are You Sure?');">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr class="text-center bg-default">
                  <td colspan="5">There is no record</td>
                </tr>
              @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>

<!-- Modal slide in (right) effects -->
<div class="md-modal md-effect-2" id="modal-2">
    <div class="md-content">
      <h4 class="font-weight-600 mb-0">Search Data</h4>
      <div class="n-modal-body">
        <div class="row">
          <div class="col-md-12">
            <span></span>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Search by Title</label>
              <input type="text" name="search_title" class="form-control search_title">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Date From</label>
              <input type="text" name="date_from" class="form-control date_from" data-toggle="datepicker" id="date-picker" autocomplete="off">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Date To</label>
              <input type="text" name="date_to" class="form-control date_to" data-toggle="datepicker" id="date-picker1" autocomplete="off">
            </div>
          </div>
          <div class="col-md-4">&nbsp;</div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-6">
                <button class="btn btn-primary search_btn">Search</button>
              </div>
              <div class="col-md-6">
                <button class="btn btn-success md-close">Close</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">&nbsp;</div>
        </div>
      </div>
    </div>
</div>
<button class="btn btn-info btn-sm md-trigger modal-11" data-modal="modal-11" style="display: none">Reslt</button>
<div class="md-modal md-effect-11" id="modal-11">
    <div class="md-content">
        <h4 class="font-weight-600 mb-0">Result</h4>
        <div class="n-modal-body">
          <button class="btn btn-success md-close">Close</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div>
  <link rel="stylesheet" href="{{ asset('admin-assets/plugins/modals/component.css') }}">
  <script src="{{ asset('admin-assets/plugins/modals/classie.js') }}"></script>
  <script src="{{ asset('admin-assets/plugins/modals/modalEffects.js') }}"></script>
  <script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
  <script src="{{ asset('admin-assets/dist/js/jquery.samask-masker.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $('.search-modal').click(function(){
      $('.search_title').val('');
      $('.date_from').val('');
      $('.date_to').val('');
      $('[data-toggle="datepicker"]').datepicker({
          format:'dd/mm/yyyy',
          zIndex:'9999',
          autoHide:true,
      });
      $('.form-control-chosen').chosen();
      $('#date-picker').samask("00/00/0000");
      $('#date-picker1').samask("00/00/0000");
      
      $('#date-picker').keydown(function(e){
          if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
            return true; 
          }  else {
            return false;
          } 
      });
      $('#date-picker1').keydown(function(e){
          if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
            return true; 
          }  else {
            return false;
          } 
      });
    })
    $('.search_btn').click(function(){
      $('#modal-11').find('.n-modal-body').html('');
      $(this).closest('.md-show').removeClass('md-show');
      var title = $('.search_title').val().trim();
      var date_from = $('.date_from').val().trim();
      var date_to = $('.date_to').val().trim();
      if(title == '' && date_from == '' && date_to == ''){
        location.reload();
      }else{
        var url = "{{ route('remaining-budget') }}";
        $.ajax({
          url:url,
          method:'POST',
          dataType:'html',
          data:{
            action:'search-expense',
            title:title,
            date_from:date_from,
            date_to:date_to,
            _token:_token,
          }, success:function(res){
            var t = $('#modal-11').find('.n-modal-body');
            t.html(res);
            t.append('<button class="btn btn-success md-close">Close</button>');
            $('.modal-11').trigger('click');
            $('.md-close').click(function(){
              $(this).closest('.md-show').removeClass('md-show');
            })
          }, error:function(e){
            alert('Error to get expense. Refresh page and try again');
          }
        })
      }
    });
  })
</script>
@if($__userType == 'district')
  @include('admin.district.layouts.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@endif