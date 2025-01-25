<?php
// 변수초기화
$p = $_GET['p'];
$replyTo = $_GET['replyTo'];
$writer = urldecode($_GET['writer']);

// DB, 세션 연결
$prefix = '../../';
include $prefix.'db_info.php';
include $prefix.'php_head.php';
include $prefix.'lib/common.php';
include $prefix.'theme_config.php';
dbConn($prefix);
$config = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'config where uid = \'1\''));

// 스팸방지용 새 코드
if($conf_antiSpam && !$_SESSION['no'] && !$_POST['commentSubmit'])
	$_SESSION['inputAntiSpam'] = substr(md5('grblogAntiSpam'.time()), -4);

// 댓글 넣기
@extract($_GET);
@extract($_POST);
if(($commentSubmit && $config['use_comment']) || ($_GET['openid_mode'] == 'id_res' && !$_SESSION['openID'])) {

	// 오픈아이디 처리
	if($chooseAuth && $config['use_openid'])
	{
		if ($openid_url && !$_SESSION['openID'])
		{
			include $prefix.'openid/class.openid.php';
			$openid = new SimpleOpenID;
			$openid->SetIdentity($_POST['openid_url']);
			$openid->SetTrustRoot('http://' . $_SERVER["HTTP_HOST"]);
			$openid->SetRequiredFields(array('nickname'));
			$openid->SetOptionalFields(array('email'));
			if ($openid->GetOpenIDServer()) {
				@setcookie('tmpContent', $content, time()+600);
				$openid->SetApprovedURL('http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"].'?p='.$p.'&post_uid='.$post_uid.'&replyTo='.$replyTo.'&chooseAuth=1');
				$openid->Redirect();
			} else {
				$error = $openid->GetError();
				echo "문제발생: " . $error['code'] . '<br />';
				echo "오류내용: " . $error['description'] . '<br />';
			}
			exit;
		}
		else if($_GET['openid_mode'] == 'id_res' && !$_SESSION['openID'])
		{
			include $prefix.'openid/class.openid.php';
			$openid = new SimpleOpenID;
			$openid->SetIdentity($_GET['openid_identity']);
			$openid_validation_result = $openid->ValidateWithServer();
			if ($openid_validation_result == true) {
				$name = $_GET['openid_sreg_nickname'];
				$email = $_GET['openid_sreg_email'];
				$homepage = $_GET['openid_identity'];
				$password = substr(md5(time()), -7);
				$content = $_COOKIE['tmpContent'];
				$_SESSION['openID'] = $_GET['openid_identity'];
				$_SESSION['openIDName'] = $_GET['openid_sreg_nickname'];
				$_SESSION['openIDEmail'] = $_GET['openid_sreg_email'];
			}else if($openid->IsError() == true){
				$error = $openid->GetError();
				echo "문제발생: " . $error['code'] . '<br />';
				echo "오류내용: " . $error['description'] . '<br />';
			} else {
				echo '유효하지 않은 인증입니다.';
			}
		} else if ($_GET['openid_mode'] == 'cancel' && !$_SESSION['openID']){
			echo "USER CANCELED REQUEST";
		} else if ($_SESSION['openID']) {
			$name = $_SESSION['openIDName'];
			$email = $_SESSION['openIDEmail'];
			$homepage = $_SESSION['openID'];
			$password = substr(md5(time()), -7);
		}
	}

	// 검사하기
	if(!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER']) && !$_GET['openid_mode'] && ($_GET['openid_mode'] != 'id_res')) 
		error('정상적인 방법으로 댓글을 남겨 주세요.');

	// 필터링 검사
	$filterText = @file_get_contents($prefix.'filter.txt');
	if($filterText)
	{
		$filterArray = @explode(',', $filterText);
		$filterNum = @count($filterArray);
		for($tf=0; $tf<$filterNum; $tf++) if(eregi($filterArray[$tf], $content)) error('글내용에 필터링 대상 단어가 있습니다 : '.$filterArray[$tf].'');
	}

	// 이름, 비밀번호 등을 가져옴 (회원일 경우)
	if($_SESSION['no'])
	{
		$name = $config['name'];
		$email = $config['email'];
		$password = $config['password'];
	}
	elseif($_SESSION['user_no'])
	{
		include $prefix.'lib/user.php';
		$member = getMemberInfo();
		$name = $member['nickname'];
		$email = $member['email'];
		$password = $member['password'];
	}
	elseif(!$_SESSION['openID'])
	{
		// 자동등록방지
		if($conf_antiSpam && (!$_SESSION['inputAntiSpam'] || !$antispam || $_SESSION['inputAntiSpam'] != $antispam))
			error('자동등록방지코드 4자리를 올바르게 입력해 주세요.');
	}

	// 입력값 검사
	if(!trim($name)) error('이름을 입력해 주세요~');
	if(!trim($content)) error('댓글을 작성해 주세요~');
	if(!trim($password)) error('비밀번호를 입력해 주세요! 자신의 댓글을 삭제하실 수 있습니다.');

	// DB에 입력
	$content = str_replace('<p>', '', str_replace('</p>', '', str_replace('<p>&nbsp;</p>', '', $content)));
	$content = str_replace('title="Cool" src="../../', 'src="', $content);
	$content = strip_tags2($content, 'span,strong,img,a,br,p,div,hr,u,del,i,strike,ol,ul,li,blockquote,em,object');
	$content = addslashes($content);
	$que = "insert into ".$dbFIX."comment set uid = '', family_uid = '0', post_uid = '$post_uid', ".
		"is_secret = '$is_secret', is_reply = '$is_reply', name = '".htmlspecialchars($name)."', ".
		"password = '".md5($password)."', email = '$email', homepage = '$homepage', ip = '".$_SERVER['REMOTE_ADDR']."', ".
		"signdate = '".time()."', content = '".$content."', writer = '".$member['user_id']."'";
	@mysql_query($que) or error('댓글을 남기지 못했습니다.');

	// DB에 관련 값들 업데이트 작업
	$insertUid = @mysql_insert_id();
	$familyQue = "update ".$dbFIX."comment set family_uid = '$replyTo' where uid = '$insertUid'";
	@mysql_query($familyQue);
	@mysql_query("update ".$dbFIX."post set comment_count = comment_count + 1 where uid = '$post_uid'");
	$isGuest = ($_SESSION['no']) ? '' : '.guest';
	if(@file_exists('../../cache/'.$post_uid.$isGuest.'.html')) @unlink('../../cache/'.$post_uid.$isGuest.'.html');
	if(@file_exists('../../cache/page.'.(($page)?$page:1).$isGuest.'.html')) @unlink('../../cache/page.'.(($page)?$page:1).$isGuest.'.html');

	// 댓글알리미
	$blogURL = 'http://'.$_SERVER['HTTP_HOST'].$grblog;
	$getMyReply = @mysql_fetch_array(mysql_query('select name, homepage, signdate, content from '.$dbFIX.'comment where uid = '.$replyTo));
	$getPostTitle = @mysql_fetch_array(mysql_query('select subject from '.$dbFIX.'post where uid = '.$post_uid));

	$postData = 'tool=grblog'.
		'&mode=fb'.
		'&url='.rawurlencode($blogURL).
		'&s_home_title='.rawurlencode($config['blog_title']).
		'&s_post_title='.rawurlencode($getPostTitle['subject']).
		'&s_no='.$post_uid.
		'&s_name='.rawurlencode($name).
		'&s_url='.rawurlencode($blogURL.'?p='.$post_uid).

		'&r1_name='.rawurlencode($getMyReply['name']).
		'&r1_pno='.$replyTo.
		'&r1_rno=0'.
		'&r1_no='.$replyTo.
		'&r1_homepage='.$getMyReply['homepage'].
		'&r1_regdate='.date('r', $getMyReply['signdate']).
		'&r1_url='.rawurlencode($blogURL.'?p='.$post_uid.'#viewComment'.$replyTo).
		'&r1_body='.rawurlencode($getMyReply['content']).

		'&r2_name='.rawurlencode($name).
		'&r2_no='.$insertUid.
		'&r2_rno='.$insertUid.
		'&r2_pno='.$post_uid.
		'&r2_homepage='.rawurlencode($homepage).
		'&r2_regdate='.rawurlencode(date('r', time())).
		'&r2_url='.rawurlencode($blogURL.'?p='.$post_uid.'#viewComment'.$insertUid).
		'&r2_body='.rawurlencode($content).

	// GR블로그 & 댓글알리미 표준 스펙 적용 블로그에 보내줄 형식
		'&blogURL='.rawurlencode($blogURL).
		'&blogName='.rawurlencode($config['blog_title']).
		'&postTitle='.rawurlencode($getPostTitle['subject']).
		'&s_no='.$post_uid.
		'&postURL='.rawurlencode($blogURL.'?p='.$post_uid).

		'&myName='.rawurlencode($getMyReply['name']).
		'&myDate='.rawurlencode(date('r', $getMyReply['signdate'])).
		'&myURL='.rawurlencode($blogURL.'?p='.$post_uid.'#viewComment'.$replyTo).
		'&myBody='.rawurlencode($getMyReply['content']).

		'&replyName='.rawurlencode($name).
		'&replyHomepage='.rawurlencode($homepage).
		'&replyDate='.rawurlencode(date('r', time())).
		'&replyURL='.rawurlencode($blogURL.'?p='.$post_uid.'#viewComment'.$insertUid).
		'&replyBody='.rawurlencode($content);

	if(substr($getMyReply['homepage'], -1) != '/') $getMyReply['homepage'] = $getMyReply['homepage'].'/';
	postSend($getMyReply['homepage'], $postData);

	die('<script type="text/javascript"> alert(\'댓글을 입력하였습니다.\'); window.opener.document.location.href = \'../../?p='.$post_uid.'\'; window.close(); </script>');
}

// 타켓 댓글 가져오기
$getOriginal = @mysql_fetch_array(mysql_query('select is_secret, content from '.$dbFIX.'comment where uid = \''.$replyTo.'\''));
if(!$getOriginal['is_secret'] || $_SESSION['no']) $replyOriginal = ': '.nl2br(str_replace("\n", "\n: ", $getOriginal['content']));
else $replyOriginal = '비밀댓글 입니다';
?>