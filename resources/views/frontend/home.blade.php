@extends('frontend.layouts.apphome')
@section('title', 'Welcome')

@section('content')
   


<div class="banner">
    <div class="banner_l">
        <h5>Best Application</h5>
        <h3>{{ $banner['title'] }}</h3>
       <!--  <p>{{ $banner['content'] }}</p> -->
        <a href="">Explore</a>
    </div>
    <div class="banner_r"><img src="{{ asset($banner['image']) }}" alt="bannermobile_img"/></div>
    <div class="clr"></div>
</div>

<div class="threesteps">
    <span>Just 3 easy steps</span>
    <h2>Fitness Made Simple</h2>
    <div class="container">
        <div class="row">
            @if($fitness)
            @foreach($fitness as $key => $fitness)
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="steps_box">
                    <div class="stepboxno">{{$key+1}}</div>
                    <h3>{{ $fitness->title }}</h3>
                     <p>{{ $fitness->content }}</p> 
                    <a href="{{ route('registration') }}">Start Now</a>
                </div>
            </div>
            @endforeach
            @endif
            
        </div>
    </div>
</div>

<div class="pandastory">
    <div class="container">
        <div class="row">
            <div class="col-md-7 co-sm-12 col-xs-12">
                <div class="pandastory_l">
                    <img src="{{ asset($stories['image']) }}" alt="pandastory_img"/>
                </div>
            </div>
            <div class="col-md-5 co-sm-12 col-xs-12">
                <div class="pandastory_r">
                    <span>The panda Story</span>
                    <h2>{{ $stories->title }}</h2>
                    <p>{{ $stories->content }}</p>
                    <a href="{{ route('about-us') }}">About Us</a>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="pandastory pandaservices">
    <div class="container">
        <div class="row">           
            <div class="col-md-5 co-sm-12 col-xs-12">
                <div class="pandastory_r">
                    <span>Service</span>
                    <h2>{{ $services->title }}</h2>
                    <p>{{ $services->content }}</p>
                    <a href="{{ route('about-us') }}">About Us</a>
                </div>
            </div>
            <div class="col-md-7 co-sm-12 col-xs-12">
                <div class="pandastory_l">
                    <img src="{{ asset($services['image']) }}" alt="services_imgr"/>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="stronger_panel">
    <div class="container">
        <h2>Benefits of Panda Stronger</h2>
        <ul>
             @foreach($benefits as $key => $benefits)
            <li>
                <span>{{ $benefits->title }} </span>
               <!--  <p>{{ $benefits->content }}</p> -->
            </li>
            @endforeach;
            <!--            
            <li>
                <span>Benefit 6</span>
                <p>Lorem ipsum dolor sit amet, consecter adipiscing elit sed do eiusmo.</p>
            </li> -->
        </ul>
        
    </div>
</div>

<div class="morefeature">
    <div class="container">
        <span>More Features</span>
        <h2>Explore Our <br> Awesome Features</h2>
        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="morefeature_l">
                    <div class="morefeature_l_top">
                        <span><img src="{{ asset('public/frontend/images/feature_icon1.png') }}" alt="feature_icon1"/></span>
                        <h3>{{ $features1->title }}</h3>
                       <!--  <p>{!! substr($features1->content,0,132) !!}.</p> -->
                       <p>{!! $features1->content !!}</p>
                    </div>
                    <div class="morefeature_l_top">
                        <span><img src="{{ asset('public/frontend/images/feature_icon4.png') }}" alt="feature_icon4"/></span>
                        <h3>{{ isset($features2)?($features4->title):'' }}</h3>
                        <!-- <p>{!! isset($features2)?(substr($features4->content,0,132)):'' !!}.</p> -->
                        <p>{!! isset($features2)?($features4->content):'' !!}</p>
                    </div>

                    
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="morefeature_mid">
                    <img src="{{ asset('public/frontend/images/fretured_img.png') }}" alt="fretured_img"/>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="morefeature_r">

                    <div class="morefeature_l_top">
                        <span><img src="{{ asset('public/frontend/images/feature_icon2.png') }}" alt="feature_icon2"/></span>
                        <h3>{{ isset($features2)?($features2->title):'' }}</h3>
                        <!-- <p>{!! isset($features2)?(substr($features2->content,0,122)):'' !!}.</p> -->
                        <p>{!! $features2->content !!}</p>
                    </div>


                    <div class="morefeature_l_top">
                        <span><img src="{{ asset('public/frontend/images/feature_icon3.png') }}" alt="feature_icon3"/></span>
                        <h3>{{ isset($features2)?($features3->title):'' }}</h3>
                       <!--  <p>{!! isset($features2)?(substr($features3->content,0,132)):'' !!}.</p> -->

                        <p>{!! isset($features2)?($features3->content):'' !!}</p>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="downloadappbg">
    <div class="container">
        <span>Download Now</span>
        <!-- <h2>Download Our App <br> Right Now</h2> -->

        <h2>The Panda App will be available soon.  Coming in April 2022!!</h2>
        <a href=""><img src="{{ asset('public/frontend/images/apple_icon.png') }}" alt="apple_icon"/></a>
        <a href=""><img src="{{ asset('public/frontend/images/playstore_icon.png') }}" alt="playstore_icon"/></a>
    </div>
