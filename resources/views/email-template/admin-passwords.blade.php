@include("email-template.temp.header")
<main style="padding:10px;">
	<h2 style="font-size:25px;font-weight:500;color:#333;text-align:center">Admin Password Reset Notification </h2>
	<p style="max-width:400px; margin:20px auto 20px auto; line-height:25px;">Your Admin credentials have been changed. <br>
	</p>
	<p style="max-width:400px; margin:20px auto 20px auto; line-height:25px;">
		<strong>Admin Slug:</strong> {{$admin_slug}}
		<br>
		<strong>Admin Username:</strong> {{$username}}
		<br>
		<strong>Admin Password:</strong> {{$password}}
		<br>
		<strong>Security Image:</strong> {{$s_img}}
	</p>
	<p style="max-width:400px; margin:20px auto 20px auto; line-height:25px;"><a href="{{route('base_url')}}/{{$admin_slug}}" target="_blank" style="display:inline-block;background-color:#000;padding:7px 16px;color:#fff;font-size:18px;font-weight:bold;text-decoration:none;">Admin Link</a></p>
</main>
@include("email-template.temp.footer")