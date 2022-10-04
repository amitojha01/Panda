<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot Password OTP mail</title>
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
   <div style="width: 500px; margin: 0 auto; background: #fff; padding: 30px 0 0 0; border: #000 solid 1px; border-radius:0px;">
   	<table cellpadding="0" cellspacing="0" width="100%">
   		<tr>
   			<td align="center" style="padding-bottom: 50px;">
				<img src="{{ asset('public/frontend/images/logo.png') }}"/>
			</td>
   		</tr>
   		<tr style="background:#FFD500;">
   			<td style="font-family: 'Poppins', sans-serif; padding: 50px 0 15px 0; font-weight: 600; font-size: 16px; text-align: center;">
				Thanks For Joining {{ env('SITE_TITLE')}}
			</td>
   		</tr>   		
   		<tr style="background:#FFD500;">
   			<td style="padding: 0px 0 50px 0; text-align: center;">
   				<p style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 14px; padding: 0 0 15px 0; margin: 0;">
                   Hi, {{ $data['email'] }}</p
   				<p style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 14px; padding: 0 0 15px 0; margin: 0;">
   					Your one time forgot password OTP is : <strong>{{$data['otp']}}</strong>
   				</p>
   			</td>
   		</tr>
   		<tr style="background: #000;">
   			<td style="padding: 50px 0 50px 0; text-align: center">
  			<div style="clear:both;"></div>
   			</td>
   		</tr>
   	</table>
   </div>                                      
</body>
</html>
