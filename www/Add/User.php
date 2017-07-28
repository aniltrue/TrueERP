<?php
include('class/head.php');
include('class/AddClass.php');
?>

<div id="PasswordInfo" class="w3-container w3-card-4 w3-white w3-left-align w3-tooltip w3-animate-opacity">
<h3 class="w3-panel">Parolanızın aşağıdaki şartlara uyması gerek:</h3>
<ul class="w3-ul">
<li id="letter" class="w3-text-red"><label id="letterTick">&#10007;</label> En az <strong>bir küçük harf</strong></li>
<li id="capital" class="w3-text-red"><label id="capitalTick">&#10007;</label> En az <strong>bir büyük harf</strong></li>
<li id="number" class="w3-text-red"><label id="numberTick">&#10007;</label> En az <strong>bir rakam</strong></li>
<li id="length" class="w3-text-red"><label id="lengthTick">&#10007;</label> En az <strong>8 karekter</strong></li>
</div>

<script>
$('#PasswordInfo').hide();
</script>

<?php

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

<script>
$(document).ready(function() {
$('#UserPassword').keyup(function() {
		var pswrd = $(this).val();
        var isValid = 1;
        
    	// Length
   		if (pswrd.length < 8 ) {
    		$('#length').removeClass('w3-text-green').addClass('w3-text-red');
			$('#lengthTick').text(String.fromCharCode(10007));
            isValid = 0;
		} else {
    		$('#length').removeClass('w3-text-red').addClass('w3-text-green');
			$('#lengthTick').text(String.fromCharCode(10004));
		}
    
    	// Letter
    	if (pswrd.match(/[a-z]/) ) {
    		$('#letter').removeClass('w3-text-red').addClass('w3-text-green');
			$('#letterTick').text(String.fromCharCode(10004));
		} else {
    		$('#letter').removeClass('w3-text-green').addClass('w3-text-red');
			$('#letterTick').text(String.fromCharCode(10007));
            isValid = 0;
		}

		// Capital letter
		if (pswrd.match(/[A-Z]/) ) {
    		$('#capital').removeClass('w3-text-red').addClass('w3-text-green');
			$('#capitalTick').text(String.fromCharCode(10004));
		} else {
    		$('#capital').removeClass('w3-text-green').addClass('w3-text-red');
			$('#capitalTick').text(String.fromCharCode(10007));
            isValid = 0;
		}

		// Number
		if (pswrd.match(/\d/) ) {
    		$('#number').removeClass('w3-text-red').addClass('w3-text-green');
			$('#numberTick').text(String.fromCharCode(10004));
		} else {
    		$('#number').removeClass('w3-text-green').addClass('w3-text-red');
			$('#numberTick').text(String.fromCharCode(10007));
            isValid = 0;
		}
        
        if(isValid == 1) {
        	$('#CreateBtn').prop('disabled',false);
        } else {
        	$('#CreateBtn').prop('disabled',true);
        }
	}).focus(function() {
    	$('#PasswordInfo').show();
	}).blur(function() {
    	$('#PasswordInfo').hide();
	});

// Initiate
$('#CreateBtn').prop('disabled',true);
});
</script>
