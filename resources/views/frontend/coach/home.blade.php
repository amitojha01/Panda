@extends('frontend.layouts.app')
@section('title', 'Welcome')

@section('content')
    <!--<div class="signin" style="height: 100vh">
        <div class="signinheader">
            <div class="signinheader_l">
                <a href="">
                    <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" />
                </a>
            </div>
            <div class="signinheader_r">
                <span>Don't have an account? <a href="{{ route('registration') }}">Try Now</a></span>
            </div>
            <div class="clr"></div>
        </div>
        <div class="signinbox">
            <h2>Comming Soon ... .. .</h2>
        </div>
        <div class="clr"></div>
        <div class="signinfooter">
            <div class="signinfooter_l">
                <p>Copyright © 2021 PARC Sports LLC All Rights Reserved.</p>
            </div>
            <div class="signinfooter_r">
                <ul>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>-->

    <div class="signin">
        <div class="signinheader">
            <div class="signinheader_l"><a href=""><img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo"/></a></div>
            <div class="signinheader_r">
                <span>Don't have an account? <a href="">Try Now</a></span>
            </div>
            <div class="clr"></div>
        </div>
        <div class="signinbox">
            <h2>Sign In</h2>
            <span>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod</span>
            <label>Email</label>
            <input type="text" class="form-control" placeholder="iamsteve@gmail.com"/>
            <label>Password</label>
            <input type="password" class="form-control" placeholder="**************"/>
            <a href="">Forgot password?</a>
            <input type="submit" class="submitbtn" value="Login"/>
        </div>
        <div class="clr"></div>
        <div class="signinfooter">
            <div class="signinfooter_l"><p>Copyright © 2021 PARC Sports LLC All Rights Reserved.</p></div>
            <div class="signinfooter_r">
                <ul>
                    <li><a href="">Terms of Use</a></li>
                    <li><a href="">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>

@endsection