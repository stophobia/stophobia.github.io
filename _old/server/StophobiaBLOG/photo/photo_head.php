<?php
if($_GET['deleteNo']) $deleteNo = $_GET['deleteNo'];
if($_GET['deleteCoNo']) $deleteCoNo = $_GET['deleteCoNo'];
if($_GET['photoNo']) $photoNo = $_GET['photoNo'];
if($_GET['deleteCoUid']) $deleteCoUid = $_GET['deleteCoUid'];
$prefix = '../';
include '../photo_config.php';
include '../lib/common.php';
include '../php_head.php';
dbConn($prefix);

// 사진삭제하기 (관리자)
if($deleteNo) {
	$del = @mysql_fetch_array(mysql_query('select file_route from '.$dbFIX.'photo where uid = '.$deleteNo));
	@unlink('../'.$del['file_route']);
	@mysql_query('delete from '.$dbFIX.'photo where uid = '.$deleteNo);
	@mysql_query('delete from '.$dbFIX.'photo_comment where photo_uid = '.$deleteNo);
	error('선택하신 사진을 사진첩에서 삭제 했습니다.', 'location.href=\'./?photoNo='.$photoNo.'\';');
}

// 코멘트삭제하기 (사용자)
if($_POST['coPass']) {
	@extract($_POST);
	$coPass = md5(trim($coPass));
	$originPass = @mysql_fetch_array(mysql_query('select photo_uid, password from '.$dbFIX.'photo_comment where uid = '.$deleteCoUid));
	if($coPass != $originPass[1]) error('비밀번호가 맞지 않습니다');
	@mysql_query('delete from '.$dbFIX.'photo_comment where uid = '.$deleteCoUid);
	@mysql_query('update '.$dbFIX.'photo set comment = comment - 1 where uid = '.$originPass[0]);
	error('코멘트 삭제가 완료 되었습니다.', 'location.href=\'./?photoNo='.$originPass[0].'\'');
}

// 코멘트삭제하기 (관리자)
if($deleteCoNo) {
	@mysql_query('delete from '.$dbFIX.'photo_comment where uid = '.$deleteCoNo);
	@mysql_query('update '.$dbFIX.'photo set comment = comment - 1 where uid = '.$photoNo);
	error('선택하신 코멘트를 삭제 했습니다.', 'location.href=\'./?photoNo='.$photoNo.'\';');
}

// 코멘트 작성완료 하기
if($_POST['submitOK']) 
{
	@extract($_POST);
	if(!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) error('정상적인 방법으로 댓글을 남겨 주세요.');
	if(eregi('http:\/\/|www\.', $content)) error('내용중 http:// 혹은 www. 가 포함되어 스팸으로 인식 되었습니다.');
	$filterText = @file_get_contents('../filter.txt');
	if($filterText)
	{
		$filterArray = explode(',', $filterText);
		$filterNum = count($filterArray);
		for($tf=0; $tf<$filterNum; $tf++)
		{
			if(eregi($filterArray[$tf], $content))
				error('글내용에 필터링 대상 단어가 있습니다 : '.$filterArray[$tf]);
		}
	}
	if($_SESSION['no'])
	{
		$config = @mysql_fetch_array(mysql_query('select name, email, password from '.$dbFIX.'config where uid = '.$_SESSION['no']));
		$name = $config['name'];
		$email = $config['email'];
		$password = $config['password'];
	}
	else
	{
		if(!$_SESSION['antiSpam'] || !$antispam || $_SESSION['antiSpam'] != $antispam)
			error('수식의 계산 결과값을 정확히 입력해 주십시오. (예: 1+2=? 에서 답인 3)');
	}
	if(!trim($name)) error('이름을 입력해 주세요~');
	if(!trim($content)) error('댓글을 작성해 주세요~');
	if(!trim($password)) error('비밀번호를 입력해 주세요~');
	if($homepage && !eregi('http:\/\/', $homepage)) $homepage = 'http://'.$homepage;
	$que = "insert into ".$dbFIX."photo_comment set uid = '', photo_uid = '$photoUid', ".
		"name = '".htmlspecialchars($name)."', email = '$email', password = '".md5($password)."', homepage = '$homepage', ip = '".$_SERVER['REMOTE_ADDR']."', ".
		"signdate = '".time()."', comment = '".htmlspecialchars($content)."'";
	@mysql_query($que);
	@mysql_query('update '.$dbFIX.'photo set comment = comment + 1 where uid = '.$photoUid);
	error('코멘트 작성을 완료하였습니다.', 'location.href=\'./?photoNo='.$photoUid.'\';');
}

