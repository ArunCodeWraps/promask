<?php
include('../include/config.php');
include("../include/functions.php");
validate_user();


$whr ="";
if($_GET['search_filter']){
    $search_filter = $_GET['search_filter'];
    if($search_filter==1){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 7 DAY)";
        $day = "Last Week";
    }else if($search_filter==2){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        $day = "Last Month";
    }else if($search_filter==3){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 3 MONTH)";
        $day = "Last 3 Months";
    }else if($search_filter==4){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 6 MONTH)";
        $day = "Last 6 Months";
    }else if($search_filter==5){
        $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 1 YEAR)";
        $day = "Last 1 Year";
    }
}else{
    $whr .=" and date(order_date) > DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $day = "Last Week";
}

?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<style type="text/css">
.orderviewdetails{
max-width: 900px;
}
</style>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<?php include("header.php"); ?>
<?php include("menu.php"); ?>

<!-- modal1 -->
<div class="modal fade" id="stickyModal1" tabindex="-1" role="dialog" aria-labelledby="stickyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"><?php echo getField('reward_name',$tbl_reward,1); ?></div>
        </div>
    </div>
</div>

<!-- modal2 -->
<div class="modal fade" id="stickyModal2" tabindex="-1" role="dialog" aria-labelledby="stickyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"><?php echo getField('reward_name',$tbl_reward,2); ?></div>
        </div>
    </div>
</div>

<!-- modal3 -->
<div class="modal fade" id="stickyModal3" tabindex="-1" role="dialog" aria-labelledby="stickyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"><?php echo getField('reward_name',$tbl_reward,3); ?></div>
        </div>
    </div>
</div>

<!-- modal4 -->
<div class="modal fade" id="stickyModal4" tabindex="-1" role="dialog" aria-labelledby="stickyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"><?php echo getField('reward_name',$tbl_reward,4); ?></div>
        </div>
    </div>
</div>
<!-- modal end -->

