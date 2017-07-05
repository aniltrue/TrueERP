<?php include('head.php'); ?>

<?php
if(isset($_GET["ProductID"]))
	$ProductID = trim($_GET["ProductID"]);
elseif(isset($_POST["ProductID"])) 
	$ProductID = trim($_POST["ProductID"]);
else {
	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üye girişi yapmak için <a href="index.php" class="w3-hover-gray">BURAYA</a> tıklayınız!</p></div>');
	include('tail.php');
	exit;	
}

$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");

$AnalysisTypes = $conn->query("SELECT * FROM AnalysisType ORDER BY AnalysisTypeName ASC");
if($AnalysisTypes->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Analiz Türü eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

$AnalysisStatus = $conn->query("SELECT * FROM AnalysisStatus ORDER BY AnalysisStatusDescription ASC");
if($AnalysisStatus->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Analiz Durumu eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

$rslt = $conn->query("SELECT * FROM Product natural join Farmer WHERE ProductID = " . $ProductID);
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Ürün bulunamadı.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}
$Product = $rslt->fetch_assoc();

if(isset($_POST["Create"])) {
	if(empty($_POST["AnalysisTypeName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Ürün Tipi seçmeniz gerekiyor!</p></div>';
		
	if(empty($_POST["AnalysisStatusID"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Analiz Durumu seçmeniz gerekiyor!</p></div>';
		
	if(empty($_POST["AnalysisDate"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Analiz Tarihi kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["AnalysisYear"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Dönem kısmı boş olamaz!</p></div>';
		
	if(!empty($_POST["AnalysisTypeName"]) && !empty($_POST["AnalysisStatusID"]) && !empty($_POST["AnalysisDate"]) && !empty($_POST["AnalysisYear"])) {
		$AnalysisTypeName = $conn->real_escape_string($_POST["AnalysisTypeName"]);
		$AnalysisStatusID = $conn->real_escape_string($_POST["AnalysisStatusID"]);
		$AnalysisDate = $conn->real_escape_string($_POST["AnalysisDate"]);
		$AnalysisYear = $conn->real_escape_string($_POST["AnalysisYear"]);	
		
		$sql = "INSERT INTO Analysis (ProductID, AnalysisTypeName, AnalysisStatusID, AnalysisDate, AnalysisYear) VALUES (" . $ProductID . ", '" . $AnalysisTypeName . "', " . $AnalysisStatusID . ", '" . $AnalysisDate . "', '" . $AnalysisYear . "')";
		$rslt = $conn->query($sql);
		
		if($rslt == true)
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $ProductID . '</b> nolu ürünün <b>' . $AnalysisTypeName . '</b> analizi başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();
?>

<form action="#" method="post" class="w3-container w3-text-green">
<h3>Analiz Ekle</h3>

<div class="w3-row w3-section">
	<p>Ürün No</p>
	<?php echo '<input class="w3-input w3-border" name="ProductID" type="text" value="' . $ProductID . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Ürün Tipi</p>
	<?php echo '<input class="w3-input w3-border" type="text" value="' . $Product["ProductTypeName"] . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Üretici Adı ve Soyadı</p>
	<?php echo ' <input class="w3-input w3-border" type="text" value="' . $Product["FarmerName"] . ' ' . $Product["FarmerSurname"] . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Analiz Türü</p>
	<select class="w3-select w3-border" name="AnalysisTypeName">
    	<option value="" disabled selected>Lütfen bir analiz türü seçiniz</option>
        <?php
			while($row = $AnalysisTypes->fetch_assoc()) 
				echo '<option value="' . $row["AnalysisTypeName"] . '">' . $row["AnalysisTypeName"] . '</option>';
			
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Analiz Durumu</p>
	<select class="w3-select w3-border" name="AnalysisStatusID">
    	<option value="" disabled selected>Lütfen analiz durumu seçiniz</option>
        <?php
			while($row = $AnalysisStatus->fetch_assoc()) 
				echo '<option value="' . $row["AnalysisStatusID"] . '">' . $row["AnalysisStatusDescription"] . '</option>';
			
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Analiz Tarihi</p>
	<?php 
	$now = new DateTime('now');
	echo '<input class="w3-input w3-border" name="AnalysisDate" type="date" value="' . $now->format("Y-m-d") . '" />'; 
	?>
</div>

<div class="w3-row w3-section">
	<p>Dönem</p>
	<?php
    echo '<input class="w3-input w3-border" name="AnalysisYear" type="number" placeholder="Yıl" value="' . $now->format("Y") . '" />';
	?>
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">Analizi Ekle</button>

</form>

<?php include('tail.php'); ?>