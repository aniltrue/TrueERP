<?php

class TableHeader {
 var $Text, $IsExl;
 
 __construct($Text, $IsExl) {
  $this->Text = $Text;
  $this->IsExl = $IsExl;
 }
}

class SearchObject {
  var $ColumnName, $IsExl;
  
  __construct($ColumnName, $IsExl) {
   $this->ColumnName = $ColumnName;
   $this->IsExl = $IsExl;
  }
  
  draw($Rows) {
   return $Rows[$this->ColumnName]; 
  }
}

?>
