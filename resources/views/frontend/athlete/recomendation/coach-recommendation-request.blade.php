@extends('frontend.athlete.layouts.app')
@section('title', 'Coach Recommendations')
@section('content')
<style>
  a.colorgreen{
    background:green;
  } 

</style>

<div class="container-fluid">
  <div class="addgamehighlightes">
   <div class="addgamehighlightesinner" style="width:100%;">
     <h3>Recommendation Request</h3>

     <div class="form-group addvideoevedancesmalltext">
      <label>Search by</label>
      <select class="form-control" id="searchby" onchange="changeLabel(this)">
        <option value="userId">User Id</option>
        <option value="email">Email</option>
      </select>      		
    </div>  

    <div class="clr"></div>

    <div class="form-group">
      <label id="search_label">Search by entering user id</label>
      <div class="recommendationsearch">
       <input type="text" id="searchTxt" placeholder=""/>
       <input type="button" class="recommendationsearchbtn" value="Search" onclick="searchUser()"/>

       <div class="clr"></div>
       
     </div>  
     <p style="display:none; color:red" id="err_msg">Search field cannot be blank!!</p>
     <div class="nouser"></div>  		
   </div>
   <div class="alternative"></div>
   <div class="searchresult"></div> 

 </div>
</div>
</div>
</div>
<input type="hidden" id="base_url" value="<?php echo url('/') ?>">
<div class="clr"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="profilepopup2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3>Send Registration Link</h3> 
        <form method="post" id="linkForm" action="{{ route('athlete.send.registraion-link') }}" enctype="multipart/form-data">
          @csrf

          <div class="sendregpopup">
            <label>Coach email</label>
            <input type="text" id="coachEmail" name="coachEmail" class="form-control" placeholder="gerrard.butler@gmail.com"/>
            <p id="err_email" style="display:none; color:red">Please enter email id!!</p>
          </div>

          <b class="or">Or</b>

          <div class="sendregpopup">
            <label>Coach mobile</label>
            <input type="tel" name="mobile" class="form-control" placeholder="123 456 7890"/>
          </div>


          <div class="yourmsg">
            <label>Your message</label>
            <div class="yourmsg_inner">
              <textarea id="" name="msg" placeholder="Type here..."></textarea>
              <div class="invitepopupbox">
                <div class="invitepopupbox_l"><img src='{{ asset("public/frontend/athlete/images/pandalogo.jpeg") }}' alt="video_img"/></div>
                <div class="invitepopupbox_r">
                  <h4>Registration link</h4>
                  <p><?php echo url('/registration/coach') ?></p>
                </div>
                <div class="clr"></div>
              </div>
            </div>
          </div>                       

          <div align="center"><input type="submit" class="recommendedsendbtn" value="Send"/></div>
        </form>        
        
      </div>      
    </div>
  </div>
</div>

<!-- Send Profile Modal -->
<div class="modal fade" id="profilepopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3>Send Profile Link</h3> 
        <form method="post" id="linkForm" action="{{ route('athlete.send.profile-link') }}" enctype="multipart/form-data">
          @csrf

          <div class="sendregpopup">
            <label>Coach email</label>
            <input type="text" id="coachEmail" name="coachEmail" class="form-control" placeholder="gerrard.butler@gmail.com"  required="" />
            <p id="err_email" style="display:none; color:red">Please enter email id!!</p>
          </div>

          <b class="or">Or</b>

          <div class="sendregpopup">
            <label>Coach mobile</label>
            <input type="tel" name="mobile" class="form-control" placeholder="123 456 7890"/>
          </div>


          <div class="yourmsg">
            <label>Your message</label>
            <div class="yourmsg_inner">
              <textarea id="" name="msg" placeholder="Type here..."></textarea>
              <div class="invitepopupbox">
                <div class="invitepopupbox_l"><img src='{{ asset("public/frontend/athlete/images/pandalogo.jpeg") }}' alt="video_img"/></div>
                <div class="invitepopupbox_r">
                  <h4>Profile link</h4>
                  <p><?php echo url('/user-profile/', Auth()->user()->id) ?></p>
                </div>
                <div class="clr"></div>
              </div>
            </div>
          </div>                       

          <div align="center"><input type="submit" class="recommendedsendbtn" value="Send"/></div>
        </form>        
        
      </div>      
    </div>
  </div>
