
<?php
include('class/head.php');
include('class/AddClass.php');
$AddObjects = array();
$TableName = "MainMenu";
$ObjectName = "Ana menü";
$PageName = "PAGE_DEV_MAINMENU_ADD";
// Create "Add Objects"

$AddObjects[0] = new AddObject("PageName", "Sayfa Adı", InputTypes::ComboBox, ObjectTypes::Common);
$AddObjects[0]->IsRequired = false;
$AddObjects[0]->ComboHelp = new ComboHelp($conn, "SELECT * FROM Pages", "PageName", "PageDescription");
$AddObjects[0]->PlaceHolder = "Bir sayfa seçiniz.";
$AddObjects[1] = new AddObject("MainMenuText", "Ana menü metni", InputTypes::Text, ObjectTypes::Common);
$AddObjects[1]->IsRequired = false;
$AddObjects[2] = new AddObject("MainMenuParent", "Ana menü ailesi", InputTypes::ComboBox, ObjectTypes::Common);
$AddObjects[2]->IsRequired = false;
$AddObjects[2]->ComboHelp = new ComboHelp($conn, "SELECT * FROM MainMenu", "MainMenuID", "MainMenuText");
$AddObjects[2]->PlaceHolder = "Bir ana sayfa seçiniz.";

?>

<?php include("class/Add.php"); ?>
