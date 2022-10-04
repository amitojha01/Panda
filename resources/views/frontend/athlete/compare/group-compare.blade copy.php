@extends('frontend.athlete.layouts.app')
@section('title', 'Compare')
@section('content')
<?php  $segment1 =  Request::segment(3);  ?>
<?php 
// echo "<pre>";
// echo $wrk_fill;

// print_r($compare_withs)
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="tab-container" id="CompareAjax">  
				<div class="tab-menu">
					<a href="{{ url('athlete/compare') }}" class="backtocompare">Back</a>
					<a href="{{ url('athlete/new-athelete/'.$segment1) }}" class="selectnewathletes">Select new athletes to compare</a>
					<ul>
						<li><a href="#" class="tab-a active-a" data-id="tab1">Athletes</a></li>
						<!-- <li><a href="#" class="tab-a" data-id="tab2">Groups</a></li>         -->
					</ul>
				</div>
				<div  class="tab tab-active" data-id="tab1">
					<div class="table-responsive">
						<table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<th></th>
								<th>Athletes</th>
								<th>Rank</th>
								<th>% Rank</th>
								<th class="talehighlightedcompare">Aci Index</th>
								<?php
								$flag = 0;
								$arr = [] ; 
								if($workout_librarys):
									foreach($workout_librarys as $key => $workout_librarys1):
										++$flag; 
										$arr[] =  $workout_librarys1['workout_id'];
								?>
								<th><a href="{{ url('athlete/comparison-details/'.$group_id.'/'.$workout_librarys1['workout_id']) }}">{{ $workout_librarys1['title'] }}</a></th>	

								<?php endforeach; endif; ?>
							</tr>
							<?php
							$values = array();
							$rank=1;
							$pos=1;

							$compare_array = $compare_withs;
							
							if(count($compare_array) > 0):
								foreach($compare_array as $key => $compare_list):
								$newpos = $pos++;
								$per = ($newpos == 1) ? ((1*1)*99) : ((1-($newpos/count($compare_array)))*100);
									print '<tr id="'.(($compare_list['id']==Auth()->user()->id)? 'activeyellow':'').'" >
											<td>';
											if ($compare_list['id'] != Auth()->user()->id) {
									print		'<button data-id="'.$compare_list['id'] .'" class="btn-delete-row comparison-delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>';
										}
									print		'<td class="imagestable"><span><img src="'.(isset($compare_list["profile_image"])? asset($compare_list["profile_image"]) : asset("public/frontend/athlete/images/defaultuser.jpg")) .'" /></span><b>'. $compare_list["username"] .'</b></td>
											<td>'.$rank++ . '</td>
											<td>'. round($per) . ' %</td>
											<td class="talehighlightedcompare">'.$compare_list['aci_index'] . '</td>';
									$temp_user = App\Models\UserWorkoutExercises::where('status', 1)
													->where('user_id', $compare_list['id'])
													->whereIn('workout_library_id', $arr)->get();
									// echo "<pre>";print_r($temp_user);
									if(count($temp_user) > 0):
										$tmpArr =array();
										foreach($temp_user as $tu):
											$tmpArr[$tu->workout_library_id]	= $tu;
										endforeach;
									if(!empty($arr)):
										foreach($arr as $a):
											print '<td>'. ((array_key_exists($a, $tmpArr)) ?  $tmpArr[$a]['unit_1'] : '0') .'</td>';
										endforeach;	
									endif;
									else:
										foreach($arr as $a):
											print '<td>'. '0' .'</td>';
										endforeach;
									endif;
									print '</tr>';
								endforeach;
							endif;
							?>
						</table>
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
$(document).ready(function(){
            
            $('.btn-delete-row').on('click', function(){
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
                            url: "{{url('athlete/delete-compare-user')}}"+"/"+id,
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
        });
</script>
@endsection