</div>



<!----------->

<!-- Modal -->
<div class="modal fade" id="requestpurpose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <h3>Request Purpose</h3>
        <form method="post" action="{{ route('send-request') }}" >
          @csrf         
        <div class="invitepopupbox">
          <div class="invitepopupbox_l"></div>
          
          
          <div class="form-group">
           <!--  <label>Select Request Purpose</label> -->
           <input type="hidden" id="receiver_id" name="receiver_id">
           <input type="hidden" id="receiver_email" name="receiver_email">
            <select class="form-control"  name="request_purpose" required="">
              <option value=""     
                >Select</option> 
              <option value="College Recruiting"     
                >College Recruiting</option>  
                <option value="Professional (non-sports related) Reference"     
                >Professional (non-sports related) Reference</option>            
                <option value="Travel Team Reference"     
                >Travel Team Reference</option>   
                <option value="Job Reference"     
                >Job Reference</option>   
                <option value="Coaching Opportunity Reference"     
                >Coaching Opportunity Reference</option>   
                <option value="General Reference"     
                >General Reference</option>   
              </select>
            </div>
         

          <div class="clr"></div>
        </div>
        <div align="center"><button type="submit" class="sendbtn" >Send</button></div>
      </form>
        
         <div align="center"><button type="button" class="invitelinkbtn" data-dismiss="modal">Cancel</button></div>
      </div>      
    </div>
  </div>
</div>


@endsection
@section('script')

<script>

  function searchUser(){
    var searchby= $('#searchby').val();
    var text = $('#searchTxt').val();
    var list="";
    var nores ="";
    var send_sec="";
    var site_url= $('#base_url').val();
    if(searchby=='userId'){
       var function_url= '{{url('athlete/search-by-userid')}}';
     }else{
      var function_url= '{{url('athlete/search-by-email')}}';
     }
   
    if(text==""){
      $('#err_msg').show();
      $('.searchresult').hide();
      $('.nouser').hide();
      $('.alternative').hide();
      return false;
    }else{
      $('#err_msg').hide();
      $.ajax({
        //url:"{{url('athlete/search-user')}}",
        url:function_url,
        type: "GET",
        data: {
          text: text,
          _token: '{{csrf_token()}}'
        },
        dataType : 'json',
        success: function(result){
          console.log(result);
          if(result.length > 0){ 
            list+='<div class="form-group">';
            list+='<label>Search Result</label>';
            list+='<div class="clr"></div>';

          //list+='<div class="searchresultrecommendation">';
          for(var i=0;i<result.length;i++){

            list+='<div class="searchresultrecommendation searchresultloop">';
            list+='<div class="searchresultrecommendation_l">';
            if (result[i].profile_image!="" && result[i].profile_image!=null){ 

              list+='<img src="'+site_url+'/'+result[i].profile_image+'" alt="" >';     
            }else{
              var uname= capitalizeFirstLetter(result[i].username);
              //list+='<img src="{{ asset("public/frontend/coach/images/noimage.png") }}" alt="addathe_user_img"/>';
              list+='<div class="pro-team">'+uname[0]+'</div>';
            } 

            list+='</div>';
            list+='<div class="searchresultrecommendation_r">';
            //list+='<h4>M00123</h4>';
            if(result[i].country_name!=="" && result[i].country_name!=null){
              list+='<h5>'+result[i].username+ '<em>  '+result[i].country_name+' </em></h5>';
            }
            else{
              list+='<h5>'+result[i].username+' </em></h5>';

            }
            if(result[i].coaching_level!="" && result[i].coaching_level!=null){
              var coach_level= capitalizeFirstLetter(result[i].coaching_level);
              list+='<b>'+coach_level+' coach </b>';
            }
            if(result[i].serve_as_reference==1){
               list+='<a href="javascript:void(0);" data-toggle="modal" data-target="#requestpurpose" onclick="getData('+result[i].id+', \''+result[i].email+'\')">Send Request</a>';

            }else{
              
              list+='<a href="javascript:void(0);"  onclick="refAlert()">Send Request</a>';

            }

            list+='<div class="send-loader" style="display:none;" ><img src="{{ asset('public/frontend/images/Preloader.gif') }}" alt="loader" style="width:120px;"/></div>';
            

            list+='</div>';
            list+='<div class="clr"></div>';
            list+='</div>';
          }
          
          list+='</div>';
          $('.searchresult').show();
          $('.searchresult').html(list);
          $('.nouser').hide();
          $('.alternative').hide();
        }else{
          nores+='<div class="usernotfound"><h6><img src="'+site_url+'/public/frontend/images/usernotfound.png" alt="" > &nbsp; User id not found</h6></div>';

          send_sec+='<div class="sendyouprofilelink">';
          send_sec+='<h3>Select an alternative way to get recommendations from coach</h3>';
          send_sec+='<div class="sendyouprofilelink_box">';
          send_sec+='<div class="activelicense">';
          send_sec+='<h4>Send your profile link</h4>';
          send_sec+='<p>Send a link to the coach that allows the coach to write a recommendation on your dashboard.</p>';
          //send_sec+='<a href="javascript:void(0);" data-toggle="modal"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';

          send_sec+='<a href="javascript:void(0);" data-toggle="modal" data-target="#profilepopup"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
          send_sec+='</div>';
          send_sec+='</div>';
          send_sec+='<div class="sendyouprofilelink_box">';
          send_sec+='<div class="activelicense">';
          send_sec+='<h4>Send Panda registration link</h4>';
          send_sec+='<p>Send a link directly to the coach that allows the coach to register on the app and recommend you.</p>';
          send_sec+='<a href="javascript:void(0);" data-toggle="modal" data-target="#profilepopup2"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
          send_sec+='</div>';
          send_sec+='</div>';
          send_sec+='<div class="clr"></div>';
          send_sec+='</div>';
          $('.searchresult').hide();
          $('.nouser').show();
          $('.alternative').show();
          $('.nouser').html(nores);
          $('.alternative').html(send_sec);
        }
        
      }
    });
    }
  } 

