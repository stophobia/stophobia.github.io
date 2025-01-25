<?php
// 기본 클래스를 부른다
include 'class/common.php';
$GR = new COMMON;

// 로그인 상태가 아니면 에러
if(!$_SESSION['no']) $GR->error('멤버만이 자신의 쪽지함을 열어볼 수 있습니다. 로그인 해 주세요.', 0, 'CLOSE');

// 변수 처리 (XSS 방지 by KISA)
if($_GET['action'] && preg_match("/[^0-9]/i", $_GET['action'])) exit();
if($_GET['viewMemoNo'] && preg_match("/[^0-9]/i", $_GET['viewMemoNo'])) exit();
$viewNo = $_GET['viewMemoNo'];
if($_SESSION['no']) $sessionNo = $_SESSION['no']; else $sessionNo = 0;
if(!$_GET['action']) $action = 1; else $action = $_GET['action'];

// DB 에 연결한다.
$GR->dbConn();

// 쪽지를 삭제했을 경우 처리하고 새로 고침
if($_GET['deleteMemoNo']) {
	$deleteNo = $_GET['deleteMemoNo'];
	$getMemo = @mysql_fetch_array(mysql_query('select member_key, sender_key, is_view from '.$dbFIX.'memo_save where no = '.$deleteNo));
	if($getMemo['sender_key'] == $_SESSION['no'] && $getMemo['member_key'] != $_SESSION['no'] && $getMemo['is_view']) {
		$GR->error('상대방이 이미 열람한 쪽지는 삭제할 수 없습니다.', 0, 'view_memo.php');
	}
	if($is_view=='1') {
		$GR->error('이미 열람한 쪽지는 삭제할 수 없습니다.', 0, 'view_memo.php');
	}
	@mysql_query('delete from '.$dbFIX.'memo_save where no = '.$deleteNo);
	$GR->error('쪽지를 삭제했습니다.', 0, 'view_memo.php');
}

// 선택한 쪽지들을 삭제처리
$ignore = 0;
if($_POST['delTargets'][0]) {
	$delCnt = @count($_POST['delTargets']);
	for($dm=0; $dm<$delCnt; $dm++) {
		$getMemo = @mysql_fetch_array(mysql_query('select member_key, sender_key, is_view from '.$dbFIX.'memo_save where no = '.$_POST['delTargets'][$dm]));
		if($getMemo['sender_key'] == $_SESSION['no'] && $getMemo['member_key'] != $_SESSION['no'] && $getMemo['is_view']) {
			++$ignore;
			continue;
		}
		@mysql_query('delete from '.$dbFIX.'memo_save where no = '.$_POST['delTargets'][$dm]);
	}
	$GR->error('상대방이 확인한 '.$ignore.'개 쪽지를 제외한<br /><br />쪽지들을 모두 삭제하였습니다.', 0, 'view_memo.php');
}

// 페이징처리
$page = $_GET['page'];
if(!$page or $page < 0) $page = 1;
$fromRecord = ($page - 1) * 10;

// 문서설정
$getMemo = @mysql_fetch_array(mysql_query('select var from '.$dbFIX.'layout_config where opt = \'memo_skin\' limit 1'));
if(!$getMemo['var']) $getMemo['var'] = 'default';
$title = 'GR Board View Memo Page';
$encoding = 'utf-8';
include 'html_head.php';

// 쪽지함 스킨 부르기
include 'admin/theme/memo/'.$getMemo['var'].'/memo.php';
?>

<script type="text/javascript">//<![CDATA[
function deleteMemo(no) {
	if(confirm('선택한 쪽지를 정말로 삭제하시겠습니까?\n\n'+
		'삭제된 쪽지는 다시 복구할 수 없습니다.')) {
		location.href='view_memo.php?deleteMemoNo='+no;
	}
}

function adjustMemo() {
	if(!confirm('선택하신 쪽지들을 정말로 삭제하시겠습니까?\n\n'+
		'삭제된 쪽지는 다시 복구할 수 없습니다.')) {
		return;
	}
	var i, isChecked=0, f = document.forms['list'];
	for(i=0; i<f.length; i++) {
		if(f[i].type=='checkbox') if(f[i].checked) isChecked++;
	}
	if(!isChecked) alert('삭제할 쪽지를 하나 이상 선택해 주세요.');
	else f.submit();
}

function selectAll() {
	var j, f = document.forms['list'];
	for(j=0; j<f.length; j++) if(f[j].type=='checkbox') f[j].checked = !f[j].checked;
}
//]]></script>

</body>
</html>
