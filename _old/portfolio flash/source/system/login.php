<?
	include "setup.php";

	$my_pass=$_POST['pass'];

	if($my_pass==$admin_pass){
		echo("TRUE");
	}else{
		echo("FALSE");
	}
?>