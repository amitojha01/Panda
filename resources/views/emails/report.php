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
        <h2 style="text-align: center; background: #5cb85c; padding:30px 0; color: #fff">Report Issue</h2>
        <p> Hello Admin,</p>
        <p style="padding:15px 0 0 0; font-size: 20spx; font-size:16px;">Issue raised by: <?= @$data['name'] ?></p> 
         <h3>Email:  <?= @$data['email'] ?></h3> 
        <h3>Mobile:  <?= @$data['phone_no'] ?></h3> 
        <h3 > Message: </h3><p><?= @$data['message'] ?></p>   

         <a style="text-align: center; display: block; font-size: 20px; background: #fff; padding:10px 0; color: #5cb85c"  href=""></a>
        <h5 style="padding:30px 0; text-align: center; background: #5cb85c; color: #fff">Thank you. Panda.</h5>
    </div>
    </body>
</html>