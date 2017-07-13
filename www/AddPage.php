<?php
include('class/head.php');
include('class/AddClass.php');
$AddObjects = array();
$TableName = "";
$ObjectName = "";
$PageName = "";
// Create "Add Objects"

$AddObjects[0] = new AddObject("PageName", "Sayfa Adı", InputTypes::Text, ObjectTypes::Common);
$AddObjects[1] = new AddObject("PageURL", "Sayfa Adresi", InputTypes::Text, ObjectTypes::Common);
$AddObjects[1]->PlaceHolder = "page.php";
$AddObjects[2] = new AddObject("PageDescription", "Sayfa Açıklaması", InputTypes::Text, ObjectTypes::Common);
$AddObjects[3] = new AddObject("PageEnable", "Sayfa Onayı", InputTypes::CheckBox, ObjectTypes::Common);
$AddObjects[3]->PlaceHolder = "true";

?>

<?php include("class/Add.php"); ?>
