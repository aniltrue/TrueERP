<?php include('head.php'); ?>

<?php

// Get TableName
if(isset($_GET["AddType"]))
	$TableName = trim($_GET["AddType"]);
elseif(isset($_POST["AddType"])) 
	$TableName = trim($_POST["AddType"]);
else {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Yanlış Sayfa!</h3><br /><p>Anasayfaya dönmek için <a href="main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;	
}

// Check Table
$rslt = $conn->query("SELECT * FROM ObjectTypes WHERE TableName = '" . $TableName . "'");
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Yanlış Sayfa!</h3><br /><p>Anasayfaya dönmek için <a href="main.php" class="w3-hover-gray">BURAYA</a> tıklayınız!</p></div>';
	include('tail.php');
	exit;	
}
$ObjectType = $rslt->fetch_assoc();

// Check Requires
$rslt = $conn->query("SELECT * FROM Objects WHERE ObjectType = 2 AND (OperationType = 0 OR OperationType = 2) AND TableName = '" . $TableName . "'");
if($rslt->num_rows > 0) {
	$Requires = array();
	while($row = $rslt->fetch_assoc()) {
		if(isset($_GET[$row["ColumnName"]]))
			$Requires[$row["ColumnName"]] = $_GET[$row["ColumnName"]];
		elseif(isset($_POST[$row["ColumnName"]]))
			$Requires[$row["ColumnName"]] = $_POST[$row["ColumnName"]];
		else {
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>' . $ObjectType["ObjectName"] . ' ekleyebilmeniz için öncelikle <b>' . $$row["ObjectText"] . '</br> seçmeniz gerekiyor.</p></div>';
			include('tail.php');
			exit;	
		}
	}
}

// ADDING
if(isset($_POST["Create"])) {
	$rslt = $conn->query("SELECT * FROM Objects WHERE (ObjectType = 2 OR ObjectType = 0) AND (OperationType = 0 OR OperationType = 2) AND TableName = '" . $TableName . "'");
	$ColumnsSQL = "";
	$ValuesSQL = "";
	$IsValid = true;
	$FirstTime = true;
	
	// Check Inputs and create SQL
	while($row = $rslt->fetch_assoc()) {
		if(empty($_POST[$row["ColumnName"]])) {
			if(!$row["CanEmpty"]) {
				//echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>' . $row["ObjectText"] . ' girmeniz gerekiyor!</p></div>';
				//$IsValid = false;
			}
		} else {
			if(!$FirstTime) {
				$ColumnsSQL = $ColumnsSQL . ", ";
				$ValuesSQL = $ValuesSQL . ", ";
			} else
				$FirstTime = false;
				
			$ColumnsSQL = $ColumnsSQL . $row["ColumnName"];
			$ValuesSQL = $ValuesSQL . "'" . $conn->real_escape_string(trim($_POST[$row["ColumnName"]])) . "'";
		}
	}
	
	// ADD if it is valid
	if($IsValid) {
		$sql = "INSERT INTO " . $TableName . " (" . $ColumnsSQL . ") VALUES (" . $ValuesSQL . ");";
		echo $sql;
		$rslt = $conn->query("INSERT INTO " . $TableName . " (" . $ColumnsSQL . ") VALUES (" . $ValuesSQL . ")");
		
		if($rslt == true)
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $ObjectType["ObjectName"] . '</b> başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';	
	}
}

// Draw form
echo '<form action="#" method="post" class="w3-container w3-text-green">
<h3>' . $ObjectType["ObjectName"] . ' Ekle</h3>';

$rslt = $conn->query("SELECT * FROM Objects WHERE (OperationType = 0 OR OperationType = 2) AND TableName = '" . $TableName . "'");

while($row = $rslt->fetch_assoc()) {
	if($row["ObjectType"] == 2)
		DrawFormItem($row, $Requires[$row["ColumnName"]]);	
	else
		DrawFormItem($row, "");
}

echo '<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">'. $ObjectType["ObjectName"] . ' Ekle</button>
</form>';

?>

<?php include('tail.php'); ?>