<?php
// 세션과 DB연결
include 'php_head.php';
include 'db_info.php';

// 제목, 내용 처리
$original = array('@amp;', '@plus;', '@percent;', '@sharp;', '@question;', '@equal;');
$change = array('&', '+', '%', '#', '?', '=');
$subject = str_replace($original, $change, addslashes($_POST['subject']));
$content = str_replace($original, $change, addslashes($_POST['content']));
$time = time();

// 멤버일 시 임시 저장 처리
if($_SESSION['no']) {
	$getExist = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'auto_save where member_key = '.$_SESSION['no']));
	if(!$getExist['no']) $sql = "insert into {$dbFIX}auto_save set no = '', member_key = '".$_SESSION['no']."', subject = '$subject', content = '$content', signdate = '$time'";
	else $sql = "update {$dbFIX}auto_save set subject = '$subject', content = '$content', signdate = '$time' where member_key = ".$_SESSION['no'];
	@mysql_query($sql);

// 일반 사용자일 경우 쿠키로 처리
} else {
	@setcookie('grSubject', $subject, $time+3600);
	@setcookie('grContent', $content, $time+3600);
	@setcookie('grDate', $time, $time+3600);
}
?>