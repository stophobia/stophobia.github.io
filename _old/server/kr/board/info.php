<?php
// 기본 클래스를 부른다
include 'class/common.php';
$GR = new COMMON;
include 'config_member.php';

// 로그인 상태가 아니면 에러
if(!$_SESSION['no']) $GR->error('로그인 상태가 아닙니다. 로그인을 해 주세요.');
$GR->dbConn();

// 탈퇴를 실행했다면 처리한다.
if($_GET['outMe'])
{
	if($_SESSION['no'] == 1) $GR->error('관리자 자신은 탈퇴 할 수 없습니다.', 0, 'info.php');
	@mysql_query('delete from '.$dbFIX.'member_list where no = '.$_SESSION['no']);
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
	'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">'.
	'<head><title>감사합니다</title><link rel="stylesheet" href="style.css" type="text/css" title="style" />'.
	'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.
	'<script type="text/javascript"> alert(\'정상적으로 등록정보가 삭제되었습니다. 그 동안 함께 해주셔서 감사합니다...\'); self.close(); </script>'.
	'</head><body></body></html>';
	$_SESSION = array();
	exit();
}

// 멤버정보가 수정되었다면 수정처리한다.
if(array_key_exists('modifyMemberInfo', $_POST) && $_POST['modifyMemberInfo'])
{
	$targetMemberNo = $_POST['targetMemberNo'];

	if(array_key_exists('deleteNameTag', $_POST) && $_POST['deleteNameTag'])
	{
		$delete1 = @mysql_fetch_array(mysql_query('select nametag from '.$dbFIX.'member_list where no = '.$targetMemberNo));
		@unlink($delete1['nametag']);
		@mysql_query("update {$dbFIX}member_list set nametag = '' where no = '$targetMemberNo'");
	}
	if(array_key_exists('deletePhoto', $_POST) && $_POST['deletePhoto'])
	{
		$delete2 = @mysql_fetch_array(mysql_query('select photo from '.$dbFIX.'member_list where no = '.$targetMemberNo));
		@unlink($delete2['photo']);		
		@mysql_query("update {$dbFIX}member_list set photo = '' where no = '$targetMemberNo'");
	}
	if(array_key_exists('deleteIcon', $_POST) && $_POST['deleteIcon'])
	{
		$delete3 = @mysql_fetch_array(mysql_query('select icon from '.$dbFIX.'member_list where no = '.$targetMemberNo));
		@unlink($delete3['icon']);		
		@mysql_query("update {$dbFIX}member_list set icon = '' where no = '$targetMemberNo'");
	}
	$getOldFile = @mysql_fetch_array(mysql_query('select photo, nametag, icon from '.$dbFIX.'member_list where no = '.$targetMemberNo));

	if(array_key_exists('photo', $_FILES) && $_FILES['photo'])
	{
		$filename1 = $_FILES['photo']['name'];
		$filetype1 = $_FILES['photo']['type'];
		$filesize1 = $_FILES['photo']['size'];
		$filetmpname1 = $_FILES['photo']['tmp_name'];

		if($filesize1 > 0)
		{
			if(!preg_match('/\.(png|jpg|gif|PNG|JPG|GIF)$/i', $filename1)) $GR->error('사진이 아닙니다. 지원 확장자 : .png, .jpg, .gif', 0, 'info.php');

			$checkSize1 = @getimagesize($filetmpname1);
			if(!$checkSize1 || ($checkSize1[2] > 3)) $GR->error('그림이 아니거나 올릴 수 없는 형식 입니다.', 0, 'HISTORY_BACK');
			switch($checkSize1[2]) {
				case '1': $extension = 'gif'; break;
				case '2': $extension = 'jpg'; break;
				case '3': $extension = 'png'; break;
			}

			if(($checkSize1[0] > 200) or ($checkSize1[1] > 200)) 
				$GR->error('사진이 200 x 200 이상입니다. 줄여서 업로드 해 주세요.', 0, 'info.php');

			if(!is_dir('member')) { @mkdir('member', 0705); @chmod('member', 0707); }			
			if(!is_uploaded_file($filetmpname1)) $GR->error('정상적으로 파일을 업로드 해 주세요.', 0, 'info.php');

			$filetmpname1 = str_replace('\\\\', '\\', $filetmpname1);
			$filename1 = 'grboard_photo_'.$targetMemberNo.'.'.$extension;

			if(file_exists('member/'.$filename1)) $GR->error('이미 파일이 올려져 있습니다.', 0, 'info.php');

			$saveFile1 = 'member/'.$filename1;
			if(!move_uploaded_file($filetmpname1, $saveFile1)) $GR->error('파일을 업로드 하지 못했습니다.', 0, 'info.php');
		} else $saveFile1 = $getOldFile['photo'];
	}

	if(array_key_exists('nametag', $_FILES) && $_FILES['nametag'])
	{
		$filename2 = $_FILES['nametag']['name'];
		$filetype2 = $_FILES['nametag']['type'];
		$filesize2 = $_FILES['nametag']['size'];
		$filetmpname2 = $_FILES['nametag']['tmp_name'];

		if($filesize2 > 0)
		{
			if(!preg_match('/\.(png|jpg|gif|PNG|JPG|GIF)$/i', $filename2)) $GR->error('그림이 아닙니다. 지원 확장자 : .png, .jpg, .gif', 0, 'info.php');

			$checkSize2 = @getimagesize($filetmpname2);
			if(!$checkSize2 || ($checkSize2[2] > 3)) $GR->error('그림이 아니거나 올릴 수 없는 형식 입니다.', 0, 'HISTORY_BACK');
			switch($checkSize2[2]) {
				case '1': $extension = 'gif'; break;
				case '2': $extension = 'jpg'; break;
				case '3': $extension = 'png'; break;
			}

			if(($checkSize2[0] > 80) or ($checkSize2[1] > 20)) 
				$GR->error('그림이 80 x 20 이상입니다. 줄여서 업로드 해 주세요.', 0, 'info.php');

			if(!is_dir('member')) { @mkdir('member', 0705); @chmod('member', 0707); }			
			if(!is_uploaded_file($filetmpname2)) $GR->error('정상적으로 파일을 업로드 해 주세요.', 0, 'info.php');

			$filetmpname2 = str_replace('\\\\', '\\', $filetmpname2);
			$filename2 = 'grboard_nametag_'.$targetMemberNo.'.'.$extension;

			if(file_exists('member/'.$filename2)) 
				$GR->error('이미 파일이 올려져 있습니다. 다른 파일이라면 파일명을 변경하신 후 업로드 하세요.', 0, 'info.php');

			$saveFile2 = 'member/'.$filename2;
			if(!move_uploaded_file($filetmpname2, $saveFile2)) 
				$GR->error('파일을 업로드 하지 못했습니다. 파일용량이 너무 크지는 않은지 확인해 보세요.', 0, 'info.php');
		} else $saveFile2 = $getOldFile['nametag'];
	}

	// 아이콘 업로드 처리
	if(array_key_exists('icon', $_FILES) && $_FILES['icon'])
	{
		$filename3 = $_FILES['icon']['name'];
		$filetype3 = $_FILES['icon']['type'];
		$filesize3 = $_FILES['icon']['size'];
		$filetmpname3 = $_FILES['icon']['tmp_name'];

		if($filesize3 > 0)
		{
			if(!preg_match('/\.(png|jpg|gif|PNG|JPG|GIF)$/i', $filename3)) $GR->error('그림이 아닙니다. 지원 확장자 : .png, .jpg, .gif', 0, 'info.php');

			$checkSize3 = @getimagesize($filetmpname3);
			if(!$checkSize3 || ($checkSize3[2] > 3)) $GR->error('그림이 아니거나 올릴 수 없는 형식 입니다.', 0, 'HISTORY_BACK');
			switch($checkSize3[2]) {
				case '1': $extension = 'gif'; break;
				case '2': $extension = 'jpg'; break;
				case '3': $extension = 'png'; break;
			}

			if($checkSize3[0] > 16 or $checkSize3[1] > 16) 
				$GR->error('그림이 16 x 16 이상입니다. 줄여서 업로드 해 주세요.', 0, 'HISTORY_BACK');

			if(!is_dir('icon'))
			{ 
				@mkdir('icon', 0705);
				@chmod('icon', 0707); 
			}			
			if(!is_uploaded_file($filetmpname3)) 
				$GR->error('정상적으로 파일을 업로드 해 주세요.', 0, 'HISTORY_BACK');

			$filetmpname3 = str_replace('\\\\', '\\', $filetmpname3);
			$filename3 = 'grboard_icon_'.$targetMemberNo.'.'.$filename3;

			if(file_exists('icon/'.$filename3)) @unlink('icon/'.$filename3);

			$saveFile3 = 'icon/'.$filename3;
			if(!move_uploaded_file($filetmpname3, $saveFile3)) 
				$GR->error('파일을 업로드 하지 못했습니다. 파일용량이 너무 크지는 않은지 확인해 보세요.', 0, 'HISTORY_BACK');
		} else $saveFile3 = $getOldFile['icon'];
	}

	$nickname = addslashes(htmlspecialchars(trim($_POST['nickname'])));
	$realname = addslashes(htmlspecialchars(trim($_POST['realname'])));
	$email = addslashes(htmlspecialchars(trim($_POST['email'])));
	$homepage = addslashes(htmlspecialchars(trim($_POST['homepage'])));
	$selfInfo = addslashes(htmlspecialchars(trim($_POST['self_info'])));
	if($_POST['password']) $password = trim($_POST['password']);

	// 홈페이지에 http:// 빠져 있으면 넣어주기
	if($homepage && !preg_match('/^(http)/i', $homepage)) $homepage = 'http://'.$homepage;
	
	// 주민등록 처리
	if($enableJumin) {
		$_POST['jumin'] = trim($_POST['jumin']);
		$savedJumin = @end(@mysql_fetch_array(mysql_query("select jumin from {$dbFIX}member_list where no = ".$_SESSION['no'])));
		if($_POST['jumin'] == $savedJumin) $jumin = $savedJumin;
		else $jumin = md5($_POST['jumin']);
	} else $jumin = '';

	if($_SESSION['no']) $sessionNo = $_SESSION['no']; else $sessionNo = 0;

	$sqlUpdate = 'update '.$dbFIX.'member_list set ';
	if($_POST['password']) $sqlUpdate .= "password = password('$password'),";
	$sqlUpdate .= "nickname = '$nickname',
		realname = '$realname',
		email = '$email',
		homepage = '$homepage',
		self_info = '$selfInfo',
		photo = '$saveFile1',
		nametag = '$saveFile2',
		jumin = '$jumin',
		icon = '$saveFile3'
		where no = '$sessionNo'";
	@mysql_query($sqlUpdate) or 
		$GR->error('회원정보를 수정하지 못했습니다.', 0, ($_POST['boardId'])?'board.php?id='.$_POST['boardId']:'CLOSE');

	$GR->error('수정을 완료했습니다.', 0, ($_POST['boardId'])?'board.php?id='.$_POST['boardId']:'CLOSE');
}

