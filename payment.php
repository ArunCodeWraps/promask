<?php
include('include/config.php');
include("include/functions.php");
require_once('vendor_firebase/autoload.php');
require_once('vendor/autoload.php');


use \Firebase\JWT\JWT;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$connection_id = uniqid().rand().uniqid();
$serviceAccount = ServiceAccount::fromJsonFile('firebase_config.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
    $database = $firebase->getDatabase();
    $newPost = $database
        ->getReference('Connections/'. $connection_id)
        ->set([
            'connection_id' => $connection_id,
        ]);


?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php include("head.php"); ?>
</head>
<body class="preloader">
  <?php include("header.php"); ?>
  <?php include("banner.php"); ?>




    <!-- Action Box - Style 3 section with custom top padding and white background color -->
    <form action="https://checkout.wompi.co/p/" method="GET">
  <!-- OBLIGATORIOS -->
  <input type="hidden" name="public-key" value="pub_test_mJTauLDQ8TRwyNDI7yUdcivaHFElrDU3" />
  <input type="hidden" name="currency" value="COP" />
  <input type="hidden" name="amount-in-cents" value="10000000" />
  <input type="hidden" name="reference" value="<?php echo rand(000000000,9999999) ?>" />
  <!-- OPCIONALES -->
  <input type="hidden" name="redirect-url" value="http://localhost/promask/payment-response.php" />
  <button type="submit">Pagar con Wompi</button>
</form>






  

  
  

  
  
  <?php include("modal.php"); ?>
  <?php include("footer.php"); ?> 

</body>
</html>