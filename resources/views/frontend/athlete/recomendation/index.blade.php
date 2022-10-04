@extends('frontend.athlete.layouts.app')
@section('title', 'Recommendation')
@section('content')
<?php 
use App\Models\Country;
use App\Models\Recommendation;
?>
<style>
	#myList div {
		display: none;
	}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="tab-container">
				<div class="tab-menu">
					<div class="searchpanelbox">
                        <!-- <div class="searaddathletes">
                            <form action="" method="post">
                                @csrf
                                <input type="text" name="name_search" autocomplete="off"
                                    placeholder="Search for connections"
                                    value="<?=!empty($name_search) ? $name_search : '' ;?>">
                                <input type="submit" class="searaddathletesbtn" value=''>
                            </form>
                            <div class="clr"></div>

                        </div> -->
                        <div class="clr"></div>
                        <a href="{{ route('athlete.new-recomendation') }}" 
                        class="sendnewrecommendationbtn ">Request A Recommendation</a>
                        <div class="filter"><a href="javascript:void(0);" data-toggle="modal"
                        	data-target="#filterpopup"><img src="images/filter_option.jpg" alt="" /></a></div>
                        </div>
                        <ul>
                        	<li><a href="#" class="tab-a active-a" data-id="tab1">New Recommendation</a></li>
                        	<li><a href="#" class="tab-a" data-id="tab2">Posted</a></li> 
                        	<li><a href="#" class="tab-a" data-id="tab3">Do Not Post</a></li> 
                        	<li><a href="#" class="tab-a" data-id="tab4">Contact</a></li>         
                        </ul>

                    </div>


                    <div class="tab tab-active" data-id="tab1">
                    	<div class="row createteamingup connectionbox" id="myList">

                    		<?php 
                    		$new_recommend= Recommendation::where('recommend_status', 1)
                    		->where('status', 0)
                    		->where('recommendation.sender_id', Auth()->user()->id)
                    		->count();
                    		//echo $new_recommend;
                    		if($new_recommend >0){

                    		//echo '<pre>'; print_r($recommended_coach_list);

                              foreach($recommended_coach_list as $list) {
                                 if($list->status==0){                   		

                                    ?>


                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                       <div class="gamebox coachrecommendationsbox" style="height:190px;">				
                                          <div class="coachsliderbox">
                                             <div class="coachslider_img">
                                                <?php if(@$list->profile_image!=""){ ?>
                                                   <img src="{{ asset($list->profile_image) }}" alt="user_img"/>
                                               <?php }else{ ?>
                                                <?php $uname = explode(" ", $list->username);
                                                $fname= $uname[0];
                                                $lname= @$uname[1];

                                                ?>
                                                <div class="pro-team" style="    padding: 2px 0px 0px 9px;">
                                                    <?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>							
                                                    <!-- <img src="{{ asset('public/frontend/coach/images/noimage.png') }}" alt="addathe_user_img"/> -->
                                                <?php }?>

                                            </div>
                                            <h5>{{ @$list->username }} <span>{{  @$list->country_name}}</span> <em><?php echo @$duration; ?></em><div class="clr"></div></h5>
                                            <?php if($list->coaching_level!=""){?>
                                                <b>{{ ucfirst(@$list->coaching_level) }} coach</b>
                                            <?php } ?>

                                            <?php if($list->updated_recommendation!=""){?>
                                                <p>{!! Str::limit(@$list->updated_recommendation, 70, ' ...') !!}

                                               <?php if(strlen($list->updated_recommendation)>70) {?>
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#invitealink" onclick="getUpdatedRecommendation(<?= @$list->recommend_id ?>)">...Read More</a>
                                            <?php } }else{ ?>


                                            <p>{!! Str::limit(@$list->recommendation, 70, ' ...') !!}

                                               <?php if(strlen($list->recommendation)>70) {?>
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#invitealink" onclick="getRecommendation(<?= @$list->recommend_id ?>)">...Read More</a>
                                            <?php } } ?>



                                        </p>
                                    </div>
                                    <div class="cacho_btn">
                                     <a href="javascript:void(0)" data-id="{{ $list->recommend_id }}" class="postbtn post-recommendation" >Post</a>

                                     <a href="javascript:void(0)" data-id="{{ $list->recommend_id }}" class="dontpostbtn dontpost-recommendation">Do Not Post</a>

                                     <a href="javascript:void(0);" data-toggle="modal" data-id="{{ $list->recommend_id }}"  data-target="#contact_coach" class="contactcaochbtn">Contact Coach</a>

                                     <a href="" class="caochquestionbtn"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                                 </div>				
                             </div>
                         </div>
                     <?php }  } }else{?> 
                        <p>There is no any new recommendation</p>

                    <?php } ?>


                </div>

            </div>

            <div class="tab" data-id="tab2">

              <div class="row createteamingup connectionbox" id="myList2">

                 <div class="table-responsive">
                    <table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
                       <tr>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Recommendation</th>
                          <th>Order</th>
                      </tr>
                      <?php 
                      $post_recommend= Recommendation::whereIn('recommend_status', [1,3])
                      ->where('status', 1)
                      ->where('recommendation.sender_id', Auth()->user()->id)
                      ->count();
                      if($post_recommend >0){

                       foreach($recommended_coach_list as $list) {
                          if($list->status==1 ){                   		

                             ?>
                             <tr>
                                <td>
                                   <?php if(@$list->profile_image!=""){ ?>
                                      <img src="{{ asset($list->profile_image) }}" alt="user_img"/ style="width:70px;height:70px">
                                  <?php }else{ ?>	
                                    <?php $uname = explode(" ", $list->username);
                                    $fname= $uname[0];
                                    $lname= @$uname[1];

                                    ?>
                                    <div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>						
                                    <!-- <img src="{{ asset('public/frontend/coach/images/noimage.png') }}" alt="addathe_user_img"/  style="width:70px;height:70px"> -->
                                <?php }?>
                            </td>
                            <td><?= @$list->username ?></td>
                            <td><?= @$list->recommendation ?>
                            <?php if($list->updated_recommendation!=""  && $list->recommend_status== 1){?>

                                
                                <br><input type="button" class="addhighlightsbtn" value="view updated recommendation" style="padding:13px; font-size:11px"  data-toggle="modal" data-target="#gamepopup" onclick="viewUpdatedRecommend(<?= @$list->recommend_id ?>)">
                            <?php } ?>
                            </td>

                            <td><input type="number" name="order" value="<?= @$list->order_no ?>" class="form-control" onkeyup="saveOrder(this, <?= @$list->recommend_id ?>)">


                            </td>
                        </tr>
                    <?php } } }else{ ?>
                     <tr>
                        <td>There is no any posted recommendation!!</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                <?php } ?>

            </table>
        </div>
    </div>
