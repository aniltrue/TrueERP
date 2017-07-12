<?php 
include('head.php'); 
include('class/AddClass.php');
?>

<?php
$AddObjects = array();
$TableName = "";
$ObjectName = "";
// Create "Add Objects"



?>

<?

// Check Requires
foreach($AddObject as $AddObjects) {
  if($AddObject->$ObjectType != 2)
    continue;
    
  if(isset($_GET[$AddObject->$ColumnName]) || isset($_POST[$AddObject->$ColumnName]))
		continue;
	
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Yanlış Sayfa!</h3><br /><p>Anasayfaya dönmek için <a href="main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;	
}

// Create Object
if($isset($_POST["Create"])) {
	$IsValid = true;
	$ColumnsSQL = "";
	$ValuesSQL = "";
	
	foreach($AddObject as $AddObjects) {
		if($empty($_POST[$AddObject->$ColumnName]) && $AddObject->$IsRequired == false) {
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>' . $AddObject->$ColumnText . ' girmeniz gerekiyor!</p></div>';
			$IsValid = false;
		} else {
			if(!empty($ColumnsSQL)) {
				$ColumnsSQL = $ColumnsSQL . ", ";
				$ValuesSQL = $ValuesSQL . ", ";
			}
				
			$ColumnsSQL = $ColumnsSQL . $AddObject->$ColumnName;
			$ValuesSQL = $ValuesSQL . "'" . $conn->real_escape_string(trim($_POST[$AddObject->$ColumnName])) . "'";
		}
	}
	
	if($IsValid) {
		$SQL = "INSERT INTO " . $TableName . " (" . $ColumnsSQL . ") VALUES (" . $ValuesSQL . ");";
		$rslt = $conn->query($SQL);
		
		if($rslt == true)
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' $ObjectName '</b> başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';	
	}
}

// Draw
echo '<form action="#" method="post" class="w3-container w3-text-green">
<h3>' . $ObjectName . ' Ekle</h3>';

foreach($AddObject as $AddObjects) 
	$AddObject->Draw();


echo '<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">'. $ObjectName . ' Ekle</button>
</form>';
?>

<?php include('tail.php'); ?>
