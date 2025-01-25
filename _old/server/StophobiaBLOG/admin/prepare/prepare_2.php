<?php
	if(isset($modifyTarget))
		$modify = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'post where uid = '.$modifyTarget));
		$modify['content'] = stripslashes($modify['content']);
	
	// 카테고리 선택옵션 호출기
	function getCategoryOption($node=0, $depth=0) {
		global $dbFIX;
		static $uidStack = array();
		if($node) $sql = ' where id = '.$node.' and depth != '.$depth; else $sql = '';
		$getCategory = @mysql_query('select * from '.$dbFIX.'category'.$sql.' order by uid asc, id asc');
		while($cat = mysql_fetch_array($getCategory)) {
			if(!in_array($cat['uid'], $uidStack, true)) array_push($uidStack, $cat['uid']);
			else continue;
			echo '<option value="'.$cat['uid'].'.'.$cat['id'].'.'.$cat['depth'].'">'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $cat['depth']).' '.stripslashes($cat['name']).'</option>';
			$getChild = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'category where id = '.$cat['uid'].' and depth != '.$cat['depth'].' limit 1'));
			if($getChild['uid']) getCategoryOption($cat['uid'], $cat['depth']);
		}
	}

	// 카테고리 목록출력 호출기
	function getCategoryList($node=0, $depth=0) {
		global $dbFIX;
		static $uidStack = array();
		if($node) $sql = ' where id = '.$node.' and depth != '.$depth; else $sql = '';
		$getCategory = @mysql_query('select * from '.$dbFIX.'category'.$sql.' order by uid asc, id asc');
		while($cat = mysql_fetch_array($getCategory)) {
			if(!in_array($cat['uid'], $uidStack, true)) array_push($uidStack, $cat['uid']);
			else continue;
			echo '<li>'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $cat['depth']).' '.$cat['name'].' <span onclick="delCategory(\''.stripslashes($cat['name']).'\');" title="이 카테고리를 삭제하기">ⓧ</span></li>';
			$getChild = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'category where id = '.$cat['uid'].' and depth != '.$cat['depth'].' limit 1'));
			if($getChild['uid']) getCategoryList($cat['uid'], $cat['depth']);
		}
	}
?>