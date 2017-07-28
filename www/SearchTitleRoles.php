
<?php
include('class/head.php');
include('class/SearchClass.php');
$ObjectName = "Ünvan Rolü";
$PageName = "PAGE_HRM_TITLE_ROLES_SEARCH";
$SearchSQL = "SELECT * FROM UserTitleRoles natural join (UserRoleTypes natural join Pages)";
$OrderSQL = "ORDER BY TitleName, RoleName, TitleRoleID ASC";
$InputObjects = array();
$SearchObjects = array();
// Create "Input Objects" and "Search Objects"

$InputObjects[0] = new InputObject("TitleRoleID", "ID", InputTypes::Number);
$InputObjects[1] = new InputObject("TitleName", "Ünvan", InputTypes::Combo);
$InputObjects[1]->ComboHelp = new ComboHelp($conn, "SELECT * FROM UserTitles ORDER BY TitleName ASC", "TitleName", "TitleName");
$InputObjects[2] = new InputObject("TitleDescription", "Ünvan Açıklaması", InputTypes::Text);
$InputObjects[3] = new InputObject("RoleName", "Rol", InputTypes::ComboBox);
$InputObjects[3]->ComboHelp = new ComboHelp($conn, "SELECT * FROM UserRoleTypes ORDER BY RoleName ASC", "RoleName", "RoleName");
$InputObjects[4] = new InputObject("RoleDescription", "Rol Açıklaması", InputTypes::Text);
$InputObjects[5] = new InputObject("PageName", "Sayfa", InputTypes::ComboBox);
$InputObjects[5]->ComboHelp = new ComboHelp($conn, "SELECT * FROM UserRoleTypes ORDER BY PageName ASC", "PageName", "PageName");
$InputObjects[6] = new InputObject("PageDescription", "Sayfa Açıklaması", InputTypes::Text);

$SearchObjects[0] = new SearchObject("TitleRoleID", "No", true);
$SearchObjects[1] = new SearchObject("TitleName", "Ünvan Adı", true);
$SearchObjects[2] = new SearchObject("TitleDescription", "Ünvan Açıklaması", true);
$SearchObjects[3] = new SearchObject("RoleName", "Rol Adı", true);
$SearchObjects[4] = new SearchObject("RoleDescription", "Rol Açıklaması", true);
$SearchObjects[5] = new SearchObject("PageName", "Sayfa Adı", true);
$SearchObjects[6] = new SearchObject("PageDescription", "Sayfa Açıklaması", true);
$SearchObjects[7] = new LinkObject("Güncelle", "PAGE_HRM_TITLE_ROLES_UPDATE", $conn, $userInfo[2], "TitleRoleID");

?>

<?php include('class/Search.php'); ?>
