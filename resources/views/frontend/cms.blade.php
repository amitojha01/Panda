@extends('frontend.layouts.app')
@section('title', 'CMS')

@section('content')
<div class="signin">
    <div class="signinheader">
        <div class="signinheader_l"><a href="{{URL::to('/')}}">
          <img src="{{ asset('public/frontend/images/signin_logo.png') }}" alt="signin_logo" /></a></div>
        <div class="signinheader_r">
            <span>Don't have an account? <a href="{{ route('registration') }}">Try Now</a></span>
        </div>
        <div class="clr"></div>
    </div>

    <div class="tremsuser">
        <div id="temsuse">
            <h2>{{ $title }}</h2>
            {!! $cms_data? $cms_data->content: '' !!}

        </div>
    </div>
    <div class="clr"></div>
    @include('frontend.layouts.footer')
</div>
@endsection
@section('script')
<script src="{{ asset('public/frontend/js/jquery.slimscroll.js') }}"></script> 
@endsection