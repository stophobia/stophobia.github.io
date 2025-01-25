<?php
// 페이지 환경 초기화
define('__GRSHOP__', true);
include '../../core.php';
include '../../'.$grcore.'/class/common.php';
include '../../lib/shop.lib.php';
$core = new Common('../../'.$grcore);
$shop = new Shop($core, $dbFIX);
$grboard = $core->config['grboard'];
$grshop = $core->config['grshop'];
$core->session('../../'.$grboard.'/session');
if(!$shop->isAdmin()) exit();

// 변수 스트립 처리
function _f($str) {
	if(ini_get('magic_quotes_gpc')) return str_replace('\"', '&quot;', $str);
	else return str_replace('\"', '&quot;', addslashes($str));
}

// 설정 저장하기
if($_POST['saveNow']) {
	if(!is_writable('config.php')) $core->alert('레이아웃 스킨 폴더 안에 config.php 파일의 퍼미션을 707로 수정해주세요.');
	@extract($_POST);
	$save = '<?php'."\n";
	$save .= '$config[\'bbs_notice\'] = \''._f($bbs_notice).'\';'."\n";
	$save .= '$config[\'bbs_qna\'] = \''._f($bbs_qna).'\';'."\n";
	$save .= '$config[\'bbs_freeboard\'] = \''._f($bbs_freeboard).'\';'."\n";
	$save .= '$config[\'bbs_best\'] = \''._f($bbs_best).'\';'."\n";
	$save .= '$config[\'row_best\'] = \''._f($row_best).'\';'."\n";
	$save .= '$config[\'row_notice\'] = \''._f($row_notice).'\';'."\n";
	$save .= '$config[\'row_qna\'] = \''._f($row_qna).'\';'."\n";
	$save .= '$config[\'row_freeboard\'] = \''._f($row_freeboard).'\';'."\n";
	$save .= '$config[\'row_total_new\'] = \''._f($row_total_new).'\';'."\n";
	$save .= '$config[\'btn_best\'] = \''._f($btn_best).'\';'."\n";
	$save .= '$config[\'btn_total_latest\'] = \''._f($btn_total_latest).'\';'."\n";
	$save .= '$config[\'btn_notice\'] = \''._f($btn_notice).'\';'."\n";
	$save .= '$config[\'btn_home\'] = \''._f($btn_home).'\';'."\n";
	$save .= '$config[\'btn_login\'] = \''._f($btn_login).'\';'."\n";
	$save .= '$config[\'btn_join\'] = \''._f($btn_join).'\';'."\n";
	$save .= '$config[\'btn_logout\'] = \''._f($btn_logout).'\';'."\n";
	$save .= '$config[\'btn_myinfo\'] = \''._f($btn_myinfo).'\';'."\n";
	$save .= '$config[\'btn_order\'] = \''._f($btn_order).'\';'."\n";
	$save .= '$config[\'btn_cart\'] = \''._f($btn_cart).'\';'."\n";
	$save .= '$config[\'btn_mypage\'] = \''._f($btn_mypage).'\';'."\n";
	$save .= '$config[\'btn_qna\'] = \''._f($btn_qna).'\';'."\n";
	$save .= '$config[\'btn_freeboard\'] = \''._f($btn_freeboard).'\';'."\n";
	$save .= '$config[\'side_category\'] = \''._f($side_category).'\';'."\n";
	$save .= '$config[\'side_banner\'] = \''._f($side_banner).'\';'."\n";
	$save .= '$config[\'foot_copyright\'] = \''._f($foot_copyright).'\';'."\n";
	$save .= '$config[\'use_rss\'] = \''._f($use_rss).'\';'."\n";
	$save .= '?>';
	$core->fileWrite('config.php', $save);
	$core->alert('설정을 저장하였습니다.', './layout.config.php');
}

