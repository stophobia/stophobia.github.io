<?
	include "setup.php";

	$my_pass=$_POST['pass'];
	$xml_doc=$_POST['xml_doc'];

	if($my_pass==$admin_pass){
		// FILE WRITE
		$fp=fopen("folder.php","w+");
		fwrite($fp,stripslashes($xml_doc));
		fclose($fp);
		echo("TRUE");
	}else{
		echo("FALSE");
	}
?>