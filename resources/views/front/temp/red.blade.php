@if (count($data) > 0)
<blockquote class="red-note">  
	@if ($data['red_body'] !="")
         {!! $data['red_body'] !!}
    @endif
</blockquote>
@endif