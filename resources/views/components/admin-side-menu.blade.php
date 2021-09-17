

<div class="side-menu">
    <div class='side-menu-body'>
        <ul>
            <li class="side-menu-divider m-t-0"></li>
            <li class="{{($mainMenu == 'dashboard')?"open":""}}">
                <a href="{{asset('admin/dashboard')}}">
                    <i class="icon fa fa-globe"></i>
                    <span>Dashboard</span>
                </a>
                
            </li>


            <?php 
                $user = App\Helpers\PermissionActivity::getPermission(11) ;

                // print_r($a);
                if(in_array(session('loggedIn')['id'],$user))
                {

            ?>
            <li class="side-menu-divider m-t-10">Sub Admin</li>
            <li class="{{($mainMenu == 'subadmin')?"open":""}}">
                <a href="#">
                    <i class="icon fa fa-pagelines active"></i>
                    <span>Subadmin</span>
                </a>
                <ul>
                    <li><a class="{{($subMenu=='subadminRoleList')?"active":""}}" href="{{asset('admin/subadmin-role-list')}}">Subadmin Role List</a></li>
                    <li><a class="{{($subMenu=='subadminUserList')?"active":""}}" href="{{asset('admin/subadmin-user-list')}}">Subadmin User List</a></li>
                   
                   
                 
                </ul>
            </li>
            <?php } ?>

           
            


            
            <?php 
                $user = App\Helpers\PermissionActivity::getPermission(9) ;

                // print_r($a);
                if(in_array(session('loggedIn')['id'],$user))
                {

            ?>
            <li class="side-menu-divider m-t-10">Window Encryption</li>
            <li class="{{($mainMenu == 'encryption')?"open":""}}">
                <a href="#">
                    <i class="icon fa fa-pagelines active"></i>
                    <span>Encryption</span>
                </a>
                <ul>
                    <li><a class="{{($subMenu=='encryptionList')?"active":""}}" href="{{asset('admin/encryption-list')}}">Encryption List</a></li>
                   
                   
                 
                </ul>
            </li>
            <?php } ?>

            <?php 
            $user = App\Helpers\PermissionActivity::getPermission(10) ;

            // print_r($a);
            if(in_array(session('loggedIn')['id'],$user))
            {

        ?>
        <li class="side-menu-divider m-t-10">Video</li>
        <li class="{{($mainMenu == 'video')?"open":""}}">
            <a href="#">
                <i class="icon fa fa-pagelines active"></i>
                <span>Video</span>
            </a>
            <ul>
                <li><a class="{{($subMenu=='videoList')?"active":""}}" href="{{asset('admin/video-list')}}">Original Video List</a></li>
                <li><a class="{{($subMenu=='revideoList')?"active":""}}" href="{{asset('admin/re-video-list')}}">Video List</a></li>
               
               
             
            </ul>
        </li>
        <?php } ?>



            <?php 
                $user = App\Helpers\PermissionActivity::getPermission(8) ;

                // print_r($a);
                if(in_array(session('loggedIn')['id'],$user))
                {

            ?>
            <li class="side-menu-divider m-t-10">User Management</li>
            <li class="{{($mainMenu == 'userManagement')?"open":""}}">
                <a href="#">
                    <i class="icon fa fa-pagelines active"></i>
                    <span>User</span>
                </a>
                <ul>
                    <li><a class="{{($subMenu=='userList')?"active":""}}" href="{{asset('admin/user-list')}}">User List</a></li>
                   
                   
                 
                </ul>
            </li>
            <?php } ?>

            <?php 
            $product = App\Helpers\PermissionActivity::getPermission(6) ;

            // print_r($a);
            if(in_array(session('loggedIn')['id'],$product))
            {

        ?>
        <li class="side-menu-divider m-t-10">Product Management</li>

       

        <li class="{{($mainMenu == 'productManagement')?"open":""}}">
            <a href="#">
                <i class="icon fa fa-pagelines active"></i>
                <span>Product</span>
            </a>
            <ul>
                <li><a class="{{($subMenu=='categoryList')?"active":""}}" href="{{asset('admin/main-category-list')}}">Category list</a></li>
                <li><a class="{{($subMenu=='productList')?"active":""}}" href="{{asset('admin/product-list')}}">Product list</a></li>
                <li><a class="{{($subMenu=='demoproductList')?"active":""}}" href="{{asset('admin/demo-product-list')}}">Demo Product list</a></li>
               
            </ul>
        </li>
        <?php } ?>

        <?php 
        $product = App\Helpers\PermissionActivity::getPermission(14) ;

        // print_r($a);
        if(in_array(session('loggedIn')['id'],$product))
        {

    ?>
    <li class="side-menu-divider m-t-10">Studio Management</li>

   

    <li class="{{($mainMenu == 'studioManagement')?"open":""}}">
        <a href="#">
            <i class="icon fa fa-pagelines active"></i>
            <span>Studio</span>
        </a>
        <ul>
            <li><a class="{{($subMenu=='studioList')?"active":""}}" href="{{asset('admin/studio-list')}}">Studio list</a></li>
            {{-- <li><a class="{{($subMenu=='productList')?"active":""}}" href="{{asset('admin/product-list')}}">Product list</a></li> --}}
           
        </ul>
    </li>
    <?php } ?>

           
        <?php 
        $product = App\Helpers\PermissionActivity::getPermission(7) ;

        // print_r($a);
        if(in_array(session('loggedIn')['id'],$product))
        {

    ?>
    <li class="side-menu-divider m-t-10">Database Management</li>
    <li class="{{($mainMenu == 'databaseManagement')?"open":""}}">
        <a href="#">
            <i class="icon fa fa-pagelines active"></i>
            <span>MCQ</span>
        </a>
        <ul>
            <li><a class="{{($subMenu=='mcqQuestList')?"active":""}}" href="{{asset('admin/mcq-question-list')}}">MCQ Question list</a></li>

            <li><a class="{{($subMenu=='mcqList')?"active":""}}" href="{{asset('admin/mcq-list')}}">Mcq List</a></li>
           
        </ul>
    </li>
    <?php } ?>

    <?php 
    $product = App\Helpers\PermissionActivity::getPermission(15) ;

    // print_r($a);
    if(in_array(session('loggedIn')['id'],$product))
    {

?>
<li class="side-menu-divider m-t-10">Ebook Management</li>
<li class="{{($mainMenu == 'ebookManagement')?"open":""}}">
    <a href="#">
        <i class="icon fa fa-pagelines active"></i>
        <span>Ebook</span>
    </a>
    <ul>
        <li><a class="{{($subMenu=='ebookList')?"active":""}}" href="{{asset('admin/ebook-list')}}">Ebook list</a></li>

        {{-- <li><a class="{{($subMenu=='mcqList')?"active":""}}" href="{{asset('admin/mcq-list')}}">Mcq List</a></li> --}}
       
    </ul>
</li>
<?php } ?>


    <?php 
    $product = App\Helpers\PermissionActivity::getPermission(4) ;

    // print_r($a);
    if(in_array(session('loggedIn')['id'],$product))
    {

?>
<li class="side-menu-divider m-t-10">Subjective Pdf Management</li>
<li class="{{($mainMenu == 'pdfManagement')?"open":""}}">
    <a href="#">
        <i class="icon fa fa-pagelines active"></i>
        <span>PDF</span>
    </a>
    <ul>
        <li><a class="{{($subMenu=='pdfList')?"active":""}}" href="{{asset('admin/pdf-list')}}">Subjective PDF list</a></li>

        {{-- <li><a class="{{($subMenu=='mcqList')?"active":""}}" href="{{asset('admin/mcq-list')}}">Mcq List</a></li> --}}
       
    </ul>
</li>
<?php } ?>

    

    
    <?php 
    $product = App\Helpers\PermissionActivity::getPermission(13) ;

    // print_r($a);
    if(in_array(session('loggedIn')['id'],$product))
    {

?>
<li class="side-menu-divider m-t-10">Order Management</li>



<li class="{{($mainMenu == 'orderManagement')?"open":""}}">
    <a href="#">
        <i class="icon fa fa-pagelines active"></i>
        <span>Orders</span>
    </a>
    <ul>
        <li><a class="{{($subMenu=='orderList')?"active":""}}" href="{{asset('admin/order-list')}}">Order list</a></li>
        {{-- <li><a class="{{($subMenu=='productList')?"active":""}}" href="{{asset('admin/product-list')}}">Product list</a></li> --}}
       
    </ul>
</li>
<?php } ?>

        </ul>
        <div class="side-menu-status-bars">
            {{-- <h6 class="text-uppercase font-size-11 m-b-10">Users</h6> --}}
            {{-- <ul class="list-inline m-b-20">
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