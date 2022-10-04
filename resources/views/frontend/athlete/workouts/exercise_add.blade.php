@extends('frontend.athlete.layouts.app')
@section('title', 'Workouts Exercise')
@section('content')
<div class="createteamingup">
    <div class="container-fluid">
        <div class="addgamehighlightes">
            <div class="addgamehighlightesinner breanchpress_l">
                <h3 style="display: flex;justify-content: space-between;">
                    <div>Video Evidence</div>
                    <div style="padding: 8px; color: black; background: #FFD500;min-width: 204px;text-align: center;">{{$workoutCategory->category_title}}</div>
                </h3>
                <h3>
                    {{ !empty($workout->sport_category_title) ?
                     ucwords($workout->sport_category_title) :
                      ucwords($workout->title) }} 
                   {{ $workoutCategory->category_title == 'ACI(TM) workouts' ? ($workoutCategory->category_title) : '' ; }} - 
                   <?php
                    if($workoutCategory->category_title == 'ACI(TM) workouts'){ 
                        if($workout->measurement->name == 'Reps'){
                          echo '1 Rep Max';  
                        }
                        elseif($workout->measurement->name == 'Time' ){
                            echo 'Time (seconds)';
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
                else {  
                        if($workoutCategory->category_title == 'Explosiveness'){
                            if($workout->title == 'Vertical Jump' || $workout->title == 'Box Jump' ||  $workout->title == 'Single Leg Box Jump'){
                                echo 'Height (inches)';
                            }
                            elseif($workout->title == 'Prowler Push'){
                                echo '15 Yards';
                            }
                            elseif($workout->measurement->name == 'time'){
                                echo 'Time (seconds)';
                            }
                            elseif($workout->measurement->name == 'Reps'){
                                echo  '1 Rep Max';
                            }
                            elseif($workout->measurement->name == 'Distance'){
                                echo 'Distance (inches)';
                            }
                            else{
                                echo $workout->measurement->name;
                            }
                        }
                        elseif($workoutCategory->category_title == 'Agility'){
                            if($workout->title == '60 Second Mini Hurdle Jump Test' || $workout->title == '30 Second Mini Hurdle Jump Test'){
                                echo 'Jumps (#)';
                            }
                            elseif($workout->measurement->name == 'time'){
                                echo 'Time (seconds)';
                            }
                            elseif($workout->measurement->name == 'Time'){
                                echo 'Time (seconds)';
                            }
                            elseif($workout->measurement->name == 'Reps'){
                                echo  'Weight Lifted';
                            }
                            elseif($workout->measurement->name == 'Distance'){
                                echo 'Distance (inches)';
                            }
                            else{
                                echo $workout->measurement->name;
                            }
                        }
                        elseif($workoutCategory->category_title == 'Sport Specific Workouts'){
                            if($workout->title == 'Vertical Jump' || $workout->title == 'Box Jump' || $workout->title == 'Single Leg Box Jump'){
                                echo 'Height (inches)';
                            }
                            elseif($workout->measurement->name == 'time'){
                                echo 'Time (seconds #.##)';
                            }
                            elseif($workout->measurement->name == 'Time'){
                                echo 'Time (seconds #.##)';
                            }
                            elseif($workout->measurement->name == 'Reps'){
                                echo  'Weight Lifted';
                            }
                            elseif($workout->measurement->name == 'Distance'){
                                echo 'Distance (inches)';
                            }
                            else{
                                echo $workout->measurement->name;
                            }
                        }
                        elseif($workout->title == 'Pull Ups' ||  $workout->title =='Push Ups' || $workout->title =='Sit Ups' ||  $workout->title == 'Lunges' || $workout->title == 'Chin Ups'){
                           echo  'Reps';
                        }
                        elseif($workout->measurement->name == 'Reps' && $workout->title != 'Pull Ups' &&  $workout->title !='Push Ups' ){
                          echo '10 Reps';  
                        }
                        elseif($workout->measurement->name == 'Time' ){
                            echo 'Time (seconds)';
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
                                    //'yards'=> 'Enter Distance',
                                    'percentage' => 'Enter Percentage',
                                    'weight' => ''
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
                           <!--  <th>
                                <?php
                    if($workoutCategory->category_title == 'ACI(TM) workouts'){ 
                        if($workout->measurement->name == 'Reps'){
                          echo 'Weight Lifted';  
                        }
                        elseif($workout->measurement->name == 'time' ){
                            echo 'Time (seconds #.##)';
                        }
                        elseif($workout->measurement->name == 'Time' ){
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
                else { 
                        if($workoutCategory->category_title == 'Strength'){
                            if($workout->title == 'Pull Ups' || $workout->title =='Push Ups' ||  $workout->title =='Sit Ups' || $workout->title == 'Chin Ups' || $workout->title == 'Lunges' ){
                               echo  'Number of Reps';
                            }
                            elseif($workout->measurement->name == 'Reps'){
                                echo  'Weight Lifted';
                            }
                            else{
                                echo $workout->measurement->name;
                            }
                        }

                        elseif($workoutCategory->category_title == 'Agility'){
                            if($workout->title == '60 Second Mini Hurdle Jump Test' || $workout->title == '30 Second Mini Hurdle Jump Test'){
                                echo 'Jumps';
                            }
                            elseif($workout->measurement->name == 'time'){
                                echo 'Time (seconds #.##)';
                            }
                            elseif($workout->measurement->name == 'Reps'){
                                echo  'Weight Lifted';
                            }
                            elseif($workout->measurement->name == 'Distance'){
                                echo 'Distance (inches)';
                            }
                            else{
                                echo $workout->measurement->name;
                            }
                        }

                        elseif($workoutCategory->category_title == 'Explosiveness'){
                            if($workout->title == 'Vertical Jump' || $workout->title == 'Box Jump' || $workout->title == 'Single Leg Box Jump'){
                                echo 'Height (inches)';
                            }
                            elseif($workout->title == 'Prowler Push'){
                                echo 'Weight Lifted';
                            }
                            elseif($workout->measurement->name == 'time'){
                                echo 'Time (seconds #.##)';
                            }
                            elseif($workout->measurement->name == 'Time'){
                                echo 'Time (seconds #.##)';
                            }
                            elseif($workout->measurement->name == 'Reps'){
                                echo  'Weight Lifted';
                            }
                            elseif($workout->measurement->name == 'Distance'){
                                echo 'Distance (inches)';
                            }
                            else{
                                echo $workout->measurement->name;
                            }
                        }

                        elseif($workoutCategory->category_title == 'Sport Specific Workouts'){
                            if($workout->title == 'Vertical Jump' || $workout->title == 'Box Jump' || $workout->title == 'Single Leg Box Jump'){
                                echo 'Height (inches)';
                            }
                            elseif($workout->measurement->name == 'time'){
                                echo 'Time (seconds #.##)';
                            }
                            elseif($workout->measurement->name == 'Time'){
                                echo 'Time (seconds #.##)';
                            }
                            elseif($workout->measurement->name == 'Reps'){
                                echo  'Weight Lifted';
                            }
                            elseif($workout->measurement->name == 'Distance'){
                                echo 'Distance (inches)';
                            }
                            else{
                                echo $workout->measurement->name;
                            }
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
                            </th> -->
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
                     <th>Url of Video Evidence</th>
                      <th>Action</th>
                    </tr>
                    <?php 
                    foreach ($userWorkoutExercises as  $logvalue) { ?>
                    <tr>
                        <td><?= date('m/d/Y', strtotime($logvalue->record_date)); ?></td>
                       <!--  <td><?= $logvalue->unit_1 ?></td> -->
                        {{-- @if(count($x) >1 )
                        <td><?= $logvalue->unit_2 ?></td>
                        @endif --}}
                        <td><a href=""><?= $logvalue->video ; ?></a></td>
                        <td onclick="deleteVideo(<?= @$logvalue->id ?>)"><img src="{{ asset('public/frontend/athlete/images/delete_icon.png') }}" alt="delete_group"/></td>
                    </tr>
                    <?php

                    }
                    ?>

                    <form id="frm-workout-exercise" action="" method="POST" >
                        @csrf
                    <tr>
                        <td><input type="text" class="form-control datepicker" name="record_date" 
                            value="" placeholder="MM-DD-YYYY" 
                            required autocomplete="off"
                            />
                        </td>
                        <!-- <td><input type="number" min="1" autocomplete="off" step=".01" name="unit_1" 
                            value="{{ $unit_1 }}" 
                            class="form-control"
                            {{ $disabled }}
                            placeholder=""
                            {{ $required }}
                        />
                        </td> -->
                        {{-- @if(count($x) >1 )
                        <td><input type="number" autocomplete="off" min="1" step=".01" name="unit_2" value="{{ old('unit_2') }}" class="form-control " placeholder="" />
                        </td>
                        @endif --}}
                         <td><input type="url" autocomplete="off" class="form-control" name="video" value="{{old('video')}}" placeholder="www.youtube.com/escf1"/></td>
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
            let unit_1 = $('input[name="unit_1"]').val();
            let unit_2= $('input[name="unit_2"]').val();
            if(unit_1 <= 1 && unit_2<= 1){
                swal('Please fill required values', 'Input Missing', 'warning');
                return false;
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
                        let unit_1 = $('input[name="unit_1"]').val();
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

//==
function deleteVideo(videoId){
            
        let id = videoId;
    
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this video!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    
                    url: "{{ url('athlete/delete-video') }}"+"/"+id,
                    
                    type:'get',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {                       
                        swal(data.message, 'success')
                        .then( () => {
                            
                            location.reload();
                        });
                    }
                });
            }else{
                return false;
            }
        });
    }
</script>
@endsection
