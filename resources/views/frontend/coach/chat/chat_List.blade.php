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

.noChat{
  display: block;
    text-align: center;
    background: #cfcece;
    /* color: white; */
    height: 40px;
    padding: 6px 0 0 0;
    width: 150px;
    color: #000;
    margin: auto;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    font-weight: bold;
}

.unRead{
  background: #FFD500;
  margin-left: 50px !important;
    color: red !important;
    font-size: 15px !important;
    width: 20px;
    height: 20px;
    display: block;
    text-align: center;
    border-radius: 50px;
}

.unReadDiv{
  display: flex;
    align-items: center;
    color: #FFD500;
}
#chat_get {
    overflow-x:hidden;
    overflow-y:visible;
    height:315px;
}

/* .chat_get::-webkit-scrollbar {
  display: none;
} */
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
                      <form id="searchchat">
                      <input type="text" id="seach" name="search" placeholder="Search Conversations" autocomplete="off"/>
                      <button type="button" class="chatbtn"></button>
                      </form>
                    </div>
                    <div style="background: #FFD500; border-radius: 5px;margin-right: -10px;">
                      <a href="{{ url('coach/connections')}}" style="color: #fff; font-size: 27px; padding: 2px 12px; font-weight: bold; text-decoration: none;">+</a>
                    </div>
                    <div class="clr"></div>
                  </div>
                  <div class="chatlist">
                    <div id="testDiv2">
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="chat_right">
                  <div class="chat_right_top">
                    <div class="chat_right_top_l">
                      <div id="chat_header">
                        
                      </div>
                      
                     
                      {{-- <span>Active Now <i></i></span> </div> --}}
                      {{-- <span> <i></i></span>  --}}
                    </div>
                    <div class="chat_right_top_r"></div>
                    <div class="clr"></div>
                  </div>
                  <div class="textchat">
                    <div id="testDiv3">
                      <div class="chat_get" id="chat_get">
                        <div>
                          <span class="noChat" style="
                          width: 210px;
                      ">Please select member</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="chat_id1" value="" id="chat_id_hidden">
                      <input type="hidden" name="connection_id1" id="connection_id_hidden"  value="">
                  <div class="inputchat_main">
                    <div class="inputchat">
                    <form id="sendmsg1" method="post" enctype="multipart/form-data" >
                      <input type="hidden" name="chat_id" value="" id="chat_id">
                      <input type="hidden" name="connection_id" id="connection_id"  value="">
                      <div class="inputchat_l">
                        <input type="text"  name="message" id="message" placeholder="Enter your message here" autocomplete="off" required/>
                      </div>
                      <div class="inputchat_r">                         
                        <!-- <a href="" class="emoji"><img src="images/emoji_icon.png" alt="emoji_icon"/></a> -->
                        <div class="file-input">
                          {{-- <input type="file" name="image" id="file-input" class="file-input__input" />
                          <label class="file-input__label" for="file-input"><span><img src="{{asset('public/frontend/athlete/images/attach_icon.png')}}" alt="attach_icon"/></span></label> --}}
                        </div>
                        {{-- <div class="loading" style="display: none"></div> --}}
                        <input type="submit" class="sendmsg" id="messageSave" value=""/>
                      </div>
                    {{-- </form> --}}
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
<script>
  $(document).ready(function(){
    all_chat_member();
  });
  
  function all_chat_member()
  {
    $.ajax({
                type  : "get",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url   : "{{ route('coach.all-chat-ids') }}",
                data  : '',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    // $('.loading').css('display','block');
                },
                success: function(res){
                  // console.log(res);
                  // console.log(res.data);
                    var fieldHTML = '';       
                    var new_list = res.data; 
                    // console.log(new_list);
                    $.each(new_list, function(k, v) {
                        // console.log(v.name);
                        let display = '';
                                if(v.all_read_message == 0){
                                    display = 'none';
                                }else{
                                  display = '';
                                }
                        fieldHTML = fieldHTML +
                        '<div class="chatlistbox GeChatList selectData" data-chat_id ="'+v.user_id+'" data-conection_id ="'+v.user_id+'"  >'+
                          '<div class="chatlistbox_l">'+
                            '<img src="'+v.user_image+'" alt="chaiprofileimg"/>'+
                          '</div>'+
                        '<div class="chatlistbox_mid">'+
                            '<h6 class="unReadDiv">'+v.name+'<span class="unRead" style="display:'+display+'">'+v.all_read_message+'</span></h6>'+
                          '<span>'+v.type+'</span>'+ 
                        '</div>'+
                        '<div class="clr"></div>'+
                      '</div>';
                    });
                    $('#testDiv2').html(fieldHTML);
                }
            }); 
  }
  $(document).on('click','.selectData',function (e) {
    // alert('chat_id');
    
    var chat_id = $(this).data('chat_id');
    view_message_chat(chat_id);
    // var conection_id = $(this).data('conection_id');
    // var formdata =  new FormData(this);
    // alert(chat_id);
    // console.log(formdata);
   
  });

  $('#messageSave').click(function(){
    var chat_id = $('#chat_id_hidden').val();
    var connection_id = $('#connection_id_hidden').val();
    var message = $('#message').val();

    if(chat_id == '' || connection_id == '' || message == ''){
      return true;
    }
    
    // alert(chat_id);
    // alert(connection_id);
    $.ajax({
          type  : "POST",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url   : "{{ route('coach.chats-save') }}",
          data  : {
            "_token": "{{ csrf_token() }}",
            chat_id :chat_id,
            connection_id :connection_id,
            message :message,
          },
          beforeSend: function(){
              // $('.loading').css('display','block');
          },
          success: function(res){
            // console.log(res);
            $('#message').val('');
            view_message_chat($('#chat_id_hidden').val());
            var elem = document.getElementById('chat_get');
            elem.scrollTop = elem.scrollHeight;
           
          }
        });
  });

  var intervalId = window.setInterval(function(){
    view_message_chat($('#chat_id_hidden').val());
    all_chat_member();
  //   var elem = document.getElementById('chat_get');
  // elem.scrollTop = elem.scrollHeight;
  }, 5000);

  function view_message_chat(chat_id){
    $.ajax({
          type  : "POST",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url   : "{{ route('coach.view-chats') }}",
          data  : {
            "_token": "{{ csrf_token() }}",
            chatid:chat_id
          },
          beforeSend: function(){
              // $('.loading').css('display','block');
          },
          success: function(res){
            console.log(res);
                  console.log(res.data);
                    var fieldHTML = '';       
                    var chat_list = res.data; 
                    // console.log(res.select_chat_user);
                    if(res.data != ''){
                    
                    $.each(chat_list, function(k, v) {
                        // console.log(v);
                        if(v.own_send == 1){
                        fieldHTML = fieldHTML +
                          '<div class="textchat1">'+
                            '<div class="textchat1_img"><img src="'+v.sender_profile_image+'" alt="user_img"/></div>'+
                                '<h6><span>'+v.message+'</span></h6>'+
                                '<span style="font-size: 10px;font-style: italic;color: #919090; display:block; margin-bottom:15px;text-align:right">'+v.addTime+'</span>'+
                            '</div>'+
                          '<div class="clr"></div>';
                        }else{
                          fieldHTML = fieldHTML +
                          '<div class="textchat2">'+
                            '<div class="textchat2_img"><img src="'+v.sender_profile_image+'" alt="user_img"/></div>'+
                                '<h6><span>'+v.message+'</span></h6>'+
                                '<span style="font-size: 10px; font-style: italic; color: #919090; display:block; margin-bottom:15px; text-align:left">'+v.addTime+'</span>'+
                            '</div>'+
                          '<div class="clr"></div>';
                        }
                      });
                    }
                    else{
                      fieldHTML = '<div>'+
                                      '<span class="noChat">No chat yet</span>'+
                                    '</div>';
                    }

                    $('#chat_get').html(fieldHTML);

                    chatHeaderHTML = 
                    '<div class="textchat2_img" style="position:relative; display:inline-block;" id=""><img id="message_user_image" src="'+res.select_chat_user.profile_image+'" alt="user_img"/></div>'+
                    '<h3 style="display:inline-block; margin-left:10px;" id="message_user_name">'+res.select_chat_user.user_name+'</h3>';

                    $('#chat_header').html(chatHeaderHTML);
                    $('#chat_id_hidden').val(res.select_chat_user.chat_id);
                    $('#connection_id_hidden').val(res.select_chat_user.connection_id);
                    // $('#chat_header').scrollBottom( $('#chat_header').height() )
                    // all_chat_member();
                    var elem = document.getElementById('chat_get');
                    elem.scrollTop = elem.scrollHeight;
 
                    
                    
          }
        });
  }


  
