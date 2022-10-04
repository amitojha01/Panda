<DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<title>Email Verification</title>
</head>
    <body>
        <div style="text-align: center; width: 600px; margin: 0 auto; background: #000;">
            <a href="{{ url('/') }}" style="display: block; text-align: center; margin:30px auto;">
                <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="" srcset="">
              </a>
        </div>
        <h2 style="text-align: center; background: #5cb85c; padding:30px 0; color: #fff">Hi, {{ $data['email'] }}</h2>
        <p style="padding:15px 0 0 0; font-size: 20spx; font-weight:600; text-align: center; font-size:16px;">
            Dear user, your one time email verification code is : {{ $data['otp']}}
        </p>
        <p style="padding:15px 0 0 0; font-size: 20spx; text-align: center; font-size:16px;">
            Please verify your OTP to complete this step.
        </p>
        <h5 style="padding:30px 0; text-align: center; background: #5cb85c; color: #fff">Thank you. {{ env('SITE_TITLE') }}.</h5>
    </div>
    </body>
</html>