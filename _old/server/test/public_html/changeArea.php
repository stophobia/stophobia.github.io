<?
$_GET[Aid] = $_GET[Aid] ? $_GET[Aid] : "07";
setcookie("Aid",$_GET[Aid],time()+60*60*24*30);
Header("Location:/");
?>