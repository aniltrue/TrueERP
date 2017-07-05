<?php include('head.php'); ?>

<?php 

if(isset($_POST["Create"])) {
	if(empty($_POST["CityName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>İl Adı kısmı boş olamaz!</p></div>';
	else {
		$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
		
		if($conn->connect_error)
     		die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
		
		$conn->query("SET NAMES 'utf8'");
		
		$name = $conn->real_escape_string(trim($_POST["CityName"]));
		
		$sql = "INSERT INTO City (CityName) VALUES ('" . $name . "')";
		$rslt = $conn->query($sql);
		$conn->close();
		
		if($rslt == true) 
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $name . '</b> ili başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.<br />Not: Aynı isimden başka bir il daha ekleyemezsiniz.</p></div>';
	}
}

?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>İl Ekle</h3>
 
<div class="w3-row w3-section">
	<p>İl Adı</p>
	<input class="w3-input w3-border" name="CityName" type="text" placeholder="İl Adı" />
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">İli Ekle</button>

</form>

<?php include('tail.php'); ?>