<?php
	if(!$isChangeCategory && isset($deleteTargets)) {
		$targetNum = count($deleteTargets);
		for($i=0; $i<$targetNum; $i++) {
			$files = @mysql_fetch_array(mysql_query("select file_route from ".$dbFIX."photo where uid = '".$deleteTargets[$i]."'"));
			@mysql_query("delete from ".$dbFIX."photo where uid = '".$deleteTargets[$i]."'");
			@mysql_query("delete from ".$dbFIX."photo_comment where photo_uid = '".$deleteTargets[$i]."'");
			@unlink($files[0]);
		}
		move('admin.php?admin=13&page='.$nowPage.'&originDivision='.$nowOriginDivision.'&division='.$nowDivision);
	}
	elseif($isChangeCategory)
	{
		$changeCount = count($deleteTargets);
		$changeNo = $isChangeCategory;
		for($i=0; $i<$changeCount; $i++) {
			@mysql_fetch_array(mysql_query('update '.$dbFIX.'photo set category = '.$changeNo.' where uid = '.$deleteTargets[$i]));
		}
		move('admin.php?admin=13&page='.$nowPage.'&originDivision='.$nowOriginDivision.'&division='.$nowDivision);
	}
?>