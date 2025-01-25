<?
	include "setup.php";

	$my_pass=$_POST['pass'];
	$my_fileName=$_POST['fileName'];

	if($my_pass==$admin_pass){
		unlink("../".$my_fileName.".jpg");
		unlink("../".$my_fileName."_thumb.jpg");
		echo("TRUE");
	}else{
		echo("FALSE");
	}
?>