</div>
<div class="tab" data-id="tab3">

 <div class="row createteamingup connectionbox" id="myList3">

    <div class="table-responsive">
       <table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
          <tr>
             <th>Image</th>
             <th>Name</th>
             <th>Recommendation</th>

         </tr>
         <?php 
         $unpost_recommend= Recommendation::where('recommend_status', '!=', 0)
         ->where('status', 2)
         ->where('recommendation.sender_id', Auth()->user()->id)
         ->count();
         if($unpost_recommend >0){

          foreach($recommended_coach_list as $list) {
             if($list->status==2){                   		

                ?>
                <tr>
                   <td>
                      <?php if(@$list->profile_image!=""){ ?>
                         <img src="{{ asset($list->profile_image) }}" alt="user_img"/ style="width:70px;height:70px">
                     <?php }else{ ?>							
                         <img src="{{ asset('public/frontend/coach/images/noimage.png') }}" alt="addathe_user_img"/  style="width:70px;height:70px">
                     <?php }?>
                 </td>
                 <td><?= @$list->username ?></td>
                 <td><?= @$list->recommendation ?></td>

             </tr>
         <?php } } }else{ ?>
            <tr>
               <td>No Result Found</td>
               <td></td>
               <td></td>

           </tr>

       <?php  } ?>

   </table>
