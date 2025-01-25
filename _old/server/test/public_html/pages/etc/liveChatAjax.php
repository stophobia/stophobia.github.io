<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";

?>


<table width=525 align=center border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=75 align=right style="padding-right:15px"><img src="/images/livetalk_03.gif" border=0></td>
	</tr>
	<tr>
		<td height=1 bgcolor="e3e3e3"></td>
	</tr>

	<?
	$que = "select * from odtLiveChat where code ='".$code."' order by regidate asc";
	$res = mysql_query($que);
	if(!mysql_num_rows($res)) {
		echo "<tr><td  align=center style='padding:8px 0 8px 0' align=center>대화 내용이 없습니다.</td></tr>";
	}
	while($row = mysql_fetch_array($res)) {

		#
		$row[content] = htmlspecialchars($row[content]);

		# 이모티콘 변환
		include $_SERVER[DOCUMENT_ROOT]."/icon.php";
		$iconKey = array_keys($iconArray);
		for($i=0;$i<count($iconKey);$i++) {
			$row[content] = str_replace("/".$iconKey[$i]."/","<img src='/images/icon/".$iconArray[$iconKey[$i]].".gif'>",$row[content]);
		}
	?>
	<tr>
		<td width=525 align=center style="padding:8px 0 8px 0"><table width=510 align=center border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td><span style="color:48688e;"><?=apply_talkname($row[id],$row[name])?></span> <span style="color:0099ff;font-size:11px">(<?=date('m.d H:i',strtotime($row[regidate]))?>)</span> &nbsp; 
				<span style="color:4e4e4e;padding-left:0"><?=$row[content]?></span>
				</td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td height=1 background="/images/livetalkdot_07.gif"></td>
	</tr>
	<?
	}
	?>
</table>