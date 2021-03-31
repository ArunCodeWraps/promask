<?php
include('../include/config.php');
include("../include/functions.php");
validate_user();
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>
    <link rel="stylesheet" href="../colorbox/colorbox.css" />
    <script src="../colorbox/jquery.colorbox.js"></script>
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
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row pb-50">
                                            <div class="col-lg-12 col-12 d-flex justify-content-between flex-column order-lg-1 order-2 mt-lg-0 mt-2">
                                                <div>
                                                    <h2 class="text-bold-700 mb-25">Reward Progress Bar</h2>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: 25%">
                                                        25%
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between pb-0">
                                    <h4 class="card-title">Support Tracker</h4>
                                    <div class="dropdown chart-dropdown">
                                        <button class="btn btn-sm border-0 dropdown-toggle p-0" type="button" id="dropdownItem4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Last 7 Days
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem4">
                                            <a class="dropdown-item" href="#">Last 28 Days</a>
                                            <a class="dropdown-item" href="#">Last Month</a>
                                            <a class="dropdown-item" href="#">Last Year</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                                <h1 class="font-large-2 text-bold-700 mt-2 mb-0">163</h1>
                                                <small>Tickets</small>
                                            </div>
                                            <div class="col-sm-10 col-12 d-flex justify-content-center">
                                                <div id="support-tracker-chart"></div>
                                            </div>
                                        </div>
                                        <div class="chart-info d-flex justify-content-between">
                                            <div class="text-center">
                                                <p class="mb-50">New Tickets</p>
                                                <span class="font-large-1">29</span>
                                            </div>
                                            <div class="text-center">
                                                <p class="mb-50">Open Tickets</p>
                                                <span class="font-large-1">63</span>
                                            </div>
                                            <div class="text-center">
                                                <p class="mb-50">Response Time</p>
                                                <span class="font-large-1">1d</span>
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
                                $sql=$obj->query("select * from $tbl_order where 1=1 and user_id='".$_SESSION['sess_user_id']."' order by id desc limit 0,5",$debug=-1);
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
                                    <script>
                                    $(document).ready(function(){
                                        $(".iframeOrder<?php echo $line->id ?>").colorbox({iframe:true, width:"900px;", height:"800px;", frameborder:"0",scrolling:true});
                                    });
                                    </script>
                                    <a href="vieworder-detail.php?order_id=<?php echo $line->id ?>" class="btn btn-primary iframeOrder<?php echo $line->id ?>" title="View Details">
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
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <?php include("footer.php"); ?>
</body>
</html>

<style>
    .bs-example{
        margin: 20px;        
    }
    /* Adding space at the bottom of progress bar */
    .progress{
        margin-bottom: 1rem;
        height: 40px;
        margin-top: 50px;
    }
</style>