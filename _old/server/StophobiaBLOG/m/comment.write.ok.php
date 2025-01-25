<?php
// 간단한 매칭키 대조
if($simpleGRBlogKey != md5('GRBlog'.$_SERVER['HTTP_HOST'].date('YmdH'))) exit();

// 입력값 검사
if(!trim($name)) error('이름을 입력해 주세요~');
if(!trim($content)) error('댓글을 작성해 주세요~');
if($homepage == 'http://') $homepage = '';
if(!preg_match("/[가-힣]/uism", $content)) error('한글이 포함되어 있지 않아 외국 스팸글로 간주되었습니다.');

// DB에 입력
$content = addslashes(htmlspecialchars($content));
$que = 'insert into '.$dbFIX."comment set uid = '', family_uid = '0', post_uid = '$post_uid', ".
		"is_secret = '$is_secret', is_reply = '$is_reply', name = '".htmlspecialchars($name)."', ".
		"password = '".md5(time())."', email = '$email', homepage = '$homepage', ip = '".$_SERVER['REMOTE_ADDR']."', ".
		"signdate = '".time()."', content = '".$content."', writer = '".$name."'";
@mysql_query($que) or error('댓글을 남기지 못했습니다.');

// DB에 관련 값들 업데이트 작업
$isGuest = '1';
$insertUid = @mysql_insert_id();
@mysql_query('update '.$dbFIX."comment set family_uid = '$insertUid' where uid = '$insertUid'");
@mysql_query('update '.$dbFIX."post set comment_count = comment_count + 1 where uid = '$post_uid'");
$isGuest = ($_SESSION['no']) ? '' : '.guest';
if(@file_exists('../cache/'.$post_uid.$isGuest.'.html')) @unlink('../cache/'.$post_uid.$isGuest.'.html');
if(@file_exists('../cache/page.'.(($page)?$page:1).$isGuest.'.html')) @unlink('../cache/page.'.(($page)?$page:1).$isGuest.'.html');

die('<script type="text/javascript"> alert(\'댓글을 입력하였습니다.\'); location.href = \'./?p='.$p.'&page='.$page.'\'; </script>');
?>