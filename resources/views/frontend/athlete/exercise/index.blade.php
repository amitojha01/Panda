@extends('frontend.athlete.layouts.app')
@section('title', 'Workouts')
@section('content')
<div class="dashboard_r">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="dashboard_r_top_l">
                    <h1>Workouts</h1>
                    <span>Welcome Back!</span>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="dashboard_r_top_r nobg">
                    <div class="serch">
                        <input type="button" class="searcgbtn" />
                        <input type="text" placeholder="Search" />
                    </div>
                    <a class="messageicon" href=""><img
                            src="{{ asset('public/frontend/athlete/images/message_icon.png') }}"
                            alt="message_icon" /><span></span></a>
                    <a class="messageicon" href=""><img
                            src="{{ asset('public/frontend/athlete/images/notification_icon.png') }}"
                            alt="message_icon" /><span></span></a>
                    <div class="clr"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clr"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12" id="workouts-category">
                <!-- <div class="workout_l_box">
                    <img src="{{ asset('public/frontend/athlete/images/workout_img1.png') }}" alt="workout_img1" />
                    <span>Strength</span>
                </div> -->
            </div>
            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="workout_right">
                    <div class="workout_right_l" id="category-info">
                        <img src="{{ asset('public/frontend/images/no-image-loading.jpg') }}" alt="workout_img_r" />
                        <h2 id="title">-</h2>
                        <p id="description">-</p>
                        <div class="activelicense">
                            <h4>Athlete Tips</h4>
                            <p>If your Club or School purchased a license for you, enter your code here to activate your
                                license.</p>
                            <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="workout_right_r">
                        <h2>Select workouts from list</h2>
                        <form action="" id="form-workout-library">
                            @csrf
                            <div class="signinbox" id="workouts-category-library">
                                <!-- dynamic data -->
                            </div>
                            <div align="center" id="workout-add" style="display: none">
                                <input type="hidden" name="workout_id" value="">
                                <button type="submi" id="save-workout" class="addyourdashboard">Add to your dashboard</button>
                            </div>
                        </form>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var workoutCategory="";
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
                            let image = base_url+v.image;
                            $('#workouts-category').append('<div class="workout_l_box workout-category" id="'+v.id+'">\
                                <img src="'+image+'" alt="workout_img" />\
                                <span>'+v.category_title+'</span>\
                            </div>');
                        })
                        $('.workout-category#'+res.data[0].id).click();
                    }               
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {            
        });

        $(document).on('click', '.workout-category', function(){
            $('.workout-category').removeClass('active');
            $(this).addClass('active');
            let id = $(this).attr('id');
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
                console.log(err);
            }
        }).done( () => {                
            getCategoryLibrary(id);
        });
            //add workoput Id to save data
            $('input[name="workout_id"]').val(id);
            //populate category info
            workoutCategory.forEach((v) => {
                if(v.id == id){
                    if(v.banner != null){
                        $('#category-info img').attr('src', base_url+v.banner);
                    }
                    $('#category-info #title').html(v.content_title);
                    $('#category-info #description').html(v.description);
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
                            console.log(err);
                            swal('Sorry!! Something went wrong', 'Warning', 'warning');
                        }
                    }).done( () => {
                        
                    });
                }
                });
                
        })
    })

    async function getCategoryLibrary(id){
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-workouts') }}/"+id+"/library",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                if(res.success){
                    $('#workouts-category-library').html('');
                    if(res.data.length > 0){
                        res.data.forEach((v, k) => {
                            let checked = savedWorkoutLibrary.indexOf(v.id) >=0 ? 'checked' : '';
                            $('#workouts-category-library').append('<div class="signinboxinput">\
                                    <div class="accout5_radio">\
                                        <span>'+v.title+'</span>\
                                        <div class="accout5_checkright">\
                                            <div class="form-group">\
                                                <input type="checkbox" name="workout_library[]" id="accountcheckbox'+k+'" value="'+v.id+'" '+checked+'>\
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
                console.log(err);
                swal('Sorry!! Something went wrong', 'Warning', 'warning');
            }
        }).done( () => {
            
        });
    }
</script>
@endsection