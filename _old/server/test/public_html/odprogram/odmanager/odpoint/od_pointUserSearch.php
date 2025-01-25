<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";


?>
<form name="frm" action="<?=$_SERVER[PHP_SELF]?>">
<input type="hidden" name="mode" value="1">
<table width=100% border=0 cellpadding=5 cellspacing=1 bgcolor="444444">
	<tr>
		<td height=40 bgcolor="cccccc" align=center colspan=2>회원검색</td>
	</tr>
	<tr>
		<td bgcolor="FFFFFF" style="font-family:굴림체;line-height:200%;padding-left:20px">
		이&nbsp;&nbsp;름 : <input type="text" name="name" size=10 class="border"> &nbsp; &nbsp;&nbsp;
		아이디 : <input type="text" name="id" size=10 class="border"> &nbsp; &nbsp;&nbsp;
		주&nbsp;&nbsp;소 : <input type="text" name="address" size=10 class="border"> &nbsp; &nbsp;&nbsp;
		연락처 : <input type="text" name="tel" size=10 class="border"> &nbsp; &nbsp;<br>
		등&nbsp;&nbsp;급 : <select name="level" class="border" style='width:70px'>
												<option value="">::등급::</option>
												<option value="1">1등급</option>
												<option value="2">2등급</option>
												<option value="3">3등급</option>
												<option value="4">4등급</option>
												<option value="5">5등급</option>
												<option value="6">6등급</option>
												<option value="7">7등급</option>
												<option value="8">8등급</option>
												<option value="9">9등급</option>
												<option value="10">10등급</option>
											</select> &nbsp; &nbsp;&nbsp;
		성&nbsp; 별 : <select name="sex" class="border" style='width:70px'>
												<option value="">::성별::</option>
												<option value="M">남</option>
												<option value="F">여</option>
											</select> &nbsp; &nbsp;&nbsp;
		연령대 : <input type="text" name="age1" class="border" style='width:26px'> ~ <input type="text" name="age2" class="border" style='width:26px'> &nbsp; &nbsp;&nbsp;
		가입일 : <input type="text" name="join" size=10 class="border">
		</td>
		<td bgcolor="FFFFFF">
		<input type="submit" style="width:70px;height:30px" value="검색">
		</td>
	</tr>
</table>
</form>
<script>
var isCheck = 1;
function allC() {
	frm3 = document.frm2;
	obj = frm3.elements['no[]'];
	if(obj.length == undefined) {
		if(this.isCheck == 1) {
				obj.checked = true;
		} else {
				obj.checked = false;
		}
	} else {
		if(this.isCheck == 1) {
			for(i=0;i<obj.length;i++) {
				obj[i].checked = true;
			}
			this.isCheck =2;
		} else {
			for(i=0;i<obj.length;i++) {
				obj[i].checked = false;
			}
			this.isCheck =1;
		}
	}
}
function submitFun(frm) {
	obj = frm.elements['no[]'];
	var result = '';
	if(obj.length == undefined) {
		if(obj.checked == true) result = obj.value;
	} else {
		for(i=0;i<obj.length;i++) {
			if(obj[i].checked == true) {
				result += result != '' ? ","+obj[i].value : obj[i].value;
			}
		}
	}

	opener.document.snsForm.pointIDArray.value = result;
	self.close();

	return false;
}
</script>
<form name="frm2" action="" onsubmit="return submitFun(this)">
<input type="submit" value="입력" style="width:70px;height:30px">
<table width=100% border=0 cellpadding=3 cellspacing=1 bgcolor="111111">
	<tr>
		<td align="center" bgcolor="eeeeee" width=30 ><a href="#none" onclick="allC()">전체</a></td>
		<td align="center" bgcolor="eeeeee" width=70 >이름<br>(아이디)</td>
		<td align="center" bgcolor="eeeeee" width=90 >연락처</td>
		<td align="center" bgcolor="eeeeee" width=30 >나이</td>
		<td align="center" bgcolor="eeeeee">주소</td>
		<td align="center" bgcolor="eeeeee" width=30 >성별</td>
		<td align="center" bgcolor="eeeeee" width=30 >등급</td>
		<td align="center" bgcolor="eeeeee" width=90 >가입일</td>
	</tr>
<?
$search = "";
if($name)			$search = " and name			like '%".$name."%' ";
if($id)				$search = " and id				like '%".$id."%' ";
if($address)	$search = " and address		like '%".$address."%' ";
if($tel)			$search = " and tel3			like '%".$tel."%' ";
if($level)		$search = " and actionLevel	= '".$level."' ";
if($sex)			$search = " and sex = '".$sex."' ";
if($age1)			$search = " and (birthy >= '".(date('Y')-$age2+1)."' and birthy <= '".(date('Y')-$age1+1)."') ";
if($join)			$search = " and (signdate >= '".strtotime($join)."' and signdate <= '".(strtotime($join)+60*60*24)."')";


$que = "select * from odtMember where id<>'' ".$search;
$res = mysql_query($que);
if($mode) {
	while($row = mysql_fetch_array($res)) {
	?>
		<tr>
			<td align="center" bgcolor="ffffff"><input type="checkbox" name="no[]" value="<?=$row[id]?>" border=0></td>
			<td align="center" bgcolor="ffffff"><?=$row[name]?><br>(<?=$row[id]?>)</td>
			<td align="center" bgcolor="ffffff"><?=$row[tel1].$row[tel2].$row[tel3]?><br><?=$row[htel1].$row[htel2].$row[htel3]?></td>
			<td align="center" bgcolor="ffffff"><?=date('Y')-$row[birthy]+1?></td>
			<td align="center" bgcolor="ffffff"><?=$row[address]." ".$row[address1]?></td>
			<td align="center" bgcolor="ffffff"><?=$row[sex] == "M" ? "남" : "여";?></td>
			<td align="center" bgcolor="ffffff"><?=$row[Mlevel]?></td>
			<td align="center" bgcolor="ffffff"><?=date('Y-m-d',$row[signdate])?></td>
		</tr>
	<?
	}
}
?>
		<tr style='display:none'>
			<td align="center" bgcolor="ffffff"><input type="checkbox" name="no[]" value="<?=$row[id]?>" border=0></td>
			<td align="center" bgcolor="ffffff"><?=$row[name]?><br>(<?=$row[id]?>)</td>
			<td align="center" bgcolor="ffffff"><?=$row[tel1].$row[tel2].$row[tel3]?><br><?=$row[htel1].$row[htel2].$row[htel3]?></td>
			<td align="center" bgcolor="ffffff"><?=date('Y')-$row[birthy]+1?></td>
			<td align="center" bgcolor="ffffff"><?=$row[address]." ".$row[address1]?></td>
			<td align="center" bgcolor="ffffff"><?=$row[sex] == "M" ? "남" : "여";?></td>
			<td align="center" bgcolor="ffffff"><?=$row[Mlevel]?></td>
			<td align="center" bgcolor="ffffff"><?=date('Y-m-d',$row[signdate])?></td>
		</tr>
</table>
<input type="submit" value="입력" style="width:70px;height:30px">
</form>