<div class="app-content content">
<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<div class="content-wrapper">
<div class="content-header row">
</div>
<div class="content-body">
<section id="dashboard-analytics">
<div class="row">
<div class="col-lg-6 col-md-12 col-sm-12">
    <div class="card bg-analytics text-white">
        <div class="card-content">
            <div class="card-body text-center">
                <img src="app-assets/images/elements/decore-left.png" class="img-left" alt="
                card-img-left">
                <img src="app-assets/images/elements/decore-right.png" class="img-right" alt="
                card-img-right">
                <div class="avatar avatar-xl bg-primary shadow mt-0">
                    <div class="avatar-content">
                        <i class="feather icon-award white font-large-1"></i>
                    </div>
                </div>
                <div class="text-center">
                    <?php
                    $LevSql = $obj->query("select level_name from $tbl_cron_level where user_id='".$_SESSION['sess_user_id']."' and MONTH(cdate)=MONTH(NOW())");
                    $LevResult = $obj->fetchNextObject($LevSql);
                     ?>
                    <h1><?php echo $LevResult->level_name; ?></h1>
                    <h1 class="mb-2 text-white">Congratulations <?php echo getField('name',$tbl_user,$_SESSION['sess_user_id']) ?>,</h1>
                    <!-- <p class="m-auto w-75">You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.</p> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-12">
    <div class="card">
        <div class="card-header d-flex flex-column align-items-start pb-0">
            <div class="avatar bg-rgba-primary p-50 m-0">
                <div class="avatar-content">
                    <i class="feather icon-users text-primary font-medium-5"></i>
                </div>
            </div>
            <h2 class="text-bold-700 mt-1 mb-25">$<?php echo getTodaySales($_SESSION['sess_user_id']) ?></h2>
            <p class="mb-0">Today Sales</p>
        </div>
        <div class="card-content">
            <div id="subscribe-gain-chart"></div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-12">
    <div class="card">
        <div class="card-header d-flex flex-column align-items-start pb-0">
            <div class="avatar bg-rgba-warning p-50 m-0">
                <div class="avatar-content">
                    <i class="feather icon-package text-warning font-medium-5"></i>
                </div>
            </div>
            <h2 class="text-bold-700 mt-1 mb-25">$<?php echo getTotalSales($_SESSION['sess_user_id']) ?></h2>
            <p class="mb-0">All Sales</p>
        </div>
        <div class="card-content">
            <div id="orders-received-chart"></div>
        </div>
    </div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-12">
    <!-- progressbar -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row pb-50">
                    <div class="col-lg-12 col-12 d-flex justify-content-between flex-column order-lg-1 order-2 mt-lg-0 mt-2">
                        <div>
                            <h2 class="text-bold-700 mb-5 ">Reward Progress Bar</h2>
                        </div>
                        <div class="progress-wrapper">
                            <div class="upper-layer">
                                <span>0</span>
                                <span><?php echo getField('r_days',$tbl_reward,1); ?></span>
                                <span><?php echo getField('r_days',$tbl_reward,2); ?></span>
                                <span><?php echo getField('r_days',$tbl_reward,3); ?></span>
                                <span><?php echo getField('r_days',$tbl_reward,4); ?></span>
                            </div>
                                <?php //echo getTotalSaleswithDuration($_SESSION['sess_user_id']); ?>
                            <div class="progress probar">
                          <div class="progress-bar" role="progressbar" style="width: <?php echo getTotalSaleswithDuration($_SESSION['sess_user_id']); ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="bottom-layer">
                                <span><img src="../images/notes.png">0</span>
                                <span><img src="../images/notes.png" data-toggle="modal" data-target="#stickyModal1">$<?php echo getField('amount',$tbl_reward,1); ?></span>
                                <span><img src="../images/notes.png" data-toggle="modal" data-target="#stickyModal2">$<?php echo getField('amount',$tbl_reward,2); ?></span>
                                <span><img src="../images/notes.png" data-toggle="modal" data-target="#stickyModal3">$<?php echo getField('amount',$tbl_reward,3); ?></span>
                                <span><img src="../images/notes.png" data-toggle="modal" data-target="#stickyModal4"> $<?php echo getField('amount',$tbl_reward,4); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



     <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row pb-50">
                    <div class="col-lg-12 col-12 d-flex justify-content-between flex-column order-lg-1 order-2 mt-lg-0 mt-2">

						<?php
						//Product Wise Goal Show

						$orderArr = array();
						$pssql=$obj->query("select id from tbl_order where 1=1 and (user_id='".$_SESSION['sess_user_id']."' or seller_id='".$_SESSION['sess_user_id']."') and order_status=3 $whr",-1); //die;
						while($PSresult=$obj->fetchNextObject($pssql)){
						$porderArr[] = $PSresult->id;
						}

						$porderId = implode(',',$porderArr);

						
						if(!empty($porderId)){
							$data = array();
							$osql = $obj->query("select product_id,sum(qty) as qty,sum(price) as price from tbl_order_itmes where order_id in ($porderId) group by product_id",-1); //die;
							while($oResult = $obj->fetchNextObject($osql)){
								$totalUSales = $oResult->price*$oResult->qty;
								$data['label'] = substr(getField('name',$tbl_product,$oResult->product_id),0,20);
								$data['y'] = $totalUSales;
								$dataPoints[] = $data;
							}
							
						}
						

						?>
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<div class="col-md-6 col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-0">
            <h4 class="card-title">Over all Goal</h4>
            <div class="dropdown chart-dropdown">
                <button class="btn btn-sm border-0 dropdown-toggle p-0" type="button" id="dropdownItem4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $day; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem4">
                    <a class="dropdown-item" href="welcome.php?search_filter=1">Last Week</a>
                    <a class="dropdown-item" href="welcome.php?search_filter=2">Last Month</a>
                    <a class="dropdown-item" href="welcome.php?search_filter=3">Last 3 Month</a>
                    <a class="dropdown-item" href="welcome.php?search_filter=4">Last 6 Month</a>
                    <a class="dropdown-item" href="welcome.php?search_filter=5">Last 1 Year</a>
                   
                </div>
            </div>
        </div>
        <?php
        $orderArr = array();
        $sql=$obj->query("select id from tbl_order where 1=1 and (user_id='".$_SESSION['sess_user_id']."' or seller_id='".$_SESSION['sess_user_id']."') and order_status=3 $whr",-1); //die;
        while($result=$obj->fetchNextObject($sql)){
            $orderArr[] = $result->id;
        }
        $totalUSales=0;
        $orderId = implode(',',$orderArr);
        if(!empty($orderId)){
            $osql = $obj->query("select product_id,sum(qty) as qty,price as price from tbl_order_itmes where order_id in ($orderId)  GROUP by product_id",-1); //die;
            while($oResult = $obj->fetchNextObject($osql)){
                $totalUUSales = $oResult->price*$oResult->qty;
                $totalUSales = $totalUSales + $totalUUSales;
            }
            
        }

        if(!empty($search_filter)){
            $totalGoalPrice =  getTotalSaleProductOnGoal($search_filter);
        }else{
            $totalGoalPrice =  getTotalSaleProductOnGoal(1);
        }
        $totPercentage = intval($totalUSales*100/$totalGoalPrice);
        ?>
        <div class="card-content">
            <div class="card-body pt-0">
                <div class="row">       
                    <div class="col-sm-10 col-12 d-flex justify-content-center">
                        <div id="support-tracker-chart"></div>
                    </div>
                </div>
                <div class="chart-info d-flex justify-content-between">
                    <div class="text-center">
                        <p class="mb-50">Total Sale</p>
                        <span class="font-large-1">$<?php echo $totalUSales; ?></span>
                    </div>
                    <div class="text-center">
                        <p class="mb-50">Total Goal</p>
                        <span class="font-large-1">$<?php echo number_format($totalGoalPrice); ?></span>
                    </div>
                    <div class="text-center">
                        <p class="mb-50">Goal Product</p>
                        <span class="font-large-1"><?php echo getTotalProductOnGoal(); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Previous Orders</h4>
        </div>
        <div class="card-content">
            <div class="table-responsive mt-1">
                <table class="table table-hover-animation mb-0">
                    <thead>
                        <tr>
                            <th>Order Date/Time</th>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Method of payment</th>
                            <th>Name/Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php
        $i=1;
        if($_SESSION['sess_user_type']=='user'){
        $sql=$obj->query("select * from $tbl_order where 1=1 and user_id='".$_SESSION['sess_user_id']."' order by id desc limit 0,5",$debug=-1);
      }else{
        $sql=$obj->query("select * from $tbl_order where 1=1 and (user_id='".$_SESSION['sess_user_id']."' or seller_id='".$_SESSION['sess_user_id']."') order by id desc limit 0,5",$debug=-1);
      }
        
        while($line=$obj->fetchNextObject($sql)){?>
        <tr>
            <td class="product-image"><?php echo stripslashes($line->order_date); ?></td>
            <td class="product-name"><?php echo stripslashes($line->order_id); ?></td>
            <td class="product-image">$<?php echo stripslashes($line->total_amount); ?></td>
            <td class="product-image"><?php echo stripslashes($line->payment_method); ?></td>
            <td class="product-image"><?php echo ucfirst(strtolower(getField('name',$tbl_user,$line->user_id))); ?><br>
                <?php echo getField('email',$tbl_user,$line->user_id); ?>
            </td>

            <td class="product-action">
            
            <a href="javascript:void(0)" class="btn btn-primary" title="View Details" onclick="viewOrder(<?php echo $line->id ?>)">
            <i class="fa fa-eye"></i></a>                    
            </td>
        </tr>
        <?php $i++; }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</section>
