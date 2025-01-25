<?php
$prefix = '../../';
$who = addslashes(trim($_GET['who']));
include $prefix.'lib/common.php';
dbConn($prefix);

// ID 값이 있는지 확인한다.
$saveQue = @mysql_query('select uid from '.$dbFIX.'user where user_id = '.$who);
$saveFetch = @mysql_fetch_array($saveQue);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<link rel="stylesheet" href="<?php echo $prefix; ?>style.css" type="text/css" title="style" />
<title>GR Blog 멤버 아이디 체크</title>
</head>
<body>
<?php
if($saveFetch['uid'])
{
	echo '<script type="text/javascript"> alert(\'이미 '.$who.' 가 다른 사용자에 의해'.
		' 등록되어 있습니다.\\n\\n다른 아이디를 사용하세요.\'); window.close(); </script>';
}
else
{
	echo '<script type="text/javascript"> alert(\'등록가능한 ID 입니다.\\n\\n등록을 계속해 주세요.\');'.
		'window.close(); </script>';
}
?>
</body>
</html>