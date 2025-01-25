<?php
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
if(!$shop->isAdmin()) $core->alert('관리자만 접속할 수 있습니다.', '../login/?go=../update/');

// for v0.91
$core->query('create table '.$shop->prefix."cards (
	uid int(11) not null auto_increment,
	member_key int(11) not null default '0',
	order_key int(11) not null default '0',
	rBusiCd char(4) not null default '',
	rOrdNo varchar(40) not null default '',
	rProdNm varchar(100) not null default '',
	rApprNo char(8) not null default '',
	rAmt int(11) not null default '0',
	rApprTm char(14) not null default '',
	rCardNm varchar(20) not null default '',
	rCardCd char(4) not null default '',
	rMembNo varchar(15) not null default '',
	rAquiCd char(4) not null default '',
	rAquiNm varchar(20) not null default '',
	rBillNo char(6) not null default '',
	primary key(uid),
	key(member_key),
	key(order_key),
	key(rBusiCd),
	key(rOrdNo),
	key(rCardCd),
	key(rBillNo)) TYPE=MyISAM CHARSET=utf8;");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GR Shop Upgrade: v0.9 Beta ▶▶▶ v0.91 Beta</title>
</head><body>

<h2>GR Shop v0.91 Beta 의 업데이트가 완료 되었습니다!</h2>

<strong>DB Table 업데이트 내역</strong>
<ul>
	<li>v0.91 Beta : 카드 결제후 거래 성공시 올더게이트에서 전송받은 결과값을 저장하는 테이블 ({prefix}_cards) 생성</li>
</ul>

<a href="../">[처음 화면으로 돌아가기]</a>

</body></html>