<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TRUE - ERP</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body class="w3-light-grey">
<?php
	session_start();
	session_destroy();
	$now = new DateTime("now");
?>

<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p>Başarıyla çıkış yaptınız.<br />3 saniye içinde yönlendirileceksiniz.<br /></p></div>
<?php
	header("Refresh:3; url=index.php"); 
?>

<div class="w3-container w3-display-bottomright">
	<p class="w3-text-gray w3-opacity w3-right-align w3-animate-opacity">Anıl Doğru <?php echo $now->format('Y'); ?>&reg;</p>
</div>
</body>
</html>
