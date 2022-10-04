@extends('frontend.layouts.app')
@section('title', 'Home')

@section('content')
<div class="banner">
        <div id="banner" class="owl-carousel">
        <div class="item">
            <img src="{{ asset('public/frontend/images/banner1.jpg') }}" alt="banner1"/>
            <div class="banner_overlay">
                <h3>Upload Your Favorite Photo & Turn It into a <span>Wireless Speaker</span></h3>
                <p>BlueTooth Photo... It's as simple as 123, Upload Your Favorite Photo and Turn It into a Wireless Speaker, See your proof instantly. Order today and have it delivered direct... Play Your Music from your Cellphone or any Bluetooth device</p>
                <b>"THE CANVAS is the SPEAKER"</b>
                <a href="">UPLOAD PHOTOS &nbsp; <img src="{{ asset('public/frontend/images/white_arrow.png') }}" alt="white_arrow"/></a>
            </div>
        </div>
        <div class="item">
            <img src="{{ asset('public/frontend/images/banner1.jpg') }}" alt="banner1"/> 
            <div class="banner_overlay">
                <h3>Upload Your Favorite Photo & Turn It into a <span>Wireless Speaker</span></h3>
                <p>BlueTooth Photo... It's as simple as 123, Upload Your Favorite Photo and Turn It into a Wireless Speaker, See your proof instantly. Order today and have it delivered direct... Play Your Music from your Cellphone or any Bluetooth device</p>
                <b>"THE CANVAS is the SPEAKER"</b>
                <a href="">UPLOAD PHOTOS &nbsp; <img src="{{ asset('public/frontend/images/white_arrow.png') }}" alt="white_arrow"/></a>
            </div>
        </div>
        </div>
    </div>

    <div class="favourite_photo">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-12 col-xs-12">
                    <div class="favourite_photo_l">
                        <h2>LET'S GET <span>STARTED</span></h2>
                        <p><span>Create your own BlueTooth Photo</span> by uploading your favorite photo or artwork onto canvas. From there you can size, position and crop your image. And then we do the rest, by converting the canvas into a wireless Blue Tooth ready speaker,  <span>The Canvas is a Speaker.</span></p>
                        <b>"THE CANVAS is the SPEAKER"</b>
                        <a href="buy-now.html">Order Now &nbsp; <img src="{{ asset('public/frontend/images/white_arrow.png') }}" alt="white_arrow"></a>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <div class="favourite_photo_r">
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/O_zM4vCiyF8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="letsgetstarted">
        <img src="{{ asset('public/frontend/images/letsgetstarted.jpg') }}" alt="letsgetstarted"/>
        <div class="">
            <div class="letsgetstartedtext">
                <b>GREAT MOTHER'S DAY GIFT</b>
                <h2>BlueTooth Photo for Mother's Day</h2>
                <p>This mom loves her BlueTooth Photo</p>           
                
            </div>
            
            <div class="letsgetstartedvideo">
                <iframe src="https://www.youtube.com/embed/B_rx8_KM6WM?rel=0&amp;showinfo=0&amp;vq=720" width="100%" height="100%" frameborder="0" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>

    <div class="productdetails">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <div class="productdetails_l">
                        <img src="{{ asset('public/frontend/images/productdetails_l_img.jpg') }}" alt="productdetails_l_img"/>
                    </div>
                </div>
                <div class="col-md-7 col-sm-12 col-xs-12">
                    <div class="productdetails_r">
                        <div class="productdetails_r_inner">
                            <h3>BlueTooth Photo Wireless Speaker</h3>
                            <h6>$69.00 <span>/</span> <del>$89.00</del></h6>
                            <p>Create your own BlueTooth Photo now… by uploading your favorite photo &
                            start listening to your favorite music from your favorite photo. </p>
                            
                            <p>Select from one of 2 sizes</p>
                            
                            <span>8" x 10" Portrait </span>
                            <span>8" x 10" Landscape </span>
                            <span>Makes great gifts for friends, family and is perfect for any occasion.</span> 
                            
                            <div class="quentity_panel">
                                <div class="qty-input">
                                    <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                    <input class="product-qty" type="number" name="product-qty" min="0" max="10" value="1">
                                    <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                </div>
                                <a href="" class="PERSSONALIZE">PERSSONALIZE</a>
                                <div class="wishlist_btn"><a href=""><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
                                <div class="replacebtn"><a href=""><img src="{{ asset('public/frontend/images/round_icon.png') }}" alt="round_icon"/></a></div>
                            </div> 
                            <div class="sharepanel">
                                <div class="sharepanel_l">
                                    <span>Share This Product View</span>
                                </div>
                                <div class="sharepanel_r">
                                    <img src="{{ asset('public/frontend/images/social_share.png') }}" alt="social_share"/>
                                </div>
                                <div class="clr"></div>
                            </div>                      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
