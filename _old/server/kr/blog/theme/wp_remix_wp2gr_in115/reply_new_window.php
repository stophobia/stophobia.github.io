<?php include '../../reply_new_window_head.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR BLog" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<meta name="copyright" content="Copyright ⓒ 2008 Hee Geun Park" />
<title>GR Blog - 댓글에 답글달기</title>
<link rel="stylesheet" href="style-black.css" type="text/css" title="style" />
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
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
/*]]>*/</style>
</head>
<body>
<div id="addReply">

<div id="msg"><?php echo $writer; ?>님의 댓글에 댓글달기:</div>

<form id="writeComment" method="post" onsubmit="return comment('', <?php echo (($_SESSION['no'] || $_SESSION['user_no'])?1:0); ?>);" action="<?php echo $_SERVER['PHP_SELF'].'?p='.$p; ?>">
<div><input type="hidden" name="commentSubmit" value="1" />
<input type="hidden" name="p" value="<?php echo $p; ?>" />
<?php if($replyTo) { ?>
<input type="hidden" name="replyTo" value="<?php echo $replyTo; ?>" />
<input type="hidden" name="is_reply" value="1" />
<?php } if($_SESSION['openID']) { ?>
<input type="hidden" name="openid_url" value="<?php echo $_SESSION['openID']; ?>" />
<?php } ?>
<input type="hidden" name="post_uid" value="<?php echo $p; ?>" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</div>
<div id="write" class="write">
<?php 
	//로그인 되어 있지 않을 때
	if(!$_SESSION['no'] && !$_SESSION['user_no']) { ?>
	<div><input type="radio" name="chooseAuth" value="0" onclick="choose('normalAuth', 'openidAuth');" id="useNormal" /> <label for="useNormal" title="이름, 비밀번호, 자동등록방지답, 내용 등을 입력합니다.">일반적인 정보입력</label> 
	<?php if($config['use_openid']) { ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="chooseAuth" value="1" onclick="choose('openidAuth', 'normalAuth');" id="useOpenID" /> <label for="useOpenID" title="오픈아이디로 로그인해서 댓글을 남깁니다.">오픈아이디(OpenID) 사용</label>
	<?php } ?>
	</div>

	<div id="normalAuth" style="display: none; padding-top: 10px">
	<?php if($conf_antiSpam) { ?>
		<p><input type="text" name="antispam" class="text" title="우측의 자동등록방지 코드 4자리를 입력해 주세요. (필수)" /> <strong title="오른쪽의 4자리 글자들을 왼쪽 입력칸에 입력해 주세요.">자동등록방지 코드:</strong> <?php echo $_SESSION['inputAntiSpam']; ?></p>
	<?php } #antispam ?>
		<p><input type="text" name="name" class="text" title="이름을 입력해 주세요 (필수)" /> <strong>이름</strong></p>
		<p><input type="password" name="password" class="text" title="비밀번호를 입력해 주세요. (필수)" /> <strong>비밀번호</strong></p>
		<p><input type="text" name="email" class="text" title="이메일 주소를 입력해 주세요." /> 이메일 (필수아님)</p>
		<p><input type="text" name="homepage" class="text" title="홈페이지(블로그) 주소를 입력해 주세요. 여러분의 블로그에도 구경 가고 싶습니다. ^^" /> 홈페이지/블로그 (필수아님)</p>
	</div>

	<?php if($config['use_openid']) { ?>
	<div id="openidAuth" style="display: none">
		<?php if(!$_SESSION['openID']) { ?>
		<p><input type="text" name="openid_url" maxlength="250" title="이 곳에 오픈아이디를 입력해 주시면 됩니다." /> <img src="openid.gif" alt="openid" /> 손님의 오픈아이디를 입력해 주세요. (예: http://myopenid.myid.net)</p>
		<?php } else { ?>
		<div class="alreadyOpenid"><img src="openid.gif" alt="openid" /> <strong><?php echo $_SESSION['openID']; ?></strong> 로 오픈아이디가 인증되어 있습니다.</div>
		<?php } ?>
	</div>
	<?php 
		} 
	}
	// 로그인 되어 있을 때
	else { ?>
	<div><input type="hidden" name="openid_url" value="" />
	<input type="hidden" name="chooseAuth" value="9" />
	<input type="hidden" name="name" value="" />
	<input type="hidden" name="password" value="" /></div>
	<?php } ?>

	<p><textarea name="content" rows="5" cols="50" style="width: 98%"><?php echo $replyOriginal; ?></textarea></p>
	<p><input type="checkbox" name="is_secret" value="1" /> 비밀댓글 <span style="font-size: 11px; color: #999">(오직 관리자만 볼 수 있습니다.)</span></p>
	<p><input type="image" src="confirm.gif" accesskey="s" title="댓글 작성을 완료 합니다. 클릭 하시면 전송합니다!" /></p>
</div>
</form>

</div>
</body>

<script type="text/javascript" src="../../tiny_mce/tiny_mce.js"></script>
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