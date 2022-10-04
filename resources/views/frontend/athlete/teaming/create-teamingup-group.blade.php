@extends('frontend.athlete.layouts.app')
@section('title', 'TeamingUPTM Group')
@section('content')
<?php 
use App\Models\Country;
?>
<head>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
		input.added_athbtn.colorgreen{
			background:green;
			}
	</style>
</head>
<div class="container-fluid">
 <form method="post" action="{{ route('athlete.create.teaming_group') }}" id="createGroupForm" enctype="multipart/form-data">
    @csrf 
  <div class="row">
    <div class="col-md-3 col-sm-12 col-xs-12">
      <div class="createteamingup_l">
        <div class="form-group">
          <label>Group Name</label>
          <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Name your group" onkeyup="checkGroup(this)" required="" />
           <span style="color:red; font-size:13px; display:none;" id="existErr" >Group Name already exist!!</span>
            <input type="hidden" value="0" id="exist_group">
        </div>
        <div class="form-group">
          <label>About Group</label>
          <input type="text" class="form-control" name="description"  placeholder="Describe your group" required/>

        </div>
          <div class="form-group">
            <label>Select Workouts</label>
            <select class="multipleSelect2 form-control" multiple="true" name="workout_id[]" required="">
              @if($workout)
              @foreach($workout as $value)
              <option value="{{$value->id}}"     
                >{{ $value->title }}</option>
                @endforeach
                @endif            
              </select>
            </div>

        <div class="upload-btn-wrapper">
          
          <button class="btn" id=""><i class="fa fa-file-image-o" aria-hidden="true"></i> &nbsp; Upload Cover Photo</button>
          <input type="file" name="image" required="" onchange="showMyImage(this)" />
           <img id="thumbnil" style="width:100%; border-radius:15px; margin-top:10px;" src="{{ asset('public/frontend/images/noimg.png') }}" alt="image"/> 
        </div>
        <input type="submit" class="creategroupbtn disable-create-group" value="Create Group" disabled/> 

      </div>
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">    
      <div class="row">
        <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
          <div class="addathe_box_l">
            <h4>Invite Connections</h4>
          </div>
        </div>
        <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
          <div class="addathe_box_r">
            <div class="searaddathletes">
              <input type="text" placeholder="Search for connections" onkeyup="searchConnection(this)"/>
              <input type="submit" class="searaddathletesbtn" value=""/>
              <div class="clr"></div>
            </div>            
            <div class="clr"></div>
          </div>
        </div>
      </div>

      <div class="row connectionList">

      	<?php if($user){
      		foreach($user as $value){
      			$country_name = Country::where('id', @$value->address[0]->country_id)->first();
      			if($value->role_id==1){
      				$type ="Athlete";
      			}else{
      				$type= "Coach";
      			}
      			?>
      			<div class="col-md-4 col-sm-12 col-xs-12">
      				<div class="addathebox">
      					<div class="addatheboximg">
      						<input type="checkbox" class="group_user_id" value="{{ $value->id }}" name=group_user_id[] style="display:none">
      						<?php if(@$value->profile_image!=""){ ?>
      							<img src="{{ asset($value->profile_image) }}" alt="user_img"/>
      						<?php }else{ ?>							
      							<!-- <img src="{{ asset('public/frontend/coach/images/noimage.png') }}" alt="addathe_user_img"/> -->
                    <?php $uname = explode(" ", $value->username);
                    $fname= $uname[0];
                    $lname= @$uname[1];

                    ?>
                    <div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>
      						<?php }?>		


      					</div>
      					<h5>{{ @$value->username}}</h5>
      					<span>{{ $type }},  {{ @$country_name->name }}</span>
      					<input type="button" class="added_athbtn invbtn" value="Add"/ onclick="inviteUser(this, <?php echo $value->id; ?>)">						
      				</div>
      			</div>
      		<?php }}?>
      	</div>

      
    </div>
  </div>
