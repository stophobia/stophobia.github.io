<?php
$prefix = '../';
include '../php_head.php';
if(!$_SESSION['no']) exit();

@header('Content-Type: text/html; charset=utf-8');
if(array_key_exists('uid', $_GET) && $_GET['uid']) $uid = $_GET['uid']; else exit();
include $prefix.'lib/common.php';
dbConn($prefix);
@extract($_POST);
if(array_key_exists('modifyTarget', $_POST) && $_POST['modifyTarget'])
{
	if(!trim($name)) error('이름을 입력해 주세요');
	if(!trim($content)) error('내용을 입력해 주세요');
	$content = str_replace('<p>', '', str_replace('</p>', '', str_replace('<p>&nbsp;</p>', '', $content)));
	$que = "update ".$dbFIX."comment set is_secret = '$is_secret', name = '".htmlspecialchars($name)."', email = '$email', homepage = '$homepage', ".
		"content = '".$content."' where uid = '$modifyTarget'";
	@mysql_query($que);
	move('admin_modify_comment.php?uid='.$modifyTarget);
}
$m = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'comment where uid = '.$uid));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<title>GR Blog 코멘트(댓글) 수정하기</title>
<link rel="stylesheet" href="../css/modify_style.css" type="text/css" title="style" />
<script type="text/javascript">//<![CDATA[
function modify()
{
	tinyMCE.triggerSave();
	t = document.forms['modifyComment'];
	if(!t.elements['name'].value) {
		alert('이름을 입력해 주세요');
		t.elements['name'].focus();
		return false;
	}
	if(!t.elements['content'].value) {
		alert('내용을 입력해 주세요');
		t.elements['content'].focus();
		return false;
	}
	return true;
}
//]]></script>
</head>
<body>

<div id="top">
댓글 수정하기
</div>

<div id="mc">
<form id="modifyComment" method="post" onsubmit="return modify();" action="<?php echo $_SERVER['PHP_SELF']; ?>?uid=<?php echo $m['uid']; ?>">
<div><input type="hidden" name="modifyTarget" value="<?php echo $m['uid']; ?>" /></div>
	<div class="c">이름:</div>
	<div><input type="text" name="name" value="<?php echo stripslashes($m['name']); ?>" class="t" /></div>
	<div class="c">이메일:</div>
	<div><input type="text" name="email" value="<?php echo $m['email']; ?>" class="t" /></div>
	<div class="c">홈페이지:</div>
	<div><input type="text" name="homepage" value="<?php echo $m['homepage']; ?>" class="t" /></div>
	<div class="c">내용:</div>
	<div><textarea name="content" rows="10"><?php echo nl2br(stripslashes($m['content'])); ?></textarea></div>
	<div><input type="checkbox" name="is_secret" value="1" <?php echo (($m['is_secret'])?'checked="checked"':''); ?> /> 비밀댓글</div>
	<div class="m"><input type="submit" value="수정완료" /></div>
</form>
</div>

</body>

<script type="text/javascript" src="<?php echo $grblog; ?>/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">//<![CDATA[
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "emotions,inlinepopups,media",
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,forecolor,|,emotions,image,media,bullist,numlist,link",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	content_css : "<?php echo $grblog; ?>/css/edit.css",
    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	plugi2n_insertdate_timeFormat : "%H:%M:%S",
	file_browser_callback : "fileBrowserCallBack",
	paste_use_dialog : false,
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : true,
	theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
	paste_auto_cleanup_on_paste : true,
	paste_convert_headers_to_strong : true,
	paste_strip_class_attributes : "all",
	paste_remove_spans : false,
	paste_remove_styles : false	
});
//]]></script>
</html>