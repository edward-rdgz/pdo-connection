<?php

$val = array("1 or '1' = '1", "\\\\---", "hola--%a", "%%m%n");

for($i=0; $i<count($val); $i++) {
	echo clean($val[$i])."</br>";
}

function clean($val) { // CONTRA INYECCIONES SQL 
	
	if(is_array($val)) {
	
		foreach($val as $n) {
			$val[] = clean($n);
		}
	
	} else {
	
		$val = addslashes($val);
		$val = trim($val);
		$val = htmlentities($val, ENT_QUOTES);
		$val = stripslashes($val);
		
	}
	
	return $val;

}

?>