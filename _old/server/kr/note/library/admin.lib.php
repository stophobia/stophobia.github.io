<?php
/**
 * @update 2008-11-21
 * @comment 관리화면에서 처리할 메소드들 정의
 */
class Admin {
	var $divide;
	/**
	 * @param none
	 * @comment 클래스 초기화시 DB연결 & 관리자인지 확인 & 각종 변경점 확인 */
	 function Admin($prefix='') {
		include $prefix.'db.info.php';
		$this->divide = $divide;
		if($_SESSION['userNo'] != 1) {
			$getAdminPassword = @mysql_fetch_array(mysql_query('select password from '.$this->divide.'users where uid = 1'));
			if($_GET['key'] != md5(md5(date('Ymd', time())).$getAdminPassword['password'])) {
				$this->alert('관리자만이 접속 가능합니다.', $prefix.'login/');
			} else $_SESSION['userNo'] = 1;
		}
		define('__GRNOTE__', true);
		$this->changeLogo();
		$this->changeTheme($_POST['theme']);
		$this->setWikiSaveOriginal($_POST['saveOriginal']);
		$this->setWikiWriteLevel($_POST['writeLevel']);
		$this->setWikiModifyLevel($_POST['modifyLevel']);
		$this->setWikiReadLevel($_POST['readLevel']);
		$this->setWikiDeleteLevel($_POST['deleteLevel']);
		$this->setWikiCacheTerm($_POST['cacheTerm']);
		$this->setWikiUploadPerm($_POST['uploadLevel']);
		$this->setTicketSendLevel($_POST['sendLevel']);
		$this->setTicketModifyLevel($_POST['modifiedLevel']);
		$this->setTicketDeleteLevel($_POST['removeLevel']);
		$this->setTicketViewNum($_POST['viewNumTicket']);
		$this->setProjectManageLevel($_POST['projectLevel']);
		$this->setGoalManageLevel($_POST['goalLevel']);
		$this->setJoinLimit($_POST['joinLimit']);
		$this->setPlannerOpen($_POST['planOpen']);
	 }
	/**
	 * @param String content
	 * @comment grnote.config.php 파일 설정저장 */
	 function saveConfig($content) {
		 $f = @fopen('../grnote.config.php', 'w');
		 @fwrite($f, $content);
		 @fclose($f);
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
	 * @comment GR노트 로고파일 변경 */
	 function changeLogo() {
		 if(!$_FILES['logo']['size']) return;
		 $name = $_FILES['logo']['name'];
		 $type = $_FILES['logo']['type'];
		 $size = $_FILES['logo']['size'];
		 $tmp = $_FILES['logo']['tmp_name'];
		 if(!eregi('\.gif', $name)) $this->alert('.gif 파일만 업로드 가능 합니다.');
		 if(!is_uploaded_file($tmp)) 	$this->alert('정상적으로 파일을 업로드 해주세요.');
		 $tmp = str_replace('\\\\', '\\', $tmp);
		 @rename('../index/grnote.logo.gif', '../index/oldlogos/'.time().'.grnote.logo.gif');
		 if(!move_uploaded_file($tmp, '../index/grnote.logo.gif')) $this->alert('파일을 업로드하지 못했습니다.');
		 $this->alert('로고를 변경하였습니다.', '../admin/?key='.$_GET['key']);
	 }
	/**
	 * @param String theme
	 * @comment GR노트 테마 변경 */
	 function changeTheme($theme='') {
		 if(!$theme) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'theme\'] = \''.$grNote['theme'].'\';', '$grNote[\'theme\'] = \''.$theme.'\';', $config);
		 $this->saveConfig($config);
		 $this->alert('테마를 변경하였습니다.', '../admin/?key='.$_GET['key']);
	 }
	/**
	 * @param int isSaveOriginal
	 * @comment GR노트 위키 원본보존 여부 설정 */
	 function setWikiSaveOriginal($isSaveOriginal=0) {
		 if(!$isSaveOriginal) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'wiki\'][\'saveOriginal\'] = '.$grNote['wiki']['saveOriginal'].';', '$grNote[\'wiki\'][\'saveOriginal\'] = '.$isSaveOriginal.';', $config);
		 $this->saveConfig($config);
		 $this->alert('위키 원본보존 여부를 설정하였습니다.', '../admin/?m=wiki');
	 }
	/**
	 * @param int level
	 * @comment GR노트 위키 작성권한 변경 */
	 function setWikiWriteLevel($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'wiki\'][\'writeLevel\'] = '.$grNote['wiki']['writeLevel'].';', '$grNote[\'wiki\'][\'writeLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('위키 작성권한을 수정하였습니다.', '../admin/?m=wiki');
	 }
	/**
	 * @param int level
	 * @comment GR노트 위키 수정권한 변경 */
	 function setWikiModifyLevel($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'wiki\'][\'modifyLevel\'] = '.$grNote['wiki']['modifyLevel'].';', '$grNote[\'wiki\'][\'modifyLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('위키 수정권한을 수정하였습니다.', '../admin/?m=wiki');
	 }
	/**
	 * @param int level
	 * @comment GR노트 위키 읽기권한 변경 */
	 function setWikiReadLevel($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'wiki\'][\'readLevel\'] = '.$grNote['wiki']['readLevel'].';', '$grNote[\'wiki\'][\'readLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('위키 읽기권한을 수정하였습니다.', '../admin/?m=wiki');
	 }
	/**
	 * @param int level
	 * @comment GR노트 위키 읽기권한 변경 */
	 function setWikiDeleteLevel($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'wiki\'][\'deleteLevel\'] = '.$grNote['wiki']['deleteLevel'].';', '$grNote[\'wiki\'][\'deleteLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('위키 삭제권한을 수정하였습니다.', '../admin/?m=wiki');
	 }
	/**
	 * @param int level
	 * @comment GR노트 위키 읽기권한 변경 */
	 function setWikiUploadPerm($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'wiki\'][\'uploadLevel\'] = '.$grNote['wiki']['uploadLevel'].';', '$grNote[\'wiki\'][\'uploadLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('위키 파일첨부 권한을 수정하였습니다.', '../admin/?m=wiki');
	 }
	/**
	 * @param int writePages, currentPage, totalPage, String goUrl
	 * @comment 페이징 메소드 */
	 function getPaging($writePages, $currentPage, $totalPage, $goUrl, $searchOption='', $searchText='', $category='')
	 {
		 $str = '';
		 if($searchOption && $searchText) $addSearchQue = '&amp;searchOption='.$searchOption.'&amp;searchText='.urlencode($searchText); else $addSearchQue = '';
		 if($currentPage > 1) $str .= '<a href="'.$goUrl.'1'.$addSearchQue.'" title="처음 페이지로 이동합니다" class="page">First</a>';
		 $startPage = (((int)(($currentPage - 1 ) / $writePages )) * $writePages) + 1;
		 $endPage = $startPage + $writePages - 1;
		 if($endPage >= $totalPage) $endPage = $totalPage;
		 if($startPage > 1) $str .= ' &nbsp;<a href="'.$goUrl.($startPage-1).'&amp;division='.$division.$addSearchQue.'" title="이전 페이지로 이동합니다" class="page">prev</a>';
		 if($totalPage > 1)
		 {
			 for($i=$startPage;$i<=$endPage;$i++)
			 {
				 if($currentPage != $i) $str .= ' &nbsp;<a href="'.$goUrl.$i.'&amp;division='.$division.$addSearchQue.'" class="page">'.$i.'</a>';
				 else $str .= ' &nbsp;<strong>'.$i.'</strong> ';
			 }
		 }
		 if($totalPage > $endPage) $str .= ' &nbsp;<a href="'.$goUrl.($endPage+1).'&amp;division='.$division.$addSearchQue.'" title="다음 페이지로 넘어갑니다" class="page">next</a>';
		 if ($currentPage < $totalPage)	 $str .= ' &nbsp;<a href="'.$goUrl.$totalPage.'&amp;division='.$division.$addSearchQue.'" title="맨 끝 페이지로 이동합니다" class="page">Last</a>';		
		 $str .= '';
		 return $str;
	 }
	/**
	 * @param int level
	 * @comment 티켓 발행권한 변경 */
	 function setTicketSendLevel($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'ticket\'][\'sendLevel\'] = '.$grNote['ticket']['sendLevel'].';', '$grNote[\'ticket\'][\'sendLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('티켓 발행권한을 수정하였습니다.', '../admin/?m=ticket');
	 }
	/**
	 * @param int level
	 * @comment 티켓 수정권한 변경 */
	 function setTicketModifyLevel($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'ticket\'][\'modifyLevel\'] = '.$grNote['ticket']['modifyLevel'].';', '$grNote[\'ticket\'][\'modifyLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('티켓 수정권한을 수정하였습니다.', '../admin/?m=ticket');
	 }
	/**
	 * @param int level
	 * @comment 티켓 삭제권한 변경 */
	 function setTicketDeleteLevel($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'ticket\'][\'removeLevel\'] = '.$grNote['ticket']['removeLevel'].';', '$grNote[\'ticket\'][\'removeLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('티켓 삭제권한을 수정하였습니다.', '../admin/?m=ticket');
	 }
	/**
	 * @param none
	 * @comment GR노트 삭제 */
	 function uninstall() {
		 @mysql_query('drop table '.$this->divide.'users');
		 $getProjects = @mysql_query('select uid from '.$this->divide.'projects');
		 while($projects = @mysql_fetch_array($getProjects)) @mysql_query('drop table '.$this->divide.'ticket'.$projects['uid']);
		 @mysql_query('drop table '.$this->divide.'projects');
		 @mysql_query('drop table '.$this->divide.'goals');
		 @mysql_query('drop table '.$this->divide.'wikis');
		 $openSession = @opendir('../session/');
		 while($readSession = @readdir($openSession)) @unlink($readSession);
		 @rmdir('../session/');
		 @chmod('../db.info.php', 0707);
		 @unlink('../db.info.php');
		 $this->alert('GR노트를 삭제하였습니다. 설치화면으로 이동합니다.', '../install/');
	 }
	/**
	 * @param int level
	 * @comment 프로젝트 생성/수정/삭제권한 변경 */
	 function setProjectManageLevel($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'project\'][\'makeLevel\'] = '.$grNote['project']['makeLevel'].';', '$grNote[\'project\'][\'makeLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('프로젝트 관리권한을 수정하였습니다.', '../admin/?m=goal');
	 }
	/**
	 * @param int level
	 * @comment 목표 생성/수정/삭제권한 변경 */
	 function setGoalManageLevel($level=0) {
		 if(!$level) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'goal\'][\'makeLevel\'] = '.$grNote['goal']['makeLevel'].';', '$grNote[\'goal\'][\'makeLevel\'] = '.$level.';', $config);
		 $this->saveConfig($config);
		 $this->alert('목표 관리권한을 수정하였습니다.', '../admin/?m=goal');
	 }
	/**
	 * @param none
	 * @comment 로그아웃시 세션 제거 */
	 function logout() {
		 $_SESSION = array();
		 @session_destroy();
		 $this->alert('로그아웃 하였습니다.', '../');
	 }
	/**
	 * @param int limit
	 * @comment 사용자 등록 허용여부를 설정 */
	 function setJoinLimit($limit=0) {
		 if(!$limit) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'user\'][\'joinOK\'] = '.$grNote['user']['joinOK'].';', '$grNote[\'user\'][\'joinOK\'] = '.$limit.';', $config);
		 $this->saveConfig($config);
		 $this->alert('사용자 등록 허용여부를 수정하였습니다.', '../admin/?m=all');
	 }
	/**
	 * @param int second
	 * @comment 위키 페이지 캐쉬파일 생성시간 */
	 function setWikiCacheTerm($second) {
		 if(!$second) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'wiki\'][\'cacheTerm\'] = '.$grNote['wiki']['cacheTerm'].';', '$grNote[\'wiki\'][\'cacheTerm\'] = '.$second.';', $config);
		 $this->saveConfig($config);
		 $this->alert('위키 페이지 캐쉬파일 생성시간을 수정하였습니다.', '../admin/?m=wiki');
	 }
	/**
	 * @param int num
	 * @comment 한 번에 티켓을 몇개씩 보여줄 것인지 설정 */
	 function setTicketViewNum($num) {
		 if(!$num) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'ticket\'][\'viewNumTicket\'] = '.$grNote['ticket']['viewNumTicket'].';', '$grNote[\'ticket\'][\'viewNumTicket\'] = '.$num.';', $config);
		 $this->saveConfig($config);
		 $this->alert('티켓 볼 개수를 수정하였습니다.', '../admin/?m=ticket');
	 }
	/**
	 * @param none
	 * @comment 세션값을 참조하여 1이면 관리자, 아니면 사용자 */
	 function isAdmin() {
		 if($_SESSION['userNo'] == 1) return 1;
		 else return 0;
	 }
	/**
	 * @param int limit
	 * @comment 플래너 공개 여부를 결정 */
	 function setPlannerOpen($limit=0) {
		 if(!$limit) return;
		 $config = @file_get_contents('../grnote.config.php');
		 include '../grnote.config.php';
		 $config = str_replace('$grNote[\'planner\'][\'open\'] = '.$grNote['planner']['open'].';', '$grNote[\'planner\'][\'open\'] = '.$limit.';', $config);
		 $this->saveConfig($config);
		 $this->alert('플래너 전체 공개 여부를 수정하였습니다.', '../admin/?m=all');
	 }
}
?>
