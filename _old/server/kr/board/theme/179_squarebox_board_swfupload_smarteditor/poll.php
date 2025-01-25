<?php
// 기본 클래스를 부르고 시간 측정 시작
$preRoute = '../../';
include $preRoute.'class/common.php';
$GR = new COMMON;
$GR->dbConn();
$id = $_GET['id'];

// 설문 추가하기
if($_POST['pollSubject'])
{
	@extract($_POST);
	$pollSubject = addslashes($pollSubject);
	$countPollOption = @count($options);
	$pollOption = array();
	@mysql_query("insert into {$dbFIX}poll_subject set no = '', subject = '$pollSubject', signdate = '".time()."', comment_num = '0', id = '$id'");
	$insertNo = @mysql_insert_id();
	for($i=0; $i<$countPollOption; $i++) {
		if($options[$i]) {
			$pollOption[$i] = addslashes($options[$i]);
			@mysql_query("insert {$dbFIX}poll_option set no = '', poll_no = '$insertNo', title = '".$pollOption[$i]."', vote = '0', id = '$id'");
		}
	}
	$GR->error('설문을 추가하였습니다. 본문에 추가해 주세요.', 0, 'poll.php?p='.$insertNo);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>설문 추가하기 - GR Board </title>
<style type="text/css">/*<![CDATA[*/
body { text-align: center; }
body, form, input { margin: 0; padding: 0; font-size: 12px; color: #666; }
img { border: 0 none; }
a { text-decoration: none; color: #ff3300; padding: 5px; }
a:hover { background-color: #ff3300; color: #fff; }
#writePoll { background: #fff url(image/poll_back.gif) no-repeat top left; padding: 10px; }
#writePoll div.title { font-family: Dotum, sans-serif; font-size: 16px; font-weight: bold; padding: 5px 0px 5px 0px; border-bottom: #ddd 1px solid; text-align: left; }
#writePoll div.subject { padding: 5px 0px 5px 0px; }
#writePoll input { border: #ccc 2px solid; background-color: #fff; padding: 3px; width: 300px; vertical-align: middle; }
#writePoll input:focus { border: green 2px solid; }
#writePoll input:hover { background-color: #f5f5f5; }
#writePoll div.options ol { margin: 10px; padding: 10px; }
#writePoll div.options ol li { margin-bottom: 3px; }
#writePoll div.help { margin: 10px 0px 15px 0px; padding: 5px; border: #ddd 1px dotted; line-height: 160%; text-align: left; font-size: 11px; font-family: Dotum, sans-serif; }
#writePoll input.s { width: 100px; margin-right: 3px; border: #ddd 2px solid; font-weight: bold; }
/*]]>*/</style>
</head><body>
<div id="writePoll">
<form id="pollInput" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="id" value="<?php echo $id; ?>" /></div>
	<div class="title">설문 추가하기</div>
	<div class="subject"><img src="<?php echo $preRoute; ?>image/admin/admin_poll.gif" alt="설문" style="vertical-align: middle" /> 설문 주제: <input type="text" name="pollSubject" /></div>
	<div class="options">
		<ol id="optionList">
			<li><input type="text" name="options[]" /></li>
			<li><input type="text" name="options[]" /></li>
			<li><input type="text" name="options[]" /></li>
			<li><input type="text" name="options[]" /></li>
			<li><input type="text" name="options[]" /></li>
		</ol>
		<input type="button" value="+ 항목추가" class="s" onclick="document.getElementById('optionList').innerHTML += '<li><input type=\'text\' name=\'options[]\' /></li>';" title="설문 항목을 더 늘립니다." />
		<input type="submit" class="s" value="설문작성완료" />
	</div>
	<div class="help">설문주제를 입력하고(예: 맛있는 야식은?) 하단에 투표를 받을 항목들(예: 1. 통닭, 2. 피자 ...)을 작성합니다. 항목이 더 필요하시면 위의 "+항목추가" 를 클릭하시면 됩니다. 설문을 다 작성하신 후 "설문작성완료" 를 클릭하시면 이 안내문 하단에 "본문 입력 화면에 끌고 가서 넣어 주십시오." 라고 적힌 상자가 나타납니다. 그 것을 메시지 대로 본문에 드래그해서 넣어주시면 됩니다. <span style="color: #ff5500">! 한 번 입력할 시 정확하게 입력해 주세요 !</span></div>

	<?php if($_GET['p']) { ?>
	<img id="pollBox" alt="<?php echo $_GET['p']; ?>" src="image/insert_poll_msg.gif" style="width: 350px; height: 150px; border: #ccc 1px solid" />
	<?php } ?>
</form>
</div>
</body>
</html>