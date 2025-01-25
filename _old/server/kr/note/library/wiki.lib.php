<?php
/**
 * @update 2008-11-21
 * @comment 위키 시스템에 사용될 메소드들 정의
 */
class Wiki {
	var $divide;
	var $wikiWriteLevel;
	var $writeKey1;
	var $writeKey2;
	var $cacheTime;
	/**
	 * @param none
	 * @comment 클래스 초기화시 DB연결 / 로그인 여부 확인 */
	 function Wiki($prefix='') {
		 include $prefix.'db.info.php';
		 include $prefix.'grnote.config.php';
		 $this->wikiWriteLevel = $grNote['wiki']['writeLevel'];
		 $this->divide = $divide;
		 $this->writeKey1 = mt_rand(1, 10);
		 $this->writeKey2 = mt_rand(1, 10);
		 $this->cacheTime = $grNote['wiki']['cacheTerm'];
	 }
	/**
	 * @param String msg, src
	 * @comment 에러 발생시 쓰는 알림창 */
	 function alert($msg, $src=false) {
		 $result = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
		 '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">'.
		 '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>알림</title>'.
		 '<script type="text/javascript">//<![CDATA['."\nalert('".str_replace('<br />', '\n', $msg)."');";
		 if($src) $result .= 'location.href=\''.$src.'\';'; else $result .= 'history.back();';
		 $result .= '//]]></script></head><body>'.$msg.'</body></html>';
		 echo $result;
		 exit();
	 }
	/**
	 * @param none
	 * @comment 위키 첫페이지가 있는지 없는지 확인 */
	 function isFirstRun() {
		 $getPage = @mysql_fetch_array(mysql_query('select uid from '.$this->divide.'wikis where master_doc = 0 limit 1'));
		 if(!$getPage[0]) return true; else return false;
	 }
	/**
	 * @param String p, subject, theme
	 * @comment 지정된 위키 페이지 가져오기 */
	 function getPage($subject, $theme, $p) {
		 $getPage = @mysql_fetch_array(mysql_query('select * from '.$this->divide.'wikis where master_doc = 0 and keyword_md5 = \''.$p.'\' order by uid desc limit 1'));
		 if(!$getPage['uid']) {
			 $this->writePage($subject, $theme);
			 return;
		 }
		 @mysql_query('update '.$this->divide.'wikis set view = view + 1 where uid = '.$getPage['uid']);
		 return $getPage;
	 }
	/**
	 * @param String content
	 * @comment 출력할 문서를 출력 전에 다듬어서 출력함 */
	 function contentFix($content) {
		 preg_match_all('/\[\[(.*?)\]\]/i', $content, $matches);
		 $cnt = count($matches[1]);
		 for($i=0; $i<$cnt; $i++) 
			 $content = preg_replace('/\[\[('.$matches[1][$i].')\]\]/i', '<a href="./?m=wiki&amp;a=view&amp;k='.urlencode($matches[1][$i]).'">$1</a>', $content);
		 $content = preg_replace('/\{\{\{(.*?)\}\}\}/i', '<div class="title1">$1</div>', $content);
		 $content = preg_replace('/\{\{(.*?)\}\}/i', '<div class="title2">$1</div>', $content);
		 $content = preg_replace('/\{(.*?)\}/i', '<div class="title3">$1</div>', $content);
		 return $content;
	 }
	/**
	 * @param String subject, theme, int modifyDocNo
	 * @comment 제시된 제목으로 문서 작성폼 열기 */
	 function writePage($subject, $theme, $modifyDocNo=0) {
		 $getPermission = @mysql_fetch_array(mysql_query('select level from '.$this->divide.'users where uid = '.$_SESSION['userNo']));
		 if(!$getPermission['level']) $getPermission['level'] = 1;
		 if(($getPermission['level'] < $this->wikiWriteLevel) && $_SESSION['userNo'] != 1) { 
			 echo '<br /><br /><br /><img src="index/theme/'.$theme.'/images/wiki.write.no.gif" alt="" /> 글 작성 권한이 없습니다. 관리자에게 문의 해보세요.'; 
			 return;
		 }
		 if($modifyDocNo) $oldDoc = @mysql_fetch_array(mysql_query('select content from '.$this->divide.'wikis where uid = '.$modifyDocNo));
		 $result = '<form name="wikiWrite" method="post" action="./?m=wiki" onsubmit="return Wiki.write();"><div><input type="hidden" name="writer" value="'.$_SESSION['userNo'].'" />'.
			 '<input type="hidden" name="modifyDocNo" value="'.$modifyDocNo.'" /><input type="hidden" name="keyword" value="'.urldecode($subject).'" /></div>'.
			 '<div id="documentTitle"><img src="index/theme/'.$theme.'/images/wiki.write.icon.gif" alt="" /> `'.urldecode($subject).'` 문서 작성하기</div>'.
			 '<textarea name="content" rows="20">'.$oldDoc['content'].'</textarea><br />';
		 if(!$_SESSION['userNo']) { $result .= '※ 자동등록방지:<br /><input type="text" name="antispam" /> (← <strong>'.
			 $this->writeKey1.' </strong>더하기<strong> '.$this->writeKey2.'</strong> = ?)'; } else { $result .= '<input type="hidden" name="antispam" value="1" />'; }
		 $result .= '<div id="wikiWriteTip">※ <strong>GR위키 작성팁</strong><ol><li><span style="color: green">[[문서이름]]</span>'.
			 '형식으로 글 작성폼에 글을 쓰면 글 열람후 "<a href="#">문서이름</a>" 을 클릭시 해당 문서를 생성하실 수 있습니다.</li>'.
			 '<li>{{{큰제목}}}, {{중간제목}}, {소제목} 형식으로 글 작성폼에 쓰면 해당 괄호들 안의 제목들이 꾸며져서 출력 됩니다.</li></ol></div>'.
			 '<div id="submitForm"><img src="index/theme/'.$theme.'/images/wiki.file.upload.gif" onclick="Wiki.upload(\''.$theme.'\');" alt="업로드" style="cursor: pointer" /> <input type="image" src="index/theme/'.$theme.'/images/wiki.write.submit.gif" alt="작성완료" /></div></form>';
		 echo $result;
	 }
	/**
	 * @param int no
	 * @comment 현재 멤버의 이름, 아이디 반환 */
	 function getInfo($no=0) {
		 if(!$no) return '익명';
		 $result = @mysql_fetch_array(mysql_query('select id, nickname from '.$this->divide.'users where uid = '.$no));
		 return $result['id'].'('.$result['nickname'].')';
	 }
	/**
	 * @param none
	 * @comment 세션값을 참조하여 1이면 관리자, 아니면 사용자 */
	 function isAdmin() {
		 if($_SESSION['userNo'] == 1) return 1;
		 else return 0;
	 }
	/**
	 * @param none
	 * @comment 현재 보고 있는 위키 페이지의 사용가능한 캐시파일(.html)을 확인함. */
	 function isAvailableCache() {
		 $page = ($_GET['k']) ? $_GET['k'] : 'welcome';
		 $page = md5($page);
		 $nowTime = time();
		 $modifyTime = @filemtime('cache/'.$page.'.html');
		 if($nowTime < ($modifyTime + $this->cacheTime)) return $page;
		 else {
			 @unlink('cache/'.$page.'.html');
			 return false;
		 }
	 }
	/**
	 * @param String keyword, content
	 * @comment 현패 보고 있는 위키 페이지의 캐시파일을 만듭니다. */
	 function makeCachePage($keyword, $content) {
		 $page = md5($keyword);
		 $f = @fopen('cache/'.$page.'.html', 'w');
		 @fwrite($f, $content);
		 @fclose($f);
	 }
	/**
	 * @param int num
	 * @comment 위치 우측에 최근 수정/추가된 단어 목록 출력함. */
	 function showLatestWord($num) {
		 $result = '<ol>';
		 $getLatestWord = @mysql_query('select keyword from '.$this->divide.'wikis order by uid desc limit '.$num);
		 while($words = @mysql_fetch_array($getLatestWord)) {
			 $result .= '<li><a href="./?m=wiki&amp;a=view&amp;k='.$words['keyword'].'">'.$words['keyword'].'</a></li>';
		 }
		 $result .= '</ol>';
		 echo $result;
	 }
	/**
	 * @param int num
	 * @comment 위치 우측에 최근 수정/추가된 단어 목록 출력함. */
	 function showStarWord($num) {
		 $result = '<ol>';
		 $getLatestWord = @mysql_query('select keyword from '.$this->divide.'wikis where keyword != \'welcome\' order by view desc limit '.$num);
		 while($words = @mysql_fetch_array($getLatestWord)) {
			 $result .= '<li><a href="./?m=wiki&amp;a=view&amp;k='.$words['keyword'].'">'.$words['keyword'].'</a></li>';
		 }
		 $result .= '</ol>';
		 echo $result;
	 }
}
?>
