@extends('frontend.layouts.coach')
@section('title', 'Registration | Coach | Colleges')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/example-styles.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/demo-styles.css') }}"> -->
@endsection
@section('content')
<div class="">
    <div class="signinheader">
        <div class="signinheader_l">
            <a href="">
                <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" />
            </a>
        </div>
        <div class="clr"></div>
    </div>
    <div class="signinbox createaccount2">
		<h2>Create Account</h2>
		<span>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod 
            <a><b>06</b>/06</a>
        </span>
		<h5>CURRENT UNIVERSITY OR COLLEGE - COACHING</h5>
        <div class="searchpanelbox desiredcollegessearch">
            <div class="searaddathletes">
                <input type="text" placeholder="Search for Collage" id="input-name">
                <input type="button" class="searaddathletesbtn" value="" id="get-by-name">
                <div class="clr"></div>
            </div>
            <div class="filter">
                <a href="javascript:void(0);" data-toggle="modal" data-target="#invitealink">
                    <img src="{{ asset('public/frontend/images/filter_option.jpg') }}" alt=""></a>
                </div>
            <div class="clr"></div>
        </div>
        <form id="frmRegistrationStep-5" method="post" action="{{ route('registration.coach.step-five') }}">
            @csrf
            <div class="signinbox">
			    <div id="testDiv" class="colleges-data">
                    <!-- data -->
                </div>
            </div>	
            <div class="clr"></div>
            <input type="submit" class="savecontinue" value="Save & continue"/>
            <a href="{{ URL::previous() }}" class="back">Back</a>
        </form>
	</div>
    <div class="clr"></div>
    @include('frontend.layouts.footer')
</div>
<!-- Modal -->
<div class="modal fade" id="invitealink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog filterpopup" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <i class="fa fa-map-marker" aria-hidden="true"></i>
       	<h3>Advanced Search</h3>
        <div class="searchmodalbox">       	 	
			<div class="searchmodalbox_l">
                <i class="fa fa-flag" aria-hidden="true"></i>
            </div>	
            <div class="searchmodalbox_r">
                <select class="search-select" id="division_id" multiple>
                    <!--  -->
                </select>
            </div>
            <div class="clr"></div>				        	 	
       	</div>
        <div class="searchmodalbox">       	 	
			<div class="searchmodalbox_l">
                <i class="fa fa-flag" aria-hidden="true"></i>
            </div>	
            <div class="searchmodalbox_r">
                <select class="search-select" id="state_id"  multiple>
                    <!--  -->
                </select>
            </div>
            <div class="clr"></div>				        	 	
       	</div>
        <div class="searchmodalbox">       	 	
			<div class="searchmodalbox_l">
                <i class="fa fa-flag" aria-hidden="true"></i>
            </div>	
            <div class="searchmodalbox_r">
                <select class="search-select" id="conference_id"  multiple>
                    <!--  -->
                </select>
            </div>
            <div class="clr"></div>				        	 	
       	</div>
       	 <div align="center">
            <button type="button" class="showresult" id="get-filter">Show Results</button>
        </div>
      </div>      
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.multi-select.js')}}"></script> 
<script src="{{ asset('public/frontend/js/jquery.slimscroll.js') }}"></script>
<script>
    $(function(){
        //$('.search-select').multiSelect();
    });
    $(document).ready(function(){
        $('input[name="colleges[]"]').on('click', function(){
            if($('input[name="sports[]"]:checked').length > 4){
                swal("Alert", "You can select max 4 Colleges", "warning");
                return false;
            }
        })

        $('#frmRegistrationStep-5').submit(function(e){
            if($('input[name="colleges[]"]:checked').length < 1){
                swal("Alert", "You must select min 1 college", "warning");
                return false;
            }
        })

        $.ajax({
            type : "GET",
            url : "{{ url('api/get-competitive-level') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[id="division_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })
                    $('#division_id').multiSelect();
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });

        $.ajax({
            type : "GET",
            url : "{{ url('api/get-conference') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[id="conference_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })
                    $('#conference_id').multiSelect();
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });

        $.ajax({
            type : "GET",
            url : "{{ url('api/get-state') }}?country_id=231",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[id="state_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })
                    $('#state_id').multiSelect();
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });

        $('#get-filter').on('click', function(){
            let division = $('#division_id').val();
            console.log(division);
            if(division){
                division = division.join();
            }else{
                division =  '';
            }
            let states = $('#state_id').val();
            if(states){
                states = states.join();
            }else{
                states = ''; 
            }
            let conferences = $('#conference_id').val();
            if(conferences){
                conferences = conferences.join();
            }else{
                conferences = '';
            }
            getCollegeDate(title='', division=division, state=states, conference=conferences);
        })

        getCollegeDate();

        $('#get-by-name').on('click', function(){
            getCollegeDate( $('#input-name').val() );

        })
    })

    function getCollegeDate(title='', division='', state='', conference=''){
        $.ajax({
            type : "GET",
            url : "{{ url('api/get-colleges') }}?title="+title+"&division_id="+division+"&state_id="+state+"&conference_id="+conference,
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                if(res.success){
                    $('.colleges-data').html('');
                    res.data.forEach((v, k) => {
                        let clas = (k+1)%2==0? 'signinboxinput2' : 'signinboxinput';
                        let img = "{{ url('/') }}/"+(v.icon ? v.icon : 'public/frontend/images/dgreecap.png');
                        let d = '<div class="'+clas+'">\
                                    <div class="accout5_radio desiredcolleges">\
                                        <img src="'+img+'" alt="dgreecap"/>\
                                        <b>'+v.name.toUpperCase()+'<em>-</em></b>\
                                        <div class="accout5_checkright">\
                                            <div class="form-group">\
                                            <input type="checkbox" id="accountcheckbox'+k+'" name="colleges[]" value="'+v.id+'">\
                                            <label for="accountcheckbox'+k+'"></label>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>';
                        $('.colleges-data').append(d);
                    })                    
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });
    }
</script>
@endsection