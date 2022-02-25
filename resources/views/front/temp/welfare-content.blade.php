<div class="row colored-row mr-0">
  @isset ($data->black_text)
  <div class="col-lg-12 col-xl-6 first-column pr-0">
    <div class="intro-box bg-dark box-1">
     {!! $data->black_text !!}
    </div>
  </div>
  @endisset
  @php
    $green = (isset($data->green_text))? json_decode($data->green_text , true) : array();
  @endphp
  @if (count($green) > 0)
  <div class="col-lg-12 col-xl-6 second-column pl-0 pr-15">
    <div class="intro-box-two bg-green">
      @foreach ($green as $k => $v)
      <div class="small-box">
        <div class="row">
          <div class="col-3 col-sm-2 icon">
            {!! $v['gr_icon'] !!}
          </div>
           <h4 class="col-9 col-sm-10 small-head">{{ $v['gr_heading'] }}</h4>             
        </div>
        {!! $v['gr_body'] !!}
      </div>
      @endforeach
    </div>
  </div>
  @endif
</div>