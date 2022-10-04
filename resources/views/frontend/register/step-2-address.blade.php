@extends('frontend.layouts.app')
@section('title', 'Registration | Address Information')

@section('content')
<div class="">
    <div class="signinheader">
        <div class="signinheader_l"><a href="{{URL::to('/')}}">
                <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" /></a></div>
        <!-- <div class="signinheader_r">
            <span>Don't have an account? <a href="">Try Now</a></span>
        </div> -->
        <div class="clr"></div>
    </div>
    <div class="signinbox createaccount2">
        <h2>Create Account</h2>
        <span>
            <a><b>02</b>/06</a>
        </span>
        <h5>Address Information</h5>
        <form id="frmRegistrationStep-address" method="post" action="{{ route('registration.step-address', $type) }}">
            @csrf
            <div class="signinbox">		
                <div class="signinboxinput">
                    <label for="country_id">Country</label>
                    <select class="form-control" name="country_id" required>
                        <!-- <option value="">--Select--</option> -->
                    </select>
                </div>
                <div class="signinboxinput2">
                    <label for="state_id">State</label>
                    <select class="form-control" name="state_id" required>
                        <option value="">--Select--</option>
                        @foreach($states as $state)
                        <option value="{{ @$state->id }}">{{ @$state->name }}</option>                        
                        @endforeach
                    </select>
                </div>
                <div class="signinboxinput">
                    <label for="city_id">City</label>
                    <select class="form-control" name="city_id" required>
                        <option value="">--Select--</option>
                    </select>
                </div>
                <div class="signinboxinput2">
                    <label>Zip Code</label>
                    <!-- <select class="form-control" name="zip" >
                        <option value="">--Select--</option>
                    </select> -->
                    <input type="number" onkeyup="checkZip(this)" class="form-control" name="zip" value="" placeholder="#####" required> 
                    <span id="zipErr" style="color:red; display:none">Please enter valid zip code!! </span>
                </div>
                <div class="clr"></div>
            </div>
            <input type="submit" id="addrsavebtn" class="savecontinue" value="Save & continue" />
           <!--  <a href="{{ URL::previous() }}" class="back">Back</a> -->
        </form>
    </div>
    <div class="clr"></div>
    @include('frontend.layouts.footer')
</div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-country') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                if(res.success){
                    $('select[name="country_id"]')
                    .append('<option value="231" selected>United States</option>');
                    /*res.data.forEach((v) => {
                        $('select[name="country_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    }) */                   
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });

        //get state list for a country
        $('select[name="country_id"]').on('change', function(){
            let id = $(this).val();
            $.ajax({
                type : "GET",
                url : "{{ url('api/get-state') }}?country_id="+id,
                data : {},
                beforeSend: function(){
                    //$("#overlay").fadeIn(300);
                },
                success: function(res){
                    if(res.success){
                        $('select[name="state_id"]').html('<option value="">--Select--</option>');
                        res.data.forEach((v) => {
                            $('select[name="state_id"]')
                            .append('<option value="'+v.id+'">'+v.name+'</option>');
                        })                    
                    }
                },
                error: function(err){
                    console.log(err);
                }
            }).done( () => {
                
            });
        })

        //get city list for a country
        $('select[name="state_id"]').on('change', function(){
            let id = $(this).val();
            $.ajax({
                type : "GET",
                url : "{{ url('api/get-city') }}?state_id="+id,
                data : {},
                beforeSend: function(){
                    //$("#overlay").fadeIn(300);
                },
                success: function(res){
                    if(res.success){
                        $('select[name="city_id"]').html('<option value="">--Select--</option>');
                        res.data.forEach((v) => {
                            $('select[name="city_id"]')
                            .append('<option value="'+v.id+'">'+v.name+'</option>');
                        })                    
                    }
                },
                error: function(err){
                    console.log(err);
                }
            }).done( () => {
                
            });
        })

        //get Zip code for a city
        $('select[name="city_id"]').on('change', function(){
            let id = $(this).val();
            // console.log(id);
            $.ajax({
                type : "GET",
                url : "{{ url('api/get-zip-codes') }}?city_id="+id,
                data : {},
                beforeSend: function(){
                    // $("#overlay").fadeIn(300);
                },
                success: function(res){
                    if(res.success){
                        $('select[name="zip"]').html('<option value="">--Select--</option>');
                        res.data.forEach((v) => {
                             $('select[name="zip"]')
                            .append('<option value="'+v.zip+'">'+v.zip+'</option>');
                        })                    
                    }
                },
                error: function(err){
                    console.log(err);
                }
            }).done( () => {
                
            });
        })
    })

     function checkZip(dis){
        var zip_length= $(dis).val().length;        
        if(zip_length!=5){
            $('#zipErr').show();
            $('#addrsavebtn').attr("disabled", true);
        }else{
            $('#zipErr').hide();
            $('#addrsavebtn').attr("disabled", false);
            
        }
    }
</script>
@endsection