@extends('frontend.coach.layouts.app')
@section('title', 'Compare')
@section('content')
<?php 
 $segment1 =  Request::segment(3);
 $segment2 =  Request::segment(4); 
//  echo $segment2;

?>
<?php 
// echo "<pre>";
// echo $wrk_fill;

// print_r($compare_withs);
// die;
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="tab-container" id="CompareAjax">  
				<div class="tab-menu">
					<a href="{{ url('coach/compare') }}" class="backtocompare">Back</a>
					<a href="{{ url('coach/new-athelete/'.$segment1) }}" class="selectnewathletes">Select new athletes to compare</a>
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
								<th style="width: 220px;">Athletes</th>
								<th style="width: 110px;">Rank <span style="font-size: 12px;">(Out of <?= count($compare_withs); ?> )</span></th>
								{{-- <th>% Rank</th> --}}
								<th class="<?= $segment2 == 'aci_index' ? 'talehighlightedcompare' : '' ; ?>" ><a  href="{{ url('coach/comparison-details/'.$segment1.'/aci_index') }}">Aci Index</a></th>
								<?php
								$flag = 0;
								$arr = [] ; 
								if($workout_librarys):
									foreach($workout_librarys as $key => $workout_librarys1):
										++$flag; 
										$arr[] =  $workout_librarys1['Workout_category_library_id'];
								?>
								<th class="<?= $segment2 == $workout_librarys1['Workout_category_library_id'] ? 'talehighlightedcompare' : '' ; ?>" ><a href="{{ url('coach/comparison-details/'.$group_id.'/'.$workout_librarys1['Workout_category_library_id']) }}"><span>{{ $workout_librarys1['workout_category_title'] }}</span>{{ $workout_librarys1['title'] }}</span></th>	

								<?php endforeach; endif; ?>
							</tr>
							
							<?php
							// echo "<pre>";
							// print_r($arr); die;
							$values = array();
							$rank=0;
							$pos=1;

							$compare_array = $compare_withs;
							// echo "<pre>";
							// print_r($compare_array);
							// die;
							
							if(count($compare_array) > 0){
								$prev_key = 0;
								foreach($compare_array as $key => $compare_list){
								$newpos = $pos++;
								// $per = ($newpos == 1) ? ((1*1)*99) : ((1-($newpos/count($compare_array)))*100); ?>
									<tr id="<?=(($compare_list['id']==Auth()->user()->id)? 'activeyellow':'') ?>">
										<td>
											<?php 
											if ($compare_list['id'] != Auth()->user()->id) {
												print		'<button data-id="'.$compare_list['id'] .'" class="btn-delete-row comparison-delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>' ; } ?>
										</td>
										<td class="imagestable"><span><img src="<?=(isset($compare_list["profile_image"])? asset($compare_list["profile_image"]) : asset("public/frontend/athlete/images/defaultuser.jpg")) ; ?>" /></span><b><?= $compare_list["username"] ;?></b></td>
										<td> <?php
										// if ($rank != 0) {

										// echo 'rank::'.$rank.'<br/>';
										// echo $prev = $compare_array[$rank - 1][$sort_value].'<br/>';
										// 	if($compare_array[$rank - 1][$sort_value] == $compare_array[$rank][$sort_value]){
										// 		echo $prev_key = $prev_key; 
										// 		echo 'same';
										// 	}
										// 	else{
										// 		echo $prev_key = $prev_key+1;
										// 		echo 'not same';
										// 	}
										// }else{
											
										// 	if($compare_array[$rank][$sort_value] == 0){
										// 		echo $prev_key+1;
										// 	}
										// 	else{
										// 	echo $future = $compare_array[$rank + 1][$sort_value];
										// 		if($future == $compare_array[$rank][$sort_value] || empty($future)){
										// 		echo $prev_key+1;
										// 		}
										// 		else{
										// 		echo $prev_key = $prev_key+1;
										// 		}
										// 	}
											
										// }
										if($rank == 0){
											if($compare_array[$rank][$sort_value] == 0){
												echo ''.$prev_key = $rank+1;
												
											}
											else{
												echo ''.$prev_key = $rank+1;
											}
										}
										else{
											if($compare_array[$rank-1][$sort_value] == $compare_array[$rank][$sort_value]){
												echo ''.$prev_key;	
												// echo 'prv'.$compare_array[$rank-1][$sort_value];
												// echo 'curr'.$compare_array[$rank][$sort_value];
											}
											if($compare_array[$rank-1][$sort_value] != $compare_array[$rank][$sort_value]){
												echo ''.$prev_key = $prev_key+1;
												
												// echo 'prv'.$compare_array[$rank-1][$sort_value];
												// echo 'curr'.$compare_array[$rank][$sort_value];
											}
										}
										// echo "rank:".$rank;
										$rank ++;
										?></td>
										{{-- <td><?= round($per); ?> % </td> --}}
										<td class="<?= $segment2 == 'aci_index' ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['aci_index']?></td>
										<?php
										foreach ($arr as $arr_value) { ?>
											{{-- // echo $arr_value; die;
											// if($arr_value == ) --}}
											<td class="<?= $segment2 == $arr_value ? 'talehighlightedcompare' : '' ; ?>"> <?=$compare_list[$arr_value] ;?>
											
									<?php	}
										?>
										{{-- <td class="<?= $segment2 == 6 ? 'talehighlightedcompare' : '' ; ?>"> <?=$compare_list['6'] ;?></td>
										<td class="<?= $segment2 == 7 ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['7'] ;?></td>
										<td class="<?= $segment2 == 10 ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['10'] ;?></td>
										<td class="<?= $segment2 == 43 ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['43'] ;?></td>
										<td class="<?= $segment2 == 44 ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['44'] ; ?></td>   
										<td class="<?= $segment2 == 54 ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['54'] ; ?></td>
										<td class="<?= $segment2 == 55 ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['55'] ; ?></td>
										<td class="<?= $segment2 == 69 ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['69'] ; ?></td>
										<td class="<?= $segment2 == 70 ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['70'] ; ?></td>
										<td class="<?= $segment2 == 76 ? 'talehighlightedcompare' : '' ; ?>"><?=$compare_list['76'] ; ?></td> --}}
									</tr>
								<?php 
									}
								}
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
                            url: "{{url('coach/delete-compare-user')}}"+"/"+id,
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