<?php if(!defined('__GRBOARD__')) exit(); ?>

<!-- 댓글 레이어 처리 시작 -->
<div id="layerCoWrite" style="position: <?php if($_COOKIE['pointer'][0]) { ?>absolute; left: <?php echo $_COOKIE['pointer'][0]; ?>px; top: <?php echo $_COOKIE['pointer'][1]; ?>px;<?php } else { ?>relative;<?php } ?>">
<div id="closeWin" <?php if(!$_COOKIE['pointer']) { ?>style="display: none"<?php } ?>><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;replyTarget=<?php echo $comment['no']; ?>&amp;commentPage=<?php echo $_GET['commentPage']; ?>" onclick="clearPos();"><img src="image/lightbox/close.gif" alt="내리기" /></a></div>

<!-- 폼 전송 부분 (이 부분은 수정하지 마세요) -->
<form id="commentWrite" onsubmit="return valueCheck(<?php echo $isMember; ?>);" method="post" action="<?php echo $grboard; ?>/comment_write_ok.php">
<div><input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
<input type="hidden" name="modifyTarget" value="<?php echo $modifyTarget; ?>" />
<input type="hidden" name="commentPage" value="<?php echo $commentPage; ?>" />
<input type="hidden" name="replyTarget" value="<?php echo $replyTarget; ?>" />
<input type="hidden" name="useCoEditor" value="<?php echo (($tmpFetchBoard['is_comment_editor'])?1:0); ?>" />
<input type="hidden" name="clickCategory" value="<?php echo $clickCategory; ?>" /></div>
<table rules="none" summary="GR Board Write Comment" cellpadding="0" cellspacing="0" border="0" class="commentWriteBox">
<caption></caption>
<colgroup>
<col style="width:120px" />
<col />
</colgroup>
<tbody>
<?php 
if(!$isMember) { 
	// 오픈ID 인증이 되어 있지 않을 시
	if($tmpFetchBoard['is_openid'] && !$_SESSION['openID']) {
?>
<tr>
	<td class="cWriteLeft"><a href="http://myid.net/" onclick="window.open(this.href, '_blank'); return false" title="오픈ID 설명보기">오픈ID</a></td>
	<td class="cWriteRight"><input type="text" name="openid_url" class="openID" maxlength="250" /> (오픈아이디 입력시 아래 생략 가능함)</td>
</tr>
	<?php 
	// 오픈ID 인증이 되어 있을 시
	} else if($tmpFetchBoard['is_openid']) { ?>
<tr>
	<td class="cWriteLeft"><a href="http://myid.net/" onclick="window.open(this.href, '_blank'); return false" title="오픈ID 설명보기">오픈ID</a></td>
	<td class="cWriteRight"><span title="아래 항목중 제목과 내용만 쓰시면 바로 등록 됩니다." style="cursor: help"><img src="<?php echo $grboard.'/'.$theme; ?>/image/openid.gif" alt="openid" /> <strong><?php echo $_SESSION['openID']; ?></strong> 로 인증 되었습니다.</span></td>
</tr>
<?php } ?>
<tr>
	<td class="cWriteLeft">이름</td>
	<td class="cWriteRight"><input type="text" name="name" class="miniInput" maxlength="20" value="<?php echo $comment['name']; ?>" /></td>
</tr>
<tr>
	<td class="cWriteLeft">비밀번호</td>
	<td class="cWriteRight"><input type="password" name="password" maxlength="40" class="miniInput" /></td>
</tr>
<tr>
	<td class="cWriteLeft">이메일</td>
	<td class="cWriteRight"><input type="text" name="email" class="miniInput" maxlength="250" value="<?php echo $comment['email']; ?>" /></td>
</tr>
<tr>
	<td class="cWriteLeft">홈페이지</td>
	<td class="cWriteRight"><input type="text" name="homepage" maxlength="250" class="miniInput" value="<?php echo $comment['homepage']; ?>" /></td>
</tr>
<tr>
	<td class="cWriteLeft">자동등록방지</td>
	<td class="cWriteRight"><input type="text" name="antispam" class="input" style="width: 100px" /> (<strong><?php echo $antiSpam0.$antiSpam3.$antiSpam1; ?>=?</strong> 의 답을 입력해 주세요.)</td>
</tr>
<?php } ?>
<tr>
	<td class="cWriteLeft">제목 
	<strong>(<?php 
	// 현재 댓글 모드 표시
	if($_GET['replyTarget']) echo '다시댓글';
	elseif($_GET['modifyTarget']) echo '수정하기';
	else echo '새로쓰기'; ?>)</strong>
	</td>
	<td class="cWriteRight">
		<input type="text" name="subject" maxlength="250" class="miniInput" style="width: 250px" value="<?php echo $comment['subject']; ?>" /> 
		<?php 
		// 로그인 후 사용가능
		if($_SESSION['no']) { ?>
		<input type="checkbox" id="is_secret" name="is_secret" value="1" <?php echo (($comment['is_secret'])?'checked="checked"':''); ?> />
		<label for="is_secret" title="게시물 작성자만 볼 수 있도록 비밀 댓글을 작성합니다." style="cursor: help">비밀글</label>
		<?php } ?>
	</td>
</tr>
<tr>
	<td class="cWriteLeft">댓글내용</td>
	<td class="cWriteRight">
		<div style="width:79%; float: left">
			<div id="editableCoBox"><textarea name="content" cols="50" rows="5" class="commentTextarea"><?php echo $comment['content']; ?></textarea></div>
		</div>
		<div style="width: 19%; float: left"><input type="image" src="<?php echo $grboard.'/'.$theme; ?>/image/comment_write_ok.gif" title="댓글을 작성완료 합니다" /></div>
	</td>
</tr>
</tbody>
</table>
</form>
</div>

<?php if($tmpFetchBoard['is_comment_editor']) { ?>
<script type="text/javascript" src="<?php echo $grboard; ?>/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
//<![CDATA[
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
	content_css : "<?php echo $grboard.'/'.$theme; ?>/edit.css",
    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	plugi2n_insertdate_timeFormat : "%H:%M:%S",
	file_browser_callback : "fileBrowserCallBack",
	paste_use_dialog : false,
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : false,
	theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
	paste_auto_cleanup_on_paste : true,
	paste_convert_headers_to_strong : false,
	paste_strip_class_attributes : "all",
	paste_remove_spans : false,
	paste_remove_styles : false,
	forced_root_block : false,
	forced_root_block : false
});
//]]>
</script>
<?php } ?>