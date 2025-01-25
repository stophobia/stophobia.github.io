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
if($_GET['numList']) $numList = $_GET['numList']; else $numList = 10;
if($_GET['orderBy']) $orderBy = $_GET['orderBy']; else $orderBy = 'no';
if($_GET['desc']) $desc = $_GET['desc']; else $desc = 'desc';
$from = ($page - 1) * $numList;
$latestNo = $core->getData('select max(no) from '.$bbsFIX.'bbs_'.$id);
$bbsInfo = $core->getData('select * from '.$dbFIX.'category where bbs_id = \''.$id.'\'');
$papa = $core->getData('select name from '.$dbFIX.'category where uid = '.$bbsInfo['parent']);
$totalPost = end($core->getData('select count(*) from '.$bbsFIX.'bbs_'.$id));
$totalPage = floor($totalPost / $numList);
$upper = ($latestNo[0] + 500) - ($numList * $page);
$lower = ($latestNo[0] - 500) - ($numList * $page);
$list = $core->query('select * from '.$bbsFIX.'bbs_'.$id.' where no < '.$upper.' and no > '.$lower.' order by '.$orderBy.' '.$desc.' limit '.$from.', '.$numList);

// 스킨 부르기
$theme = 'theme/iphone'; # 안정화 전까진 iphone 테마로 고정
$setting = $forum->getView();
include $theme.'/head.php';
include $theme.'/bbs.php';
include $theme.'/foot.php';
?>