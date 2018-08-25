 <?php 
function pre($value="") { // Create Tag "<pre>...</pre>" 
	echo "<pre>"; 
	if($value!=""){
		if(is_array($value)) { 
			print_r($value); 
		} else { 
			var_dump($value); 
		} 
	}else{
		echo "Not value to function \"pre\".";
	}
	echo "</pre>"; 
}
 ?>