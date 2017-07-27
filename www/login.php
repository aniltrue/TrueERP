<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TRUE - ERP</title>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body class="w3-light-grey">

<?php
	$now = new DateTime("now");
	session_start();
	
	session_destroy();
	session_start();
	if(isset($_POST["UserEmail"]) && !empty($_POST["UserEmail"]) && isset($_POST["UserPassword"]) && !empty($_POST["UserPassword"])) {
		$conn = new mysqli("localhost:3306", "root", "", "TrueERP");	
		
		$userEmail  = $conn->real_escape_string($_POST["UserEmail"]);
  		$userPassword = $conn->real_escape_string($_POST["UserPassword"]);

		if($conn->connect_error)
			die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
    	
		$conn->query("SET NAMES 'utf8'");
	
		$pswrd = md5($userPassword);
	
		$sql = "SELECT * FROM User WHERE UserEmail = '" . $userEmail . "'";
		$rslt = $conn->query($sql);
		$conn->close();
	
		if ($rslt->num_rows > 0) { 
			$rw = $rslt->fetch_assoc();
			if ($rw["UserPassword"] == $pswrd) {
				if($rw["UserEnable"] == 1) {
					$_SESSION["email"] = $userEmail;
					$_SESSION["user"] = md5($pswrd . "_dg");
					echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p>Üye girişi başarılı!<br />Hoş geldiniz, ' . $rw["UserName"] . ' ' . $rw["UserSurname"] . '<br />3 saniye içinde yönlendirileceksiniz.<br /></p></div>';
					header("Refresh:3; url=main.php"); 
					exit;
				} else {
					echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Kullanıcı bloke edilmiştir.</ br>2 saniye içinde geri yönlendirileceksiniz.</p></div>';
					header("Refresh:2; url=index.php");
				}
			} else {
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Girdiğiniz parola yanlış.</ br>2 saniye içinde geri yönlendirileceksiniz.</p></div>';
				header("Refresh:2; url=index.php");
			}
		} else {
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Girdiğiniz e-posta adresi bulunamadı.</ br>2 saniye içinde geri yönlendirileceksiniz.</p></div>';
			header("Refresh:2; url=index.php");
		}
	} else {
		die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Yanlış adres.<br />1 saniye içinde yönlendirileceksiniz.</p></div>');
		header("Refresh:1; url=index.php");
	}
?>

<div class="w3-container w3-bottom">
	<p class="w3-text-gray w3-right w3-animate-opacity">Anıl Doğru <?php echo $now->format('Y'); ?>&reg;</p>
</div>

</body>
</html>
