<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";


	$que = "select * from odtProduct where code=parent_code and mainName like '%".$_GET['key']."%'";
	$res = mysql_query($que);
	$num = mysql_num_rows($res);

	if(!$num) exit;
?>

<script> 

	obj = parent.document.view.proList;
	obj.options.length = <?=$num?>;//셀렉트박스 옵션갯수지정
<?
$xxx=0;
while($row = mysql_fetch_array($res)) {
	if($row[code]) {
?>
	obj.options[<?=$xxx?>].value="<?=$row[code]?>";
  obj.options[<?=$xxx?>].text="<?=$row[mainName]?>";
<?
			$xxx++;
	}
}
?>

</script>