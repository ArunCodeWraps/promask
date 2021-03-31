<?php 
if($reccnt > $pagesize)
{
	
 $num_pages=$reccnt/$pagesize;

$PHP_SELF=$_SERVER['PHP_SELF'];
$qry_str=$_SERVER['argv'][0];

$m=$_REQUEST;
unset($m['start']);

$qry_str=str_replace("?","",qry_str($m));

//echo "$qry_str : $p<br>";

//$j=abs($num_pages/10)-1;
$j=$start/$pagesize-5;
//echo("<br>$j");
if($j<0) {
	$j=0;
}
$k=$j+10;
if($k>$num_pages)	{
	$k=$num_pages;
}
$j=intval($j);
?>
<link rel="stylesheet" href="css/algarve.css" type="text/css">
<table border="0" cellspacing="0" cellpadding="0" align="right" class="txt"> 
  <tr> 
    <td align="right" > &nbsp;&nbsp;&nbsp; 
      <?php
			
			for($i=$j;$i<$k;$i++)
			{
				if($i==$j)echo "Page:";
			   if(($pagesize*($i))!=$start)
				  {
	  ?> 
     
      <a href="<?php echo $PHP_SELF;?>?start=<?php echo $pagesize*($i);?>&<?php echo $qry_str;?>" style="color:#666666;">
	  <strong><font size="+1"></font><?php echo $i+1;?></font></strong></a> 
      <?php
		}
	  else{
	  ?> 
       
      <?php echo $i+1;?> 
       
      <?php
	  }
 }?> </td> 
  </tr> 
</table> 
<?php }
?> 
