<?php
// 기본 클래스를 부른다
include 'class/common.php';
$GR = new COMMON;

// 로그인 상태가 아니면 에러
if(!$_SESSION['no']) $GR->error('로그인한 사용자만 게시물을 신고 하실 수 있습니다.', 0, 'CLOSE');

// DB 에 연결한다.
$GR->dbConn();
$getReport = @mysql_fetch_array(mysql_query('select var from '.$dbFIX.'layout_config where opt = \'report_skin\' limit 1'));
if(!$getReport['var']) $getReport['var'] = 'default';

// 이미 신고된 게시물은 처리하지 않음
$isExist = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'report where id = \''.$_GET['id'].'\' and article_num = '.$_GET['article_num']));
if($isExist['no']) $GR->error('이미 신고된 게시물입니다.', 0, 'CLOSE');

// 신고 추가하기 처리
if($_POST['addReport']) {
	@mysql_query("insert into {$dbFIX}report set no = '', id = '".$_POST['id']."', article_num = ".$_POST['article_num'].", reporter = ".(($_SESSION['no'])?$_SESSION['no']:0).
		", reason = '".addslashes($_POST['reason'])."', status = 0");
	$getMaster = @mysql_fetch_array(mysql_query('select master from '.$dbFIX.'board_list where id = \''.$_POST['id'].'\''));
	$masterArr = @explode('|', $getMaster['master']);
	$cntMaster = @count($masterArr)+1;
	$content = $_POST['id'].'게시판의 '.$_POST['article_num'].'번째 게시물의 신고가 접수되었습니다.'."\n\n".'사유: '.$_POST['reason']."\n\n".'<a href="board.php?id='.
		$_POST['id'].'&amp;articleNo='.$_POST['article_num'].'" onclick="window.open(this.href, \'_blank\'); return false">[새창으로 확인하기]</a>';
	$content = addslashes($content);
	for($i=0; $i<$cntMaster; $i++) {
		$getMemberNo = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'member_list where id = \''.$masterArr[$i].'\''));
		@mysql_query("insert into {$dbFIX}memo_save set no = '', member_key = '".$getMemberNo['no']."', sender_key = '".(($_SESSION['no'])?$_SESSION['no']:0)."', ".
			"subject = '[신고] 게시물의 신고가 접수 되었습니다.', content = '$content', signdate = '".$GR->grTime()."', is_view = '0'");
	}
	@mysql_query("insert into {$dbFIX}memo_save set no = '', member_key = '1', sender_key = '".(($_SESSION['no'])?$_SESSION['no']:0)."', ".
		"subject = '[신고] 게시물의 신고가 접수 되었습니다.', content = '$content', signdate = '".$GR->grTime()."', is_view = '0'");
	$GR->error('이 게시물을 관리자와 마스터에게 신고하였습니다.', 0, 'CLOSE');
}

// 페이징처리
$page = $_GET['page'];
if(!$page or $page < 0) $page = 1;
$fromRecord = ($page - 1) * 10;

// 문서설정
$title = 'GR Board Send Report';
$encoding = 'utf-8';
include 'html_head.php';

// 신고함 스킨 부르기
include 'admin/theme/report/'.$getReport['var'].'/report.php';
?>

<script type="text/javascript">//<![CDATA[
function deleteScrap(no) {
	if(confirm('선택한 스크랩을 정말로 삭제하시겠습니까?\n\n'+
		'삭제된 스크랩은 다시 복구할 수 없습니다.')) {
		location.href='view_scrap.php?deleteTarget='+no;
	}
}
//]]></script>

</body>
</html>
