<?php
// Check Roles
if(!CheckPageRoles($conn, $userInfo[2], $PageName)) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Bu Sayfaya Yetkiniz Yok!</h3><br /><p>Anasayfaya dönmek için <a href="' . $WorkPlace . 'main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}

$WhereSQL = '';
$isValid = true;
foreach($References as $Reference) {
  if(!isset($_GET[$Reference->ColumnName]) || $_GET[$Reference->ColumnName] != '') {
    echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce ' . $Reference->Text . ' seçmeniz gerekiyor.</p></div>';
	$isValid = false;
  } else {
    if(!empty($WhereSQL))
      $WhereSQL = $WhereSQL . ' AND ';
    
    $WhereSQL = $WhereSQL . $Reference->ColumnName . " = '" . $conn->real_escape_string(trim($_GET[$Reference->ColumnName])) . "'";
  }
}

if(!$isValid) {
  include('tail.php');
  exit;
}

$results = $conn->query("SELECT * FROM " . $TableName . " WHERE " . $WhereSQL);
if($results->num_rows < 1) {
  echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br /><b>' . $ObjectName . '</b> bulunamadı.</p></div>';
  include('tail.php');
  exit;
}

$result = $conn->query("DELETE FROM " . $TableName . " WHERE " . $WhereSQL);
if($result > 0) 
	echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $ObjectName . '</b> başarıyla silindi.</p></div>';
else
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
  
include('tail.php');
