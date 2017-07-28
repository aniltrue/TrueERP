<?php
include('class/head.php');
include('class/SearchClass.php');
$ObjectName = "Kullanıcı Rolü";
$PageName = "PAGE_DEV_ROLE_TYPES_SEARCH";
$SearchSQL = "SELECT * FROM UserRoleTypes u left join Pages p ON u.PageName = p.PageName";
$OrderSQL = "ORDER BY RoleName, RoleDescription ASC";
$InputObjects = array();
$SearchObjects = array();
// Create "Input Objects" and "Search Objects"

$InputObjects[0] = new InputObject("RoleName", "Rol Adı", InputTypes::Text);
$InputObjects[1] = new InputObject("RoleDescription", "Rol Açıklaması", InputTypes::Text);
$InputObjects[2] = new InputObject("PageName", "Sayfa Adı", InputTypes::Text);
$InputObjects[3] = new InputObject("PageDescription", "Sayfa Açıklaması", InputTypes::Text);
$InputObjects[4] = new InputObject("PageURL", "URL", InputTypes::Text);

$SearchObjects[0] = new SearchObject("RoleName", "Rol Adı", true);
$SearchObjects[1] = new SearchObject("RoleDescription", "Rol Açıklaması", true);
$SearchObjects[2] = new SearchObject("PageName", "Sayfa Adı", true);
$SearchObjects[3] = new SearchObject("PageDescription", "Sayfa Adı", true);
$SearchObjects[4] = new SearchObject("PageURL", "URL", true);
$SearchObjects[5] = new LinkObject("Günelle", "PAGE_DEV_ROLE_TYPES_UPDATE", $conn, $userInfo[2], "RoleName");
$SearchObjects[6] = new LinkObject("Bu Role Sahip Ünvanlar", "PAGE_HRM_TITLE_ROLES_SEARCH", $conn, $userInfo[2], "RoleName");
$SearchObjects[6]->AdditionalPar = "Search=1";
$SearchObjects[6]->IsPopup = true;

?>

<?php include('class/Search.php'); ?>
