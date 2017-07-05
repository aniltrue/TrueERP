<?php include('head.php'); ?>

<?php
if(isset($_POST["Create"])) {
	if(empty($_POST["UserName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Ad kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["UserSurname"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Soyad kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["UserEmail"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>E-Posta kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["UserPhone"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Telefon kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["UserPassword1"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Parola kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["UserPassword2"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Parola Tekrar kısmı boş olamaz!</p></div>';
		
	if(!empty($_POST["UserName"]) && !empty($_POST["UserSurname"]) && !empty($_POST["UserEmail"]) && !empty($_POST["UserPhone"]) && !empty($_POST["UserPassword1"]) && !empty($_POST["UserPassword2"])) {
		$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
		
		if($conn->connect_error)
     		die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
		
		$conn->query("SET NAMES 'utf8'");
		
		$name = $conn->real_escape_string(trim($_POST["UserName"]));
		$surname = $conn->real_escape_string(trim($_POST["UserSurname"]));
		$email = $conn->real_escape_string(trim($_POST["UserEmail"]));
		$phone = $conn->real_escape_string(trim($_POST["UserPhone"]));
		$password1 = $conn->real_escape_string($_POST["UserPassword1"]);
		$password2 = $conn->real_escape_string($_POST["UserPassword2"]);
		
		if($password1 != $password2)
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Parolalar uyuşmuyor!</p></div>';
		
		else {
			$sql = "INSERT INTO User (UserName, UserSurname, UserPhone, UserEmail, StartDate, UserPassword) VALUES ('" . $name . "', '". $surname . "', '" . $phone . "', '" . $email ."', now(), '" . md5($password1) . "')";
			$rslt = $conn->query($sql);
		
			if($rslt == 0)
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.Not: Aynı e-posta adresinden başka bir kullanıcı daha ekleyemezsiniz.</p></div>';
			else 
				echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $name . ' ' . $surname . '</b> kullanıcısı başarıyla eklendi.</p></div>';
		}
		
		$conn->close();
	}
}
?>

<form action="#" method="post" class="w3-container w3-text-green">
<h3>Üye Oluştur</h3>
 
<div class="w3-row w3-section">
	<p>Ad</p>
	<input class="w3-input w3-border" name="UserName" type="text" placeholder="Ad" />
</div>

<div class="w3-row w3-section">
	<p>Soyad</p>
	<input class="w3-input w3-border" name="UserSurname" type="text" placeholder="Soyad" />
</div>

<div class="w3-row w3-section">
	<p>E-Posta</p>
	<input class="w3-input w3-border" name="UserEmail" type="email" placeholder="E-Posta" />
</div>

<div class="w3-row w3-section">
	<p>Telefon</p>
    <input class="w3-input w3-border" name="UserPhone" type="text" placeholder="Telefon" />
</div>

<div class="w3-row w3-section">
	<p>Parola</p>
	<input class="w3-input w3-border" name="UserPassword1" type="password" placeholder="Parola" />
</div>

<div class="w3-row w3-section">
	<p>Parola Tekrar</p>
	<input class="w3-input w3-border" name="UserPassword2" type="password" placeholder="Parola Tekrar" />
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">Üye Oluştur</button>

</form>

<?php include('tail.php'); ?>