<h5 class="text-center">This Query will be send to</h5>
<div class="contact-item row">
  @if (!empty($province_record) and !empty($province_record->address))
    <div class="contact-icon  col-2 col-sm-2 col-md-2 col-lg-3">
      <i class="icon-location"></i>
    </div>
    <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
      <h3>{{ (!empty($province_record->address_title)) ? $province_record->address_title : "" }}</h3>
      <p>{{ $province_record->address }}</p>
    </div>
  @endif
</div>
<div class="contact-item row">
  @if (!empty($province_record) and !empty($province_record->phone))
    <div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-3">
      <i class="icon-phone"></i>
    </div>
    <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
        <h3>{{ $province_record->phone_title }}</h3>
        <p>{!! nl2br($province_record->phone) !!}</p>
    </div>
  @endif
</div>
<div class="contact-item row">
  @if (!empty($province_record) and !empty($province_record->email))
    <div class="contact-icon col-2 col-sm-2 col-md-2 col-lg-3">
      <i class="icon-envelope"></i>
    </div>
    <div class="contact-detail col-10 col-sm-10 col-md-10 col-lg-9">
        <h3>{{ $province_record->email_title }}</h3>
        <p>{!! nl2br($province_record->email) !!}</p>
    </div>
  @endif
</div>