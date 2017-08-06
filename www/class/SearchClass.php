<?php
include('head.php');
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
	var $conn, $SQL, $ValueColumn, $TextColumns;
	
	function __construct($conn, $SQL, $ValueColumn, $TextColumns) {
		$this->conn = $conn;
		$this->SQL = $SQL;
		$this->ValueColumn = $ValueColumn;
		$this->TextColumns = $TextColumns;
	}
	
	function ComboText($Value) {
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

class InputObject {
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
    
    echo '<input ' . $NameText . ' ' . $IDText . ' ' . $InputText . ' ' . $ValueText . ' ' . $PlaceHolderText . ' ' . $ClassText . ' />';
	  if($this->InputType === "checkbox")
		  echo '<label class="w3-text-black">' . $this->PlaceHolder . '</label>';
    
    echo '</li>';
  }
  
  private function drawCombo() {
    echo '<select class="w3-select w3-border" name="' . $this->ColumnName . '" id="' . $this->ColumnName . '">';
    if ($this->Value != "")
      echo '<option value=""> </option>';
    else
      echo '<option value="" selected> </option>';
    
    echo $this->ComboHelp->ComboText($this->Value);
    
    echo '</select>';
  }
}

class SearchObject {
  public $ColumnName, $Text, $IsExl, $TableName;
  
  function __construct($ColumnName, $Text, $IsExl) {
   $this->ColumnName = $ColumnName;
   $this->Text = $Text;
   $this->IsExl = $IsExl;
   $this->TableName = '';
  }
  
  public function draw($Row) {
   return $Row[$this->ColumnName]; 
  }
}

class LinkObject extends SearchObject {
 var $PageName, $ReferansColumn, $AdditionalPar, $IsPopup;
 private $RoleCheck, $Page;
 
 function __construct($Text, $PageName, $conn, $UserTitle, $ReferansColumn) {
  parent::__construct(null, $Text, false);
  $this->PageName = $PageName;
  $this->ReferansColumn = $ReferansColumn;
  $this->AdditionalPar = "";
  $this->IsPopup = false;
  
  $this->RoleCheck = CheckPageRoles($conn, $UserTitle, $PageName);
  $result = $conn->query("SELECT * FROM Pages WHERE PageName = '" . $PageName . "' AND PageEnable = 1");
  $this->Page = $result->fetch_assoc();
 }
 
 public function draw($Row) {
  $ReferansText = "";
  if(!empty($this->ReferansColumn)) {
   if(!empty($this->AdditionalPar))
   	$ReferansText = '?' . $this->ReferansColumn . '=' . $Row[$this->ReferansColumn] . '&' . $this->AdditionalPar;
   else
   	$ReferansText = '?' . $this->ReferansColumn . '=' . $Row[$this->ReferansColumn];
  }
  
  $URLText = 'href="http://localhost/TrueERP/' . $this->Page["PageURL"] . $ReferansText . '"';
  if($this->RoleCheck == false) 
   $URLText = 'tooltip="Bu alana yetkiniz yok." disabled';
  elseif($this->IsPopup)
	$URLText = 'onclick="PopWindow(' . "'http://localhost/TrueERP/" . $this->Page["PageURL"] . $ReferansText . "', '" . $this->Page["PageDescription"] . "'" . ');"';
  
  return '<a class="w3-btn w3-teal w3-round-xlarge" ' . $URLText . '>' . $this->Page["PageDescription"] . '</a>';
 }
}

?>
