<!-- 댓글 입력하는 부분 -->
<form id="writeComment<?php echo $gb['uid']; ?>" method="post" onsubmit="return comment(<?php echo $gb['uid'].','.(($_SESSION['no'] || $_SESSION['user_no'])?1:0); ?>);" action="<?php echo $grblog.'?p='.$gb['uid']; ?>">
<div><input type="hidden" name="commentSubmit" value="1" />
<input type="hidden" name="p" value="<?php echo $gb['uid']; ?>" />
<?php if($replyTo) { ?>
<input type="hidden" name="replyTo" value="<?php echo $replyTo; ?>" />
<input type="hidden" name="is_reply" value="1" />
<?php } if($_SESSION['openID']) { ?>
<input type="hidden" name="openid_url" value="<?php echo $_SESSION['openID']; ?>" />
<?php } ?>
<input type="hidden" name="post_uid" value="<?php echo $gb['uid']; ?>" />
<input type="hidden" name="spamKeyCode" value="<?php echo md5($gb['uid'].$_SESSION['antiSpam']); ?>" />
</div>
<div id="write<?php echo $gb['uid']; ?>">
<?php if(!$_SESSION['no'] && !$_SESSION['user_no']) { ?>
	<div style="padding-top: 15px"><input type="radio" name="chooseAuth" value="0" onclick="choose('normalAuth<?php echo $gb['uid']; ?>', 'openidAuth<?php echo $gb['uid']; ?>');" id="useNormal<?php echo $gb['uid']; ?>" /> <label for="useNormal<?php echo $gb['uid']; ?>" title="이름, 비밀번호, 자동등록방지답, 내용 등을 입력합니다.">일반적인 정보입력</label> 
	<?php if($config['use_openid']) { ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="chooseAuth" value="1" onclick="choose('openidAuth<?php echo $gb['uid']; ?>', 'normalAuth<?php echo $gb['uid']; ?>');" id="useOpenID<?php echo $gb['uid']; ?>" /> <label for="useOpenID<?php echo $gb['uid']; ?>" title="오픈아이디로 로그인해서 댓글을 남깁니다.">오픈아이디(OpenID) 사용</label>
	<?php } ?>
	</div>
	<div id="normalAuth<?php echo $gb['uid']; ?>" style="display: none; padding-top: 10px">
	<?php if($conf_antiSpam) { ?>
		<div><input type="text" name="antispam" class="text" title="우측의 자동등록방지 코드 4자리를 입력해 주세요. (필수)" /> <strong title="오른쪽의 4자리 글자들을 왼쪽 입력칸에 입력해 주세요.">자동등록방지 코드:</strong> <div id="quiz<?php echo $gb['uid']; ?>" style="display: inline; cursor: pointer" title="여기를 클릭하시면 입력칸에 자동으로 적습니다." onclick="pasteCode(<?php echo $gb['uid'].', \''.$_SESSION['antiSpam']; ?>');"><?php echo $_SESSION['antiSpam']; ?></div></div>
	<?php } else { ?><input type="hidden" name="antispam" value="NOT_USE" /><?php } ?>
		<p><input type="text" name="name" class="text" title="이름을 입력해 주세요 (필수)" /> <strong>이름</strong></p>
		<p><input type="password" name="password" class="text" title="비밀번호를 입력해 주세요. (필수)" /> <strong>비밀번호</strong></p>
		<p><input type="text" name="email" class="text" title="이메일 주소를 입력해 주세요." /> 이메일 (필수아님)</p>
		<p><input type="text" name="homepage" class="text" title="홈페이지(블로그) 주소를 입력해 주세요. 여러분의 블로그에도 구경 가고 싶습니다. ^^" /> 홈페이지/블로그 (필수아님)</p>
	</div>
	<?php if($config['use_openid']) { ?>
	<div id="openidAuth<?php echo $gb['uid']; ?>" style="display: none">
		<?php if(!$_SESSION['openID']) { ?>
		<p><input type="text" name="openid_url" class="text" maxlength="250" title="이 곳에 오픈아이디를 입력해 주시면 됩니다." /> <img src="<?php echo $grblog.$theme; ?>/openid.gif" alt="openid" /> 손님의 오픈아이디를 입력해 주세요.</p>
		<?php } else { ?>
		<div class="alreadyOpenid"><img src="<?php echo $grblog.$theme; ?>/openid.gif" alt="openid" /> <strong><?php echo $_SESSION['openID']; ?></strong> 로 오픈아이디가 인증되어 있습니다.</div>
		<?php } ?>
	</div>
	<?php } 
		} ?>
	<p><textarea name="content" rows="5" cols="50" class="textarea"><?php echo (($replyOriginal)?$replyOriginal:''); ?></textarea></p>
	<div><input type="checkbox" name="is_secret" value="1" /> 비밀댓글 <span style="font-size: 11px; color: #999">(오직 관리자만 볼 수 있습니다.)</span></div>
	<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit" class="btn submit btn-pink" /></p>
</div>
</form>

<?php if($p) { ?></div><?php } 

// 댓글 작성폼을 웹에디터로~
if(!isset($isEditorLoaded)) {
?>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
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
	paste_remove_styles : false,
	forced_root_block : false
});
//]]></script>
<?php $isEditorLoaded = true; } ?>