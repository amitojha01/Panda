<DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
    <body>
        <!-- <div style="text-align: center; width: 600px; margin: 0 auto; background: #f4f4f4;"> -->
        <div style="text-align: center; width: 600px; margin: 0 auto; background: #f4f4f4;">
            <a href="{{ url('/') }}" style="display: block; text-align: center; margin:30px auto;">
                <!-- <img src="{{ asset('public/frontend/images/logo.png') }}" alt="" srcset=""> -->
                <img src="{{ asset('public/frontend/images/logo.png') }}" alt="" srcset="">
              </a>
        </div>
        <h2 style="text-align: center; background: #5cb85c; padding:30px 0; color: #fff">Password Reset</h2>
        <p style="padding:15px 0 0 0; font-size: 20spx; text-align: center; font-size:16px;">If You have lost your password or wish to reset it use the link below to get started</p>       
       
         <a style="text-align: center; display: block; font-size: 20px; background: #fff; padding:10px 0; color: #5cb85c"  href="<?= url('/password-reset', base64_encode($data['email'])); ?>">Reset Password</a>
        <h5 style="padding:30px 0; text-align: center; background: #5cb85c; color: #fff">Thank you. Panda.</h5>
    </div>
    </body>
</html>