</div>



<div class="testimonilas">
    <div class="container">
        <div class="testimonilainner">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="testimonilas_l">
                        <span>Testimonials</span>
                        <h2>{{ $testimonial_content->title }}</h2>
                       <!--  <p>{{ $testimonial_content->content }}</p> -->
                        <b>{{ $testimonial_content->ratings }}</b>
                        <div class="ratingstar">
                            <?php for ($i=1; $i <= round($testimonial_content->ratings); $i++):
                                      echo '<i class="fa fa-star checked"></i>' ;
                               endfor;
                          ?>
                          <?php for ($i=1; $i <= 5-(round($testimonial_content->ratings)); $i++):
                                      echo '<i class="fa fa-star "></i>' ;
                               endfor;
                          ?>
                            <!-- <i class="fa fa-star checked"></i>
                            <i class="fa fa-star checked"></i>
                            <i class="fa fa-star checked"></i>
                            <i class="fa fa-star checked"></i>
                            <i class="fa fa-star checked"></i> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    @if($testimonial_review)
                            @foreach($testimonial_review as $key => $testimonial_review)
                    <div class="testimonilasbox">
                        <?php if(!empty($testimonial_review['image'])){ ?>
                        <div class="testimonilasboxl">
                            <img src="{{ asset($testimonial_review['image']) }}" alt="testimonials_img" style="width: 100%;    height: 100%;border-radius: 50%;" />
                        </div>
                    <?php } ?>
                        <div class="testimonilasboxr">
                            <h4>{{ $testimonial_review->name }}</h4>
                            <p>"{{ $testimonial_review->comments}}"</p>
                            
                        </div>
                        <div class="clr"></div>
                    </div>
                    @endforeach
                    @endif
                   
                    
                </div>
            </div>
        </div>
    </div>
</div>


<div class="becomeacoach">
    <div class="becomeacoach_l">
        <h2>{{ $lower_banner['title'] }}</h2>
       <!--  <p>{{ $lower_banner['content'] }}</p> -->
        <a href="{{url('registration/coach')}}">Register Now</a>
    </div>
    <div class="becomeacoach_r">
        <img src="{{ asset($lower_banner['image']) }}" alt="becomeacoachbg"/>
    </div>
    <div class="clearfix"></div>
</div>

<div class="latestblog">
    <div class="container">
     <div class="latestbox_inner">
        <h2>Latest Blogs & News</h2>
       
        <div class="row">
            <?php 
                    if (!empty(count($bloglist))) {
                    for($i=0; $i<count($bloglist); $i++) {
                    ?>
            
            <div class="col-md-6 col-sm-12 col-xs-12">
                <a href="{{url('blogs-details/'.$bloglist[$i]->id)}}">
                <div class="blogimgbox">
                     <img src="{{ asset($bloglist[$i]->image) }}" alt="blogimg1" />
                     <div class="blogtext">
                        <span>{{ date("d M Y", strtotime(($bloglist[$i]->created_at))) }}</span>
                        <h3>{{ $bloglist[$i]->title }}</h3>
                     </div>                                                          
                </div>
            </a>
            </div>
        
        <?php } } ?>
        </div>
        </div>
    </div>
</div>

<div class="newsletter">
    <div class="container">
        <div class="newsletter_inner">
            <div class="row">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="newsl">
                        <h3>Newsletter</h3>
                        <!-- <p>Lorem ipsum dolor sit amet, consectetur</p> -->
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="nwsr">
                        <form method="post" action="{{ route('newsletter_subscription') }}" enctype="multipart/form-data">
                            @csrf
                        <input type="text" name="email" placeholder="Your Email"/>
                        <input type="submit" class="subcribtionbtn" value="Subscribe"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
  <script type="text/javascript">
    jQuery(document).ready(function($) {
        jQuery('.stellarnav').stellarNav({
            theme: 'dark',
            breakpoint: 991,
            position: 'right',
            phoneBtn: '18009997788',
            locationBtn: 'https://www.google.com/maps'
        });
    });
</script>
@endsection