@if (count($data) > 0)
<blockquote class="green-note">  
	@if ($data['gr_body'] !="")
         {!! $data['gr_body'] !!}
    @endif
</blockquote>
@endif