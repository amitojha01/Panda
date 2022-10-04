<header>
    <nav id="cssmenu">
        <div id="head-mobile"></div>
        <div class="button"></div>
        <ul>
<li class="{{ Request::routeIs('coach.dashboard') ? 'active' : '' }}"><a href="{{ url('/coach/dashboard') }}"><img src="{{ asset('public/frontend/coach/images/nav1.png') }}" alt="nav1"/>
<span>Dashboard</span>
</a></li>

<li class="{{ Request::routeIs('coach.compare') ? 'active' : '' }}">
    <a href="{{ route('coach.compare') }}">
        <img src="{{ asset('public/frontend/coach/images/nav3.png') }}" alt="nav3" />
       <span> PANDA Compare<sup>TM</sup></span>
  </a>
</li>

<li class="{{ Request::routeIs('coach.connections') ? 'active' : '' }}"><a href="{{ route('coach.connections') }}">
   <img src="{{ asset('public/frontend/coach/images/nav6.png') }}" alt="nav6" /><span>Panda Connect <sup>TM</sup></span></a></li>


<li class="{{ Request::routeIs('coach.teamingup-group') ? 'active' : '' }}"><a href="{{ route('coach.teamingup-group') }}"><img src="{{ asset('public/frontend/coach/images/nav5.png') }}" alt="nav5"/><span>TeamingUP<sup>TM</sup> Groups</span></a></li>


<li class="{{ Request::routeIs('coach.lookup') ? 'active' : '' }}"><a href="{{ route('coach.lookup') }}"><img src="{{ asset('public/frontend/coach/images/note_icon.png') }}" alt="note_icon"/><span>Reverse Lookups</span></a>
  <!--  <ul>
      <li><a href="#">Product 1</a>
         <ul>
            <li><a href="#">Sub Product</a></li>
            <li><a href="#">Sub Product</a></li>
         </ul>
      </li>
      <li><a href="#">Product 2</a>
         <ul>
            <li><a href="">Sub Product</a></li>
            <li><a href="#">Sub Product</a></li>
         </ul>
      </li>
   </ul> -->
</li>
<li class="{{ Request::routeIs('coach.recommendation') ? 'active' : '' }}"><a href="{{ route('coach.recommendation') }}"><img src="{{ asset('public/frontend/athlete/images/recomandation.png') }}" alt="edit_icon"/><span>Recommendations</span></a></li>

<li class="{{ Request::routeIs('coach.chat') ? 'active' : '' }}"><a href="{{ route('coach.chat') }}"><img src="{{ asset('public/frontend/athlete/images/newchaticon.png') }}" alt="Icon awesome-calendar-check" /><span>Chat</span></a></li>


   
  
<!-- <li><a href="">
   <img src="{{ asset('public/frontend/athlete/images/newchaticon.png') }}" alt="nav4" /><span>Chat</span></a></li> -->
    
<li class="{{ Request::routeIs('coach.events') ? 'active' : '' }}"><a href="{{ route('coach.events') }}"><img src="{{ asset('public/frontend/coach/images/myevents_icn.png') }}" alt="Icon awesome-calendar-check" /><span>Promote Events</span></a></li>




<li class="{{ Request::routeIs('blogs') ? 'active' : '' }}"><a href="{{ route('blogs') }}" target="_blank">
                    <img src="{{ asset('public/frontend/athlete/images/blogicon.png') }}" alt="nav4" /><span>Blog</span></a></li>


 <li class="{{ Request::routeIs('coach.report') ? 'active' : '' }}">
                <a href="{{ route('coach.report') }}">
                    <img src="{{ asset('public/frontend/athlete/images/reportanissue.png') }}" alt="nav4" /><span>Contact Us / Report an Issue</span></a></li>


<li class="{{ Request::routeIs('coach.profile.change-password') ? 'active' : '' }}"><a href="#"><img src="{{ asset('public/frontend/coach/images/nav7.png') }}" alt="nav7"/><span>Settings</span></a>
    <ul>
        <li><a href="{{ route('coach.profile.change-password') }}">Change Password</a>
        </li>
    </ul>
</li>
<li ><a href="#"><img src="{{ asset('public/frontend/coach/images/dots_icon.png') }}" alt="dots_icon"/></a></li>

<li class="{{ Request::routeIs('coach.logout') ? 'active' : '' }}"><a href="{{ route('coach.logout') }}"><img src="{{ asset('public/frontend/coach/images/nav8.png') }}" alt="nav8"/></a></li>
</ul>


        
    </nav>
</header>