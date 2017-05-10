<?php
//Esse é um arquivo para fazer o AUTOLOAD das classes. 

//Ela recebe o nome da classe
spl_autoload_register(function($class_name){

	$filename = "class". DIRECTORY_SEPARATOR .$class_name. ".php"; 

	if (file_exists($filename)) {
		require_once($filename);
	}

});




?>