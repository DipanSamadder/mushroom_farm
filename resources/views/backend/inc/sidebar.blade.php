<!-- Right Icon menu Sidebar -->

<div class="navbar-right">

    <ul class="navbar-nav">

        <button type="submit" class="btn btn-primary rv-btn-toggle"><i class="zmdi zmdi-settings"></i></button>

        <li><a href="{{ route('home') }}" target="_blank" title="Add Media"><i class="zmdi zmdi-hc-fw"></i></a></li>



 

        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#DSLDImageUpload" title="Add Media"><i class="zmdi zmdi-camera"></i></a></li>





        <li><a href="javascript:void(0);" title="Clear Cache" onclick="clear_cache()"><i class="zmdi zmdi-hc-fw"></i></a></li>





        <li>

            <a href="{{ route('backend.setting') }}"  title="Setting"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a>

        </li>





        <li>

            <a href="javascript::void(0);" class="mega-menu" title="Sign Out" onclick="logout()"><i class="zmdi zmdi-power"></i></a>

        </li>

        

    </ul>

</div>



<!-- Left Sidebar -->

<aside id="leftsidebar" class="sidebar">

    <div class="navbar-brand">

        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>

        <a href="{{ route('backend.dashboard') }}">

            @if(dsld_get_setting('dashboard_logo') > 0)

                <img src="{{ dsld_uploaded_file_path(dsld_get_setting('dashboard_logo')) }}"  alt="{{ dsld_upload_file_title(dsld_get_setting('dashboard_logo')) }}" width="25">

            @else

                <img src="{{ dsld_static_asset('backend/assets/images/logo.svg') }}" width="25" alt='{{ env("APP_NAME", "Backend New" ) }}'>

            @endif

        <span class="m-l-10">{{ dsld_get_setting('dashboard_title') }}</span></a>

    </div>

    <div class="menu">

        <ul class="list">

            <li>

                <div class="user-info">



                    @if(Auth::user()->avatar_original !='')

                        <a class="image" href="{{ route('profiles.index') }}">

                            <img src="{{ dsld_uploaded_file_path(Auth::user()->avatar_original) }}" class="rounded-circle shadow mr-2" alt="profile-image" width="35">

                        </a>

                    @else

                        <img src="{{ dsld_static_asset('backend/assets/images/profile_av.jpg') }}" class="rounded-circle shadow  mr-2" alt="profile-image" width="35">

                    @endif

                    <div class="detail">

                        <h4>{{ Auth::user()->name }}</h4>

                        <small>Role: {{ Auth::user()->roles->pluck('name')->first() }}</small>                  

                    </div>

                </div>

            </li>

            <li class="{{ dsld_is_route_active(['backend.dashboard'], 'active open') }}"><a href="{{ route('backend.dashboard') }}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>



           

            <li class="{{ dsld_is_route_active(['media.library.admin'], 'active open') }}"><a href="{{ route('media.library.admin') }}"><i class="zmdi zmdi-folder"></i><span>Media</span></a></li>

              



              



            @if(dsld_check_permission(['pages','edit-pages','add-pages'])) 

            <li  class="{{ dsld_is_route_active(['pages.index', 'pages.edit','page.others.index', 'page.others.edit'], 'active open') }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Pages</span></a>

                <ul class="ml-menu">

                    @if(dsld_check_permission(['pages']))

                    <li class="{{ dsld_is_route_active(['pages.index', 'pages.edit']) }}"><a href="{{ route('pages.index') }}">Pages</a></li>

                     @endif


                     

                </ul>

            </li> 

            @endif 


            @if(dsld_check_permission(['room'])) 

            <li  class="{{ dsld_is_route_active(['rooms.index', 'rooms.edit', 'rooms.store'], 'active open') }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-hc-fw"></i><span>Room</span></a>
                <ul class="ml-menu">
                    @if(dsld_check_permission(['room']))
                        <li class="{{ dsld_is_route_active(['rooms.index', 'rooms.edit']) }}"><a href="{{ route('rooms.index') }}">All Room</a></li>
                    @endif
                </ul>
            </li> 
            @endif

            @if(dsld_check_permission(['salary'])) 

            <li  class="{{ dsld_is_route_active(['deductions.index', 'deductions.edit', 'deductions.store','allowances.index', 'allowances.edit', 'allowances.store'], 'active open') }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-hc-fw"></i><span>Salary</span></a>
                <ul class="ml-menu">
                    @if(dsld_check_permission(['salary']))
                        <li class="{{ dsld_is_route_active(['deductions.index', 'deductions.edit']) }}"><a href="{{ route('deductions.index') }}">All Deduction</a></li>
                    @endif
                    @if(dsld_check_permission(['salary']))
                        <li class="{{ dsld_is_route_active(['allowances.index', 'allowances.edit']) }}"><a href="{{ route('allowances.index') }}">All Allowance</a></li>
                    @endif
                </ul>
            </li> 
            @endif

            @if(dsld_check_permission(['employee'])) 

            <li  class="{{ dsld_is_route_active(['employes.index', 'employes.edit', 'employes.store', 'labours_rate.index', 'labours_rate.edit','designations.index', 'designations.edit'], 'active open') }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-hc-fw"></i><span>Employes</span></a>
                <ul class="ml-menu">
                    @if(dsld_check_permission(['employee']))
                        <li class="{{ dsld_is_route_active(['employes.index', 'employes.edit']) }}"><a href="{{ route('employes.index') }}">All employes</a></li>
                    @endif
                    
                    @if(dsld_check_permission(['labours_rate']))
                        <li class="{{ dsld_is_route_active(['labours_rate.index', 'labours_rate.edit']) }}"><a href="{{ route('labours_rate.index') }}">Labours</a></li>
                    @endif
                    @if(dsld_check_permission(['designations']))
                        <li class="{{ dsld_is_route_active(['designations.index', 'designations.edit']) }}"><a href="{{ route('designations.index') }}">Designation</a></li>
                    @endif

                </ul>
            </li> 
            @endif


            @if(dsld_check_permission(['contactfs','edit-contactfs', 'contactf-leads','edit-contactf-leads']))  

                <li class="{{ dsld_is_route_active(['contact_form.index', 'contact_form.leads' ,'contact-form.show'], 'active open') }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-hc-fw"></i><span>Forms</span></a>

                    <ul class="ml-menu">

                        @if(dsld_check_permission(['contactfs','edit-contactfs']))

                        <li class="{{ dsld_is_route_active(['contact_form.index', 'contact_form_fields.edit', 'contact_form_fields.update']) }}"><a href="{{ route('contact_form.index') }}">All Forms</a></li>

                        @endif

                        @if(dsld_check_permission(['contactf-leads','edit-contactf-leads']))

                        <li class="{{ dsld_is_route_active(['contact_form.leads','contact-form.show']) }}"><a href="{{ route('contact_form.leads') }}">All Leads</a></li>

                        @endif

                    </ul>

                </li> 

            @endif


            @if(dsld_check_permission(['translates','frontend-setting','menus']))

            <li class="{{ dsld_is_route_active(['frontend.setting',  'translate.index','menus.index','menus.edit'], 'active open') }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-apps"></i><span>Settings</span></a>

                <ul class="ml-menu">

                    

                     

                    @if(dsld_check_permission(['frontend-setting']))

                    <!-- Show-Frontend-Setting-->

                    <li class="{{ dsld_is_route_active(['frontend.setting']) }}"><a href="{{ route('frontend.setting') }}">Frontend</a></li>

                    @endif

                    @if(dsld_check_permission(['translates']))

                    <!-- Show-Terminal-->

                    <li class="{{ dsld_is_route_active(['translate.index']) }}"><a href="{{ route('translate.index') }}">Translate</a></li>

                    @endif

                    

                    @if(dsld_check_permission(['menus']))

                    <!-- Backend Setting-->

                    <li class="{{ dsld_is_route_active(['menus.index','menus.edit']) }}"><a href="{{ route('menus.index') }}">Menu</a></li>

                    @endif

                 

                </ul>

            </li> 

            @endif

            



            @if(dsld_check_permission(['roles','permissions'])) 

            <li  class="{{ dsld_is_route_active(['roles.index', 'role.edit', 'role.store', 'permissions.index', 'permission.edit', 'permission.store'], 'active open') }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-hc-fw"></i><span>Roles</span></a>

                <ul class="ml-menu">

                    @if(dsld_check_permission(['roles']))

                    <li class="{{ dsld_is_route_active(['roles.index', 'role.edit']) }}"><a href="{{ route('roles.index') }}">All Roles</a></li>

                     @endif



                    @if(dsld_check_permission(['permissions']))

                    <li class="{{ dsld_is_route_active(['permissions.index', 'permissions.edit']) }}"><a href="{{ route('permissions.index') }}">All Permissions</a></li>

                    @endif



                </ul>

            </li> 

            @endif
            @role('Super-Admin') 

            <li  class="{{ dsld_is_route_active(['backend.setting','terminals','languages.index','pages_section.index','pages_section_fields.edit','templates.index'], 'active open') }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-hc-fw"></i><span>Developer</span></a>

                <ul class="ml-menu">

                    

                    @if(dsld_check_permission(['backend-setting']))

                    <!-- Backend Setting-->

                    <li class="{{ dsld_is_route_active(['backend.setting']) }}"><a href="{{ route('backend.setting') }}">Backend</a></li>

                    @endif





                    @if(dsld_check_permission(['terminals']))

                    <!-- Terminal-->

                    <li class="{{ dsld_is_route_active(['terminal.index']) }}"><a href="{{ route('terminal.index') }}" target="blank">Terminal</a></li>

                    @endif





                    @if(dsld_check_permission(['languages']))

                    <!-- Show-Terminal-->

                    <li class="{{ dsld_is_route_active(['languages.index']) }}"><a href="{{ route('languages.index') }}">Language</a></li>

                    @endif



                    @if(dsld_check_permission(['page-sections']))

                    <!-- Show-sections-->

                    <li class="{{ dsld_is_route_active(['pages_section.index','pages_section_fields.edit']) }}"><a href="{{ route('pages_section.index') }}">Section</a></li>

                    @endif



                    @if(dsld_check_permission(['templates']))

                    <!-- Show-sections-->

                    <li class="{{ dsld_is_route_active(['templates.index']) }}"><a href="{{ route('templates.index') }}">Template</a></li>

                    @endif

                </ul>

            </li> 

            @endrole



            @if(dsld_check_permission(['user'])) 

            <li class="{{ dsld_is_route_active(['users.index', 'users.edit', 'users.store'], 'active open') }}">

                <a href="{{ route('users.index') }}"><i class="zmdi zmdi-hc-fw"></i><span>Users</span></a>

            </li>

            @endif

            

            <li class="{{ dsld_is_route_active(['profiles.index'], 'active open') }}"><a href="{{ route('profiles.index') }}"><i class="zmdi zmdi-account"></i><span>Profile</span></a></li> 

        </ul>

    </div>

</aside>

