<?php
$PageName = "PAGE_DEV_ROLE_TYPES_ADD";
include('../class/AddClass.php');
$AddObjects = array();
$TableName = "UserRoleTypes";
$ObjectName = "Rol Türü";
// Create "Add Objects"

$AddObjects[0] = new AddObject("RoleName", "Rol Adı", InputTypes::Text, ObjectTypes::Common);
$AddObjects[0]->PlaceHolder = "ROLE_DESCRIPTION_OPERATION";
$AddObjects[1] = new AddObject("PageName", "Sayfa Adı", InputTypes::ComboBox, ObjectTypes::Common);
$AddObjects[1]->ComboHelp = new ComboHelp($conn, "SELECT * FROM Pages", "PageName", "PageDescription");
$AddObjects[1]->IsRequired = false;
$AddObjects[1]->PlaceHolder = "Bir sayfa seçiniz.";
$AddObjects[2] = new AddObject("RoleDescription", "Rol Açıklaması", InputTypes::Text, ObjectTypes::Common);

?>

<?php include("../class/Add.php"); ?>
