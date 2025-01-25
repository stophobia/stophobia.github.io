// 전역 사용
var EXTEND_PDS = 0;

// 아이디접근
function $(id)
{
	return document.getElementById(id);
}

// 게시물 작성취소
function isCancel(id)
{
	if(confirm('정말로 게시물 작성을 취소하시겠습니까?\n\n작성하신 글은 모두 사라집니다.'))
	{
		location.href='board.php?id='+id;
	}
}

// 자동폭파 사용
function useBomb()
{
	t = document.forms["write"].elements["is_timebomb"];
	if(!confirm('정말로 이 게시물이 일정시간 후 자동 삭제되도록 하시겠습니까?\n\n'+
		'지정된 시간 이후에 게시물이 읽혀지면 게시물과 댓글, 첨부파일 등이 모두 삭제됩니다.\n\n'+
		'한 번 지정한 시간은 다시 수정되지 않으니 신중하게 설정해 주세요!')) {
		t.checked = false;
		return;
	} else t.checked = true;
	s = document.getElementById('setBomb');
	if(t.checked) s.style.display = '';
	else s.style.display = 'none';
}

// 경고문구 부착
function useAlert()
{
	t = document.forms["write"].elements["is_alert"];
	if(!confirm('정말로 이 게시물에 경고문구를 부착하시겠습니까?\n\n'+
		'읽는 이는 경고문구를 클릭한 후 게시물을 볼 수 있습니다.')) {
		t.checked = false;
	}
}

// 설문조사 사용 - 해제
function inputPoll(path, id)
{
	var l = parseInt((document.body.clientWidth / 2) - 250);
	window.open(path+'/poll.php?id='+id, 'poll', 'width=450,height=500,left='+l+',top=100,menubar=no,scrollbars=yes');
}

// 일반정보 or 오픈아이디
function setOpenid(s)
{
	var d = document;
	if(s) {
		d.getElementById('openidInput').style.display = ''; 
		d.getElementById('normalInput').style.display = 'none';
		d.getElementById('fileUploadField').style.display = 'none';
	} else {
		d.getElementById('normalInput').style.display = ''; 
		d.getElementById('openidInput').style.display = 'none';
		d.getElementById('fileUploadField').style.display = '';
	}
}

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// HTML 관련 문자 변환
function htmlencode(str)
{
	str = str_replace('&', '@amp;', str);
	str = str_replace('\\+', '@plus;', str);
	str = str_replace('%', '@percent;', str);
	str = str_replace('#', '@sharp;', str);
	str = str_replace('\\?', '@question;', str);
	str = str_replace('\\=', '@equal;', str);
	return str;
}

// 추가 업로드 필드
function moreUpload()
{
	EXTEND_PDS++;
	$('extendUploads').innerHTML += '<div title="파일용량이 클 경우 한 번에 업로드가 되지 않을 수 있습니다.">추가파일 #'+EXTEND_PDS+': <input type="file" name="fileExtend'+EXTEND_PDS+'" class="input" /></div>';
}

// 태그 선정 돕기
function tagAssist(tag, id)
{
	var lastTag = tag.split(',');
	var tag = lastTag[lastTag.length-1];
	var request = new Ajax.Request('tag_assist.php', {
		parameters : 'tag='+tag+'&id='+id,
		onSuccess : function(request) {
			var result = '<ol>';
			var lists = request.responseXML.getElementsByTagName('lists')[0];
			var tags = lists.getElementsByTagName('tags');
			for(i=0; i<tags.length; i++) {
				var tag = tags[i].firstChild.nodeValue;
				var count = parseInt(tags[i].getAttribute('count')) + 1;
				result += '<li title="태그 입력을 쉽게 하기 위해 이미 입력된 태그중 비슷한 걸 찾습니다."><strong>'+tag+'</strong> (사용된 횟수: '+count+'번)</li>';
			}
			result += '</ol>';
			$('searchTags').style.display = '';
			$('searchTags').innerHTML = result;
		}
	});
}

// 플래시 업로더용 스크립트 (by SWFUpload)
var swfu = new SWFUpload({ 
		post_params: {"PHPSESSID" : SESS_ID, "id" : BBS_ID},
		upload_url : GRBOARD+"/swfupload_ok.php", 
		flash_url : GRBOARD+"/swfupload.swf", 
		file_size_limit : "50 MB",
		file_types : "*.*",
		file_types_description : "All Files",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,
		button_placeholder_id: "swfUpBtnforGRBOARD",
		button_image_url: GRBOARD+"/"+THEME+"/image/swf.upload.btn.gif",
		button_width: "60",
		button_height: "20",
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete
});

// 다음 에디터 스타일을 동적으로 할당
var des = document.createElement('link');
des.setAttribute('rel', 'stylesheet');
des.setAttribute('href', GRBOARD+'/daumEditor/css/editor.css');
des.setAttribute('type', 'text/css');
des.setAttribute('title', 'style');
document.documentElement.getElementsByTagName("HEAD")[0].appendChild(des);