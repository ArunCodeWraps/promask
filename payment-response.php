<?php
include('include/config.php');
include("include/functions.php");


echo '<pre>';
print_r($_REQUEST); die;
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
  <input type="hidden" name="public-key" value="LLAVE_PUBLICA_DEL_COMERCIO" />
  <input type="hidden" name="currency" value="MONEDA" />
  <input type="hidden" name="amount-in-cents" value="MONTO_EN_CENTAVOS" />
  <input type="hidden" name="reference" value="REFERENCIA_DE_PAGO" />
  <!-- OPCIONALES -->
  <input type="hidden" name="redirect-url" value="payment-response.php" />
  <button type="submit">Pagar con Wompi</button>
</form>






  

  
  

  
  
  <?php include("modal.php"); ?>
  <?php include("footer.php"); ?> 

</body>
</html>