<?php
class InputTypes {
 const $Text = 'text';
 const $Number = 'number'; 
 const $Date = 'date';
 const $Year = 'year';
 const $TextArea = 'textArea';
 const $ComboBox = 'comboBox';
 const $List = 'list'; 
}

class ObjectTypes {
 const $Common = 0;
 const $ShowOnly = 1;
 const $Required = 2;
}

class AddObject {
  var $ColumnName, $ColumnText, $InputType, $ObjectType, $PlaceHolder, $IsRequired, $IsUnique;
  var $value;
  
  function __constructor($ColumnName, $ColumnText, $InputType, $ObjectType) {
   $this->$ColumnName = $ColumnName;
   $this->$ColumnText = $ColumnText;
   $this->$InputType = $InputType;
   $this->$ObjectType = $ObjectType;
   $this->$PlaceHolder = $ColumnText;
   $IsRequired = true;
   $IsUnique = false;
   $value = null;
  }
  
  function draw() {
   if($InputType == 'text' && $InputType == 'number' && $InputType == 'date' && $InputType == 'year' && $InputType == 'textArea')
     return;
    
   drawTitle();
   
   echo '</div>';
  }
  
  private function drawTitle() {
   $RedDot = "";
	 if($IsRequired)
		$RedDot = '<label class="w3-text-red">*</label>';
    
	 echo '<div class="w3-row w3-section">
	 <p>' . $ColumnText . $RedDot . '</p>';
  }
  
  private function getPropertiesText() {
   $DisabledText = "";
	 if($ObjectType != 0)
		 $DisabledText = "disabled";
		
	 $NameText = "";
	 if($ObjectType != 1)
	  $NameText = 'name="' . $ColumnName . '"';
    
   return trim($NameText . " " . $DisabledText);
  }
}
?>
