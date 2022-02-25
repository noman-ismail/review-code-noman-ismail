@php
  $cats = DB::table("blogcats")->orderBy("tb_order")->get();
@endphp
@if (isset($cats))
@if (count($cats) > 0)
<div class="sidebar-item">
	<ul class="categories">
		<li class="side-head"><h3 class="rounded-top">Categories</h3></li>
		@foreach ($cats as $k => $v)
        @php
        $id = $v->id;
        $slug = $v->slug;
        $title = $v->title;
        $url  = route('base_url')."/".$slug."-4".$id;
        @endphp
        <li class="nav-item">
            <i></i><a href="{{ $url }}">{{ $title }} </a> <span>{{ _getCatPostCount($id) }}</span></li>
        @endforeach
	</ul>
</div>
@endif
@endif