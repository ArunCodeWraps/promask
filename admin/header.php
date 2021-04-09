<!-- BEGIN: Header-->
  <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
      <div class="navbar-wrapper">
          <div class="navbar-container content">
              <div class="navbar-collapse" id="navbar-mobile">
                  <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                      <ul class="nav navbar-nav">
                          <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                      </ul>
                      <ul class="nav navbar-nav bookmark-icons">
                          <!-- li.nav-item.mobile-menu.d-xl-none.mr-auto-->
                          <!--   a.nav-link.nav-menu-main.menu-toggle.hidden-xs(href='#')-->
                          <!--     i.ficon.feather.icon-menu-->
                          <!-- <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo.html" data-toggle="tooltip" data-placement="top" title="Todo"><i class="ficon feather icon-check-square"></i></a></li>
                          <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon feather icon-message-square"></i></a></li>
                          <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon feather icon-mail"></i></a></li> -->
                          <!-- <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calender.html" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon feather icon-calendar"></i></a></li> -->
                      </ul>
                      
                  </div>
                  <ul class="nav navbar-nav float-right">
                <?php
                if($_SESSION['user_type']=='superadmin'){
                $ttime = strtotime(date('H:i'));
                $mtime = strtotime("06:05");
                $todate = date('Y-m-d');
                $cronSql = $obj->query("select id from $tbl_cron_level where date(cdate)='$todate'",-1);
                $cronRow = $obj->numRows($cronSql);
                if($cronRow=='' && $ttime > $mtime){?>
                <li class="dropdown user user-menu" style="top: 23px;right: 25px;">
                  <a href="setcronjoblevel.php"><span class="hidden-xs" style="background-color:grey; padding:10px;color:#fff">Update Level</span></a>
               </li>
                <?php } }?>
                      
                       
                      
                      <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                              <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">Administrator</span><span class="user-status">Available</span></div><span><img class="round" src="app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="change-password.php"><i class="feather icon-mail"></i> Change Password</a>
                              <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="feather icon-power"></i> Logout</a>
                          </div>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </nav>