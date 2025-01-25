<?php 
if(!defined('__GRFORUM__')) exit();

// 포럼 명칭 / 설명 수정하기
if($_POST['start']) {
	$title = addslashes(trim($_POST['title']));
	$desc = addslashes(trim($_POST['description']));
	$core->query('update ' . $dbFIX . 'view set var = \'' . $title . '\' where opt = \'forum_title\' limit 1');
	$core->query('update ' . $dbFIX . 'view set var = \'' . $desc . '\' where opt = \'forum_desc\' limit 1');
	$core->alert('포럼 명칭과 설명을 수정하였습니다.', './?m=' . $m);
}

// 기존 포럼 명칭 / 설명 가져오기
$title = $core->getData('select var from ' . $dbFIX . 'view where opt = \'forum_title\' limit 1');
$description = $core->getData('select var from ' . $dbFIX . 'view where opt = \'forum_desc\' limit 1');
$title = stripslashes($title['var']);
$description = stripslashes($description['var']);
?>

<h3>포럼 명칭과 한줄 설명을 작성해 주세요!</h3>
포럼 명칭 (예: 한식 요리사 모임) 과 한줄 설명 (예: 요리를 사랑하는 사람들의 광장) 을 적어주세요.<br />
이 곳에 지정하신 포럼 명칭과 한줄 설명은 사용하시는 포럼 스킨에 맞게 배치되어 보여집니다.<br />
포럼 명칭으로 사이트 도메인을 사용하셔도 됩니다.<br />
(만약 포럼 명칭과 설명이 불필요하시다면, 공백으로도 설정하실 수 있습니다.)<br />
<br />

<p>현재 포럼명칭: <strong><?php echo $title; ?></strong></p>
<p>현재 포럼설명: <strong><?php echo $description; ?></strong></p>

<form name="title" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="m" value="<?php echo $m; ?>" /><input type="hidden" name="start" value="1" /></div>

<div class="help">
	<p>새 포럼명칭: <input class="i" type="text" name="title" value="<?php echo $title; ?>" /></p>
	<p>새 포럼설명: <input class="i" type="text" name="description" value="<?php echo $description; ?>" /></p>
	<p>&nbsp;</p>
	<p><input class="s" type="submit" value="포럼 명칭과 설명 수정하기" /></p>
</div>

</form>