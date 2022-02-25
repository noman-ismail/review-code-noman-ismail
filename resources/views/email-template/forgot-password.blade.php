@include("email-template.temp.header")
<main style="padding:10px;">
	<p style="text-align: left;max-width:400px; padding: 5px; margin:20px auto 20px auto; line-height:25px;">
		{!! nl2br($body) !!}
	</p>
</main>
@include("email-template.temp.footer")