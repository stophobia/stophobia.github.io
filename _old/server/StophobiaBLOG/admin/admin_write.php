<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 새글 작성 -->
<form name="new_post" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=2" onsubmit="return post_write('');">
<div id="all">
	<div class="normalTitle">글작성</div>
	<div id="modifyDIV"><input type="hidden" name="modifyTarget" value="<?php echo $modify['uid']; ?>" /></div>
	<div><input type="hidden" name="writer" value="<?php echo $config['name']; ?>" />
	<input type="hidden" name="writeID" value="<?php echo (($member['user_id'])?$member['user_id']:$config['id']); ?>" /></div>
	<div id="setting">
		<div class="option">제목:</div>
		<div class="value"><input type="text" name="subject" class="t" value="<?php echo $modify['subject']; ?>" title="포스팅 제목을 입력해 주세요" /></div>
		<div class="option">내용:</div>
		<div class="value">
			<div><textarea name="content" id="content" rows="20" cols="90"><?php echo $modify['content']; ?></textarea></div>
		</div>
		<div class="option">태그('<strong>,</strong>' 로 구분해서 입력해주세요 [예: 일상<strong>,</strong>행복]):</div> 
		<div class="value"><input type="text" name="tag" class="t" value="<?php echo $modify['tag']; ?>" title="태그(꼬리표)를 입력해주세요. 없을 시 비워두시면 됩니다." /></div>
		<div class="option">트랙백 보낼 곳: <select name="encoding" title="대부분 기본값을 쓰시면 되나, 네이버/다음/파란 등의 서비스형 블로그에는 EUC-KR 을 선택하셔야 합니다."><option value="utf-8">UTF-8 (티스토리/텍스트큐브, 워드프레스, GR블로그, 이글루스 등...)</option><option value="euc-kr">EUC-KR (네이버, 다음, 파란, 야후! 등...)</option></select></div>
		<div class="value"><input type="text" name="trackback" class="t" value="<?php echo $modify['trackback']; ?>" title="트랙백(엮인글) 보낼 곳을 적어주세요. 없을 시 비워두시면 됩니다." /></div>
		<div class="option">카테고리:</div>
		<div id="viewCategory">
			<select name="category">
			<option value="">선택 분류 없음</option>
			<?php getCategoryOption(); ?>
			</select>
			<input type="text" name="addNewCategory" class="i" title="추가할 카테고리명을 입력해주세요 (예: 나의취미)" /><input type="button" value="추가" class="s" onclick="addCategory();" />
		</div>
		<div id="listCategory">
			<ol><?php getCategoryList(); ?></ol>
		</div>
		<div class="clr"></div>
		<!-- 옵션설정 -->
		<fieldset id="optionBox">
			<legend>옵션설정</legend>
			<div id="options">
				<div id="openRSS"><input type="checkbox" id="open_rss" name="open_rss" value="1" checked="checked" /> <label for="open_rss" title="RSS 2.0 포맷으로 외부에 글을 출판합니다.">RSS 에 공개</label></div>
				<div id="commentCondition"><input type="checkbox" id="comment_condition" name="comment_condition" value="1" checked="checked" /> <label for="comment_condition" title="이 글에 방문객들의 댓글이나 블로거들의 트랙백(엮인글)을 받습니다.">댓글, 트랙백 허용</label></div>
				<div id="useSync"><input type="checkbox" id="use_sync" name="use_sync" value="1" /> <label for="use_sync" title="이 글을 시리니넷의 싱크넷(SinkNET)에 출판 합니다.">싱크넷에 출판하기</label></div>
				<div id="modifyTime"><input type="checkbox" id="modify_time" name="modify_time" value="1" <?php echo (($modifyTarget)?'checked="checked"':'');?> /> <label for="modify_time" title="글을 수정하였을 경우 수정한 시각으로 다시 작성시간을 수정합니다.">작성시간 업데이트</label></div>
				<div id="makeHTML"><input type="checkbox" id="make_html" name="make_html" value="1" <?php echo (($modify['use_cache'])?'checked="checked"':'');?> /> <label for="make_html" title="글을 HTML파일에 따로 저장해서 해당 글을 읽는 페이지 전체의 DB부하를 감소시킵니다.">HTML파일로 글읽기</label></div>
			</div>
		</fieldset>
		<div class="clr"></div>
		<div class="btn">
			<img src="<?php echo $grblog; ?>image/darkgray/button.write.minidic.gif" onclick="window.open('http://endic.naver.com/small.naver?where=index','DirectSearch_Dic','width=405,height=500,resizable=no,scrollbars=no');" title="잘 생각나지 않는 단어(용어)를 검색합니다." />
			<img src="<?php echo $grblog; ?>image/darkgray/button.write.fileAttach.gif" onclick="file_upload();" title="첨부할 파일(.zip, .pdf 등) 이 있을 시 클릭하세요." />
			<img src="<?php echo $grblog; ?>image/darkgray/button.write.imageAttach.gif" onclick="post_upload();" title="첨부할 그림(사진) 이 있을 시 클릭하세요." />
			<input type="image" src="<?php echo $grblog; ?>image/darkgray/button.write.save.gif" onclick="set_value(0)" title="작성한 부분까지 저장 한 후 출판하지 않고 계속 작성합니다." />
			<input type="image" src="<?php echo $grblog; ?>image/darkgray/button.write.publish.gif" onclick="set_value(1);" title="작성을 완료하고 글을 블로그에 공개합니다." />
			<input type="image" src="<?php echo $grblog; ?>image/darkgray/button.write.notice.gif" onclick="set_value(2);" title="작성을 완료하고 글을 공지글로 합니다." />
		</div>
		<!-- 글 작성 완료 상태 -->
		<div id="writeStatus" style="display: none"></div>
	</div>
</div>
<!--# 새글 작성 -->

</form>