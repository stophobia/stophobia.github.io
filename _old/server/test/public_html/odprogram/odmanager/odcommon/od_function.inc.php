<?
	## 추가 섬값
	$_MaddSum = "00100200300";	// 00100200300
	
	## 기본정보 호출
	function info_basic() {
		$row_setup = mysql_fetch_array(mysql_query("SELECT * FROM odtSetup WHERE serialnum='1'"));
		return $row_setup;
	}
	$row_setup = info_basic();
	
	if(!$row_setup[ranDsum]) $row_setup[ranDsum] = "wkrlditkfkdgo";
	
	## 회사정보 호출
	function info_company() {
		$row_company = mysql_fetch_array(mysql_query("SELECT * FROM odtCompany WHERE serialnum='1'"));
		return $row_company;
	}
	$row_company = info_company();
	
	$_company_tel_division = explode("-",$row_company[tel]);
	$_sms_company_tel = $_company_tel_division[0].$_company_tel_division[1].$_company_tel_division[2];
	$_company_htel_division = explode("-",$row_company[htel]);
	$_sms_company_htel = $_company_htel_division[0].$_company_htel_division[1].$_company_htel_division[2];

	## 관리자 로그인 처리
	function login_admin($serialnum,$_MranDsum,$_MaddSum,$keepTerm) {
		global $_COOKIE;
		$_Mstring_join = $serialnum.$_MranDsum.$_MaddSum;
		
		if($_COOKIE['auth_adminid']) {
			SetCookie("auth_adminid","",-999,"/");
			
			return false;
		}
		else {
			SetCookie("auth_adminid",$serialnum,0,"/");
			SetCookie("auth_adminid_sess",md5($_Mstring_join),0,"/");
			//SetCookie("auth_adminid",$serialnum,time()+$keepTerm,"/");
			//SetCookie("auth_adminid_sess",md5($_Mstring_join),time()+$keepTerm,"/");

			return true;
		}
	}

	## 입점업체 로그인 처리
	function login_subcompany($serialnum,$_MranDsum,$_MaddSum,$keepTerm) {
		global $_COOKIE;
		$_Mstring_join = $serialnum.$_MranDsum.$_MaddSum;
				
		if($_COOKIE['auth_comid']) {
			SetCookie("auth_comid","",-999,"/");
				
			return false;
		}
		else {
			SetCookie("auth_comid",$serialnum,0,"/");
			SetCookie("auth_comid_sess",md5($_Mstring_join),0,"/");
			return true;
		}
	}
	## 관리자 로그인 인증 처리
	function chk_admin($_MranDsum,$_MaddSum) {
		global $_COOKIE;
		$get_manager_serialnum = $_COOKIE['auth_adminid'];
		$get_auth_adminid_sess = $_COOKIE['auth_adminid_sess'];
		$get_manager_serialnum .= $_MranDsum .= $_MaddSum;
		$real_auth_adminid_sess = md5($get_manager_serialnum);
		
		if($get_auth_adminid_sess == $real_auth_adminid_sess) return true;
		else return false;
	}

	## 로그인한 관리자 정보 호출
	function info_admin($_MranDsum,$_MaddSum) {
		global $_COOKIE;
		$get_member_serialnum = $_COOKIE['auth_adminid'];
		$get_auth_adminid_sess = $_COOKIE['auth_adminid_sess'];
		$get_member_serialnum .= $_MranDsum .= $_MaddSum;
		$real_auth_adminid_sess = md5($get_member_serialnum);
		
		if($get_auth_adminid_sess == $real_auth_adminid_sess) {
			$row_member = mysql_fetch_array(mysql_query("SELECT * FROM odtAdmin WHERE serialnum = '".$_COOKIE['auth_adminid']."'"));
			
			return $row_member;
		}
	}
	$row_admin = info_admin($row_setup[ranDsum],$_MaddSum);
	

	## 로그인한 관리자 정보 호출
	function info_subcompany($_MranDsum,$_MaddSum) {
		global $_COOKIE;
		$get_member_serialnum = $_COOKIE['auth_comid'];
		$get_auth_adminid_sess = $_COOKIE['auth_comid_sess'];
		$get_member_serialnum .= $_MranDsum .= $_MaddSum;
		$real_auth_adminid_sess = md5($get_member_serialnum);
		

		if($get_auth_adminid_sess == $real_auth_adminid_sess) {
			$row_member = mysql_fetch_array(mysql_query("SELECT * FROM odtMember WHERE serialnum = '".$_COOKIE['auth_comid']."'"));
			
			return $row_member;
		}
	}
	$com = info_subcompany($row_setup[ranDsum],$_MaddSum);
	
	## 에러 메시지1
	function error_msgloc($url,$msg) {
		echo "
			<script>
				alert(\"$msg\");
				location.href=\"$url\";
			</script>";

		exit;
	}

	## 에러메시지2
	function error_msgback_user($msg) {
		echo "
			<script>
				alert(\"$msg\");
				history.go(-1);
			</script>";

		exit;
	}

	function insert_sms() {
		$row_sms = mysql_fetch_array(mysql_query("SELECT * FROM odtSms WHERE serialnum='1'"));

		return $row_sms;
	}
	$row_sms = insert_sms();
	
	$_minput_use_division_ = explode("/",$row_sms[minput_use]);
	$_oinput_use_division_ = explode("/",$row_sms[oinput_use]);
	$_pinput_use_division_ = explode("/",$row_sms[pinput_use]);
	$_dinput_use_division_ = explode("/",$row_sms[dinput_use]);
	$_cinput_use_division_ = explode("/",$row_sms[cinput_use]);


	## 문자 자르기
	function cut_str_short($Str, $size, $addStr="...")  { 
    if(mb_strlen($Str, "UTF-8") > $size) return mb_substr($Str, 0, $size, "UTF-8").$addStr; 
    else return $Str; 
	} 

	## 메세지
	function error_msgall($msg,$option='') {
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo "<script>alert('".$msg."');";

		if($option == "back")				{echo "history.back();";}
		else if($option == "close")	{echo "self.close();";}
		else if($option == "reload"){echo "parent.location.reload();";}
		else if($option == "exit")	{echo "</script>";exit;}
		else if($option)						{echo "location.href='".$option."'";}

		echo "</script>";
		return;
	}

	## 이동
	function error_loc($url='/') {
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo "<script>location.href='".$url."';</script>";
		return;
	}

	# THREE와 FIVE 상품날짜 계산 함수
	function calcul_time($catecode,$date) {
		global $row_setup;

		$defaultDate = $row_setup[mallstart];
		$gapTime = strtotime($date) - strtotime($defaultDate);
		$gapDay =  $gapTime / 60 / 60 / 24;
		switch($catecode) {
			case "01" :
				return true;
				break;
			case "02" :
				if(date('w',strtotime($date)) == 1) return true;
				break;
			case "03" :
				return true;
				break;
			case "04" :
				if($gapDay % 3 == 0) return true;
				break;
			case "05" :
				if($gapDay % 5 == 0) return true;
				break;
			default :
				return true;
				break;
		}
		return false;
	}
	$helpIdx=1;
	function help_pop($ment) {
		global $helpIdx;
		$id = "helpLayer".++$helpIdx;
		?>
		<a href="#none"><img src="/img/helpicon.gif" border=0 align=absmiddle  onclick="document.getElementById('<?=$id?>').style.display='inline'"></a>
		<div id=<?=$id?> style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none;' >
			<div style='position:absolute;z-index:3;top:5;left:20;'>
				<table border='0' cellpadding='2' cellspacing='3' bgcolor='#7B7B7B'>
					<tr>
						<td bgcolor='#FFFFFF' style='padding:7px;' >
						<span style='cursor:pointer;color:blue' onclick="document.getElementById('<?=$id?>').style.display='none'"><b>[닫기]</b></span>
						<br>
						<?=$ment?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?
	}

function cut_str(&$contents,$cut_len=0,$cut_num=1) {

     /// 문자열 길이
     $cont_len = strlen($contents);
     
     /// setting default values
     if($cut_len <= 0) $cut_len = $cont_len; 
     else              $cut_len = intval($cut_len);
     if($cut_num <= 0)    $cut_num = 1;
     elseif($cut_num > 1) $cut_num = intval($cut_num);

     /// 문자열을 자르기 위한 시작위치
     $start_pos = 0;

     /// 자를 갯수만큼 loop
     for($cnt=1; $cnt <= $cut_num; $cnt++) {
          /// 다음번에 자를 문자열이 남아 있을때
          if($cont_len > ($start_pos + $cut_len)) {
                 $s_flag = false;
                 $tmp_str = substr($contents,$start_pos,$cut_len);
                 $tmp_pos = strrpos($tmp_str,' ');
                 if(!$tmp_pos) $tmp_pos = 0;

                 /// 자른 문자열에서 역으로 첫번째 space문자를 검출후 다시 space문자에서부터
                 /// 자른 문자열 끝까지 2byte문자 시작위치인지 여부를 체크해서
                 /// 2byte문자 시작위치이면 1byte 앞까지 문자를 잘라서 array에 넣음
                 /// $s_flag 는 2byte문자 시작위치인지에 대한 flag
                 for($i=$tmp_pos; $i < $cut_len; $i++) {
                       if(ord($tmp_str[$i]) > 127) {
                             if($s_flag) $s_flag = false;
                             else         $s_flag = true;
                       }
                       else $s_flag = false;
                 }

                 if($s_flag) {
                       $arr_cont[$cnt] = substr($tmp_str,0,$cut_len-1);
                       $start_pos += $cut_len - 1;          
                 }    
                 else {
                       $arr_cont[$cnt] = $tmp_str;
                       $start_pos += $cut_len;    
                 }
                 
                 /// 문자열을 $cut_num 갯수까지 자른후, 나머지를 array의 마지막에 넣음
                 if($cnt == $cut_num) {
                        $arr_cont[$cnt+1] = substr($contents,$start_pos);
                 }       
          }
          /// 다음번에 더이상 자를 문자열이 없으므로 for loop 빠져나감
          else {
                 $arr_cont[$cnt] = substr($contents,$start_pos);
                 break;
          }      
     }     
     
     /// array첫번째에 실제로 문자열을 자른 갯수를 넣는다
     $arr_cont[0] = $cnt;

     return $arr_cont;

} // End of cut_str()
/// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

function chk_authfree() {
	global $freeid,$_SERVER;

	// 관리자면 패스
	if($_SERVER[REMOTE_ADDR] == "119.67.223.105" || $_SERVER[REMOTE_ADDR] == "112.156.23.89") return;


}





	// add function - writer : onedaynet jjc
	function ViewArr($arr) {
		echo "<xmp>". print_R($arr , true) ."</xmp>";
	}

?>