<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="https://code.jquery.com/jquery-1.7.min.js"></script>

<?php
// Functions
	
function CheckPageRoles($conn, $UserTitle, $PageName) {
 if(!isset($PageName) || empty($PageName))
 	return false;

 $Roles = $conn->query("SELECT * FROM UserRoleTypes WHERE PageName = '" . $PageName . "'");
 if($Roles->num_rows == 0)
	 return true;
	
 $Roles = $conn->query("SELECT * FROM UserTitleRoles natural join UserRoleTypes WHERE TitleName = '" . $UserTitle . "' AND (PageName = '" . $PageName . "' OR RoleName = 'ROLE_ALL')");
 return $Roles->num_rows > 0;
}
	
function CheckRoles($conn, $UserTitle, $RoleName) {
 $Roles = $conn->query("SELECT * FROM UserTitleRoles WHERE TitleName = '" . $UserTitle . "' AND (RoleName = '" . $RoleName ."' OR RoleName = 'ROLE_ALL')");
 return $Roles->num_rows > 0;
}
	
function DisplayError($title, $text) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>' . $title . '</h3><br /><p>' . $text . '</p></div>';
}
?>
	
<?php
// Create Constants
$conn = new mysqli("localhost:3306", "root", "", "TrueERP");	
if($conn->connect_error){
     die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
}
$conn->query("SET NAMES 'utf8'");
$now = new DateTime('now');
$WorkPlace = 'http://localhost/TrueERP/';

?>

<title>TRUE - ERP</title>
</head>

<body class="w3-light-grey">

<?php
// Check Login
session_start();
if(!isset($_SESSION["user"]) || !isset($_SESSION["email"])) {<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üye girişi yapmak için <a href="' . $WorkPlace . 'index.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>'
	session_destroy();
	echo ';
	include('tail.php');
	exit;
}
$UserEmail = $conn->real_escape_string($_SESSION["email"]);
$sql = "SELECT * FROM User WHERE UserEmail = '" . $UserEmail . "' AND UserEnable = 1";
$result = $conn->query($sql);
if($result->num_rows <= 0) {
	session_destroy();
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üye girişi yapmak için <a href="' . $WorkPlace . 'index.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}
	
$User = $result->fetch_assoc();
$Password = md5($User["UserPassword"] . "_dg");
if($Password != $_SESSION["user"] || !$User["UserEnable"]) {
	session_destroy();
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üye girişi yapmak için <a href="' . $WorkPlace . 'index.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}
$userInfo = array($User["UserName"], $User["UserSurname"], $User["TitleName"], $User["UserPhone"], $User["UserEnable"]);

?>

<div class="w3-container w3-border-bottom w3-border-lime w3-teal">
	<h2>TRUE ERP</h2>
    <p>Hoş Geldiniz, <?php echo $userInfo[0] . ' ' . $userInfo[1] ?>.</p>
</div>

<div class="w3-container w3-green w3-border w3-border-teal w3-margin">
	<div class="w3-bar w3-border-teal">
    <?php
	
	$mainmenus = $conn->query("SELECT * FROM MainMenu left join Pages ON MainMenu.PageName = Pages.PageName WHERE MainMenuParent = 0");
	while($mainmenu = $mainmenus->fetch_assoc()) {
		if(!empty($mainmenu["PageURL"]) && CheckPageRoles($conn, $userInfo[2], $mainmenu["PageName"]))
			echo '<a href="' . $WorkPlace . $mainmenu["PageURL"] . '" class="w3-bar-item w3-button w3-animate-right">' . $mainmenu["PageDescription"] . '</a>';	
		else {
			echo '<div class="w3-dropdown-hover">
			<button class="w3-button w3-animate-right">' . $mainmenu["MainMenuText"] . '</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-4">';
			
			$childmenus = $conn->query("SELECT * FROM MainMenu natural join Pages WHERE MainMenuParent = " . $mainmenu["MainMenuID"]);
			while($childmenu = $childmenus->fetch_assoc()) {
				if(CheckPageRoles($conn, $userInfo[2], $childmenu["PageName"]))
					echo '<a href="' . $WorkPlace . $childmenu["PageURL"] . '" class="w3-bar-item w3-button">' . $childmenu["PageDescription"] . '</a>';
			}
			
			echo '</div>
			</div>';
		}
	}
	
	?>
    
    <a href="logout.php" class="w3-bar-item w3-button w3-right w3-animate-right">Çıkış</a>
    </div>
    
    <div class="w3-panel w3-border w3-border-teal w3-white w3-card-4">
<?php
// Check Roles
if(!isset($PageName) || empty($PageName)) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Bu Sayfaya Yetkiniz Yok!</h3><br /><p>Anasayfaya dönmek için <a href="' . $WorkPlace . 'main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}
?>
