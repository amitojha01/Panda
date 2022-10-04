@extends('frontend.athlete.layouts.app')
@section('title', 'Dashboard')
@section('style')
<style>
    #aci-score{
        padding-right: 5px;
    }
    #myChart {
        width: 100%;
        height: 300px;
    }
</style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="dashboard_r_top">
                            <!-- <img src="{{ asset('public/frontend/athlete/images/graph_img.jpg') }}" alt="graph_img" /> -->
                            <div id="myChart" width="400" height="170"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="dashboard_l_top">
                            <a href="{{ route('athlete.game-highlights')}}"><h3>Game Highlights</h3></a>
                            <div id="gamehighlight" class="owl-carousel">
                                @if($game_highlight)
                                @foreach($game_highlight as $key=> $game_list)
                                <a href="{{ route('athlete.game-highlights')}}">
                                <div class="item">
                                    <div class="gamehighlight_box">
                                        <span><img src="{{ asset('public/frontend/athlete/images/blackcalender.png') }}" alt="blackcalender" /></span>
                                        <h4>{{ date('Y-m-d', strtotime($game_list->record_date)) }}</h4>
                                        <p>{{ substr(($game_list->description),0,100) }}</p>
                                    </div>
                                </div>
                                </a>
                                @endforeach;
                                @endif;
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="dashboard_l_bottom">
                             <a href="{{ route('athlete.video-evidence') }}"><h3>Video Evidence</h3></a>
                            <div id="videoevidence" class="owl-carousel">
                                @if($video_evidence)
                                @foreach($video_evidence as $key => $video_list)
                                <div class="item">
                <?php $videoLink = $video_list->video_link;
               $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
                $has_match = preg_match($rx, $videoLink, $matches);
                $videoId = $matches[1]; ?>
                <a href="{{ route('athlete.video-evidence') }}"><img src="{{ 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}" width="85%" height="85%" alt="videoimg" /></a>
                                </div>
                                @endforeach;
                                @endif;
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="dashboard_l_top" style="margin-bottom:30px;">
                            <a href="{{ route('athlete.events')}}"><h3>Last event attended</h3></a>
                             <div id="last_attend_event" class="owl-carousel">
                                @if($last_attend_event)
                                @foreach($last_attend_event as $key => $last_attendevent)
                                  <div class="item">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="eventsboxleft">
                                    <i>To</i>
                                    <h6>Start Date</h6><b>{{ $last_attendevent->start_date }}</b>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="eventsboxright">
                                    <h6>End Date</h6><b>{{ $last_attendevent->end_date }}</b>
                                </div>
                            </div>
                            <div class="col-lg-12">     
                                <div class="eventsboxleft">
                                    <h6>Location</h6><b>{{ $last_attendevent->location }}</b>
                                </div>                                    
                            </div>
                        </div>
                                  </div>
                                  @endforeach;
                                  @endif;
                                  
                             </div>
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="dashboard_l_bottom">
                             <a  href="{{ route('athlete.events') }}"><h3 style="color:#4BFF00;">The next upcoming event to attend</h3></a>
                           <div id="upcomingevents" class="owl-carousel">
                            @if($upcoming_event)
                                @foreach($upcoming_event as $key => $upcomingevents)
                                  <div class="item">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="eventsboxleft">
                                    <i>To</i>
                                    <h6>Start Date</h6><b>{{ $upcomingevents->start_date }}</b>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="eventsboxright">
                                    <h6>End Date</h6><b>{{ $upcomingevents->end_date }}</b>
                                </div>
                            </div>
                            <div class="col-lg-12">     
                                <div class="eventsboxleft">
                                    <h6>Location</h6><b>{{ $upcomingevents->location }}</b>
                                </div>                                    
                            </div>
                        </div>
                                  </div>
                                  @endforeach
                                  @endif
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
                                    'speed' => 'Enter MPH',
                                    'distance'=> 'Enter Feet',
                                    'time'=> 'Enter Sec',
                                    //'yards'=> 'Enter Distance',
                                    'percentage' => 'Enter Percentage'
                                );
                                $xx = $workout_description_array[strtolower($measurement->name)];
                                $x = explode("|", $xx);
                            ?>
                                <h3><u>{{ $library['category_title'] }}</u></h3>
                                <h4>{{ !empty($library['sport_category_title']) ? $library['sport_category_title'] : $library['title'] }}</h4>
                                <span>
                                {{ucwords($measurement->unit)}}, 
                                    {{ !empty($x[0]) ? $x[0] : '0' }}
                                </span>
                                <h5>
                                    {{ $exercises ? $exercises->unit_1 : 0}} <b>{{strtoupper($measurement->unit)}}</b>
                                </h5>
                                @if(count($x) > 1)
                                <span>
                                {{ucwords($measurement->unit)}}, 
                                    {{ !empty($x[1]) ? $x[1] : '0' }}
                                </span>
                                <h5>
                                {{ $exercises ? $exercises->unit_2 : 0}} <b>{{strtoupper($measurement->unit)}}</b>
                                </h5>
                                @endif
                                <span>Date</span>
                                <h5>
                                    @if($exercises)
                                        {{ date('m/d/Y', strtotime($exercises->record_date) )}}
                                    @else
                                        {{ date('m/d/Y', strtotime($library['created_at']) )}}
                                    @endif
                                <a href="{{ url('athlete/workouts/show/'.$library['category_id'].'/'.$library['id']) }}">
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
                            <b>{{ @$user_physicalInfo->height_feet  }}' {{ @$user_physicalInfo->height_inch  }}"</b>
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
                            <b>{{ @$user_physicalInfo->wingspan_feet  }}' {{ @$user_physicalInfo->wingspan_inch }}"</b>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="athletic_competencybox">
                        <h6>Athletic Competency Index ™ Score:</h6>
                        @if($aci_score)
                            <h4 id="aci-score">{{ round($aci_score->aci_index, 2) }}</h4>
                            <a href="javascript:void(0)" id="calculate-aci-score" class="postbtn">Recalculate</a>
                        @else
                            <h4 id="aci-score">-</h4>
                            <a href="javascript:void(0)" id="calculate-aci-score" class="postbtn">Calculate</a>
                        @endif
                        <div class="clr"></div>
                    </div>
                    <div class="athletic_competencybox">
                        <h6>ACI ™ Rank for all similar gender and birth year</h6>
                        <h4 style="color: #4BFF00;">82</h4>
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
                    <a href="{{ route('athlete.coach-recomendation') }}" class="requestrecommendationbtn">REQUEST A RECOMMENDATION FROM A COACH</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script>
    $(document).ready(function(){
        $('#calculate-aci-score').on('click', function(){
            $.ajax({
            type : "GET",
            url : "{{ url('athlete/aci-index-calculate') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    $('#aci-score').html(res.data.aci_index.toFixed(2));
                    $('#calculate-aci-score').html('Recalculate');
                }else{
                    swal(res.message, 'Warning', 'warning');
                }
            },
            error: function(err){
                console.log(err);
            }
            }).done( () => {
            });
        })
    })

    /**---Chart.js */
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("myChart", am4charts.XYChart);
        chart.paddingRight = 20;
        // Add data
        chart.data = [{
            "month": "Jan",
            "value": 25
            }, {
            "month": "Feb",
            "value": 27
            }, {
            "month": "March",
            "value": 30
            }, {
            "month": "Apr",
            "value": 31
            }, {
            "month": "May",
            "value": 29
            }, {
            "month": "June",
            "value": 28
            }, {
            "month": "July",
            "value": 29
            }, {
            "month": "Aug",
            "value": 30
            }, {
            "month": "Sep",
            "value": 31
            },{
            "month": "Oct",
            "value": 31
            },{
            "month": "Nov",
            "value": 32
            },{
            "month": "Dec",
            "value": 34
        }];
        
        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "month";
        categoryAxis.renderer.minGridDistance = 50;
        categoryAxis.renderer.grid.template.location = 0.5;
        categoryAxis.startLocation = 0.5;
        categoryAxis.endLocation = 0.5;

        // Create value axis
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.baseValue = 0;

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.categoryX = "month";
        series.strokeWidth = 3;
        series.tensionX = 0.77;
        series.stroke = am4core.color("#4BFF00"); // red
        // bullet is added because we add tooltip to a bullet for it to change color
        var bullet = series.bullets.push(new am4charts.Bullet());
        bullet.tooltipText = "{valueY}";

        bullet.adapter.add("fill", function(fill, target){
            if(target.dataItem.valueY < 0){
                return am4core.color("#FF0000");
            }
            return fill;
        })
        var range = valueAxis.createSeriesRange(series);
        range.value = 0;
        range.endValue = -1000;
        range.contents.stroke = am4core.color("#FF0000");
        range.contents.fill = range.contents.stroke;

        // Add scrollbar
        var scrollbarX = new am4charts.XYChartScrollbar();
        scrollbarX.series.push(series);
        chart.scrollbarX = scrollbarX;

        chart.cursor = new am4charts.XYCursor();

    }); // end am4core.ready()
</script>
@endsection