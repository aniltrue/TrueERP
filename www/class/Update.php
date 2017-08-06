<?php 
// Check Roles
if(!CheckPageRoles($conn, $userInfo[2], $PageName)) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Bu Sayfaya Yetkiniz Yok!</h3><br /><p>Anasayfaya dönmek için <a href="' . $WorkPlace . 'main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}

$WhereSQL = '';
// Check Reqirements
foreach ($UpdateObjects as $UpdateObject) {
  if($UpdateObject->ObjectType != 2)
    continue;
    
  if(isset($_GET[$UpdateObject->ColumnName]) || isset($_POST[$UpdateObject->ColumnName])) {
	if(isset($_POST[$UpdateObject->ColumnName]))
		$UpdateObject->Value = $conn->real_escape_string(trim($_POST[$UpdateObject->ColumnName]));
	else
		$UpdateObject->Value = $conn->real_escape_string(trim($_GET[$UpdateObject->ColumnName]));
	
	if($SelectSQL == '')
		$WhereSQL = $UpdateObject->ColumnName . "='" . $UpdateObject->Value . "'";
	else
		$WhereSQL = $SelectSQL . ' AND ' . $UpdateObject->ColumnName . "='" . $UpdateObject->Value . "'";
		
	continue;
  }
  
  echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Yanlış Sayfa!</h3><br /><p>Anasayfaya dönmek için <a href="' . $WorkPlace . 'main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
  include('tail.php');
  exit;	
}

// Show Properties
$result = $conn->query("SELECT * FROM " . $TableName . " WHERE " . $WhereSQL);
if($result->num_rows != 1) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><p><b>' . $ObjectName . '</b> bulunamadı.</p></div>';	
	include('tail.php');
	exit;	
}

$Row = $result->fetch_assoc();
foreach ($UpdateObjects as $UpdateObject) 
	$UpdateObject->Value = $Row[$UpdateObject->ColumnName];


// Create
if(isset($_POST["Update"])) {
	$IsValid = true;
	$UpdateSQL = '';
	
	foreach ($UpdateObjects as $UpdateObject) {
		if($_POST[$UpdateObject->ColumnName] === '') {
			if($UpdateObject->IsRequired) {
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>' . $UpdateObject->ColumnText . ' girmeniz gerekiyor!</p></div>';
				$IsValid = false;
			}
		} else {
			if(!empty($UpdateSQL)) 
				$UpdateSQL = $UpdateSQL . ", ";
			
				
			$ColumnsSQL = $ColumnsSQL . $UpdateObject->ColumnName . "='" . $UpdateObject->Value . "'";
		}
	}
	
	if($IsValid) {
		$SQL = "UPDATE " . $TableName . " SET " . $UpdateSQL . " WHERE " . $WhereSQL;
		$rslt = $conn->query($SQL);
		
		if($rslt == 1)
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $ObjectName . '</b> başarıyla güncellendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';	
	}
}

// Add Form
echo '<form action="#" method="post" class="w3-container w3-text-green">
<h3>' . $ObjectName . ' Ekle</h3>';

foreach ($UpdateObjects as $UpdateObject) 
	$UpdateObject->Draw();


echo '<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create" id="CreateBtn">'. $ObjectName . ' Ekle</button>
</form>';

include('tail.php'); 

?>
