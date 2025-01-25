<?php
	if($modifyTarget) {
		if(!$name) error('분류명을 입력해 주세요');
		$name = addslashes($name);
		@mysql_query("update ".$dbFIX."photo_category set name = '$name' where uid = '$modifyTarget'");
		error('분류명을 수정했습니다.', 'location.href=\'admin.php?admin=14\';');
	} elseif($addName) {
		$addName = addslashes($addName);
		@mysql_query("insert into ".$dbFIX."photo_category set uid = '', name = '$addName'");
		error('분류를 추가 했습니다.', 'location.href=\'admin.php?admin=14\';');
	} elseif($deleteTarget) {
		if($deleteTarget == 1) error('기본 분류는 삭제가 불가능 합니다.', 'location.href=\'admin.php?admin=14\';');
		@mysql_query("delete from {$dbFIX}photo_category where uid = $deleteTarget limit 1");
		@mysql_query("update {$dbFIX}photo set category = 1 where category = $deleteTarget");
		error('분류를 삭제 했습니다. 첫번째 분류로 이전 되었습니다.', 'location.href=\'admin.php?admin=14\';');
	}
?>