<?php
$nickname = addslashes($_GET['nickname']);
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 닉네임 값이 있는지 확인한다.
$saveQue = @mysql_query("select id from {$dbFIX}member_list where nickname = '$nickname'");
$saveFetch = @mysql_fetch_array($saveQue);

// 문서설정
$title = 'GR Board ID Check';
$encoding = 'utf-8';
include 'html_head.php';
?>
<body>
<?php
if($saveFetch['id'])
{
	echo '<script type="text/javascript"> alert(\'이미 '.$nickname.' (이)가 다른 사용자에 의해'.
		' 등록되어 있습니다.\\n\\n다른 닉네임을 사용하세요.\');'.
		'window.close();	</script>';
}
else
{
	echo '<script type="text/javascript"> alert(\'등록가능한 닉네임 입니다.\\n\\n등록을 계속해 주세요.\');'.
		'window.close(); </script>';
}
?>
</body>
</html>