// 레이아웃 설정 가져오기
include 'config.php';
$layout = $shop->get('layout_skin');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GR Shop <?php echo $shop->version; ?> - <?php echo $layout; ?> 스킨 설정</title>
<link rel="stylesheet" href="config.css" type="text/css" title="style" />
<script type="text/javascript" src="../../<?php echo $grcore; ?>/js/jquery.js"></script>
<script type="text/javascript">//<![CDATA[
$(function(){
	$(".infoBox", this).toggle("infoBox");
});
//]]></script>
</head>
<body>

<div class="infoBox">
<!-- config.php 파일의 퍼미션이 맞지 않으면 경고 -->
<?php if(!is_writable('config.php')) { ?><div class="warnBox"><img src="image/warn.icon.gif"> 스킨 디렉토리 안에 들어있는 <strong>config.php</strong> 파일의 퍼미션을 <strong>707</strong>로 맞춰주세요!</div><?php } ?>

<strong><?php echo $layout; ?> 레이아웃 스킨 설정화면에 오신 것을 환영합니다.</strong><br />
이 곳에서는 <?php echo $layout; ?> 레이아웃 스킨에서 필요로 하는 각종 변수들을 지정할 수 있습니다.<br />
지정된 변수는 스킨 폴더 안에 들어있는 config.php 파일에 모두 저장됩니다.<br />
GR Shop 사용에 능숙한 사용자나, 혹은 프로그래밍에 관한 기초적인 지식을 소유하신 분들은<br />
이 화면 없이 config.php 파일을 직접 FTP 로 내려 받아 설정하신 후 업로드하여 설정을 마칠 수도 있습니다.<br />
<br />
각 항목별로 제시된 설명에 따라 변수를 지정하시고 저장하기를 누르시면 됩니다.<br />
레이아웃 스킨별로 필요로 하는 변수들이 다를 수 있으므로 초기 설치 후에 한 번 설정하시고,<br />
그 후에는 GR Shop 레이아웃 스킨을 변경할 때마다 다시 레이아웃 설정을 확인해 주세요.<br />
(기본 basic 스킨과 호환되는 레이아웃 스킨들 역시 확인해 주시는 것이 좋습니다.)<br />
<br />
<strong>번호별 배너 위치 및 최적크기 안내</strong><br />
1 : 레이아웃 우측 상단 부분 (최적크기: 150 x 30)<br />
2 이상 : 레이아웃 좌측 하단 부분 (최적크기: 160 x 40)<br />
</div>

<form id="skinSetting" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="saveNow" value="1" /></div>
<h2>1. 사용할 게시판 지정</h2>

<div class="margin">
<table rules="none" summary="GR Shop Layout Skin Config List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 150px">옵션</th>
	<th style="width: 200px">설정</th>
	<th>설명</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="bg">이벤트/소식</td>
	<td class="bg"><input type="text" class="i" name="bbs_notice" value="<?php echo $config['bbs_notice']; ?>" /></td>
	<td class="bg">이벤트, 행사안내, 공지사항용으로 사용할 게시판 ID 를 입력해 주세요. (예: notice)</td>
</tr>
<tr>
	<td>문의게시판</td>
	<td><input type="text" class="i" name="bbs_qna" value="<?php echo $config['bbs_qna']; ?>" /></td>
	<td>고객들이 문의글을 남길 수 있는 게시판 ID 를 입력해 주세요. (예: qna)</td>
</tr>
<tr>
	<td class="bg">자유게시판</td>
	<td class="bg"><input type="text" class="i" name="bbs_freeboard" value="<?php echo $config['bbs_freeboard']; ?>" /></td>
	<td class="bg">자유롭게 글을 남길 수 있는 게시판 ID 를 입력해 주세요. (예: freeboard)</td>
</tr>
<tr>
	<td>추천상품 게시판</td>
	<td><input type="text" class="i" name="bbs_best" value="<?php echo $config['bbs_best']; ?>" /></td>
	<td>추천상품만 모아서 보여줄 게시판 ID 를 입력해 주세요. (예: best)</td>
