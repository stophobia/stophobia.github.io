<?php
/**
 * @update 2009-02-06
 * @comment 관리화면 > 멤버정보수정
 */
@session_save_path('../session');
@session_start();
if($_SESSION['userNo'] != 1) exit();

include '../library/admin.lib.php';
$A = new Admin('../');
@extract($_POST);

// 멤버 수정 (수정 실패시 1 리턴)
if($A->isAdmin()) {
	$sql = "update {$A->divide}users set ";
	if($password) $sql .= "password = '".md5($password)."', ";
	$sql .= "nickname = '$nickname', email = '$email', homepage = '$homepage', level = '$level', point = '$point', self_info = '$selfInfo' where uid = $modifyUid";
	$result = @mysql_query($sql);
	if(!$result) {
		@header('Content-Type: text/xml; charset=utf-8');
		echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
		exit();
	}

	// 최종 작업 결과 리턴 (여기까지 왔다면 0)
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
}
?>