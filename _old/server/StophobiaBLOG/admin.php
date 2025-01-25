<?php
// 초기화
include 'php_head.php';
if(!$_SESSION['no']) die('<script type="text/javascript"> location.href=\'./login.php\'; </script>');
define('__GRBLOG__', true);

// 필수 요소 부르기
include 'lib/common.php';
include 'lib/admin.php';
include 'lib/user.php';
include 'admin/admin_prepare.php';
$isMemberPerm = getPerm();
if($isMemberPerm) {
	if(!$_GET['admin']) $admin = 100;
	$member = getMemberInfo();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<link rel="stylesheet" href="<?php echo $grblog; ?>style.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $grblog; ?>css/admin_style.css" type="text/css" title="style" />
<title>GR Blog 관리자 화면 - v1.1.7.1 - 파랑새</title>
<script type="text/javascript" src="<?php echo $grblog; ?>js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $grblog; ?>js/effects.js"></script>
<script type="text/javascript" src="<?php echo $grblog; ?>js/dragdrop.js"></script>
<script type="text/javascript"> var GRBLOG = '<?php echo $grblog; ?>'; </script>
<?php 
// 글쓰기 화면
if($admin == 2 || $admin == 10) { include 'theme_config.php'; ?>
<style type="text/css"> @import url(<?php echo $grblog; ?>css/write_style.css); </style>
<script type="text/javascript" src="<?php echo $grblog; ?>tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">//<![CDATA[
var AUTOSAVE_TERM = <?php echo $conf_autosave_term; ?>; 
if(!AUTOSAVE_TERM) AUTOSAVE_TERM = 60;
//]]></script>
<script type="text/javascript" src="<?php echo $grblog; ?>js/write.js"></script>
<?php } 
// 링크 관리
elseif($admin == 3 || $admin == 17) { ?>
<style type="text/css"> @import url(<?php echo $grblog; ?>css/link_style.css); </style>
<script type="text/javascript" src="<?php echo $grblog; ?>js/link.js"></script>
<?php } 
// 글 관리
elseif($admin == 4 || $admin == 13 || $admin == 14 || $admin == 19) { ?>
<style type="text/css"> @import url(<?php echo $grblog; ?>css/post_style.css); </style>
<script type="text/javascript" src="<?php echo $grblog; ?>js/post.js"></script>
<?php } 
// 댓글 관리
elseif($admin == 5) { ?>
<style type="text/css"> @import url(<?php echo $grblog; ?>css/comment_style.css); </style>
<script type="text/javascript" src="<?php echo $grblog; ?>js/comment.js"></script>
<?php } 
// 트랙백 관리
elseif($admin == 6) { ?>
<style type="text/css"> @import url(<?php echo $grblog; ?>css/trackback_style.css); </style>
<script type="text/javascript" src="<?php echo $grblog; ?>js/trackback.js"></script>
<?php } 
// 등록된 사용자 관리
elseif($admin == 15) { ?>
<style type="text/css"> @import url(<?php echo $grblog; ?>css/user_style.css); </style>
<script type="text/javascript" src="<?php echo $grblog; ?>js/user.js"></script>
<?php } 
// 대쉬보드
elseif($admin == 20) { ?>
<script type="text/javascript" src="<?php echo $grblog; ?>js/dashboard.js"></script>
<?php } 
// 기본 or 설치
else { ?>
<script type="text/javascript" src="<?php echo $grblog; ?>js/install.js"></script>
<?php } ?>
<script type="text/javascript">//<![CDATA[
function deleteBlog()
{
	if(confirm('정말로 블로그를 삭제(Uninstall) 하시겠습니까?\n\n'+
		'GR블로그가 사용중인 데이터들이 모두 삭제되고 블로그가 초기화 됩니다.\n\n계속 삭제를 진행하시겠습니까?'))
	{
		if(confirm('GR블로그가 사용중인 모든 데이터를 삭제하고 블로그를 초기화 합니다.\n\n동의하십니까?'))
			location.href='<?php echo $grblog; ?>admin.php?admin=8&deleteBlog=yes';
	}
}
//]]></script>
</head>
<body>

<!-- 관리자 화면 상단 -->
<div id="adminTop">
<a href="<?php echo $grblog; ?>admin.php?admin=20&amp;inView=adminBox"><img src="<?php echo $grblog; ?>image/darkgray/top.configuration.logo.gif" alt="GR Blog Configuration" /></a>
</div>
<!--# 관리자 화면 상단 -->

<!-- 가운데정렬 -->
<div id="center">

<!-- 관리화면 메뉴 -->
<div id="adminMenu">
	<div class="boxTitle">관리메뉴</div>
	<?php if(!$isMemberPerm || $isMemberPerm > 1) { ?>
		<div class="<?php echo btn($admin, 2); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=2" title="새로운 글을 작성 합니다."><img src="<?php echo $grblog; ?>image/icon_new_post.gif" alt="" /> 새글 작성</a></div>
	<?php } if(!$isMemberPerm || $isMemberPerm > 2) { ?>
		<div class="<?php echo btn($admin, 3); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=3" title="블로그 페이지에 즐겨찾기용 링크를 걸어둡니다."><img src="<?php echo $grblog; ?>image/icon_link_admin.gif" alt="" /> 링크 설정</a></div>
		<div id="photoBoxTitle" class="n" onclick="tg('photoBox');" title="사진첩 설정 / 사진 올리기 / 사진 관리 / 사진 분류"><img src="<?php echo $grblog; ?>image/icon_camera_all.gif" alt="" /> 포토로그</div>
		<div id="photoBox" style="display: none">
			<div class="<?php echo btn($admin, 9); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=9&amp;inView=photoBox" title="사진첩을 설정 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_camera_setup.gif" alt="" /> 사진첩 설정</a></div>
			<div class="<?php echo btn($admin, 10); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=10&amp;inView=photoBox" title="사진(그림)을 업로드 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_camera_write.gif" alt="" /> 사진 올리기</a></div>
		<?php } if(!$isMemberPerm || $isMemberPerm > 3) { ?>
			<div class="<?php echo btn($admin, 13); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=13&amp;inView=photoBox" title="올린 사진들을 관리 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_camera_admin.gif" alt="" /> 사진 관리</a></div>
			<div class="<?php echo btn($admin, 14); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=14&amp;inView=photoBox" title="올린 사진들을 분류 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_camera_category.gif" alt="" /> 사진 분류</a></div>
		</div>
		<div id="textBoxTitle" class="n" onclick="tg('textBox');" title="코멘트 관리 / 트랙백 관리 / 포스트 관리"><img src="<?php echo $grblog; ?>image/icon_reply_trackback_all.gif" alt="" /> 글관리</div>
		<div id="textBox" style="display: none">
			<div class="<?php echo btn($admin, 5); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=5&amp;inView=textBox" title="방문객들의 코멘트(댓글)을 관리 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_comment_admin.gif" alt="" /> 코멘트 관리</a></div>
			<div class="<?php echo btn($admin, 6); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=6&amp;inView=textBox" title="다른 블로거들이 걸어준 트랙백(엮인글)을 관리 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_trackback_admin.gif" alt="" /> 트랙백 관리</a></div>
		<?php } if(!$isMemberPerm || $isMemberPerm > 4) { ?>
			<div class="<?php echo btn($admin, 4); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=4&amp;inView=textBox" title="올려둔 글들을 관리 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_post_admin.gif" alt="" /> 포스트 관리</a></div>
		</div>
	<?php } if(!$isMemberPerm) { ?>
		<div id="adminBoxTitle" class="n" onclick="tg('adminBox');" title="전체 설정 / 테마 설정 / 테마 수정 / 멤버 관리 / DB 백업하기 / 삭제하기"><img src="<?php echo $grblog; ?>image/icon_admin_all.gif" alt="" /> 관리자 전용</div>
		<div id="adminBox" style="display: none">
			<div class="<?php echo btn($admin, 20); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=20&amp;inView=adminBox" title="블로그의 전체 현황에 대해 확인합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_dashboard_admin.gif" alt="" /> 대쉬 보드</a></div>
			<div class="<?php echo btn($admin, 1); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=1&amp;inView=adminBox" title="블로그의 전체적인 옵션들을 설정 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_total_setup.gif" alt="" /> 전체 설정</a></div>
			<div class="<?php echo btn($admin, 12); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=12&amp;inView=adminBox" title="블로그의 테마(스킨)을 설정하거나 세부적인 설정을 변경 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_theme_admin.gif" alt="" /> 테마/세부 설정</a></div>
			<div class="<?php echo btn($admin, 16); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=16&amp;inView=adminBox" title="블로그의 테마(스킨)을 웹에서 직접 수정 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_theme_modify.gif" alt="" /> 테마 수정</a></div>
			<div class="<?php echo btn($admin, 15); ?>"><a href="<?php echo $grblog; ?>admin.php?admin=15&amp;inView=adminBox" title="이 블로그에 등록한 사용자(멤버)들을 관리 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_user_group.gif" alt="" /> 멤버 관리</a></div>
			<div class="n"><a href="<?php echo $grblog; ?>admin.php?admin=11" title="GR블로그가 사용중인 DB를 백업 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_db_save.gif" alt="" /> DB 백업하기</a></div>	
			<div class="n"><a href="#" onclick="deleteBlog();" title="GR블로그를 삭제 합니다."><img src="<?php echo $grblog; ?>image/icon_sub_arrow.gif" alt="" /> <img src="<?php echo $grblog; ?>image/icon_delete_blog.gif" alt="" /> 삭제하기</a></div>
		</div>
		<div class="<?php echo ($admin == 18)?'m':'n'; ?>"><a href="<?php echo $grblog; ?>admin.php?admin=18" title="모노로그와 관련된 설정을 합니다."><img src="<?php echo $grblog; ?>image/icon_mono_admin.gif" alt="" /> 모노로그</a></div>
		<div class="<?php echo ($admin == 19)?'m':'n'; ?>"><a href="<?php echo $grblog; ?>admin.php?admin=19" title="댓글 알리미를 열어 봅니다."><img src="<?php echo $grblog; ?>image/icon_reply_notify_admin.gif" alt="" /> 댓글알리미</a></div>
	<?php } ?>
	<div class="<?php echo ($admin == 17)?'m':'n'; ?>"><a href="<?php echo $grblog; ?>admin.php?admin=17" title="등록한 이웃 블로그의 RSS를 보면서 새로 올라온 글들을 확인 합니다."><img src="<?php echo $grblog; ?>image/icon_get_rss.gif" alt="" /> RSS보기</a></div>
	<div class="n"><a href="<?php echo $grblog; ?>admin.php?admin=7" title="로그아웃(logout) 합니다."><img src="<?php echo $grblog; ?>image/icon_logout.gif" alt="" /> 로그아웃</a></div>
	<div class="n"><a href="<?php echo $grblog; ?>" title="블로그 첫화면으로 돌아 갑니다."><img src="<?php echo $grblog; ?>image/icon_home.gif" alt="" /> 블로그로 돌아가기</a></div>
	<div><img src="<?php echo $grblog; ?>image/darkgray/bottom.adminPanel.background.gif" alt="" /></div>
	<div class="clr"></div>
</div>
<!--# 관리화면 메뉴 -->

<!-- 항목 별 제어화면 -->
<div id="adminControl">
<?php
switch($admin)
{
	case 1: if(!$isMemberPerm || $isMemberPerm > 4) include 'admin/admin_all.php'; break;
	case 2: if(!$isMemberPerm || $isMemberPerm > 1) include 'admin/admin_write.php'; break;
	case 3: if(!$isMemberPerm || $isMemberPerm > 2) include 'admin/admin_link.php'; break;
	case 4: if(!$isMemberPerm || $isMemberPerm > 4) include 'admin/admin_post.php'; break;
	case 5: if(!$isMemberPerm || $isMemberPerm > 3) include 'admin/admin_comment.php'; break;
	case 6: if(!$isMemberPerm || $isMemberPerm > 3) include 'admin/admin_trackback.php'; break;
	case 9: if(!$isMemberPerm || $isMemberPerm > 2) include 'admin/admin_photo.php'; break;
	case 10: if(!$isMemberPerm || $isMemberPerm > 2) include 'admin/admin_write_photo.php'; break;
	case 12: if(!$isMemberPerm || $isMemberPerm > 4) include 'admin/admin_theme.php'; break;
	case 13: if(!$isMemberPerm || $isMemberPerm > 3) include 'admin/admin_photo_list.php'; break;
	case 14: if(!$isMemberPerm || $isMemberPerm > 3) include 'admin/admin_photo_category.php'; break;
	case 15: if(!$isMemberPerm) include 'admin/admin_user.php'; break;
	case 16: if(!$isMemberPerm) include 'admin/admin_theme_modify.php'; break;
	case 17: include 'admin/admin_rss_reader.php'; break;
	case 18: if(!$isMemberPerm) include 'admin/admin_monolog.php'; break;
	case 19: if(!$isMemberPerm) include 'admin/admin_reply_notify.php'; break;
	case 20: if(!$isMemberPerm) include 'admin/admin_dashboard.php'; break;
	case 100: if($isMemberPerm) include 'admin/admin_member_all.php'; break;
	default: include 'admin/admin_dashboard.php'; break;
}
?>
</div>
<!--# 항목 별 제어화면 -->

<div class="clr"></div>

</div><!--# 가운데 정렬 -->
<script type="text/javascript">//<![CDATA[
function tg(t)
{
	if($(t).style.display == '') {
		$(t+'Title').style.fontWeight = 'normal';
		$(t+'Title').style.cursor = 'pointer';
		Effect.Fade(t);
	}
	else {
		$(t+'Title').style.fontWeight = 'bold';
		$(t+'Title').style.color = '#2777fb';
		Effect.Appear(t);
	}
}
<?php if($_GET['inView']) echo 'tg(\''.$_GET['inView'].'\');'; ?>
new Draggable('adminMenu', {revert:false});
<?php if($admin != 2 && $admin != 10 && $admin != 17) { ?>
new Draggable('adminControl', {revert:false});
<?php } ?>
//]]></script>

</body>
</html>