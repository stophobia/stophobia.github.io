<?php
/*
	GR Paper 관리자 페이지
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-1-15
	내  용: 관리자 페이지. 관리자만 접근 가능함.
	참  고: OPML 파일 업로드시 페이지 리로드되면서 처리
*/

if($_FILES['opml']['size']) include 'add.opml.ok.php';
if($_GET['getOPML']) include 'opml.download.php';
include '../library/common.php';
$c = new GRCOMMON('../');
include '../config/base.php';
if(!$c->isAdmin()) $c->alert('관리자만 접속 가능합니다.', $config['absPath'].'/login/');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="<?php echo $config['version']; ?>" />
<meta name="Author" content="<?php echo $config['author']; ?>" />
<meta name="Nationality" content="Republic of Korean" />
<title><?php echo $config['version']; ?> - 관리자 화면</title>
<link rel="stylesheet" href="<?php echo $config['absPath']; ?>/css/admin.css" type="text/css" title="style" />
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/effects.js"></script>
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/admin.js"></script>
</head>
<body>

<div id="logo"><a href="<?php echo $config['absPath']; ?>" title="이 곳을 클릭하시면 Paper 첫화면으로 이동합니다."><img src="<?php echo $config['absPath']; ?>/image/grpaper-admin.gif" alt="GR Paper Administrator Panel" /></a></div>

