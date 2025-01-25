<?php
if(!defined('__GRBOARD__')) exit();

// 글쓰기 상단 타이틀
if($mode) $writeTitle = '기존의 글을 수정합니다';
else $writeTitle = '새로운 게시물을 작성합니다';
?>
<!-- 게시판 시작 -->
<div id="GRBOARD">

<!-- 글작성 폼 시작 (이 부분은 수정하지 마세요) -->
<form id="write" method="post" action="<?php echo $grboard; ?>/write_ok.php" onsubmit="return checkWriteValue(<?php echo $isMember; ?>);" enctype="multipart/form-data">
<div><input type="hidden" name="mode" value="<?php echo $mode; ?>" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" />
<input type="hidden" name="autosaveTime" value="<?php echo time(); ?>" />
<input type="hidden" name="isReported" value="<?php echo $isReported; ?>" />
<input type="hidden" name="ext_no_interest" value="0" /></div>

<!-- 글 작성 상태 -->
<div class="writeTitle" ><?php echo $writeTitle; ?></div>

<!-- 옵션 -->
<div class="writeRight">
<ul class="noneStyle">	
	<!-- 비밀글 여부 -->
	<li><input type="checkbox" name="is_secret" value="1" <?php echo (($modify['is_secret'])?'checked="checked"':''); ?> /> 
	<span title="체크하면 비밀글로 등록되어 작성자와 이 게시판 마스터, 관리자만이 볼 수 있습니다">비밀글로 설정</span> (글 작성자와 관리자만 볼 수 있습니다.)</li>
	<!-- 경고문구 여부 -->
	<li><input type="checkbox" name="is_alert" value="1" <?php echo (($modify['bad'] && $modify['bad']<-10)?'checked="checked"':''); ?> onclick="useAlert();" /> 
	<span title="체크하면 글보기 시 경고문구를 먼저 보여주고 사용자가 클릭 시 본문을 보도록 합니다">경고문구 부착</span> (글 보기시 경고문구를 클릭해야 본문이 보입니다.)</li>
	<?php 
	// 관리자 혹은 마스터만 가능 (공지글 지정)
	if($isAdmin or $isMaster) { ?><li><input type="checkbox" name="is_notice" value="1" <?php echo (($modify['is_notice'])?'checked="checked"':''); ?> /> <span>공지글로 설정</span> (이 게시판 맨 윗줄에 매달아 놓습니다.)</li>
	<?php } 
	// 자동폭파 지정
	if($tmpFetchBoard['is_bomb']) { 
		$getBomb = @mysql_fetch_array(mysql_query("select * from {$dbFIX}time_bomb where id = '$id' and article_num = '$articleNo'"));
		$bombTime = date('m월 d일 H시 i분', $getBomb['set_time']);
	?>
	<li><input type="checkbox" name="is_timebomb" value="1" <?php echo (($getBomb['no'])?'checked="checked"':''); ?> onclick="useBomb();" />
	<span title="체크하면 설정한 폭파시간 이후에 읽혀질 경우 글이 자동으로 삭제 됩니다">자동폭파 설정</span> (지정된 시간이 지나면 이 글은 삭제됩니다.)</li>
	<!-- 자동폭파 시간 설정 -->
	<div id="setBomb" style="display: none">
		<?php if($getBomb['no']) { ?>
		<span style="color: red">※ 이 게시물은 <?php echo $bombTime; ?>에 폭파되도록 설정되어 있습니다.</span>
		<?php } else { ?><input type="text" name="bombTime" value="10" /> 
		<select name="bombTerm"><option value="60">분</option><option value="3600">시간</option><option value="86400">일</option></select>
		뒤에 읽혀지면 폭파됨
		<?php } ?>
	</div>
	<?php } ?>
	<!-- 댓글 입력 허용하기 여부 -->
	<li><input type="checkbox" name="option_reply_open" value="1" <?php echo (($modify['option_reply_open'] || !$mode)?'checked="checked"':''); ?> /> 
	<span title="체크하면 이 게시물에 상품평 작성을 허용합니다.">상품평 작성 허용하기</span> (이 글에 고객들이 상품평을 입력할 수 있도록 합니다.)</li>
	<!-- 댓글 알리미 사용하기 여부 -->
	<li><input type="checkbox" name="option_reply_notify" value="1" <?php echo (($modify['option_reply_notify'])?'checked="checked"':''); ?> /> 
	<span title="체크하면 이 게시물에 상품평이 달릴 때 쪽지로 알려줍니다.">상품평을 쪽지로 알려주기</span> (상품평이 달리면 쪽지함으로 메시지를 받습니다.)</li>
