<?php

?>
<!-- 전체 설정 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	이 곳에서 GR Counter 가 어떤 식으로 동작하도록 할지 결정하실 수 있습니다.<br />
	가령 빠른 동작속도를 최우선으로 하고 싶으시면 "Extreme Mode" 를 선택하시고<br />
	적정 수준의 속도와 최적화된 DB 용량 사용을 원하시면 "Save Mode" 를 선택하세요.<br />
	(기본: Save Mode)
	</div>
	<form id="setMode" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="setMode" value="1" /></div>
	<table rules="none" summary="GR Counter Mode Setting" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<tbody>
	<tr>
		<td class="l">동작 선택</td>
		<td class="r">
			<input type="radio" name="mode" value="1"<?php echo ($GC->isExtremeMode)?' checked="checked"':''; ?> /> Extreme Mode (속도 우선)
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="mode" value="0"<?php echo (!$GC->isExtremeMode)?' checked="checked"':''; ?> /> Save Mode (효율 우선) 
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="설 정" class="btnS" />
		</td>
	</tr>
	</tbody>
	</table>
	</form>
	</div>

</div>
<!--# 전체 설정 -->