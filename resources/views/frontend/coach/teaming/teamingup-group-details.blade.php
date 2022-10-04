@extends('frontend.coach.layouts.app')
@section('title', 'TeamingUPTM Group')
@section('content')
<?php 
use App\Models\User;
use App\Models\UserWorkoutExercises;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategory;


use App\Models\TeamingGroupUser;

use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutCategoryLibrary;
use App\Models\Country;
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="teamingupdetails">
				<div class="row">
					<div class="col-md-4 col-sm-12 col-xs-12">
						<div class="teamingupdetails_l">
							<div class="TeamingUPbox">
								<div class="TeamingUPbox_img">
									@if($group_detail->image!="") 
									<img src="{{ asset($group_detail->image) }}" alt="team_img"/>
									@else
									<img src="{{ asset('public/frontend/athlete/images/teamingup_img.png') }}" alt="teamingup_img">
									@endif
								</div>
								<div class="TeamingUPbox_text">
									<h3>{{ $group_detail->group_name }}</h3>
									
									<p>{{ $group_detail->description }}</p>
								</div>
							</div>
<div class="teamingupdetails_l_member">
	<h3>Members</h3>
	<ul>
		<li><a href="{{ route('coach.teamingup-group-details.add-mamber',$group_detail->id) }}"><img src="{{ asset('public/frontend/athlete/images/add_member.png') }}" alt="add_member"/> Add members</a></li>
		<li><a href="javascript:void(0);" data-toggle="modal" data-target="#invitealink"><img src="{{ asset('public/frontend/athlete/images/invite_link_icon.png') }}" alt="invite_link_icon"/> Invite via link</a></li>
		<li>
			<a href="javascript:void(0);"><span class="adminimgbox"><i></i>		
				@if(@$creator->profile_image!="") 
				<img src="{{ asset($creator->profile_image) }}" alt="team_img"/>
				@else
				<img src="{{ asset('public/frontend/images/noimage.png') }}" alt="user_img"/>
				@endif
			</span>
			{{ @$creator->username }}  <em></em> <b>Admin</b></a>
		</li>
		<?php if($group_detail->created_by== Auth()->user()->id ||in_array(Auth()->user()->id, $group_admin)){?>

		<li><a href="{{ route('coach.edit-teamingup-group',$group_detail->id) }}"><img src="{{ asset('public/frontend/athlete/images/edit_icon.png') }}" alt="edit_group"/> Edit Group</a></li>

		<li><a href="javascript:void(0)" onclick="deleteGroup(<?= @$group_detail->id ?>)"><img src="{{ asset('public/frontend/athlete/images/delete_icon.png') }}" alt="delete_group"/>Delete Group</a></li>

	<?php }if($group_detail->created_by!= Auth()->user()->id){ ?>
		<li><a href="javascript:void(0)" onclick="exitGroup(<?= @$group_detail->id ?>)"><img src="{{ asset('public/frontend/images/exit-icon.jpg') }}" alt="delete_group"/>Exit Group </a></li>

	<?php } ?>
	<li><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal"><img src="{{ asset('public/frontend/athlete/images/invite_link_icon.png') }}" alt="invite_link_icon"/>Edit library</a></li>
		
		</ul>
	</div>

