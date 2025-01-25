<?
$_GET[cateCode] = $_GET[cateCode] ? $_GET[cateCode] : "07";
setcookie("Aid",$_GET[cateCode],time()+60*60*24*30);
Header("Location:/");
//Header("Location:/?viewCode=".$_GET[viewCode]);
?>