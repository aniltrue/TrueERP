<?php
$PageName = "PAGE_DEV_PAGE_REMOVE";
include("../class/RemoveClass.php");

$References = array();
$ObjectName = "Sayfa";
$TableName = "Pages";
// Create "Remove Objects"

$References[0] = new RemoveObject("PageName", "Sayfa Adı");

?>

<?php include("../class/Remove.php"); ?>