function capitalizeFirstLetter(string){
  return string.charAt(0).toUpperCase() + string.slice(1);
}

  function sendRequest(dis,receiver_id,email){  
   
   $(dis).parents('.searchresultrecommendation_r').find('.send-loader').show();
   $.ajax({
    url:"{{url('athlete/send-request')}}",
    type: "GET",
    data: {
     receiver_id : receiver_id,
     email: email,          
     _token: '{{csrf_token()}}'
   },
   dataType : 'json',

   success: function(result){
    if(result ){
      $(dis).parents('.searchresultrecommendation_r').find('.send-loader').hide();
      $(dis).addClass('colorgreen');
      $(dis).text('Request Sent');
      swal(result.message, 'success')
      .then( () => {
              //location.reload();
            });
    }else{ 
      $(dis).parents('.searchresultrecommendation_r').find('.send-loader').hide();
      alert('Ooops!! Something went wrong');

    }
  }
});
 }

 $('#linkForm').submit(function() {
  if ($.trim($("#coachEmail").val()) === "") {
    $('#err_email').show();
    return false;
  }else{
    $('#err_email').hide();
  } 
});

 function changeLabel(dis){
  
  var search_by= $(dis).val();

  if(search_by=="email"){
    $('#search_label').text('Search by entering user email');
  }else{    
    $('#search_label').text('Search by entering user id');  
  }

 }

 function getData(receiver_id, email){
  $('#receiver_id').val(receiver_id);
  $('#receiver_email').val(email);
   }


   function refAlert(){
    swal({
            title: "This coach is currently not accepting any reference requests for players.",
            icon: "warning",
            //buttons: true,
            dangerMode: true,
            showConfirmButton: false,
            showCancelButton: true,
        })
   }

</script>

@endsection