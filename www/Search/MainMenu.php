
<?php
include('class/head.php');
include('class/SearchClass.php');
$ObjectName = "Ana Menü";
$PageName = "PAGE_DEV_MAINMENU_SEARCH";
$SearchSQL = "SELECT * FROM MainMenu m left join Pages p ON m.PageName = p.PageName";
$OrderSQL = "ORDER BY MainMenuID ASC";
$InputObjects = array();
$SearchObjects = array();
// Create "Input Objects" and "Search Objects"

$InputObjects[0] = new InputObject("MainMenuID", "Ana Menü No", InputTypes::Number);
$InputObjects[1] = new InputObject("PageName", "Sayfa Adı", InputTypes::ComboBox);
$InputObjects[3]->ComboHelp = new ComboHelp($conn, "SELECT * FROM Pages ORDER BY PageDescription ASC", "PageName", "PageDescription");
$InputObjects[2] = new InputObject("MainMenuText", "Ana Menü Metni", InputTypes::Text);
$InputObjects[3] = new InputObject("MainMenuParent", "Üst Menü", InputTypes::ComboBox);
$InputObjects[3]->ComboHelp = new ComboHelp($conn, "SELECT * FROM MainMenu WHERE MainMenuParent = 0 ORDER BY MainMenuText ASC", "MainMenuID", "MainMenuText");

$SearchObjects[0] = new SearchObject("MainMenuID", "Ana Menü No", true);
$SearchObjects[1] = new SearchObject("PageName", "Sayfa Adı", true);
$SearchObjects[1] = new SearchObject("PageDescription", "Sayfa Tanımı", true);
$SearchObjects[2] = new SearchObject("MainMenuText", "Ana Menü Metni", true);
$SearchObjects[3] = new SearchObject("MainMenuParent", "Üst Menü No", true);
$SearchObjects[4] = new LinkObject("Sayfayı Görüntüle", "PAGE_DEV_PAGE_SEARCH", $conn, $userInfo[2], "PageName");
$SearchObjects[4]->AdditionalPar = 'Search=1';
$SearchObjects[4]->IsPopup = true;
$SearchObjects[5] = new LinkObject("Üst Menü Görüntüle", "PAGE_DEV_MAINMENU_SEARCH", $conn, $userInfo[2], "MainMenuParent");
$SearchObjects[5]->AdditionalPar = 'Search=1';
$SearchObjects[5]->IsPopup = true;
$SearchObjects[6] = new LinkObject("Güncelle", "PAGE_DEV_MAINMENU_UPDATE", $conn, $userInfo[2], "MainMenuID");

?>

<?php include('class/Search.php'); ?>
