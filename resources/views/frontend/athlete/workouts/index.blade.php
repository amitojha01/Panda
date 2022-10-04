@extends('frontend.athlete.layouts.app')
@section('title', 'Workout Libraries')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<style>
    .showDiv{
        display: block !important;
    }
</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12 workoutl_panel" id="workouts-category">
                <!-- dynamic -->
                <div id="workout_l_box">

                </div>
            </div>
            <div class="col-md-9 col-sm-12 col-xs-12 workoutr_panel">
                <div class="workout_right">
                    <div class="workout_right_l" id="category-info">
                        <img src="{{ asset('public/frontend/images/no-image-loading.jpg') }}" alt="workout_img_r" />
                        <h2 id="title">-</h2>
                        <p id="description">-</p>
                       
                    </div>
                    <div class="workout_right_r" id="workout-librarys">
                     
                     <div>
                            <h2 id="workout-title" style="color:white">-</h2>
                            
                            <div class="activelicense" style="margin:15px 0 0 0; width:100%; padding-right:20px;">
                                {{-- <h4>Athlete Tips</h4> --}}
                                <p>Need Workout Tips?  Check out the <span style="color:red;"><u><a style="position: relative;
                                    background: none;
                                    border-radius: 0;
                                    width: auto;
                                    display: inline-block;
                                    text-align: end;
                                    top: auto;
                                    right: auto;
                                    height: auto;
                                    color: #e90000;
                                    font-size: 14px;" href="https://www.youtube.com/channel/UCUqMLP96Z7OyIW6_MPLaB0A">Panda Stronger YouTube Channel</a></u></span></p>
    <!--
                                <a href="javascript:void(0)" id="workout-tips">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </a>
    -->
                            </div> 
                            <div class="searaddathletes" style="float: none; margin-top:15px; ">
                                <input type="text" id="search_value" placeholder="Search for workouts " />
                                <input type="submit" class="searaddathletesbtn" value="" />
                                <div class="clr"></div>
                            </div>
                            
                            <div class="selectButton col-md-12" style="padding: 0; float:none; margin-top:15px; margin-bottom: 15px;">
                                <input class="selectAll"  id="ckbCheckAll" type="button" value="Select All">
                                <input class="selectAll"  id="ckbCheckRemoveAll" type="button"  value="Remove All">
                            </div>
                            <h5 STYLE="color: #FFD500; font-size: 1.5rem; ">*Please select at least one workout from the list below</h5>
                            
                            
                        </div>
                      
                      
                        <div class="clr"></div>
                        
                                                                              
                        
                    </div>
                    <div class="clr"></div>
                    
                    <div class="workoutbottom"  id="workout-librarys">
                    	
                        
                         <form action="" id="form-workout-library">
                            <div align="center" id="workout-add" style="display: none; margin-top:15px; ">
                                <input type="hidden" name="workout_id" value="">
                                <button type="submi" id="save-workout" class="addyourdashboard mb-3">Add to your dashboard</button>
                            </div>                     
                                      
                            @csrf
                        
                        <div id="workout_library_scroll">

                       
                            <div class="signinbox" id="workouts-category-library" >
                                <!-- dynamic data -->
                            </div>                           
                       

                        </div>

                      
                            </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            placement: 'top',
            trigger: 'hover'
        });
    });
