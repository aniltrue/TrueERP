<?php
include('head.php');

class RemoveObject {
	var $ColumnName, $Text;
	
	function __construct($ColumnName, $Text) {
		$this->ColumnName = $ColumnName;
		$this->Text = $Text;	
	}
}
?>