</div>
</div>
</div>

<div class="tab" data-id="tab4">

    <div class="row createteamingup connectionbox" id="myList4">

       <div class="table-responsive">
          <table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
             <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Recommendation</th>
                <th>Contact Message</th>
            </tr>
            <?php 
            $contact_recommend= Recommendation::where('recommend_status', 1)
            ->where('status',3)
            ->where('recommendation.sender_id', Auth()->user()->id)
            ->count();
            if($contact_recommend >0){


             foreach($recommended_coach_list as $list) {
                if($list->status==3){                   		

                   ?>
                   <tr>
                      <td>
                         <?php if(@$list->profile_image!=""){ ?>
                            <img src="{{ asset($list->profile_image) }}" alt="user_img"/ style="width:70px;height:70px">
                        <?php }else{ ?>							
                            <img src="{{ asset('public/frontend/coach/images/noimage.png') }}" alt="addathe_user_img"/  style="width:70px;height:70px">
                        <?php }?>
                    </td>
                    <td><?= @$list->username ?></td>
                    <td><?= @$list->recommendation ?></td>

                    <td><?= @$list->reply_msg ?></td>
                </tr>
            <?php } } } else{ ?>
               <tr>
                  <td>No Result Found</td>
                  <td></td>
                  <td></td>
                  <td></td>

              </tr>

          <?php } ?>

      </table>
  </div>
</div>
</div>

<!--------------------->

</div>
</div>
</div>
</div>
<div class="clr"></div>
</div>
<!-- Modal -->
<div class="modal fade" id="contact_coach" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">      
         <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
           <h3>Contact Coach</h3> 

           <form method="post" id="contactForm" action="{{ route('athlete.contact-coach') }}" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="recommend_id" id='recommend-id'>
               <div class="yourmsg">
                  <label>Your message</label>
                  <div class="yourmsg_inner">
                     <textarea style="height:150px;" id="replymsg" name="reply_msg" placeholder="Type here..."></textarea>


                 </div>
                 <p id="err_msg" style="display:none; color:red">Message field cann'tbe blank</p>
             </div>                       

             <div align="center"><input type="submit" class="recommendedsendbtn" value="Send"/></div>
         </form>        

     </div>      
 </div>
</div>
</div>
<!-----Recommendation Modal-------->
<div class="modal fade" id="invitealink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">      
            <div class="modal-body">
                <h3>Recommendation</h3>

                <div class="invitepopupbox">
                    <p id="recmd"></p>

                    <div class="clr"></div>
                </div>


                <div align="center"><button type="button" class="invitelinkbtn" data-dismiss="modal">Cancel</button></div>
            </div>      
        </div>
    </div>
</div>

<!----view updated recommendation---->
<div class="modal fade" id="gamepopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">  

        <form method="post" action="{{ route('athlete.accept-recommendation') }}" enctype="multipart/form-data">
               @csrf    
                 <input type="hidden" name="recommend_id" id='recommendId'>
            <div class="modal-body">
                <h3>Recommendation</h3>

                <div class="invitepopupbox">
                    <p id="updated_recmd"></p>


                    <div class="clr"></div>
                </div>


                 <div align="center"><button type="button" class="recommendedsendbtn" onclick="rejectRecommendation()">Reject</button></div>
                 <div align="center"><input type="submit" class="recommendedsendbtn" value="Accept"/></div>
            </div>
            </form>      
        </div>
    </div>
</div>





<!------->

