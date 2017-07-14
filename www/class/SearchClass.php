<?php

class TableHeader {
 var $Text, $IsExl;
 
 function __construct($Text, $IsExl) {
  $this->Text = $Text;
  $this->IsExl = $IsExl;
 }
}

class SearchObject {
  var $ColumnName, $IsExl;
  
  function __construct($ColumnName, $IsExl) {
   $this->ColumnName = $ColumnName;
   $this->IsExl = $IsExl;
  }
  
  function draw($Rows) {
   return $Rows[$this->ColumnName]; 
  }
}

class LinkObject extends SearchObject {
 var $PageName, $ReferansColumn;
 var $RoleCheck, $Page;
 
 function __construct($ColumnName, $IsExl, $PageName, $conn, $UserTitle, $ReferansColumn) {
  parent::__construct($ColumnName, $IsExl);
  $this->PageName = $PageName;
  $this->ReferansColumn = $ReferansColumn;
  
  $this->RoleCheck = CheckPageRoles($conn, $UserTitle, $PageName);
  $this->Page = $conn->query("SELECT PageURL, PageDescription FROM Pages WHERE PageName = '" . $PageName . "'");
  
 }
 
 function __draw($Rows) {
  $ReferansText = "";
  if(!empty($this->ReferansColumn))
   $ReferansText = '?' . $this->ReferansColumn . '=' . $Rows[$this->ReferansColumn];
  
  $URLText = 'href="' . $this->Page["PageURL"] . $ReferansText . '"';
  if($this->RoleCheck == false) {
   $URLText = 'tooltip="Bu alana yetkiniz yok." disabled';
  }
  
  return '<a class="w3-btn w3-teal w3-round-xlarge" ' . $URLText . '>' . $this->Page["PageDescription"] . '</a>';
 }
}

?>
