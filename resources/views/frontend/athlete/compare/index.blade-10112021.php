@extends('frontend.athlete.layouts.app')
@section('title', 'Compare')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="tab-container" id="CompareAjax">  
				<div class="tab-menu">
					<a href="<?= url('athlete/new-athelete'); ?>" class="selectnewathletes">Select new athletes to compare</a>
					<ul>
						<li><a href="#" class="tab-a active-a" data-id="tab1">Saved Compare</a></li>
						<li><a href="#" class="tab-a " data-id="tab2">Athletes</a></li>
						<li><a href="#" class="tab-a" data-id="tab3">Groups</a></li>        
					</ul>
				</div>
				<?php
				$arr 	= [];
				$tmpArr	= [];
				?>
				<div  class="tab tab-active" data-id="tab1">
					<div class="table-responsive">
						<table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<th>Group Name</th>
								<th>No of Members</th>
								<th>Action</th>
							</tr>
							
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div> 

				<div  class="tab" data-id="tab2">
					<div class="table-responsive">
						<table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<th></th>
								<th>Athletes</th>
								<th>Rank</th>
								<th>Aci Index</th>
								<?php
								$flag = 0;
								if($workout_librarys):
									foreach($workout_librarys as $key => $workout_librarys):
										++$flag; 
										$arr[] =  $workout_librarys['workout_id'];
								?>
								<th> {{ $workout_librarys['title'] }}</th>	

								<?php endforeach; endif; ?>
							</tr>
							<?php
							$values = array();
							$rank=1;
							$compare_array = collect($compare_withs)->sortBy('aci_index')->reverse()->toArray();
							if(count($compare_array) > 0):
								foreach($compare_array as $key => $compare_list):

									print '<tr>
											<td><button data-id="'.$compare_list['id'] .'" class="btn-delete-row"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
											<td class="imagestable"><span><img src="'.(isset($compare_list["profile_image"])? asset($compare_list["profile_image"]) : asset("public/frontend/athlete/images/defaultuser.jpg")) .'" /></span><b>'. $compare_list["username"] .'</b></td>
											<td>'.$rank++ . '</td>
											<td>'.$compare_list['aci_index'] . '</td>';
									$temp_user = App\Models\UserWorkoutExercises::where('status', 1)
													->where('user_id', $compare_list['id'])
													->whereIn('workout_library_id', $arr)->get();
									if(count($temp_user) > 0):
										foreach($temp_user as $tu):
											$tmpArr[$tu->workout_library_id]	= $tu;
										endforeach;
									endif;
									if(!empty($arr)):
										foreach($arr as $a):
											print '<td>'. ((array_key_exists($a, $tmpArr)) ?  $tmpArr[$a]['unit_1'] : '0') .'</td>';
										endforeach;	
									endif;
									print '</tr>';
								endforeach;
							endif;
							?>
						</table>
					</div>
				</div>

				<div  class="tab" data-id="tab3">
					<div class="table-responsive">
						<table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<th>Group Name</th>
								<th>No of Members</th>
								<th>Action</th>
							</tr>
							@if($group)
							@foreach($group as $key => $groupdetails)
							<tr>
								<td>{{ $groupdetails->group_name }}</td>
								<?php 
		            $count_member = App\Models\TeamingGroupUser::where('teaming_group_id', $groupdetails->id)
		            ->get()->count();
		          ?>
								<td>{{ $count_member }}</td>
								<td><input type="checkbox" name="add_grp"  value="{{ $groupdetails->id }}" class="added_athbtn" ></td>
							</tr>
							@endforeach
							@endif
							<tr>
								<td colspan="4" ><button id="add_compare">Add</td>
							</tr>
						</table>
					</div>
				</div>    
			</div>


			<!-- Group view -->
			<div class="container">
			</div>
			<!-- End group view -->

			

		</div>
	</div>
</div>
</div>
<div class="clr"></div>
</div>





@endsection

@section('script')

<script>
	$(document).ready(function(){
            
            $('.btn-delete-row').on('click', function(){
               let id = $(this).data('id');
               console.log(id);
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
                            url: "{{url('athlete/delete-compare')}}"+"/"+id,
                            type:'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(data) {
                            	console.log(data);
                                swal(data.message,'Success', 'success')
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

            $('#add_compare').on('click', function(){
                var compare_grp = [];
            $.each($("input[name='add_grp']:checked"), function(){
                compare_grp.push($(this).val());
            });
            // alert(compare_grp);
            // alert("My favourite sports are: " + favorite);
                        $.ajax({
                            url: "{{url('athlete/compare-group')}}"+"/"+compare_grp,
                            type:'POST',
                            data: {
                                // "compare_grp" : compare_grp,
                                "_token" : "{{ csrf_token() }}",
                            },
                            success: function(data) {

								        $('.container').html(data.html);
								        $('#CompareAjax').hide();
                        	}
                        });
            });
        })
</script>
@endsection