<form id="panelForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return Admin.addOPML();" enctype="multipart/form-data">
<div id="panelLayout">

		<div class="title" onclick="Admin.toggle('welcome');" title="관리자 패널 설명을 봅니다. 이 곳에서 관리자 비밀번호를 변경하실 수도 있습니다."><img src="<?php echo $config['absPath']; ?>/image/grpaper-admin-panel-1.gif" alt="1. 관리자 패널에 오신 것을 환영합니다" /></div>
		<div id="welcome" class="body"<?php echo (isset($_GET['work1']))?'':' style="display: none"'; ?>>
		<div class="info">
		GR Paper 관리자 패널에서는 스킨 설정부터 캐쉬 파일 유지 시간, 수집 간격 조정<br />
		그리고 피드 추가/제거 등의 관리를 위한 도구들이 각각의 그룹 속에 준비되어 있습니다.<br />
		변경할 설정이 있을 경우 먼저 해당 부분과 관련된 패널명을 클릭하시고, 펼쳐진 패널 내용을<br />
		확인하셔서 설정을 변경하시면 됩니다. 아래는 일반적인 사항에 대한 설정입니다.<br />
		</div>
		<span class="recommand">※ 관리자 비밀번호를 변경하려면 아래에 새 비밀번호를 입력하신 후, "변경하기" 를 눌러주세요.</span><br />
		<dt>비밀번호 변경</dt>
		<dd class="i"><input type="password" class="i" id="newPassword" title="관리자 비밀번호를 변경하고자 할 때 이 곳에 새 비밀번호를 적어주세요." /><input type="button" class="s" value="변경하기" onclick="Admin.newPassword();" title="이 곳을 클릭하시면 입력하신 새 비밀번호로 변경됩니다." /> <span id="newPasswordResult"></span></dd>
		<dd class="clear"></dd>

		<dt>세션 비우기</dt>
		<dd class="i"><input type="button" class="s" value="세션 비우기" onclick="Admin.sessClean();" title="이 곳을 클릭하시면 불필요하게 쌓인 세션을 정리합니다." /> (현재: <?php echo $c->totalSession(); ?> 개) <span id="sessCleanResult"></span></dd>
		<dd class="clear"></dd>
		</div>
		
		<div class="title" onclick="Admin.toggle('feedManage');" title="RSS 피드를 추가하거나 삭제합니다."><img src="<?php echo $config['absPath']; ?>/image/grpaper-admin-panel-2.gif" alt="2. 피드(그룹) 추가 / 제거하기" /></div>
		<div id="feedManage" class="body"<?php echo (isset($_GET['work2']))?'':' style="display: none"'; ?>>
		수집할 피드를 추가하거나, 이미 수집중인 피드를 제거하실 수 있습니다.<br />
		추가된 피드를 제거하실 경우, 관리자의 선택에 따라 이미 수집된 데이터는 삭제하지 않을 수도 있습니다.<br />
		<span class="recommand" title="일반 웹호스팅 환경에서는 50개 이하, 중급 독립서버에서는 200개 이하, 고성능 독립서버의 경우에도 1,000개 이하로 적정 피드수를 유지해 주세요.">(* 수집대상 RSS 피드들이 많아질수록 수집할 때마다 서버에 부하가 더 많이 걸립니다.)</span>
		<div id="groupSetting">
			<div id="addGroup">
			<div><input type="hidden" id="modifyUid" value="" /></div>
			<ul>
				<li><input type="text" id="groupName" class="i" title="이 곳에 그룹명을 적어주세요. (예: 요리블로그 모음)" /> (그룹명)</li>
				<li><input type="text" id="groupInfo" class="i" title="이 곳에 그룹에 대한 설명을 적어주세요. (예: 참고할 만한 레시피가 한가득!)" /> (그룹설명)</li>
			</ul>
			<input type="button" id="btnGroup" class="s" value="추가하기" onclick="Admin.addGroup();" title="추가(수정)할 그룹을 다 작성했으면 이 곳을 클릭해 주세요." />
			</div>
			<div id="manageGroup">
				<ol id="manageGroupList">
					<?php
					$gpList = $c->db->query('select uid, name, info from '.$c->prefix.'feed_group');
					while($glist = $gpList->fetch_array()) { 
						$sGroup = stripslashes($glist['name']); 
					?>
					<li id="group<?php echo $glist['uid']; ?>"><?php echo $sGroup; ?> &nbsp;&nbsp;&nbsp;&nbsp; <span class="delete" title="이 그룹을 삭제합니다. 피드는 삭제되지 않으며, 기본 그룹은 삭제할 수 없습니다." onclick="Admin.deleteGroup(<?php echo $glist['uid']; ?>);">delete</span> <span class="modify" title="이 그룹정보를 수정합니다. 이름과 설명을 변경할 수 있습니다." onclick="Admin.modifyGroup(<?php echo $glist['uid']; ?>, '<?php echo $sGroup; ?>', '<?php echo $glist['info']; ?>');">modify</span></li>
					<?php } ?>
				</ol>
			</div>
			<div class="clear"></div>
		</div>

		<!-- OPML로 한방에 추가 -->
		<div id="importOPML">※ OPML 불러오기: <select name="opmlGroupUid" title="지정된 그룹 소속으로 모든 RSS 구독목록이 등록됩니다.">
		<?php
		$getGroupList = $c->db->query('select uid, name from '.$c->prefix.'feed_group');
		while($groupList = $getGroupList->fetch_array()) { 
			$selectGroup = stripslashes($groupList['name']);
		?>
		<option value="<?php echo $groupList['uid']; ?>"><?php echo $selectGroup; ?></option>
		<?php } ?>
		</select><input type="file" name="opml" title="불러들일 OPML 파일을 첨부해 주세요." /><input type="submit" class="s" value="추가" title="OPML 문서에 지정된 모든 RSS 들을 한 번에 구독 등록합니다." /></div>

		<!-- 개개의 피드 추가 -->
		<div id="addFeed">※ 피드 추가하기: <input type="checkbox" id="isOpen" value="1" checked="checked" title="수집된 피드를 공개합니다. 체크를 해제하시면 관리자로 로그인 할 때만 이 피드가 보여집니다." /> 공개 &nbsp;&nbsp; <select id="groupUid" title="선택하신 그룹 소속으로 RSS가 등록됩니다.">
		<?php
		$getGroupList = $c->db->query('select uid, name from '.$c->prefix.'feed_group');
		while($groupList = $getGroupList->fetch_array()) { 
			$selectGroup = stripslashes($groupList['name']);
		?>
		<option value="<?php echo $groupList['uid']; ?>"><?php echo $selectGroup; ?></option>
		<?php } ?>
		</select><input type="text" class="i" id="feedUrl" title="이 곳에 추가할 RSS 피드주소를 적어주세요." /><input type="button" class="s" value="추가" title="추가할 RSS 피드주소를 적었다면 이 곳을 클릭하세요." onclick="Admin.addFeed();" /></div>
		아래는 현재까지 추가된 피드 목록입니다.<br />
		마우스 스크롤로 위/아래 이동하여 수집중인 목록을 확인하실 수 있습니다.<br />
		검색을 위해서는 Ctrl+F 키를 눌러주세요.<br />
		<span style="color: #999">(전체 구독피드수: <strong><?php echo $c->totalRowNum('feed_list'); ?></strong> 개, <a href="./?getOPML=1" title="여기를 클릭하시면 GR Paper 에서 구독중인 RSS 목록을 받으실 수 있습니다.">구독목록을 OPML로 내보내기</a>)</span>
		<div id="feedBox">
			<ol id="feedList">
			<?php
			$getFeedList = $c->db->query('select * from '.$c->prefix.'feed_list');
			while($rss = $getFeedList->fetch_array()) {
				$rssName = stripslashes($rss['name']);
				$rssInfo = htmlspecialchars(stripslashes($rss['info']));
				$getGroup = $c->db->query('select name, info from '.$c->prefix.'feed_group where uid = '.$rss['group_uid']);
				$group = $getGroup->fetch_array();
				$groupInfo = htmlspecialchars(stripslashes($group['info']));
				$groupName = stripslashes($group['name']);
			?>
				<li id="rss<?php echo $rss['uid']; ?>">[<?php echo ($rss['is_open'])?'공개':'비밀'; ?>/<span class="group" title="그룹정보: <?php echo $groupInfo; ?>"><?php echo $groupName; ?></span>] 
				<a href="http://<?php echo $rss['url']; ?>" title="<?php echo $rssInfo; ?>"><?php echo $rssName; ?></a> &nbsp;(<?php echo $rss['total']; ?>개)&nbsp; <span class="delete" title="이 수집중인 피드를 삭제합니다." onclick="Admin.deleteFeed(<?php echo $rss['uid']; ?>);">delete</span></li>
			<?php } ?>
			</ol>
		</div>
		</div>
		
		<div class="title" onclick="Admin.toggle('skinManage');" title="한 화면에 몇개의 글들을 보이게 할 것인지, 인기글은 보이게 할 것인지 등의 옵션을 수정하실 수 있습니다."><img src="<?php echo $config['absPath']; ?>/image/grpaper-admin-panel-3.gif" alt="3. 스킨 설정하기" /></div>
		<div id="skinManage" class="body"<?php echo (isset($_GET['work3']))?'':' style="display: none"'; ?>>
		<dt>스킨 선택</dt>
		<dd class="i"><select id="theme" onchange="Admin.skinConfig('theme', 'select');"><?php
		$getSkinDir = dir('../skin/');
		while($entry = $getSkinDir->read()) {
			if($entry == '.' || $entry == '..') continue;
			echo '<option value="'.$entry.(($entry==$c->get('theme'))?' selected="selected"':'').'">'.$entry.'</option>';
		}
		$getSkinDir->close();
		?></select> <span id="themeResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>브라우저 타이틀</dt>
		<dd class="i"><input type="text" class="i" id="browserTitle" value="<?php echo $c->get('browserTitle'); ?>" title="여기에 브라우저 상단에 보일 글귀를 작성해 주세요." /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('browserTitle', 'text');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="browserTitleResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>인기글 개수</dt>
		<dd class="i"><input type="text" class="i" id="hotPostNumber" value="<?php echo $c->get('hotPostNumber'); ?>" title="최근 인기글을 몇개까지 보여줄 건지 정합니다. (0 = 사용안함, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('hotPostNumber', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="hotPostNumberResult"></span></dd>
		<dd class="clear"></dd>

		<dt>인기글 유효시간</dt>
		<dd class="i"><input type="text" class="i" id="hotPostTerm" value="<?php echo $c->get('hotPostTerm'); ?>" title="최근 인기글로 유효한 시간을 정합니다. 기본으로 12시간 이전에 작성된 글 중 인기있는 글만 현재 인기글로 인정합니다. (예: 12, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('hotPostTerm', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="hotPostTermResult"></span></dd>
		<dd class="clear"></dd>

		<dt>최근글 개수</dt>
		<dd class="i"><input type="text" class="i" id="postNumber" value="<?php echo $c->get('postNumber'); ?>" title="최근글을 한 페이지당 몇개까지 보여줄 건지 정합니다. (숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('postNumber', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="postNumberResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>페이지 개수</dt>
		<dd class="i"><input type="text" class="i" id="pageNumber" value="<?php echo $c->get('pageNumber'); ?>" title="페이징을 몇 개까지 보여줄 것인지 정합니다. (예: 10, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('pageNumber', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="pageNumberResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>미리보기 글자수</dt>
		<dd class="i"><input type="text" class="i" id="charNumber" value="<?php echo $c->get('charNumber'); ?>" title="미리 보여질 본문 글자수를 입력합니다. (예: 450, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('charNumber', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="charNumberResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>이미지 썸네일 가로길이</dt>
		<dd class="i"><input type="text" class="i" id="thumbWidth" value="<?php echo $c->get('thumbWidth'); ?>" title="미리 보여질 이미지의 썸네일 가로 길이(=너비)를 px 단위 기준으로 지정합니다. (예: 80, 0=사용안함, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('thumbWidth', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="thumbWidthResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>이미지 썸네일 세로길이</dt>
		<dd class="i"><input type="text" class="i" id="thumbHeight" value="<?php echo $c->get('thumbHeight'); ?>" title="미리 보여질 이미지의 썸네일 세로 길이(=높이)를 px 단위 기준으로 지정합니다. (예: 50, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('thumbHeight', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="thumbHeightResult"></span></dd>
		<dd class="clear"></dd>

		<dt>썸네일보기 출력개수</dt>
		<dd class="i"><input type="text" class="i" id="thumbNumber" value="<?php echo $c->get('thumbNumber'); ?>" title="썸네일만 따로 모아서 보는 페이지에서, 한 페이지당 썸네일 이미지를 몇개씩 볼 것인지 지정합니다. (예: 30, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('thumbNumber', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="thumbNumberResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>최근등록 블로그 개수</dt>
		<dd class="i"><input type="text" class="i" id="blogNumber" value="<?php echo $c->get('blogNumber'); ?>" title="최근 등록된 블로그를 몇개까지 한 번에 보여줄 건지 정합니다. (0=사용안함, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('blogNumber', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="blogNumberResult"></span></dd>
		<dd class="clear"></dd>

		<dt>구독목록 개수</dt>
		<dd class="i"><input type="text" class="i" id="blogListNumber" value="<?php echo $c->get('blogListNumber'); ?>" title="구독목록 (등록된 블로그 목록보기 페이지) 에서 한 페이지당 보여줄 블로그 목록수를 지정합니다. (예: 25, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('blogListNumber', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="blogListNumberResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>인기 태그 개수</dt>
		<dd class="i"><input type="text" class="i" id="tagNumber" value="<?php echo $c->get('tagNumber'); ?>" title="인기있는 태그를 몇개까지 한 번에 보여줄 건지 정합니다. (0=사용안함, 숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('tagNumber', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="tagNumberResult"></span></dd>
		<dd class="clear"></dd>
		</div>
		
		<div class="title" onclick="Admin.toggle('botManage');" title="얼마의 시간 간격으로 RSS피드를 수집할 것인지 정하고, HTML 캐쉬 관련 설정을 합니다."><img src="<?php echo $config['absPath']; ?>/image/grpaper-admin-panel-4.gif" alt="4. RSS 수집기 /  캐쉬 설정" /></div>
		<div id="botManage" class="body"<?php echo (isset($_GET['work4']))?'':' style="display: none"'; ?>>
		<div class="info">
		GR Paper 가 등록된 RSS피드들을 몇 분 간격으로 수집할 것인지 결정합니다.<br />
		아래에 지정하는 시간 단위는 "분" 단위로, 10분 이하로 지정하시면 서버가 항상 수집작업을 합니다.<br />
		지정된 수집간격은 최소 간격으로, 실제로는 수집간격이 지정된 시간보다 조금 더 길어질 수 있습니다.<br />
		<span class="recommand" title="RSS피드를 수집하는 과정은 서버에 부하가 많이 걸리는 작업이기 때문에, 수집간격을 최소 1시간 이상(=60분 이상) 으로 지정해 주시는 걸 권장합니다.">(* 최소 60분 이상으로 지정해 주시는 것이 좋습니다. 서버에 부담을 줄일 수 있습니다.)</span>
		</div>

		<dt>피드추가 허용</dt>
		<dd class="i"><input type="checkbox" name="isEnableAdd" value="1"<?php echo ($c->get('isEnableAdd'))?' checked="checked"':''; ?> title="익명 방문객이 RSS 주소를 페이퍼에 추가할 수 있도록 허용합니다." /> 체크 시 누구나 피드를 추가할 수 있습니다. 
		<input type="button" class="s" value="저장" onclick="Admin.skinConfig('isEnableAdd', 'check');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="isEnableAddResult"></span></dd>
		<dd class="clear"></dd>

		<dt>RSS 수집간격</dt>
		<dd class="i"><input type="text" class="i" id="botTerm" value="<?php echo $c->get('botTerm'); ?>" title="수집 간격을 몇 분 간격으로 할 지 정합니다. (숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('botTerm', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="botTermResult"></span></dd>
		<dd class="clear"></dd>

		<dt>HTML 캐쉬 비우기</dt>
		<dd class="i"><input type="button" class="s" value="HTML 캐쉬를 새로 갱신하기!" onclick="Admin.cacheReload();" title="이 곳을 클릭하시면 현재까지 저장된 HTML 캐쉬를 비우고 새로 캐쉬를 생성합니다." /> <span id="cacheReloadResult"></span></dd>
		<dd class="clear"></dd>

		<dt>지금 RSS수집하기</dt>
		<dd class="i"><input type="button" class="s" value="지금 바로 RSS를 갱신하기!" onclick="Admin.runAggregator();" title="이 곳을 클릭하시면 RSS 수집을 지금 바로 시작합니다." /> <span id="runAggregatorResult"></span></dd>
		<dd class="clear"></dd>

		<dt>수집 안되는 피드삭제</dt>
		<dd class="i"><input type="button" class="s" value="수집되지 않는 피드 삭제하기!" onclick="Admin.feedValid();" title="이 곳을 클릭하시면 수집 대상 피드들을 검사 후 수집되지 않는 피드들만 목록에서 삭제합니다." /> <span id="feedValidResult"></span></dd>
		<dd class="clear"></dd>

		<dt>수집중단된 피드삭제</dt>
		<dd class="i"><input type="button" class="s" value="더 이상 수집하지 않는 피드 삭제하기!" onclick="Admin.feedReload();" title="이 곳을 클릭하시면 삭제된 RSS 피드들에서 예전에 수집했다가 그대로 보관중이던 글들을 모두 삭제 합니다." /> <span id="feedReloadResult"></span></dd>
		<dd class="clear"></dd>

		<dt>썸네일 모두 삭제</dt>
		<dd class="i"><input type="button" class="s" value="<?php echo $c->totalRowNum('image'); ?> 개의 그림들 모두 삭제하기!" onclick="Admin.deleteThumbnail();" title="이 곳을 클릭하시면 별도로 관리되고 있는 썸네일들을 모두 삭제합니다. (DB정보쪽만 제거)" /> <span id="deleteThumbnailResult"></span></dd>
		<dd class="clear"></dd>

		<dt>태그들 모두 삭제</dt>
		<dd class="i"><input type="button" class="s" value="<?php echo $c->totalRowNum('tag'); ?> 개의 태그들 모두 삭제하기!" onclick="Admin.deleteTag();" title="이 곳을 클릭하시면 별도로 보관중이던 모든 태그들을 삭제합니다." /> <span id="deleteTagResult"></span></dd>
		<dd class="clear"></dd>

		<dt>수집로그 삭제</dt>
		<dd class="i"><input type="button" class="s" value="<?php echo $c->totalRowNum('log'); ?> 개의 수집기록 모두 삭제하기!" onclick="Admin.deleteLog();" title="이 곳을 클릭하시면 기록 했던 수집 로그 정보를 모두 삭제합니다." /> <span id="deleteLogResult"></span></dd>
		<dd class="clear"></dd>

		<dt>페이퍼 초기화</dt>
		<dd class="i"><input type="button" class="s" value="<?php echo $c->totalRowNum('feed'); ?> 개의 글 모두 삭제하기!" onclick="Admin.deletePost();" title="이 곳을 클릭하시면 그 간 수집한 모든 포스트들을 삭제합니다." /> <span id="deletePostResult"></span></dd>
		<dd class="clear"></dd>

		</div>
		
		<div class="title" onclick="Admin.toggle('grSeriesManage');" title="GR시리즈들과의 연동을 설정합니다. (선택적임)"><img src="<?php echo $config['absPath']; ?>/image/grpaper-admin-panel-5.gif" alt="5. GR시리즈 연동 설정" /></div>
		<div id="grSeriesManage" class="body"<?php echo (isset($_GET['work5']))?'':' style="display: none"'; ?>>
		<div class="info">
		<strong>(1) GR보드 연동설정</strong><br />
		아래에 GR보드의 상대경로, 공지사항 출력용으로 사용할 게시판 ID, 출력할 개수를 작성합니다.<br />
		이 GR보드와의 연동은 선택적입니다. 서버에 GR보드가 설치되어 있지 않다면, 아래 입력항목을<br />
		그대로 비워두시면 됩니다. (이 경우 공지사항을 출력하지 않습니다.)<br />
		<br />
		<strong>(2) GR카운터 연동설정</strong><br />
		아래에 GR카운터의 상대경로, 사용할 카운터 ID를 입력합니다.<br />
		이 GR카운터와의 연동은 선택적입니다. 서버에 GR카운터가 설치되어 있지 않다면, 아래 입력항목을<br />
		그대로 비워두시면 됩니다. (이 경우 GR카운터의 접속자 통계/로그분석을 사용하지 않습니다.)<br />
		<span class="recommand" title="서로 다른 데이터베이스에 설치되어 있을 경우, 연동이 되지 않습니다.">(* GR보드와 GR카운터가 GR Paper 와 같은 DB 안에 설치되어 있어야 합니다.)</span>
		</div>
		<dt>(1) GR보드 상대경로</dt>
		<dd class="i"><input type="text" class="i" id="grboardPath" value="<?php echo $c->get('grboardPath'); ?>" title="GR보드가 설치된 상대경로를 입력해 주세요. GR Paper 와 동등한 위치에 있을 경우 (예: /grpaper 와 /grboard 가 서로 같은 위치일 때) ../grboard 라고 입력하시면 됩니다." /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('grboardPath', 'text');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="grboardPathResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>(1) 사용할 게시판ID</dt>
		<dd class="i"><input type="text" class="i" id="grboardBbsId" value="<?php echo $c->get('grboardBbsId'); ?>" title="공지사항 출력용으로 사용할 게시판 아이디를 입력합니다. (예: notice)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('grboardBbsId', 'text');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="grboardBbsIdResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>(1) 최근 공지글 출력개수</dt>
		<dd class="i"><input type="text" class="i" id="grboardNoticeNumber" value="<?php echo $c->get('grboardNoticeNumber'); ?>" title="최근 공지글을 몇 개까지 보여줄 것인지 정합니다. (숫자만 입력해 주세요)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('grboardNoticeNumber', 'number');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="grboardNoticeNumberResult"></span></dd>
		<dd class="clear"></dd>
				
		<dt>(2) GR카운터 상대경로</dt>
		<dd class="i"><input type="text" class="i" id="grcounterPath" value="<?php echo $c->get('grcounterPath'); ?>" title="GR카운터가 설치된 상대경로를 입력해 주세요. GR Paper 와 동등한 위치에 있을 경우 (예: /grpaper 와 /grcounter 가 서로 같은 위치일 때) ../grcounter 라고 입력하시면 됩니다." /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('grcounterPath', 'text');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="grcounterPathResult"></span></dd>
		<dd class="clear"></dd>
		
		<dt>(2) GR카운터 수집대상ID</dt>
		<dd class="i"><input type="text" class="i" id="grcounterID" value="<?php echo $c->get('grcounterID'); ?>" title="GR카운터에서 생성한 수집대상 ID를 입력합니다. (예: paper)" /><input type="button" class="s" value="저장" onclick="Admin.skinConfig('grcounterID', 'text');" title="이 곳을 클릭하시면 설정이 저장됩니다." /> <span id="grcounterIDResult"></span></dd>
		<dd class="clear"></dd>
		</div>

		<div class="title" onclick="Admin.toggle('logList');" title="마지막 수집기 활동 내역을 확인하실 수 있습니다."><img src="<?php echo $config['absPath']; ?>/image/grpaper-admin-panel-6.gif" alt="6. 수집기 로그보기" /></div>
		<div id="logList" class="body"<?php echo (isset($_GET['work6']))?'':' style="display: none"'; ?>>
		<ol><?php
		$logList = $c->db->query('select log from '.$c->prefix.'log where log !=\'\' order by uid desc limit 1');
		while($lgs = $logList->fetch_array()) {
			$logArray = @explode("\n", $lgs['log']);
			$logCount = count($logArray)-1;
			for($lg=0; $lg<$logCount; $lg++) {
				echo '<li'.((!$lg)?' class="start"':'').'>'.$logArray[$lg].'</li>'; 
			} 
		}?></ol>
		</div>
		
		</div>
</div>

<div id="copy">Powered by <a href="http://sirini.net" title="GR Paper 는 GR시리즈를 만들고 있는 시리니넷에서 공개한 오픈소스 프로그램입니다.">GR Paper</a></div>

</form>

</body>
</html>
