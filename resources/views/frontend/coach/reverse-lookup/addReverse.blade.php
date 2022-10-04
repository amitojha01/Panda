@extends('frontend.coach.layouts.app')
@section('title', 'Reverse Lookups')
@section('content')
<?php 
use App\Models\SportPosition;

?>

<div class="createteamingup">
    <div class="container-fluid">
        <div class="addgamehighlightes">
            <form method="post" action="{{ route('coach.save-reverse-lookups') }}" enctype="multipart/form-data">
                @csrf
                <div class="addgamehighlightesinner">
                    <h3>Reverse Lookups Criteria</h3>


                    <input type="hidden" name="reverseId" value="{{isset($data)?($data->id):''}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reverse Lookups Name</label>
                                <input type="text" class="form-control" name="name" placeholder="name"
                                    value="{{isset($data)?($data->name):''}}" required />
                                @if ($errors->has('name'))
                                <div class="text-danger" style="position:relative">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select the workout</label>
                                <select class="form-control" id="workout_library" name="workout_library" required>
                                    <option value="">Select</option>
                                </select>
                                @if ($errors->has('workout_library'))
                                <div class="invalid-feedback">{{ $errors->first('workout_library') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>From criteria</label>
                                <input type="text" class="form-control number-only" id="from_criteria" name="from_criteria"
                                    placeholder="Enter criteria" value="<?= @$data->from_criteria ?>" required />
                                <!-- @if ($errors->has('url'))
                                <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                                @endif -->
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Criteria unit</label>
                                <input type="text" class="form-control criteria_unit" id="criteria_first"
                                    name="criteria_first" placeholder="criteria" value="<?= @$measurement_unit->unit ?>" required readonly />
                                <!-- @if ($errors->has('url'))
                                <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                                @endif -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>To criteria</label>
                                <input type="text" class="form-control number-only" id="to_criteria" name="to_criteria"
                                    placeholder="Enter criteria" value="<?= @$data->to_criteria ?>" required />
                                <!-- @if ($errors->has('url'))
                                <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                                @endif -->
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Criteria unit</label>
                                <input type="text" class="form-control criteria_unit" id="criteria_first"
                                    name="criteria_first" placeholder="criteria" value="<?= @$measurement_unit->unit ?>" required readonly />
                                <!-- @if ($errors->has('url'))
                                <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                                @endif -->
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Birth Year equal to or greater than</label>
                                <!-- <input type="text" class="form-control datepicker"
                                    value="{{isset($data)?($data->start_year):''}}" name="start_year"
                                    placeholder="YYYY" required autocomplete="off"/>
                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span> -->
                               
                                <select class="form-control" name="start_year"  >                        
                                    <option value="">Select Year</option>
                                    @for($i= Date('Y')-5; $i>=1940; $i--)
                                    <option value="{{ $i }}"
                                    {{ @$data->start_year == $i ? 'selected' : ''}}
                                    >{{ $i }}</option>
                                    
                                    @endfor                                     
                                </select>

                                @if ($errors->has('start_year'))
                                <div class="text-danger" style="position:relative">{{ $errors->first('start_year') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Birth year equal to or less than</label>
                                <!-- <input type="text" class="form-control datepicker"
                                    value="{{isset($data)?($data->end_year):''}}" name="end_year"
                                    placeholder="YYYY" required autocomplete="off"/>
                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span> -->
                                <select class="form-control" name="end_year" >                        
                                    <option value="">Select Year</option>
                                    @for($i= Date('Y')-5; $i>=1940; $i--)
                                    <option value="{{ $i }}"
                                    {{ @$data->end_year == $i ? 'selected' : ''}}
                                    >{{ $i }}</option>
                                    @endfor                                     
                                </select>

                                
                                @if ($errors->has('end_year'))
                                <div class="text-danger" style="position:relative">{{ $errors->first('end_year') }}</div>

                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Graduation Year equal to or greater than </label>
                               
                                <select class="form-control" name="graduation_year_from" >
                                    <option value="">Select Year</option>>
                             <?php                          
                                for($i= Date('Y')+10; $i>=Date('Y')-50; $i--){
                                ?>
                                <option value="{{ $i }}" {{ @$data->graduation_year_from == $i ? 'selected' : ''}}>{{ $i }}</option>
                                <?php
                            }
                            ?> 
                        </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Graduation Year equal to or less than </label>
                               
                                <select class="form-control" name="graduation_year_to" >
                                    <option value="">Select Year</option>>
                             <?php                          
                                for($i= Date('Y')+10; $i>=Date('Y')-50; $i--){
                                ?>
                                <option value="{{ $i }}" {{ @$data->graduation_year_to == $i ? 'selected' : ''}}>{{ $i }}</option>
                                <?php
                            }
                            ?> 
                        </select>
                                
                            </div>
                        </div>

                        
                    </div>
                    <?php if(@$lookup_sport){ ?>

                        <div class="row lookup-sports">
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <label>Sports</label>
                                        
                                        <select class="form-control form-control-sm @error('sport_id') is-invalid @enderror  sportOption" name="sport_id[]" onchange="getSportPos(this)" >
                                            <option value="">--Select Sport--</option>
                                            <?php if($sport){
                                                foreach($sport as $value){
                                                    ?>
                                                    <option 
                                                    value="{{$value->id}}"
                                                    {{ $value->id == $lookup_sport[0]->sport_id ? 'selected': '' }}
                                                    >{{ $value->name }}  
                                                </option>
                                                <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <label>Sports Position 1</label>
                                    <?php 
                                    $position = SportPosition::where(['sport_id'=> $lookup_sport[0]->sport_id])->get();
                                    $pos_selected="";
                                                                                
                                    ?>
                                    <select class="form-control pvalone form-control-sm @error('sport_position_id') is-invalid @enderror sportpos-dropdown" name="first_position_id[]"  >
                                        <option value="">--Select position--</option>
                                        <?php if($position){
                                            foreach($position as $value){
                                                
                                                if($value->id==@$lookup_sport[0]->first_position_id){
                                                    $pos_selected='selected';

                                                }
                                                ?>
                                                <option 
                                                value="{{$value->id}}"
                                                {{ $pos_selected }}
                                                >{{ $value->name }}  
                                            </option>
                                            <?php $pos_selected="";
                                        }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12">
                                    <label>Sports Position 2</label>
                                    <?php 
                                    $position = SportPosition::where(['sport_id'=> $lookup_sport[0]->sport_id])->get();
                                    $pos_selected="";
                                    
                                    ?>
                                    <select class="form-control  form-control-sm @error('sport_position_id') is-invalid @enderror sportpos-dropdown" name="second_position_id[]" onchange="checkPosition1(this)" >
                                        <option value="">--Select Sport--</option>
                                        <?php if($position){
                                            foreach($position as $value){
                                                
                                                if($value->id== @$lookup_sport[0]->second_position_id){
                                                    $pos_selected='selected';

                                                }
                                                
                                                ?>
                                                <option 
                                                value="{{$value->id}}"
                                                {{ $pos_selected }}
                                                >{{ $value->name }}  
                                            </option>
                                            <?php $pos_selected="";
                                        }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-md-1 col-sm-12 col-xs-12 ">
                             <input type="button"  class="btn btn-primary" value="Add Sports" onclick="addSport()" style="margin-top:30px">
                         </div>
                            <div class="clr"></div>  
                        </div>

                        <?php
                        //foreach($lookup_sport as $val){  
                        for($i=1; $i<count($lookup_sport); $i++){  ?>

                            <div class="row lookup-sports">
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <label>Sports</label>
                                        
                                        <select class="form-control form-control-sm @error('sport_id') is-invalid @enderror  sportOption" name="sport_id[]" onchange="getSportPos(this)" requiredz>
                                            <option value="">--Select Sport--</option>
                                            <?php if($sport){
                                                foreach($sport as $value){
                                                    ?>
                                                    <option 
                                                    value="{{$value->id}}"
                                                    {{ $value->id == $lookup_sport[$i]->sport_id ? 'selected': '' }}
                                                    >{{ $value->name }}  
                                                </option>
                                                <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <label>Sports Position 1</label>
                                    <?php 
                                    $position = SportPosition::where(['sport_id'=> $lookup_sport[$i]->sport_id])->get();
                                    $pos_selected="";
                                    //print_r($position);
                                                                                
                                    ?>
                                    <select class="form-control pvalone form-control-sm @error('sport_position_id') is-invalid @enderror sportpos-dropdown" name="first_position_id[]"  >
                                        <option value="">--Select position--</option>
                                        <?php if($position){
                                            foreach($position as $value){
                                                
                                                if($value->id==@$lookup_sport[$i]->first_position_id){
                                                    $pos_selected='selected';

                                                }
                                                ?>
                                                <option 
                                                value="{{$value->id}}"
                                                {{ $pos_selected }}
                                                >{{ $value->name }}  
                                            </option>
                                            <?php $pos_selected="";
                                        }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12">
                                    <label>Sports Position 2</label>
                                    <?php 
                                    $position = SportPosition::where(['sport_id'=> $lookup_sport[$i]->sport_id])->get();
                                    $pos_selected="";
                                    
                                    ?>
                                    <select class="form-control  form-control-sm @error('sport_position_id') is-invalid @enderror sportpos-dropdown" name="second_position_id[]" onchange="checkPosition1(this)" >
                                        <option value="">--Select Sport--</option>
                                        <?php if($position){
                                            foreach($position as $value){
                                                
                                                if($value->id== @$lookup_sport[$i]->second_position_id){
                                                    $pos_selected='selected';

                                                }
                                                
                                                ?>
                                                <option 
                                                value="{{$value->id}}"
                                                {{ $pos_selected }}
                                                >{{ $value->name }}  
                                            </option>
                                            <?php $pos_selected="";
                                        }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-md-1 col-sm-12 col-xs-12 ">
                                <input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeSport(this)">

                            </div>
                            <div class="clr"></div>  
                        </div>

                    <?php } }else{ ?>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sport</label>
                                <select class="form-control" id="sport_id" name="sport_id[]" onchange="getSportPos(this)" >
                                    <option value="">Select</option>
                                    <?php if($sport){
                                                foreach($sport as $value){
                                                    ?>
                                                    <option 
                                                    value="{{$value->id}}"
                                                   
                                                    >{{ $value->name }}  
                                                </option>
                                                <?php
                                            }
                                        } ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sports Position 1</label>
                                <select class="form-control sport_position sportpos-dropdown" id="first_position" name="first_position_id[]"
                                    >
                                    <option value="">Select</option>
                                    
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sports Position 2</label>
                                <select class="form-control sport_position sportpos-dropdown" id="second_position" name="second_position_id[]"
                                    >
                                    <option value="">Select</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 ">
                           <input type="button"  class="btn btn-primary" value="Add Sports" onclick="addSport()" style="margin-top:30px">
                       </div>


                    </div>
                <?php }?>
                    <div class="sportlist"></div>
                     

                    <input type="submit" class="addhighlightsbtn" value="Submit" />
                    <!-- <input type="submit" class="addhighlightsbtn" value="Back"/> -->
                    <a href="" class="addhighlightsbtn eventsbackbtn">Back</a>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="clr"></div>

@endsection
@section('script')

<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
</script>

<script>
$(function() {
    $('.datepicker').datepicker({
        // minDate: 0
        dateFormat: 'yy',
        changeYear: true,
        yearRange: "1960:2030"
    });
})
</script>

@if ($message = Session::get('error'))
<script>
swal('{{ $message }}', 'Warning', 'error');
</script>
@endif
<script src="{{ asset('public/frontend/js/password.js') }}"></script>
<script>
// const state_id = "{{isset($data)?($data->state):'0'}}";
// console.log(state_id);
$(document).ready(function() {
        
    const workout_library = "{{isset($data)?($data->workout_library):'0'}}";
    $.ajax({
        type: "GET",
        url: "{{ url('api/get-workouts/library') }}",
        data: {},
        beforeSend: function() {
            //$("#overlay").fadeIn(300);
        },
        success: function(res) {
            console.log(res);
            if (res.success) {
                res.data.forEach((v) => {
                     
                    let selected = workout_library!=0 ? (workout_library == v.id ? 'selected': '') : '';
                        $('select[name="workout_library"]')
                        .append('<option value="'+v.id+'" '+selected+'>'+v.title+'</option>');

                })

            }
        },
        error: function(err) {
            console.log(err);
        }
    }).done(() => {})

})

// sport

const sport_id = "{{isset($data)?($data->sport_id):'0'}}";

$(document).ready(function() {
    
    $.ajax({
        type: "GET",
        url: "{{ url('api/get-sports') }}",
        data: {},
        beforeSend: function() {
            //$("#overlay").fadeIn(300);
        },
        success: function(res) {
            console.log(res);
            if (res.success) {
                res.data.forEach((v) => {
                    console.log(v);
                    let selected = sport_id != 0 ? (sport_id == v.id ? 'selected' : '') :
                        '';
                    $('select[name="sport_id"]')
                        .append('<option value="' + v.id + '" ' + selected + '>' + v.name +
                            '</option>');
                })

            }
        },
        error: function(err) {
            console.log(err);
        }
    }).done(() => {})

})

$('#sport_id').on('change', function() {
    var sport_id_ser = $('#sport_id option:selected').val();

    // alert(sport_id_ser);
    $(document).ready(function() {
        //Club
        $.ajax({
            type: "GET",
            url: "{{ url('/sport-position-get?sport_id=') }}" + sport_id_ser,
            data: {},
            beforeSend: function() {
                //$("#overlay").fadeIn(300);
            },
            success: function(res) {
                console.log(res);
                res.data.forEach((v) => {
                    console.log(v);
                    let selected = sport_id != 0 ? (sport_id == v.id ? 'selected' :
                            '') :
                        '';

                    $('select[name="first_position"]')
                        .append('<option value="' + v.id + '" >' + v.name +
                            '</option>');
                    $('select[name="second_position"]')
                        .append('<option value="' + v.id + '" >' + v.name +
                            '</option>');
                })
            },
            error: function(err) {
                console.log(err);
            }
        }).done(() => {})

    });
});


// state_id
$('#workout_library').on('change', function() {
    var workout_library_id = $('#workout_library option:selected').val();

    // alert(workout_library_id);
    $(document).ready(function() {
        //Club
        $.ajax({
            type: "GET",
            url: "{{ url('/library-measurements-get?workout_library_id=') }}" +
                workout_library_id,
            data: {},
            beforeSend: function() {
                //$("#overlay").fadeIn(300);
            },
            success: function(res) {
                console.log(res);
                if (res.success) {
                    // var v = '';

                    $('.criteria_unit').val(res.data.unit);

                }
            },
            error: function(err) {
                console.log(err);
            }
        }).done(() => {})

    });
});
</script>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});


$('.number-only').keyup(function(e) {
        if(this.value!='-')
          while(isNaN(this.value))
            this.value = this.value.split('').reverse().join('').replace(/[\D]/i,'')
                                   .split('').reverse().join('');
    })
    .on("cut copy paste",function(e){
        e.preventDefault();
    });

    //==Sport===
    function addSport(){ 
          
        var list="";        
        $.ajax({
            url:"{{url('coach/get-sportslist')}}",
            type: "GET",
            data: {
                _token: '{{csrf_token()}}' 
            },
            dataType : 'json',
            success: function(result){
                console.log(result);

             list+='<div class="row">';
             list+='<div class="form-group col-md-3">';
             list+='<label>Sports</label>';
          
             list+='<input type="hidden" name="sprtId[]" class="sprtId" value="">'; 
             list+='<select class="form-control form-control-sm  sportOption " name="sport_id[]" onchange="getSportPos(this)" required>';
            list+='<option value="">--Select Sport--</option>';
            $.each(result.sport,function(key,value){
                list+='<option value="'+value.id+'">'+value.name+'</option>';
                    
                });
           
            list+='</select>';
            list+='</div>';
            list+='<div class="col-md-4">';
            list+='<label>Sports Position 1</label>';
            list+='<select class="form-control pvalone form-control-sm   sportpos-dropdown" name="first_position_id[]" onchange="checkPosition2(this)" >';
            list+='<option value="">--Select Sport--</option>';
            
            list+='</select>';
            list+='</div>';



     
            list+='<div class="col-md-4">';
            list+='<label>Sports Position 2</label>';
            list+='<select class="form-control pvaltwo form-control-sm   sportpos-dropdown" name="second_position_id[]" onchange="checkPosition1(this)">';
            list+='<option value="">--Select Sport--</option>';
            
            list+='</select>';
            list+='</div>';
          
            list+='<div class="col-md-1">';
            list+='<input type="button" style="margin-top:30px;" class="btn btn-danger" value="Remove" onclick="removeSport(this)">';
                    
            list+='</div>';
            list+='</div>';
            $('.sportlist').append(list);
            }
        });
    }


    function getSportPos(dis){      
            var sport_id = dis.value;
                       
            //$(dis).closest('.row').find('.sprtId').val(sport_id);
            $.ajax({
                url:"{{url('coach/get-sport-position')}}",
                type: "GET",
                data: {
                    sport_id: sport_id,
                    _token: '{{csrf_token()}}' 
                },
                dataType : 'json',
                success: function(result){
                    console.log(result);
                    $(dis).closest('.row').find('.sportpos-dropdown').html('<option value="">Select Sport Position</option>'); 
                    $.each(result.position,function(key,value){
                        $(dis).closest('.row').find('.sportpos-dropdown').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });

                }
            });

        }

        function removeSport(dis){
       $(dis).closest(".row").remove();
    }
</script>
@endsection