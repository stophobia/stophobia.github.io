<?php
if(!defined('__GRBOARD__')) exit();

// 글쓰기 상단 타이틀
if($mode) $writeTitle = '기존의 글을 수정합니다';
else $writeTitle = '새로운 게시물을 작성합니다';

// 헤더 영역 불러오기
include $theme . '/head.php';
?>

<!-- 글작성 폼 시작 (이 부분은 수정하지 마세요) -->
<form name="write" id="write" method="post" action="<?php echo $grboard; ?>/write_ok.php" enctype="multipart/form-data" accept-charset="utf-8">
<div><input type="hidden" name="mode" value="<?php echo $mode; ?>" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" />
<input type="hidden" name="autosaveTime" value="<?php echo time(); ?>" />
<input type="hidden" name="isReported" value="<?php echo $isReported; ?>" />
<input type="hidden" name="clickCategory" value="<?php echo $clickCategory; ?>" /></div>

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
	<span title="체크하면 이 게시물에 댓글을 허용합니다.">댓글 허용하기</span> (이 글에 댓글입력을 허용합니다.)</li>
	<!-- 댓글 알리미 사용하기 여부 -->
	<li><input type="checkbox" name="option_reply_notify" value="1" <?php echo (($modify['option_reply_notify'])?'checked="checked"':''); ?> /> 
	<span title="체크하면 이 게시물에 댓글이 달릴 때 쪽지로 알려줍니다.">댓글을 쪽지로 알려주기</span> (댓글이 달리면 쪽지함으로 메시지를 받습니다.)</li>
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
	<li><span style="padding-right: 3px"><strong>제 &nbsp;&nbsp; 목:</strong></span> <input type="text" name="subject" id="subject" size="73" class="input" value="<?php echo $subject?>" /></li>
	<!-- 태그 (꼬리표) 받기 : 콤마로 구분 -->
	<li><span style="padding-right: 6px">꼬 리 표:</span> <input type="text" name="tag" class="input" onkeydown="tagAssist(this.value, '<?php echo $id; ?>');" style="width: 350px" value="<?php echo $modify['tag']; ?>" title="태그(tag/꼬리표)를 통해 글의 핵심단어를 보여줄 수 있습니다." /> ( <strong>,</strong> 콤마로 단어 구분)
	<div id="searchTags" style="display: none"></div></li>
	<!-- 링크 #1, 2 받기 -->
	<li><span style="padding-right: 5px">링크 # 1:</span> <input type="text" name="link1" size="73" class="input" value="<?php echo $modify['link1']; ?>" /></li>
	<li><span style="padding-right: 5px">링크 # 2:</span> <input type="text" name="link2" size="73" class="input" value="<?php echo $modify['link2']; ?>" /></li>
</ul>

<!-- 트랙백 주소 받기 -->
<div id="fileUploadField"><div><ul class="noneStyle">
	<?php if(!$mode) { ?><li><span style="padding-right: 6px" title="다른 게시판/블로그에 관련된 글을 원거리에서 달 수 있습니다.">트 랙 백:</span> <input type="text" name="trackback" size="73" class="input" value="<?php echo $modify['trackback']; ?>" title="다른 게시판/블로그에 관련된 글을 원거리에서 달 수 있습니다." /></li><?php } ?>

