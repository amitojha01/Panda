<DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
    <body>        
        <div style="text-align: center; width: 600px; margin: 0 auto; background: #f4f4f4;">
            <a href="{{ url('/') }}" style="display: block; text-align: center; margin:30px auto;">
               
                <img src="{{ asset('public/frontend/images/logo.png') }}" alt="" srcset="">
              </a>
        </div>
        <h2 style="text-align: center; background: #5cb85c; padding:30px 0; color: #fff"><?php echo @$data['link_type']; ?> Link</h2>
        <p style="padding:15px 0 0 0; font-size: 20spx; text-align: center; font-size:16px;">You have been invited by <?php echo @$data['sender_name'] ?><<?php echo @$data['sender_email'] ?>>.  </p>

        <p style="text-align: center;"><?php echo @$data['msg']; ?></p>      

         <a style="text-align: center; display: block; font-size: 20px; background: #fff; padding:10px 0; color: #5cb85c"  href="<?php echo url('/registration/coach'); ?>"> <?php echo url('/registration/coach'); ?></a>
        <h5 style="padding:30px 0; text-align: center; background: #5cb85c; color: #fff">Thank you. Panda.</h5>
    </div>
    </body>
</html>