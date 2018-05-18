<li class="dropdown dropdown-user">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <img alt="" class="img-circle" src="<?php echo site_url('admin_assets/layout/img/avatar.png'); ?>"/>
        <span class="username username-hide-on-mobile">
            <?php 
            $user_type = getUserdata('user_type');
            if($user_type == "admin")
            {
                echo "Administrator"; 
            } else {
                echo getUserdata('user_name').' '.getUserdata('user_family_name');
            }
            ?> </span>
        <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-default">
        <li>
            <a href="<?php echo base_url_tr('user/edit/' . getUserdata('user_id')); ?>">
                <i class="icon-user"></i> My Profile </a>

        </li>

        <li class="divider">
        </li>

        <li>
            <a href="<?php echo base_url_tr('authentication/logout'); ?>">
                <i class="icon-key"></i> Log Out </a>
        </li>
    </ul>
</li>

