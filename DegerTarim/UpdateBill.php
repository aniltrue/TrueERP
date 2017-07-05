<?php include('head.php'); ?>

<?php

if(isset($_GET["BillID"]))
	$BillID = trim($_GET["BillID"]);
elseif(isset($_POST["BillID"])) 
	$BillID = trim($_POST["BillID"]);
else {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Fatura seçmeniz gerekiyor.</p></div>';
	include('tail.php');
	exit;	
}

$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");

$rslt = $conn->query("SELECT * FROM Bill WHERE BillID=" . $BillID);
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Fatura bulunamadı.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}
$Bill = $rslt->fetch_assoc();

if(isset($_POST["Save"])) {
	if(empty($_POST["BillAmount"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Fatura Tutarı kısmı boş olamaz!</p></div>';	
		
	if(empty($_POST["BillDescription"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Fatura Açıklaması kısmı boş olamaz!</p></div>';	
	
	if(empty($_POST["BillDate"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Tarih seçmeniz gerekiyor!</p></div>';
		
	if(empty($_POST["BillYear"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>BillYear kısmı boş olamaz!</p></div>';	
		
	if(!empty($_POST["BillAmount"]) && !empty($_POST["BillDescription"]) && !empty($_POST["BillDate"]) && !empty($_POST["BillYear"])) {
		$description = $conn->real_escape_string(trim($_POST["BillDescription"]));
		$amount = trim($_POST["BillAmount"]);
		$date = $conn->real_escape_string(trim($_POST["BillDate"]));
		$year = $conn->real_escape_string(trim($_POST["BillYear"]));
		
		$sql = "UPDATE Bill SET BillAmount = " . $amount . ", BillDescription = '" . $description . "', BillDate = '" . $date . "', BillYear = '" . $year . "' WHERE BillID = " . $BillID;
		$rslt = $conn->query($sql);
		
		if($rslt == 1) {
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $BillID . '</b> nolu fatura başarıyla güncellendi.</p></div>';
			$rslt = $conn->query("SELECT * FROM Bill WHERE BillID=" . $BillID);
			if($rslt->num_rows == 0) {
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Fatura bulunamadı.</p></div>';
				$conn->close();
				include('tail.php');
				exit;
			}
			$Bill = $rslt->fetch_assoc();
		}
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();

?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>Faturayı Güncelle</h3>
 
<div class="w3-row w3-section">
	<p>Fatura No</p>
	<?php echo '<input class="w3-input w3-border" name="BillID" type="text" value="' . $BillID . '" disabled />'; ?>
</div> 
 
<div class="w3-row w3-section">
	<p>Fatura Açıklaması</p>
	<?php echo '<input class="w3-input w3-border" name="BillDescription" type="text" value="' . $Bill["BillDescription"] . '" placeholder="Fatura Açıklaması" />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Fatura Tutarı (TL)</p>
	<?php echo '<input class="w3-input w3-border" name="BillAmount" type="text" value="' . $Bill["BillAmount"] . '" placeholder="00.00" />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Fatura Tarihi</p>
	<?php echo '<input class="w3-input w3-border" name="BillDate" type="date" value="' . $Bill["BillDate"] . '" />'; ?> 
</div>

<div class="w3-row w3-section">
	<p>Dönem</p>
    <?php echo '<input class="w3-input w3-border" name="BillYear" type="number" placeholder="Yıl" value="' . $Bill["BillYear"] . '" />'; ?>
</div>

<span onclick="document.getElementById('RemoveBill').style.display='block'" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin" >Faturayı Sil</span>

<div id="RemoveBill" class="w3-modal">
   <div class="w3-modal-content w3-card-4 w3-border w3-border-green">
     <div class="w3-container w3-light-gray">
	   <h3 class="w3-text-red w3-border-bottom">Dikkat!</h3>
       <span onclick="document.getElementById('RemoveBill').style.display='none'" class="w3-button w3-display-topright">&times;</span>
       <p>Faturayı silmek istediğinizden emin misiniz?<br />Sildiğiniz takdirde bu faturaya bağlı bütün veriler tamamen silinecektir.</p>
       <?php echo '<a href="RemoveBill.php?BillID=' . $BillID . '" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin">Sil</a>' ?>
       <span onclick="document.getElementById('RemoveBill').style.display='none'" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">İptal</span>
    </div>
  </div>
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Save">Faturayı Güncelle</button>

</form>

<?php include('tail.php'); ?>