</tr>
</tbody>
</table>
</div>

<h2>2. 각 게시판별 최근게시물 출력개수</h2>

<div class="margin">
<table rules="none" summary="GR Shop Layout Skin Config List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 150px">옵션</th>
	<th style="width: 200px">설정</th>
	<th>설명</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="bg">이벤트/소식 목록수</td>
	<td class="bg"><input type="text" class="i" name="row_notice" value="<?php echo $config['row_notice']; ?>" /></td>
	<td class="bg">최근게시물로 몇 개씩 보여줄 것인지 지정해주세요. (예: 5)</td>
</tr>
<tr>
	<td>문의게시판 목록수</td>
	<td><input type="text" class="i" name="row_qna" value="<?php echo $config['row_qna']; ?>" /></td>
	<td>최근게시물로 몇 개씩 보여줄 것인지 지정해주세요. (예: 5)</td>
</tr>
<tr>
	<td class="bg">자유게시판 목록수</td>
	<td class="bg"><input type="text" class="i" name="row_freeboard" value="<?php echo $config['row_freeboard']; ?>" /></td>
	<td class="bg">최근게시물로 몇 개씩 보여줄 것인지 지정해주세요. (예: 5)</td>
</tr>
<tr>
	<td>추천상품 목록수</td>
	<td><input type="text" class="i" name="row_best" value="<?php echo $config['row_best']; ?>" /></td>
	<td>최근게시물로 몇 개씩 보여줄 것인지 지정해주세요. (예: 8)</td>
</tr>
<tr>
	<td class="bg">자유게시판 목록수</td>
	<td class="bg"><input type="text" class="i" name="row_freeboard" value="<?php echo $config['row_freeboard']; ?>" /></td>
	<td class="bg">최근게시물로 몇 개씩 보여줄 것인지 지정해주세요. (예: 5)</td>
</tr>
<tr>
	<td>신상품 목록수</td>
	<td><input type="text" class="i" name="row_total_new" value="<?php echo $config['row_total_new']; ?>" /></td>
	<td>통합 최근게시물로 몇 개씩 보여줄 것인지 지정해주세요. (예: 10)</td>
</tr>
</tbody>
</table>
</div>

<h2>3. 링크 버튼들 이름 지정</h2>

<div class="margin">
<table rules="none" summary="GR Shop Layout Skin Config List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 150px">옵션</th>
	<th style="width: 200px">설정</th>
	<th>설명</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="bg">추천상품</td>
	<td class="bg"><input type="text" class="i" name="btn_best" value="<?php echo $config['btn_best']; ?>" /></td>
	<td class="bg">추천상품만 모은 최근게시물 제목 (예: 추천상품)</td>
</tr>
<tr>
	<td>신상품 목록</td>
	<td><input type="text" class="i" name="btn_total_latest" value="<?php echo $config['btn_total_latest']; ?>" /></td>
	<td>최근 등록된 신상품 목록의 제목 (예: 최근 등록된 신제품)</td>
</tr>
<tr>
	<td class="bg">이벤트/소식</td>
	<td class="bg"><input type="text" class="i" name="btn_notice" value="<?php echo $config['btn_notice']; ?>" /></td>
	<td class="bg">이벤트/소식 최근게시물 제목 (예: 이벤트/소식)</td>
</tr>
<tr>
	<td>처음화면</td>
	<td><input type="text" class="i" name="btn_home" value="<?php echo $config['btn_home']; ?>" /></td>
	<td>처음화면으로 돌아가는 버튼 이름 (예: 처음화면)</td>
</tr>
<tr>
	<td class="bg">로그인</td>
	<td class="bg"><input type="text" class="i" name="btn_login" value="<?php echo $config['btn_login']; ?>" /></td>
	<td class="bg">로그인하는 버튼 이름 (예: 로그인)</td>
