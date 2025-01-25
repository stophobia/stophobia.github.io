<?
header("Content-Type: text/html; charset=utf-8"); 
include dirname(__FILE__)."/odprogram/odcommon/od_db_conf.php";

include "./icon.php";

# 현재 상품 방송시간 추출 (초기 업데이트시에는 내가 쓴글도 보일수 있도록한다.)
$live_start_time = mysql_result(mysql_query("select live_start_time from odtProduct where code ='".$_POST[code]."'"),0);

if($live_start_time == $_POST[now]) {
	$que = "select * from odtLiveChat where code = '".$_POST[code]."' and regidate > '".$_POST[now]."' and id != '' order by regidate asc";
} else {
	$que = "select * from odtLiveChat where code = '".$_POST[code]."' and regidate > '".$_POST[now]."' and id != '".$_POST[id]."' and id != '' order by regidate asc";
}
$res = mysql_query($que);

// 새로 등록된 글이 없으면 중지.
if(!mysql_num_rows($res)) {exit;}

// 새로 등록된 글이 있으면 출력.
while($row = mysql_fetch_array($res)) {
	# 이모티콘 변환
	$iconKey = array_keys($iconArray);
	for($i=0;$i<count($iconKey);$i++) {
		$row[content] = str_replace("/".$iconKey[$i]."/","<img src='/images/icon/".$iconArray[$iconKey[$i]].".gif'>",$row[content]);
	}

	echo "<span style='font-weight:bold;color:".$row[color].";font-family:".$row[font].";'>[".$row[name]."] 님의 말</span><br />";
	echo "<span style='font-family:".$row[font].";'>".$row[content]."</span><br />";
	$lastDate = $row[regidate];
}
echo ":::::".$lastDate;
?>