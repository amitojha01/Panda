@extends('frontend.athlete.layouts.app')
@section('title', 'Edit Group')
@section('content')
<?php 
use App\Models\Country;
use App\Models\TeamingGroupUser;
?>
<style>
  input.added_athbtn.colorgreen{
    background:green;
  } 

</style>
<head>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    input.added_athbtn.colorgreen{
     background:green;
   }
 </style>
</head>
<div class="container-fluid">
 <form method="post" action="{{ route('athlete.update.teaming_group', $group_detail->id) }}" id="createGroupForm" enctype="multipart/form-data">
  @csrf 
  <div class="row">
    <div class="col-md-3 col-sm-12 col-xs-12">
      <div class="createteamingup_l">
        <div class="form-group">
          <label>Group Name</label>
          <input type="text" class="form-control" name="group_name" id="group_name" value="{{ @$group_detail->group_name }}" placeholder="Name your group" onkeyup="checkGroup(this)" required="" />
          <span style="color:red; font-size:13px; display:none;" id="existErr" >Group Name already exist!!</span>
          <input type="hidden" value="0" id="exist_group">
        </div>
        <div class="form-group">
          <label>About Group</label>
          <input type="text" class="form-control" name="description"  placeholder="Describe your group" value="{{ @$group_detail->description }}"  required/>

        </div>
        <div class="form-group">
          <label>Select Workouts</label>
          <select class="multipleSelect2 form-control" multiple="true" name="workout_id[]" disabled="true" >
            <?php if($workout){
              $chk= "";

              foreach($workout as $value){ 
                if (in_array($value->id, $workout_group)) {
                  $chk='selected';
                } ?>

                ?>
                <option value="{{$value->id}}" {{ $chk }}     
                  >{{ $value->title }}</option>
                  <?php $chk= ""; }} ?>           
                </select>
              </div>

              <div class="upload-btn-wrapper">

                <button class="btn" id=""><i class="fa fa-file-image-o" aria-hidden="true"></i> &nbsp; Upload Cover Photo</button>
                <input type="file" name="image"  onchange="showMyImage(this)" />

                @if($group_detail->image!="") 
                <img id="thumbnil" src="{{ asset($group_detail->image) }}" alt="team_img" style="width:100%; border-radius:15px; margin-top:10px;"/>
                @else
                <img id="thumbnil" style="width:100%; border-radius:15px; margin-top:10px;" src="{{ asset('public/frontend/images/noimg.png') }}" alt="image"/>
                @endif

              </div>
              <input type="submit" class="creategroupbtn " value="Update Group" /> 

            </div>
          </div>

          
          <div class="col-md-9 col-sm-12 col-xs-12">    
            <div class="row">
              <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">

                <?php if($is_search==1){?>
                  <div class="row">
                    <div class="selectButton" style="padding: 15px;">
                      <input class="selectAll"  id="ckbCheckAll" type="button" value="Select All">
                      <input class="selectAll" id="ckbCheckRemoveAll" type="button"  value="Remove All">
                    </div>

                  </div>
                <?php } ?>

                <div class="addathe_box_l">
                  <h4>Invite Athletes</h4>                 
                </div>
              </div>
              <input type="hidden" id="teaming_group_id" value="<?= @$group_detail->id ?>">
              <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                <div class="addathe_box_r">
                  <div class="searaddathletes">
                    <input type="text" placeholder="Search Athletes" onkeyup="searchConnection(this)"/>
                    <input type="button" class="searaddathletesbtn" value=""/>
                    <div class="clr"></div>
                  </div> 

                  <a class="filter" href="javascript:void(0);" data-toggle="modal"
                  data-target="#filterpopup">
                  <img src="{{ asset('public/frontend/athlete/images/filter_option.jpg') }}" alt="filter_option"/>
                </a>           
                <div class="clr"></div>
              </div>
            </div>
          </div>

          <div class="row connectionList">

           <?php if($user){
            foreach($user as $value){
             $country_name = Country::where('id', @$value->address[0]->country_id)->first();

             $group_user = TeamingGroupUser::where('user_id', @$value->id)->where('teaming_group_id', @$group_detail->id
           )->first();

             if($group_user){
              $invite_btn= "Added";
              $btn_css= "colorgreen";
              $chk_user="checked";
            }else{
              $invite_btn = "Add";
              $btn_css ="";
              $chk_user="";
            }


            if($value->role_id==1){
              $type ="Athlete";
            }else{
              $type= "Coach";
            }
            ?>
            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="addathebox">
               <div class="addatheboximg">
                <input type="checkbox" class="group_user_id" value="{{ $value->id }}" name=group_user_id[] style="display:none" <?= $chk_user; ?>>
                <?php if(@$value->profile_image!=""){ ?>
                 <img src="{{ asset($value->profile_image) }}" alt="user_img"/>
               <?php }else{ ?>							
                 <?php $uname = explode(" ", $value->username);
                 $fname= $uname[0];
                 $lname= @$uname[1];

                 ?>
                 <div class="pro-user"><?= ucfirst(@$fname[0]).ucfirst(@$lname[0]);?></div>
               <?php }?>		


             </div>
             <h5>{{ @$value->username}}</h5>
             <span>{{ $type }},  {{ @$country_name->name }}</span>
             <input type="button" class="added_athbtn <?= $btn_css ?> invbtn" value="<?= $invite_btn ?>"/ onclick="inviteUser(this, <?php echo $value->id; ?>)">


             <?php if($invite_btn=="Add"){?>
              <input type="checkbox" class="checkBoxClass" name="add_user_array[]" value="<?php echo $value->id; ?>" style="display: none">
            <?php }else{?>
              <input type="checkbox" class="removeCheckBoxClass" name="remove_user_array[]" value="<?php echo $value->id; ?>" style="display: none">

            <?php } ?>					
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

<!-- Filter Modal -->
<div class="modal fade" id="filterpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
        aria-hidden="true">&times;</span> </button>
        <h5>Apply Filter</h5>
        <form method="get"  enctype="multipart/form-data">
          @csrf
          <div class="tab-container">
            <div class="filtertabopoup_l">
              <div class="tab-menu01">
                <ul>
                 <ul>
                  <li><a href="#" class="tab-a01 active-a01" data-id="tab1">Gender</a></li>

                  <li><a href="#" class="tab-a01" data-id="tab2">Sports</a></li>
                  <li><a href="#" class="tab-a01" data-id="tab3">Position</a></li>

                  <li><a href="#" class="tab-a01" data-id="tab4"> Birth year</a></li>
                  <li><a href="#" class="tab-a01" data-id="tab5">Graduation Year</a></li>

                  <li><a href="#" class="tab-a01 " data-id="tab6">City</a></li>
                  <li><a href="#" class="tab-a01" data-id="tab7">State</a></li>
                  <li><a href="#" class="tab-a01" data-id="tab8">Zip Code</a></li>                          

                  <li><a href="#" class="tab-a01" data-id="tab11">Competition Level</a></li>
                </ul>
              </ul>
            </div>
          </div>
          <div class="filtertabopoup_r">
            <div class="tab01 tab-active01" data-id="tab1">
              <select class="form-control" name="gender" id="gender"
              style="width: 100% !important;">
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="both">Both</option>
            </select>


          </div>
          <div class="tab01 " data-id="tab2">
            <ul>

              @foreach($sport_list as $sport_value)
              <li>
                {{$sport_value->name}}
                <div class="radioboxsub">
                  <input type="checkbox" id="sport{{$sport_value->id}}" name="sports[]"
                  value="{{$sport_value->id}}">
                  <label for="sport{{$sport_value->id}}"></label>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
          <div class="tab01" data-id="tab3">
           <ul>
            @foreach($sport_position as $position_value)
            <li>
              {{$position_value->name}}
              <div class="radioboxsub">
                <input type="checkbox" id="position{{$position_value->id}}" name="position[]"
                value="{{$position_value->id}}">
                <label for="position{{$position_value->id}}"></label>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
        <div class="tab01" data-id="tab4">
          <input type="number" class="form-control" name="start_year" value=""
          placeholder="Year" autocomplete="off" />To
          <input type="number" class="form-control" name="end_year" value=""
          placeholder="Year" autocomplete="off" />
        </div>
        <div class="tab01" data-id="tab5">
          <input type="number" class="form-control" name="graduation_year" value=""
          placeholder="Year" autocomplete="off" />
        </div>
        <div class="tab01" data-id="tab6">
          <select class="form-control" name="cities" id="cities"
          style="width: 100% !important;">
          <option value=''>Select </option>
          <?php if(count($cities)>0){?>
            @foreach($cities as $cities_value)
            <option value="{{$cities_value->id}}"> {{$cities_value->name}}
            </option>
            @endforeach
          <?php } ?>
        </select>
      </div>

      <div class="tab01" data-id="tab7">
            <!-- <ul>
                <select class="form-control" name="states" id="state"
                style="width: 100% !important;">
                <option value=''>Select </option>
                @foreach($states as $states_value)
                <option value="{{$states_value['id']}}"> {{$states_value['name']}}
                </option>
                @endforeach
            </select>
          </ul> -->
          <ul>
           @foreach($states as $states_value)
           <li>
            {{$states_value['name']}}
            <div class="radioboxsub">
              <input type="checkbox" id="state{{$states_value['id']}}" name="states[]"
              value="{{$states_value['id']}}">
              <label for="state{{$states_value['id']}}"></label>
            </div>
          </li>
          @endforeach
        </ul>
      </div> 

      <div class="tab01" data-id="tab8">
        <input type="number" class="form-control" name="zip_code" value=""
        placeholder="Enter zip code" autocomplete="off" />
      </div>


      <div class="tab01" data-id="tab11">
       <ul>
        <select class="form-control" name="competition" id="competition"
        style="width: 100% !important;">
        <option value=''>Select </option>
        @foreach($competition_level as $competition_value)
        <option value="{{$competition_value['id']}}"> {{$competition_value['name']}}
        </option>
        @endforeach
      </select>
    </ul>
  </div>
</div>
<div class="clr"></div>

<input type="submit" class="applybtn" value="Apply" />
</div>
</form>
</div>
</div>
</div>
</div>
<!---End Filter modal--->
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
    var group_id= $('#teaming_group_id').val();

    if ( $(dis).hasClass("colorgreen") ){

      //$(dis).removeClass('colorgreen');

      //$(dis).parents(".addathebox").find(".group_user_id").prop('checked', false);
      //$(dis).val('Add');
      

    }else{
      $(dis).addClass('colorgreen');

      $(dis).parents(".addathebox").find(".group_user_id").prop('checked', true);	
      //==
      $.ajax({
        url:"{{url('athlete/invite')}}",
        type: "GET",
        data: {
          userId: userId,
          group_id: group_id,
          _token: '{{csrf_token()}}'
        },
        dataType : 'json',
        
        success: function(result){
          if(result==1 ){
            $(dis).parents('.addathebox').find('.loader').hide();
            $(dis).addClass('colorgreen');
            $(dis).val('Added');
          }else{ 
            alert('Ooops!! Something went wrong');

          }
        }
      }); 

    }	

  }

  function searchConnection(dis){
    var group_id= $('#teaming_group_id').val();
    var text = $(dis).val();
    var list="";
    var site_url= $('#base_url').val();

    $.ajax({
      url:"{{url('athlete/connection-search')}}",
      type: "GET",
      data: {
        text: text,
        group_id:group_id,
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
            if(jQuery.inArray(result.res[i].id, result.userArray) !== -1){
              var invite_btn= "Added";
              var btn_css= "colorgreen";
            }else{
              var invite_btn= "Add";
              var btn_css= "";
            }
            list+='<div class="col-md-4 col-sm-12 col-xs-12">';
            list+='<div class="addathebox">';
            list+='<div class="addatheboximg">';
            if (result.res[i].profile_image!="" && result.res[i].profile_image!=null){ 

              list+='<img src="'+site_url+'/'+result.res[i].profile_image+'" alt="" >';     
            }else{
              var uname= capitalizeFirstLetter(result.res[i].username);
              list+='<div class="pro-user">'+uname[0]+'</div>';            
            }         

            list+='</div>';
            list+='<h5>'+result.res[i].username+'</h5>';
            list+='<span>'+type+'</span>';
            //list+='<input type="button" class="added_athbtn invbtn" value="Add" />'; 

            list+='<input type="button" class="added_athbtn '+btn_css+'" value="'+invite_btn+'"  onclick="inviteUser(this, '+result.res[i].id+','+group_id+')"/>'; 

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
      url:"{{url('athlete/check-teaming-group')}}",
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

  /*********************/

  $(document).ready(function () {
    var group_id= $('#teaming_group_id').val();

    $(".checkBoxClass").prop('checked', false);
    $("#ckbCheckAll").click(function () {
      $(".checkBoxClass").prop('checked', true);
      $(".removeCheckBoxClass").prop('checked', false);

      swal({
        title: "Are you sure?",
        text: "Want to add selected member in team?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

         var multi_athelatic="";
         $("input[name='add_user_array[]']:checked:enabled").each(function() {
          multi_athelatic=$(this).val()+","+multi_athelatic;
        });
         console.log(multi_athelatic);
         $.ajax({
           url:"{{url('athlete/invite-selected-member')}}",
           type: "POST",
           data: {
            userId: multi_athelatic,
            group_id: group_id,
            _token: '{{csrf_token()}}'
          },
          dataType : 'json',
          success: function(result) {
            if(result==1 ){
             swal('Added Successfully', 'success')
             .then( () => {
              location.reload();
            });
           }else{ 
            alert('Ooops!! Something went wrong');

          }
                                /*swal(data.message, 'success')
                                .then( () => {
                                    location.reload();
                                  });*/
                                }
                              });
       }else{
        return false;
      }
    });   


    });

        //===Remove all selected User===
        $("#ckbCheckRemoveAll").click(function () {
          $(".removeCheckBoxClass").prop('checked', true);
          $(".checkBoxClass").prop('checked', false);


          swal({
            title: "Are you sure?",
            text: "Want to remove selected member from team?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {

             var multi_athelatic="";
             $("input[name='remove_user_array[]']:checked:enabled").each(function() {
              multi_athelatic=$(this).val()+","+multi_athelatic;
            });
             console.log(multi_athelatic);
             $.ajax({
               url:"{{url('athlete/remove-selected-member')}}",
               type: "POST",
               data: {
                userId: multi_athelatic,
                group_id: group_id,
                _token: '{{csrf_token()}}'
              },
              dataType : 'json',
              success: function(result) {
                if(result==1 ){
                 swal('Removed Successfully', 'success')
                 .then( () => {
                  location.reload();
                });
               }else{ 
                alert('Ooops!! Something went wrong');

              }
                                /*swal(data.message, 'success')
                                .then( () => {
                                    location.reload();
                                  });*/
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
