<?php
include('class/head.php');
include('class/AddClass.php');
$AddObjects = array();
$TableName = "User";
$ObjectName = "Kullanıcı";
$PageName = "PAGE_HRM_USER_ADD";

$AddObjects[0] = new AddObject("UserEmail", "E-Posta Adresi", InputTypes::Email, ObjectTypes::Common);
$AddObjects[1] = new AddObject("UserName", "Kullanıcı Adı", InputTypes::Text, ObjectTypes::Common);
$AddObjects[2] = new AddObject("UserSurname", "Kullanıcı Soyadı", InputTypes::Text, ObjectTypes::Common);
$AddObjects[3] = new AddObject("UserPassword", "Parola", InputTypes::Password, ObjectTypes::Common);
$AddObjects[4] = new AddObject("UserPhone", "Telefon Numarası", InputTypes::Text, ObjectTypes::Common);
$AddObjects[5] = new AddObject("TitleName", "Ünvan", InputTypes::ComboBox, ObjectTypes::Common);
$AddObjects[5]->ComboHelp = new ComboHelp($conn, "SELECT * FROM UserTitles", "TitleName", "TitleDescription");
$AddObjects[5]->PlaceHolder = "Bir ünvan seçiniz.";

?>

<?php include("class/Add.php"); ?>
