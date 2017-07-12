<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php
// Functions
	
function CheckPageRoles($conn, $UserEmail, $PageName) {
 $Roles = $conn->("SELECT * FROM UserRoles left join UserRoleTypes WHERE UserEmail = '" . $UserEmail . "' AND (PageName = '" . $PageName ."' OR RoleTypeName = 'ROLE_ALL')");
 return $Roles->num_rows() > 0;
}
?>
	
<?php
$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
if($conn->connect_error){
     die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
}
$conn->query("SET NAMES 'utf8'");
$now = new DateTime('now');

?>

<title>Bla Bla</title>
</head>

<body class="w3-light-grey">

<?php
session_start();
if(!isset($_SESSION["user"]) || !isset($_SESSION["email"])) {
	session_destroy();
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üye girişi yapmak için <a href="index.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}
$UserEmail = $conn->real_escape_string($_SESSION["email"]);
$sql = "SELECT * FROM User WHERE UserEmail = '" . $UserEmail . "'";
$result = $conn->query($sql);
if($result->num_rows <= 0) {
	session_destroy();
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üye girişi yapmak için <a href="index.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}
	
$User = $result->fetch_assoc();
$Password = md5($rw["UserPassword"] . "_dg");
if($Password != $_SESSION["user"]) {
	session_destroy();
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üye girişi yapmak için <a href="index.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}
$userInfo = array($rw["UserName"], $rw["UserSurname"], $rw["UserPhone"], $rw["StartDate"]);

?>

<div class="w3-container w3-border-bottom w3-border-lime w3-teal">
	<h2>Bla Bla</h2>
    <p>Hoş Geldiniz, <?php echo $userInfo[0] . ' ' . $userInfo[1] ?>.</p>
</div>

<div class="w3-container w3-green w3-border w3-border-teal w3-margin">
	<div class="w3-bar w3-border-teal">
    <?php
	
	$mainmenus = $conn->query("SELECT * FROM MainMenu left join Pages WHERE MainMenuParent = 0");
	while($mainmenu = $mainmenus->fetch_assoc()) {
		if(!empty($mainmenu["PageURL"]) && CheckPageRoles($conn, $UserEmail, $childmenu["PageName"]))
			echo '<a href="' . $mainmenu["PageURL"] . '" class="w3-bar-item w3-button w3-animate-right">' . $mainmenu["MainMenuText"] . '</a>';	
		else {
			echo '<div class="w3-dropdown-hover">
			<button class="w3-button w3-animate-right">' . $mainmenu["MainMenuText"] . '</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-4">';
			
			$childmenus = $conn->query("SELECT * FROM MainMenu natural join Page WHERE MainMenuParent = " . $mainmenu["MainMenuID"]);
			while($childmenu = $childmenus->fetch_assoc()) {
				if(CheckPageRoles($conn, $UserEmail, $childmenu["PageName"]))
					echo '<a href="' . $childmenu["PageURL"] . '" class="w3-bar-item w3-button">' . $childmenu["MainMenuText"] . '</a>';
			}
			
			echo '</div>
			</div>';
		}
	}
	
	?>
    
    <a href="logout.php" class="w3-bar-item w3-button w3-right w3-animate-right">Çıkış</a>
    </div>
    
    <div class="w3-panel w3-border w3-border-teal w3-white w3-card-4">
