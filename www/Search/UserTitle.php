<?php
include('class/head.php');
include('class/SearchClass.php');
$ObjectName = "Ünvan";
$PageName = "PAGE_HRM_USER_TITLES_SEARCH";
$SearchSQL = "SELECT * FROM UserTitles";
$OrderSQL = "ORDER BY TitleName, TitleDescription ASC";
$InputObjects = array();
$SearchObjects = array();
// Create "Input Objects" and "Search Objects"

$InputObjects[0] = new InputObject("TitleName", "Ünvan Adı", InputTypes::Text);
$InputObjects[1] = new InputObject("TitleDescription", "Ünvan Açıklaması", InputTypes::Text);

$SearchObjects[0] = new SearchObject("TitleName", "Ünvan Adı", true);
$SearchObjects[1] = new SearchObject("TitleDescription", "Ünvan Açıklaması", true);
$SearchObjects[2] = new LinkObject("Rolleri Görüntüle", "PAGE_HRM_TITLE_ROLES_SEARCH", $conn, $userInfo[2], "TitleName");
$SearchObjects[2]->AdditionalPar = "Search=1";
$SearchObjects[2]->IsPopup = true;
$SearchObjects[3] = new LinkObject("Rol Ekle", "PAGE_HRM_TITLE_ROLES_ADD", $conn, $userInfo[2], "TitleName");
$SearchObjects[4] = new LinkObject("Güncelle", "PAGE_HRM_USER_TITLES_UPDATE", $conn, $userInfo[2], "TitleName");

?>

<?php include('class/Search.php'); ?>
