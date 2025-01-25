<?php
/**
 * iPhone, OMNIA 등의 스마트폰에서 보여지는 GR blog 페이지 정의
 * 테마: grblog/m/theme/
 * 글작성: grblog/m/write/
 * 관리자: grblog/m/admin/
 */

// 초기화 설정
@header('Content-Type: text/html; charset=utf-8');
include '../lib/common.php';
if(!file_exists('../db_info.php')) exit();
include '../php_head.php';
@extract($_POST);
define('__GRBLOG__', true);
dbConn('../');

// 댓글 입력시 처리
if($simpleGRBlogKey) include 'comment.write.ok.php';

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
$absPath = 'http://'.$_SERVER['HTTP_HOST'].$grblog.'/m';
$blogInfo = stripslashes($config['blog_info']);

// 브라우저 상단 제목표시줄 표기
$blogTitle = stripslashes($config['blog_title']);
$browserTitle = $blogTitle.' - ';

// 기본 테마 정의 (안정화 전까지는 basic 으로 강제 고정)
$theme = 'theme/basic';
include $theme.'/index.php';
?>