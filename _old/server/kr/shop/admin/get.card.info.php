<?php
// 변수처리
if(!$_POST['uid']) exit();
$uid = $_POST['uid'];

// Core 설정 저장
define('__GRSHOP__', true);
include '../core.php';
$_grcore = $grcore;
$grcore = '../'.$_grcore;
include $grcore.'/class/common.php';
include '../lib/shop.lib.php';
$core = new Common($grcore);
$shop = new Shop($core, $dbFIX);
$grboard = '../'.$core->config['grboard'];
$core->session($grboard.'/session');

// 관리자가 아니면 퇴출
if(!$shop->isAdmin()) $core->alert('관리자만 접속할 수 있습니다.', '../login/?go=../');

// 카드정보 가져오기
$info = $core->getData('select * from '.$shop->prefix.'cards where uid = '.$uid);
?>
<ul>
	<li>주문번호: <?php echo $info['rOrdNo']; ?></li>
	<li>전문코드: <?php echo $info['rBusiCd']; ?> / 승인번호: <?php echo $info['rApprNo']; ?></li>
	<li>승인시각: <?php echo $info['rApprTm']; ?></li>
	<li>카드사명: <?php echo $info['rCardNm']; ?> / 매입사명: <?php echo $info['rAquiNm']; ?></li>
	<li>전표번호: <?php echo $info['rBillNo']; ?> / 카드사코드: <?php echo $info['rCardCd']; ?></li>
	<li>가맹점번호: <?php echo $info['rMembNo']; ?> / 매입사코드: <?php echo $info['rAquiCd']; ?></li>
</ul>