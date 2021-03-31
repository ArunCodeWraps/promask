<!-- Contact form pop-up element content -->
  <div id="contact_panel" class="mfp-hide contact-popup">
    <div class="contact-popup-panel">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <!-- Contact form pop-up element -->
            <div class="contactForm pop-up-form">
              <!-- Google reCaptcha required javascript file -->
              <script src='js/api.js'></script>

              <!-- Title -->
              <h3 class="m_title m_title_ext text-custom contact-popup-title tcolor">
                GET A QUOTE !
              </h3>
              <h4 class="tbk__subtitle fw-thin">
                We'll do everything we can to make our next best project!
              </h4>

              <form action="https://tuperfume.club/php_helpers/_contact-process.php" method="post" class="contact_form row mt-40" enctype="multipart/form-data">
                <div class="cf_response"></div>

                <div class="col-sm-6 kl-fancy-form">
                  <input type="text" name="name" id="cf_name-pop-up" class="form-control" placeholder="Please enter your first name" value="" tabindex="1" maxlength="35" required>
                  <label class="control-label">
                    FIRSTNAME
                  </label>
                </div>

                <div class="col-sm-6 kl-fancy-form">
                  <input type="text" name="lastname" id="cf_lastname-pop-up" class="form-control" placeholder="Please enter your first last name" value="" tabindex="1" maxlength="35" required>
                  <label class="control-label">
                    LASTNAME
                  </label>
                </div>

                <div class="col-sm-12 kl-fancy-form">
                  <input type="text" name="email" id="cf_email-pop-up" class="form-control h5-email" placeholder="Please enter your email address" value="" tabindex="1" maxlength="35" required>
                  <label class="control-label">
                    EMAIL
                  </label>
                </div>

                <div class="col-sm-12 kl-fancy-form">
                  <input type="text" name="subject" id="cf_subject-pop-up" class="form-control" placeholder="Enter the subject message" value="" tabindex="1" maxlength="35" required>
                  <label class="control-label">
                    SUBJECT
                  </label>
                </div>

                <div class="col-sm-12 kl-fancy-form">
                  <textarea name="message" id="cf_message-pop-up" class="form-control" cols="30" rows="10" placeholder="Your message" tabindex="4" required></textarea>
                  <label class="control-label">
                    MESSAGE
                  </label>
                </div>

                <!-- Google recaptcha required site-key (change with yours => https://www.google.com/recaptcha/admin#list) -->
                <div class="g-recaptcha" data-sitekey="SITE-KEY"></div>
                <!--/ Google recaptcha required site-key -->

                <div class="col-sm-12">
                  <!-- Contact form send button -->
                  <button class="btn btn-fullcolor" type="submit">
                    Send
                  </button>
                </div>
              </form>
            </div>
            <!--/ Contact form pop-up element -->
          </div>
          <!--/ col-md-12 col-sm-12 -->
        </div>
        <!--/ .row -->
      </div>
      <!--/ .container -->
    </div>
    <!--/ .contact-popup-panel -->
    <button title="Close (Esc)" type="button" class="mfp-close">×</button>
  </div>
  <!--/ Contact form pop-up element content -->







  <!-- Login Panel content -->
  <div id="login_panel" class="mfp-hide loginbox-popup auth-popup">
    <div class="inner-container login-panel auth-popup-panel">
      <h3 class="m_title m_title_ext text-custom auth-popup-title tcolor">
        SIGN IN YOUR ACCOUNT TO HAVE ACCESS TO DIFFERENT FEATURES
      </h3>

      <form class="login_panel" name="login_panel" method="post" action="#">
        <div class=" kl-fancy-form">
          <input type="text" id="username" name="username" class="form-control inputbox kl-fancy-form-input kl-fw-input" placeholder="eg: james_smith">
          <label class="kl-font-alt kl-fancy-form-label">
            EMAIL
          </label>
        </div>

        <div class=" kl-fancy-form">
          <input type="password" id="password" name="password" class="form-control inputbox kl-fancy-form-input kl-fw-input" placeholder="type password">
          <label class="kl-font-alt kl-fancy-form-label">
            PASSWORD
          </label>
        </div>

        <label class="auth-popup-remember" for="kl-rememberme">
          <input type="checkbox" name="rememberme" id="kl-rememberme" value="forever" class="auth-popup-remember-chb"> Remember Me 
        </label>

        <input type="submit" id="login" name="submit_button" class="btn zn_sub_button btn-fullcolor btn-md" value="LOG IN">

        <input type="hidden" value="login" class="" name="form_action">
        <input type="hidden" value="login" class="" name="action">
        <input type="hidden" value="#" class="" name="submit">

        <div class="links auth-popup-links">
          <a href="#register_panel" class="create_account auth-popup-createacc kl-login-box auth-popup-link">
            CREATE AN ACCOUNT
          </a>

          <span class="sep auth-popup-sep"></span>

          <a href="#forgot_panel" class="kl-login-box auth-popup-link">
            FORGOT YOUR PASSWORD?
          </a>

          <p id="loginmsg" style="font-size: 13px;text-align: center;margin-top: 20px;"></p>
        </div>
      </form>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close">×</button>
  </div>




  <div id="register_panel" class="mfp-hide loginbox-popup auth-popup">
    <div class="inner-container register-panel auth-popup-panel">
      <h3 class="m_title m_title_ext text-custom auth-popup-title">
        CREATE ACCOUNT
      </h3>

      <form class="register_panel" name="register_panel" method="post" action="#">
        <div class=" kl-fancy-form ">
          <input type="text" id="reg-username" name="user_name" class="form-control inputbox kl-fancy-form-input kl-fw-input" placeholder="type desired username" required>
          <label class="kl-font-alt kl-fancy-form-label">NAME</label>
        </div>

        <div class="kl-fancy-form">
          <input type="email" id="reg-email" name="user_email" class="form-control inputbox kl-fancy-form-input kl-fw-input" placeholder="your-email@website.com" required>
          <label class="kl-font-alt kl-fancy-form-label">
            EMAIL
          </label>
        </div>
        <div class=" kl-fancy-form">
          <input type="password" id="reg-pass" name="user_password" class="form-control inputbox kl-fancy-form-input kl-fw-input" placeholder="*****" required>
          <label class="kl-font-alt kl-fancy-form-label">
            PASSWORD
          </label>
        </div>

        <div class="kl-fancy-form">
          <input type="password" id="reg-pass2" name="user_password2" class="form-control inputbox kl-fancy-form-input kl-fw-input" placeholder="*****" required>
          <label class="kl-font-alt kl-fancy-form-label">
            CONFIRM PASSWORD
          </label>
        </div>

        <div class="">
          <input type="submit" id="signup" name="submit" class="btn zn_sub_button btn-block btn-fullcolor btn-md" value="CREATE MY ACCOUNT">
        </div>

        <div class="links auth-popup-links">
          <a href="#login_panel" class="kl-login-box auth-popup-link">
            ALREADY HAVE AN ACCOUNT?
          </a>
          <p id="regismsg" style="font-size: 13px;text-align: center;margin-top: 20px;"></p>
        </div>
      </form>
    </div>
  </div>




  <div id="forgot_panel" class="mfp-hide loginbox-popup auth-popup forgot-popup">
    <div class="inner-container forgot-panel auth-popup-panel">
      <h3 class="m_title m_title_ext text-custom auth-popup-title">
        FORGOT YOUR DETAILS?
      </h3>

      <form class="forgot_form" name="forgot_form" method="post" action="#">
        <div class=" kl-fancy-form">
          <input type="text" id="forgot-email" name="user_login" class="form-control inputbox kl-fancy-form-input kl-fw-input" placeholder="...">
          <label class="kl-font-alt kl-fancy-form-label">
            USERNAME OR EMAIL
          </label>
        </div>

        <div class="">
          <input type="submit" id="recover" name="submit" class="btn btn-block zn_sub_button btn-fullcolor btn-md" value="SEND MY DETAILS!">
        </div>
        
        <div class="links auth-popup-links">
          <a href="#login_panel" class="kl-login-box auth-popup-link">
            AAH, WAIT, I REMEMBER NOW!
          </a>
        </div>
      </form>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close">×</button>
  </div>
  <!--/ Login Panel content -->