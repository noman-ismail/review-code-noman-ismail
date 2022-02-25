@include("email-template.temp.header")
<div>
	<p style="font-size:18px;">
	<strong>{{$name}}</strong>  asked a question to you...
	</p>
	<div style="font-size:16px;">
	" {!!nl2br($content)!!} "
	</div>
</div>
@include("email-template.temp.footer")