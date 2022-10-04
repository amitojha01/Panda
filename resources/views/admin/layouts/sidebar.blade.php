<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/admin') }}">
                <img alt="image" src="{{ asset('public/frontend/images/signin_logo.png') }}" class="header-logo" />
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i data-feather="monitor"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i data-feather="image"></i>
                    <span>Gallery</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('banners.index') }}">Banner Management</a></li>
                    <li><a class="nav-link" href="{{ route('stories.index') }}">Stories Management</a></li>
                    <li><a class="nav-link" href="{{ route('services.index') }}">Services Management</a></li>
                </ul>
            </li>
             <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i data-feather="image"></i>
                    <span>Testimonial</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('testimonial.index') }}">Testimonial Content</a></li>
                    <li><a class="nav-link" href="{{ route('testimonial-review.index') }}">Testimonial Reviews</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="file"></i>
                    <span>CMS</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('cms.index') }}">CMS Management</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('blogs.index') }}">Blog Management</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('features.index') }}">Features Management</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('fitness.index') }}">Fitness Management</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('team.index') }}">Team Management</a></li>
                </ul>

                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('advisory.index') }}">Advisory Board Management</a></li>
                </ul>
           </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="user"></i>
                    <span>User</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('user.index') }}">Athlete Management</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('coach.index') }}">Coach Management</a></li>
                </ul> 
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="command"></i>
                    <span>Newsletter</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('newsletter.index') }}">Newsletter Management</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="shopping-bag"></i>
                    <span>City</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('cities.index') }}">City Management</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="shopping-bag"></i>
                    <span>Colleges</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('colleges.index') }}">College Management</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="book"></i>
                    <span>Education</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('education.index') }}">Education Management</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="book-open"></i>
                    <span>Competition</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('competition.index') }}">Competation Management</a></li>
                </ul>
            </li>            
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="shopping-bag"></i>
                    <span>Confernces</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('conference.index') }}">Collegiate Confernces</a></li>
                </ul>
            </li>
             <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="hard-drive"></i>
                    <span>Travel</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('travel.index') }}">Travel Management</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="book-open"></i>
                    <span>School Playing</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('schoolplaying.index') }}">School Playing Management</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="feather"></i>
                    <span>Sports</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('sports.index') }}">Sports Management</a></li>
                </ul>
                 <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.sports.position') }}">Sports Position</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="flag"></i>
                    <span>Workout Management</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('libraryMesurement.index') }}">Library Measurement</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('workoutlibrary.index') }}">Workout Library</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('workoutcategory.index') }}">Category Master</a></li>
                </ul>
            </li>

             <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="flag"></i>
                    <span>Teaming Group</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('group.index') }}">Group Management</a></li>
                </ul>                 
            </li>

            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="dollar-sign"></i>
                    <span>Subscription</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('subscription.index') }}">Subscription Management</a></li>
                </ul>                
            </li>

            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="flag"></i>
                    <span>Exercises</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('exercises.index') }}">Exercises Management</a></li>
                </ul>
            </li>


            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="flag"></i>
                    <span>Email A Coach</span>
                </a> 
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('email.index') }}">Email Management</a></li>
                </ul>
            </li>
            
            <!-- <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="briefcase"></i><span>Widgets</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="widget-chart.html">Chart Widgets</a></li>
                    <li><a class="nav-link" href="widget-data.html">Data Widgets</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Apps</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="chat.html">Chat</a></li>
                    <li><a class="nav-link" href="portfolio.html">Portfolio</a></li>
                    <li><a class="nav-link" href="blog.html">Blog</a></li>
                    <li><a class="nav-link" href="calendar.html">Calendar</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Email</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="email-inbox.html">Inbox</a></li>
                    <li><a class="nav-link" href="email-compose.html">Compose</a></li>
                    <li><a class="nav-link" href="email-read.html">read</a></li>
                </ul>
            </li>
            <li class="menu-header">UI Elements</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Basic
                        Components</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="alert.html">Alert</a></li>
                    <li><a class="nav-link" href="badge.html">Badge</a></li>
                    <li><a class="nav-link" href="breadcrumb.html">Breadcrumb</a></li>
                    <li><a class="nav-link" href="buttons.html">Buttons</a></li>
                    <li><a class="nav-link" href="collapse.html">Collapse</a></li>
                    <li><a class="nav-link" href="dropdown.html">Dropdown</a></li>
                    <li><a class="nav-link" href="checkbox-and-radio.html">Checkbox &amp; Radios</a></li>
                    <li><a class="nav-link" href="list-group.html">List Group</a></li>
                    <li><a class="nav-link" href="media-object.html">Media Object</a></li>
                    <li><a class="nav-link" href="navbar.html">Navbar</a></li>
                    <li><a class="nav-link" href="pagination.html">Pagination</a></li>
                    <li><a class="nav-link" href="popover.html">Popover</a></li>
                    <li><a class="nav-link" href="progress.html">Progress</a></li>
                    <li><a class="nav-link" href="tooltip.html">Tooltip</a></li>
                    <li><a class="nav-link" href="flags.html">Flag</a></li>
                    <li><a class="nav-link" href="typography.html">Typography</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="shopping-bag"></i><span>Advanced</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="avatar.html">Avatar</a></li>
                    <li><a class="nav-link" href="card.html">Card</a></li>
                    <li><a class="nav-link" href="modal.html">Modal</a></li>
                    <li><a class="nav-link" href="sweet-alert.html">Sweet Alert</a></li>
                    <li><a class="nav-link" href="toastr.html">Toastr</a></li>
                    <li><a class="nav-link" href="empty-state.html">Empty State</a></li>
                    <li><a class="nav-link" href="multiple-upload.html">Multiple Upload</a></li>
                    <li><a class="nav-link" href="pricing.html">Pricing</a></li>
                    <li><a class="nav-link" href="tabs.html">Tab</a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="blank.html"><i data-feather="file"></i><span>Blank Page</span></a></li>
            <li class="menu-header">Otika</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="layout"></i><span>Forms</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="basic-form.html">Basic Form</a></li>
                    <li><a class="nav-link" href="forms-advanced-form.html">Advanced Form</a></li>
                    <li><a class="nav-link" href="forms-editor.html">Editor</a></li>
                    <li><a class="nav-link" href="forms-validation.html">Validation</a></li>
                    <li><a class="nav-link" href="form-wizard.html">Form Wizard</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="grid"></i><span>Tables</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="basic-table.html">Basic Tables</a></li>
                    <li><a class="nav-link" href="advance-table.html">Advanced Table</a></li>
                    <li><a class="nav-link" href="datatables.html">Datatable</a></li>
                    <li><a class="nav-link" href="export-table.html">Export Table</a></li>
                    <li><a class="nav-link" href="editable-table.html">Editable Table</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="pie-chart"></i><span>Charts</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="chart-amchart.html">amChart</a></li>
                    <li><a class="nav-link" href="chart-apexchart.html">apexchart</a></li>
                    <li><a class="nav-link" href="chart-echart.html">eChart</a></li>
                    <li><a class="nav-link" href="chart-chartjs.html">Chartjs</a></li>
                    <li><a class="nav-link" href="chart-sparkline.html">Sparkline</a></li>
                    <li><a class="nav-link" href="chart-morris.html">Morris</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="feather"></i><span>Icons</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="icon-font-awesome.html">Font Awesome</a></li>
                    <li><a class="nav-link" href="icon-material.html">Material Design</a></li>
                    <li><a class="nav-link" href="icon-ionicons.html">Ion Icons</a></li>
                    <li><a class="nav-link" href="icon-feather.html">Feather Icons</a></li>
                    <li><a class="nav-link" href="icon-weather-icon.html">Weather Icon</a></li>
                </ul>
            </li>
            <li class="menu-header">Media</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="image"></i><span>Gallery</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="light-gallery.html">Light Gallery</a></li>
                    <li><a href="gallery1.html">Gallery 2</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="flag"></i><span>Sliders</span></a>
                <ul class="dropdown-menu">
                    <li><a href="carousel.html">Bootstrap Carousel.html</a></li>
                    <li><a class="nav-link" href="owl-carousel.html">Owl Carousel</a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="timeline.html"><i data-feather="sliders"></i><span>Timeline</span></a></li>
            <li class="menu-header">Maps</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="map"></i><span>Google
                        Maps</span></a>
                <ul class="dropdown-menu">
                    <li><a href="gmaps-advanced-route.html">Advanced Route</a></li>
                    <li><a href="gmaps-draggable-marker.html">Draggable Marker</a></li>
                    <li><a href="gmaps-geocoding.html">Geocoding</a></li>
                    <li><a href="gmaps-geolocation.html">Geolocation</a></li>
                    <li><a href="gmaps-marker.html">Marker</a></li>
                    <li><a href="gmaps-multiple-marker.html">Multiple Marker</a></li>
                    <li><a href="gmaps-route.html">Route</a></li>
                    <li><a href="gmaps-simple.html">Simple</a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="vector-map.html"><i data-feather="map-pin"></i><span>Vector
                        Map</span></a></li>
            <li class="menu-header">Pages</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="user-check"></i><span>Auth</span></a>
                <ul class="dropdown-menu">
                    <li><a href="auth-login.html">Login</a></li>
                    <li><a href="auth-register.html">Register</a></li>
                    <li><a href="auth-forgot-password.html">Forgot Password</a></li>
                    <li><a href="auth-reset-password.html">Reset Password</a></li>
                    <li><a href="subscribe.html">Subscribe</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="alert-triangle"></i><span>Errors</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="errors-503.html">503</a></li>
                    <li><a class="nav-link" href="errors-403.html">403</a></li>
                    <li><a class="nav-link" href="errors-404.html">404</a></li>
                    <li><a class="nav-link" href="errors-500.html">500</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="anchor"></i><span>Other
                        Pages</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="create-post.html">Create Post</a></li>
                    <li><a class="nav-link" href="posts.html">Posts</a></li>
                    <li><a class="nav-link" href="profile.html">Profile</a></li>
                    <li><a class="nav-link" href="contact.html">Contact</a></li>
                    <li><a class="nav-link" href="invoice.html">Invoice</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="chevrons-down"></i><span>Multilevel</span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Menu 1</a></li>
                    <li class="dropdown">
                        <a href="#" class="has-dropdown">Menu 2</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Child Menu 1</a></li>
                            <li class="dropdown">
                                <a href="#" class="has-dropdown">Child Menu 2</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Child Menu 1</a></li>
                                    <li><a href="#">Child Menu 2</a></li>
                                </ul>
                            </li>
                            <li><a href="#"> Child Menu 3</a></li>
                        </ul>
                    </li>
                </ul>
            </li> -->
        </ul>
    </aside>
</div>
