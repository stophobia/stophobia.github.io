<?
	## 추가 섬 값
	function rand_num() { 
		return $addSum = "dnjsepdlspt"; 
	}
	$addSum = rand_num();

	## 쇼핑몰 기본정보 호출
	function info_basic() {
		$row_setup = mysql_fetch_array(mysql_query("SELECT * FROM odtSetup WHERE serialnum='1'"));
		
		return $row_setup;
	}
	$row_setup = info_basic();

	if(!$row_setup[ranDsum]) $row_setup[ranDsum] = "qldpsdptmtltmxpawm";

	if($row_setup[tableloc] == C) $row_setup[tableloc] = "center";
	else $row_setup[tableloc] = "left";

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

	## 로그인
	function apply_login($serialnum,$ranDsum,$addSum) {
		global $_COOKIE;
		$string_join = $serialnum.$ranDsum.$addSum;
		
		if($_COOKIE['auth_memberid']) {
			SetCookie("auth_memberid","",-999,"/");
			
			return false;
		}
		else {
			SetCookie("auth_memberid",$serialnum,0,"/");
			SetCookie("auth_memberid",$serialnum,0,"/",".*.*");
			SetCookie("auth_memberid_sess",md5($string_join),0,"/");
			SetCookie("auth_memberid_sess",md5($string_join),0,"/",".*.*");
			
			return true;
		}
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

	## 회원인증
	function chk_login($url,$msg,$ranDsum,$addSum) {
		global $_COOKIE;
		$get_member_serialnum = $_COOKIE['auth_memberid'];
		$get_auth_memberid_sess = $_COOKIE['auth_memberid_sess'];
		
		if(!$get_member_serialnum) { error_msgloc($url, $msg); }
		if(!$get_auth_memberid_sess) { error_msgloc($url, $msg); }
		
		$get_member_serialnum .= $ranDsum .= $addSum;
		$real_auth_memberid_sess = md5($get_member_serialnum);
		
		if($get_auth_memberid_sess == $real_auth_memberid_sess) {
			return true;
		}
		else {
			error_msgloc($url,$msg);
			return false;
		}
	}

	## 회원정보 호출
	function info_member($ranDsum,$addSum) {
		global $_COOKIE;
		$get_member_serialnum = $_COOKIE['auth_memberid'];
		$get_auth_memberid_sess = $_COOKIE['auth_memberid_sess'];
		$get_member_serialnum .= $ranDsum .= $addSum;
		$real_auth_memberid_sess = md5($get_member_serialnum);
		if($get_auth_memberid_sess == $real_auth_memberid_sess) {
			$row_member = mysql_fetch_array(mysql_query("SELECT * FROM odtMember WHERE serialnum = '".$_COOKIE['auth_memberid']."' AND secession<>'Y'"));
		
			return $row_member;
		}
	}
	$row_member = info_member($row_setup[ranDsum],$addSum);

	## 회원의 권한 및 권한별 할인율을 정한다.
	$row_member_level_name = "";
	$row_member_sale_ratio = 0;
	$sale_ratio_round = 0;

	if($row_member[Mtype] == "C"){
		## 회원등급을 사용하는 경우
		if($row_setup[pclass] == "Y") {	
			if($row_member[Mlevel] == 9) {
				$row_member_level_name = "관리자";							// 등급이름
				$row_member_sale_ratio = 0;								// 등급별 할인율
				$sale_ratio_round = 0;								// 반올림 자리수 지정
			}
			## 골드회원
			else if($row_member[Mlevel] == 5) {	
				$row_member_level_name = $row_setup[Cclassname2];		// 등급이름
				$row_member_sale_ratio = $row_setup[Cclassration2];		// 등급별 할인율
				$sale_ratio_round = $row_setup[Cclassround2];		// 반올림 자리수 지정
			}
			## 실버회원
			else if($row_member[Mlevel] == 3) {	 
				$row_member_level_name = $row_setup[Cclassname1];
				$row_member_sale_ratio = $row_setup[Cclassration1];
				$sale_ratio_round = $row_setup[Cclassround1];
			}
			## 일반회원
			else {	
				$row_member_level_name = "일반회원";
				$row_member_sale_ratio = 0;
				$sale_ratio_round = 0;
			}
		}
	}
	else if($row_member[Mtype] != "C"){
		## 회원등급을 사용하는 경우
		if($row_setup[mclass] == "Y") {	
			if($row_member[Mlevel] == 9) {
				$row_member_level_name = "관리자";							// 등급이름
				$row_member_sale_ratio = 0;								// 등급별 할인율
				$sale_ratio_round = 0;								// 반올림 자리수 지정
			}
			## 골드회원
			else if($row_member[Mlevel] == 5) {	
				$row_member_level_name = $row_setup[classname2];			// 등급이름
				$row_member_sale_ratio = $row_setup[classration2];		// 등급별 할인율
				$sale_ratio_round = $row_setup[classround2];		// 반올림 자리수 지정
			}
			## 실버회원
			else if($row_member[Mlevel] == 3) {	 
				$row_member_level_name = $row_setup[classname1];
				$row_member_sale_ratio = $row_setup[classration1];
				$sale_ratio_round = $row_setup[classround1];
			}
			## 일반회원
			else {	
				$row_member_level_name = "일반회원";
				$row_member_sale_ratio = 0;
				$sale_ratio_round = 0;
			}
		}
	}		

	## Get 방식 Encode
	function var_encode($get_string_value) {
		return base64_encode($get_string_value)."$!";
	}

	## Get 방식 Decode
	function var_decode($get_string_value) {
		$decode_division = explode("&",base64_decode(str_replace("$!","",$get_string_value)));
		$decode_division_total = count($decode_division);
		
		for($i=0;$i<$decode_division_total;$i++){
			$array_division = explode("=",$decode_division[$i]);
			$_Decode[$array_division[0]] = $array_division[1];
		}

		return $_Decode;
	}

	## 에러메시지(지정한 페이지로 이동)
	function error_msgloc($url,$msg) {
		echo "
			<script>
				alert(\"$msg\");
			</script>
			<meta http-equiv='Refresh' content='0; URL=$url'>";

		exit;
	}

	## 에러메시지(이전 페이지로 이동)
	function error_msgback_user($msg) {
		echo "
			<script>
				alert(\"$msg\");
				history.go(-1);
			</script>";

		exit;
	}

	## 잘못된 접근으로 인한 이동
	function error_locmain($_move_main_) {
		echo "<meta http-equiv='Refresh' content='0; URL=$_move_main_'>";
		exit;
	}

	## 에러메시지(창닫기)
	function error_locclose($msg) {
		echo "
			<script>
				alert(\"$msg\");
				window.close();
			</script>";

		exit;
	}

	## 메일추출 방지
	function encode_email($email) {
		$len = strlen($email);
		
		if(!$len) return 0;
		
		for ($i=0; $i<$len; $i++) $encEmail_Func = $encEmail_Func."&#".ord(substr($email, $i, $i+1)).";";
		
		return $encEmail_Func;
	}

	## 주문번호 생성
	function get_ordernumber($length) {
		$md5Temp = md5(uniqid(rand()));
		$unique = substr($md5Temp, 0, $length);
		$sumTemp = (date("Y")+date("m")+date("d")+date("H")+date("i")+date("s")+19)*997;
		$lengthTemp = strlen($sumTemp);
		$checksum = substr($sumTemp,$lengthTemp-2,2);
		$ordernum = "S".$unique.$checksum;
		
		return $ordernum;
	}

	## SMS발송
	function insert_sms() {
		$row_sms = mysql_fetch_array(mysql_query("SELECT * FROM odtSms WHERE serialnum='1'"));
		
		return $row_sms;
	}
	$row_sms = insert_sms();

	$_minput_use_division_ = explode("/",$row_sms[minput_use]);
	$_oinput_use_division_ = explode("/",$row_sms[oinput_use]);
	$_pinput_use_division_ = explode("/",$row_sms[pinput_use]);
	$_cinput_use_division_ = explode("/",$row_sms[cinput_use]);

	## 쇼핑몰 슈퍼관리자 정보
	function odtAdmin() {
		$row_admin = mysql_fetch_array(mysql_query("SELECT * FROM odtAdmin WHERE superLevel='9' ORDER BY serialnum ASC LIMIT 1"));
		
		return $row_admin;
	}
	$row_admin = odtAdmin();

	## 상품 이미지 사이즈
	$pSmall_size = explode("-",$row_setup[sSize]);
	$table_scale_width = $pSmall_size[0]+5;
	$table_scale_height = $pSmall_size[1]+16;
	$pMedium_size = explode("-",$row_setup[mSize]);
	$pBig_size = explode("-",$row_setup[bSize]);

	## 공동구매 상품 이미지 사이즈
	$gSmall_size = explode("-",$row_setup[sSizeg]);
	$gMedium_size = explode("-",$row_setup[mSizeg]);
	$gBig_size = explode("-",$row_setup[bSizeg]);

	## 품절상품 표시 여부
	if($row_setup[emptyview] == "yes") {
		$stock_where = "WHERE (iwpcheck='all' OR iwpcheck='no')";
		$stock_and = "AND (iwpcheck='all' OR iwpcheck='no')";
	}
	else {
		$stock_where = "WHERE stock > '0' AND (iwpcheck='all' OR iwpcheck='no')";
		$stock_and = "AND stock > '0' AND (iwpcheck='all' OR iwpcheck='no')";
	}

	$ip = $_SERVER['REMOTE_ADDR'];

	## 원화표시 아이콘
	$price_icon_view = "<img src='".$folderpath_upload."/odicons/won.gif' align='absmiddle' border='0'>";

	## 포인트표시 아이콘
	$point_icon_view = "<img src='".$folderpath_upload."/odicons/point.gif' align='absmiddle' border='0'>";

	## 회원권한별 가격
	function get_price($price,$ratio,$round) {
		$priceTemp = round(($price-($price*$ratio/100)),-$round);
	
		return $priceTemp;
	}

	## 회원권한별 포인트
	function get_point($point,$ratio,$round) {
		$pointTemp = round(($point-($point*$ratio/100)),-$round);
		
		return $pointTemp;
	}

	## 할인통합 가격
	function round_price($price,$round) {
		$salePriceTemp = round($price,-$round);
		
		return $salePriceTemp;
	}

	function info_imagefocus() {
		$row_imagefocus = mysql_fetch_array(mysql_query("SELECT * FROM odtImageFocus WHERE serialnum='1'"));
		
		return $row_imagefocus;
	}
	$row_imagefocus = info_imagefocus();

	## 품절상품 표시여부 : $row_setup[emptyview] == "yes"
	
	$row_design = mysql_fetch_array(mysql_query("SELECT * FROM odtDesign WHERE serialnum='1'"));


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


	## 쿠폰 발급 알람 및 만료된 쿠폰 삭제
	if($row_member[id]) {
		$isAlarm = mysql_result(mysql_query("select count(*) from odtCoupon where coID ='".$row_member[id]."' and coUse ='N' and alarm = 'N'"),0);
		mysql_query("update odtCoupon set alarm = 'Y', coUse='E' where coID='".$row_member[id]."' and coUse='N' and coLimit < '".date('Y-m-d')."'");
		mysql_query("update odtCoupon set alarm='Y' where coID='".$row_member[id]."'");
		if($isAlarm) {
			error_msgall($row_member[id]."님 쿠폰이 발급되었습니다.",'/?Pid=u03b05');
		}
	}

	$isAdmin = false;
	if(@array_key_exists($row_member[id],$array_adminid) == true) $isAdmin = true;



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
?>
