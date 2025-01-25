<?php
// 초기화 설정
include 'lib/common.php';
if(!file_exists('db_info.php')) move('install.php');
include 'php_head.php';
include 'theme_config.php';
@extract($_POST);
define('__GRBLOG__', true);

// GR Counter 연동시 처리
if($conf_grcounter) { $grcount = $conf_grcounter_path; $grid = $conf_grcounter_id; include $grcount.'grcounter.php'; }

// 2차 도메인 & 현재 접속자 & 댓글알리미 처리
dbConn();
$adrArr = @explode('.', $_SERVER['HTTP_HOST']);
if('/'.$adrArr[0].'/' == $grblog) move('http://'.$adrArr[1].'.'.$adrArr[2].$grblog.'?p='.$_GET['p']);
if($conf_nowConnect) setNowVisit();
if($_POST['url'] || $_POST['postTitle']) include 'catch_reply_notify.php';

// 변수처리
if($_GET['page']) $page = $_GET['page']; elseif(!$page) $page = 1;
if($_GET['p']) $p = $_GET['p'];
if($_GET['tag']) $t = addslashes(urldecode($_GET['tag'])); else $t = '';
if($_GET['cat']) $cat = $_GET['cat']; else $cat = '';
if($_GET['ds']) $ds = $_GET['ds']; else $ds = 0;
if($_GET['dl']) $dl = $_GET['dl']; else $dl = 0;
if($_GET['replyTo']) $replyTo = $_GET['replyTo'];
if($_GET['so']) $so = $_GET['so'];
if($_GET['st']) $st = urldecode($_GET['st']);
if($_GET['deleteCoUid']) $deleteCoUid = $_GET['deleteCoUid'];
if($_GET['chooseAuth']) $chooseAuth = $_GET['chooseAuth'];
if($_GET['post_uid']) $post_uid = $_GET['post_uid'];
if($_GET['division']) $division = $_GET['division'];
if($_GET['originDivision']) $originDivision = $_GET['originDivision'];
if($_GET['sortCategory']) {
	$getCatUid = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'category where name = \''.$_GET['sortCategory'].'\''));
	$cat = $getCatUid['uid'];
}

// 설정 가져오기
$config = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'config where uid = \'1\''));
$theme = 'theme/'.$config['theme'];
$absPath = 'http://'.$_SERVER['HTTP_HOST'].$grblog;
$blogInfo = stripslashes($config['blog_info']);

// 코멘트 삭제 처리 - 일반 or 오픈아이디
if($coPass) include 'comment_delete_proc.php';
if($deleteCoUid && $_SESSION['openID']) include 'comment_delete_openid_proc.php';

// 코멘트 작성완료일 때
if(($commentSubmit && $config['use_comment']) || ($_GET['openid_mode'] == 'id_res' && !$_SESSION['openID'])) include 'insert_comment.php';

// 스팸방지용 새 코드
if(!$_SESSION['no'] && !$commentSubmit && $conf_antiSpam) $_SESSION['antiSpam'] = substr(md5('grblogAntiSpam'.time()), -4);

// 댓글달기 일때
if($replyTo) include 'prepare_to_reply.php'; else $replyOriginal = '';

// 브라우저 상단 제목표시줄 표기
$blogTitle = stripslashes($config['blog_title']);
$browserTitle = $blogTitle.' - ';

// 게시물 보기일 시
if($p) include 'read_post.php';
elseif($cat) include 'category_list.php';
else include 'loop_post.php';
?>