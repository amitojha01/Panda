@extends('frontend.layouts.coach')
@section('title', 'Registration | Coach | Other Informations')
@section('style')
<style>
    .accout5_radio img{
        width: 30px;
    }
</style>
@endsection
@section('content')
<div class="">
<div class="signinheader">
        <div class="signinheader_l"><a href="">
                <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" /></a></div>
        <!-- <div class="signinheader_r">
            <span>Don't have an account? <a href="">Try Now</a></span>
        </div> -->
        <div class="clr"></div>
    </div>
	<div class="signinbox createaccount2">
		<h2>Create Account</h2>
		<span>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod 
			<a><b>03</b>/06</a>
		</span>
		<h5>Other information</h5>
		<form action="{{ route('registration.coach.other-information')}}" method="POST">
			@csrf
			<div class="signinbox">		
				<div class="signinboxinput">
					<label>Level Coaching</label>
					<select class="form-control" name="coaching_level" id="coach_level" required>
						<option value="">--Select--</option>
						
						@foreach($coach_level as $level)
						<option value="{{ $level->id }}" {{ $level->id == 2 ? 'selected' : ''}}>{{ $level->name }}</option>
						@endforeach

						<!-- <option value="college" selected>College</option>
						<option value="school">School</option> -->
					</select>
				</div>
				<div class="signinboxinput2">
					<label>Sport</label>
					<select class="form-control" name="sport_id" required>
						<option value="">--Select--</option>
					</select>
				</div>
				<div class="signinboxinput" id="sec-college">
					<label>Current College Name</label>

				 <input id="myInput" type="text" name="myCountry" placeholder="Country">
					<!-- <select class="form-control" name="college_id" required>
						<option value="">--Select--</option>
					</select> -->

					

           
           
					<!-- <input type="text" class="form-control" id="search_college" name="college_id">
					<div id="suggesstion-box"></div> -->

				</div>
				<div class="signinboxinput" id="sec-school" style="display: none">
					<label id="level_name">Current School Name</label>
					<input type="text" class="form-control" name="school">
				</div>
				<div class="signinboxinput2">
					<div class="genderlabel genderradiobox">
					<label>Gender of Sport Coaching</label>
					<div class="clr"></div>
					<p>
					<input type="radio" id="test2" name="gender_of_coaching" value="male" {{ old('gender_of_coaching') == 'male'? 'checked': ''}}>
					<label for="test2">Male</label>
					</p>
					<p>
					<input type="radio" id="test3" name="gender_of_coaching" value="female" {{ old('gender_of_coaching') == 'female'? 'checked': ''}} >
					<label for="test3">Female</label>
					</p>
					<p>
					<input type="radio" id="test4" name="gender_of_coaching" value="both" {{ old('gender_of_coaching') == 'both'? 'checked': ''}}  checked="">
					<label for="test4">Both</label>
					</p>
					</div>
					@if ($errors->has('gender_of_coaching'))
                        <span class="text-danger">{{ $errors->first('gender_of_coaching') }}</span>
                    @endif
				</div>
				<div class="clr"></div>
				<div class="signinboxinput2 genderlabel">
					<div class="">
					<label>Your Bio</label>
					<div class="clr"></div>
						<textarea class="yourbiotextarea" name="about" placeholder="Type here or copy and paste" required>{{old('about')}}</textarea>
					</div>
					@if ($errors->has('about'))
                        <span class="text-danger">{{ $errors->first('about') }}</span>
                    @endif
				</div>
				<div class="signinboxinput2 genderlabel">
					<div class="">
					<label>Your Bio Link</label>
					<div class="clr"></div>
						<input type="url" class="form-control" name="about_link" value="{{ old('about_link') }}" placeholder="http://">
					</div>
					@if ($errors->has('about_link'))
                        <span class="text-danger">{{ $errors->first('about_link') }}</span>
                    @endif
				</div>
				<div class="signinboxinput">
					<label>Contact Preference</label>
					<select class="form-control" name="preference_id" required>
						<option value="">--Select--</option>
					</select>
				</div>
				<div class="signinboxinput2">
					<div class="reference_checkright">
					<div class="form-group">
					<input type="checkbox" id="html" name="serve_as_reference" value="1"
							{{ old('serve_as_reference') == 1 ? 'checked' : '' }}
					>
					<label for="html"> &nbsp; Are you willing to serve as a reference?</label>
					</div>
					</div>
				</div>
				<div class="clr"></div>
			</div>
			<input type="submit" class="savecontinue" value="Save & continue"/>
			<a href="{{ URL::previous() }}" class="back">Back</a>
		</form>
	</div>
	<div class="clr"></div>
	@include('frontend.layouts.footer')
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
		$('select[name="coaching_level"]').on('change', function(){
			let option = $(this).val();
			var coach_level= $("#coach_level option:selected").text()+' Name';
			$('#level_name').text(coach_level);
						
			console.log(option);
			/*if(option == 'school'){
				$('#sec-school').show();
				$('#sec-school .form-control').prop('required', true);
				$('#sec-college').hide();
				$('#sec-college .form-control').prop('required', false);
			}else{
				$('#sec-school').hide();
				$('#sec-school .form-control').prop('required', false);
				$('#sec-college').show();
				$('#sec-college .form-control').prop('required', true);
			}*/
			if(option == '2'){
				$('#sec-school').hide();
				$('#sec-school .form-control').prop('required', false);
				$('#sec-college').show();
				$('#sec-college .form-control').prop('required', true);
			}else{
				$('#sec-school').show();
				$('#sec-school .form-control').prop('required', true);
				$('#sec-college').hide();
				$('#sec-college .form-control').prop('required', false);
			}

		})
		$.ajax({
            type : "GET",
            url : "{{ url('api/get-preference') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[name="preference_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })                    
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });

		//Club
		$.ajax({
            type : "GET",
            url : "{{ url('api/get-colleges') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[name="college_id"]')
                        .append('<option value="'+v.id+'">'+v.name+'</option>');
                    })                    
                }
            },
            error: function(err){
                console.log(err);
            }
        }).done( () => {
            
        });
		//Sports
		$.ajax({
            type : "GET",
            url : "{{ url('api/get-sports') }}",
            data : {},
            beforeSend: function(){
                //$("#overlay").fadeIn(300);
            },
            success: function(res){
                console.log(res);
                if(res.success){
                    res.data.forEach((v) => {
                        $('select[name="sport_id"]')
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

    //====
    $("#search-box").keyup(function(){
    	alert('hh');
    	var words = [
  'random', 'list', 'of', 'words',
  'draisine', 'swithe', 'overdiversification', 'bitingness',
  'misestimation', 'mugger', 'fissirostral', 'oceanophyte',
  'septic', 'angletwitch', 'brachiopod', 'autosome',
  'uncredibility', 'epicyclical', 'causticize', 'tylotic',
  'robustic', 'chawk', 'mortific', 'histotomy',
  'slice', 'enjambment', 'mercaptids', 'oppositipetalous',
  'impious', 'pollinivorous', 'poulaine', 'wholesaler'
];
		$.ajax({
		/*type: "POST",
		url: "readCountry.php",
		data:'keyword='+$(this).val(),*/

		type : "GET",
            url : "{{ url('api/get-sports') }}",
            data : {},
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			console.log(data);
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(words);
			//$("#search-box").css("background","#FFF");
		}
		});
	});
    //====

    //===6-Nov-2021===
    
    function autocomplete(inp, arr) {

  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
 /* inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        
        currentFocus++;
        addActive(x);
      } else if (e.keyCode == 38) { 
        currentFocus--;
        addActive(x);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          if (x) x[currentFocus].click();
        }
      }
  });*/
  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
  
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
   
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
   
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }

  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
      });
}


$.ajax({
		

		type : "GET",
            url : "{{ url('api/get-sports') }}",
            data : {},
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			console.log(data);
			autocomplete(document.getElementById("myInput"), data);
			//$("#suggesstion-box").show();
			//$("#suggesstion-box").html(data);
			//$("#search-box").css("background","#FFF");
		}
		});

/*An array containing all the country names in the world:*/
var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
//autocomplete(document.getElementById("myInput"), countries);
  </script>>

  
<!-- </script> -->
@endsection