<?php 
include('../include/config.php');
include("../include/functions.php");
// content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

//$datay=array(1000,5000,10000,50000,0,0,3000,400);


// Create the graph. These two calls are always required
$graph = new Graph(800,250,'auto');
$graph->SetScale("textlin");

//$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());
 $num = cal_days_in_month(CAL_GREGORIAN, '09', date('Y'));
 for($i=1;$i<= $num;$i++){
	 if($i<10){$i='0'.$i;} 
	$monthArr[]= $i;
	
	$cut_date=date('Y')."-".date('m')."-".$i;
	$orderArr=$obj->query("select count(*) as tot_register from $tbl_model where start_date like '".$cut_date."%' ",$debug=-1);
	$rsOrder=$obj->fetchNextObject($orderArr);
	if($rsOrder->tot_register==''){
		$rsOrder->tot_register=0;
		}
	$datay[]=$rsOrder->tot_register;
 }
//print_r($datay);
// set major and minor tick positions manually
$graph->yaxis->SetTickPositions(array(0,1,2,5,10,20,30),array(1,3,10,20,50,100,200,));
$graph->SetBox(false);

//$graph->ygrid->SetColor('gray');
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels($monthArr);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
$graph->yaxis->title->Set('Users');
$graph->xaxis->title->Set('Day');
$graph->xaxis->SetLabelAlign('right','center','right');
// Create the bar plots
$b1plot = new BarPlot($datay);

// ...and add it to the graPH
$graph->Add($b1plot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#85c22f");
$graph->title->Set("Users Registration -".date('M')." ".date('Y'));

// Display the graph
$graph->Stroke();
?>