</script>
<script type="text/javascript">
    $(document).ready(function(){
      
      $(document).on('submit','#sendmsg1',function(e){
        e.preventDefault();
        var chat_id = $('#chat_id_hidden').val();
        var connection_id = $('#connection_id_hidden').val();
        var formdata =  new FormData(this);
        console.log(formdata); die;
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
                    // $('.loading').css('display','block');
                },
                success: function(res){
                  // $('.loading').css('display','none');

                  // console.log(res.data.firebase_chat_id);
                  // console.log(res.data.connection_message_id);
                  //  $('#connection_id').val(res.data.connection_message_id);
                  //   $('#chat_id').val(res.data.firebase_chat_id);
                  //   GetChat($('#chat_id').val(),$('#connection_id').val());

                  //   $('#message').val('');
                }
            }); 
      });
    });

      $(document).on('click','.GeChatList',function (e) {
        // alert("GeChatList");
        var chat_id = $(this).data('chat_id');
        var conection_id = $(this).data('conection_id');
        $('.chatlistbox').removeClass('active');
        $(this).addClass('active');
        // GetChat(chat_id,conection_id);
      });
 

    //   // $('#seach').on('keyup',function (e) {
    //   //    e.preventDefault();
    //   //    var search = $(this).val();;
    //   //    console.log(search);
    //   //     $.ajax({
    //   //           type  : "POST",
    //   //           headers: {
    //   //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   //           },
    //   //           url   : "{{ route('athlete.search-connections') }}",
    //   //           data  : {search:search},
    //   //           dataType : "JSON",
    //   //           cache: false,
    //   //           contentType: false,
    //   //           processData: false,
    //   //           beforeSend: function(){
    //   //               $('.loading').css('display','block');
    //   //           },
    //   //           success: function(res){
    //   //             $('.loading').css('display','none');

    //   //             $('#testDiv2').html(res.html);
                  

    //   //           }
    //   //     }); 

    //   // }) 
    //   // $(document).on('keyup','#searchchat',function (e) {
    //   //    e.preventDefault();
    //   //    var formdata =  new FormData(this);;
    //   //    // console.log(formdata);
    //   //     $.ajax({
    //   //           type  : "POST",
    //   //           headers: {
    //   //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   //           },
    //   //           url   : "{{ route('athlete.search-connections') }}",
    //   //           data  : formdata,
    //   //           dataType : "JSON",
    //   //           cache: false,
    //   //           contentType: false,
    //   //           processData: false,
    //   //           beforeSend: function(){
    //   //               // $('.loading').css('display','block');
    //   //           },
    //   //           success: function(res){
    //   //             // $('.loading').css('display','none');
    //   //             $('#testDiv2').html(res.html);
                 
    //   //              // $('#connection_id').val(res.data.connection_message_id);
    //   //              //  $('#chat_id').val(res.data.firebase_chat_id);
    //   //              //  GetChat($('#chat_id').val(),$('#connection_id').val());

    //   //              //  $('#message').val('');
    //   //           }
    //   //     }); 

    //   // })
      
    
    
    // $(document).ready(
      
    //   GetChat($('#chat_id_hidden').val(),$('#connection_id_hidden').val())
    // );
      // var intervalId = window.setInterval(function(){
      //  GetChat($('#chat_id_hidden').val(),$('#connection_id_hidden').val());
      // }, 8000);
    // function GetChat(chat_id,conection_id) {
    //   var chat_id       = chat_id ;
    //   var conection_id = conection_id ;
    //   // alert(chat_id);
    //   if(chat_id == ''){
    //      $('.chat_get').html('');
    //     return false ;
    //   }
    //   $('#chat_id_hidden').val(chat_id)
    //   $('#connection_id_hidden').val(conection_id)
    //   // $('.chatlistbox').removeClass('active');
    //   // $(this).addClass('active');
    //   $.ajax({
    //           type  : "POST",
    //           url   : "{{ route('athlete.get-connections-message') }}",
    //           data  : {
    //               '_token' : "{{ csrf_token() }}",
    //               chat_id : chat_id
    //           },
    //           dataType : "JSON",
    //           beforeSend: function(){
    //               //$("#overlay").fadeIn(300);
    //               // $('#eventsmodaldetails').empty();
    //               // $('.loading').css('display','block');
    //           },
    //           success: function(res){
    //             // $('#message_user_image').append('');
    //             // console.log(res.messagehead);
    //             // $('.loading').css('display','none');
    //               if(res.success == 1){
    //                 $('.chat_get').html(res.data);
    //                 $('#connection_id').val(conection_id);
    //                 $('#chat_id').val(chat_id);
    //                 $('#receive_details').text(res.receive_details);
    //                 $('#message_user_name').text(res.messagehead.username);
    //                 // $('#message_user_image').append('<img src="'+ res.messagehead.image +'" alt="something" />');
    //                 $("#message_user_image").attr("src",  res.messagehead.image);
    //               }else{
    //               }
    //           }
    //       }); 
    // }
    

</script>
@endsection