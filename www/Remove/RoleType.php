<?php
$PageName = "PAGE_DEV_ROLE_TYPES_REMOVE";
include("../class/RemoveClass.php");

$References = array();
$ObjectName = "Kullanıcı Rolü";
$TableName = "UserRoleTypes";
// Create "Remove Objects"

$References[0] = new RemoveObject("RoleName", "Rol Adı");

?>

<?php include("../class/Remove.php"); ?>