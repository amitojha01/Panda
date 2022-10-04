@extends('frontend.coach.layouts.app')
@section('title', 'Recommendations')
@section('content')
<div class="container-fluid">
  <div class="addgamehighlightes">
   <div class="addgamehighlightesinner">
     <h3>Write Recommendation</h3>
     <form method="post" id="recommendForm" action="{{ route('coach.send-recomendation') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="recommendId" value="{{ @$recommed_id }}">

      <div class="form-group">
        <label>Recommendation</label>
        <textarea name="recommendation" id="recommend_txt" placeholder="Type here...">{{ @$detail->recommendation }}</textarea>  
        <p style="color:red; display:none" id="err_msg">Recommendation field can not be blank!!</p>    		
      </div>

      <div class="writerecommendtion_example">


        <p><b>Example:</b>  I have coached Joey for 4 years in our Premier League Soccer Travel program. He is one of the most diligent and hard working kids I have ever worked with in our program. He works hard at practice and always wants to learn. His teammates love him and he is a supremely gifted athlete. In my opinion he is ready for the college game.  Joey maintains great classroom habits and is always been part of the honor roll program at school.  All the coaches on the staff maintain a great relationship with Joey as he consistently demonstrates great leadership skills.  In fact, Joey was the team captain and led a fundraising drive by the soccer team to get donations to the local food bank.  He is a very good player, but even better person.  I believe he will be very successful at the college level.<br><br>

          Suggestions to explain or describe about the athlete in the recommendation.  Some or all may be applicable.  Choose items that you can write confidently on regarding the athlete:
          <ul class="recommend_point">
            <li>Describe the athlete’s school habits in the classroom</li>
            <li>Expand on the athlete’s practice habits and discipline</li>
            <li>Talk about the athlete’s commitment to exercise, keeping fit, and commitment to the weight room</li>
            <li>Leadership abilities – ability to lead or work with the team</li>
            <li> Teamwork – ability to be a team player overall, not just the leadership elements; does the athlete play as an individual or a team player?</li>
            <li>Does the athlete maintain an involvement in the community and school?</li>
            <li>What is the player’s relationship with the coaches?</li>

          </ul>


        </p>

      </div>
      

      <div class="form-group" style="display:none" id="replyMsg">
        <label>Message</label>
        <textarea  id="recommend_txt" placeholder="Type here...">{{ @$detail->reply_msg }}</textarea>  

      </div>



      

      <input type="submit" class="sendtoathletebtn" value="SEND TO THE ATHLETE"/>
      <?php if($detail->reply_msg!=""){?>

        <input type="button" class="sendtoathletebtn" onclick="showMsg()" value="Show message"/>
      <?php } ?>
    </form>

    <!-- <input type="submit" class="canceltoathletebtn" value="Cancel"/> -->
  </div>
</div>
</div>
</div>
<div class="clr"></div>
</div>
@endsection
@section('script')

<script>
  $('#recommendForm').submit(function() {
    if ($.trim($("#recommend_txt").val()) === "") {
      $('#err_msg').show();
      return false;
    }else{
      $('#err_msg').hide();
    }
  });

  function showMsg(){
    $('#replyMsg').show();
  }
</script>

@endsection