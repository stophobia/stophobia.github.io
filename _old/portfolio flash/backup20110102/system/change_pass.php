<?
	include "setup.php";

	$my_pass=$_POST['pass'];
	$new_pass=$_POST['new_pass'];

	if($my_pass==$admin_pass){
		// FILE WRITE
		$fp=fopen("setup.php","w+");
		fwrite($fp,stripslashes($new_pass));
		fclose($fp);
		echo("TRUE");
	}else{
		echo("FALSE");
	}
?>