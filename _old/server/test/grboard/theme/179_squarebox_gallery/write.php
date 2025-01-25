<?php
if(!defined('__GRBOARD__')) exit();

// 글쓰기 상단 타이틀
if($mode) $writeTitle = '既存の記事を修正します。';
else $writeTitle = '新しい記事を作成します。';

// 헤더 영역 불러오기
include $theme . '/head.php';
?>

<!-- 글작성 폼 시작 (이 부분은 수정하지 마세요) -->
<form id="write" method="post" action="<?php echo $grboard; ?>/write_ok.php" onsubmit="return checkWriteValue(<?php echo $isMember; ?>);" enctype="multipart/form-data">
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
</div>



<!-- 제목, 태그 등의 핵심정보 입력 -->
<ul class="noneStyle">
	<!-- 제목 받기 -->
	<li><span style="padding-right: 8px"><strong>タイトル:</strong></span> <input type="text" name="subject" size="73" class="input" value="<?php echo $subject?>" /></li>
</ul>

<!-- 트랙백 주소 받기 -->
<div id="fileUploadField"><div><ul class="noneStyle">

<?php
// 기본 파일 첨부 시작
if(isset($totalFiles)) {
	// 개수 부르기
	for($tmp=1; $tmp<=$totalFiles; $tmp++) { ?>
	<li><span style="padding-right: 8px">イメージ<?php echo $tmp; ?>:</span> <input type="file" name="file<?php echo $tmp; ?>" class="input" /></li>
	<?php 
	// 파일이 이미 올려져 있을 때
	if($oldFile[$tmp-1]) { ?>
	<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span class="fileExist"><strong><?php echo end(explode('/', $oldFile[$tmp-1])); ?></strong> は既にアップされています。
	<input type="checkbox" name="delete<?php echo $tmp; ?>" value="<?php echo $oldFile[$tmp-1]; ?>">削除</span></li>
	<?php 
		}
	}
} # 기본 파일 첨부 기능 끝
?>
</ul></div></div>

<!-- 글작성 폼. 웹에디터 사용시 TinyMCE 웹에디터로 감싸게 됨. -->
<div id="editableBox"><textarea name="content" class="textarea" rows="15" style="height:200px;"><?php echo $content; ?></textarea></div>

<!-- 작성버튼들 (미니사전, 설문조사, 글 복구, 임시저장, 작성완료, 작성취소) -->
<div id="btnBox" style="padding-top: 15px; text-align: center">
	<input type="submit" value="作成完了" accesskey="s" /> 
	<input type="button" value="作成取消" onclick="isCancel('<?php echo $id; ?>');" />
</div>
</form>

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
	plugins : "table,save,advhr,advimage,advlink,insertdatetime,emotions,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,inlinepopups,autosave",
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
	forced_root_block : false,
	theme_advanced_fonts : "굴림=굴림;굴림체=굴림체;궁서=궁서;궁서체=궁서체;돋움=돋움;돋움체=돋움체;바탕=바탕;바탕체=바탕체;맑은고딕=Malgun Gothic;나눔고딕=나눔고딕;나눔명조=나눔명조;다음체=다음_Regular;Arial=Arial; Comic Sans MS='Comic Sans MS';Courier New='Courier New';Tahoma=Tahoma;Times New Roman='Times New Roman';Verdana=Verdana"
});

function fileBrowserCallBack(field_name, url, type, win) {
	win.document.forms[0].elements[field_name].value = "<?php echo $_SERVER['HTTP_HOST']; ?>";
}

var USE_EDITOR = true;
var GRBOARD = '<?php echo $grboard; ?>';
//]]></script>
<?php } ?>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/effects.js"></script>
<script type="text/javascript" src="<?php echo $grboard.'/'.$theme; ?>/write.js"></script>
</div><!--# 게시판 끝 -->