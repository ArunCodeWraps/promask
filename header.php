
  <input type="checkbox" id="support_p" class="panel-checkbox">
  <div class="support_panel">
    <div class="support-close-inner">
      <label for="support_p" class="spanel-label inner">
        <span class="support-panel-close">×</span>
      </label>
    </div>  
    <div class="container">   
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-9">
          <!-- Title -->
          <h4 class="m_title mb-20">
            HOW TO SHOP
          </h4>

          <!-- Content - how to shop steps -->
          <div class="m_content how_to_shop">
            <div class="row">
              <div class="col-sm-4">
                <span class="number">1</span> Login or create new account.
              </div>
              <!--/ col-sm-4 -->

              <div class="col-sm-4">
                <span class="number">2</span> Review your order.
              </div>
              <!--/ col-sm-4 -->

              <div class="col-sm-4">
                <span class="number">3</span> Payment <strong>FREE</strong> shipment
              </div>
              <!--/ col-sm-4 -->
            </div>
            <!--/ row -->

            <p>
              If you still have problems, please let us know, by sending an email to support@website.com . Thank you!
            </p>
          </div>
          <!--/ Content - how to shop steps -->
        </div>
        <!--/ col-sm-12 col-md-12 col-lg-9 -->

        <div class="col-sm-12 col-md-12 col-lg-3">
          <!-- Title -->
          <h4 class="m_title mb-20">
            SHOWROOM HOURS
          </h4>

          <!-- Content -->
          <div class="m_content">
            Mon-Fri 9:00AM - 6:00AM<br>
            Sat - 9:00AM-5:00PM<br>
            Sundays by appointment only!
          </div>
          <!--/ Content -->
        </div>
        <!--/ col-sm-12 col-md-12 col-lg-3 -->
      </div>
      <!--/ row -->
    </div>
    <!--/ container -->
  </div>
  <!--/ Support Panel -->










    <!-- Page Wrapper -->
  <div id="page_wrapper">
    <!-- Header style 1 -->
    <header id="header" class="site-header cta_button" data-header-style="1">
      <!-- Header background -->
      <div class="kl-header-bg"></div>
      <!--/ Header background -->

      <!-- Header wrapper -->
      <div class="site-header-wrapper">
        <!-- Header Top wrapper -->
        <div class="site-header-top-wrapper">
          <!-- Header Top container -->
          <div class="siteheader-container container">
            <!-- Header Top -->
            <div class="site-header-row site-header-top d-flex justify-content-between">
              <!-- Header Top Left Side -->
              <div class="site-header-top-left d-flex">
                <!-- Header Top Social links -->
                <ul class="topnav social-icons sc--clean align-self-center">
                  <li>
                    <a href="#" target="_self" title="Facebook">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#" target="_self" title="Twitter">
                      <i class="fab fa-twitter"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#" target="_self" title="Dribbble">
                      <i class="fab fa-dribbble"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#" target="_self" title="Google Plus">
                      <i class="fab fa-google-plus-g"></i>
                    </a>
                  </li>
                </ul>
                <!--/ Header Top Social links -->

                <div class="clearfix visible-xxs">
                </div>

                <!-- Top Header contact text -->
                <div class="kl-header-toptext align-self-center"> 
                  <span class="topnav-item--text">QUESTIONS? CALL: </span>
                  <a href="tel:0900 800 900" class="fw-bold">0900 800 900</a>
                  <i class="phone-header fas fa-phone ml-5 visible-xs visible-sm visible-md"></i>
                </div>
                <!--/ Top Header contact text -->
              </div>
              <!--/ .site-header-top-left -->

              <!-- Header Top Right Side -->
              <div class="site-header-top-right d-flex">
                <div class="topnav support--panel align-self-center">
                  <!-- Support panel trigger -->
                  <label for="support_p" class="topnav-item spanel-label">
                    <i class="fas fa-info-circle support-info closed"></i>
                    <i class="far fa-times-circle support-info opened"></i>
                    <span class="topnav-item--text">SUPPORT</span>
                  </label>
                  <!--/ Support panel trigger -->
                </div>

                <!-- Login trigger -->
                <?php  if (empty($_SESSION['sess_user_id'])) { ?>  

                <div class="topnav login--panel align-self-center">
                  <a class="topnav-item popup-with-form" href="#login_panel">
                    <i class="login-icon fas fa-sign-in-alt visible-xs xs-icon"></i>
                    <span class="topnav-item--text">LOGIN</span>
                  </a>
                </div>

                <?php } else{?>
                  <div class="topnav topnav--lang align-self-center">
                    <div class="languages drop">
                      <a href="#" class="topnav-item">
                        <span class="fas fa-user xs-icon"></span>
                        <span class="topnav-item--text"><?php echo $_SESSION['sess_username'] ?></span>
                      </a>
                      <div class="pPanel">
                        <ul class="inner">
                          <li class="toplang-item">
                            <a href="user/welcome.php">
                              <i class="login-icon fas fa-tachometer-alt visible-xs xs-icon"></i> Dashboard
                            </a>
                          </li>
                          <li class="toplang-item">
                            <a href="logout.php">
                              <i class="login-icon fas fa-sign-out-alt visible-xs xs-icon"></i> Logout
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>

                <?php } ?>  

                <!--/ Login trigger -->     

                <!-- header search -->
                <!-- <div id="search" class="header-search align-self-center">
                  <a href="#" class="searchBtn "><span class="fas fa-search white-icon"></span></a>
                  <div class="search-container">
                    <form id="searchform" class="header-searchform" action="https://www.google.com/search" method="get" target="_blank">
                      <input id="q" name="q" maxlength="20" class="inputbox" type="text" size="20" value="SEARCH ..." onblur="if (this.value=='') this.value='SEARCH ...';" onfocus="if (this.value=='SEARCH ...') this.value='';">
                      <button type="submit" id="searchsubmit" class="searchsubmit fas fa-search white-icon"></button>
                    </form>
                  </div>
                </div> -->
                <!--/ header search -->
              </div>
              <!--/ .site-header-top-right -->
            </div>
            <!--/ .site-header-row .site-header-top -->

            <!-- Header separator -->
            <div class="separator site-header-separator"></div>
            <!--/ Header separator -->
          </div>
          <!--/ .siteheader-container .container -->
        </div>
        <!--/ Header Top wrapper -->

        <!-- Header Main wrapper -->
        <div class="site-header-main-wrapper d-flex">
          <!-- Header Main container -->
          <div class="siteheader-container container align-self-center">
            <!-- Header Main -->
            <div class="site-header-row site-header-main d-flex flex-row justify-content-between">
              <!-- Header Main Left Side -->
              <div class="site-header-main-left d-flex justify-content-start align-items-center">
                <!-- Logo container-->
                <div class="logo-container hasInfoCard logosize--yes">
                  <!-- Logo -->
                  <h1 class="site-logo logo" id="logo">
                    <a href="index" title="">
                      <img src="images/logo-promask.png" class="logo-img" alt="Kallyas" title="Kallyas Gigantic Premium Template" />
                    </a>
                  </h1>
                  <!--/ Logo -->

                  <!-- InfoCard -->
                  <div id="infocard" class="logo-infocard">
                    <div class="custom">
                      <div class="row">
                        <div class="col-sm-6 left-side d-flex">
                          <div class="align-self-center">
                            <div class="infocard-wrapper text-center">
                              <img src="images/kallyas_icon.png" class="mb-25" alt="Kallyas" title="Kallyas" />
                              <p>
                                Kallyas is an gigantic ultra-premium, responsive template built for today websites with over <strong>350 elements</strong>.
                              </p>
                            </div>
                            <!--/ infocard-wrapper -->
                          </div>
                          <!--/ .align-self-center -->
                        </div>
                        <!--/ col-sm-6 left-side d-flex -->

                        <div class="col-sm-6 right-side">
                          <div class="custom contact-details">
                            <p>
                              Your Company LTD<br>
                              Street nr 100, 4536534, Chicago, US <br>
                              <a href="mailto:sales@yourwebsite.com">sales@yourwebsite.com</a>
                            </p>
                            <a href="http://goo.gl/maps/1OhOu" class="map-link" target="_blank" title="">
                              <span class="fas fa-map-marker-alt white-icon mr-10"></span>
                              <span>Open in Google Maps</span>
                            </a>
                          </div>
                          <div style="height:20px;">
                          </div>
                          <!-- Social links clean style -->
                          <ul class="social-icons sc--clean">
                            <li><a href="#" target="_self" class="fab fa-twitter" title="Twitter"></a></li>
                            <li><a href="#" target="_self" class="fab fa-facebook-f" title="Facebook"></a></li>
                            <li><a href="#" target="_self" class="fab fa-dribbble" title="Dribbble"></a></li>
                            <li><a href="#" target="_blank" class="fab fa-google-plus-g" title="Google Plus"></a></li>
                          </ul>
                          <!--/ Social links clean style -->
                        </div>
                        <!--/ col-sm-6 right-side -->
                      </div>
                      <!--/ row -->
                    </div>
                    <!--/ custom -->
                  </div>
                  <!--/ InfoCard -->
                </div>
                <!--/ logo container-->

                <!-- Separator -->
                <div class="separator visible-xxs"></div>
                <!--/ Separator -->
              </div>
              <!--/ .site-header-main-left -->

              <!-- Header Main Center Side -->
              <div class="site-header-main-center d-flex justify-content-center align-items-center">
                <!-- Main Menu wrapper -->
                <div class="main-menu-wrapper">
                  <!-- Responsive menu trigger -->
                  <div id="zn-res-menuwrapper">
                    <a href="#" class="zn-res-trigger "></a>
                  </div>
                  <!--/ responsive menu trigger -->

                  <!-- Main menu -->
                  <div id="main-menu" class="main-nav zn_mega_wrapper">
                    <ul id="menu-main-menu" class="main-menu zn_mega_menu">
                      
                      <li class="menu-item-has-children"><a href="index">Home</a></li>
                      <li class="menu-item-has-children"><a href="our-company">Our company</a></li>
                      <li class="menu-item-has-children"><a href="#">Shop By Category</a>
                        <ul class="sub-menu clearfix">
                          <?php $mSql = $obj->query("select * from $tbl_maincategory where status='1' and parent_id='0'",$debug=-1); 
                           while($line1=$obj->fetchNextObject($mSql)){ ?>
                          <!-- <li><a href="portfolio-creative.html">PORTFOLIO - CREATIVE</a></li> -->
                          <li><a href="products/<?php echo $line1->slug ?>"><?php echo $line1->maincategory ?></a>
                            <ul class="sub-menu clearfix">
                              <?php $subSql = $obj->query("select * from $tbl_maincategory where status='1' and parent_id='".$line1->id."'",$debug=-1); 
                             while($subCat=$obj->fetchNextObject($subSql)){
                               ?>
                              <li><a href="products/<?php echo $subCat->slug ?>"><?php echo $subCat->maincategory ?></a></li>
                              <?php } ?>
                              
                            </ul>
                          </li>

                          <?php } ?>
                        </ul>
                      </li>
                      
                      <li class="menu-item-has-children"><a href="products/">Products</a></li>
                      <!-- <li class="menu-item-has-children"><a href="contactus">FAQ</a></li> -->
                      <li class="menu-item-has-children"><a href="contact-us">Contact Us</a></li>
                    </ul>
                  </div>
                  <!--/ Main menu -->
                </div>
                <!--/ .main-menu-wrapper -->
              </div>
              <!--/ .site-header-main-center -->

              <!-- Header Main Right Side -->
              <div class="site-header-main-right d-flex justify-content-end align-items-center">
                <!-- Shopping Cart -->
                <div class="mainnav mainnav--cart d-flex align-self-center" id="cartDiv">
                  
                </div>
                <!--/ Shopping Cart -->

                <!-- Call to action ribbon Free Quote (Contact form pop-up element) -->
                <div class="quote-ribbon">
                  <a href="#contact_panel" id="ctabutton" class="ctabutton kl-cta-ribbon" title="GET A FREE QUOTE" target="_self">
                    <strong>FREE</strong>QUOTE
                    <svg version="1.1" class="trisvg"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" preserveaspectratio="none" width="14px" height="5px" viewbox="0 0 14 5" enable-background="new 0 0 14 5" xml:space="preserve">
                      <polygon fill-rule="nonzero" points="14 0 7 5 0 0"></polygon>
                    </svg>
                  </a>
                </div>
                <!--/ Call to action ribbon Free Quote (Contact form pop-up element) -->
              </div>
              <!--/ .site-header-main-right -->
            </div>
            <!--/ .site-header-row .site-header-main -->
          </div>
          <!--/ .siteheader-container .container -->
        </div>
        <!--/ Header Main wrapper -->
      </div>
      <!--/ Header wrapper -->
    </header>
