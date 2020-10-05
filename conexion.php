<?php 
	
	$host = 'localhost';
	$user = 'dbadminbckp';
	$password = 'admin';
	$db = 'aquaweb';

	$conection = @mysqli_connect($host,$user,$password,$db);

	if(!$conection){
		echo "Error en la conexión";
	}

?>