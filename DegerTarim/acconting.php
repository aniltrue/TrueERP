<?php include('head.php'); ?>

<?php
if(isset($_GET["Year"]))
	$Year = trim($_GET["Year"]);
else {
	$now = new DateTime('now');
	$Year = $now->format("Y");
}

$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");

$Payments = $conn->query("SELECT * FROM Payment WHERE PaymentYear = '" . $Year . "'");
if(!$Payments)
	$Revenue = 0;
else {
	$Cost = 0;
	while($row = $Payments->fetch_assoc()) 
		$Revenue += $row["Money"];
}

$Bills = $conn->query("SELECT * FROM Bill WHERE BillYear = '" . $Year . "'");
if(!$Bills)
	$Cost = 0;
else {
	$Cost = 0;
	while($row = $Bills->fetch_assoc()) 
		$Revenue += $row["BillAmount"];
}

$conn->close();

?>

<form method="get" class="w3-container w3-text-green">

<div class="w3-container w3-left">
	<p>Dönem: 
    <?php echo '<input class="w3-border" name="Year" type="number" value="' . $Year . '" />'; ?></p>
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Göster</button>

</form>

<ul class="w3-ul">
  <li><p><?php echo $Year; ?> dönemine ait toplanan para = <b><?php echo $Revenue; ?></b> TL</li></p>
  <li><p><?php echo $Year; ?> dönemine ait toplam fatura = <b><?php echo $Cost; ?></b> TL</li></p>
  <li><p><?php echo $Year; ?> dönemine ait edilen kar    = <b>
  <?php 
  $Profit = $Revenue - $Cost;
  if ($Profit > 0)
  	echo '<label class="w3-text-black">' . $Profit . '</label>'; 
  else
  	echo '<label class="w3-text-red">' . $Profit . '</label>'; 
  ?>
  </b> TL</p></li>
</ul>

<?php include('tail.php'); ?>