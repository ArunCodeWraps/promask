<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="welcome.php">
                <div class="brand-logo"></div>
                <h2 class="brand-text mb-0">Promask</h2>
            </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <?php $pageName= pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME); ?>
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a href="welcome.php"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a></li>
            <li class=" navigation-header"><span>User</span></li>
            <li class="<?php echo ($pageName =='user-list' || $pageName =='user-addf')?'active':'' ?> nav-item"><a href="user-list.php"><i class="feather icon-grid"></i><span class="menu-title" data-i18n="Email">User</span></a>
            </li>
            <li class=" navigation-header"><span>Catalog</span></li>
            <li class="<?php echo ($pageName =='order-list' || $pageName =='order-addf')?'active':'' ?> nav-item"><a href="order-list.php"><i class="feather icon-grid"></i><span class="menu-title" data-i18n="Email">Order</span></a>
            </li>

             <li class=" navigation-header"><span>Change Password</span></li>
             <li class="<?php echo ($pageName =='change-password')?'active':'' ?> nav-item"><a href="change-password.php"><i class="feather icon-grid"></i><span class="menu-title" data-i18n="Email">Change Password</span></a>
            </li>
        </ul>
    </div>
</div>