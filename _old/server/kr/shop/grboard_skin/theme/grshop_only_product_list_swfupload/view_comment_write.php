<?php if(!defined('__GRBOARD__')) exit(); ?>

<div id="layerCoWrite" style="position: <?php if($_COOKIE['pointer'][0]) { ?>absolute; left: <?php echo $_COOKIE['pointer'][0]; ?>px; top: <?php echo $_COOKIE['pointer'][1]; ?>px;<?php } else { ?>relative;<?php } ?>">
<div id="closeWin" <?php if(!$_COOKIE['pointer']) { ?>style="display: none"<?php } ?>><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;replyTarget=<?php echo $comment['no']; ?>&amp;commentPage=<?php echo $_GET['commentPage']; ?>" onclick="clearPos();"><img src="image/lightbox/close.gif" alt="내리기" /></a></div>
<form id="commentWrite" onsubmit="return valueCheck(<?php echo $isMember; ?>);" method="post" action="<?php echo $grboard; ?>/comment_write_ok.php">
<div><input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="modifyTarget" value="<?php echo $modifyTarget; ?>" />
<input type="hidden" name="commentPage" value="<?php echo $commentPage; ?>" />
<input type="hidden" name="replyTarget" value="<?php echo $replyTarget; ?>" />
<input type="hidden" name="useCoEditor" value="<?php echo (($tmpFetchBoard['is_comment_editor'])?1:0); ?>" /></div>
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
	if($_GET['replyTarget']) echo '다시댓글';
	elseif($_GET['modifyTarget']) echo '수정하기';
	else echo '새로쓰기'; ?>)</strong>
	</td>
	<td class="cWriteRight">
		<input type="hidden" name="subject" value="." /><!-- 댓글 제목기능 비활성화 -->
		<?php if(!$tmpFetchBoard['is_comment_editor']) { ?>
		<span onclick="showBtn('emoticon');"><img src="image/emoticon/icon_biggrin.gif" alt="이모티콘 사용" title="이모티콘을 사용합니다." /></span>
		<input type="checkbox" id="is_grcode" name="is_grcode" value="1" <?php echo (($comment['is_grcode'])?'checked="checked"':''); ?> onclick="showBtn('grcodeButton');" /> 
		<label for="is_grcode" title="GR Code 를 사용합니다. 클릭하시면 설명을 봅니다." onclick="helpGrcode();" style="cursor: help">GR 코드</label> &nbsp; 
		<?php } if($_SESSION['no']) { ?>
		<input type="checkbox" id="is_secret" name="is_secret" value="1" <?php echo (($comment['is_secret'])?'checked="checked"':''); ?> />
		<label for="is_secret" title="게시물 작성자만 볼 수 있도록 비밀 댓글을 작성합니다." style="cursor: help">비밀글</label>
		<?php } ?>
	</td>