</tr>
<tr>
	<td>회원가입</td>
	<td><input type="text" class="i" name="btn_join" value="<?php echo $config['btn_join']; ?>" /></td>
	<td>회원가입(멤버등록) 할 수 있는 버튼 이름 (예: 회원가입)</td>
</tr>
<tr>
	<td class="bg">로그아웃</td>
	<td class="bg"><input type="text" class="i" name="btn_logout" value="<?php echo $config['btn_logout']; ?>" /></td>
	<td class="bg">로그아웃하는 버튼 이름 (예: 로그아웃)</td>
</tr>
<tr>
	<td>정보수정</td>
	<td><input type="text" class="i" name="btn_myinfo" value="<?php echo $config['btn_myinfo']; ?>" /></td>
	<td>기본 회원정보를 확인하고 수정하는 버튼 이름 (예: 정보수정)</td>
</tr>
<tr>
	<td class="bg">주문조회</td>
	<td class="bg"><input type="text" class="i" name="btn_order" value="<?php echo $config['btn_order']; ?>" /></td>
	<td class="bg">주문한 (했던) 물품들 목록을 확인하는 버튼 이름 (예: 주문조회)</td>
</tr>
<tr>
	<td>장바구니</td>
	<td><input type="text" class="i" name="btn_cart" value="<?php echo $config['btn_cart']; ?>" /></td>
	<td>찜한 상품들 목록을 확인하는 버튼 이름 (예: 장바구니)</td>
</tr>
<tr>
	<td class="bg">마이페이지</td>
	<td class="bg"><input type="text" class="i" name="btn_mypage" value="<?php echo $config['btn_mypage']; ?>" /></td>
	<td class="bg">부가 회원정보를 확인하고 수정하는 버튼 이름 (예: 마이페이지)</td>
</tr>
<tr>
	<td>문의게시판</td>
	<td><input type="text" class="i" name="btn_qna" value="<?php echo $config['btn_qna']; ?>" /></td>
	<td>고객들이 문의글을 남길 수 있는 버튼 이름 (예: 문의게시판)</td>
</tr>
<tr>
	<td class="bg">자유게시판</td>
	<td class="bg"><input type="text" class="i" name="btn_freeboard" value="<?php echo $config['btn_freeboard']; ?>" /></td>
	<td class="bg">자유롭게 글을 남길 수 있는 버튼 이름 (예: 자유게시판)</td>
</tr>
</tbody>
</table>
</div>

<h2>4. 기타 옵션 지정</h2>

<div class="margin">
<table rules="none" summary="GR Shop Layout Skin Config List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 150px">옵션</th>
	<th style="width: 200px">설정</th>
	<th>설명</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="bg">사이드 - 상품분류</td>
	<td class="bg"><input type="text" class="i" name="side_category" value="<?php echo $config['side_category']; ?>" /></td>
	<td class="bg">좌측 메뉴부분 상품분류 제목 (예: 상품분류)</td>
</tr>
<tr>
	<td>사이드 - 기획상품</td>
	<td><input type="text" class="i" name="side_banner" value="<?php echo $config['side_banner']; ?>" /></td>
	<td>각종 작은 배너들 상단 제목 (예: 기획상품)</td>
</tr>
<tr>
	<td class="bg">하단 - 카피라이트</td>
	<td class="bg"><input type="text" class="i" name="foot_copyright" value="<?php echo $config['foot_copyright']; ?>" /></td>
	<td class="bg">저작권 정보 (예: Copyright(C) 2009 GR Shop All rights reserved)</td>
</tr>
<tr>
	<td>통합 RSS 지원</td>
	<td><input type="checkbox" name="use_rss" value="1"<?php echo ($config['use_rss'])?' checked="checked"':''; ?> /> RSS 지원하기</td>
	<td>사이트 헤더에 GR보드 통합 RSS 주소를 넣습니다. (최신글을 RSS로 출력함)</td>
</tr>
</tbody>
</table>
</div>

<div id="layoutSetting">
	<input type="submit" value="저장하기" />
</div>

</form>

</body>
</html>