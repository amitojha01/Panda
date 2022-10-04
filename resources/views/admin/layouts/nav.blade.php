<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar sticky">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
               collapse-btn"> <i data-feather="align-justify"></i></a></li>
               <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
            </a></li>
            <li>
                <form class="form-inline mr-auto">
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                        data-width="200">
                        <button class="btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"
            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            @if(auth()->check() )
            @php($tmp = \App\Models\User::where('id', Auth()->user()->id)->first())
            <img alt="image" src="{{ asset($tmp->profile_image) }}"  class="user-img-radious-style">

            @else
                <img alt="image" src="{{ asset('public/frontend/images/avatar-icon.png') }}" class="user-img-radious-style">
                @endif
            <span class="d-sm-none d-lg-inline-block"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right pullDown">
            <div class="dropdown-title">Hello Admin,</div>
            <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                <i class="fas fa-user"></i> Profile
            </a> 
                <a href="{{ route('admin.settings') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings 
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.logout') }}" class="dropdown-item has-icon text-danger"> 
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
