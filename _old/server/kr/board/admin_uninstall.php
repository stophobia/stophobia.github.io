<?php
// 기본 클래스를 불러온다.
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 관리자인지 확인한다.
if($_SESSION['no'] != 1) $GR->error('관리자 화면은 관리자만 접근할 수 있습니다.', 1, 'CLOSE');

// 먼저 생성된 게시판 테이블과 코멘트 테이블들을 삭제한다.
$getDeleteTarget = @mysql_query('select id from '.$dbFIX.'board_list') or $GR->error('게시판 삭제목록을 가져오는데 실패했습니다.', 0, 'admin.php');

// 가져온 목록 순서대로 테이블들을 삭제한다.
while($deleteId = mysql_fetch_array($getDeleteTarget)) {
	$deleteID = $deleteId['id'];
	@mysql_query('drop table '.$dbFIX.'bbs_'.$deleteID);
	@mysql_query('drop table '.$dbFIX.'comment_'.$deleteID);
}

// 기본적으로 생성되는 테이블들도 삭제한다.
@mysql_query('drop table '.$dbFIX.'board_list');
@mysql_query('drop table '.$dbFIX.'member_list');
@mysql_query('drop table '.$dbFIX.'pds_save');
@mysql_query('drop table '.$dbFIX.'error_save');
@mysql_query('drop table '.$dbFIX.'memo_save');
@mysql_query('drop table '.$dbFIX.'trackback_save');
@mysql_query('drop table '.$dbFIX.'group_list');
@mysql_query('drop table '.$dbFIX.'poll_comment');
@mysql_query('drop table '.$dbFIX.'poll_option');
@mysql_query('drop table '.$dbFIX.'poll_subject');
@mysql_query('drop table '.$dbFIX.'time_bomb');
@mysql_query('drop table '.$dbFIX.'total_article');
@mysql_query('drop table '.$dbFIX.'total_comment');
@mysql_query('drop table '.$dbFIX.'member_group');
@mysql_query('drop table '.$dbFIX.'layout_config');
@mysql_query('drop table '.$dbFIX.'scrap_book');
@mysql_query('drop table '.$dbFIX.'report');
@mysql_query('drop table '.$dbFIX.'auto_save');
@mysql_query('drop table '.$dbFIX.'pds_extend');
@mysql_query('drop table '.$dbFIX.'tag_list');
@mysql_query('drop table '.$dbFIX.'article_option');
@mysql_query('drop table '.$dbFIX.'login_log');
@mysql_query('drop table '.$dbFIX.'pds_list');

// DB 접속 저장파일을 삭제한다.
@chmod('db_info.php', 0707);
@unlink('db_info.php') or $GR->error('DB 접속정보 파일(db_info.php)을 삭제하는데 실패했습니다.');

// 삭제되었음을 알리고 설치페이지로 이동한다.
$GR->error('GR Board 가 생성한 DB 자료들을 삭제했습니다.<br /><br />그 동안 사용해 주셔서 감사합니다.<br /><br />'.
	'완전한 삭제를 위해서는 GR Board 디렉토리를<br /><br />FTP로 접근하여 완전히 제거하셔야 합니다.'.
	'(재설치 사용자분을 위해 설치화면으로 이동 합니다.)', 0, 'install.php');
?>