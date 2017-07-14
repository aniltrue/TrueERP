<?php
include('class/head.php');
include('class/SearchClass.php');
$ObjectName = "Kullanıcı";
$PageName = "PAGE_HRM_USER_SEARCH";
$SearchSQL = "SELECT * FROM User natural join UserTitles ORDER BY UserName, UserSurname ASC";
$SpecialSQL = "";
$TableHeaders = array();
$SearchObjects = array();
// Create "Table Headers" and "Search Objects"

$TableHeaders[0] = new TableHeader("E-Posta", true);
$TableHeaders[1] = new TableHeader("Ad", true);
$TableHeaders[2] = new TableHeader("Soyad", true);
$TableHeaders[3] = new TableHeader("Ünvan", true);
$TableHeaders[4] = new TableHeader("Telefon", true);
$TableHeaders[5] = new TableHeader("Güncelle", false);
$TableHeaders[6] = new TableHeader("Sil", false);

$SearchObjects[0] = new SearchObject("UserEmail", true);
$SearchObjects[1] = new SearchObject("UserName", true);
$SearchObjects[2] = new SearchObject("UserSurname", true);
$SearchObjects[3] = new SearchObject("TitleDescription", true);
$SearchObjects[4] = new SearchObject("UserPhone", true);
$SearchObjects[5] = new LinkObject("PAGE_HRM_USER_UPDATE", $conn, $userInfo[2], "UserEmail");
$SearchObjects[6] = new LinkObject("PAGE_HRM_USER_PASSWORD_RESET", $conn, $userInfo[2], "UserEmail");
$SearchObjects[7] = new LinkObject("PAGE_HRM_USER_REMOVE", $conn, $userInfo[2], "UserEmail");

?>

<?php include('class/Search.php');
