<?php
$PageName = "PAGE_HRM_TITLE_ROLES_ADD";
include('../class/AddClass.php');
$AddObjects = array();
$TableName = "UserTitleRoles";
$ObjectName = "Ünvan rolü";
// Create "Add Objects"

$AddObjects[0] = new AddObject("TitleName", "Ünvan Adı", InputTypes::Text, ObjectTypes::Required);
$AddObjects[1] = new AddObject("RoleName", "Rol Adı", InputTypes::ComboBox, ObjectTypes::Common);
$AddObjects[1]->ComboHelp = new ComboHelp($conn, "SELECT * FROM UserRoleTypes", "RoleName", "RoleDescription");
$AddObjects[1]->PlaceHolder = "Bir rol seçiniz.";

?>

<?php include("../class/Add.php"); ?>
