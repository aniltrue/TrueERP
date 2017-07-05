<?php include('head.php'); ?>

<?php
if(isset($_GET["AnalysisID"]))
	$AnalysisID = trim($_GET["AnalysisID"]);
elseif(isset($_POST["AnalysisID"])) 
	$AnalysisID = trim($_POST["AnalysisID"]);
else {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Analiz seçmeniz gerekiyor.</p></div>';
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

$rslt = $conn->query("SELECT * FROM Analysis natural join (Product natural join Farmer) WHERE AnalysisID = " . $AnalysisID);
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Analiz bulunamadı.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}
$Analysis = $rslt->fetch_assoc();

if(isset($_POST["Save"])) {
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
		
		$sql = "UPDATE Analysis SET AnalysisTypeName = '" . $AnalysisTypeName . "', AnalysisStatusID = " . $AnalysisStatusID . ", AnalysisDate = '" . $AnalysisDate . "', AnalysisYear = '" . $AnalysisYear . "' WHERE AnalysisID = " . $AnalysisID;
		$rslt = $conn->query($sql);
		
		if($rslt == 1) {
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $AnalysisID . '</b> nolu analiz başarıyla güncellendi.</p></div>';
			$rslt = $conn->query("SELECT * FROM Analysis natural join (Product natural join Farmer) WHERE AnalysisID = " . $AnalysisID);
			if($rslt->num_rows == 0) {
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Analiz bulunamadı.</p></div>';
				$conn->close();
				include('tail.php');
				exit;
			}
			$Analysis = $rslt->fetch_assoc();
		}
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();
?>

<form action="#" method="post" class="w3-container w3-text-green">
<h3>Analizi Güncelle</h3>

<div class="w3-row w3-section">
	<p>Analiz No</p>
	<?php echo '<input class="w3-input w3-border" name="AnalysisID" type="text" value="' . $AnalysisID . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Ürün Tipi</p>
	<?php echo '<input class="w3-input w3-border" type="text" value="' . $Analysis["ProductTypeName"] . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Üretici Adı ve Soyadı</p>
	<?php echo ' <input class="w3-input w3-border" type="text" value="' . $Analysis["FarmerName"] . ' ' . $Analysis["FarmerSurname"] . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Analiz Türü</p>
	<select class="w3-select w3-border" name="AnalysisTypeName">
        <?php
			while($row = $AnalysisTypes->fetch_assoc()) {
				if($row["AnalysisTypeName"] == $Analysis["AnalysisTypeName"])
					echo '<option value="' . $row["AnalysisTypeName"] . '" selected>' . $row["AnalysisTypeName"] . '</option>';
				else
					echo '<option value="' . $row["AnalysisTypeName"] . '">' . $row["AnalysisTypeName"] . '</option>';
			}
			
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Analiz Durumu</p>
	<select class="w3-select w3-border" name="AnalysisStatusID">
        <?php
			while($row = $AnalysisStatus->fetch_assoc()) {
				if($row["AnalysisStatusID"] == $Analysis["AnalysisStatusID"])
					echo '<option value="' . $row["AnalysisStatusID"] . '" selected>' . $row["AnalysisStatusDescription"] . '</option>';
				else
					echo '<option value="' . $row["AnalysisStatusID"] . '">' . $row["AnalysisStatusDescription"] . '</option>';
			}
			
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Analiz Tarihi</p>
	<?php 
		echo '<input class="w3-input w3-border" name="AnalysisDate" type="date" value="' . $Analysis["AnalysisDate"] . '" />'; 
	?>
</div>

<div class="w3-row w3-section">
	<p>Dönem</p>
	<?php
    	echo '<input class="w3-input w3-border" name="AnalysisYear" type="number" placeholder="Yıl" value="' . $Analysis["AnalysisYear"] . '" />';
	?>
</div>

<span onclick="document.getElementById('RemoveAnalysis').style.display='block'" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin" >Analizi Sil</span>

<div id="RemoveAnalysis" class="w3-modal">
   <div class="w3-modal-content w3-card-4 w3-border w3-border-green">
     <div class="w3-container w3-light-gray">
	   <h3 class="w3-text-red w3-border-bottom">Dikkat!</h3>
       <span onclick="document.getElementById('RemoveAnalysis').style.display='none'" class="w3-button w3-display-topright">&times;</span>
       <p>Analizi silmek istediğinizden emin misiniz?<br />Sildiğiniz takdirde bu analize bağlı bütün veriler tamamen silinecektir.</p>
       <?php echo '<a href="RemoveAnalysis.php?AnalysisID=' . $AnalysisID . '" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin">Sil</a>' ?>
       <span onclick="document.getElementById('RemoveAnalysis').style.display='none'" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">İptal</span>
    </div>
  </div>
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Save">Analizi Güncelle</button>

</form>

<?php include('tail.php'); ?>