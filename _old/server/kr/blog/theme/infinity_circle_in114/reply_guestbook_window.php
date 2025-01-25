<?php
$prefix = '../../';
include $prefix.'lib/common.php';
include $prefix.'php_head.php';
include $prefix.'theme_config.php';

dbConn($prefix);
@extract($_POST);
@extract($_GET);
$path = 'http://'.$_SERVER['HTTP_HOST'].$grblog.'guestbook/';

// 스팸방지용 새 코드
if(!$_SESSION['no'] && !$guestbookSubmit && $conf_antiSpam)
	$_SESSION['antiSpam'] = substr(md5('grblogAntiSpam'.time()), -4);

// 설정 가져오기
$config = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'config where uid = \'1\''));
$theme = 'theme/'.$config['theme'];

// 방명록 작성완료
if($guestbookSubmit) {
	if(!$_SESSION['no'] && $conf_antiSpam && ($_SESSION['antiSpam'] != $antispam)) error('자동등록방지코드 4자리를 올바르게 입력해 주세요');
	if($conf_koreanOnly && !preg_match("/[가-힣]/uism", $content)) error('한글이 포함되어 있지 않아 타 언어 스팸으로 간주되었습니다.');
	$name = htmlspecialchars(addslashes(trim($name)));
	$password = trim($password);
	$content = htmlspecialchars(addslashes(trim($content)));
	$homepage = htmlspecialchars(trim($homepage));
	$email = htmlspecialchars(trim($email));
	if(!$name) error('이름을 입력해 주세요');
	if(!$_SESSION['no'] && !$password) error('비밀번호를 입력해 주세요');
	if(!$content) error('내용을 입력해 주세요');
	if($homepage == 'http://') $homepage = '';
	$sql = "insert into {$dbFIX}guestbook set uid = '', name = '$name', password = '".md5($password)."', homepage = '$homepage', ".
		"content = '$content', is_secret = '$isSecret', is_reply = '$replyTarget', signdate = '".time()."', email = '$email'";
	@mysql_query($sql);
	$insertNo = @mysql_insert_id();

	die('<script type="text/javascript"> alert(\'방명록에 답글을 입력하였습니다.\'); window.opener.document.location.href = \''.$path.'?page='.$page.'\'; window.close(); </script>');
}

// 답글 달 때 내용 가져오기
if($replyTarget) {
	$modify = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'guestbook where uid = '.$replyTarget));
	if($modify['is_secret']) $modify = array();
	$writer = $modify['name'];
	$modify['content'] = ':'.str_replace("\n", "\n:", $modify['content']);
	if($_SESSION['no']) {
		$modify['name'] = $config['name'];
		$modify['homepage'] = $config['homepage'];
		$modify['email'] = $config['email'];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR BLog" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<meta name="copyright" content="Copyright ⓒ 2008 Hee Geun Park" />
<title>GR Blog - 방명록에 답글달기</title>
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<link rel="stylesheet" href="guestbook.css" type="text/css" title="style" />
<script src="../../js/prototype.js" type="text/javascript"></script>
<script src="../../js/effects.js" type="text/javascript"></script>
<script type="text/javascript" src="theme.js"></script>
<style type="text/css">/*<![CDATA[*/
#addReply {
	margin: 10px 10px 0px 10px;
	height: 410px;
	padding: 10px;
	position: relative;
	background-color: #fff;
	border: #d3d3d3 1px solid;
	text-align: left;
}
#msg {
	font-family: Dotum, 돋움, sans-serif;
	font-size: 11px;
	color: #999;
	text-align: left;
}
#wrapWindow {
	margin-top: 10px;
	padding-top: 5px;
	border-top: #ddd 1px dotted;
}
#guestbook {
	width: 100%;
	padding: 0;
	margin: 0;
	background: transparent;
}
/*]]>*/</style>
</head>
<body>
<div id="addReply">

<div id="msg"><?php echo $writer; ?>님의 글에 답글달기:</div>

<div id="wrapWindow">
<div id="guestbook">
	<form id="guest" method="post" onsubmit="return chkGuest('<?php if($conf_antiSpam && !$_SESSION['no']) echo 'useSpamCheck'; ?>');" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="guestbookSubmit" value="1" />
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="replyTarget" value="<?php echo $replyTarget; ?>" /></div>
	<table rules="none" summary="GR Blog Guestbook" cellspacing="0" cellpadding="0" border="0">
	<tbody>
	<tr>
		<td class="opt1">이름</td>
		<td class="opt2"><input type="text" name="name" class="i" value="<?php echo stripslashes($modify['name']); ?>" /></td>
	</tr>
	<?php if(!$_SESSION['no']) { ?>
	<tr>
		<td class="opt1">패스워드</td>
		<td class="opt2"><input type="password" name="password" class="i" value="" /></td>
	</tr>
	<?php } ?>
	<tr>
		<td class="opt1">홈페이지 (옵션)</td>
		<td class="opt2"><input type="text" name="homepage" class="i" value="<?php echo ($modify['homepage'])?$modify['homepage']:'http://'; ?>" /></td>
	</tr>
	<tr>
		<td class="opt1">이메일 (옵션)</td>
		<td class="opt2"><input type="text" name="email" class="i" value="<?php echo $modify['email']; ?>" style="width: 100px" /></td>
	</tr>
	<tr>
		<td class="opt1">내용</td>
		<td class="opt2"><textarea name="content" rows="5" class="text"><?php echo stripslashes($modify['content']); ?></textarea></td>
	</tr>
	<?php if(!$_SESSION['no']) { ?>
	<tr>
		<td class="opt1">비밀글 (옵션)</td>
		<td class="opt2"><input type="checkbox" name="isSecret" value="1" /> 관리자에게만 보여주고 싶을 경우, 체크해 주세요</td>
	</tr>
	<?php } if($conf_antiSpam && !$_SESSION['no']) { ?>
	<tr>
		<td class="opt1">자동등록방지</td>
		<td class="opt2"><input type="text" name="antispam" class="i" style="width: 100px" /> <span>&nbsp;&nbsp; <?php echo $_SESSION['antiSpam']; ?></span></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" style="padding: 15px"><input type="submit" value="작성완료" class="btn submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
</div>
</div>

</div>
</body>
</html>