</tr>
<tr>
	<td class="cWriteLeft">
	댓글내용
	<?php if(!$tmpFetchBoard['is_comment_editor']) { ?><div><span onclick="formSize(2);"><img src="<?php echo $grboard.'/'.$theme; ?>/image/textarea_size_up.gif" alt="폼 크게" title="댓글 작성 폼을 크게 합니다." /></span>
	<span onclick="formSize(-2);"><img src="<?php echo $grboard.'/'.$theme; ?>/image/textarea_size_down.gif" alt="폼 작게" title="댓글 작성 폼을 작게 합니다." /></span></div><?php } ?>
	</td>
	<td class="cWriteRight">
		<div style="width:79%; float: left">
			<div id="editableCoBox"><textarea name="content" cols="50" rows="5" class="commentTextarea"><?php echo $comment['content']; ?></textarea></div>
			<?php if(!$tmpFetchBoard['is_comment_editor']) { ?>
			<div id="grcodeButton" style="display:<?php echo (($comment['is_grcode'])?'':'none'); ?>">
			<span class="hand" onclick="quickTag('[b]', '[/b]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_bold.gif" alt="굵게" title="드래그한 글자 굵게" /></span>
			<span class="hand" onclick="quickTag('[i]', '[/i]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_i.gif" alt="기울게" title="드래그한 글자 기울게" /></span>
			<span class="hand" onclick="quickTag('[img]', '[/img]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_img.gif" alt="그림넣기" title="드래그한 URI주소가 그림주소이며 출력하기" /></span>
			<span class="hand" onclick="quickTag('[big]', '[/big]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_big.gif" alt="글자크게" title="드래그한 글자 크게" /></span>
			<span class="hand" onclick="quickTag('[color:blue:]', '[/color]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_color.gif" alt="색상" title="드래그한 글자 색깔을 blue 로 하기 (red, green, #2e4f4f 등 가능)" /></span>
			<span class="hand" onclick="quickTag('[div]', '[/div]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_div.gif" alt="문단꾸미기" title="드래그한 문단을 박스모양 안에 담기" /></span>
			<span class="hand" onclick="quickTag('[u]', '[/u]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_underline.gif" alt="밑줄" title="드래그한 글자에 밑줄치기" /></span>
			<span class="hand" onclick="quickTag('[s]', '[/s]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_midline.gif" alt="취소선" title="드래그한 글자에 취소선 긋기" /></span>
			<span class="hand" onclick="quickTag('[quote]', '[/quote]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_quote.gif" alt="인용" title="드래그한 문단을 인용 표시하기" /></span>
			<span class="hand" onclick="quickTag('[url]', '[/url]')"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_url.gif" alt="링크" title="드래그한 문장에 링크걸기" /></span>
			</div>
			<!-- 이모티콘 입력 (Emoticon by phpBB - http://phpbb.com ⓒ phpBB Group) -->
			<div id="emoticon" style="display: none">
				<span class="hand" onclick="emoticon(' :D ');"><img src="image/emoticon/icon_biggrin.gif" alt="행복해" title="행복해" /></span>
				<span class="hand" onclick="emoticon(' :) ');"><img src="image/emoticon/icon_smile.gif" alt="미소" title="미소" /></span>
				<span class="hand" onclick="emoticon(' :( ');"><img src="image/emoticon/icon_sad.gif" alt="슬퍼요" title="슬퍼요" /></span>
				<span class="hand" onclick="emoticon(' :o ');"><img src="image/emoticon/icon_surprised.gif" alt="놀람" title="놀람" /></span>
				<span class="hand" onclick="emoticon(' :shock: ');"><img src="image/emoticon/icon_eek.gif" alt="쇼크" title="쇼크" /></span>
				<span class="hand" onclick="emoticon(' :? ');"><img src="image/emoticon/icon_confused.gif" alt="혼란" title="혼란" /></span>
				<span class="hand" onclick="emoticon(' 8) ');"><img src="image/emoticon/icon_cool.gif" alt="시원함" title="시원함" /></span>
				<span class="hand" onclick="emoticon(' :lol: ');"><img src="image/emoticon/icon_lol.gif" alt="웃음" title="웃음" /></span>
				<span class="hand" onclick="emoticon(' :x ');"><img src="image/emoticon/icon_mad.gif" alt="미친" title="미친" /></span>
				<span class="hand" onclick="emoticon(' :P ');"><img src="image/emoticon/icon_razz.gif" alt="냉소" title="냉소" /></span>
				<span class="hand" onclick="emoticon(' :oops: ');"><img src="image/emoticon/icon_redface.gif" alt="당황" title="당황" /></span>
				<span class="hand" onclick="emoticon(' :cry: ');"><img src="image/emoticon/icon_cry.gif" alt="울음" title="울음" /></span>
				<span class="hand" onclick="emoticon(' :evil: ');"><img src="image/emoticon/icon_evil.gif" alt="사악함" title="사악함" /></span>
				<span class="hand" onclick="emoticon(' :twisted: ');"><img src="image/emoticon/icon_twisted.gif" alt="비틀어진 사악함" title="비틀어진 사악함" /></span>
				<span class="hand" onclick="emoticon(' :roll: ');"><img src="image/emoticon/icon_rolleyes.gif" alt="눈굴림" title="눈굴림" /></span>
				<span class="hand" onclick="emoticon(' :wink: ');"><img src="image/emoticon/icon_wink.gif" alt="윙크" title="윙크" /></span>
				<span class="hand" onclick="emoticon(' :!: ');"><img src="image/emoticon/icon_exclaim.gif" alt="느낌표" title="느낌표" /></span>
				<span class="hand" onclick="emoticon(' :?: ');"><img src="image/emoticon/icon_question.gif" alt="물음표" title="물음표" /></span>
				<span class="hand" onclick="emoticon(' :idea: ');"><img src="image/emoticon/icon_idea.gif" alt="아이디어" title="아이디어" /></span>
				<span class="hand" onclick="emoticon(' :arrow: ');"><img src="image/emoticon/icon_arrow.gif" alt="화살표" title="화살표" /></span>
				<span class="hand" onclick="emoticon(' :| ');"><img src="image/emoticon/icon_neutral.gif" alt="무표정" title="무표정" /></span>
				<span class="hand" onclick="emoticon(' :mrgreen: ');"><img src="image/emoticon/icon_mrgreen.gif" alt="초록 아저씨" title="초록 아저씨" /></span>
			</div>
			<?php } ?>
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
	forced_root_block : false	
});
//]]>
</script>
<?php } ?>