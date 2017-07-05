<?php include('head.php'); ?>

<?php
if(isset($_POST["Save"])) {
	if(empty($_POST["UserPassword1"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Şimdiki Parola kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["UserPassword2"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Yeni Parola kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["UserPassword3"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Yeni Parola Tekrar kısmı boş olamaz!</p></div>';

	if(!empty($_POST["UserPassword1"]) && !empty($_POST["UserPassword2"]) && !empty($_POST["UserPassword3"])) {
		$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
		
		if($conn->connect_error)
     		die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
		
		$conn->query("SET NAMES 'utf8'");
		
		$password1 = md5(md5($conn->real_escape_string($_POST["UserPassword1"])) . "_dg");
		$password2 = $conn->real_escape_string($_POST["UserPassword2"]);
		$password3 = $conn->real_escape_string($_POST["UserPassword3"]);	

		if($password1 == $_SESSION["user"]) {
			if($password2 == $password3) {
				$sql = "UPDATE User SET UserPassword = '". md5($password2) . "' WHERE UserEmail = '" . $_SESSION["email"] . "'";
				$rslt = $conn->query($sql);
				
				if($rslt == true) {
					$_SESSION["user"] = md5(md5($password2) . "_dg");
					
					echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p>Parola başarıyla güncellendi.</p></div>';
					
				} else 
					echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
			} else 
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Parolalar uyuşmuyor.</p></div>';
		} else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Şimdiki Parolayı yanlış girdin.</p></div>';
			
		$conn->close();
	}
}
?>

<form action="#" method="post" class="w3-container w3-text-green">
<h3>Şifre Değiştir</h3>

<div class="w3-row w3-section">
	<p>Şimdiki Parola</p>
	<input class="w3-input w3-border" name="UserPassword1" type="password" placeholder="Eski Parola" />
</div>

<div class="w3-row w3-section">
	<p>Yeni Parola</p>
	<input class="w3-input w3-border" name="UserPassword2" type="password" placeholder="Yeni Parola" />
</div>

<div class="w3-row w3-section">
	<p>Yeni Parola Tekrar</p>
	<input class="w3-input w3-border" name="UserPassword3" type="password" placeholder="Parola Tekrar" />
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Save">Parola Değiştir</button>

</form>

<?php include('tail.php'); ?>