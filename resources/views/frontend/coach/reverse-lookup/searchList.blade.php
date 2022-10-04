@extends('frontend.coach.layouts.app')
@section('title', 'Reverse Lookups')
@section('content')
<?php 
use App\Models\Compare;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
                                        <th>Private or Public</th>
                                        <th>Follow?</th>
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


                                           if($item_value->profile_type==1){
                                            $profile_type="Public";
                                        }else{
                                            $profile_type="Private";
                                        }

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
                                        <td><?= @$profile_type ?></td>
                                        <td></td>
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
                                foreach($user_lookup as $key => $item_value){ 
                                    $WorkoutExercise =DB::table('user_workout_exercise_logs')
                                    ->select('unit_1', 'record_date')
                                    ->where('user_id', $item_value->user_id )
                                    ->where('workout_library_id', $item_value->workout_library_id )
                                    ->orderBy('id', 'DESC')
                                    ->first();

                                    array_push($record_date_array, $WorkoutExercise->record_date);                     

                                }

                                $new_lookup=array();

                                foreach($user_lookup as $key => $new){
                                   $user_lookup[$key]->rdate = $record_date_array[$key];                                   
                               }

                               foreach ($user_lookup->sortByDesc('rdate') as $item_value){
                                $WorkoutExercise =DB::table('user_workout_exercise_logs')
                                ->select('unit_1', 'record_date')
                                ->where('user_id', $item_value->user_id )
                                ->where('workout_library_id', $item_value->workout_library_id )
                                ->orderBy('id', 'DESC')
                                ->first();

                                if($item_value->profile_type==1){
                                    $profile_type="Private";
                                }else{
                                    $profile_type="Public";
                                }

                                $exist_follower_user = App\Models\Follower::where('status', '!=' , 3)->where('user_id', Auth()->user()->id)->where('follower_id',$item_value->user_id)->first(); 

                               
                                $is_follow=0;
                                $req_status=0;
                                if($exist_follower_user){
                                    $is_follow=1;
                                    if($exist_follower_user->status==2){
                                        $req_status=1;
                                    }
                                }

                                ?>
                                
                                <tr>

                                    <td><?= @$cnt++ ?></td>
                                    <td>
                                        <?php 
                                    if($req_status==1 || @$item_value->profile_type==0){ ?>
                                        <a href="{{ url('athlete-profile/'.$item_value->user_id.'/'.'coach') }}" > 
                                            <?= @$item_value->username ?>
                                        </a> 
                                        <?php }else{ ?> 
                                        <a href="#" onclick="private_msg()">
                                            <?= @$item_value->username ?>
                                        </a>  
                                        <?php }?>       
                                    </td>

                                    <td>

                                        <?= @$workout->title ?> 
                                    </td>
                                    <td> <?= @$profile_type ?></td>
                                   
                                   <?php if($is_follow==1){?>
                                     <td><input type="button" id="followers" data-athleteid="<?= $item_value->user_id ?>"
                                        class="followbtn_new followers" value="Follow" style="background:#dd6565 !important" disabled /></td>
                                    <?php }else{?>
                                       <td><input type="button" id="followers" data-athleteid="<?= $item_value->user_id ?>"
                                        class="followbtn_new followers" value="Follow" /></td>
                                    <?php }?>


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



                            <?php } }else{ ?>
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
@section('script')
<script>
    $(document).ready(function() {
        $('.followers').on('click', function() {
            var follower_id = $(this).data('athleteid');
            
            $.ajax({
                type: "POST",
                url: "{{ route('coach.add-follow') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    follower_id: follower_id
                },
                dataType: "JSON",
                beforeSend: function() {

                },
                success: function(res) {
                    if (res.success) {
                        swal(res.message, 'Success', 'success')
                        .then(() => {
                            location.reload();
                        });
                    }
                }
            });
        });
    });

     function private_msg(){        
        swal( "You cannot open a 'Private Profile' until your 'Follow' request has been accepted.", ' ', 'warning');
        return false;
    }

</script>
@endsection
