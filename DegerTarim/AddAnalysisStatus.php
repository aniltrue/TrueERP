<?php include('head.php'); ?>

<?php 

if(isset($_POST["Create"])) {
	if(empty($_POST["AnalysisStatusDescription"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Analiz Durum Açıklaması kısmı boş olamaz!</p></div>';
	else {
		$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
		
		if($conn->connect_error)
     		die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
		
		$conn->query("SET NAMES 'utf8'");
		
		$name = $conn->real_escape_string(trim($_POST["AnalysisStatusDescription"]));
		
		$sql = "INSERT INTO AnalysisStatus (AnalysisStatusDescription) VALUES ('" . $name . "')";
		$rslt = $conn->query($sql);
		$conn->close();
		
		if($rslt == true) 
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $name . '</b> analiz durumu başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>Analiz Durumu Ekle</h3>
 
<div class="w3-row w3-section">
	<p>Analiz Durumu Açıklaması</p>
	<input class="w3-input w3-border" name="AnalysisStatusDescription" type="text" placeholder="Analiz durumu açıklaması" />
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">Analiz Durumunu Ekle</button>

</form>

<?php include('tail.php'); ?>