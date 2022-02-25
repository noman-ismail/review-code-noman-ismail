@include('admin.layout.header')
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-10">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">General Settings</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <!-- <a href="#" class="action-item"><i class="ti-reload"></i></a>
                <a href="#" class="action-item"><i class="ti-reload"></i></a>
                <div class="dropdown action-item" data-toggle="dropdown">
                  <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item">Refresh</a>
                    <a href="#" class="dropdown-item">Manage Widgets</a>
                    <a href="#" class="dropdown-item">Settings</a>
                  </div>
                </div> -->
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
          <form method="POST" action="/<?= admin ?>/general-setting" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <input type="hidden" name="id" value="{{$settings->id}}" >
            <div class="form-row">
              <div class="form-group col-lg-3 col-md-3 logo-img">
                <label class="font-weight-600">Logo Image: </label>
                <div class="uc-image" style="width: 97%;">
                  <input type="hidden" name="logo" value="{{$settings->logo}}">
                  <div id="logo" class="image_display">
                    <img src="{{$settings->logo}}" alt="">
                  </div>
                  <div style="margin-top:10px;">
                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#logo" data-link="logo">Add Image</a>
                  </div>
                </div>
              </div>
              
              <div class="form-group col-lg-3 col-md-3 logo-img">
                <label class="font-weight-600"> Favicon: </label>
                <div class="uc-image" style="width: 97%;">
                  <input type="hidden" name="favicon" value="{{$settings->favicon}}">
                  <div id="favicon" class="image_display">
                    <img src="{{$settings->favicon}}" alt="">
                  </div>
                  <div style="margin-top:10px;">
                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#favicon" data-link="favicon">Add Image</a>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-3 col-md-3 logo-img">
                <label class="font-weight-600">OG Image: </label>
                <div class="uc-image" style="width: 97%;">
                  <input type="hidden" name="og" value="{{$settings->og}}">
                  <div id="og" class="image_display">
                    <img src="{{$settings->og}}" alt="">
                  </div>
                  <div style="margin-top:10px;">
                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#og" data-link="og">Add Image</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group col-md-9">
              <label>Google Analytics:</span></label>
              <textarea id="m"  name="google_analytics" rows="3" class="form-control" placeholder="Google Analytics">{{$settings->google_analytics?$settings->google_analytics:''}}</textarea>
            </div>
            <!-- webnmaster tool-->
            <div class="form-group col-md-9">
              <label>Google Web Master Tools Meta Tags:</label>
              <textarea id="m" name="web_master" rows="3" class="form-control" placeholder="Web Master Tools Meta Tags">{{$settings->web_master?$settings->web_master:''}}</textarea>
            </div>
            <div class="form-group col-md-9">
              <label>Bing Master Tools Meta Tags:</label>
              <textarea id="m" name="bing_master" rows="3" class="form-control" placeholder="Bing Master Tools Meta Tags">{{$settings->bing_master?$settings->bing_master:''}}</textarea>
            </div>
            
            <div class="form-group col-md-9">
              <button type="submit" class="btn btn-info float-right">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="shortcode-model" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <h1><b>Step 1</b></h1>
        <p>In addition to using the Messenger Profile API, Page admins may also update their domain whitelist in Page settings by doing the following:</p>
        <ol>
          <li>Click <b>Settings</b> at the top of your Facebook Page</li>
          <li>Click <b>Advance Messaging </b> on the left</li>
          <li>Edit whitelisted domains for your page in the <b>Whitelisted Domains </b> section <br>
            <img src="{{ route('base_url')."/images/whishlisted-domain.png" }}" alt="" class="img-thumbnail">
          </li>
        </ol>
        <h1><b>Step 2</b></h1>
        <h4>find your Page ID:</h2>
        <ol>
          <li>From News Feed, click Pages in the left side menu.</li>
          <li>Click your Page name to go to your Page.</li>
          <li>Click About in the left column.</li>
          <li>Scroll down to find your Page ID below More Info.</li>
          <li>Put your page id in below input field</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')