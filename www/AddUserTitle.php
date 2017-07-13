<?php
include('class/head.php');
include('class/AddClass.php');
$AddObjects = array();
$TableName = "UserTitles";
$ObjectName = "Ünvan";
$PageName = "PAGE_HRM_USER_TITLES_ADD";
// Create "Add Objects"

$AddObjects[0] = new AddObject("TitleName", "Ünvan Adı", InputTypes::Text, ObjectTypes::Common);
$AddObjects[1] = new AddObject("TitleDescription", "Ünvan Açıklaması", InputTypes::Text, ObjectTypes::Common);

?>

<?php include("class/Add.php"); ?>
