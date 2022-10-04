@extends('frontend.coach.layouts.app')
@section('title', 'Chat')
@section('content')
<style type="text/css">
  .loading {
  height: 0;
  width: 0;
  padding: 15px;
  border: 6px solid #ccc;
  border-right-color: #888;
  border-radius: 22px;
  -webkit-animation: rotate 1s infinite linear;
  /* left, top and position just for the demo! */
  position: absolute;
  left: 36%;
  top: 23%;
}

@-webkit-keyframes rotate {
  /* 100% keyframe for  clockwise. 
     use 0% instead for anticlockwise */
  100% {
    -webkit-transform: rotate(360deg);
  }
}
.chatlistbox.GeChatList.active{
    background: #242222;
}

</style>
<?php
// echo '<pre>';
// print_r($det);
// die;
?>
<meta name="csrf-token" content="{{ csrf_token() }}" />
 <div class="clr"></div>
   
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="teamingupdetails">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="chat_l">
                  <div class="chat_l_search" style="background:#000;display: flex;align-items: center;justify-content: space-between;">
                    <div style="width:85%;background: white;border-radius: 5px;">
                      <form id="searchchat" method="post" enctype="multipart/form-data" >
                      <input type="text" id="seach" name="search" placeholder="Search Conversations"/>
                      <input type="submit" class="chatbtn">
                      </form>
                    </div>
                    <div style="background: #FFD500; border-radius: 5px;margin-right: -10px;">
                      <a href="{{ url('coach/connections')}}" style="color: #fff; font-size: 27px; padding: 2px 12px; font-weight: bold; text-decoration: none;">+</a>
                    </div>
                    <div class="clr"></div>
                  </div>
                  <div class="chatlist">
                    <div id="testDiv2">
                      <?php if(count($chat_details)){
                        $i= 0 ;
                      foreach($chat_details As $chatlist){

                     
                          $val = base64_encode($chatlist->firebase_chat_id);
                         // $vl = ;
                      ?>
                      <div class="chatlistbox GeChatList <?php if($i == 0 ){ echo "active";} ?>  " data-chat_id ="<?php echo $val; ?>" data-conection_id ="<?php echo  $chatlist->connection_message_id;?>"  >
                        <div class="chatlistbox_l">
                        @if($chatlist->user->profile_image !='') 
                          <img src="{{ url($chatlist->user->profile_image)}}" alt="chaiprofileimg"/> <!-- <i></i>  -->
                        @else
                         <img src="{{asset('public/frontend/images/default-user.jpg')}}" alt="chaiprofileimg"/> <!-- <i></i>  -->
                        @endif  
                        </div>
                        <div class="chatlistbox_mid">
                          <h6>{{ $chatlist->user->username}}</h6>
                          @if($chatlist->user->role_id == 1)
                          <span> Athlete</span> 
                          @else
                          <span>Coach </span> 
                          @endif
                        </div>
                        {{-- <div class="chatlistbox_r"> <span>2</span> </div> --}}
                        <div class="clr"></div>
                      </div>
                      <?php $i++;}}?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="chat_right">
                  <div class="chat_right_top">
                    <div class="chat_right_top_l">
                      <div class="textchat2_img" id=""><img id="message_user_image" src="'.$send_image.'" alt="user_img"/></div>
                      <h3 id="message_user_name"></h3>
                     
                      {{-- <span>Active Now <i></i></span> </div> --}}
                      {{-- <span> <i></i></span>  --}}
                    </div>
                    <div class="chat_right_top_r"></div>
                    <div class="clr"></div>
                  </div>
                  <div class="textchat">
                    <div id="testDiv3">
                      <div class="chat_get"></div>
                    </div>
                  </div>

                    <input type="hidden" name="chat_id1" value="<?=  base64_encode($det['firebase_chat_id']); ?>" id="chat_id_hidden">
                      <input type="hidden" name="connection_id1" id="connection_id_hidden"  value="<?=  $det['connection_id'] ?>">
                  <div class="inputchat_main">
                    <div class="inputchat">
                    <form id="sendmsg1" method="post" enctype="multipart/form-data" >
                      <input type="hidden" name="chat_id" value="<?=  $det['firebase_chat_id'] ?>" id="chat_id">
                      <input type="hidden" name="connection_id" id="connection_id"  value="<?=  $det['connection_id'] ?>">
                      <div class="inputchat_l">
                        <input type="text"  name="message" id="message" placeholder="Enter your message here" req/>
                      </div>
                      <div class="inputchat_r">                         
                        <!-- <a href="" class="emoji"><img src="images/emoji_icon.png" alt="emoji_icon"/></a> -->
                        <div class="file-input">
                          <input type="file" name="image" id="file-input" class="file-input__input" />
                          <label class="file-input__label" for="file-input"><span><img src="{{asset('public/frontend/athlete/images/attach_icon.png')}}" alt="attach_icon"/></span></label>
                        </div>
                        {{-- <div class="loading" style="display: none"></div> --}}
                        <input type="submit" class="sendmsg" value=""/>
                      </div>
                      </form>
                      <div class="clr"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(document).ready(function(){
      
      $(document).on('submit','#sendmsg1',function(e){
        e.preventDefault();
        var chat_id = $('#chat_id').val();
        var connection_id = $('#connection_id').val();
        var formdata =  new FormData(this);;
        $.ajax({
                type  : "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url   : "{{ route('coach.save-connections-message') }}",
                data  : formdata,
                dataType : "JSON",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.loading').css('display','block');
                },
                success: function(res){
                  $('.loading').css('display','none');

                  console.log(res.data.firebase_chat_id);
                  console.log(res.data.connection_message_id);
                   $('#connection_id').val(res.data.connection_message_id);
                    $('#chat_id').val(res.data.firebase_chat_id);
                    GetChat($('#chat_id').val(),$('#connection_id').val());

                    $('#message').val('');
                }
            }); 
      });


      $(document).on('click','.GeChatList',function (e) {
        // alert("GeChatList");
        var chat_id = $(this).data('chat_id');
        var conection_id = $(this).data('conection_id');
        $('.chatlistbox').removeClass('active');
        $(this).addClass('active');
        GetChat(chat_id,conection_id);
      })

      // $('#seach').on('keyup',function (e) {
      //    e.preventDefault();
      //    var search = $(this).val();;
      //    console.log(search);
      //     $.ajax({
      //           type  : "POST",
      //           headers: {
      //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //           },
      //           url   : "{{ route('athlete.search-connections') }}",
      //           data  : {search:search},
      //           dataType : "JSON",
      //           cache: false,
      //           contentType: false,
      //           processData: false,
      //           beforeSend: function(){
      //               $('.loading').css('display','block');
      //           },
      //           success: function(res){
      //             $('.loading').css('display','none');

      //             $('#testDiv2').html(res.html);
                  

      //           }
      //     }); 

      // }) 
      $(document).on('keyup','#searchchat',function (e) {
         e.preventDefault();
         var formdata =  new FormData(this);;
         // console.log(formdata);
          $.ajax({
                type  : "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url   : "{{ route('coach.search-connections') }}",
                data  : formdata,
                dataType : "JSON",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.loading').css('display','block');
                },
                success: function(res){
                  $('.loading').css('display','none');
                  $('#testDiv2').html(res.html);
                 
                   // $('#connection_id').val(res.data.connection_message_id);
                   //  $('#chat_id').val(res.data.firebase_chat_id);
                   //  GetChat($('#chat_id').val(),$('#connection_id').val());

                   //  $('#message').val('');
                }
          }); 

      })
      
    });
    
    $(document).ready(
      
      GetChat($('#chat_id_hidden').val(),$('#connection_id_hidden').val())
    );
      var intervalId = window.setInterval(function(){
       GetChat($('#chat_id_hidden').val(),$('#connection_id_hidden').val());
      }, 8000);
    function GetChat(chat_id,conection_id) {
      var chat_id       = chat_id ;
      var conection_id = conection_id ;
      // alert(chat_id);
      if(chat_id == ''){
         $('.chat_get').html('');
        return false ;
      }
      $('#chat_id_hidden').val(chat_id)
      $('#connection_id_hidden').val(conection_id)
      // $('.chatlistbox').removeClass('active');
      // $(this).addClass('active');
      $.ajax({
              type  : "POST",
              url   : "{{ route('coach.get-connections-message') }}",
              data  : {
                  '_token' : "{{ csrf_token() }}",
                  chat_id : chat_id
              },
              dataType : "JSON",
              beforeSend: function(){
                  //$("#overlay").fadeIn(300);
                  // $('#eventsmodaldetails').empty();
                  $('.loading').css('display','block');
              },
              success: function(res){
                // $('#message_user_image').append('');
                // console.log(res.messagehead);
                $('.loading').css('display','none');
                  if(res.success == 1){
                    $('.chat_get').html(res.data);
                    $('#connection_id').val(conection_id);
                    $('#chat_id').val(chat_id);
                    $('#receive_details').text(res.receive_details);
                    $('#message_user_name').text(res.messagehead.username);
                    // $('#message_user_image').append('<img src="'+ res.messagehead.image +'" alt="something" />');
                    $("#message_user_image").attr("src",  res.messagehead.image);
                  }else{
                  }
              }
          }); 
    }
    

</script>
@endsection