</script>
<script>
    var workoutCategory="";
    var workoutId = "";
    const savedWorkoutLibrary = [];
    $(document).ready(function(){ 
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-workouts') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                if(res.success){
                    if(res.data.length > 0){
                        workoutCategory = res.data;
                        res.data.forEach((v) => {
                            let image = base_url+"/"+v.image;
                            $('#workouts-category #workout_l_box')
                            .append('<div class="workout_l_box workout-category" id="'+v.id+'">\
                                <img src="'+image+'" alt="workout_img" />\
                                <span>'+v.category_title+'</span>\
                            </div>');
                        })
                        //$('.workout-category#'+res.data[0].id).click();                        
                        $('.workout-category#'+sessionStorage.tabId).click();
                    }               
                }
            },
            error: function(err){
                // console.log(err);
            }
        }).done( () => {            
        });

        $(document).on('click', '.workout-category', function(){
            $('.workout-category').removeClass('active');
            $(this).addClass('active');
            workoutId = $(this).attr('id');
            //get users updated workout librarys            
            $.ajax({
            type : "GET",
            url : "{{ url('api/get-user-workouts') }}?user_id={{ Auth()->user()->id }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                if(res.success){
                    if(res.data.length > 0){
                        savedWorkoutLibrary.splice(0, savedWorkoutLibrary.length);
                        for(data of res.data){
                            savedWorkoutLibrary.push(data.id);
                        }
                    }
                }
            },
            error: function(err){
                // console.log(err);
            }
            }).done( () => {                
                getCategoryLibrary(workoutId);
            });
            //add workoput Id to save data
            $('input[name="workout_id"]').val(workoutId);
            //populate category info
            workoutCategory.forEach((v) => {
                // console.log('ddedd');
                // console.log(v.category_title);
                if(v.id == workoutId){
                    if(v.banner != null){
                        $('#category-info img').attr('src', base_url+"/"+v.banner);
                    }
                    $('#category-info #title').html(v.content_title);
                    $('#category-info #description').html(v.description);
                    $('#workout-librarys #workout-title').html('Select '+v.category_title+' workouts list');
                    // $('#workout-librarys #workout-title').html('Select '+v.content_title+' workouts list');

                }
            })
        });

        $('#form-workout-library').submit(function(e){
            e.preventDefault();
            if($('input[name="workout_library[]"]:checked').length < 1){
                swal('Please select library from list', 'Warning', 'warning');
                return false;
            }

            swal({
                title: "Are you sure?",
                text: "Want to add selected categories on dashboard",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    let fd = new FormData(this);
                    let workout_ids = [];
                    $('input[name="workout_library[]"]:checked').each(function(v){
                        workout_ids.push($(this).val());
                    })
                    fd.append('workout_library', workout_ids);
                    $.ajax({
                        type : "POST",
                        url : "{{ route('workouts.store') }}",
                        data : fd,
                        cache : false,
                        processData: false,
                        contentType: false,
                        beforeSend: function(){
                            //$("#overlay").fadeIn(300);
                        },
                        success: function(res){
                            if(res.success){
                                swal(res.message, 'Success', 'success');
                            }else{
                                swal(res.message, 'Warning', 'warning');
                            }
                        },
                        error: function(err){
                            // console.log(err);
                            swal('Sorry!! Something went wrong', 'Warning', 'warning');
                        }
                    }).done( () => {
                        
                    });
                }
                });
                
        })

        $('#workout-tips').on('click', function(){
            window.location.href = "{{ url('/athlete/workouts') }}/"+workoutId+"/tips";
        })
    })

    async function getCategoryLibrary(id){
       
        $.ajax({
            type : "GET",
            // url : "{{ url('api/get-workouts/library') }}?workout_category_id="+id,
            url : "{{ url('/get-workouts/library') }}?workout_category_id="+id,
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    // alert(id); die;
                    $('#workouts-category-library').html('');
                    if(res.data.length > 0){
                        var checked = "";
                        res.data.forEach((v, k) => {
                            // console.log(v);
                            let disabled = '';
                            let display = '';
                            let showDiv = '';
                            let display_hover = '';
                            if(id != 8){
                                if(v.is_aci_index == 1){
                                    checked = 'checked';
                                    disabled = 'disabled';
                                    display = 'none';
                                    display_hover = 'block';
                                }else{
                                    checked = savedWorkoutLibrary.indexOf(v.id) >=0 ? 'checked' : '';
                                    // checked = v.checked == 1 ? 'checked' : '';
                                    showDiv = 'showDiv';
                                    display_hover = 'none';
                                    
                                }
                            }
                            else{
                                checked = v.checked == 1 ? 'checked' : '';
                                showDiv = 'showDiv';
                                display_hover = 'none';
                            }
                            let title = v.sport_category_title ?  v.sport_category_title : v.title;
                            $('#workouts-category-library').append('<div class="signinboxinput" data-toggle="popover">\
                                   <div  class="n-ppost" style="display:'+display_hover+' ;width: 40px;height: 40px;background: red;text-align: center;color: #fff;font-size: 20px;border-radius: 50%;position: absolute; padding: 6px 0 0 0; right: 14px;z-index: 999; top: 10px;">i</div>\
                                   <div class="n-ppost-name">To add this workout to your "My Workouts" Dashboard, select this item from the ACI Workout Library.</div>\
                                   <div class="accout5_radio">\
                                        <span>'+title+'</span>\
                                        <div class="accout5_checkright '+showDiv+'">\
                                            <div class="form-group '+showDiv+'" style="display:'+display+'">\
                                                <input class="checkBoxClass" type="checkbox" name="workout_library[]" id="accountcheckbox'+k+'" value="'+v.id+'" '+checked+' '+disabled+'>\
                                                <label for="accountcheckbox'+k+'"></label>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>'
                            );
                        });
                        $('#workout-add').show();
                        $('#workouts-category-library').append('<div class="clr"></div>');
                    }else{
                        $('#workout-add').hide();
                        swal('Sorry!! No data dound', 'Alert', 'warning');
                    }
                }
            },
            error: function(err){
                // console.log(err);
                swal('Sorry!! Something went wrong', 'Warning', 'warning');
            }
        }).done( () => {
            
        });
    }
</script>
<script>
    $(document).ready(function () {
    //    $(".checkBoxClass").prop('checked', false);
       $("#ckbCheckAll").click(function () {
           // $(".checkBoxClass").attr('checked', this.checked);
           $(".checkBoxClass").prop('checked', true);
       });

       $("#ckbCheckRemoveAll").click(function () {
           // $(".checkBoxClass").attr('checked', this.checked);
           $(".checkBoxClass").prop('checked', false);
       });
   });
</script>
<script>
     $(document).ready(function(){
      $("#search_value").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#workouts-category-library div").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
     });
</script>
@endsection