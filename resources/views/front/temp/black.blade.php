
@if (count($data) > 0)
<blockquote class="dark-note">  
	@if ($data['black_body'] !="")
         {!! $data['black_body'] !!}
    @endif
</blockquote>
@endif