</div>
</div>
<div class="col-md-8 col-sm-12 col-xs-12">
	<div class="teamingupdetails_r">
		<h2>Comparison
		<a href="javascript:void(0)" id="compare_now_group" data-toggle="modal"
                    class="selectnewathletes event_details" style="position: relative;
                        right: 0;
                        top: 3px;
                        margin-left: 20px;
                    ">Compare Now</a></h2>
		<div class="table-responsive">
			<table class="tabtable teamingupdetailstable" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<?php if($group_detail->created_by== Auth()->user()->id  || in_array(Auth()->user()->id, $group_admin)){?>
						<th></th>
						<th></th>
					<?php }?>
					<th style="width:20%">Athletes</th>
					<th>Rank</th>
					<?php foreach($workout as $tw){
						// print_r($tw);
						// die;
						$team_workout= WorkoutLibrary::select('title')->where('id', @$tw->workout_id)->first();
						
						$team_workout_category= WorkoutCategory::select('category_title')->where('id', @$tw->category_id)->first();
						
						// workout_category
						// category_id
						?>
						<th><span style="color:rgb(255 213 0)">{{ $team_workout_category->category_title }}</span><?php echo $team_workout->title; ?></th>
					<?php } ?>

				</tr>
				<?php if($group_user){
					foreach($group_user as $value){
						$user_detail = User::where('id', @$value->user_id)->first();
						if(in_array($value->user_id, $group_admin)){
							$admintxt= "Group Admin";
							$toggle = "checked";
						}else{
							$admintxt= "Make Group Admin";
							$toggle= "";
						}				

						?>
						<tr>
							<?php if($group_detail->created_by== Auth()->user()->id ||  in_array(Auth()->user()->id, $group_admin)){?>
								<td><i class="fa fa-trash-o delete-connection" data-id="{{ $value->id }}"  aria-hidden="true"></i></td>
								<td ><span class="admintxt"><?= @$admintxt ?></span>

								<input type="checkbox" name="profile_type" id="toggle_<?= @$user_detail->id ?>" class="chkbx-toggle" value="1" onchange="makeAdmin(this,<?= @$user_detail->id ?>,<?= $group_detail->id ?>)" <?= @$toggle ?>>
                        <label for="toggle_<?= @$user_detail->id ?>"></label>
									

								</td>
							<?php }?>
							<td class="imagestable">
								<span>

									@if($user_detail->profile_image!="") 
									<img src="{{ asset($user_detail->profile_image) }}" alt="team_img"/>
									@else
									<?php $uname = explode(" ", $user_detail->username);
									$fname= $uname[0];
									$lname= @$uname[1];

									?>
									<div class="pro-team"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>
									@endif

								</span><b>{{ @$user_detail->username}}</b></td>
								<td>1</td>

								<?php foreach($workout as $tw){
									// echo "<pre>";
									// 	print_r($tw); die;
									$workout_val= UserWorkoutExercises::select('unit_1')->where('user_id', @$value->user_id)->where('category_id', @$tw->category_id )->where('workout_library_id', @$tw->workout_id)->first();

									?>
									<td><?php echo @$workout_val->unit_1; ?></td>
								<?php } ?>

	
							</tr>
						<?php }} ?>
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
<input type="hidden" id="baseUrl" value="<?= url(''); ?>">
<div class="clr"></div>
</div>