</div>
</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog orderviewdetails">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body"></div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div>

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script>
window.onload = function () {
 var d = new Date();
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "Product Goal - "+d.getFullYear()
	},
	axisY: {
		suffix: "$",
		scaleBreaks: {
			autoCalculate: true
		}
	},
	data: [{
		type: "column",
		yValueFormatString: "$#,##0",
		indexLabel: "{y}",
		indexLabelPlacement: "inside",
		indexLabelFontColor: "white",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
<script type="text/javascript">
    $(window).on("load", function () {

  var $primary = '#7367F0';
  var $danger = '#EA5455';
  var $warning = '#FF9F43';
  var $info = '#0DCCE1';
  var $primary_light = '#8F80F9';
  var $warning_light = '#FFC085';
  var $danger_light = '#f29292';
  var $info_light = '#1edec5';
  var $strok_color = '#b9c3cd';
  var $label_color = '#e7eef7';
  var $white = '#fff';

  // Support Tracker Chart starts
  // -----------------------------

  var supportChartoptions = {
    chart: {
      height: 270,
      type: 'radialBar',
    },
    plotOptions: {
      radialBar: {
        size: 150,
        startAngle: -150,
        endAngle: 150,
        offsetY: 20,
        hollow: {
          size: '65%',
        },
        track: {
          background: $white,
          strokeWidth: '100%',

        },
        dataLabels: {
          value: {
            offsetY: 30,
            color: '#99a2ac',
            fontSize: '2rem'
          }
        }
      },
    },
    colors: [$danger],
    fill: {
      type: 'gradient',
      gradient: {
        // enabled: true,
        shade: 'dark',
        type: 'horizontal',
        shadeIntensity: 0.5,
        gradientToColors: [$primary],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100]
      },
    },
    stroke: {
      dashArray: 8
    },
    series: [<?php echo $totPercentage; ?>],
    labels: ['Total Sales'],

  }

  var supportChart = new ApexCharts(
    document.querySelector("#support-tracker-chart"),
    supportChartoptions
  );

  supportChart.render();

  // Support Tracker Chart ends

});
</script>
<?php include("footer.php"); ?>
</body>
</html>

<script type="text/javascript">
function viewOrder(id){
$.ajax({
url:"ajax/viewOrderDetails.php",
data:{order_id:id},
beforeSend:function(){
},
success:function(data){
$(".modal-body").html(data);
$("#myModal").modal('show');
}
});
}
</script>