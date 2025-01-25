<?
	include "./odprogram/odcommon/od_config.inc.php";
	include "./odprogram/odcommon/od_function.inc.php";	
	include "./odprogram/odcommon/od_lib.inc.php";
//	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	function userDetail3($id,$name) {
				global $array_adminid,$row_member,$admin,$_COOKIE;
				$randID = rand(1,99999);
				
				$isAdminTmp = mysql_num_rows(mysql_query("SELECT * FROM odtAdmin WHERE serialnum = '".$_COOKIE['auth_adminid']."'"));

				if(@array_key_exists($row_member[id],$array_adminid) != true && !$isAdminTmp) {
					return $name;
				}
	
				$que = "select id,name,address,signdate,point,action,sex,birthy from odtMember where id='".$id."'";
				$res = mysql_query($que);

				# 구매내역
				unset($buyLog);
				$res2 = mysql_query("select * from odtOrder where orderid = '".$id."' and paystatus = 'Y' and canceled = 'N'");
				if(!mysql_num_rows($res2)) $buyLog = " : 없음";
				while($row2 = mysql_fetch_array($res2)) {
					$pLog = explode("^",$row2[pLog]);
					for($z=0;$z<count($pLog);$z++) {
						$pLogTmp = explode("|",$pLog[$z]);
						$proName = mysql_result(mysql_query("select name from odtProduct where code ='".$pLogTmp[0]."'"),0);
						$buyLog .= "<br>[".date('m.d H:i',strtotime($row2[orderdate]))."](".$pLogTmp[1]."개)".cut_str_short($proName,20);
					}
				}
				if(!$id) $buyLog = " : 없음";

				$ment = "<span onclick=\"document.getElementById(selfID).style.display='none'\" style='cursor:hand'><b>[닫기]</b></span><br>";

				if(!mysql_num_rows($res)) {
					$ment .= "비회원<br>";
				} else {
					$row = mysql_fetch_array($res);
					$ment .= "아&nbsp;이&nbsp;디 : ".$row[id]."<br>";
					$ment .= "이&nbsp;&nbsp;&nbsp;&nbsp;름 : ".$row[name]."(".(date('Y')-$row[birthy]+1)."세-".($row[sex] == "M" ? "남" : "여").")<br>";
					$ment .= "주&nbsp;&nbsp;&nbsp;&nbsp;소 : ".$row[address]."<br>";
					$ment .= "포&nbsp;인&nbsp;트 : ".number_format($row[point])." 포인트<br>";
					$ment .= "참여점수 : ".number_format($row[action])." 점<br>";
					$ment .= "가&nbsp;입&nbsp;일 : ".date('Y년 m월 d일',$row[signdate])."<br>";
				}
				$ment .= "<b>구매내역</b>".$buyLog;

				// 접속경로
				unset($orderIP);
				$orderIP = @mysql_result(mysql_query("select ip from odtMember where id='".$id."'"),0);
				$ment .= "<br><b>접속경로</b>";
				if(!$orderIP) $orderIP = @mysql_result(mysql_query("select ip from odtOrder where orderid='".$id."'"),0);
				if($orderIP) {
					$cRes = mysql_query("select Time,Connect_Route from odtCounter where Connect_IP = '".$orderIP."' and Connect_Route != '' and !(Connect_Route like '%".str_replace('www.','',$_SERVER[HTTP_HOST])."%')  order by Time desc limit 10");
					if(!mysql_num_rows($cRes)) $ment .= "<br>즐겨찾기나 주소를 바로 입력하여 접속.";
					while($cRow = mysql_fetch_array($cRes)) {
						$ment .= "<br><a href='".$cRow[Connect_Route]."' target='_blank'>[".date('m.d H:i',$cRow[Time])."] ".$cRow[Connect_Route]."</a>";
					}
				}

				$ttName = "<table border='0' cellpadding='2' cellspacing='3' bgcolor='#7B7B7B'>
										<tr>
											<td nowrap bgcolor='#FFFFFF' style='padding:7;font-family:굴림체'>".$ment."</td>
										</tr>
									</table>";


		return $ttName;
	}
if($_POST[id] && $_POST[name]) {
	echo userDetail3($_POST[id],$_POST[name]);
}
?>