<?php
/*
	GR Paper RSS피드 추가 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-12-7
	내  용: Ajax 로 넘어온 url 를 확인하여 유효성을 검사하고, 유효할 시 추가처리한다.
	참  고: RSS 2.0 포맷만 지원한다. 날짜 형식은 표준을 따른다. (GR블로그, 텍스트큐브(티스토리), 워드프레스 기준)
	          HTTP Request 는 텍스트큐브 니들웍스의 라이브러리를 사용한다.
	주  의: 관리자만 추가 작업을 할 수 있다.
*/

include '../library/common.php';
include '../library/external/Needlworks.PHP.HTTPRequest.php';
$c = new GRCOMMON('../', 'text/xml');
$false = '<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>';
if(!$c->isAdmin() && !$_POST['isGuestAdd']) die($false);

// DOM 파싱 처리 시도
@extract($_POST);
$url = str_replace('http://', '', trim($url));
$tc = new HTTPRequest('http://'.$url);
$tc->send();
$p = simplexml_load_string($tc->responseText);
if(!$p) die($false);

// 이미 있다면 추가하지 않음
$blogURL = str_replace('http://', '', $p->channel[0]->link);
$getExist = $c->db->query('select uid from '.$c->prefix.'feed_list where url = \''.$blogURL.'\' limit 1');
$checkExist = $getExist->fetch_array();
if($checkExist['uid']) die($false);

// 추가 처리하기
$name = htmlspecialchars(addslashes(str_replace(array('<![CDATA[', ']]>'), '', $p->channel[0]->title)));
$info = htmlspecialchars(addslashes(str_replace(array('<![CDATA[', ']]>'), '', $p->channel[0]->description)));
$c->db->query('insert into '.$c->prefix."feed_list set uid = '', group_uid = '$groupUid', xml = '$url', url = '$blogURL', ".
	"img = '".str_replace('http://', '', $p->channel[0]->image->link)."', name = '$name', info = '$info', is_open = '$isOpen', last_update = 0, total = 0");
$insertID = $c->db->insert_id;
$c->db->query('update '.$c->prefix.'feed_group set count = count + 1 where uid = '.$groupUid.' limit 1');
	
// 처리 완료
$getGroup = $c->db->query('select name, info from '.$c->prefix.'feed_group where uid = '.$groupUid);
$group = $getGroup->fetch_array();
$groupInfo = htmlspecialchars(stripslashes($group['info']));
$groupName = stripslashes($group['name']);
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result><![CDATA[
	[<?php echo ($isOpen)?'공개':'비밀'; ?>/<span class="group" title="그룹정보: <?php echo $groupInfo; ?>"><?php echo $groupName; ?></span>] 
			<strong title="<?php echo $info; ?>"><?php echo stripslashes($name); ?></strong> &nbsp;&nbsp; <span class="delete" title="이 수집중인 피드를 삭제합니다." onclick="Admin.deleteFeed(<?php echo $insertID; ?>);">delete</span> (추가되었음)
	]]></result>
</grpaper>
