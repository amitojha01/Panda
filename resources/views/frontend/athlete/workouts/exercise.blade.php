@extends('frontend.athlete.layouts.app')
@section('title', 'Workouts Exercise')
@section('content')
<div class="createteamingup">
    <div class="container-fluid">
        <div class="addgamehighlightes">
            <div class="addgamehighlightesinner breanchpress_l">
                <h3 style="display: flex;justify-content: space-between;">
                    <div>Workout Data Entry</div>
                    <div style="padding: 8px; color: black; background: #FFD500;min-width: 204px;text-align: center;">{{$workoutCategory->category_title}}</div>
                </h3>
                <h3>
                    <?php
                    // echo "<pre>";
                    // print_r($workoutCategory);
                    // print_r($workout->id);
                    // die;    
                    ?>
                    {{ !empty($workout->sport_category_title) ? ucwords($workout->sport_category_title) : ucwords($workout->title) }} 
                   {{ $workoutCategory->category_title == 'ACI(TM) workouts' ? ($workoutCategory->category_title) : '' ; }}
                       
                   
                </h3>


                <table class="profiletable" cellpadding="0" cellspacing="0" style="width:100%;">                    
                    <tr>
                        <th>Record Date</th>
                        
                        <?php
                                $workout_description_array = array(
                                    'reps' => 'Enter the number of reps completed | Enter the amount of weight used',
                                    'time' => 'Enter the time it took to complete the workout',
                                    'distance' => 'Enter the distance they jumped',
                                    'height' => 'Enter the height of the box on which they jumped',
                                    'distance & weight' => 'Enter distance travelled | Enter the amount of weight used',
                                    'speed' => 'Enter MPH',
                                    'distance'=> 'Enter ',
                                    'time'=> 'Enter Sec',
                                    'weight' =>  'Enter the amount of weight used',
                                    //'yards'=> 'Enter Distance',
                                    'percentage' => 'Enter Percentage'
                                );
                                $xx = $workout_description_array[strtolower($workout->measurement->name)];
                                $x = explode("|", $xx);
                                if(strtolower($workout->measurement->name) == 'distance'){
                                    $text = $x[0].' Inch';
                                }else if(strtolower($workout->measurement->name) == 'time'){
                                    $text =  $x[0].' (example, a six minute run 6:00 should be converted to 360 seconds)';
                                }else{
                                    $text =  $x[0];
                                }
                                //if excese is already added and it it from ACI index
                                $disabled = "";
                                $unit_1 = "";
                                $required = "";
                                if($workout->is_aci_index == 1 && !empty($exercise)){
                                    //$disabled = "disabled";
                                    $unit_1 = $exercise->unit_1;
                                    $required = "";
                                }
                            ?>
                            {{-- <th>{{$workout->measurement->name}}</th> --}}
                            <th>
                               
                        {{$workout->measurement->name}}
                  
                            </th>
                        {{-- @if(count($x) >1 )
                        <th>{{$workout->measurement->name}},
                            <?php 
                            if(strtolower($workout->measurement->name) == 'distance'){
                                    echo $x[1].' Inch';
                            }
                            elseif(strtolower($workout->measurement->name) == 'time'){
                                    echo $x[1].' (example, a six minute run 6:00 should be converted to 360 seconds)';
                            }
                            else{
                                    echo $x[1];
                            }

                        elseif($workout->measurement->name == 'Reps' && $workout->title != 'Pull Ups' && $workout->title !='Push Ups'){
                          echo 'Weight Lifted';  
                        }
                        elseif($workout->measurement->name == 'time' ){
                            echo 'Time (seconds #.##)';
                        }
                        elseif ($workout->measurement->name == 'Distance') {
                            echo 'Distance (inches)';
                        }
                        
                        else{    
                    ?>
                        {{$workout->measurement->name}}
                   <?php
                    }
                }
                   ?>
                            </th>
                        {{-- @if(count($x) >1 )
                        <th>{{$workout->measurement->name}},
                            <?php 
                            if(strtolower($workout->measurement->name) == 'distance'){
                                    echo $x[1].' Inch';
                            }
                            elseif(strtolower($workout->measurement->name) == 'time'){
                                    echo $x[1].' (example, a six minute run 6:00 should be converted to 360 seconds)';
                            }
                            else{
                                    echo $x[1];
                            }
                            ?>
                        </th> 
                        @endif --}}
                        <!-- <th>Url of Video Evidence</th> -->
                    </tr>
                    <?php 
                    foreach ($userWorkoutExercises as  $logvalue) { ?>
                    <tr>
                        <td><?= date('m/d/Y', strtotime($logvalue->record_date)); ?></td>
                        <td><?= $logvalue->unit_1 ?></td>
                        {{-- @if(count($x) >1 )
                        <td><?= $logvalue->unit_2 ?></td>
                        @endif --}}
                       <!--  <td><a href=""><?= $logvalue->video ; ?></a></td> -->
                    </tr>
                    <?php

                    }
                    ?>

                    <form id="frm-workout-exercise" action="" method="POST" >
                        @csrf
                    <tr>
                        <td><input type="text" class="form-control datepicker" name="record_date" 
                            value="{{ old('record_date') }}" placeholder="MM-DD-YYYY" 
                            required autocomplete="off"
                            />
                        </td>
                        <td><input type="number" id="unit_1_message" autocomplete="off" step=".01" name="unit_1" data-m-dec="2" pattern="[0-9]\.[0-9]{2}"
                            value="" 
                            class="form-control"
                            {{ $disabled }}
                            placeholder=""
                            {{ $required }}
                            required
                        />
                        </td>
                        {{-- @if(count($x) >1 )
                        <td><input type="number" autocomplete="off" min="1" step=".01" name="unit_2" value="{{ old('unit_2') }}" class="form-control " placeholder="" />
                        </td>
                        @endif --}}
                        <!-- <td><input type="url" autocomplete="off" class="form-control" name="video" value="{{old('video')}}" placeholder="www.youtube.com/escf1"/></td> -->
                    <tr>
                    <tr>                       
                        <td  
                        {{-- @if(count($x) >1 )
                            colspan="3"
                            @else --}}
                            colspan="1"
                            {{-- @endif --}}
                            ></td>
                            
                    <input type="hidden" name="category_id" value="{{ $category_id }}">
                        <td>
                            {{-- <a class="clicktoupdate" href="">Click Save To UPDATE</a> --}}
                            
                            <input type="submit" class="addhighlightsbtn clicktoupdate" value="Click Save To UPDATE"/>
                        </td>
                    <tr>
                </table>

                {{-- <form id="frm-workout-exercise" action="" method="POST" >
                    @csrf
                    <div class="form-group datrrecordtext">
                        <label>Date of record</label>
                        <input type="text" class="form-control datepicker" name="record_date" 
                            value="{{ old('record_date') }}" placeholder="MM-DD-YYYY" 
                            required autocomplete="off"
                            />
                        <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        @if ($errors->has('record_date'))
                            <span class="text-danger">{{ $errors->first('record_date') }}</span>
                        @endif
                    </div>
                    <div class="form-group datrrecordtext">
                        <label>
                            {{$workout->measurement->name}},
                            <?php
                                $workout_description_array = array(
                                    'reps' => 'Enter the number of reps completed | Enter the amount of weight used',
                                    'time' => 'Enter the time it took to complete the workout',
                                    'distance' => 'Enter the distance they jumped',
                                    'height' => 'Enter the height of the box on which they jumped',
                                    'distance_weight' => 'Enter distance travelled | Enter the amount of weight used',
                                    'speed' => 'Enter MPH',
                                    'distance'=> 'Enter ',
                                    'time'=> 'Enter Sec',
                                    //'yards'=> 'Enter Distance',
                                    'percentage' => 'Enter Percentage'
                                );
                                $xx = $workout_description_array[strtolower($workout->measurement->name)];
                                $x = explode("|", $xx);
                                if(strtolower($workout->measurement->name) == 'distance'){
                                    echo $x[0].' Inch';
                                }else if(strtolower($workout->measurement->name) == 'time'){
                                    echo $x[0].' (example, a six minute run 6:00 should be converted to 360 seconds)';
                                }else{
                                    echo $x[0];
                                }
                                //if excese is already added and it it from ACI index
                                $disabled = "";
                                $unit_1 = "";
                                $required = "";
                                if($workout->is_aci_index == 1 && !empty($exercise)){
                                    //$disabled = "disabled";
                                    $unit_1 = $exercise->unit_1;
                                    $required = "";
                                }
                            ?>
                        </label>
                            <input type="number" min="1" step=".01" name="unit_1" 
                                value="{{ $unit_1 }}" 
                                class="form-control"
                                {{ $disabled }}
                                placeholder="20"
                                {{ $required }}
                            />
                        <span>
                            <b>
                                {{ucwords($workout->measurement->unit)}}
                            </b>
                        </span>
                        @if ($errors->has('unit_1'))
                            <span class="text-danger">{{ $errors->first('unit_1') }}</span>
                        @endif
                    </div>
                    @if(count($x) >1 )
                    <div class="form-group datrrecordtext">
                        <label>
                            {{$workout->measurement->name}}, 
                            @if(strtolower($workout->measurement->name) == 'distance')
                                    echo $x[1].' Inch';
                            @elseif(strtolower($workout->measurement->name) == 'time')
                                    echo $x[1].' (example, a six minute run 6:00 should be converted to 360 seconds)';
                            @else
                                    echo $x[1];
                            @endif
                        </label>
                        <input type="number" min="1" step=".01" name="unit_2" value="{{ old('unit_2') }}" class="form-control " placeholder="190" />
                        <span>
                            <b>
                                {{ucwords($workout->measurement->unit)}}
                            </b>
                        </span>
                        @if ($errors->has('unit_2'))
                            <span class="text-danger">{{ $errors->first('unit_2') }}</span>
                        @endif
                    </div>
                    @endif
                    <div class="clr"></div>
                    <div class="form-group">
                        <label>If you have recorded video evidence of your workout, copy the link of the video in the box provided:</label>
                        <input type="url" class="form-control" name="video" value="{{old('video')}}" placeholder="www.youtube.com/escf1"/>
                        @if ($errors->has('video'))
                            <span class="text-danger">{{ $errors->first('video') }}</span>
                        @endif
                    </div>
                    <input type="hidden" name="category_id" value="{{ $category_id }}">
                    <input type="submit" class="addhighlightsbtn" value="Update"/>
                </form> --}}
            </div>
            <div class="breanchpress_r">
                <h3>ACI Workouts</h3>
                <ul>
                    <li>Bench Press – 1 rep max</li>
                    <li>Squat – 1 rep max</li>
                    <li>Deadlift – 1 rep max</li>
                    <li>40 yard Dash</li>
                    <li>100m Dash</li>
                    <li>Standing Broad Jump</li>
                    <li>Standing Vertical Jump</li>
                    <li>5-10-5 Drill</li>
                    <li>L-Cone Drill</li>
                    <li>1 Mile Run</li>
                </ul>
                <a href="{{ route('aci-details') }}" target="_blank">Read More</a>
            </div>
            <div class="clr"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var workoutCategory = "";
    const savedWorkoutLibrary = [];
    $(function(){
        $('.datepicker').datepicker({
            maxDate: 0
        });
    })
    $(document).ready(function () {
        $('#frm-workout-exercise').submit(function (e) {
            e.preventDefault();
            // alert('hi');
            // die;
            
            var cat_id = {{ $workoutCategory->id }} ;
            var workout_id = {{ $workout->id }} ;
            let unit_1 = $('input[name="unit_1"]').val();
            // let unit_2= $('input[name="unit_2"]').val();
            if(unit_1 === '' ){
                swal('Please fill required values', 'Input Missing', 'warning');
                return false;
            }
            var dec = countDecimals(unit_1); 
            // if(unit_1 !== '' && cat_id == 8){
               
            //     // alert(dec);
            //     // die;
            //     if(dec !== 0){
            //         if(workout_id == 7 || workout_id == 6 || workout_id == 10 || workout_id == 43 || workout_id == 44 || workout_id == 69 || workout_id == 70 ){
            //             if(dec !== 2 && dec !== 0 ){
            //                 swal('Warning', 'Please enter a valid format, two decimal points only. Eg. 10.24','warning');
            //                 $('#unit_1_message').focus()
            //                 return false;
            //             }
            //         }
            //         else if(workout_id == 54 || workout_id == 55){
            //             if(dec !== 1 ){
            //                 swal('Warning', 'Please enter a valid format, one decimal points only. Eg. 15.6','warning');
            //                 $('#unit_1_message').focus();
            //                 return false;
            //             }
            //         }
            //         else if(workout_id == 76){
            //             if(dec !== 0 ){
            //             swal('Warning', 'Please enter a valid format, whole numbers only. Eg. 201','warning');
            //             $('#unit_1_message').focus();
            //             return false;
            //             }
            //         }
            //     }
            // }
            if(dec === 0){
                if(workout_id == 7 || workout_id == 6 || workout_id == 10 || workout_id == 43 || workout_id == 44 || workout_id == 69 || workout_id == 70 ){
                    unit_1 = parseFloat(unit_1).toFixed(2);
                }
                else if(workout_id == 54 || workout_id == 55){
                    unit_1 = parseFloat(unit_1).toFixed(1);
                }
                else if(workout_id == 76){
                    unit_1 = parseFloat(unit_1);
                }
            }
            else if(dec === 1){
                if(workout_id == 7 || workout_id == 6 || workout_id == 10 || workout_id == 43 || workout_id == 44 || workout_id == 69 || workout_id == 70 ){
                    unit_1 = parseFloat(unit_1).toFixed(2);
                }
                else if(workout_id == 76){
                    unit_1 =  parseInt(unit_1);
                }
            }
            else if(dec !== 0){
                if(workout_id == 76){
                    unit_1 =  parseInt(unit_1);
                }
            }

            swal({
                    title: "Are you sure?",
                    text: "Want to update exercise with current data",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        let fd = new FormData(this);
                        // let unit_1 = unit_1;
                        fd.append('unit_d', unit_1);
                        $.ajax({
                            type: "POST",
                            url: "{{ route('athlete.workouts.exercise', $workout->id) }}",
                            data: fd,
                            cache: false,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                                //$("#overlay").fadeIn(300);
                            },
                            success: function (res) {
                                console.log(res);
                                if (res.success) {
                                    swal(res.message, 'Success', 'success')
                                    .then(()=> {
                                        window.location.href = "{{ route('athlete.dashboard') }}";
                                    });
                                } else {
                                    swal(res.message, 'Warning', 'warning');
                                }
                            },
                            error: function (err) {
                                $.each(err.responseJSON.error, function(k, v){
                                    if(v.length){
                                        swal(v[0], 'Warning',
                                        'warning');
                                    }else{
                                        swal('Sorry!! Something went wrong', 'Warning',
                                        'warning');
                                    }
                                    return false;
                                })
                                
                            }
                        }).done(() => {

                        });
                    }
                });

        })
    })

    var countDecimals = function (value) {
    if(Math.floor(value) === value) return 0;
    if(Math.floor(value) != value){
    return value.toString().split(".")[1].length || 0; 
    }
    return 0;
    }


    // $( "#unit_1_message" ).one( "click", function() {
    //     var cat_id = {{ $workoutCategory->id }} ;
    //     var workout_id = {{ $workout->id }} ;

    //     if(cat_id == 8){
    //         if(workout_id == 7 || workout_id == 6 || workout_id == 10 || workout_id == 43 || workout_id == 44 || workout_id == 69 || workout_id == 70 ){
    //             swal('Warning', 'Please enter a valid format, two decimal points only. Eg. 10.24','warning');
    //         }
    //         else if(workout_id == 54 || workout_id == 55){
    //             swal('Warning', 'Please enter a valid format, one decimal points only. Eg. 15.6','warning');
    //         }
    //         else if(workout_id == 76){
    //             swal('Warning', 'Please enter a valid format, whole numbers only. Eg. 201','warning');
    //         }
    //     }
    //     $('#unit_1_message').focus();

      
    // });

</script>
@endsection
