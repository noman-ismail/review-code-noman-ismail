@include("email-template.temp.header")
<main style="padding:10px;">
	<p style="text-align: left;max-width:400px; padding: 5px; margin:20px auto 20px auto; line-height:25px;">
		{!! nl2br($body) !!}
	</p>
	<ul style="text-align: left; list-style: none;">
	    <li style="margin-bottom: 1px;"><b>Name:</b> {{ $name }}</li>
	    <li style="margin-bottom: 1px;"><b>Contact:</b> {{ $contact }}</li>
	    <li style="margin-bottom: 1px;"><b>From: {{ $email }}</b></li>
	    <li style="margin-bottom: 1px;"><b>City: {{ $city }}</b></li>
	</ul>
</main>
@include("email-template.temp.footer")