<?php include('head.php'); ?>

<?php

function ADD_START($Title, $AddingObjectName, $TableName) {

$Objects = array();

$rslt = $conn->query("SELECT * FROM Objects WHERE ObjectType = 2");

if(isset($_GET[$rslt["ColumnName"]]))
	$Objects[$rslt["ColumnName"]] = trim($_GET[$rslt["ColumnName"]]);
elseif(isset($_POST[$rslt["ColumnName"]])) 
	$Objects[$rslt["ColumnName"]] = trim($_POST[$rslt["ColumnName"]]);
else {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Yanlış Sayfa!</h3><br /><p>Anasayfaya dönmek için <a href="main.php" class="w3-hover-gray">BURAYA</a> tıklayınız!</p></div>';
	include('tail.php');
	exit;	
}



}
?>