// 회원의 정보를 가져온다.
$member = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'member_list where no = '.$_SESSION['no']));

// 게시판상에서 정보 확인일 경우 변수로 저장
if(isset($_GET['infoInBoard'])) $infoInBoard = 1; else $infoInBoard = 0;
if(isset($_GET['boardId'])) $boardId = $_GET['boardId']; else $boardId = '';
if(isset($_GET['fromPage'])) $fromPage = $_GET['fromPage']; else $fromPage = '';

// 필요한 변수정의
$getInformation = @mysql_fetch_array(mysql_query('select var from '.$dbFIX.'layout_config where opt = \'info_skin\' limit 1'));
if(!$getInformation['var']) $getInformation['var'] = 'default';
$setup = @mysql_fetch_array(mysql_query("select head_file, head_form, foot_form, foot_file, theme from {$dbFIX}board_list where id = '$boardId'"));
$theme = 'theme/'.$setup['theme'];
$grboard = str_replace('/info.php', '', $_SERVER['SCRIPT_NAME']);

// 상단 설정, 이동지점
if(!empty($boardId) && ($setup['head_file'] or $setup['head_form']))
{
	if($setup['head_file'])
	{
		ob_start();
		include $setup['head_file'];
		$content = ob_get_contents();
		ob_clean();
		echo str_replace('</head>', '<link rel="stylesheet" href="'.$grboard.'/admin/theme/info/'.$getInformation['var'].'/style.css" type="text/css" title="style" /></head>', $content);
	}
	if($setup['head_form'])
	{
		$setup['head_form'] = str_replace('[theme]', $grboard.'/'.$theme, $setup['head_form']);
		$setup['head_form'] = str_replace('</head>', '<style type="text/css"> @import  url('.$grboard.'/admin/theme/info/'.$getInformation['var'].'/style.css); </style></head>', $setup['head_form']);
		echo stripslashes($setup['head_form']);
	}
}
else
{
	$title = 'GR Board My Information Page';
	$encoding = 'utf-8';
	include 'html_head.php';
}

// 회원 가입 테마 부르기
include 'admin/theme/info/'.$getInformation['var'].'/info.php';

// 하단 설정
if($boardId)
{
	if($setup['foot_form']) echo stripslashes($setup['foot_form']);
	if($setup['foot_file']) include $setup['foot_file'];
}
else { ?></body></html><?php } ?>