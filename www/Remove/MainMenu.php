<?php
$PageName = "PAGE_DEV_MAINMENU_REMOVE";
include("../class/RemoveClass.php");

$References = array();
$ObjectName = "Ana Menü";
$TableName = "MainMenu";
// Create "Remove Objects"

$References[0] = new RemoveObject("MainMenuID", "Ana Menü No");

?>

<?php include("../class/Remove.php"); ?>