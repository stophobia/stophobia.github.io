<?php
@header('Content-Type: text/html; charset=utf-8');
if(!$_GET['ip']) die('IP Address is Unknown.');
$ip = $_GET['ip'];
include '../phpwhois/whois.main.php';
$whois = new Whois();
$result = $whois->Lookup($ip);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GR Counter Whois</title>
<style type="text/css">/*<![CDATA[*/
body { margin: 0; padding: 0; font-size: 12px; color: #666; font-family: Georgia, Gulim, sans-serif; }
td { line-height: 160%; }
.titleBar { height: 34px; background: url(../image/whois_top_back.gif) repeat-x; border-bottom: #9ec24f 1px solid; color: #fff; }
.l { height: 28px; background: url(../image/whois_option_back.gif) repeat-x; text-align: center; font-weight: bold; }
.ll { text-align: center; font-weight: bold; }
.r { border-bottom: #f7f7f7 1px solid; padding-left: 5px; }
.raw { margin: 5px; padding: 5px; background-color: #fafafa; border: #eee 3px solid; }
/*]]>*/</style>
</head>
<body>
<table rules="none" summary="GR Board DB Status" cellpadding="0" cellspacing="0" border="0" style="width: 100%">
<caption></caption>
<colgroup>
<col style="width: 100px" />
<col />
</colgroup>
<thead>
<tr>
	<th colspan="2" class="titleBar">Whois 정보보기 - <?php echo $ip; ?></th>
</tr>
</thead>
<tbody>
<tr>
	<td class="l">소유 회사</td>
	<td class="r"><?php 
	if(is_array($result['regrinfo']['owner']['organization'])) {
		if($result['regrinfo']['owner']['organization'][0]) echo $result['regrinfo']['owner']['organization'][0].', ';
		if($result['regrinfo']['owner']['organization'][1]) echo $result['regrinfo']['owner']['organization'][1];
	} else echo $result['regrinfo']['owner']['organization'];
	?></td>
</tr>
<tr>
	<td class="l">소유주 주소</td>
	<td class="r"><?php 
	if(is_array($result['regrinfo']['owner']['address'])) {
		if($result['regrinfo']['owner']['address']['country']) echo '<span style="cursor: help; font-weight: bold" title="국가 코드입니다. (대게) 알파벳 2자로 구성됩니다. (예: US → 미국, CA → 캐나다...)">'.$result['regrinfo']['owner']['address']['country'].'</span>, ';
		if($result['regrinfo']['owner']['address']['state']) echo '<span style="cursor: help" title="주/도명 입니다. 미국 같은 경우 주(state)명이 나타납니다.">'.$result['regrinfo']['owner']['address']['state'].'</span>, ';
		if($result['regrinfo']['owner']['address']['city']) echo '<span style="cursor: help; font-weight: bold" title="도시명입니다.">'.$result['regrinfo']['owner']['address']['city'].'</span>, ';
		if($result['regrinfo']['owner']['address']['street']) echo '<span style="cursor: help" title="도로/길거리 이름입니다. 번지수도 간혹 포함됩니다.">'.$result['regrinfo']['owner']['address']['street'].'</span>';
	} else echo $result['regrinfo']['owner']['address']; ?></td>
</tr>
<tr>
	<td class="l">관리자명</td>
	<td class="r"><?php echo ($result['regrinfo']['admin']['name'])?$result['regrinfo']['admin']['name']:'비공개'; ?></td>
</tr>
<tr>
	<td class="l">연락처</td>
	<td class="r"><?php echo ($result['regrinfo']['admin']['phone'])?$result['regrinfo']['admin']['phone']:'비공개'; ?></td>
</tr>
<tr>
	<td class="l">이메일</td>
	<td class="r"><?php echo ($result['regrinfo']['admin']['email'])?$result['regrinfo']['admin']['email']:'비공개'; ?></td>
</tr>
<tr>
	<td class="l">IP관리기관</td>
	<td class="r"><?php echo $result['regyinfo']['registrar']; ?></td>
</tr>
<tr>
	<td class="l">후이즈 서버</td>
	<td class="r"><?php echo $result['regyinfo']['whois']; ?></td>
</tr>
<tr>
	<td class="l">조회 분류</td>
	<td class="r"><?php echo $result['regyinfo']['type']; ?></td>
</tr>
<tr>
	<td class="l">조회 포트</td>
	<td class="r"><?php echo $result['regyinfo']['port']; ?></td>
</tr>
<tr>
	<td colspan="2" class="r">
	<strong>※ 아래는 검색 질의 응답입니다.</strong><br /><br />
	<?php
	$rows = count($result['rawdata']);
	for($i=0; $i<$rows; $i++) {
		if($i > 2 && $result['rawdata'][3] == '# KOREAN') echo iconv('euckr', 'utf-8', $result['rawdata'][$i]).'<br />';
		else echo $result['rawdata'][$i].'<br />';
	}
	?>
	</td>
</tr>
</tbody>
</table>
</body>
</html>