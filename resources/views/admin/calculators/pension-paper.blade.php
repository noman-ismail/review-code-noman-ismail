@include('admin.layout.header')
{{ full_editor() }}
<div class="body-content">
  <div class="card">
      <div class="card-header bg-success text-white">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fs-17 font-weight-600 mb-0 text-white">Pension Paper</h6>
          </div>
          <div class="text-right">
            <div class="actions">
              <a href="{{ route('pension-paper-meta') }}" class="btn btn-sm btn-info float-right">Pension Paper Meta</a>
              <a href="{{ route('pension-paper') }}" class="btn btn-sm btn-secondary float-right mr-2">Pension Paper</a>
            </div>
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
        </div>
      </div>
      <form action="{{ route('pension-paper') }}" method="post">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Description</label>
              <textarea name="description" class="form-control oneditor" rows="15">{!! $data->content !!}</textarea>
            </div>
          </div>
          <div class="col-md-12 text-right">
            <button class="btn btn-primary">
              Submit
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@include('admin.layout.footer')