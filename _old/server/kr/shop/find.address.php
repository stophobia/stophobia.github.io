<?php
/**
 * 우편번호/주소 검색
 *  - 이 파일은 별도의 팝업창으로 띄워져야 함 (권장크기: 600 x 550)
 *  - 스타일/자바스크립트 모두 자체내에서 선언 후 사용 (jQuery 는 호출됨)
 *  - 최신 우편번호: http://www.postman.pe.kr/zipcode/index.html
 *    (참고: GR Shop 에서 사용하는 zipcode.txt 파일은 반드시 시리니넷에서 제공하는 것을 사용해야 합니다.)
 */

// Core 설정 저장
define('__GRSHOP__', true);
include 'core.php';
include 'lib/shop.lib.php';
include $grcore.'/class/common.php';
$core = new Common($grcore);
$shop = new Shop($core, $dbFIX);
$core->session($core->config['grboard'].'/session');
if(!$shop->isLogin()) $core->alert('로그인 하신 이후에 사용하실 수 있습니다.');
include 'layout/'.$shop->get('layout_skin').'/config.php';

// 처음 사용시 우편번호 테이블 생성
$isReady = $core->getData('select uid from '.$shop->prefix.'zipcode limit 1');
if(!$isReady['uid']) {
	echo '우편번호 DB 를 최신화합니다. 잠시만 기다려주세요......<br />'; flush();
	$core->query('create table '.$shop->prefix.'zipcode ( uid int(11) not null auto_increment, '.
		"code char(7) not null default '', sido char(6) not null default '', gun varchar(20) not null default '', dong varchar(30) not null default '', ".
		"ri varchar(30) not null default '', building varchar(50) not null default '', bunji varchar(50) not null default '', primary key(uid), key(dong), key(ri)) TYPE=MyISAM CHARSET=utf8;");
	echo '우편번호 DB 테이블을 생성했습니다. DB입력을 시작합니다......<br />'; flush();
	$db = file('zipcode.txt');
	$cnt = count($db);
	for($i=1; $i<$cnt; $i++) {
		if(!$db[$i]) break;
		$arr = explode("\t", $db[$i]);
		$core->query('insert into '.$shop->prefix."zipcode set uid = '', code = '".$arr[0]."', sido = '".$arr[1]."', gun = '".$arr[2]."', dong = '".$arr[3]."', ri = '".$arr[4]."', building = '".$arr[5]."', bunji = '".$arr[6]."'");
		if($i % 5000 == 0) { echo $i.'번째 우편번호를 입력했습니다...<br />'; flush(); sleep(1); }
	}
	die('우편번호 정보를 업데이트 하였습니다.<script type="text/javascript"> location.href=\'find.address.php\'; </script>');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Shop" />
<title>우편번호/주소 검색하기</title>
<style type="text/css">/*<![CDATA[*/
body { margin: 0; padding: 0; font-size: 12px; text-align: center; background: #fff url(img/find.address.back.gif) repeat-x top; }
input { font-size: 12px; }
table { width: 100%; table-layout: fixed; }
th { text-align: center; height: 36px; background: url(img/mv_top.gif) repeat-x; }
tr:hover { background-color: #fafafa; }
td { border-bottom: #eee 1px solid; padding: 5px; line-height: 165%; text-align: center; }
h2 { font-family: Malgun Gothic, sans-serif; font-size: 18pt; }
a { color: #2e83ff; text-decoration: none; }

#enter { margin-bottom: 25px; border-top: #aaa 3px solid; border-bottom: #aaa 3px solid; padding: 20px; background-color: #fcfcfc; }
#enter .i { border: #ddd 1px solid; padding: 5px; }
#enter .s { background-color: #eee; border: #aaa 1px solid; padding: 3px; }
#infoBox { margin: 20px; border: #aaa 1px dotted; padding: 10px; line-height: 165%; background-color: #ffffe5; text-align: left; display: none; }
/*]]>*/</style>
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.js"></script>
<script type="text/javascript">//<![CDATA
$(function(){
	$("#infoBox", this).toggle("infoBox");
});
function choose(code, address) {
	opener.document.forms['purchase'].elements['mail_code'].value = code;
	opener.document.forms['purchase'].elements['address1'].value = address;
	opener.document.forms['purchase'].elements['address2'].focus();
	self.close();
}
//]]></script>
</head>
<body>

<h2>우편번호 검색</h2>

<form id="code" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="enter">
	검색할 읍/면/동/건물 이름을 적어주세요.<br /><br />
	<input type="text" name="dong" class="i" value="<?php echo $_POST['dong']; ?>" /> <input type="submit" value="검색" class="s" />
</div>
</form>

<?php if($_POST['dong']) { ?>

<table rules="none" summary="GR Shop Cash List" cellpadding="0" cellspacing="0" border="0" style="width: 100%; table-layout: fixed">
<caption></caption>
<thead>
<tr>
	<th style="width: 80px">우편번호</th>
	<th style="width: 45px">시/도</th>
	<th style="width: 80px">구/군</th>
	<th style="width: 80px">동</th>
	<th>건물명</th>
	<th style="width: 80px">번지</th>
	<th style="width: 45px">선택</th>
</tr>
</thead>
<tbody>
<?php
// 검색 실행
$dong = $_POST['dong'];
$result = $core->query('select * from '.$shop->prefix."zipcode where dong like '%{$dong}%' or ri like '%{$dong}%' or building like '%{$dong}%' order by code asc");
while($list = $core->fetch($result)) { ?>
<tr>
	<td><?php echo $list['code']; ?></td>
	<td><?php echo $list['sido']; ?></td>
	<td><?php echo $list['gun']; ?></td>
	<td><?php echo $list['dong']; ?></td>
	<td><?php echo $list['building']; ?></td>
	<td><?php echo $list['bunji']; ?></td>
	<td><a href="#" onclick="choose('<?php echo $list['code']; ?>', '<?php echo $list['sido'].' '.$list['gun'].' '.$list['dong'].' '.$list['building'].' '.$list['bunji']; ?>');">선택</a></td>
</tr>
<?php } #while ?>
</tbody>
</table>

<?php } else { ?>

<div id="infoBox">
<strong>※ 우편번호/주소 도움말</strong><br />
<br />
우편번호/주소는 기본적으로 고객님의 집주소를 가정합니다.<br />
그러나 필요에 따라 배송받을 위치를 집이 아닌 직장이나 다른 곳으로 정하실 수 있습니다.<br />
<br />
단, 이미 다른 상품을 구매하신 후에 아직 택배를 받지 않은 상태에서<br />
다시 다른 상품을 구매하여 주소를 변경하시면, 이미 구매한 상품과 방금 구매한 상품은<br />
자동으로 마지막으로 변경된 배송지에 보내지게 됩니다.<br />
<br />
만약 이를 원하지 않으실 경우, 입금하시기 전 "<?php echo $config['btn_qna']; ?>" 에 비밀글로<br />
구매할 상품과 배송지를 다시 알려주신 후 입금을 해 주세요.<br />
<br />
보다 정확하고 신속한 배송을 위해 받으실 곳을 정확히 입력해 주세요.
</div>

<?php } ?>

</body>
</html>