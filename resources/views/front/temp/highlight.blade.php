@if (count($data) > 0)
    <div class="pink-box">
        <h3 class="text-center">Highlights
            <span class="decor-line">
                <em class="star">
                    <i class="icon-star-full"></i>
                </em>
            </span>
        </h3>
        <div class="row">
            @foreach ($data as $key => $value)
                <a class="col-sm-6 col-md-4" href="{{ route('base_url')."/".$value->slug."-2".$value->id }}">
                    <div class="higlight-column">
                        <img src="{{ is_image($value->cover_image) }}" class="img-fluid" alt="{{ $value->title }}">
                        <div class="hvr-highlight">
                            <i class="icon-link"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@else
    <p></p>
@endif
