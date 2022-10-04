@extends('frontend.coach.layouts.app')
@section('title', 'Reverse Lookups')
@section('content')
<?php 
use App\Models\Compare;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\DB;
//use DB;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                    <div class="addathe_box_l">
                        <h4>{{ @$reverse_lookup_name }}</h4>
                    </div>
                </div>
                <!-- <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                    <div class="addathe_box_r">
                        <a href="{{route('coach.add-reverse-lookup')}}" class="criteriabtn">Add criteria</a>
                    </div>
                </div> -->
            </div>
            <div>

                <div class="dashtabletab" style="margin-top:0;">
                    <div class="tab-container">

                        <!-- <div class="tab-menu2">
                            <ul>
                                <li><a href="#" class="tab-a2 active-a2" data-id="tab1">{{ @$reverse_lookup_name }} </a></li>

                            </ul>
                        </div> -->

                        <div  class="tab1z tab-active2" data-id="tab1">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" width="100%" class="coachdashtable reversetable">
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Workout Name</th>
                                        <th>Current Workout Entry Stat</th>
                                        <th>Entry date</th>
                                        <th>Graduation Year</th>
                                        <th>Birth Year</th>
                                        <th></th>
                                    </tr>

                                    <?php $cnt=1;
                                    if(count($new_user_lookup)>0 || count($user_lookup) >0){
                                        foreach($new_user_lookup as $key => $item_value){ 

                                         $WorkoutExercise =DB::table('user_workout_exercise_logs')
                                         ->select('unit_1', 'record_date')
                                         ->where('user_id', $item_value->user_id )
                                         ->where('workout_library_id', $item_value->workout_library_id )
                                         ->orderBy('id', 'DESC')
                                         ->first();

                                         ?>
                                         <tr>

                                            <td><?= @$cnt++ ?></td>
                                            <td>
                                               <a href="{{ url('athlete-profile/'.$item_value->user_id.'/'.'coach') }}" > 

                                                <?= @$item_value->username ?> (New)
                                            </a>
                                        </td>
                                        <td>

                                            <?= @$workout->title ?> 
                                        </td>
                                        <td>

                                            <?= @$WorkoutExercise->unit_1 ?> 
                                        </td>
                                        <td>
                                            <?= @date('m/d/Y', strtotime($WorkoutExercise->record_date)) ?> 
                                        </td>
                                        <td>

                                            <?= @$item_value->graduation_year ?> 
                                        </td>
                                        <td>

                                            <?= @$item_value->year ?> 
                                        </td>

                                    </tr>
                                <?php }
                                 $record_date_array= array();

                                 $lookup_arr= array();
                                foreach($user_lookup as $key => $item_value){ 
                                    $WorkoutExercise =DB::table('user_workout_exercise_logs')
                                    ->select('unit_1', 'record_date')
                                    ->where('user_id', $item_value->user_id )
                                    ->where('workout_library_id', $item_value->workout_library_id )
                                    ->orderBy('id', 'DESC')
                                    ->first();                                       
                                   
                                         
                                    array_push($record_date_array, $WorkoutExercise->record_date);

                                     
                                   
                                }
                                 //print_r($lookup_arr);exit;

                                 $arr = $record_date_array;    
                                 function date_sort($a, $b) {
                                    return strtotime($b) - strtotime($a);
                                }
                                usort($arr, "date_sort");
                                /*echo $arr[0];
                                print_r($arr);exit;*/
                                $count=0;
                                $n=0;

                                    //====
                                    foreach($user_lookup as $key => $item_value){ 
                                    $WorkoutExercise =DB::table('user_workout_exercise_logs')
                                    ->select('unit_1', 'record_date')
                                    ->where('user_id', $item_value->user_id )
                                    ->where('workout_library_id', $item_value->workout_library_id )
                                    ->orderBy('id', 'DESC')
                                    ->first();
                                    echo $arr[0];
                                    for($i=0; $i<count($arr); $i++){
                                    if($WorkoutExercise->record_date== $arr[$i] ){
                                                                           

                                         
                                    

                                    ?>
                                    <tr>

                                        <td><?= @$cnt++ ?></td>
                                        <td>
                                            <a href="{{ url('athlete-profile/'.$item_value->user_id.'/'.'coach') }}" > 

                                                <?= @$item_value->username ?>
                                            </a>          
                                        </td>
                                        <td>

                                            <?= @$workout->title ?> 
                                        </td>
                                        <td>

                                            <?= @$WorkoutExercise->unit_1 ?> 
                                        </td>
                                        <td>
                                            <?= @date('m/d/Y', strtotime($WorkoutExercise->record_date)) ?> 
                                        </td>
                                        <td>

                                            <?= @$item_value->graduation_year ?> 
                                        </td>
                                        <td>

                                            <?= @$item_value->year ?> 
                                        </td>

                                    </tr>



                                <?php    }
                               //unset($arr[$i]);
                              
                              // print_r($arr);exit;
                               //echo count($arr);exit;
                                 }}}else{ ?>
                                 <tr>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>No Result Found!!</td>

                                </tr> 



                            <?php } ?>


                        </table>
                    </div>
                </div>
            </div>

        </div>


    </div>


</div>
</div>
</div>
</div>
<div class="clr"></div>
</div>

@endsection

