
@if (count($data) > 0)
@php
  $n =rand(0,35);
@endphp
<div  id="sectionThree">
    <div class="section-child">
        <h3 class="text-success faqs-head">Frequently Asked Questions</h3>
        <div class="row" id="faqs-row">
            <div class="col-md-12">
            @foreach ($data as $k =>  $v)
            @php
              $num = $k+1 . ".";
              $visible = ($k==0) ? "visible" : "" ;
              $icon = ($k==0) ? "icon-chevron-up" : "icon-chevron-down" ;
            @endphp
                <div class="ex-faqs-item {{ $visible }}">
                    <div class="ex-faqs-header">
                        <h3>
                        <span class="faqs-no">{{ $num }}</span>
                        <span class="faqs-text">{{ $v['question'] }}</span>
                        <span class="faqs-icon"><i class="{{ $icon }}"></i>
                        </span>
                        </h3>
                    </div>
                    <div class="ex-faqs-body">
                       {!! $v['answer'] !!}
                    </div>
                </div>
             @endforeach   
            </div>
        </div>
    </div>
</div>
@endif