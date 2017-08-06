<?php
$PageName = "PAGE_HRM_TITLE_ROLES_REMOVE";
include("../class/RemoveClass.php");

$References = array();
$ObjectName = "Ünvan Rolü";
$TableName = "UserTitleRoles";
// Create "Remove Objects"

$References[0] = new RemoveObject("TitleRoleID", "ID");

?>

<?php include("../class/Remove.php"); ?>