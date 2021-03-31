<link href="<?php echo SITE_URL; ?>include/pagination.css" rel="stylesheet" type="text/css" />
<?php
  $adjacents = 3;
  if(empty($targetpage)) $targetpage = "?";
  if(empty($limit)) $limit = 50;
  $page = $_GET['page'];
  if ($page)
      $start = ($page - 1) * $limit;
  else
      $start = 0;
  
  if ($page == 0)
      $page = 1;
  $prev = $page - 1;
  $next = $page + 1;
  $lastpage = ceil($total_pages / $limit);
  $lpm1 = $lastpage - 1;
  
  $pagination = "";
  if ($lastpage > 1) {
      $pagination .= "<div class=\"pagination\">";
      if ($page > 1)
          $pagination .= "<a href=\"$targetpage-p-$prev\">&laquo; Previous</a>";
      else
          $pagination .= "<span class=\"disabled\">&laquo; Previous</span>";
      
      
      if ($lastpage < 7 + ($adjacents * 2)) {
          for ($counter = 1; $counter <= $lastpage; $counter++) {
              if ($counter == $page)
                  $pagination .= "<span class=\"current\">$counter</span>";
              else
                  $pagination .= "<a href=\"$targetpage-p-$counter\">$counter</a>";
          }
      } elseif ($lastpage > 5 + ($adjacents * 2)) {
          if ($page < 1 + ($adjacents * 2)) {
              for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                  if ($counter == $page)
                      $pagination .= "<span class=\"current\">$counter</span>";
                  else
                      $pagination .= "<a href=\"$targetpage-p-$counter\">$counter</a>";
              }
              $pagination .= "...";
              $pagination .= "<a href=\"$targetpage-p-$lpm1\">$lpm1</a>";
              $pagination .= "<a href=\"$targetpage-p-$lastpage\">$lastpage</a>";
          } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
              $pagination .= "<a href=\"$targetpage-p-1\">1</a>";
              $pagination .= "<a href=\"$targetpage-p-2\">2</a>";
              $pagination .= "...";
              for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                  if ($counter == $page)
                      $pagination .= "<span class=\"current\">$counter</span>";
                  else
                      $pagination .= "<a href=\"$targetpage-p-$counter\">$counter</a>";
              }
              $pagination .= "...";
              $pagination .= "<a href=\"$targetpage-p-$lpm1\">$lpm1</a>";
              $pagination .= "<a href=\"$targetpage-p-$lastpage\">$lastpage</a>";
          } else {
              $pagination .= "<a href=\"$targetpage-p-1\">1</a>";
              $pagination .= "<a href=\"$targetpage-p-2\">2</a>";
              $pagination .= "...";
              for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                  if ($counter == $page)
                      $pagination .= "<span class=\"current\">$counter</span>";
                  else
                      $pagination .= "<a href=\"$targetpage-p-$counter\">$counter</a>";
              }
          }
      }
      if ($page < $counter - 1)
          $pagination .= "<a href=\"$targetpage-p-$next\">Next &raquo;</a>";
      else
          $pagination .= "<span class=\"disabled\">Next &raquo;</span>";
      $pagination .= "</div>\n";
  }
?>