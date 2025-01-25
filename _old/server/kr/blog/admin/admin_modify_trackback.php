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
	$que = "update ".$dbFIX."trackback set name = '".htmlspecialchars(addslashes($name))."', subject = '".htmlspecialchars($subject)."', ".
		"summary = '".cutString(htmlspecialchars(addslashes($content)), 250)."', url = '$url' where uid = '$modifyTarget'";
	@mysql_query($que);
	move('admin_modify_trackback.php?uid='.$modifyTarget);
}
$m = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'trackback where uid = '.$uid));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<title>GR Blog 트랙백 수정하기</title>
<link rel="stylesheet" href="../css/modify_style.css" type="text/css" title="style" />
<script type="text/javascript">
function modify()
{
	t = document.forms['modifyTrackback'];
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
</script>
</head>
<body>

<div id="top">
GR Blog modify trackback
</div>

<div id="mc">
<form id="modifyTrackback" method="post" onsubmit="return modify();" action="<?php echo $_SERVER['PHP_SELF']; ?>?uid=<?php echo $m['uid']; ?>">
<div><input type="hidden" name="modifyTarget" value="<?php echo $m['uid']; ?>" /></div>
	<div class="c">이름:</div>
	<div><input type="text" name="name" value="<?php echo stripslashes($m['name']); ?>" class="t" /></div>
	<div class="c">주소:</div>
	<div><input type="text" name="url" value="<?php echo $m['url']; ?>" class="t" /></div>
	<div class="c">제목:</div>
	<div><input type="text" name="subject" value="<?php echo $m['subject']; ?>" class="t" /></div>
	<div class="c">내용:</div>
	<div><textarea name="content" rows="10"><?php echo stripslashes($m['summary']); ?></textarea></div>
	<div class="m"><input type="submit" value="수정완료" /></div>
</form>
</div>

</body>
</html>