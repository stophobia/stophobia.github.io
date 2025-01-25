<?php
/*
	GR Paper 익명 피드주소 추가 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-1-12
	내  용: 누구나 피드를 추가할 수 있도록 허용한 경우 피드주소를 받아서, 추가합니다.
	참  고: 누구나 피드를 추가하도록 할 경우, 주기적으로 피드 목록을 관리해야 합니다.
	          익명으로 등록된 피드는 guest 그룹으로 등록됩니다.
	주  의: 누구나 등록 가능하기 때문에 서버에 다량의 피드주소가 등록되어 부하를 유발할 수 있습니다.
*/

// 초기화
include '../library/common.php';
$c = new GRCOMMON('../');
include '../config/base.php';

// 주요 변수 저장
$isEnableAdd = $c->get('isEnableAdd');
$getGuestGroupUid = $c->db->query('select uid from '.$c->prefix.'feed_group where name = \'guest\' limit 1')->fetch_array();
$getAdminMail = $c->db->query('select email from '.$c->prefix.'user where uid = 1')->fetch_array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['version']; ?> - 피드추가하기</title>
<link rel="stylesheet" href="<?php echo $config['absPath']; ?>/css/admin.css" type="text/css" title="style" />
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/admin.js"></script>
</head>
<body>
<form id="panelForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<div><input type="hidden" id="groupUid" value="<?php echo $getGuestGroupUid['uid']; ?>" /><input type="hidden" id="isOpen" value="1" /></div>
	
	<div id="addFeedLogo">GR Paper</div>

	<!-- 개개의 피드 추가 -->
	<div id="addFeedPopup">
		<div>추천할 RSS 주소를 적어주세요 → <input type="text" class="i" id="feedUrl" title="이 곳에 추가할 RSS 피드주소를 적어주세요." value="" /><input type="button" class="s" value="추가" title="추가할 RSS 피드주소를 적었다면 이 곳을 클릭하세요." onclick="Admin.addFeedPopup();" /></div>
	</div>

</form>
</body>
</html>