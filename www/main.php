<?php include('class/head.php'); 

// Check Roles
if(!CheckPageRoles($conn, $userInfo[2], "PAGE_MAIN")) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Bu Sayfaya Yetkiniz Yok!</h3><br /><p>Anasayfaya dönmek için <a href="main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}

?>
<h3 class="w3-text-green">Ana Sayfa</h3>

<p>Sayın <?php echo $userInfo[0] . ' ' . $userInfo[1] ?>,
<br /><br />
TRUE kurumsal yazılımına hoşgeldiniz.<br />
...
<br /><br />
Bu yazılımı yukarıdaki menüden istediğiniz işlemi seçip kolayca kullanabilirsiniz.
<br /><br />
İyi Çalışmalar Dileriz...<br />
</p>

<?php include('class/tail.php'); ?> 
