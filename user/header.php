<?php
$uArr=$obj->query("select name from $tbl_user where id='".$_SESSION['sess_user_id']."'",-1); //die;
$rsU=$obj->fetchNextObject($uArr);
?>
<!-- BEGIN: Header-->
  <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
      <div class="navbar-wrapper">
          <div class="navbar-container content">
              <div class="navbar-collapse" id="navbar-mobile">
                  <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center"></div>
                  <ul class="nav navbar-nav float-right">
                      <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>">Visit Website</a></li>                
                      <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                              <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600"><?php echo ucfirst(strtolower($rsU->name)); ?></span><span class="user-status">Available</span></div><span><img class="round" src="app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="profile-editf.php"><i class="feather icon-user"></i> Edit Profile</a>
                              <div class="dropdown-divider"></div><a class="dropdown-item" href="../logout.php"><i class="feather icon-power"></i> Logout</a>
                          </div>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </nav>