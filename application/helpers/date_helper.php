<?php
function fullDateTH3($date) {
	list($yy, $mm, $dd) = preg_split("[/|-]",$date);
	
	if($dd=='01') { $dd='1'; }
	else if($dd=='02') { $dd='2'; }
	else if($dd=='03') { $dd='3'; }
	else if($dd=='04') { $dd='4'; }
	else if($dd=='05') { $dd='5'; }
	else if($dd=='06') { $dd='6'; }
	else if($dd=='07') { $dd='7'; }
	else if($dd=='08') { $dd='8'; }
	else if($dd=='09') { $dd='9'; }
	
	if($mm=='01') { $mm='มกราคม'; }
	else if($mm=='02') { $mm='กุมภาพันธ์'; }
	else if($mm=='03') { $mm='มีนาคม'; }
	else if($mm=='04') { $mm='เมษายน'; }
	else if($mm=='05') { $mm='พฤษภาคม'; }
	else if($mm=='06') { $mm='มิถุนายน'; }
	else if($mm=='07') { $mm='กรกฎาคม'; }
	else if($mm=='08') { $mm='สิงหาคม'; }
	else if($mm=='09') { $mm='กันยายน'; }
	else if($mm=='10') { $mm='ตุลาคม'; }
	else if($mm=='11') { $mm='พฤศจิกายน'; }
	else if($mm=='12') { $mm='ธันวาคม'; }
	$yy += 543;
	return "$dd $mm พ.ศ. $yy";
}

// function splitDateForm($date,$sp="-") {
	// list($dd, $mm, $yy) = preg_split("[/|-]", $date);
	// $yy += 543;
	// return $yy.'-'.$mm.'-'.$dd;
// }
?>