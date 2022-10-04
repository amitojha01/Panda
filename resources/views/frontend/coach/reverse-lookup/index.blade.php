@extends('frontend.coach.layouts.app')
@section('title', 'Reverse Lookups')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                    <div class="addathe_box_l">
                        <h4>Reverse Lookup Criteria</h4>
                    </div>
                </div>
                <div class="col-md-6 col-md-4 col-sm-12 col-xs-12-12 col-xs-12">
                    <div class="addathe_box_r">
                        <a href="{{route('coach.add-reverse-lookup')}}" class="criteriabtn">Add criteria</a>
                    </div>
                </div>
            </div>

            <table class="tabtable" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th>SL No.</th>
                    <th>Name</th>
                    <!-- <th>End Date</th>
                                <th>Sport</th>
                                <th>Event Name</th>
                                <th>Type of event</th>
                                <th>Location</th>
                                <th>Link to Event</th> -->
                    <th>Action</th>
                </tr>
                @if($reverseList)
                @foreach($reverseList as $key => $reverseList_details)
                <tr>

                    <td>{{ $key+1}}</td>
                    <td>{{ $reverseList_details->name }}</td>
                    <!-- <td>{{ $reverseList_details->end_date }}</td>
                                <td>{{ $reverseList_details->sp_name }}</td>
                                <td>{{ $reverseList_details->event_name }}</td>
                                <td>{{ $reverseList_details->ev_name }}</td>
                                <td>{{ $reverseList_details->location }}</td>
                                <td>{{ $reverseList_details->url }}</td> -->
                    <td>
                        <!-- <button data-id="" class="btn-delete-row comparison-delete"><i class="fa fa-trash-o"
                                            aria-hidden="true"></i></button> -->
                        <a href="{{url('coach/edit-reverse-lookup/'.$reverseList_details->id)}}"><i class="fa fa-pencil"
                                aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" data-id="{{$reverseList_details->id}}" class="btn-delete-row"><i
                                class="fa fa-trash-o" aria-hidden="true"></i></a>
								<a href="{{url('coach/view-reverse-lookup/'.$reverseList_details->id)}}"><i class="fa fa-eye"
                                aria-hidden="true"></i></a>
                    </td>
                </tr>
                @endforeach
                @endif
            </table>


            <!-- <div>
                <div class="row">
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="added_athbtn" value="Follow" />
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="add_athbtn" value="Following" />
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="added_athbtn" value="Follow" />
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="add_athbtn" value="Following" />
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="added_athbtn" value="Follow" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="add_athbtn" value="Following" />
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="added_athbtn" value="Follow" />
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="add_athbtn" value="Following" />
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="added_athbtn" value="Follow" />
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="addathebox">
                            <a class="deleteathletes" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <div class="addatheboximg">
                                <img src="{{ asset('public/frontend/coach/images/addathe_user_img.png') }}"
                                    alt="addathe_user_img" />
                            </div>
                            <h5>Steve Smith</h5>
                            <span>Athlete, Harrisburg, PA</span>
                            <input type="button" class="add_athbtn" value="Following" />
                        </div>
                    </div>

                </div>
            </div> -->
        </div>
    </div>
</div>
</div>
<div class="clr"></div>
</div>

@endsection

@section('script')

<script>
$(document).ready(function() {

    $('.btn-delete-row').on('click', function() {
        let id = $(this).data('id');
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{url('coach/delete-reverse-lookup')}}" + "/" + id,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            console.log(data);
                            swal(data.message, 'Success', 'success')
                                .then(() => {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    return false;
                }
            });
    });
})
</script>

@endsection