</ul>
</div>

<!-- 카테고리, 오픈 아이디 사용 여부 선택 -->
<ul id="inputBoxs">
	<li><div class="writeRight">
	<?php
	// 분류(카테고리)
	if($isCategory) echo $category;

	// 오픈아이디를 허용한다면 옵션 제공
	if($tmpFetchBoard['is_openid'] && !$_SESSION['no']) { ?>
	<input type="radio" name="inputType" id="useNormal" value="1" checked="checked" style="vertical-align: middle" onclick="setOpenid(false);" /> <label for="useNormal">일반적인 정보입력</label>
	<input type="radio" name="inputType" id="useOpenid" value="2" style="vertical-align: middle" onclick="setOpenid(true);" /> <label for="useOpenid">오픈아이디(OpenID) 사용</label>
	<?php } ?>
	</div></li>
</ul>

<?php
// 비회원일 시 입력할 항목들 (이름, 비밀번호, 자동입력방지 → 필수 / 이메일, 홈페이지 → 선택)
if(!$isMember) { ?>

<!-- 일반적인 정보입력 -->
<div id="normalInput"><div>
<ul class="noneStyle">
	<!-- 이름 받기 -->
	<li><span style="padding-right: 10px"><strong>이름:</strong></span> <input type="text" name="name" class="miniInput" value="<?php echo $modify['name']; ?>" /> &nbsp;&nbsp;&nbsp;&nbsp;
	<strong>비밀번호:</strong> <input type="password" class="miniInput" name="password" /></li>
	<!-- 이메일 받기 -->
	<li>이메일: <input type="text" name="email" class="miniInput" value="<?php echo $modify['email']?>" /> &nbsp;&nbsp;&nbsp;&nbsp;
	<span style="padding-right: 4px">홈페이지:</span> <input type="text" name="homepage" class="miniInput" value="<?php echo $modify['homepage']; ?>" /></li>
	<!-- 자동등록방지 받기 -->
	<li><strong>자동입력방지:</strong> <input type="text" name="antispam" class="input" style="width: 118px" /> (<strong><?php echo $antiSpam0.$antiSpam3.$antiSpam1; ?>=?</strong> 의 답을 입력해 주세요.)</li>
</ul>
</div></div>

<!-- 오픈아이디로 입력 -->
<div id="openidInput" style="display: none"><div>
<ul class="noneStyle">
	<li><span style="padding-right: 10px"><strong>오픈아이디:</strong></span><input type="text" name="openid_url" class="openid" /> (입력예: http://exam.myid.net)<br />
	(※ 트랙백 보내기와 파일 첨부는 사용 하실 수 없습니다.)</li>
</ul>
</div></div>

<?php } # 비회원일시 입력할 항목들 받기 끝 ?>

<!-- 제목, 태그 등의 핵심정보 입력 -->
<ul class="noneStyle">
	<!-- 제목 받기 -->
	<li><input type="text" name="subject" class="input" value="<?php echo $subject; ?>" /> : 상품명</li>
	<li><input type="text" name="ext_money_original" class="miniInput" value="<?php echo $modify['ext_money_original']; ?>" /> : 판매가 (정가, 숫자만 입력. 예: 350000)</li>
	<li><input type="text" name="ext_money_real" class="miniInput" value="<?php echo $modify['ext_money_real']; ?>" /> : 할인된 판매가 (실제 판매가, 숫자만 입력. 예: 315000)</li>
	<li><input type="text" name="ext_money_save" class="miniInput" value="<?php echo $modify['ext_money_save']; ?>" /> : 적립금 (숫자만 입력. 예: 5000)</li>
	<li><input type="text" name="ext_number_get" class="miniInput" value="<?php echo $modify['ext_number_get']; ?>" /> : 한번에 구매 가능한 수량 (100 이하의 숫자만 입력. 예: 20)</li>
	<li><input type="text" name="ext_transport_cost" class="miniInput" value="<?php echo $modify['ext_transport_cost']; ?>" /> : 배송비 (숫자만 입력. 예: 0)</li>
	<li><input type="text" name="ext_transport_term" class="miniInput" value="<?php echo $modify['ext_transport_term']; ?>" /> : 배송기간 (일日 단위. 숫자만 입력. 예: 2)</li>
	<li><input type="text" name="ext_from_made" class="input" value="<?php echo $modify['ext_from_made']; ?>" /> : 제조사/원산지</li>
	<li><input type="text" name="ext_exchange_info" class="miniInput" value="<?php echo $modify['ext_exchange_info']; ?>" /> : 반품/교환안내 (예: 상품확인 후 7일내 환불)</li>
	<li><input type="text" name="ext_product_code" class="miniInput" value="<?php echo $modify['ext_product_code']; ?>" /> : 상품코드 (예: A000B1234C56)</li>
	<li><input type="text" name="ext_etc_info" class="miniInput" value="<?php echo $modify['ext_etc_info']; ?>" /> : 기타안내 (예: 주문하실 때 색상도 지정해 주세요)</li>
</ul>

<!-- 기본 첨부파일 기능 : 사용안함 → 멀티업로드 기능으로 대체 -->
<div id="fileUploadField"><div>
<ul class="noneStyle">
<?php
// 파일 첨부 시작
if(isset($totalFiles)) {

	/**** 기본 첨부기능 숨기기 ****
	// 개수 부르기
	for($tmp=1; $tmp<=$totalFiles; $tmp++) { ?>
	<li><span style="padding-right: 8px">파일 #<?php echo $tmp; ?>:</span> <input type="file" name="file<?php echo $tmp; ?>" class="input" /></li>
	<?php 
	// 파일이 이미 올려져 있을 때
	if($oldFile[$tmp-1]) { ?>
	<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span class="fileExist"><strong><?php echo end(explode('/', $oldFile[$tmp-1])); ?></strong> 은 이미 올려져 있습니다.
	<input type="checkbox" name="delete<?php echo $tmp; ?>" value="<?php echo $oldFile[$tmp-1]; ?>">삭제하기</span></li>
	<?php 
		}
	}
	**** 기본 첨부기능 숨기기 끝 ****/

	// 추가 첨부파일이 올려져 있을 때 (글수정시)
	if($mode == 'modify') {
		$getExtendPds = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
		while($extPds = @mysql_fetch_array($getExtendPds)) { ?>
		<li><span class="fileExist">+ <strong><?php echo end(explode('/', $extPds['file_route'])); ?></strong> 이 추가로 첨부되어 있습니다.
		<input type="checkbox" name="deleteExtendPds[]" value="<?php echo $extPds['no']; ?>">삭제하기</span></li>
		<?php
		} #while
	} #if

	// 추가 무한 첨부 기능
	?>
	<li>
		<div class="extendUploadBtn"><span id="swfUpBtnforGRBOARD"></span> <input id="btnCancel" type="button" value="멀티업로드 취소" onclick="swfu.cancelQueue();" disabled="disabled" title="클릭하시면 멀티업로드로 업로드중이던 파일 전송을 취소합니다." /></div>
		<div id="extendUploads"></div>
		<div id="flashHistory" style="display: none"><div id="fsUploadProgress"></div></div>
		<div id="divStatus">0 Files Uploaded</div>
	</li>
	<?php
}
?>
</ul></div></div>

<!-- 글작성 폼. 웹에디터 사용시 TinyMCE 웹에디터로 감싸게 됨. -->
<div id="editableBox"><textarea name="content" class="textarea" rows="15"><?php echo $content; ?></textarea></div>

<!-- 태그, 링크 등의 부수정보 입력 -->
<ul class="noneStyle">
	<!-- 링크 #1, 2 받기 -->
	<li>링크 1: <input type="text" name="link1" size="73" class="input" value="<?php echo $modify['link1']; ?>" /></li>
	<li>링크 2: <input type="text" name="link2" size="73" class="input" value="<?php echo $modify['link2']; ?>" /></li>
	<!-- 태그 (꼬리표) 받기 : 콤마로 구분 -->
	<li>꼬리표: <input type="text" name="tag" class="input" onkeydown="tagAssist(this.value, '<?php echo $id; ?>');" style="width: 350px" value="<?php echo $modify['tag']; ?>" title="태그(tag/꼬리표)를 통해 글의 핵심단어를 보여줄 수 있습니다." /> ( <strong>,</strong> 콤마로 단어 구분)
	<div id="searchTags" style="display: none"></div></li>
	<?php if(!$mode) { ?><li><span title="다른 게시판/블로그에 관련된 글을 원거리에서 달 수 있습니다.">트랙백:</span> <input type="text" name="trackback" size="73" class="input" value="<?php echo $modify['trackback']; ?>" title="다른 게시판/블로그에 관련된 글을 원거리에서 달 수 있습니다." /></li><?php } ?>
</ul>

<!-- 작성버튼들 (미니사전, 설문조사, 글 복구, 임시저장, 작성완료, 작성취소) -->
<div id="btnBox" style="padding-top: 15px; text-align: center">
	<input type="button" value="미니사전" onclick="window.open('http://endic.naver.com/small.naver?where=index','DirectSearch_Dic','width=405,height=500,resizable=no,scrollbars=no');" title="네이버 미니사전 열기" />
	<input type="button" value="설문조사" onclick="inputPoll('<?php echo $grboard.'/'.$theme; ?>', '<?php echo $id; ?>');" title="설문조사를 작성합니다. 클릭 후 팝업창이 뜨면 그 곳에 안내된 대로 설문을 작성해서 넣어보세요." /> 
	<input type="button" value="글 복구" onclick="window.open('autosave.php', '_blank', 'width=550,height=650,menubar=no,scrollbars=yes'); return false" title="마지막으로 저장된 글을 가져옵니다." /> 
	<input type="button" value="임시저장" onclick="autosave();" title="임시로 글제목과 내용을 저장하고, 계속해서 글을 작성합니다. (자주 눌러주세요!)" /> 
	<input type="submit" value="작성완료" accesskey="s" title="글을 작성 완료 합니다." /> 
	<input type="button" value="작성취소" onclick="isCancel('<?php echo $id; ?>');" title="게시물 작성을 취소합니다" />
</div>
</form>

<!-- 임시저장 안내 메시지 -->
<div id="writePreviewBox"><img src="<?php echo $grboard; ?>/image/icon/poll_icon.gif" alt="" /> [임시저장] 버튼을 자주 눌러주세요. 불의의 사고로 작성중인 글이 삭제되는 것을 방지합니다.</div>

<!-- TinyMCE 설정 -->
<script type="text/javascript">//<![CDATA[
var USE_EDITOR = false;
//]]></script>
<?php if($tmpFetchBoard['is_editor']) { ?>
<script type="text/javascript" src="<?php echo $grboard; ?>/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">//<![CDATA[
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "table,save,advhr,advimage,advlink,insertdatetime,emotions,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,inlinepopups",
	theme_advanced_buttons1_add_before : "save,newdocument",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "forecolor,backcolor,insertdate,inserttime",
	theme_advanced_buttons2_add_before: "cut,copy,paste,search,replace",
	theme_advanced_buttons3_add_before : "tablecontrols,preview",
	theme_advanced_buttons3_add : "emotions,media,advhr,print,fullscreen",
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

function fileBrowserCallBack(field_name, url, type, win) {
	win.document.forms[0].elements[field_name].value = "<?php echo $_SERVER['HTTP_HOST']; ?>";
}

var USE_EDITOR = true;
var GRBOARD = '<?php echo $grboard; ?>';
var THEME = '<?php echo $theme; ?>';
var BBS_ID = '<?php echo $id; ?>';
var SESS_ID = '<?php echo session_id(); ?>';
//]]></script>
<?php } ?>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/effects.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/swfupload.js"></script> 
<script type="text/javascript" src="<?php echo $grboard; ?>/js/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/handlers.js"></script>
<script type="text/javascript" src="<?php echo $grboard.'/'.$theme; ?>/write.js"></script>
</div><!--# 게시판 끝 -->