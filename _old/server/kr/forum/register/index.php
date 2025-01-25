<?php
/**
 * GR Forum Register Page
 * @author sirini
 * @update 2009-08-05
 * @comment GR Board 내 회원등록 화면으로 이동한다.
 * @information 게시판 영역에 있다면 해당 게시판의 id 를 이용해서 이동하고
 *              포럼 영역에 있다면 등록된 게시판 아이디 중 하나를 선택해서 이동한다.
 */

// 코어 / 보드 연동
include '../core.php';
include '../' . $grcore . '/class/common.php';
$core = new Common('../' . $grcore);
$grboard = '../' . $core->config['grboard'];
$core->session($grboard . '/session');
$bbsID = $_GET['id'];

// 로그인 상태라면 리턴
if($_SESSION['no']) $core->alert('이미 로그인 되어 있습니다.');

// 회원등록 화면으로 이동
if($bbsID) $core->move($grboard . '/join.php?joinInBoard=1&boardId=' . $bbsID);	
else {
	$getBBS = $core->getData('select bbs_id from ' . $dbFIX . 'category where bbs_id != \'\' limit 1');
	if($getBBS['bbs_id']) $core->move($grboard . '/join.php?joinInBoard=1&boardId=' . $getBBS['bbs_id']);
	else $core->alert('GR Forum 관리화면에서 분류 관리를 통해 GR Board 게시판을 1개 이상 등록해야 합니다.');
}
?>