{{-- workout category library --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="headTitle" style="color: white;">Select workout you want to use for comparison ?</h5>
                <button type="button" class="close close_relode" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="container-fluid">
					<form action="{{ url('coach/add-group-library/').'/'.$group_detail->id }}" method="POST" id="form-workout-library">
						@csrf
					
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">

                            <div id="workout_l_box12" class="popupcompareleftbox tab-menu02">
                            <?php foreach($allWorkoutCategory as $key => $category_value){ 

                            ?> 
                                <div class="workout_l_box workout-category tab-a02 active-a02" data-id="tab{{$key+1}}">
                                    <img src="{{  asset($category_value->image) }}" alt="workout_img" />
                                    <span>{{ $category_value->category_title }}</span>
                                </div>
                            <?php } ?>

                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="workout_right">
                                <div class="workout_right_r comparepopupdesign" id="workout-librarys">
                                   
                                    
                                        <div id="workout_library_scroll" class="popupcomparerightbox">
            
                                   
                                            <div class="signinbox" id="workouts-category-library123">
                                                <?php 
                                                 foreach($allWorkoutCategory as $key => $workOutValue){    
                                                    $workout_library = WorkoutCategoryLibrary::where('workout_category_id', $workOutValue['id'])->get()->pluck('workout_library_id');
     
                                                    $data = [];
                                                        if(count($workout_library) > 0){
                                                            $data = WorkoutLibrary::where('status', 1)->whereIn('id', $workout_library)->get();
                                                        }else{
                                                            $data = WorkoutLibrary::where('status', 1)->get();
                                                        }
                                                ?>
                                                <div class="tab02 {{$key== 0 ? 'tab-active02' : '' }}" data-id="tab{{$key+1}}">
                                               

                                                        @foreach($data as $key_val => $data_value)
                                                            <?php 
                                                            $workout_library_id_only = WorkoutCategoryLibrary::where('workout_category_id', $workOutValue['id'])->where('workout_library_id', $data_value->id)->get()->pluck('id');
                                                          
                                                            ?>
                                                            <div class="signinboxinput">
                                                                <div class="accout5_radio">
                                                                    <span>{{ $data_value->title }}</span>
                                                                    <div class="accout5_checkright">
                                                                        <div class="form-group" style="display: <?=$data_value->is_aci_index == 1 &&  $workOutValue['id'] !=8  ? 'none' : '' ;?>">
                                                                            <input type="checkbox" name="workout_cat_library_array[]" id="accountcheckbox{{$key+1}}{{$key_val}}" value="{{$workout_library_id_only[0]}}" <?=in_array($workout_library_id_only[0] , $category_library_id_array) ? 'checked'  : '' ;?>>
                                                                            <label for="accountcheckbox{{$key+1}}{{$key_val}}"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                </div>
                                                <?php 
                                                }
                                                ?>
                                                
                                            </div>  
                                        </div>
                                    
                                </div>
                                <div class="clr"></div>
                            </div>
                            
                        </div>
                    </div>
                    <div align="center" id="" style="margin-top:20px;">
                        <button type="submit" id="library" class="addyourdashboard mb-3">Submit</button>
                    </div>
					</form>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="invitealink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">      
			<div class="modal-body">
<!--
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    -->
    <h3>Invite Via Link</h3>
    <p>Anyone can follow this link to join this group with the access code</p>
    <div class="invitepopupbox">
    	<div class="invitepopupbox_l popupsharemodal_l">    		
    		@if($group_detail->image!="") 
    		<img src="{{ asset($group_detail->image) }}" alt="team_img"/>
    		@else
    		<img src="{{ asset('public/frontend/athlete/images/teamingup_img.png') }}" alt="teamingup_img">
    		@endif
    	</div>
    	
    	<div class="invitepopupbox_r popupsharemodal_r">
    		<h4>Group link</h4>
    		<?php $name_slug= str_replace(' ', '-', @$group_detail->group_name); ?>
    		
    		 <p id="link-text"><?php echo url('/coach/teamingup-group-details/'. $group_detail->id.'/?group-name='.@$name_slug);?></p>
    		
    	</div>
    	<div class="clr"></div>
    </div>
    <input type="hidden" name="hidden_link" value="<?php echo url('/coach/teamingup-group-details/'. $group_detail->id);?>" id="group_link">
    <ul>
    	<li><a href=""><img src="{{ asset('public/frontend/athlete/images/sendlink.png') }}" alt="sendlink"/> Send link via chat</a></li>
    	<li  onclick="copyToClipboard()"><a href="javascript:void(0)"><img src="{{ asset('public/frontend/athlete/images/copylink.png') }}" alt="copylink"/  > <p id="copy_txt" style="display: inline-block;
    	padding: 0;
    	font-size: 16px">Copy link </p></a></li>
    	<li ><a href="javascript:void(0)"><img src="{{ asset('public/frontend/athlete/images/harelink.png') }}" alt="harelink"/> <div class="sharethis-inline-share-buttons" style="display: inline-block;
    	padding: 0;
    	font-size: 16px"></div></a></li>    	

    </ul>
    <div align="center"><button type="button" class="invitelinkbtn" data-dismiss="modal">Cancel</button></div>
</div>      
</div>
</div>
</div>

<!-- compare Modal -->
<div class="modal fade" id="comparemodaldetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog filterpopup" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
				{{-- <form action="" method="post"> --}}
					{{-- @csrf --}}
					<div class="eventsdetailspage">
						<h5>Comparison Name</h5>
						<input type="text" class="form-control" name="comparison_name" id="comparison_name">
						<input type="hidden" id="group_id" name="group_id" value="<?php echo $group_detail['id'] ; ?>">
						{{-- <div>
							<h3>Athelatic members</h3>
							<div class="" id="grp_member">
								<!-- <div class="grp_member2">SK</div> -->
							</div>
						</div> --}}
						<input type="submit" class="addhighlightsbtn" id="addhighlightsbtn" name="submit" id="comparison_save" value="submit">
					</div>
				{{-- </form> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
	function copyToClipboard() {

		document.getElementById("group_link").select();
		
		document.execCommand('copy');
		document.getElementById("copy_txt").innerHTML = "Copied!";
		return false;

	}

	$('.delete-connection').on('click', function(){
		let id = $(this).data('id');
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this data!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					
					url: "{{ url('coach/delete-member') }}"+"/"+id,
					
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
	});


	function deleteGroup(groupId){
		let baseUrl = $('#baseUrl').val();		
		let id = groupId;
	
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this group!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					
					url: "{{ url('coach/delete-group') }}"+"/"+id,
					
					type:'get',
					data: {
						"_token": "{{ csrf_token() }}",
					},
					success: function(data) {						
						swal(data.message, 'success')
						.then( () => {
							window.location.href = baseUrl+"/coach/teamingup-group";
							//location.reload();
						});
					}
				});
			}else{
				return false;
			}
		});
	}

	function exitGroup(groupId){
		let baseUrl = $('#baseUrl').val();		
		let id = groupId;
	
		swal({
			title: "Are you sure want to exit?",
			//text: "Once deleted, you will not be able to recover this group!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					
					url: "{{ url('coach/exit-group') }}"+"/"+id,
					
					type:'get',
					data: {
						"_token": "{{ csrf_token() }}",
					},
					success: function(data) {						
						swal(data.message, 'success')
						.then( () => {
							window.location.href = baseUrl+"/coach/teamingup-group";
							//location.reload();
						});
					}
				});
			}else{
				return false;
			}
		});

	}

	function makeAdmin(dis,userId, groupId){		
		var textval= $(dis).parent('td').find('.admintxt').text();
		
		if(textval=="Make Group Admin"){
			$(dis).parent('td').find('.admintxt').text('Group Admin');
			var action="create";
		}else{
			$(dis).parent('td').find('.admintxt').text('Make Group Admin');
			var action="remove";
		}
		swal({
			title: "Are you sure?",
			//text: "Once deleted, you will not be able to recover this group!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willAdmin) => {
			if (willAdmin) {
				$.ajax({
					
					url: "{{ url('coach/create-group-admin') }}",					
					type:'POST',
					data: {
						 userId: userId,
						 groupId: groupId,
						 action:action,
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
	//}
}

	//==


</script>
<script type='text/javascript'>
$(document).ready(function() {
	$('#compare_now_group').on('click', function() {
		// var compare_name = [];
		// $.each($("input[name='add_group_compare']:checked"), function() {
		// 	compare_name.push($(this).attr('data-p'));
		// });
		// if (compare_name == "") {
		// 	swal({
		// 		text: "Please add minimum one Group!",
		// 		icon: "warning",
		// 		dangerMode: true,
		// 	})
		// 	return false;
		// }
		// $('#grp_member1').empty();
		// $.each(compare_name, function(key, value) {
		// 	$('#grp_member1').append(`
		// 			<div class="grp_member2">` + value + `
		// 			</div>`);
		// });
		$('#comparemodaldetails').modal('show');
	});

	$('#addhighlightsbtn').on('click', function() {
        var comparison_name = $("#comparison_name").val();
        var group_id = $("#group_id").val();

		if(comparison_name == ''){
			swal({
			title: "Please enter comparison name?",
			//text: "Once deleted, you will not be able to recover this group!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
			return true;
		}

        $.ajax({
            url: "{{url('coach/comparison-group-add')}}",
            type: 'POST',
            data: {
                "comparison_name": comparison_name,
                "group_id": group_id,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                swal(data.message, 'Success', 'success')
                    .then(() => {
                        location.reload();
                    });
            }
        });
    });
});
</script>

<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=61793bd54bdfd50012dd5ded&product=inline-share-buttons" async="async"></script>

@endsection
