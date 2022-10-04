<header>
    <nav id="cssmenu">
        <div id="head-mobile"></div>
        <div class="button"></div>
        <ul>
            <li class="{{ Request::routeIs('athlete.dashboard') ? 'active' : '' }}">
                <a href="{{ url('/athlete/dashboard') }}">
                    <img src="{{ asset('public/frontend/athlete/images/nav1.png') }}" alt="nav1" />
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="{{ Request::routeIs('workouts.index') ? 'active' : '' }}">
                <a href="{{ route('workouts.index') }}">
                    <img src="{{ asset('public/frontend/athlete/images/nav2.png') }}" alt="nav2" />
                   <span> Workouts</span>
                </a>
            </li>
             <!-- <li><a href="{{ route('athlete.video-evidence') }}"><img src="{{ asset('public/frontend/athlete/images/videoevidance_icon.png') }}" />

                <span>Video Evidence</span></a></li> -->
            <li class="{{ Request::routeIs('athlete.compare') ? 'active' : '' }}">
                <a href="{{ route('athlete.compare') }}">
                    <img src="{{ asset('public/frontend/athlete/images/nav3.png') }}" alt="nav3" />
                   <span> Panda Compare<sup>TM</sup></span>
            </a>
            </li>

            <li class="{{ Request::routeIs('athlete.connections') ? 'active' : '' }}">
                <a href="{{ route('athlete.connections') }}">
                <img src="{{ asset('public/frontend/athlete/images/nav6.png') }}" alt="nav6" /><span>Panda Connect <sup>TM</sup></span></a></li>

            <li class="{{ Request::routeIs('athlete.teamingup-group') ? 'active' : '' }}">
                <a href="{{ route('athlete.teamingup-group') }}">
                <img src="{{ asset('public/frontend/athlete/images/nav5.png') }}" alt="nav5" /><span>TeamingUP<sup>TM</sup> Groups</span></a></li>


            <li class="{{ Request::routeIs('athlete.game-highlights') ? 'active' : '' }}">
                <a href="{{ route('athlete.game-highlights') }}">
                <img src="{{ asset('public/frontend/athlete/images/game.png') }}" alt="game" /><span>Game Highlights</span></a></li>

                <li class="{{ Request::routeIs('athlete.coach-recomendation') ? 'active' : '' }}">
                <a href="{{ route('athlete.coach-recomendation') }}">
                <img src="{{ asset('public/frontend/athlete/images/recomandation.png') }}" alt="nav4" /><span>Recommendations</span></a></li>

               
                <li class="">
                <a href="{{ route('athlete.email-coach') }}">
                <img src="{{ asset('public/frontend/athlete/images/email_icon.png') }}" alt="nav6" /><span>Email A Coach</span></a></li>
            
            
           
            <li class="{{ Request::routeIs('athlete.chat') ? 'active' : '' }}">
                <a href="{{ route('athlete.chat') }}">
                <img src="{{ asset('public/frontend/athlete/images/newchaticon.png') }}" alt="nav4" /><span>Chat</span></a></li>          


               

            <li class="{{ Request::routeIs('athlete.events','tab_id=1') ? 'active' : '' }}">
                <a href="{{ route('athlete.events','tab_id=1') }}">
                <img src="{{ asset('public/frontend/athlete/images/myevents_icn.png') }}" alt="Icon awesome-calendar-check" /><span>My Events</span></a></li>

                <li class="{{ Request::routeIs('athlete.events') ? 'active' : '' }}">
                    <a href="{{ route('athlete.events','tab_id=2') }}">
                <img src="{{ asset('public/frontend/athlete/images/eventicon.png') }}" alt="Icon awesome-calendar-check" /><span> Event Opportunities</span></a></li>

                <!-- <li><a href="{{ route('athlete.events') }}">
                <img src="{{ asset('public/frontend/athlete/images/newmailicon.png') }}" alt="Icon awesome-calendar-check" /><span>Search Events</span></a>
                </li> -->
           

            <li class="{{ Request::routeIs('blogs') ? 'active' : '' }}">
                <a href="{{ route('blogs') }}" target="_blank">
                    <img src="{{ asset('public/frontend/athlete/images/blogicon.png') }}" alt="nav4" /><span>Blog</span></a></li>

            <li class="{{ Request::routeIs('athlete.report') ? 'active' : '' }}">
                <a href="{{ route('athlete.report') }}">
                    <img src="{{ asset('public/frontend/athlete/images/reportanissue.png') }}" alt="nav4" /><span>Contact Us / Report an Issue</span></a></li>

             <li class="{{ Request::routeIs('profile.change-password') ? 'active' : '' }}">
                <a href="#"><img src="{{ asset('public/frontend/athlete/images/nav7.png') }}" alt="nav7" /><span>Settings</span></a>
                <ul>
                    <li><a href="{{ route('profile.change-password') }}">Change Password</a>
                    </li>
                </ul>
            </li>

            <!-- <li><a href="#"><img src="{{ asset('public/frontend/athlete/images/dots_icon.png') }}" alt="dots_icon" /></a></li> -->
            <li class="{{ Request::routeIs('athlete.logout') ? 'active' : '' }}">
                <a href="{{ route('athlete.logout') }}">
                    <img src="{{ asset('public/frontend/athlete/images/nav8.png') }}" alt="nav8" />
                </a>
            </li>
        </ul>
    </nav>
</header>