<?php
$PageName = "PAGE_HRM_USER_TITLES_REMOVE";
include("../class/RemoveClass.php");

$References = array();
$ObjectName = "Ünvan";
$TableName = "UserTitles";
// Create "Remove Objects"

$References[0] = new RemoveObject("TitleName", "Ünvan Adı");

?>

<?php include("../class/Remove.php"); ?>