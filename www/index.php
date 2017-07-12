<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TRUE - ERP</title>

<?php
$now = new DateTime("now");

?>

</head>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<body class="w3-light-grey">

<div class="w3-card-4 w3-display-middle w3-animate-opacity">
	<div class="w3-container w3-teal">
  		<h2>Üye Girişi</h2>
	</div>

	<form class="w3-container w3-padding-16 w3-border" method="post" action="login.php">
    	<div class="w3-panel">
  			<label class="w3-text-teal"><b>E-Posta</b></label>
  			<input class="w3-input w3-border w3-light-grey w3-text-light-green" type="email" name="UserEmail">
        </div>

		<div class="w3-panel">
  			<label class="w3-text-teal"><b>Parola</b></label>
  			<input class="w3-input w3-border w3-light-grey w3-text-light-green" type="password" name="UserPassword">
        </div>

		<div class="w3-panel">
  			<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Giriş</button>
        </div>
	</form>
</div>

<div class="w3-container w3-bottom">
	<p class="w3-text-gray w3-right w3-animate-opacity">Anıl Doğru <?php echo $now->format('Y'); ?>&reg;</p>
</div>

</body>
</html>