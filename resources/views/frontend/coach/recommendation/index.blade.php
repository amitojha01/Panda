@extends('frontend.coach.layouts.app')
@section('title', 'Recommendations')
@section('content')

<div class="container-fluid">	
	<div class="row">
		<?php foreach($recommended_user_list as $list){ 
			$cdate = date('Y-m-d H:i:s');	
			$d1 = strtotime($recommended_user_list[0]->created_at);
			$d2 = strtotime($cdate);
			$totalSecondsDiff = abs($d1-$d2); 
			$totalMinutesDiff = $totalSecondsDiff/60;
			$totalHoursDiff   = $totalSecondsDiff/60/60;
			$totalDaysDiff    = $totalSecondsDiff/60/60/24; 
			$totalMonthsDiff  = $totalSecondsDiff/60/60/24/30;
			$totalYearsDiff   = $totalSecondsDiff/60/60/24/365;

			if($totalSecondsDiff > 0 && $totalSecondsDiff<= 60){
				$duration= 'Just now';
			}elseif($totalMinutesDiff >1 && $totalMinutesDiff <=60){
				$duration= round($totalMinutesDiff).' min';
			}elseif($totalHoursDiff >1 && $totalHoursDiff <=24){
				$duration= round($totalHoursDiff).' h';
			}elseif($totalDaysDiff >1 && $totalDaysDiff <=30){
				$duration= round($totalDaysDiff).' d';
			}elseif($totalMonthsDiff >1 && $totalMonthsDiff <=12){
				$duration= round($totalMonthsDiff).' month';
			}elseif($totalYearsDiff >1 ){
				$duration= round($totalYearsDiff). ' y';
			}else{
				$duration ="";
			}
			?>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div class="gamebox coachrecommendationsbox">
					<div class="coachslider_img">

						<?php if(@$list->profile_image!=""){ ?>
							<img src="{{ asset($list->profile_image) }}" alt="user_img"/>
						<?php }else{ ?>							
							<img src="{{ asset('public/frontend/coach/images/noimage.png') }}" alt="addathe_user_img"/>
						<?php }?>

					</div>				
					<div class="coachsliderbox">
						
						<h5>{{ @$list->username }}<span> {{  @$list->country_name}}</span> <em><?php echo @$duration; ?></em><div class="clr"></div></h5>
						<b>Athlete</b>
						<?php if(@$list->updated_recommendation!=""){?>
							<p>{!! Str::limit(@$list->updated_recommendation, 70, ' ...') !!}</p>

						<?php }else{?>
							<p>{!! Str::limit(@$list->recommendation, 70, ' ...') !!}</p>
						<?php } ?>
					</div>
					<div class="cacho_btn">
						<a href="{{ route('coach.edit-recomendation', @$list->recommend_id) }}" class="recommendedwright">Update </a>
						<a href="" class="dontpostbtn">Remove</a>
						<?php if($list->reply_msg!=""){?>

							<!-- <input type="button" class="sendtoathletebtn" onclick="showMsg()" value="Show message"/> -->
							<a href="javascript:void(0);" data-toggle="modal" data-id="{{ $list->recommend_id }}"  data-target="#contact_coach" class="contactcaochbtn">Show message</a>
						<?php } ?>


					</div>				
				</div>
			</div>
		<?php } ?>	        

	</div>
</div>                                                                       
</div>



<div class="clr"></div>
</div>


<div class="modal fade" id="contact_coach" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">      
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3>Athlete Reply</h3>       
				<input type="hidden" name="recommend_id" id='recommend-id'>
          <div class="yourmsg"><!-- 
          	<label>Your message</label> -->
          	<div class="yourmsg_inner">
          		<textarea style="height:150px;" id="replymsg" name="reply_msg" ></textarea>


          	</div>

          </div>                       

          <!--  <div align="center"><input type="submit" class="recommendedsendbtn" value="Send"/></div> -->


      </div>      
  </div>
</div>
</div>
@endsection

@section('script')
<script>
	$('.contactcaochbtn').click(function(){

		var recomend_id= $(this).data('id');

		$.ajax({
			type : "GET",

			url:"{{url('coach/get-reply-msg')}}",
			data : {
				recomend_id: recomend_id,
				_token: '{{csrf_token()}}' 
			},
			dataType : 'json',
			beforeSend: function(){
                    // $("#overlay").fadeIn(300);
                },
                success: function(res){

                	if(res.reply_msg!=""){

                		$('#replymsg').val(res.reply_msg);                  
                	}
                },
                error: function(err){
                	console.log(err);
                }
            }).done( () => {

            });

        });

    </script>
    @endsection