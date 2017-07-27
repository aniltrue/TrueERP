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
}

class ComboHelp {
	var $conn, $SQL, $ValueColumn, $TextColumns, $Value;
	
	function __construct($conn, $SQL, $ValueColumn, $TextColumns, $Value) {
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
      $SelectedText = "";
      if ($Value == $Option[$this->ValueColumn]) 
        $SelectedText = " selected";
      
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
			
			$ComboText = $ComboText . '<option ' . $ValueText . $SelectedText . '>' . trim($Text) . '</option>';
		}
		
		return $ComboText;
	}
}

class InputObjects {
  var $ColumnName, $Text, $InputType, $Value, $PlaceHolder;
  var $ComboHelp;
  
  function __construct($ColumnName, $Text, $InputType) {
    $this->ColumnName = $ColumnName;
    $this->Text = $Text;
    $this->InputType = $InputType;
    $this->Value = "";
    $this->PlaceHolder = $Text;
  }
  
  function draw() {
    echo '<li>';
    echo '<label>' . $this->Text . '</label>';

    if($this->InputType === 'comboBox') {
	    $this->drawCombo();
      echo '</li>';
      return;
    }
    
    $NameText = 'name="' . $this->ColumnName . '"';
    $IDText = 'id="' . $this->ColumnName . '"';
    $ValueText = 'value="' . $this->Value . '"';
    $PlaceHolderText = 'placeholder="' . $this->PlaceHolder . '"';
    $ClassText = 'class="w3-input w3-border"';	
	  if($this->InputType === "checkbox")
		  $ClassText = 'class="w3-check"';
    
    $InputText = 'type="' . $this->InputType . '"';
	  if($this->InputType === 'year')
		  $InputText = 'type="number"';
    
    echo '<input ' $NameText . ' ' . $IDText . ' ' . $InputText . ' ' . $ValueText . ' ' . $PlaceHolderText . ' ' . $ClassText . ' />';
	  if($this->InputType === "checkbox")
		  echo '<label class="w3-text-black">' . $this->PlaceHolder . '</label>';
    
    echo '</li>';
  }
  
  private function drawCombo() {
    echo '<select class="w3-select w3-border" name="' . $this->ColumnName . ' id="' . $this->ColumnName . '">';
    if ($this->Value === "")
      echo '<option value="">' . $this->PlaceHolder . '</option>';
    else
      echo '<option value="" selected>' . $this->PlaceHolder . '</option>';
    
    echo $this->ComboHelp->ComboText();
    
    echo '</select>';
  }
}

class SearchObject {
  var $ColumnName, $Text, $IsExl;
  
  function __construct($ColumnName, $Text, $IsExl) {
   $this->ColumnName = $ColumnName;
   $this->Text = $Text;
   $this->IsExl = $IsExl;
  }
  
  function draw($Row) {
   return $Row[$this->ColumnName]; 
  }
}

class LinkObject extends SearchObject {
 var $PageName, $ReferansColumn, $AdditionalPar;
 var $RoleCheck, $Page;
 
 function __construct($Text, $PageName, $conn, $UserTitle, $ReferansColumn) {
  parent::__construct(null, $Text, false);
  $this->PageName = $PageName;
  $this->ReferansColumn = $ReferansColumn;
  $this->AdditionalPar = "";
  
  $this->RoleCheck = CheckPageRoles($conn, $UserTitle, $PageName);
  $this->Page = $conn->query("SELECT PageURL, PageDescription FROM Pages WHERE PageName = '" . $PageName . "'");
  
 }
 
 function __draw($Row) {
  $ReferansText = "";
  if(!empty($this->ReferansColumn))
   $ReferansText = '?' . $this->ReferansColumn . '=' . $Row[$this->ReferansColumn];
  
  $URLText = 'href="' . $this->Page["PageURL"] . $ReferansText . $this->AdditionalPar . '"';
  if($this->RoleCheck == false) {
   $URLText = 'tooltip="Bu alana yetkiniz yok." disabled';
  }
  
  return '<a class="w3-btn w3-teal w3-round-xlarge" ' . $URLText . '>' . $this->Page["PageDescription"] . '</a>';
 }
}

?>
