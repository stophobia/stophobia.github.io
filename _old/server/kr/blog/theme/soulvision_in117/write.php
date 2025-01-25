<div id="content">
<!-- 새글 작성 -->
<form id="new_post" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return post_write('write_');">
	<div id="modifyDIV"><input type="hidden" name="modifyTarget" value="<?php echo $modify['uid']; ?>" /></div>
	<div><input type="hidden" name="writer" value="<?php echo $config['name']; ?>" />
	<input type="hidden" name="writeID" value="<?php echo (($member['user_id'])?$member['user_id']:$config['id']); ?>" /></div>
	<div id="setting">
		<!-- 글 작성 완료 상태 -->
		<div id="writeStatus" style="display: none"></div>
		<div class="option">제목:</div>
		<div class="value"><input type="text" name="subject" class="t" value="<?php echo $modify['subject']; ?>" title="포스팅 제목을 입력해 주세요" /></div></td>
		<div class="option">내용:</div>
		<div class="value">
			<div><textarea name="write_content" id="write_content" rows="20" style="width: 98%"><?php echo $modify['content']; ?></textarea></div>
			<div id="autosaveMsg">"<strong>비밀글로 저장</strong>" 버튼을 자주 눌러주세요. 불의의 사고로 본문이 유실되는 것을 방지합니다.</div>
		</div>
		<div class="option">태그 ('<strong>,</strong>' 로 구분해서 입력해주세요 [예: 일상<strong>,</strong>행복]):</div> 
		<div class="value"><input type="text" name="tag" class="t" value="<?php echo $modify['tag']; ?>" title="태그(꼬리표)를 입력해주세요. 없을 시 비워두시면 됩니다." /></div>
		<div class="option">트랙백 보낼 곳: <select name="encoding" title="대부분 기본값을 쓰시면 되나, 네이버/다음/파란 등의 서비스형 블로그에는 EUC-KR 을 선택하셔야 합니다."><option value="utf-8">UTF-8 (티스토리/텍스트큐브, 워드프레스, GR블로그, 이글루스 등...)</option><option value="euc-kr">EUC-KR (네이버, 다음, 파란 등...)</option></select></div>
		<div class="value"><input type="text" name="trackback" class="t" value="<?php echo $modify['trackback']; ?>" title="트랙백(엮인글) 보낼 곳을 적어주세요. 없을 시 비워두시면 됩니다." /></div>
		<div class="option">카테고리:</div>
		<div id="viewCategory">
			<select name="category">
			<?php
			$getCategory = @mysql_query('select id, name from '.$dbFIX.'category');
			while($cat = mysql_fetch_array($getCategory)) { ?>
				<option value="<?php echo $cat['id']; ?>" <?php if($modify['category'] == $cat['id']) echo 'selected="selected"'; ?>><?php echo stripslashes($cat['name']); ?></option>
			<?php } ?>
			</select><input type="text" name="addNewCategory" class="i" title="추가할 카테고리명을 입력해주세요 (예: 나의취미)" /><input type="button" value="추가" class="s" onclick="addCategory();" />
		</div>
		<div id="listCategory">
			<ol>
			<?php
			$showCL = @mysql_query('select * from '.$dbFIX.'category');
			while($cl = mysql_fetch_array($showCL)) { ?>
				<li><?php echo $cl['name']; ?> <span onclick="delCategory('<?php echo addslashes($cl['name']); ?>');" title="이 카테고리를 삭제하기">ⓧ</span></li>
			<?php } ?>
			</ol>
		</div>
		<div class="clr"></div>
		<!-- 옵션설정 -->
		<fieldset id="optionBox">
			<legend>옵션설정</legend>
			<div id="options">
				<div id="openRSS"><input type="checkbox" id="open_rss" name="open_rss" value="1" checked="checked" /> <label for="open_rss">RSS 에 공개</label> (체크하시면 RSS 피드를 통해 외부로 글을 공개합니다.)</div>
				<div id="commentCondition"><input type="checkbox" id="comment_condition" name="comment_condition" value="1" checked="checked" /> <label for="comment_condition">댓글, 트랙백 허용</label> (방문객/멤버들의 댓글과 다른 블로거들의 트랙백을 받습니다.)</div>
				<div id="useSync"><input type="checkbox" id="use_sync" name="use_sync" value="1" /> <label for="use_sync">싱크넷에 출판하기</label> (체크하게 되면 시리니넷의 싱크넷에 글을 출판합니다.)</div>
				<div id="modifyTime"><input type="checkbox" id="modify_time" name="modify_time" value="1" <?php echo (($modifyTarget)?'checked="checked"':'');?> /> <label for="modify_time">작성시간 업데이트</label> (글을 수정했을 경우 체크하면 글쓴 시간을 현재로 수정합니다.)</div>
				<div id="makeHTML"><input type="checkbox" id="make_html" name="make_html" value="1" <?php echo (($modifyTarget)?'checked="checked"':'');?> /> <label for="make_html" title="글을 HTML파일에 따로 저장해서 해당 글을 읽는 페이지 전체의 DB부하를 감소시킵니다.">HTML파일로 글읽기</label> (체크하면 이 포스트를 HTML캐쉬로 저장해서 서버 부하를 줄입니다.)</div>
			</div>
		</fieldset>
		<div class="clr"></div>
		<div class="btn">
		<input type="button" value="미니사전" onclick="window.open('http://endic.naver.com/small.naver?where=index','DirectSearch_Dic','width=405,height=500,resizable=no,scrollbars=no');" title="잘 생각나지 않는 단어(용어)를 검색합니다." />
		<input type="button" value="파일 첨부" onclick="file_upload();" title="첨부할 파일(.zip, .pdf 등) 이 있을 시 클릭하세요." />
		<input type="button" value="그림 첨부" onclick="post_upload();" title="첨부할 그림(사진) 이 있을 시 클릭하세요." />
		<input type="submit" value="비밀글로 저장" onclick="set_value(0);" title="작성한 부분까지 저장 한 후 비공개 상태로 계속 작성합니다." />
		<input type="submit" value="작성완료" onclick="set_value(1);" title="작성을 완료하고 글을 공개합니다." />
		<input type="submit" value="공지로 작성" onclick="set_value(2);" title="작성을 완료하고 글을 공지글로 합니다." />
		</div>
	</div>
<!--# 새글 작성 -->
</form>

<!-- 자동 저장된 내용 확인 -->
<div id="autosaveCheck" style="display: none">
	<div id="autosaveTitle">마지막으로 자동 저장된 글내용입니다. &nbsp;(브라우저 쿠키 제거 시 삭제)</div>
	<div id="autosaveContent"></div>
</div>

</div>