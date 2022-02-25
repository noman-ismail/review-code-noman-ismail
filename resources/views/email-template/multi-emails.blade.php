@include("email-template.temp.header")
<main style="padding:10px;">
	<h2 style="font-size:25px;font-weight:500;color:#333;text-align:center">{{$subject}}</h2>
	<p style="max-width:400px; margin:20px auto 20px auto; line-height:25px;">
		{!!nl2br($content)!!}
	</p>
</main>
@include("email-template.temp.footer")