<script>

  function saveOrder(dis, recommend_id){ 		
     var orderno= $(dis).val();
     if(orderno!=""){

         $.ajax({
            url:"{{url('athlete/save-order')}}",
            type: "POST",
            data: {
               orderno: orderno,
               recommend_id: recommend_id,
               _token: '{{csrf_token()}}'
           },
           dataType : 'json',

           success: function(result){
               if(result==1 ){
                 swal("Success", "Order saved successfully!!", "success");

             }else{ 
              alert('Ooops!! Something went wrong');

          }
      }
  }); 

     }
 }
 $(document).ready(function() {
     var size_li = $("#myList div").size();
     var x = 36;
     size_li = $("#myList div").size();
     x = 36;
     $('#myList div:lt(' + x + ')').show();
     $('#loadMore').click(function() {
        x = (x + 36 <= size_li) ? x + 36 : size_li;
        $('#myList div:lt(' + x + ')').show();
    });

 });


 $('.post-recommendation').on('click', function(){
     let id = $(this).data('id');        
     swal({
            //title: "Are you sure?",
            title: "Are you sure that you want to post this recommendations on your profile",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
     .then((willPost) => {
        if (willPost) {
           $.ajax({

              url: "{{ url('athlete/post-recommendation') }}"+"/"+id,

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

 $('.dontpost-recommendation').on('click', function(){
     let id = $(this).data('id');        
     swal({
            //title: "Are you sure?",
            title: "Are you sure that you don't want to post this recommendations on your profile",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
     .then((willPost) => {
        if (willPost) {
           $.ajax({

              url: "{{ url('athlete/dontpost-recommendation') }}"+"/"+id,

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

 $('.contactcaochbtn').click(function(){
     $('#recommend-id').val($(this).data('id'));

 });

 $('#contactForm').submit(function() {
     if ($.trim($("#replymsg").val()) === "") {
        $('#err_msg').show();
        return false;
    }else{
        $('#err_msg').hide();
    }
});


 function getRecommendation(recomend_id){
    $.ajax({
        type : "GET",

        url:"{{url('athlete/get-recommendation')}}",
        data : {
            recomend_id: recomend_id,
            _token: '{{csrf_token()}}' 
        },
        dataType : 'json',
        beforeSend: function(){
                    // $("#overlay").fadeIn(300);
                },
                success: function(res){
                    console.log(res);                    
                    if(res.recommendation.length>0){
                       $('#recmd').text(res.recommendation[0].recommendation);                  
                   }
               },
               error: function(err){
                console.log(err);
            }
        }).done( () => {

        });
    }

    function getUpdatedRecommendation(recomend_id){
    $.ajax({
        type : "GET",

        url:"{{url('athlete/get-recommendation')}}",
        data : {
            recomend_id: recomend_id,
            _token: '{{csrf_token()}}' 
        },
        dataType : 'json',
        beforeSend: function(){
                    // $("#overlay").fadeIn(300);
                },
                success: function(res){
                    console.log(res);                    
                    if(res.recommendation.length>0){
                       $('#recmd').text(res.recommendation[0].updated_recommendation);                  
                   }
               },
               error: function(err){
                console.log(err);
            }
        }).done( () => {

        });
    }

    


    

 function viewUpdatedRecommend(recomend_id){
   $('#recommendId').val(recomend_id);
    $.ajax({
        type : "GET",

        url:"{{url('athlete/get-recommendation')}}",
        data : {
            recomend_id: recomend_id,
            _token: '{{csrf_token()}}' 
        },
        dataType : 'json',
        beforeSend: function(){
                    // $("#overlay").fadeIn(300);
                },
                success: function(res){
                    console.log(res);                    
                    if(res.recommendation.length>0){
                       $('#updated_recmd').text(res.recommendation[0].updated_recommendation);                  
                   }
               },
               error: function(err){
                console.log(err);
            }
        }).done( () => {

        });
    }

    function rejectRecommendation(){
        var recomend_id= $('#recommendId').val();
        swal({
            //title: "Are you sure?",
            title: "Are you sure want to reject recommendations",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
     .then((willPost) => {
        if (willPost) {
           $.ajax({

              url: "{{ url('athlete/reject-recommendation') }}"+"/"+recomend_id,

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
