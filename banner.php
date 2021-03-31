    <!-- Slideshow - iOS Slider element with animateme scroll efect, custom height and bottom mask style 2 -->
    <div class="kl-slideshow iosslider-slideshow uh_light_gray maskcontainer--shadow_ud iosslider--custom-height scrollme">
      <!-- Loader -->
      <div class="kl-loader">
        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewbox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"><path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path><path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z" transform="rotate(98.3774 20 20)"><animatetransform attributetype="xml" attributename="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatcount="indefinite"></animatetransform></path></svg>
      </div>
      <!-- Loader -->

      <div class="bgback">
      </div>

      <!-- Animated Sparkles -->
      <div class="th-sparkles">
      </div>
      <!--/ Animated Sparkles -->

      <!-- iOS Slider wrapper with animateme scroll efect -->
      <div class="iosSlider kl-slideshow-inner animateme" data-trans="6000" data-autoplay="1" data-infinite="true" data-when="span" data-from="0" data-to="0.75" data-translatey="300" data-easing="linear">
        <!-- Slides -->
        <div class="kl-iosslider hideControls">
          

          


          <?php $bSql = $obj->query("select photo,title,sub_title,target_url from $tbl_banner where status=1",$debug=-1); 
          $i=1;
          while($line=$obj->fetchNextObject($bSql)){ 
              if(is_file("upload_image/banner/".$line->photo)){
           ?>
          <div class="item iosslider__item">
            <div class="slide-item-bg" style="background-image: url(upload_image/banner/<?php echo $line->photo; ?>);"></div>
            <!-- Gradient overlay -->
            <div class="kl-slide-overlay" style="background:rgba(91,48,0,0.3); background: -moz-linear-gradient(left, rgba(91,48,0,0.3) 0%, rgba(53,53,53,0.25) 100%); background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(91,48,0,0.3)), color-stop(100%,rgba(53,53,53,0.25))); background: -webkit-linear-gradient(left, rgba(91,48,0,0.3) 0%,rgba(53,53,53,0.25) 100%); background: -o-linear-gradient(left, rgba(91,48,0,0.3) 0%,rgba(53,53,53,0.25) 100%); background: -ms-linear-gradient(left, rgba(91,48,0,0.3) 0%,rgba(53,53,53,0.25) 100%); background: linear-gradient(to right, rgba(91,48,0,0.3) 0%,rgba(53,53,53,0.25) 100%); ">
            </div>
            <!--/ Gradient overlay -->
            <!-- Captions container -->
            <div class="container kl-iosslide-caption kl-ioscaption--style5 zoomin klios-aligncenter kl-caption-posv-middle">
              <!-- Captions animateme wrapper -->
              <div class="animateme" data-when="span" data-from="0" data-to="0.75" data-opacity="0.1" data-easing="linear">
                <!-- Main Big Title -->
                <h2 class="main_title has_titlebig kl-ios-has-sqbox ">
                  <span class="kl-ios-sqbox"></span>
                  <span>
                    <strong><?php echo $line->title; ?></strong>
                  </span>
                </h2>
                <!--/ Main Big Title -->

                <!-- Big Title -->
                <h3 class="title_big">
                  <strong><?php echo $line->sub_title; ?> </strong>
                </h3>
                <!--/ Big Title -->
                <!-- Link buttons -->
                <div class="more">
                  <!-- Button full color style -->
                  <a href="<?php echo $line->target_url; ?>" target="_self" class="btn btn-fullcolor" title="" >
                    Buy Now
                  </a>
                  <!--/ Button full color style -->
                </div>
                <!--/ Link buttons -->
              </div>
              <!--/ Captions animateme wrapper -->
            </div>
            <!--/ Captions container -->
          </div>
          <!--/ Slide 4 -->
          <?php $i++; } } ?>   
          
        </div>
        <!--/ Slides -->

        <!-- Navigation Controls - Prev -->
        <div class="kl-iosslider-prev">
          <!-- Arrow -->
          <span class="thin-arrows ta__prev"></span>
          <!--/ Arrow -->

          <!-- Label - prev -->
          <div class="btn-label">
            PREV
          </div>
          <!--/ Label - prev -->
        </div>
        <!--/ Navigation Controls - Prev -->

        <!-- Navigation Controls - Next -->
        <div class="kl-iosslider-next">
          <!-- Arrow -->
          <span class="thin-arrows ta__next"></span>
          <!--/ Arrow -->

          <!-- Label - next -->
          <div class="btn-label">
            NEXT
          </div>
          <!--/ Label - next -->
        </div>
        <!--/ Navigation Controls - Prev -->
      </div>
      <!--/ iOS Slider wrapper with animateme scroll efect -->

      <!-- Bullets -->
      <div class="kl-ios-selectors-block bullets2">
        <div class="selectors">
          <?php $bSql = $obj->query("select photo,title,sub_title,target_url from $tbl_banner where status=1",$debug=-1); 
          $i=1;
          while($line=$obj->fetchNextObject($bSql)){ 
              if(is_file("upload_image/banner/".$line->photo)){
           ?>
          <!-- Item #1 -->
          <div class="item iosslider__bull-item <?php echo ($i=="1")?'first':''; ?>">
          </div>
          <?php $i++; } } ?> 
          <!--/ Item #1 -->          
        </div>
        <!--/ .selectors -->
      </div>
      <!--/ Bullets -->

      <div class="scrollbarContainer">
      </div>

      <!-- Bottom mask style 2 -->
      <div class="kl-bottommask kl-bottommask--shadow_ud">
      </div>
      <!--/ Bottom mask style 2 -->
    </div>
    <!--/ Slideshow - iOS Slider element with animateme scroll efect, custom height and bottom mask style 2 -->