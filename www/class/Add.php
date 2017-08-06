<?php 
// Check Roles
if(!CheckPageRoles($conn, $userInfo[2], $PageName)) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Bu Sayfaya Yetkiniz Yok!</h3><br /><p>Anasayfaya dönmek için <a href="' . $WorkPlace . 'main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}

// Check Reqirements
foreach ($AddObjects as $AddObject) {
  if($AddObject->ObjectType != 2)
    continue;
    
  if(isset($_GET[$AddObject->ColumnName]) || isset($_POST[$AddObject->ColumnName])) 
	continue;
  
  echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Yanlış Sayfa!</h3><br /><p>Anasayfaya dönmek için <a href="' . $WorkPlace . 'main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
  include('tail.php');
  exit;	
}

// Create
if(isset($_POST["Create"])) {
	$IsValid = true;
	$ColumnsSQL = "";
	$ValuesSQL = "";
	
	foreach ($AddObjects as $AddObject) {
		if($_POST[$AddObject->ColumnName] === '') {
			if($AddObject->IsRequired) {
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>' . $AddObject->ColumnText . ' girmeniz gerekiyor!</p></div>';
				$IsValid = false;
			}
		} else {
			if(!empty($ColumnsSQL)) {
				$ColumnsSQL = $ColumnsSQL . ", ";
				$ValuesSQL = $ValuesSQL . ", ";
			}
				
			$ColumnsSQL = $ColumnsSQL . $AddObject->ColumnName;
			if($AddObject->InputType != "password")
				$ValuesSQL = $ValuesSQL . "'" . $conn->real_escape_string(trim($_POST[$AddObject->ColumnName])) . "'";
			else
				$ValuesSQL = $ValuesSQL . "'" . md5($conn->real_escape_string(trim($_POST[$AddObject->ColumnName]))) . "'";
		}
	}
	
	if($IsValid) {
		$SQL = "INSERT INTO " . $TableName . " (" . $ColumnsSQL . ") VALUES (" . $ValuesSQL . ");";
		$rslt = $conn->query($SQL);
		
		if($rslt == true)
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $ObjectName . '</b> başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';	
	}
}

// Add Form
echo '<form action="#" method="post" class="w3-container w3-text-green">
<h3>' . $ObjectName . ' Ekle</h3>';

foreach ($AddObjects as $AddObject) 
	$AddObject->Draw();


echo '<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create" id="CreateBtn">'. $ObjectName . ' Ekle</button>
</form>';

include('tail.php'); 

?>
