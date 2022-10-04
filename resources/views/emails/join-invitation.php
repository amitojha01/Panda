<DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
    <body>
        <div style="width:800px; margin: 0 auto; background: #000;">
        <div align="center" style="padding:100px 0 10px 0"><img src="<?php echo url('/public/frontend/images/signin_logo.png'); ?>"></div>
        <div style="text-align: center; width: 600px; margin: 0 auto;>
            <a href="{{ url('/') }}" style="display: block; text-align: center; margin:30px auto;">
                
               
              </a>
        </div>
        <div style="border-top:#FFD500 solid 5px; background: #404040; padding:20px 0 50px 0; margin:90px 0 50px 0;">
        <h2 style="text-align: center; font-size:40px; padding:30px 0px 0 0px; margin:0 0 0 0; color: #FFD500; font-family: 'Poppins', sans-serif;">Join my group</h2>
        <p style="padding:0px 100px 0 100px; text-align: center; font-size:16px; font-family: 'Poppins', sans-serif; color: #fff;">You have been invited by <?php echo @$data['creator_name']; ?><<?php echo @$data['creator_email'] ?>> to join the group. To accept this invitation click the link below </p>

         <a style="text-align: center; display: block; font-size: 20px;  padding:10px 0; color: #FFD500; font-family: 'Poppins', sans-serif;"  href="<?= url('/accept-invitation',$data['token']); ?>"> <?php echo url('').'?'.@$data['token'];?></a>
        </div>       
       
        
        <h5 style="padding:30px 0 100px 0; font-size:20px; text-align: center; font-family: 'Poppins', sans-serif; background:#000; color: #fff">Thank You Panda</h5>
    </div>
    </body>
</html>