<?php include('head.php'); ?>

<?php
if(isset($_POST["Save"])) {
	if(empty($_POST["UserName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Ad kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["UserSurname"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Soyad kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["UserPhone"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Telefon kısmı boş olamaz!</p></div>';
		
	if(!empty($_POST["UserName"]) && !empty($_POST["UserSurname"]) && !empty($_POST["UserPhone"])) {
		$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
		
		if($conn->connect_error)
     		die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
		
		$conn->query("SET NAMES 'utf8'");
		
		$name = $conn->real_escape_string(trim($_POST["UserName"]));
		$surname = $conn->real_escape_string(trim($_POST["UserSurname"]));
		$phone = $conn->real_escape_string(trim($_POST["UserPhone"]));
		
		$sql = "UPDATE User SET UserName = '" . $name . "', UserSurname = '". $surname . "', UserPhone = '" . $phone . "' WHERE UserEmail = '" . $_SESSION["email"] ."'";
		$rslt = $conn->query($sql);
		$conn->close();
		
		if($rslt == 0)
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
		else {
			$userInfo = array($name, $surname, $phone, $userInfo[3]);	
			
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p>Üyelik başarıyla güncellendi.</p></div>';
		}
	}
}
?>

<form action="#" method="post" class="w3-container w3-text-green">
<h3>Profil</h3>
 
<div class="w3-row w3-section">
	<p>Ad</p>
	<?php echo '<input class="w3-input w3-border" name="UserName" type="text" placeholder="Ad" value=' . $userInfo[0] . '>'; ?>
</div>

<div class="w3-row w3-section">
	<p>Soyad</p>
	<?php echo '<input class="w3-input w3-border" name="UserSurname" type="text" placeholder="Soyad" value=' . $userInfo[1] . '>'; ?>
</div>

<div class="w3-row w3-section">
	<p>E-Posta</p>
	<?php echo '<input class="w3-input w3-border" type="email" placeholder="E-Posta" disabled value=' . $_SESSION["email"] . '>'; ?>
</div>

<div class="w3-row w3-section">
	<p>Telefon</p>
    <?php echo '<input class="w3-input w3-border" name="UserPhone" type="text" placeholder="Telefon" value=' . $userInfo[2] . '>'; ?>
</div>

<div class="w3-row w3-section">
	<p>Başlangıç Tarihi</p>
	<?php echo '<input class="w3-input w3-border" type="date" placeholder="Message" disabled value=' . $userInfo[3] . '>'; ?>
</div>

<a href="ChangePassword.php" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin">Şifreyi Değiştir</a>
<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Save">Değişiklikleri Kaydet</button>

</form>

<?php include('tail.php'); ?>