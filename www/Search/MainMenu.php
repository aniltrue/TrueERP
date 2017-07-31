
<?php
include('class/head.php');
include('class/SearchClass.php');
$ObjectName = "Sayfa";
$PageName = "PAGE_DEV_PAGE_SEARCH";
$SearchSQL = "SELECT * FROM Pages";
$OrderSQL = "ORDER BY PageName, PageDescription ASC";
$InputObjects = array();
$SearchObjects = array();
// Create "Input Objects" and "Search Objects"



?>

<?php include('class/Search.php'); ?>
