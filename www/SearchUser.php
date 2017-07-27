<?php
include('class/head.php');
include('class/SearchClass.php');
$ObjectName = "Kullanıcı";
$PageName = "PAGE_HRM_USER_SEARCH";
$SearchSQL = "SELECT * FROM User natural join UserTitles";
$OrderSQL = "ORDER BY UserName, UserSurname ASC";
$InputObjects = array();
$SearchObjects = array();
// Create "Input Objects" and "Search Objects"

$InputObjects[0] = new InputObject("UserEmail", "E-Posta", InputTypes::Email);
$InputObjects[1] = new InputObject("UserName", "Ad", InputTypes::Text);
$InputObjects[2] = new InputObject("UserSurname", "Soyad", InputTypes::Text);
$InputObjects[3] = new InputObject("TitleName", "Ünvan", InputTypes::ComboBox);
$InputObjects[3]->ComboHelp = new ComboHelp($conn, "SELECT * FROM UserTitles ORDER BY TitleDescription ASC", "TitleName", "TitleDescription");
$InputObjects[4] = new InputObject("UserPhone", "Telefon", InputTypes::Text);

$SearchObjects[0] = new SearchObject("UserEmail", "E-Posta", true);
$SearchObjects[1] = new SearchObject("UserName", "Ad", true);
$SearchObjects[2] = new SearchObject("UserSurname", "Soyad", true);
$SearchObjects[3] = new SearchObject("TitleDescription", "Ünvan", true);
$SearchObjects[4] = new SearchObject("UserPhone", "Telefon", true);
$SearchObjects[5] = new LinkObject("Güncelle", "PAGE_HRM_USER_UPDATE", $conn, $userInfo[2], "UserEmail");
$SearchObjects[6] = new LinkObject("Parola Değiştir", "PAGE_HRM_USER_PASSWORD_RESET", $conn, $userInfo[2], "UserEmail");
$SearchObjects[7] = new LinkObject("Sil", "PAGE_HRM_USER_REMOVE", $conn, $userInfo[2], "UserEmail");

?>

<?php include('class/Search.php'); ?>
