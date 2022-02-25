<html lang="en">
@php
	extract($data);
@endphp
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
	</head>
	<body style=" background:#ddd;padding:2%;font-family: Verdana, Geneva, Tahoma, sans-serif;">
		<div style="max-width:600px;background:#fff;border-radius:20px;margin:0 auto;text-align:center;overflow:hidden;">
			<h4 style="font-size: 18px;">Welcome Dear {{ $name }}</h4>
			<hr/>
			<p style="padding: 0px 20px;">We have sent you PDF attachment that you generate from our "Pension Calculator" App</p>
			<p style="padding: 0px 20px;">Please visit the below link if you want to download our Android App</p>
				<a href="https://play.google.com/store/apps/details?id=com.dgaps.android.pensioncalculator&hl=en" target="_blank"><img src="https://engrabbas.com/images/playstore.png" alt="" style="text-align: center; width: 50%;"></a>
			<p style="padding: 0px 20px;"><b>Thanks</b> for connecting with us</p>
			<hr/>
			<footer style="margin:0 auto">
				<h4 style="padding: 0px 20px;"><span style="font-size:14px;font-weight:normal;color:black">Powered By:</span>
				<a href="https://engrabbas.com" target="_blank" style="color:#d6352d;">Engr Ghulam Abbas</a> , CEO <a href="https://dgaps.com" target="_blank" style="color:#d6352d;">Digital Applications</a></h4>
				<h4 style="padding: 0px 20px;"><span style="font-size:14px;font-weight:normal;color:black">Gifted By:</span>
				<a href="" style="color:#d6352d;">Abdul Munaf Bhatti</a> , Punjab Chairman <a href="http://apjea.com" target="_blank" style="color:#d6352d;">APJEA</a></h4>
			</footer>
		</div>
	</body>
</html>