<?php include('head.php'); ?>

<?php

if(isset($_POST["Create"])) {
	if(empty($_POST["BillDescription"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Fatura Açıklaması kısmı boş olamaz!</p></div>';

	if(empty($_POST["BillAmount"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Fatura Tutarı kısmı boş olamaz!</p></div>';

	if(empty($_POST["BillDate"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Fatura Tarihi kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["BillYear"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Dönem kısmı boş olamaz!</p></div>';
		
	if(!empty($_POST["BillDescription"]) && !empty($_POST["BillDate"]) && !empty($_POST["BillYear"]) && !empty($_POST["BillAmount"])) {
		$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
		
		if($conn->connect_error)
     		die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
		
		$conn->query("SET NAMES 'utf8'");
		
		$description = $conn->real_escape_string(trim($_POST["BillDescription"]));
		$amount = trim($_POST["BillAmount"]);
		$date = $conn->real_escape_string(trim($_POST["BillDate"]));
		$year = $conn->real_escape_string(trim($_POST["BillYear"]));
		
		$sql = "INSERT INTO Bill (BillDescription, BillAmount, BillDate, BillYear) VALUES ('" . $description . "', '" . $amount . "', '" . $date . "', '" . $year . "')";
		$rslt = $conn->query($sql);
		$conn->close();
		
		if($rslt == true)
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p>Fatura başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}
?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>Fatura Ekle</h3>
 
<div class="w3-row w3-section">
	<p>Fatura Açıklaması</p>
	<input class="w3-input w3-border" name="BillDescription" type="text" placeholder="Fatura Açıklaması" />
</div>

<div class="w3-row w3-section">
	<p>Fatura Tutarı (TL)</p>
	<input class="w3-input w3-border" name="BillAmount" type="text" placeholder="00.00" />
</div>

<div class="w3-row w3-section">
	<p>Fatura Tarihi</p>
	<?php 
	$now = new DateTime('now');
	echo '<input class="w3-input w3-border" name="BillDate" type="date" value="' . $now->format("Y-m-d") . '" />'; 
	?>
</div>

<div class="w3-row w3-section">
	<p>Dönem</p>
	<?php
    echo '<input class="w3-input w3-border" name="BillYear" type="number" placeholder="Yıl" value="' . $now->format("Y") . '" />';
	?>
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">Faturayı Ekle</button>

</form>

<?php include('tail.php'); ?>