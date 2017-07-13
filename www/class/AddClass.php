<?php
class InputTypes {
 const Text = 'text';
 const Email = 'email';
 const Password = 'password';
 const Number = 'number'; 
 const Date = 'date';
 const CheckBox = 'checkbox';
 const Year = 'year';
 const TextArea = 'textArea';
 const ComboBox = 'comboBox';
 const ListBox = 'list'; 
}

class ObjectTypes {
 const Common = 0;
 const ShowOnly = 1;
 const Required = 2;
}

class ComboHelp {
	var $conn, $SQL, $ValueColumn, $TextColumns;
	
	function __construct($conn, $SQL, $ValueColumn, $TextColumns) {
		$this->conn = $conn;
		$this->SQL = $SQL;
		$this->ValueColumn = $ValueColumn;
		$this->TextColumns = $TextColumns;
	}
	
	function ComboText() {
		$ComboText = "";
		
		$Options = $this->conn->query($this->SQL);
		
		if($Options->num_rows == 0) 
			return;
		
		while($Option = $Options->fetch_assoc()) {
			$ValueText = 'value="' . $Option[$this->ValueColumn] . '"';
			$Text = "";
			
			if(is_string($this->TextColumns))
				$Text = $Option[$this->TextColumns];
			else {
				foreach($this->TextColumns as $TextColumn) {
					if(!empty($Text))
						$Text = $Text . " - ";
				
					$Text = $Text . $Option[$TextColumn];
				}
			}
			
			$ComboText = $ComboText . '<option ' . $ValueText . '>' . trim($Text) . '</option>';
		}
		
		return $ComboText;
	}
}

class AddObject {
  var $ColumnName, $ColumnText, $InputType, $ObjectType, $PlaceHolder, $IsRequired, $IsUnique, $ComboHelp;
  
  function __construct($ColumnName, $ColumnText, $InputType, $ObjectType) {
   $this->ColumnName = $ColumnName;
   $this->ColumnText = $ColumnText;
   $this->InputType = $InputType;
   $this->ObjectType = $ObjectType;
   $this->PlaceHolder = $ColumnText;
   $this->IsRequired = true;
   $this->IsUnique = false;
   $this->ComboHelp = null;
  }
  
  function draw() {
   if($this->InputType === 'comboBox') {
		 $this->drawCombo();
     return;
	 }
   
	 $now = new DateTime('now');
		
	 echo '<div class="w3-row w3-section">';
	 $this->drawTitle();
	 
	 $InputText = 'type="' . $this->InputType . '"';
	 if($this->InputType === 'year')
		 $InputText = 'type="number"';
   
	 $PlaceHolderText = 'placeholder="' . $this->PlaceHolder . '"';
	 
	 $ValueText = 'value=""';
	 if($this->InputType === 'year')
		 $ValueText = 'value="' . $now()->format("Y") . '"';
	 elseif($this->InputType === 'date')
		 $ValueText = 'value="' . $now()->format("d.M.Y") . '"';
	
	 echo '<input ' . $InputText . ' ' . $ValueText . ' ' . $PlaceHolderText . ' ' . $this->getPropertiesText() . ' />';
	 if($this->InputType === "checkbox")
		 echo '<label class="w3-text-black">' . $this->PlaceHolder . '</label>';
	 
   echo '</div>';
  }
  
	private function drawCombo() {
		echo '<div class="w3-row w3-section">';
		$this->drawTitle();
		echo '<select class="w3-select w3-border" ' . $this->getPropertiesText() . '>';
		echo '<option value="" disabled selected>' . $this->PlaceHolder . '</option>';
		
		echo $this->ComboHelp->ComboText();
		
		echo '</select>';
		echo '</div>';
	}
	
  private function drawTitle() {
	 if($this->IsRequired)
		 echo '<p>' . $this->ColumnText . '<label class="w3-text-red">*</label></p>';
	 else
		 echo '<p>' . $this->ColumnText . '</p>';
  }
  
  private function getPropertiesText() {
   $DisabledText = "";
	 if($this->ObjectType != 0)
		 $DisabledText = "disabled";
		
	 $NameText = "";
	 if($this->ObjectType != 1)
	  $NameText = 'name="' . $this->ColumnName . '"';

	$ClassText = 'class="w3-input w3-border"';	
	if($this->InputType === "checkbox")
		$ClassText = 'class="w3-check"';
	elseif($this->InputType === "combobox")
		$ClassText = 'class="w3-select w3-border"';
		
  return trim($NameText . " " . $DisabledText);
  }
}
?>