</form>
</div>
</div>
<input type="hidden" id="base_url" value="<?php echo url('/'); ?>">  
<div class="clr"></div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
</body>
</html>

@endsection
@section('script')

<script>
	function inviteUser(dis, userId){
    var group_value= $('#exist_group').val();    

    if ( $(dis).hasClass("colorgreen") ){

      $(dis).removeClass('colorgreen');

      $(dis).parents(".addathebox").find(".group_user_id").prop('checked', false);
      

   }else{
    $(dis).addClass('colorgreen');

    $(dis).parents(".addathebox").find(".group_user_id").prop('checked', true);	
    
  }	
		
	}


  function searchConnection(dis){
    var text = $(dis).val();
    var list="";
    var site_url= $('#base_url').val();

    $.ajax({
      url:"{{url('athlete/connection-search')}}",
      type: "GET",
      data: {
        text: text,
        _token: '{{csrf_token()}}'
      },
      dataType : 'json',
      success: function(result){
        console.log(result);
        if(result.res.length > 0){ 
          for(var i=0;i<result.res.length;i++){
            if(result.res[i].role_id==1){
              var type ="Athlete";
            }else{
              var type= "Coach";
            }
            list+='<div class="col-md-4 col-sm-12 col-xs-12">';
            list+='<div class="addathebox">';
            list+='<div class="addatheboximg">';
            list+='<input type="checkbox" class="group_user_id" value="'+result.res[i].id+'" name=group_user_id[] style="display:none">';
            if (result.res[i].profile_image!="" && result.res[i].profile_image!=null){ 

              list+='<img src="'+site_url+'/'+result.res[i].profile_image+'" alt="" >';     
            }else{
              var uname= capitalizeFirstLetter(result.res[i].username);
                    list+='<div class="pro-user">'+uname[0]+'</div>';
            }         

            list+='</div>';
            list+='<h5>'+result.res[i].username+'</h5>';
            list+='<span>'+type+'</span>';
            list+='<input type="button" class="added_athbtn invbtn" onclick="inviteUser(this, '+result.res[i].id+')" value="Add"/>';         
            list+='</div>';
            list+='</div>';
          }
        }else{
          list+='No connections are available'; 
        }
        $('.connectionList').html(list);
      }
    });
  }	

  function checkGroup(dis){
    var group_name= $(dis).val();
    $.ajax({
        url:"{{url('athlete/check-group')}}",
        type: "GET",
        data: {
            group_name: group_name,
            _token: '{{csrf_token()}}'
        },
        dataType : 'json',
        success: function(result){         
          console.log(result);          
            if(result==0 ){
              $('#existErr').hide();
              $('#exist_group').val('0');

              /*if($('.colorgreen').length >0 && $('#exist_group').val()==0 ){
              $('.creategroupbtn').prop("disabled", false);
              $('.creategroupbtn').removeClass('disable-create-group');
              
            }*/
             $('.creategroupbtn').prop("disabled", false);
              $('.creategroupbtn').removeClass('disable-create-group');
          }else{ 
            $('#exist_group').val('1');

               $('#existErr').show();
               $('.creategroupbtn').prop("disabled", true);
               $('.creategroupbtn').addClass('disable-create-group');
             
            }
        }
    });

 
  }

  function showMyImage(fileInput) {
    var files = fileInput.files;
    for (var i = 0; i < files.length; i++) { 
      var file = files[i];
      var imageType = /image.*/; 
      if (!file.type.match(imageType)) {
        continue;
      } 
      var img=document.getElementById("thumbnil"); 
      img.file = file; 
      var reader = new FileReader();
      reader.onload = (function(aImg) { 
        return function(e) { 
          aImg.src = e.target.result; 
        }; 
      })(img);
      reader.readAsDataURL(file);
    } 
  }

  function capitalizeFirstLetter(string){
  return string.charAt(0).toUpperCase() + string.slice(1);
}

	

</script>

@endsection
