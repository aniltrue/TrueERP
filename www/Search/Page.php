<?php
include('class/head.php');
include('class/SearchClass.php');
$ObjectName = "";
$PageName = "";
$SearchSQL = "";
$OrderSQL = "";
$InputObjects = array();
$SearchObjects = array();
// Create "Input Objects" and "Search Objects"

$InputObjects[0] = new InputObject("PageName", "Sayfa Adı", InputTypes::Text);
$InputObjects[1] = new InputObject("PageDescription", "Sayfa Tanımı", InputTypes::Text);
$InputObjects[2] = new InputObject("PageURL", "URL", InputTypes::Text);
$InputObjects[3] = new InputObject("PageEnable", "Aktif", InputTypes::CheckBox);
$InputObjects[3]->Value = 1;

$SearchObjects[0] = new SearchObject("PageName", "Sayfa Adı", true);
$SearchObjects[1] = new SearchObject("PageDescription", "Sayfa Tanımı", true);
$SearchObjects[2] = new SearchObject("PageURL", "URL", true);
$SearchObjects[3] = new SearchObject("PageEnable", "Aktif", true);
$SearchObjects[4] = new LinkObject("Rolleri Bul", "PAGE_DEV_ROLE_TYPES_SEARCH", $conn, $userInfo[2], "PageName");
$SearchObjects[5] = new LinkObject("Güncelle", "PAGE_DEV_PAGE_UPDATE", $conn, $userInfo[2], "PageName");

?>

<?php include('class/Search.php'); ?>
