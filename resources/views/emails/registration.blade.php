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
        <h2 style="text-align: center; background: #5cb85c; padding:30px 0; color: #fff">Registration Successfully Completed</h2>
        <h3 style="text-align: center">Hi <strong>{{ $data['name'] }},</strong></h3>
        <p style="text-align: center; padding:3px 0 0; color: #000; font-size: 20px;"> Thank you for joining with Us. </p>
        <p style="text-align: center; padding:3px 0; color: #000; font-size: 20px;"> Your login details provided below.</p>

        <p style="text-align: center; padding:3px 0; color: #000; font-size: 20px;"> Email: {{ $data['email'] }}</p>
        <p style="text-align: center; padding:3px 0; color: #000; font-size: 20px;"> Password: {{ $data['password'] }}</p>
        <!-- <table>
            <tr align="center">
                <th style="color:#000; font-size: 20px;">Email : </th>
                <td style="color:#5cb85c; font-size: 20px;">{{ $data['email'] }}</td>
            </tr>
            <tr align="center">
                <th style="color:#000; font-size: 20px;">Password : </th>
                <td style="color:#5cb85c; font-size: 20px;">{{ $data['password'] }}</td>
            </tr>
        </table> -->
            <div>
            <h5 style="padding:30px 0; text-align: center; background: #5cb85c; color: #fff">Thank you. bluetoothphotos.</h5>
            </div>
    </body>
</html>