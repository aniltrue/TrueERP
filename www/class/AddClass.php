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
   if($InputType === 'combo')
     return;
   
	 echo '<div class="w3-row w3-section">';
	 drawTitle();
	 
	 $InputText = 'type="' . $InputType . '"';
	 if($InputType === 'year')
		 $InputText = 'type="number"';
   
	 $PlaceHolderText = 'placeholder="' . $PlaceHolder . '"';
	 
	 $ValueText = 'value=""';
	 if($InputType === 'year')
		 $ValueText = 'value="' . $now()->format("Y") . '"';
	 elseif($InputType === 'date')
		 $ValueText = 'value="' . $now()->format("d.M.Y") . '"';
	
	 echo '<input ' $InputText . ' ' $ValueText . ' ' . $PlaceHolderText . ' ' . getPropertiesText() . ' />'; 
	 
   echo '</div>';
  }
  
	function drawCombo($conn, $SQL, $ValueColumn, $TextColumns) {
		if($InputType != 'combo')
			return;
		
		echo '<div class="w3-row w3-section">';
		drawTitle();
		
		echo '<option value="" disabled selected>' . $PlaceHolder . '</option>';
		
		$Options = $conn->query($SQL);
		
		if($Options->num_rows == 0) {
			echo '</div>';
			return;
		}
		
		while($Option = $Options->fetch_assoc()) {
			$ValueText = 'value="' . $Option[$ValueColumn] . '"';
			$Text = "";
			
			if(is_string($TextColumns))
				$Text = $Option[$TextColumns];
			else {
				foreach($TextColumn as $TextColumns) {
					if(!empty($Text))
						$Text = $Text . " - ";
				
					$Text = $Text . $Option[$TextColumn];
				}
			}
			
			echo '<option ' . $ValueText . '>' . trim($Text) . '</option>';
		}
		
		echo '</div>';
	}
	
  private function drawTitle() {
	 if($IsRequired)
		 echo '<p>' . $ColumnText . '<label class="w3-text-red">*</label></p>';
	 else
		 echo '<p>' . $ColumnText . '</p>';
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