// 스팸방지용 질문코드 (산수)
if(!$_SESSION['no'] && !$_POST['submitOK'])
{
	$antiSpam0 = mt_rand(1, 9);
	$antiSpam1 = mt_rand(1, 9);
	$antiSpam2 = mt_rand(0, 1);
	if($antiSpam2) {
		$_SESSION['antiSpam'] = $antiSpam0 + $antiSpam1;
		$antiSpam3 = '+';
	}
	else {
		$_SESSION['antiSpam'] = $antiSpam0 * $antiSpam1;
		$antiSpam3 = 'x';
	}
}

// 현재 사진
if($photoNo) $addQ = ' where uid = '.$photoNo; else $addQ = '';
$nowPhoto = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'photo'.$addQ.' order by uid desc limit 1'));
$photoCategory = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'photo_category where uid = '.$nowPhoto['category']));
$photoCa = stripslashes($photoCategory['name']);
$mainTitle = stripslashes($nowPhoto['title']);
$mainContent = stripslashes($nowPhoto['content']);
$mainEXIF = showEXIF('../'.$nowPhoto['file_route']);
$size = @getimagesize('../'.$nowPhoto['file_route']);
$exifWidth = $size[0];
if($size[0] > $photo['original_max_width']) {
	$exifWidth = $photo['original_max_width'];
	$resizePhoto = '../phpThumb/phpThumb.php?src=../'.$nowPhoto['file_route'].'&amp;w='.$photo['original_max_width'].'&amp;q='.$photo['quality'].'&amp;fltr[]=usm|99|0.5|3';
}
else $resizePhoto = '../'.$nowPhoto['file_route'];
$fileName = explode('/', $nowPhoto['file_route']);

// 이전 사진 바로 가기
if(!$photoNo) $photoNo = $nowPhoto['uid'];
$prevPhoto = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'photo where uid < '.$photoNo.' order by uid desc limit 1'));
if($prevPhoto['uid']) {
	$prevImage = '<a href="./?photoNo='.$prevPhoto['uid'].'" title="이전 사진을 봅니다"><img src="../phpThumb/phpThumb.php?src=../'.$prevPhoto['file_route'].'&amp;w='.$photo['main_width'].'&amp;h='.$photo['main_height'].'&amp;q='.$photo['quality'].'&amp;fltr[]=usm|99|0.5|3" alt="이전 사진" /></a>';
} else $prevImage = '<img src="image/no_img.gif" alt="이전사진 없음" />';

// 다음 사진 바로 가기
$nextPhoto = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'photo where uid > '.$photoNo.' order by uid asc limit 1'));
if($nextPhoto['uid']) {
	$nextImage = '<a href="./?photoNo='.$nextPhoto['uid'].'" title="다음 사진을 봅니다"><img src="../phpThumb/phpThumb.php?src=../'.$nextPhoto['file_route'].'&amp;w='.$photo['main_width'].'&amp;h='.$photo['main_height'].'&amp;q='.$photo['quality'].'&amp;fltr[]=usm|99|0.5|3" alt="다음 사진" /></a>';
} else $nextImage = '<img src="image/no_img.gif" alt="다음사진 없음" />';

// 현재 사진 바로 가기
$justViewImage = '<a href="#" title="현재 보고 계시는 사진입니다"><img src="../phpThumb/phpThumb.php?src=../'.$nowPhoto['file_route'].'&amp;w='.$photo['main_width'].'&amp;h='.$photo['main_height'].'&amp;q='.$photo['quality'].'&amp;fltr[]=usm|99|0.5|3" alt="현재 사진" /></a>';
?>