<?php
// 게시판 아이디가 없다면 index.php 로 이동
if(!$_GET['id']) @header('location: ./index.php');
else $id = $_GET['id'];

// 코어 / 보드 / 포럼 연동
include '../core.php';
include '../' . $grcore . '/class/common.php';
include '../class/grforum.lib.php';
$core = new Common('../' . $grcore);
$grboard = '../' . $core->config['grboard'];
$forum = new Forum($core, $dbFIX, $bbsFIX, $grboard);
$core->session($grboard . '/session');
define('__GRFORUM__', true);

// 기본 설정
if($_GET['page']) $page = $_GET['page']; else $page = 1;
if($_GET['no']) $no = $_GET['no']; else $no = 1;
$latestNo = $core->getData('select max(no) from '.$bbsFIX.'bbs_'.$id);
$bbsInfo = $core->getData('select * from '.$dbFIX.'category where bbs_id = \''.$id.'\'');
$papa = $core->getData('select name from '.$dbFIX.'category where uid = '.$bbsInfo['parent']);
$view = $core->getData('select * from '.$bbsFIX.'bbs_'.$id.' where is_secret = 0 and no = '.$no);
$fileOrigin = $core->getData('select * from '.$bbsFIX.'pds_save where id = \''.$id.'\' and article_num = '.$no);
$fileExtend = $core->query('select * from '.$bbsFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$no);
$comments = $core->query('select * from '.$bbsFIX.'comment_'.$id.' where is_secret = 0 and board_no = '.$no);

// 조회수를 올린다.
if(!eregi('gr_hit_'.$no, $_SESSION['hit']))
{
	$core->query('update '.$bbsFIX.'bbs_'.$id.' set hit = hit + 1 where no = '.$no);
	$_SESSION['hit'] = $_SESSION['hit'].',gr_hit_'.$articleNo;
}

// 스킨 부르기
$theme = 'theme/iphone'; # 안정화 전까진 iphone 테마로 고정
$setting = $forum->getView();
include $theme.'/head.php';
include $theme.'/read.php';
include $theme.'/foot.php';
?>