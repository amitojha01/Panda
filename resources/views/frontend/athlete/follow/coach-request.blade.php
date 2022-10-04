@extends('frontend.athlete.layouts.app')
@section('title', 'Coach Request')
@section('content')
<?php 
use App\Models\UserPhysicalInformation;
use App\Models\Education;
use App\Models\User;
use App\Models\Country;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="dashtabletab">
                <div class="tab-container">

                    <div class="tab-menu1">
                      <ul>
                       <!-- <li><a href="#" class="tab-a1 active-a1" data-id="tab1">Recommendation Requests</a></li>
                         <li><a href="#" class="tab-a1" data-id="tab2">Players Following</a></li> -->
                         <li><a href="#" class="tab-a1" data-id="tab3">Coach Requesting to be Followed</a></li>
                     </ul>
                 </div>

                 <div  class="tab1 tab-active1" data-id="tab3">
                   <div class="table-responsive">
                      <table cellpadding="0" cellspacing="0" width="100%" class="coachdashtable">
                        <?php   
                        if(count($coach_request) > 0){
                            foreach($coach_request as $list){    
                                $user_detail = User::where('id', $list->user_id)
                                ->with('address')->first();                           

                                $country_name="";                           
                                if(!empty(@$user_detail->address[0]->country_id)){
                                    $country_name = Country::where('id', $user_detail->address[0]->country_id)->first();
                                }

                                $education = UserPhysicalInformation::where('user_id', @$list->user_id)->first();
                                $edu_res= Education::where('id', @$education->id)->first();

                                ?>
                                <tr>
                                    <td><span class="coachtableimg">
                                        @if($user_detail->profile_image!="")                    
                                        <!-- <img src="{{ asset($user_detail->profile_image) }}" alt="user_img"/> -->
                                        <img src="{{ asset('public/frontend/images/noimage.png') }}" alt="user_img"/>
                                        @else
                                        <img src="{{ asset('public/frontend/images/noimage.png') }}" alt="user_img"/>
                                        @endif

                                    </span></td>
                                    <td>
                                        <h6>{{$user_detail->username}}</h6>
                                        
                                    </td>
                                    <td>{{@$edu_res->name}}</td>
                                    <td>{{ @$user_detail->year}}</td>
                                    <td><a class="writerecommendedlink" href="javascript:void(0)" onclick="request_response(<?= $list->fid ?>,'2')">Accept</a></td>
                                    <td><a class="writerecommendeddeny" onclick="request_response(<?= $list->fid ?>, '3')" href="javascript:void(0)">Deny</a></td>
                                </tr>
                            <?php } }else{?>
                                <tr>
                                    <td></td>
                                   
                                    <td></td>
                                    <td></td>
                                     <td>No Result Found!!</td>
                                    <td></td>
                                    <td></td>

                                </tr>

                            <?php } ?>                            

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

</div>
</div>
</div>
<div class="clr"></div>
@endsection

@section('script')
<script>

    function request_response(follower_id, status){
       
        $.ajax({
            type: "POST",
            url: "{{ route('athlete.request-response') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                follower_id: follower_id,
                status:status

            },
            dataType: "JSON",
            beforeSend: function() {
                //$("#overlay").fadeIn(300);
                // $('#eventsmodaldetails').empty();
            },
            success: function(res) {
                console.log(res);
                if (res.success) {
                    swal(res.message, 'Success', 'success')
                        .then(() => {
                            location.reload();
                        });
                }
            }
        });
    }

</script>
