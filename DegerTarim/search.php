<?php	
function Search($SearchKey, $rslt) {
	
	$Rows = array();
	$Keys = explode(" ", $SearchKey);
	
	$i = 0;
	while($row = $rslt->fetch_assoc()) {
		if(empty($SearchKey)) {
			$Rows[$i] = $row;
			$i++;
			continue;
		}
		
		$Text = "";
		foreach($row as $rw) {
			$Text = $Text . " " . $rw;
		}
		
		$Text = trim($Text);
		$IsValid = true;
		
		foreach($Keys as $Key) {
			if(!strpos($Text, $Key)) {
				$IsValid = false;
				break;	
			}
		}
	
		if($IsValid) {
			$Rows[$i] = $row;
			$i++;
		}
	}
	
	return $Rows;
}

function SearchFarmer($SearchKey, $rslt, $conn) {
	
	$Rows = array();
	$Keys = explode(" ", $SearchKey);
	
	$i = 0;
	while($row = $rslt->fetch_assoc()) {
		if(empty($SearchKey)) {
			$Rows[$i] = $row;
			$i++;
			continue;
		}
		
		$Text = "";
		foreach($row as $rw) {
			$Text = $Text . " " . $rw;
		}
		
		$rws = $conn->query("SELECT * FROM (Product natural join Farmer) natural join (Village natural join District)");
		
		if($rws == true) {
			while($r = $rws->fetch_assoc()) {
				if ($r["TCID"] != $row["TCID"])
					continue;
					
				$Text = $Text . " " . $r["ProductTypeName"] . " " . $r["CityName"] . " " . $r["DistrictName"] . " " . $r["VillageName"];
			}
		}
		
		$Text = trim($Text);
		$IsValid = true;
		
		foreach($Keys as $Key) {
			if(!strpos($Text, $Key)) {
				$IsValid = false;
				break;	
			}
		}
	
		if($IsValid) {
			$Rows[$i] = $row;
			$i++;
		}
	}
	
	return $Rows;
}
?>