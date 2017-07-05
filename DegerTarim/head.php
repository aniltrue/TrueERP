<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php
$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	

if($conn->connect_error){
     die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
}

$conn->query("SET NAMES 'utf8'");

$now = new DateTime('now');

function DrawFormItem($row, $value) {
	$now = new DateTime('now');
	$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	

	if($conn->connect_error){
    	 die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	}

	$conn->query("SET NAMES 'utf8'");

	$RedDot = "";
	if(!$row["CanEmpty"])
		$RedDot = '<label class="w3-text-red">*</label>';

	echo '<div class="w3-row w3-section">
	<p>' . $row["ObjectText"] . $RedDot . '</p>';
	
	$DisabledText = "";
	if($row["ObjectType"] != 0)
		$DisabledText = "disabled";
		
	$NameText = "";
	if($row["ObjectType"] != 1)
		$NameText = 'name="' . $row["ColumnName"] . '"';
		
	if($row["InputType"] == "text" || $row["InputType"] == "date" || $row["InputType"] == "year" || $row["InputType"] == "number") {
		$InputType = 'type="' . $row["InputType"] . '"';
		if($row["InputType"] == "year")
			$InputType = 'type="number"';
		
		$ValueText = "";
		if(empty($value) && $row["InputType"] == "date")
			$value = $now->format("Y-m-d");
		elseif(empty($value) && $row["InputType"] == "year")
			$value = $now->format("Y");
		
		if(!empty($value))
			$ValueText = 'value="' . $value . '"';
			
		$InputText = $row["InputText"];
		if(empty($row["InputText"]))
			$InputText = $row["ObjectText"];
			
		if(!empty($row["SpecialSQL"])) {
			$ValueText = "";
			$GetValue = $conn->query($row["SpecialSQL"] . " WHERE " . $value);
			$rw = $GetValue->fetch_assoc();
			$FirstTime = true;
			foreach($rw as $r) {
				if(!$FirstTime)
					$ValueText = $ValueText . ' ';
				else
					$FirstTime = false;
					
				$ValueText = $ValueText . $r;	
			}
			
			$ValueText = 'value="' . $ValueText . '"';
		}
			
		echo '<input class="w3-input w3-border" ' . $NameText . ' ' . $InputType . ' ' . $ValueText . ' ' . $DisabledText . ' placeholder="' . $row["InputText"] . '" />';
		
	} elseif($row["InputType"] == "combo") {
		echo '<select class="w3-select w3-border" ' . $NameText . ' ' . $DisabledText . '>';
		if(empty($value))
    	 echo '<option value="" disabled selected>' . $row["InputText"] . '</option>';
		
		$combos = $conn->query($row["SpecialSQL"]);
		while($combo = $combos->fetch_assoc()) {
			$FirstTime = true;
			$ValueText = "";
			$Columns = explode(" ", $row["ComboSpecial"]);
			foreach($Columns as $Column) {
				if(!$FirstTime)
					$ValueText = $ValueText . ' - ';
				else
					$FirstTime = false;
					
				$ValueText = $ValueText . $combo[$Column];
			}
			
			$SelectedText = "";
			if(!empty($value) && $combo[$row["ColumnName"]] == $value)
				$SelectedText = "selected";
				
			echo '<option value="' . $combo[$row["ColumnName"]] . '" ' . $SelectedText . '>' . $ValueText . '</option>';
		}
		
		echo '</select>';
	}
	
	echo '</div>';	
}

?>

<title>Değer İyi Tarım - ERP</title>
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

$email = $conn->real_escape_string($_SESSION["email"]);

$sql = "SELECT * FROM User WHERE UserEmail = '" . $email . "'";
$rslt = $conn->query($sql);

if($rslt->num_rows <= 0) {
	session_destroy();
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üye girişi yapmak için <a href="index.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}
	
$rw = $rslt->fetch_assoc();
$pswrd = md5($rw["UserPassword"] . "_dg");

if($pswrd != $_SESSION["user"]) {
	session_destroy();
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üye girişi yapmak için <a href="index.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}

$userInfo = array($rw["UserName"], $rw["UserSurname"], $rw["UserPhone"], $rw["StartDate"]);
?>

<div class="w3-container w3-border-bottom w3-border-lime w3-teal">
	<h2>Değer İyi Tarım</h2>
    <p>Hoş Geldiniz, <?php echo $userInfo[0] . ' ' . $userInfo[1] ?>.</p>
</div>

<div class="w3-container w3-green w3-border w3-border-teal w3-margin">
	<div class="w3-bar w3-border-teal">
    <a href="main.php" class="w3-bar-item w3-button w3-animate-right">Anasayfa</a>
    <?php
	
	$mainmenus = $conn->query("SELECT * FROM MainMenu WHERE MainMenuParent = 0");
	while($mainmenu = $mainmenus->fetch_assoc()) {
		if(!empty($mainmenu["MainMenuLink"]))
			echo '<a href="' . $mainmenu["MainMenuLink"] . '" class="w3-bar-item w3-button w3-animate-right">' . $mainmenu["MainMenuName"] . '</a>';	
		else {
			echo '<div class="w3-dropdown-hover">
			<button class="w3-button w3-animate-right">' . $mainmenu["MainMenuName"] . '</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-4">';
			
			$childmenus = $conn->query("SELECT * FROM MainMenu WHERE MainMenuParent = " . $mainmenu["MainMenuID"]);
			while($childmenu = $childmenus->fetch_assoc()) 
				echo '<a href="' . $childmenu["MainMenuLink"] . '" class="w3-bar-item w3-button">' . $childmenu["MainMenuName"] . '</a>';
			
			echo '</div>
			</div>';
		}
	}
	
	?>
    
    <a href="logout.php" class="w3-bar-item w3-button w3-right w3-animate-right">Çıkış</a>
    </div>
    
    <div class="w3-panel w3-border w3-border-teal w3-white w3-card-4">