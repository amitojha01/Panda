@extends('frontend.athlete.layouts.app')
@section('title', 'Sent Email List')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

             <form  id="emailForm" action="{{ route('athlete.emailcoach') }}" method="POST" >
        @csrf
            <div class="row">
                <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                    <div class="addathe_box_l">
                        <h4>Sent List</h4>
                    </div>
                </div>
                <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                    <div class="addathe_box_r">
                       <a href="{{ route('athlete.email-coach') }}" class="addhighlightsbtn" style="padding: 6px 15px 6px 15px;">Back</a> 
                       
                    </div>
                </div>
                
            </div>

            <table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th>SL No.</th>
                    <th>Date</th>
                    <th>Recipient Email</th>
                    <th>Subject</th>
                    <th>Message</th>

                    <!-- <th>Action</th> -->
                </tr>
                @if($sent_list)
                @foreach($sent_list as $key => $list)
                <tr data-email="{{ $list->email }}">

                    <td>{{ $key+1}}</td>
                    <td>{{  date('m/d/Y', strtotime($list->created_at))  }}</td>
                    <td>{{ $list->recipient_email }}</td>
                    <td>{{ $list->subject }}</td>
                    <td>{{ $list->message }}</td>
                    <!-- <td><input type="checkbox" onchange="emailCheck(this)"></td> -->
                </tr>
                @endforeach
                @endif
            </table>

        </div>
    </form>
    </div>
</div>
</div>
<div class="clr"></div>
</div>

@endsection

@section('script')

<script>


    function emailCheck(dis){
        var checkboxcount= $('#checkboxcount').val();
        if($(dis).prop('checked') == true){
            if(checkboxcount==2){
                $(dis).prop('checked', false);
                    swal('Alert', 'You cannot check more than two checkbox', 'error');

                    return false;
                } 

           var countinc= parseInt(checkboxcount) + 1;
           $('#checkboxcount').val(countinc);  
          var coachemail = $(dis).parent('td').parent('tr').attr('data-email');
          
          $('#coachEmail'+countinc).val(coachemail);     
       }
      
       if(checkboxcount!=0 && $(dis).prop('checked') == false ){
         var countinc= parseInt(checkboxcount) - 1;
           $('#checkboxcount').val(countinc); 
            $('#coachEmail'+checkboxcount).val('');  
       }

    }

    $( "#emailForm" ).submit(function() {
       var checkboxcount= $('#checkboxcount').val();
       if(checkboxcount==0){
        swal('Alert', 'Please check atleast one checkbox', 'error');
         return false;

       }
       
   });
    
</script>

@endsection