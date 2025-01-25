<?php 
/**
 * @update 2009-02-06
 * @comment 관리화면 전체설정
 */
if(!defined('__GRNOTE__')) exit();

// 퍼미션 체크
if(!is_writable('../grnote.config.php')) 
	echo '<br /><span class="alert">※ GR노트 디렉토리 안에 있는 grnote.config.php 파일의 퍼미션이 707 이 아닙니다. 707로 변경해주세요.</span><br /><br />'; 
?>
<span class="b">GR노트 상단 로고설정</span><br />
<br />
GR노트 상단에 보여질 로고를 변경 할 수 있습니다. (관리자화면 제외)<br />
적당한 크기의 로고를 만들어서 아래 "찾아보기..." 를 눌러 찾으신 후,<br />
"로고 변경" 을 누르시면 상단 로고가 변경되어 출력 됩니다.<br />
(※ 그림파일은 반드시 .gif 형식으로 만드셔야 하며, 이전 로고들은 /index/oldlogos/ 에 저장됩니다.)<br />
<br />
<form id="logos" method="post" action="./?m=all" enctype="multipart/form-data">
<input type="file" name="logo" class="i" /> <input type="image" src="images/submit.logo.change.gif" class="s" title="로고를 변경 합니다." />
</form>
<img src="<?php echo $grNote['path']; ?>/index/grnote.logo.gif" alt="GR노트 로고" />

<div class="dotLine"></div>

<span class="b">GR노트 테마설정</span><br />
<br />
GR노트의 테마를 선택하고 "테마 변경" 버튼을 눌러 테마를 변경합니다.<br />
테마에 따라 다양한 GR노트의 기능들을 쉽게 활용하실 수 있습니다.<br />
기본적으로 제공되는 테마는 "basic" 테마 입니다.<br />
<br />
<form id="themes" method="post" action="./?m=all">
<select name="theme"><?php
$openDir = @opendir($grNote['path'].'/index/theme/');
while($readDir = @readdir($openDir)) {
	if($readDir == '.' || $readDir == '..') continue;
	echo '<option value="'.$readDir.'"'.(($grNote['theme']==$readDir)?' selected="selected"':'').'>'.$readDir.'</option>';
}
?></select> <input type="image" src="images/submit.theme.change.gif" class="s" title="테마를 변경 합니다." /></form>

<div class="dotLine"></div>

<span class="b">GR노트 사용자 등록제한</span><br />
<br />
GR노트에 사용자들이 자신의 정보를 등록하고 로그인을 할 수 있도록 허용할 것인지 정합니다.<br />
공개된 노트의 경우 기본적으로 허용하는 것을 권장합니다.<br />
처음 등록을 하고 로그인을 하게 되면 기본적으로 일반 방문객과 차별을 두기 위해 레벨 2 로 설정 됩니다.<br />
레벨등의 정보는 멤버관리에서 통합적으로 관리가 가능하며 제한된 노트를 운영하고자 하는 분들은<br />
일부 사용자들만 등록한 이후 등록을 제한하면 됩니다.<br />
<br />
<form id="join" method="post" action="./?m=all">
<input type="radio" name="joinLimit" id="yes" value="1"<?php echo (($grNote['user']['joinOK']==1)?' checked="checked"':''); ?> /> <label for="yes">등록을 거부합니다.</label> &nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="joinLimit" id="no" value="2"<?php echo (($grNote['user']['joinOK']==2)?' checked="checked"':''); ?> /> <label for="no">등록을 허용합니다.</label> &nbsp;&nbsp;&nbsp;&nbsp;
<input type="image" src="images/submit.save.original.gif" class="s" title="사용자 등록 허용 여부를 결정합니다." />
</form>

<div class="dotLine"></div>

<span class="b">플래너 전체 공개</span><br />
<br />
팀 단위로 공동의 플래너를 유지하고자 할 경우에는 "전체 공개용" 으로 설정합니다.<br />
만약, 개개인 각자의 플래너를 유지하고자 할 경우에는 "개인용" 으로 설정합니다.<br />
프로젝트를 진행하면서 팀/부서의 공통 일정과 기념일을 관리하고자 할 경우는 전체 공개로 하시고,<br />
팀원 각자의 개인 일정을 관리할 수 있도록 (즉 프라이버시를 유지할 수 있도록) 해줄 경우에는<br />
개인용으로 설정해 주세요.<br />
<br />
<form id="plannerOpen" method="post" action="./?m=all">
<input type="radio" name="planOpen" id="openyes" value="1"<?php echo (($grNote['planner']['open']==1)?' checked="checked"':''); ?> /> <label for="openyes">전체 공개용</label> &nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="planOpen" id="openno" value="2"<?php echo (($grNote['planner']['open']==2)?' checked="checked"':''); ?> /> <label for="openno">개인용</label> &nbsp;&nbsp;&nbsp;&nbsp;
<input type="image" src="images/submit.save.original.gif" class="s" title="플래너 공개 여부를 저장 합니다." />
</form>

<div class="dotLine"></div>

<span class="b">GR노트 정보</span><br />
<ul>
	<li>제작: 박희근 (a.k.a SIRINI / <a href="mailto:sirini@gmail.com">sirini@gmail.com</a>)</li>
	<li>배포: 시리니넷 (<a href="http://sirini.net" onclick="window.open(this.href, '_blank'); return false">http://sirini.net</a>)</li>
	<li>버젼: v0.94 beta "잠자리" (pl3 for <span style="color: red">security</span>)</li>
	<li>설치환경: Apache 1.x 이상, PHP 4.3.x 이상, MySQL 3.23.x 이상</li>
	<li>사용환경: Internet Explorer 6.x 이상 / Mozilla Firefox 1.x 이상 / Safari 1.x 이상 (자바스크립트 사용이 가능해야 합니다.)</li>
	<li>라이센스: /install/license.txt 파일 참조 (설치시 안내됩니다.)</li>
	<li>도움준곳: <a href="http://maru.net" onclick="window.open(this.href, '_blank'); return false">마루호스팅</a>, <a href="http://mozilla.or.kr" onclick="window.open(this.href, '_blank'); return false">Mozilla Firefox</a>, <a href="http://prototypejs.org" onclick="window.open(this.href, '_blank'); return false">Prototype</a>, <a href="http://script.aculo.us" onclick="window.open(this.href, '_blank'); return false">Script.aculo.us</a>, <a href="http://www.everaldo.com/crystal/" onclick="window.open(this.href, '_blank'); return false">Crystal Project</a>, <a href="http://tinymce.moxiecode.com" onclick="window.open(this.href, '_blank'); return false">TinyMCE</a>, And you...
</ul>