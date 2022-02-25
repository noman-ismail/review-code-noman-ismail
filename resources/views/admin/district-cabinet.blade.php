@include('admin.layout.header')
{{ full_editor() }}
<div class="body-content">
  <div class="card border-info">
      <div class="card-header bg-info text-white">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fs-17 font-weight-600 mb-0 text-white">District Cabinet</h6>
          </div>
          <div class="text-right">
            <div class="actions">
            </div>
          </div>
        </div>
      </div>
      @php
        $record = (!empty($data)) ? json_decode($data->district_cabinet) : array();
      @endphp
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
      <form action="{{ route('district-cabinet-setting') }}" method="post">
        @csrf
        <div class="row">
          <div class="form-group col-md-12 p-0">
              <label class="font-weight-600">Meta Title</label>
              <div class="input-group">
                  <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ (!empty($record))?$record->meta_title:''}}" data-count="text">
                  <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ (!empty($record))?strlen($record->meta_title):'0'}}</span>
                  </div>
              </div>
          </div>
          <div class="form-group col-md-12 p-0">
              <label class="font-weight-600">Meta Description</label>
              <div class="input-group">
                  <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ (!empty($record))?$record->meta_description:''}}</textarea>
                  <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ (!empty($record))?strlen($record->meta_description):'0'}}</span>
                  </div>
              </div>
          </div>
          <div class="form-group col-md-12 p-0">
              <label class="font-weight-600">Meta Tags</label>
              <div class="input-group">
                  <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ (!empty($record))?$record->meta_tags:''}}">
                  <div class="input-group-append">
                      <span class="input-group-text count countshow">{{ (!empty($record))?count(explode(",",$record->meta_tags)):'0'}}</span>
                  </div>
              </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Content</label>
              <textarea name="content" class="form-control oneditor" rows="15">{!! (!empty($record))?$record->content:"" !!}</textarea>
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