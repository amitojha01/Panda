@extends('frontend.athlete.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="dashboard_r_top">
                            <img src="{{ asset('public/frontend/athlete/images/graph_img.jpg') }}" alt="graph_img" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="dashboard_l_top">
                            <h3>Game Highlights</h3>
                            <div id="gamehighlight" class="owl-carousel">
                                <div class="item">
                                    <div class="gamehighlight_box">
                                        <span><img src="{{ asset('public/frontend/athlete/images/blackcalender.png') }}" alt="blackcalender" /></span>
                                        <h4>8/25/2021</h4>
                                        <p>EDP Regional Tournament in Princeton, NJ playing the #4 team ranked in
                                            GotSoccer.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="gamehighlight_box">
                                        <span><img src="{{ asset('public/frontend/athlete/images/blackcalender.png') }}" alt="blackcalender" /></span>
                                        <h4>8/25/2021</h4>
                                        <p>EDP Regional Tournament in Princeton, NJ playing the #4 team ranked in
                                            GotSoccer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard_l_bottom">
                            <h3>Video Evidence</h3>
                            <div id="videoevidence" class="owl-carousel">
                                <div class="item">
                                    <img src="{{ asset('public/frontend/athlete/images/video_img.jpg') }}" alt="videoimg" />
                                </div>
                                <div class="item">
                                    <img src="{{ asset('public/frontend/athlete/images/video_img.jpg') }}" alt="videoimg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashbottom">
                    <h4>My Workouts ({{ count($workout_librarys) }})</h4>
                    <div class="row">
                        @if($workout_librarys)
                        @foreach($workout_librarys as $library)
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="dashbottombox_l">
                            <?php
                                $measurement = App\Models\WorkoutLibraryMeasurement::find($library['measurement_id']);
                                $exercises = App\Models\UserWorkoutExercises::where([
                                                                                'workout_library_id'=> $library['id'],
                                                                                'user_id'=> Auth()->user()->id
                                                                                ])->first();
                                $workout_description_array = array(
                                    'reps' => 'Enter the number of reps completed | Enter the amount of weight used',
                                    'time' => 'Enter the time it took to complete the workout',
                                    'distance' => 'Enter the distance they jumped',
                                    'height' => 'Enter the height of the box on which they jumped',
                                    'distance_weight' => 'Enter distance travelled | Enter the amount of weight used',
                                );
                                $xx = $workout_description_array[strtolower($measurement->name)];
                                $x = explode("|", $xx);
                            ?>
                                <h3><u>{{ $library['category_title'] }}</u></h3>
                                <h4>{{ $library['title'] }}</h4>
                                <span>
                                {{ucwords($measurement->unit)}}, 
                                    {{ $x[0] }}
                                </span>
                                <h5>
                                    {{ $exercises ? $exercises->unit_1 : 0}} <b>{{strtoupper($measurement->unit)}}</b>
                                </h5>
                                @if(count($x) > 1)
                                <span>
                                {{ucwords($measurement->unit)}}, 
                                    {{ $x[1] }}
                                </span>
                                <h5>
                                {{ $exercises ? $exercises->unit_2 : 0}} <b>{{strtoupper($measurement->unit)}}</b>
                                </h5>
                                @endif
                                <span>Date</span>
                                <h5>
                                    @if($exercises)
                                        {{ date('d/m/Y', strtotime($exercises->record_date) )}}
                                    @else
                                        {{ date('d/m/Y', strtotime($library['created_at']) )}}
                                    @endif
                                <a href="{{ route('workouts.show', $library['id']) }}">
                                    <img class="yellowarrow" src="{{ asset('public/frontend/athlete/images/yellowright_arrow.png') }}"
                                            alt="yellowright_arrow" />
                                </a>
                                    <div class="clr"></div>
                                </h5>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="dashbottombox_l dashbottombox_llast">
                                <a href="{{ route('workouts.index') }}">
                                    <img src="{{ asset('public/frontend/athlete/images/yellow_plus.png') }}" alt="yellow_plus" />
                                    <div class="clr"></div>
                                    <span>Add New Workout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="myprofile">
                    <a href="<?= url('athlete/profile'); ?>">
                    <div class="myprofile_l">
                        @if(Auth()->user()->profile_image!="")                    
                        <img src="{{ asset($user_detail->profile_image) }}" alt="user_img"/>
                        @else
                        <img src="{{ asset('public/frontend/athlete/images/user_img.png') }}" alt="user_img"/>
                        @endif
                    </div>
                    <div class="myprofile_mid">
                        <span>Hello,</span>
                        <h5>{{ Auth()->user()->username }}!</h5>
                    </div>
                    </a>
                    <div class="myprofile_r">
                        <a href="<?= url('athlete/edit-profile'); ?>">
                            <img src="{{ asset('public/frontend/athlete/images/edit_img.png') }}" alt="edit_img" />
                        </a>
                    </div>
                    <div class="clr"></div>
                    <div class="profiledetails">
                        <div class="profiledetails_l">
                            <span>User id</span>
                            <b>{{ Auth()->user()->username  }}</b>
                            <span>Current Education Level:</span>
                            <b>{{ @$school_level->name  }}</b>
                            <span>Birth Year</span>
                            <b>{{ Auth()->user()->date_of_year  }}</b>
                            <span>Height</span>
                            <b>{{ @$user_physicalInfo->height  }}"</b>
                            <span>Hand Measurement</span>
                            <b>{{ @$user_physicalInfo->head  }}"</b>
                        </div>
                        <div class="profiledetails_r">
                            <span>Sport</span>
                            <b>{{ @$sport_detail->name  }}</b>
                            <span>Gender</span>
                            <b>{{ ucfirst(Auth()->user()->gender)  }}</b>
                            <span>High School GPA</span>
                            <b>{{ @$user_physicalInfo->grade  }}</b>
                            <span>Weight</span>
                            <b>{{ @$user_physicalInfo->weight  }} lbs</b>
                            <span>Wingspan</span>
                            <b>{{ @$user_physicalInfo->wingspan  }}"</b>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="athletic_competencybox">
                        <h6>Athletic Competency Index ™ Score:</h6>
                        <!-- <h4>75.6</h4> -->
                        <a href="javascript:void(0)" id="calculate-aci-score" class="postbtn">Calculate</a>
                        <div class="clr"></div>
                    </div>
                    <div class="athletic_competencybox">
                        <h6>ACI ™ Rank for all similar gender and birth year</h6>
                        <h4 style="color: #4BFF00;">82%</h4>
                        <div class="clr"></div>
                    </div>

                    <div class="coach_recommendation">
                        <h4>Coach Recommendations (3)</h4>
                        <div id="coachslider" class="owl-carousel">
                            <div class="item">
                                <div class="coachsliderbox">
                                    <div class="coachslider_img">
                                        <img src="{{ asset('public/frontend/athlete/images/user_img.png') }}" alt="user_img" />
                                    </div>
                                    <h5>Steve Smith <span>Harrisburg, PA</span> <em>5w</em>
                                        <div class="clr"></div>
                                    </h5>
                                    <b>Club Coach</b>
                                    <p>Wayne Smith is a terrific athlete and and is a gym rat working out 5 days a work.
                                    </p>
                                </div>
                                <div class="cacho_btn">
                                    <a href="" class="postbtn">Post</a>
                                    <a href="" class="dontpostbtn">Do Not Post</a>
                                    <a href="" class="contactcaochbtn">Contact Coach</a>
                                    <a href="" class="caochquestionbtn">
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="item">
                                <div class="coachsliderbox">
                                    <div class="coachslider_img">
                                        <img src="{{ asset('public/frontend/athlete/images/user_img.png') }}" alt="user_img" />
                                    </div>
                                    <h5>Steve Smith <span>Harrisburg, PA</span> <em>5w</em>
                                        <div class="clr"></div>
                                    </h5>
                                    <b>Club Coach</b>
                                    <p>Wayne Smith is a terrific athlete and and is a gym rat working out 5 days a work.
                                    </p>
                                </div>
                                <div class="cacho_btn">
                                    <a href="" class="postbtn">Post</a>
                                    <a href="" class="dontpostbtn">Do Not Post</a>
                                    <a href="" class="contactcaochbtn">Contact Coach</a>
                                    <a href="" class="caochquestionbtn">
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="" class="requestrecommendationbtn">REQUEST A RECOMMENDATION FROM A COACH</a>
                </div>
            </div>
        </div>
    </div>
@endsection