

<div class="side-menu">
    <div class='side-menu-body'>
        <ul>
            <li class="side-menu-divider m-t-0"></li>
            <li class="{{($mainSuperAdminMenu == 'dashboard')?"open":""}}">
                <a href="{{asset('superadmin/dashboard')}}">
                    <i class="icon fa fa-globe"></i>
                    <span>Dashboard</span>
                </a>
                
            </li>
           
            <?php 
                $user = App\Helpers\PermissionActivity::getPermission(5) ;

                // print_r($a);
                if(in_array(session('loggedIn')['id'],$user))
                {

            ?>
            <li class="side-menu-divider m-t-10">Admin User</li>
            <li class="{{($mainSuperAdminMenu == 'AdminUser')?"open":""}}">
                <a href="#">
                    <i class="icon fa fa-pagelines active"></i>
                    <span>Admin User</span>
                </a>
                <ul>
                    <li><a class="{{($superadminSubMenu=='roles')?"active":""}}" href="{{asset('superadmin/admin-roles')}}">Admin Roles </a></li>
                    {{-- <li><a class="{{($superadminSubMenu=='modules')?"active":""}}" href="{{asset('superadmin/admin-modules')}}">Admin Modules</a></li> --}}
                    <li><a class="{{($superadminSubMenu=='adminUser')?"active":""}}" href="{{asset('superadmin/admin-user')}}">Admin User</a></li>
                    {{-- <li><a class="{{($superadminSubMenu=='modulePermission')?"active":""}}" href="{{asset('superadmin/add-module-permission')}}">Admin Module Permission</a></li> --}}
                   
                 
                </ul>
            </li>
            <?php } ?>


            
           
        </ul>
        <div class="side-menu-status-bars">
            {{-- <h6 class="text-uppercase font-size-11 m-b-10">Users</h6>
            <ul class="list-inline m-b-20">
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-state-warning avatar-xs">
                            <img src="{{asset('public/admin/media/image/avatar.jpg')}}" class="rounded-circle">
                        </figure>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-state-success avatar-xs">
                            <span class="avatar-title bg-primary rounded-circle">E</span>
                        </figure>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-state-success avatar-xs">
                            <span class="avatar-title bg-danger rounded-circle">SC</span>
                        </figure>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-state-warning avatar-xs">
                            <span class="avatar-title bg-info rounded-circle">A</span>
                        </figure>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <figure class="avatar avatar-xs">
                            <span class="avatar-title bg-dark font-size-14 rounded-circle">+5</span>
                        </figure>
                    </a>
                </li>
            </ul> --}}
            {{-- <h6 class="text-uppercase font-size-11 m-b-10 d-flex justify-content-between">Storage <span class="text-muted">%85</span></h6>
            <div class="progress" style="height: 5px;">
                <div class="progress-bar bg-danger-gradient" role="progressbar" style="width: 85%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div> --}}
        </div>
    </div>
</div>