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
        <h2 style="text-align: center; background: #5cb85c; padding:30px 0; color: #fff">Join my group</h2>
        <p style="padding:15px 0 0 0; font-size: 20spx; text-align: center; font-size:16px;">You have been invited by <?php echo @$data['creator_name'] ?><<?php echo @$data['creator_email'] ?>> to join the group. To accept this invitation click the link below </p>      

         <a style="text-align: center; display: block; font-size: 20px; background: #fff; padding:10px 0; color: #5cb85c"  href="<?= url('/accept-invitation',$data['token']); ?>"> <?php echo url('').'?'.@$data['token'];?></a>
        <h5 style="padding:30px 0; text-align: center; background: #5cb85c; color: #fff">Thank you. Panda.</h5>
    </div>
    </body>
</html>