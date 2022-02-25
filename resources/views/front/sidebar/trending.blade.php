<!-- recent posts -->
@php
$blogs = \App\Models\Blogs::where('status' , 'publish')->orderBy('views', 'desc')->take(4)->get();
@endphp
@if (count($blogs) > 0)
<div class="sidebar-item">
	<ul class="recent-post">
		<li class="side-head"><h3 class="rounded-top">Recent Post</h3></li>
		@foreach ($blogs as $v)
		@php
			$title = unslash( $v->title );
			$short_title = ( strlen( $title ) > 60 ) ? substr( $title, 0, 160 ) . "...": $title;
			$content = trim(trim_words( html_entity_decode($v->content), 35 ));
			$content = clean_short_code(html_entity_decode($content));
			$image = $v->cover;
			$date = date("d M Y", strtotime($v->date) );
			$url = route('base_url')."/".$v->slug."-3".$v->id;
		@endphp
		<li class="row">
			<a href="{{ $url }}" class="col-3 col-md-2 col-lg-5 post-image">
				<img src="{{ get_post_thumbnail($image) }}" class="img-fluid" alt="{{$short_title}}">
			</a>
			<div class="col-9 col-md-10 col-lg-7 post-detail">
				<a href="{{ $url }}" class="post-title">{{ $title }}</a>
				<span>{{ $date }}</span>
			</div>
		</li>
		@endforeach
	</ul>
</div>
@endif	