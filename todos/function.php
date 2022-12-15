<?php 
function sanitize_string($str) {
	if (get_magic_quotes_gpc()) {
		$sanitize = mysqli_real_escape_string(stripslashes($str));	 
	} else {
        $mysqli = mysqli_connect("localhost", "root", "root", "todos");
		$sanitize = mysqli_real_escape_string($mysqli,$str);	
	} 
	return $sanitize;
}

function div($done, $id){
    $class = 'todoCard';
    if ($done == 1){
        $class='doneCard';
    }
    return "<div class ='$class' id='$id'>";
    
}