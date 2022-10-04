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
        <div style="border-top:#FFD500 solid 5px; background: #404040; padding:20px 0 50px 0; margin:90px 0 0 0;">

         <p style="padding:0px 100px 0 13px; font-size:16px; font-family: 'Poppins', sans-serif; color: #fff; font-weight: bold;">Subject : &nbsp; &nbsp; &nbsp; &nbsp; <?= @$data['subject'] ?> </p>

         <p style="padding:0px 30px 0 13px; font-size:16px; font-family: 'Poppins', sans-serif; color: #fff; font-weight: bold;">From :  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span style="    font-weight: normal;"><a style="color:#fff;"> <?= @$data['from_email'] ?> </a></span>&nbsp;&nbsp;<span style="color:#c8db28; font-size: 12px;">(coaches, to reply directly to the athlete, use the email address provided to the left)</span> </p>

         <p style="padding:0px 100px 0 13px; font-size:16px; font-family: 'Poppins', sans-serif; color: #fff;">Coach, </p>


         <p style="padding:0px 10px 0 13px; font-size:16px; font-family: 'Poppins', sans-serif; color: #fff;"><?= @$data['message'] ?> </p>

         <p style="padding:0px 100px 0 13px; font-size:16px; font-family: 'Poppins', sans-serif; color: #fff;"><?= @$data['athlete_name'] ?> </p>


     </div>  
     <!-- <div style="background: #97919157; margin-top:-30px">  -->    
        <p style="padding: 10px 10px 10px 10px;font-size: 16px;font-family: 'Poppins', sans-serif;color: #fff;font-weight: bold;background: #1e1e1e;margin: 0;">To view the athlete profile: <a href="<?= @$data['profile_link'] ?>" target="_blank" style="color:#c8db28; font-weight: normal"><?= @$data['profile_link'] ?></a></p>

        <p style="padding: 10px 10px 10px 10px;font-size: 16px; text-align:center;  font-family: 'Poppins', sans-serif;color: #fff;background: #1e1e1e;margin: 0;">
           This email was sent through Panda Stronger’s email server on behalf of one of our athletes.   To respond directly to the athlete, send your email to 
       </p>
       <p style="padding: 10px 10px 10px 10px;font-size: 16px;text-align:center; font-family: 'Poppins', sans-serif;color: #fff;font-weight: bold;background: #1e1e1e;margin: 0;"><a style="color:#c8db28;"><?= @$data['from_email'] ?></a></p>
   <!-- </div> -->


</div>
</body>
</html>