<?php
// 파일 첨부 시작
if(isset($totalFiles)) {
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

	// 추가 첨부파일이 올려져 있을 때 (글수정시) | 2010-01-30 Coder 컴센스 , Editor 이동규
  if($mode == 'modify') {
  $getExtendPds = @mysql_query("select no, file_route from ".$dbFIX."pds_extend where id = '".$id."' and article_num = ".$articleNo);
  while($extPds = @mysql_fetch_array($getExtendPds)) {
  $getPdsList = @mysql_fetch_array(mysql_query('select no, name from '.$dbFIX.'pds_list where type = 1 and uid = '.$extPds['no']));
  if($getPdsList['no']) $filename = end(explode('/', $getPdsList['name']));
  ?>
  <li>              
  <span class="fileExist">+ <strong><?php echo $filename;  ?></strong> 이 추가로 첨부되어 있습니다.
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

<!-- 글작성 폼. 웹에디터 사용시 Daum Editor 로 감싸게 됨. -->
<div id="tx_trex_container" class="tx-editor-container">
	<div id="tx_sidebar" class="tx-sidebar">
		<div class="tx-sidebar-boundary">

		<!-- 사이드바 / 첨부 -->
		<ul class="tx-bar tx-bar-left tx-nav-attach">
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-lbg tx-bold" id="tx_bold">
					<a href="javascript:;" class="tx-icon" title="굵게 (Ctrl+B)">굵게</a>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-bg tx-underline" id="tx_underline">
					<a href="javascript:;" class="tx-icon" title="밑줄 (Ctrl+U)">밑줄</a>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-bg tx-italic" id="tx_italic">
					<a href="javascript:;" class="tx-icon" title="기울임 (Ctrl+I)">기울임</a>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-bg tx-strike" id="tx_strike">
					<a href="javascript:;" class="tx-icon" title="취소선 (Ctrl+D)">취소선</a>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-slt-tbg tx-forecolor" style="background-color:#5c7fb0;" id="tx_forecolor">
					<a href="javascript:;" class="tx-icon" title="글자색">글자색</a>
					<a href="javascript:;" class="tx-arrow" title="글자색 선택">글자색 선택</a>
				</div>
				<div id="tx_forecolor_menu" class="tx-menu tx-forecolor-menu tx-colorpallete" unselectable="on"></div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-slt-brbg tx-backcolor" style="background-color:#5c7fb0;" id="tx_backcolor">
					<a href="javascript:;" class="tx-icon" title="글자 배경색">글자 배경색</a>
					<a href="javascript:;" class="tx-arrow" title="글자 배경색 선택">글자 배경색 선택</a>
				</div>
				<div id="tx_backcolor_menu" class="tx-menu tx-backcolor-menu tx-colorpallete" unselectable="on"></div>
			</li>
		</ul>

		<!-- 사이드바 / 우측영역 -->
		<ul class="tx-bar tx-bar-right tx-nav-opt">
			<li class="tx-list">
				<div unselectable="on" class="tx-switchtoggle" id="tx_switchertoggle">
					<a href="javascript:;" title="에디터 타입">에디터</a>
				</div>
			</li>
		</ul>
	</div>
</div>
	
<div id="tx_toolbar_basic" class="tx-toolbar tx-toolbar-basic">
	<div class="tx-toolbar-boundary">
				
		<ul class="tx-bar tx-bar-left tx-group-align"> 
			<li class="tx-list">
				<div unselectable="on" class="tx-slt-42bg tx-fontsize" id="tx_fontsize">
					<a href="javascript:;" title="글자크기">9pt</a>
				</div>
				<div id="tx_fontsize_menu" class="tx-fontsize-menu tx-menu" unselectable="on"></div>
			</li>
			<li class="tx-list">
				<div id="tx_fontfamily" unselectable="on" class="tx-slt-70bg tx-fontfamily">
					<a href="javascript:;" title="글꼴">굴림</a>
				</div>
				<div id="tx_fontfamily_menu" class="tx-fontfamily-menu tx-menu" unselectable="on"></div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-lbg tx-alignleft" id="tx_alignleft">
					<a href="javascript:;" class="tx-icon" title="왼쪽정렬 (Ctrl+,)">왼쪽정렬</a>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-bg tx-aligncenter" id="tx_aligncenter">
					<a href="javascript:;" class="tx-icon" title="가운데정렬 (Ctrl+.)">가운데정렬</a>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-bg tx-alignright" id="tx_alignright">
					<a href="javascript:;" class="tx-icon" title="오른쪽정렬 (Ctrl+/)">오른쪽정렬</a>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-rbg tx-alignfull" id="tx_alignfull">
					<a href="javascript:;" class="tx-icon" title="양쪽정렬">양쪽정렬</a>
				</div>
			</li>
		</ul>
		
		<ul class="tx-bar tx-bar-left tx-group-tab"> 
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-lbg tx-indent" id="tx_indent">
					<a href="javascript:;" title="들여쓰기 (Tab)" class="tx-icon">들여쓰기</a>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-rbg tx-outdent" id="tx_outdent">
					<a href="javascript:;" title="내어쓰기 (Shift+Tab)" class="tx-icon">내어쓰기</a>
				</div>
			</li>
		</ul>
		
		<ul class="tx-bar tx-bar-left tx-group-list">
			<li class="tx-list">
				<div unselectable="on" class="tx-slt-31rbg tx-styledlist" id="tx_styledlist">
					<a href="javascript:;" class="tx-icon" title="리스트">리스트</a>
					<a href="javascript:;" class="tx-arrow" title="리스트">리스트 선택</a>
				</div>
				<div id="tx_styledlist_menu" class="tx-styledlist-menu tx-menu" unselectable="on"></div>
			</li>
		</ul>
				
		<ul class="tx-bar tx-bar-left tx-group-etc">
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-lbg tx-emoticon" id="tx_emoticon">
					<a href="javascript:;" class="tx-icon" title="이모티콘">이모티콘</a>
				</div>
				<div id="tx_emoticon_menu" class="tx-emoticon-menu tx-menu" unselectable="on"></div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-bg tx-link" id="tx_link">
					<a href="javascript:;" class="tx-icon" title="링크 (Ctrl+K)">링크</a>
				</div>
				<div id="tx_link_menu" class="tx-link-menu tx-menu"></div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-bg tx-specialchar" id="tx_specialchar">
					<a href="javascript:;" class="tx-icon" title="특수문자">특수문자</a>
				</div>
				<div id="tx_specialchar_menu" class="tx-specialchar-menu tx-menu"></div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-bg tx-table" id="tx_table">
					<a href="javascript:;" class="tx-icon" title="표만들기">표만들기</a>
				</div>
				<div id="tx_table_menu" class="tx-table-menu tx-menu" unselectable="on">
					<div class="tx-menu-inner">
						<div class="tx-menu-preview"></div>
						<div class="tx-menu-rowcol"></div>
						<div class="tx-menu-deco"></div>
						<div class="tx-menu-enter"></div>
					</div>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-rbg tx-horizontalrule" id="tx_horizontalrule">
					<a href="javascript:;" class="tx-icon" title="구분선">구분선</a>
				</div>
				<div id="tx_horizontalrule_menu" class="tx-horizontalrule-menu tx-menu" unselectable="on"></div>
			</li>
		</ul>
				
		<ul class="tx-bar tx-bar-left"> 
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-lbg tx-textbox" id="tx_textbox">
					<a href="javascript:;" class="tx-icon" title="글상자">글상자</a>
				</div>		
				<div id="tx_textbox_menu" class="tx-textbox-menu tx-menu"></div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-bg tx-quote" id="tx_quote">
					<a href="javascript:;" class="tx-icon" title="인용구 (Ctrl+Q)">인용구</a>
				</div>
				<div id="tx_quote_menu" class="tx-quote-menu tx-menu" unselectable="on"></div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-rbg tx-dictionary" id="tx_dictionary">
					<a href="javascript:;" class="tx-icon" title="사전">사전</a>
				</div>
			</li>
		</ul> 
				
		<ul class="tx-bar tx-bar-left tx-group-undo"> 
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-lbg tx-undo" id="tx_undo">
					<a href="javascript:;" class="tx-icon" title="실행취소 (Ctrl+Z)">실행취소</a>
				</div>
			</li>
			<li class="tx-list">
				<div unselectable="on" class="tx-btn-rbg tx-redo" id="tx_redo">
					<a href="javascript:;" class="tx-icon" title="다시실행 (Ctrl+Y)">다시실행</a>
				</div>
			</li>
		</ul>
			
	</div>
</div>

<div id="tx_canvas" class="tx-canvas">
	<div id="tx_loading" class="tx-loading"><div><img src="daumEditor/images/icon/loading2.png?rv=1.0.1" width="113" height="21" align="absmiddle"/></div></div>
	<div id="tx_canvas_wysiwyg_holder" class="tx-holder" style="display:block;">
		<iframe id="tx_canvas_wysiwyg" name="tx_canvas_wysiwyg" allowtransparency="true" frameborder="0"></iframe>
	</div>
	<div class="tx-source-deco">
		<div id="tx_canvas_source_holder" class="tx-holder">
			<textarea id="tx_canvas_source" rows="30" cols="30"></textarea>
		</div>
	</div>
	<div id="tx_canvas_text_holder" class="tx-holder">
		<textarea id="tx_canvas_text" rows="30" cols="30"></textarea>
	</div>	
</div>

<!-- 높이조절 Start -->
<div id="tx_resizer" class="tx-resize-bar">
	<div class="tx-resize-bar-bg"></div>
	<img id="tx_resize_holder" src="daumEditor/images/icon/btn_drag01.gif" width="58" height="12" unselectable="on" alt="" />
</div>

<!-- 파일첨부박스 Start -->
<div id="tx_attach_div" class="tx-attach-div">
	<div id="tx_attach_txt" class="tx-attach-txt">파일 첨부</div>
	<div id="tx_attach_box" class="tx-attach-box">
		<div class="tx-attach-box-inner">
			<div id="tx_attach_preview" class="tx-attach-preview"><p></p><img src="daumEditor/images/icon/pn_preview.gif" width="147" height="108" unselectable="on"/></div>
			<div class="tx-attach-main">
				<div id="tx_upload_progress" class="tx-upload-progress"><div>0%</div><p>파일을 업로드하는 중입니다.</p></div>
				<ul class="tx-attach-top">
					<li id="tx_attach_delete" class="tx-attach-delete"><a>전체삭제</a></li>
					<li id="tx_attach_size" class="tx-attach-size">
						파일: <span id="tx_attach_up_size" class="tx-attach-size-up"></span>/<span id="tx_attach_max_size"></span>
					</li>
					<li id="tx_attach_tools" class="tx-attach-tools">
					</li>
				</ul>
				<ul id="tx_attach_list" class="tx-attach-list"></ul>
			</div>
		</div>
	</div>
</div>

<!-- 작성버튼들 (미니사전, 설문조사, 글 복구, 임시저장, 작성완료, 작성취소) -->
<div id="btnBox" style="padding-top: 15px; text-align: center">
	<input type="button" value="설문조사" onclick="inputPoll('<?php echo $grboard.'/'.$theme; ?>', '<?php echo $id; ?>');" title="설문조사를 작성합니다. 클릭 후 팝업창이 뜨면 그 곳에 안내된 대로 설문을 작성해서 넣어보세요." /> 
	<input type="button" value="작성완료" accesskey="s" onclick="Editor.save(); return false" title="글을 작성 완료 합니다." /> 
	<input type="button" value="작성취소" onclick="isCancel('<?php echo $id; ?>');" title="게시물 작성을 취소합니다" />
</div>
</form>

<!-- 임시저장 안내 메시지 -->
<div id="writePreviewBox"><img src="<?php echo $grboard; ?>/image/icon/poll_icon.gif" alt="" /> [임시저장] 버튼을 자주 눌러주세요. 불의의 사고로 작성중인 글이 삭제되는 것을 방지합니다.</div>

<?php if($mode == 'modify') { ?>
<textarea id="tx_load_content"><?php echo str_replace('src="data/', 'src="../../data/', $content); ?></textarea>
<?php } ?>

<!-- Daum Editor 설정 -->
<script src="daumEditor/js/editor.js" type="text/javascript" charset="utf-8"></script>
<script src="daumEditor/js/editor_sample.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">//<![CDATA[
function validForm(editor) { 
	if($tx('subject').value == ""){
		alert('제목을 입력하세요');
		$tx('subject').focus();
		return false;
	}

	var _validator = new Trex.Validator();
	var _content = editor.getContent();
	if(!_validator.exists(_content)) {
		alert('내용을 입력하세요');
		return false;
	}
	return true;
}

function setForm(editor) {
	var _formGen = editor.getForm();
	
	var _content = editor.getContent();
	_formGen.createField(
		tx.textarea({ 
			'name': "content", 
			'style': { 'display': "none" } 
		}, 
		_content)
	);
	return true;
}
var GRBOARD = '<?php echo $grboard; ?>';
var THEME = '<?php echo $theme; ?>';
var BBS_ID = '<?php echo $id; ?>';
var SESS_ID = '<?php echo session_id(); ?>';

new Editor({
	txHost: '',
	txPath: '<?php echo $grboard; ?>/daumEditor/',
	txVersion: '5.3.0',
	txService: 'sample',
	txProject: 'sample',
	initializedId: "",
	wrapper: "tx_trex_container"+"",
	form: 'write'+"",
	txIconPath: "daumEditor/images/icon/",
	txDecoPath: "<?php echo $grboard; ?>/daumEditor/images/deco/",
	canvas: {
		styles: {
			color: "#666",
			fontFamily: "굴림",
			fontSize: "10pt",
			backgroundColor: "#fff",
			lineHeight: "1.5",
			padding: "8px"
		}
	},
	sidebar: {
		attacher: {
			image: {
				},
			file: {
			}
		}
	},
	size: {
		contentWidth: 550
	}
});

<?php if($mode == 'modify') { ?>
Editor.modify({
	"content": $tx("tx_load_content")
});
document.getElementById('tx_load_content').style.display = 'none';
<?php } ?>
//]]></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/swfupload.js"></script>  
<script type="text/javascript" src="<?php echo $grboard; ?>/js/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/handlers.js"></script>
<script type="text/javascript" src="<?php echo $grboard.'/'.$theme; ?>/write.js"></script>
</div><!--# 게시판 끝 -->