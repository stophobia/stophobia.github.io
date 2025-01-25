<!-- 전체 설정 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	GR Counter 에서 통계자료들을 구분하는 역할을 하는 ID를 생성하는 곳입니다.<br />
	기본으로 생성되는 'index' 아이디 이외에도 필요에 따라 여러 아이디를 추가할 수 있습니다.<br />
	각각의 아이디를 각각의 페이지에 넣을 경우 <u title="즉 한 아아디는 한 페이지에서 사용 가능 합니다.">해당 페이지별로 통계자료가 별도로 수집</u>됩니다.<br />
	생성된 아이디는 추후 페이지 내에 GR Counter 소스코드를 넣을 시 사용됩니다.<br />
	<span style="color: #5b934e">예) <br />
	&lt;?php<br />
	$grcount = 'grcounter/'; <span style="color: #999"># GR Counter 가 설치된 상대 경로</span><br />
	$grid = 'index'; <span style="color: #999"># 수집 대상 ID 지정</span><br />
	include $grcount . 'grcounter.php';<br />
	?&gt;</span><br />
	</div>
	<form id="addID" method="post" onsubmit="return GC.checkAddId();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="addId" value="1" /></div>
	<table rules="none" summary="GR Counter Add ID" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<tbody>
	<tr>
		<td class="l">아이디</td>
		<td class="r"><input type="text" name="id" class="t" /><input type="submit" value="추 가" class="btnS" /></td>
	</tr>
	</tbody>
	</table>
	</form>
	</div>

</div>
<!--# 전체 설정 -->