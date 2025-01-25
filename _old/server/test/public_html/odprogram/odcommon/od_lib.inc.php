<?
//*****************************************************//
//***********섬네일
//*****************************************************//
//GD를 이용한 이미지 리사이즈 함수 

//$img_file    :    원본파일 
//$simg_name    :리사이즈 파일 : 없을 경우 이미지를 직접출력합니다. 
//*리사이즈와 워터 마크를 사용하지 않을 경우 직접 출력하는건 효율성이 떨어집니다. 
//(직접 출력의 경우 header가 수정되기 때문에 다른 출력이 있으면 안됩니다.) 
//$simg_width    :리사이즈 너비 
//$simg_height    :리사이즈 높이 
//* $simg_width와$simg_height 가 둘다 없을 경우 원본크기 그대로 작업합니다. 
//$simg_type        :리사이즈 파일타입 (1:gif , 2:jpg , 3:png) : 기본 gif 
//$simg_str : 워터마크 문자열  (시작 위치:10px,20px ) 폰트는 gulim.ttc 지만, 없을 경우 ""로 바꿔주세요. 
//gulim.ttc 는 윈도우 font 폴더 안에 있습니다. 
function thumbnail_img($img_file,$simg_name='', $simg_width='', $simg_height='', $simg_type=1,$simg_str=''){ 

if(!is_file($img_file)){ echo "원본 파일이 없습니다.";exit; } 
// GD 버젼체크 
$gd = gd_info(); 
$gdver = substr(preg_replace("/[^0-9]/", "", $gd['GD Version']), 0, 1); 
if(!$gdver) return "GD 버젼체크 실패거나 GD 버젼이 1 미만입니다."; 

list($img_width, $img_height, $img_type, $img_attr) = getimagesize($img_file); //소스이미지파일 크기 
if(!$simg_width && !$simg_height){ 
    $simg_width = $img_width; 
    $simg_height = $img_height; 
}else if(!$simg_width){ 
    $simg_width = $img_width * ($simg_height/$img_height);    //자동 비율생성 : 너비 
}else if(!$simg_height){ 
    $simg_height = $img_height * ($simg_width/$img_width);    //자동 비율생성 : 높이 
} 
/* 
지원 이미지 타입 
1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 
9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM. 
1,2,3 만 지원하도록한다. 
*/ 
if($img_type<1 && $img_type > 3){ 
    return "GIF,JPG,PNG 가 아닙니다."; 
} 

if($img_type==1){ 
$img_im = imagecreatefromgif($img_file);            //원본 이미지: gif 
}else if($img_type==2){ 
$img_im = imagecreatefromjpeg($img_file);            //원본 이미지: jpg 
}else if($img_type==3){ 
$img_im = imagecreatefrompng($img_file);            //원본 이미지: png 
} 

if($gdver >= 2){    //GD 2.XX    : truecolor로 작업한다. 
    $simg_im = imagecreatetruecolor($simg_width, $simg_height); 
    imagecopyresampled($simg_im, $img_im, 0, 0, 0, 0, $simg_width, $simg_height,$img_width, $img_height); //이미지를 리사이즈한다. 
}else{ //GD 1.xxx 
    $simg_im = imagecreate($simg_width, $simg_height); 
    imagecopyresized($simg_im, $img_im, 0, 0, 0, 0, $simg_width, $simg_height,$img_width, $img_height);    //이미지를 리사이즈한다. 
} 

if($simg_str){ 
  $color_000000 = imagecolorallocate($simg_im, 0, 0, 0); //색상 : 검정 
  $color_FFFFFF = imagecolorallocate($simg_im, 0xFF, 0xFF, 0xFF); //색상 : 흰색 
  $simg_str = iconv("EUC-KR","UTF-8",$simg_str); // UTF-8로 한글 변경 
  @imagettftext($simg_im, 10, 0, 12, 22, $color_000000, "/gulim.ttc",$simg_str); //글자 적기 
  @imagettftext($simg_im, 10, 0, 10, 20, $color_FFFFFF, "/gulim.ttc",$simg_str); //글자 적기 
} 

if($simg_name){ 
    if($simg_type==1){ 
        imagegif($simg_im,$simg_name);            //원본 이미지: gif 
    }else if($simg_type==2){ 
        imagejpeg($simg_im,$simg_name,100);            //원본 이미지: jpg 
    }else if($simg_type==3){ 
        imagepng($simg_im,$simg_name);            //원본 이미지: png 
    } 
}else{ 
        Header("Content-Disposition: attachment;; filename=".basename($img_file)); 
        header("Content-Transfer-Encoding: binary"); 
    if($simg_type==1){ 
        header("Content-type: image/gif");  //이미지 타입에 맞도록 해더 구성 
        imagegif($simg_im);            //원본 이미지: gif 
    }else if($simg_type==2){ 
        header("Content-type: image/jpg");  //이미지 타입에 맞도록 해더 구성 
        imagejpeg($simg_im,'',80);            //원본 이미지: jpg 
    }else if($simg_type==3){ 
        header("Content-type: image/png");  //이미지 타입에 맞도록 해더 구성 
        imagepng($simg_im);            //원본 이미지: png 
    } 
} 

// 메모리에 있는 그림 삭제 
imagedestroy($img_im); 
imagedestroy($simg_im); 

return $simg_name; 

} 

//*****************************************************//
//***********이미지 리사이징
//*****************************************************//

function resize_img($file,$dir='',$width,$height) {
	global $_SERVER,$folderpath_upfiles;

	if(!$file || !$width || !$height) {echo "이미지 리사이징 사용에러";exit;}

	//섬네일 파일이 없으면 생성 
	if(!is_file($_SERVER[DOCUMENT_ROOT].$folderpath_upfiles.$dir."/".$width."x".$height."_".$file)) {
		thumbnail_img($_SERVER[DOCUMENT_ROOT].$folderpath_upfiles.$dir."/".$file,$_SERVER[DOCUMENT_ROOT].$folderpath_upfiles.$dir."/".$width."x".$height."_".$file,$width,$height,2,'');
	}

	return $folderpath_upfiles. $dir."/".$width."x".$height."_".$file;
}



	##게시판 네비게이션 리턴
	function print_pagelisting($pg,$total,$scale,$var) {

		if($var) {	//pg변수값을 삭제하기
			$var = "&" . preg_replace("/\&pg\=[0-9]{1,2}|pg\=[0-9]{1,2}\&|pg\=[0-9]{1,2}/","",$var);	//pg 가 마지막에 뭍을경우를 위해 한번더
		}


		$scale;//페이지당 출력 레코드수 
		$page_scale = 10; // 화면당 출력할 페이지 수 
		if(!$pg) $pg = 0;//시작 페이지 번호가 없을경우 0 
		
		$total_page = ceil($total/$scale);//총 페이지수 
		$page = floor($total_page/$page_scale);//단위블럭페이지수 
		$n_page = floor($pg/$page_scale);//현재 단위블럭 페이지번호 

		/* 이전페이지 처리 -----------------------------------------------------------------------------*/
		if($n_page > 0){ 
		//이전 링크 출력 조건 현재단위블럭 페이지 번호가 0보다 클경우 
				$p_start = ($n_page-1)*$page_scale; 
		//현재 단위블럭 페이지 -1 * 단위블럭 페이지 출력수(page_scale) 
				$link = "<a href='".$_SERVER[PHP_SELF]."?pg=${p_start}".$var."'>"; 
				$link .= "<img src='/images/navi/navi_prev.gif' alt='이전' width='11' height='13' border=0 />"; 
				$link .= "</a>"; 
		} else {

				$link = "<img src='/images/navi/navi_prev.gif' alt='이전' width='11' height='13' border=0  />"; 

		}
				$prev_pg = $link; 
		/* 이전페이지 처리 끝 --------------------------------------------------------------------------*/


		/* 페이징 번호 처리 ----------------------------------------------------------------------------*/
		$is = $n_page*$page_scale;//단위블럭 페이지 시작번호 구하기 현재 페이지 번호를 이용하여 현재 단위블럭 페이지 번호를 구하고 그 값을 이용하여 단위블럭 페이지 출력수를 곱한 값 
		for($i=$is; $i < $is+$page_scale; $i++){ 
		//i는 현재 단위블럭 페이지 번호*단위블럭 페이지 출력수 부터 시작하고 i는 단위블럭 페이지 출력수를 더한 값만큼만 반복하도록 지정 
				if($i < $total_page){//i가 총 페이지수 보다 작을 동안만 출력하기 위한조건 
					if($i == $pg) {
						$link = "<span class='BS_abslist'><b>"; 
						$link .= $i+1;//pg값이 i로 지정됨으로 화면상 출력기준을 1부터 시작하는 10진수로 맞추기 위해 +1을 연산 
						$link .= "</b></span>"; 
					} else {
						$link = "<a href='".$_SERVER[PHP_SELF]."?pg=${i}".$var."'><span class='BS_abslist'>"; 
						$link .= $i+1;//pg값이 i로 지정됨으로 화면상 출력기준을 1부터 시작하는 10진수로 맞추기 위해 +1을 연산 
						$link .= "</span></a>"; 
					}
						if($i != $is) $print .= " | ";
						$print .= $link; 
				} 
		} 
		/* 페이징 번호 처리 끝 -------------------------------------------------------------------------*/


		/* 다음페이지 처리 ------------------------------------------------------------------------------*/
		if($n_page < $page){//현재 단위블럭 페이지번호 보다 총 단위블럭 페이지 수가 작을 경우에만 다음 링크 출력 
				$link = "<a href='".$_SERVER[PHP_SELF]."?pg=${i}".$var."'>";//i는 상단 for문에서 이미 마지막 페이지 pg번호보다 +1한 값을 가지고 있기 때문에 i를 그냥 출력함 
				$link .= "<img src='/images/navi/navi_next.gif' alt='다음' width='11' height='13' border=0 />"; 
				$link .= "</a>"; 
		} else {
				$link = "<img src='/images/navi/navi_next.gif' alt='다음' width='11' height='13' border=0 />"; 
		}
		$next_pg = $link; 
		/* 다음페이지 처리 끝 -----------------------------------------------------------------------------*/


		/* 맨 처음 / 맨 마지막 페이지 처리 ----------------------------------------------------------------*/
		$first_pg = "<a href='".$_SERVER[PHP_SELF]."?pg=0".$var."'>"; 
		$first_pg .= "<img src='/images/navi/navi_first.gif' alt='맨처음' width='13' height='13' border=0 />"; 
		$first_pg .= "</a>";
		
		$last_pg = "<a href='".$_SERVER[PHP_SELF]."?pg=".($total_page-1).$var."'>"; 
		$last_pg .= "<img src='/images/navi/navi_last.gif' alt='맨마지막' width='13' height='13' border=0 />"; 
		$last_pg .= "</a>";
		/* 맨 처음 / 맨 마지막 페이지 처리 끝 --------------------------------------------------------------*/
		

		/* 테이블 처리 -------------------------------------------------------------------------------------*/
		$print = "<table border=0 cellpadding=0 cellspacing=0 align=center>
								<tr>
									<td>$first_pg</td><td style=padding-left:5;padding-right:5>$prev_pg</td><td>$print</td><td style=padding-left:5;padding-right:5>$next_pg</td><td>$last_pg</td>
								</tr>
							</table>";
		/* 테이블 처리 끝 ----------------------------------------------------------------------------------*/

		return $print;
	}

	function file_delete($file) {
		@unlink($file);
		return '';
	}
	function file_upload($file,$dir='',$limit=''){
		global $_SERVER;
		
		$uploadFolder=$_SERVER[DOCUMENT_ROOT].$dir;
		//폴더가 없으면 생성
		if(!is_dir($uploadFolder)) { 
			mkdir($uploadFolder);
			chmod($uploadFolder,0707);
		}


		/* 업로드 차단 -----------------------------------------*/
		$denyArr= array("PHP","PHP3","HTML","HTM","ASP","C","PL","JS","JSP","INI","INC","EXE","BAT","CHM");			//업로드 차단 확장자.
		$fileTmp = explode(".",$file[name]);
		for($i=0;$i < count($denyArr);$i++) {
			if(strstr(strtoupper(end($fileTmp)),$denyArr[$i])) {
				echo "<script>alert('해당 확장자는 업로드할수 없습니다. 확장자를 바꿔주세요.');history.back();</script>";
				exit;
			}
		}
		/* 업로드 차단 -----------------------------------------*/
		// 용량차단
		if($limit) {
			if($file[size] > ($limit*1000000)) {

				error_msgall('용량초과입니다. 허용용량 : '.$limit."MB");
				exit;
			}
		}

		$saveFileName=$file[name];
		$saveFileNameTmp=explode(".",$saveFileName);
		$saveFileNameHead=substr(md5(rand()),0,7); // 한글파일을 영문화.
		$saveFileNameTest=$saveFileNameHead.".".end($saveFileNameTmp);
		for($i=0;;$i++){ // 파일중복검사,  
			$saveFileNameTest=$saveFileNameHead.$i.".".end($saveFileNameTmp);
			if(!is_file($uploadFolder."/".$saveFileNameTest)) break;
		}
		$fileCopy=@copy($file[tmp_name],$uploadFolder."/".$saveFileNameTest);
		@unlink($file[tmp_name]);
		if(!$fileCopy){
			error_msgall('업로드중 에러가 발생하였습니다');
			exit;
		}else{
			return $dir."/".$saveFileNameTest;
		}
	}


	function file_upload_resize($file,$dir='',$width,$height){
		global $_SERVER;
		
		$uploadFolder=$_SERVER[DOCUMENT_ROOT].$dir;
		//폴더가 없으면 생성
		if(!is_dir($uploadFolder)) { 
			mkdir($uploadFolder);
			chmod($uploadFolder,0707);
		}


		/* 업로드 차단 -----------------------------------------*/
		$denyArr= array("PHP","PHP3","HTML","HTM","ASP","C","PL","JS","JSP","INI","INC","EXE","BAT","CHM");			//업로드 차단 확장자.
		$fileTmp = explode(".",$file[name]);
		for($i=0;$i < count($denyArr);$i++) {
			if(strstr(strtoupper(end($fileTmp)),$denyArr[$i])) {
				echo "<script>alert('해당 확장자는 업로드할수 없습니다. 확장자를 바꿔주세요.');history.back();</script>";
				exit;
			}
		}
		/* 업로드 차단 -----------------------------------------*/

		#리사이징
		thumbnail_img($file[tmp_name],$file[tmp_name],$width,$height,2,'');

		$saveFileName=$file[name];
		$saveFileNameTmp=explode(".",$saveFileName);
		$saveFileNameHead=substr(md5(rand()),0,7); // 한글파일을 영문화.
		$saveFileNameTest=$saveFileNameHead.".".end($saveFileNameTmp);
		for($i=0;;$i++){ // 파일중복검사,  
			$saveFileNameTest=$saveFileNameHead.$i.".".end($saveFileNameTmp);
			if(!is_file($uploadFolder."/".$saveFileNameTest)) break;
		}
		$fileCopy=@copy($file[tmp_name],$uploadFolder."/".$saveFileNameTest);
		@unlink($file[tmp_name]);
		if(!$fileCopy){
			error_msgall('업로드중 에러가 발생하였습니다');
			exit;
		}else{
			return $dir."/".$saveFileNameTest;
		}
	}

	
	function chk_nowsale($code) {
		$que = "select * from odtProduct where code = '".$code."'";
		$res = mysql_query($que);
		$row = mysql_fetch_array($res);

		if($row[cateCode] == "01") {
			$que2 = "select code from odtProduct where cateCode = '01' and sale_date <= '".date('Y-m-d')."' order by sale_date desc limit 1";
			$res2 = mysql_query($que2);
			$row2 = mysql_result($res2,0);

			if($row2 != $code) return false;
		}

		if($row[cateCode] == "02") {
			$que2 = "select code from odtProduct where cateCode = '02' and sale_date <= '".date('Y-m-d')."' order by sale_date desc limit 1";
			$res2 = mysql_query($que2);
			$row2 = mysql_result($res2,0);

			if($row2 != $code) return false;
		}

		if($row[cateCode] == "03") {
			$que2 = "select * from odtProduct where cateCode = '03' and live_start_time > '".$row[live_start_time]."' order by live_start_time asc limit 1";
			$res2 = mysql_query($que2);
			$row2 = mysql_fetch_array($res2);

			$nowDate = date('Y-m-d H:i:s');
			
			if($row[live_start_time] > $nowDate || $row2[live_start_time] < $nowDate) return false;
		}

		if($row[cateCode] == "04") {
			$que2 = "select code from odtProduct where cateCode = '04' and sale_date <= '".date('Y-m-d')."' order by sale_date desc limit 1";
			$res2 = mysql_query($que2);
			$row2 = mysql_result($res2,0);
			
			if($row2 != $code) return false;
		}

		if($row[cateCode] == "05") {
			$que2 = "select code from odtProduct where cateCode = '05' and sale_date <= '".date('Y-m-d')."' order by sale_date desc limit 1";
			$res2 = mysql_query($que2);
			$row2 = mysql_result($res2,0);

			if($row2 != $code) return false;
		}

		return true;
	}


	function icon_level($level,$isImg='') {
		if(!$level) $level = 1;
		if($isImg) return false;
		for($i=0;$i<$level;$i++) {
			$print .= "<img src='/img/report_img_01".($i%2==0 ? "4" : "5").".jpg'>";
		}
		return $print;
	}

	function icon_member($id,$isImg='') {
		if($isImg) return false;
		$level = @mysql_result(mysql_query("select actionLevel from odtMember where id ='".$id."'"),0);

		if(!$level) $level = 1;		// 가상 ID면 레벨1

		for($i=0;$i<$level;$i++) {
			$print .= "<img src='/img/report_img_01".($i%2==0 ? "4" : "5").".jpg'>";
		}
		return $print;
	}

	function get_guestid($name,$email) {
		# 비회원용 아이디 생성
		return "G".substr(md5($email),5,7).substr(md5($name),0,2);
	}


	#오늘 판매되어야 할 상품코드값을 리턴한다. --> nowSaleItem
	function info_nowsale($cateCode) {
		global $row_setup;

		$today_date = date("Y-m-d");
		
		$que = "select code from odtProduct where code = parent_code and cateCode = '".$cateCode."' and sale_date <= '".$today_date."' and sale_enddate>='".$today_date."' order by sale_date desc limit 1";
		$res = mysql_query($que);
		if( mysql_num_rows($res) > 0 ) {
			return @mysql_result($res,0,0);
		}
		else {
			// 해당 상품이 없을 경우 최종 판매시작일의 상품 하나를 가져옴
			$sque = "select code from odtProduct where code = parent_code and cateCode = '".$cateCode."' and sale_date <= '".$today_date."' order by sale_date desc limit 1";
			$sres = mysql_query($sque);
			return @mysql_result($sres,0,0);
		}
	}


	// 추가 수정
	#오늘 판매되어야 할 상품 정보값을 리턴한다. --> nowSaleItemAllData
	function info_nowsale_alldata($cateCode) {
		global $row_setup;

		$today_date = date("Y-m-d");

		$que = "select * from odtProduct where code = parent_code and cateCode = '".$cateCode."' and sale_date <= '".$today_date."' and sale_enddate>='".$today_date."' order by sale_date desc limit 1";
		$res = mysql_query($que);
		if( mysql_num_rows($res) > 0 ) {
			return @mysql_fetch_assoc($res);
		}
		else {
			// 해당 상품이 없을 경우 최종 판매시작일의 상품 하나를 가져옴
			$sque = "select code from odtProduct where code = parent_code and cateCode = '".$cateCode."'  order by sale_date desc limit 1";
			$sres = mysql_query($sque);
			return @mysql_fetch_assoc($sres);
		}
	}


	// 추가 수정 --> nowSaleTime
	function info_nowsale_time($app_code) { 
		global $row_setup;

		$que = "select sale_enddate from odtProduct where code='${app_code}' ";
		$res = mysql_query($que);
		if( mysql_num_rows($res) > 0 ){
			$sale_enddate = mysql_result($res,0,0);
		}
		else {
			$sale_enddate = date("Y-m-d" , strtotime("+1 day"));
		}
		return strtotime("${sale_enddate}") + $row_setup[changeTime]*3600;
	}





	// 추가 수정
	function date_nextsale($cateCode) {
		global $row_setup;
		$sDate = $row_setup[mallstart];


		$today = date('Y-m-d');
		$yester= date('Y-m-d',strtotime("-1 day"));
		$nextday= date('Y-m-d',strtotime("+1 day"));

		$curr_hour = date('H');
		$wTmp = date('w');

		if( $row_setup[changeTime] >= 18 ) {
			$date2 = $curr_hour >= $row_setup[changeTime] ? $nextday : $today;
		}
		else {
			$date2 = $curr_hour < $row_setup[changeTime] ? $yester : $today;
		}

		if( $row_setup[changeTime] >= 18 && $wTmp == "4"  ) {
			return $row_setup[changeTime] > $curr_hour ? date('Y-m-d',strtotime("+0 day")) : date('Y-m-d',strtotime("next sunday")) ;
		}
		elseif(in_array( $wTmp , array("5" , "6") ) ) {
			if( $row_setup[changeTime] >= 18 ) {
				return date('Y-m-d',strtotime("next sunday"));
			}
			else {
				return date('Y-m-d',strtotime("next monday"));
			}
		}
		else {
			if( $row_setup[changeTime] >= 18 ) {
				return $row_setup[changeTime] > $curr_hour ? date('Y-m-d',strtotime("+0 day")) : date('Y-m-d',strtotime("+1 day")) ;
			}
			else {
				return date('Y-m-d',strtotime("+1 day"));
			}
		}

	}



	function chk_live() {
		$que = "select * from odtProduct where cateCode = '03' and live_start_time < '".date('Y-m-d H:i:s')."' order by live_start_time desc limit 1";
		$res = mysql_query($que);
		$row = mysql_fetch_array($res);

		# 라이브인지 재방인지 체크
		$endTime = strtotime($row[live_start_time]) + $row[live_time]*60;
		$isLive = $endTime > time() ? true : false;

		return $isLive;
	}

	function apply_talkid($id,$isImg) {
		global $array_adminid,$row_member;
		$ment = '';

		if($isImg == "md") {
			$ttName = "<img src='/images/".$array_adminid[$id]."' align=middle>";
		} else if($isImg == "seller") {
			$ttName = "<img src='/img/talk_ico_06.jpg' align=middle>";
		} else {
			if(@array_key_exists($row_member[id],$array_adminid) != true) {
				$ttName = "<b>".substr($id,0,strlen($id)-3)."***</b>";
			} else {
				$que = "select id,name,address,signdate,point,action,sex,birthy,isRobot from odtMember where id='".$id."'";
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
						$buyLog .= "<br>(".$pLogTmp[1]."개)".cut_str_short($proName,20);
					}
				}

				if(!mysql_num_rows($res)) {
					$ment = "로봇회원";
					$weight = "";
				} else {
					$row = mysql_fetch_array($res);
					$ment .= "아&nbsp;이&nbsp;디 : ".$row[id]."<br>";
					$ment .= "이&nbsp;&nbsp;&nbsp;&nbsp;름 : ".$row[name]."(".(date('Y')-$row[birthy]+1)."세-".($row[sex] == "M" ? "남" : "여").")<br>";
					$ment .= "주&nbsp;&nbsp;&nbsp;&nbsp;소 : ".$row[address]."<br>";
					$ment .= "포&nbsp;인&nbsp;트 : ".number_format($row[point])." 포인트<br>";
					$ment .= "참여점수 : ".number_format($row[action])." 점<br>";
					$ment .= "가&nbsp;입&nbsp;일 : ".date('Y년 m월 d일',$row[signdate])."<br>";
					$ment .= "구매내역".$buyLog;
					$weight = "bold";
					if($row[isRobot] == "Y") $weight = "";
				}
				$randID = rand(1,99999);
				$ttName = "<div id=".$randID." style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none'><div style='position:absolute;z-index:3;top:30;left:0;'><table border='0' cellpadding='2' cellspacing='3' bgcolor='#7B7B7B'>
										<tr>
											<td nowrap bgcolor='#FFFFFF' style='padding:7;font-family:굴림체'>".$ment."</td>
										</tr>
									</table></div></div>					
				<span style='font-weight:".$weight.";cursor:pointer' onclick=\"document.getElementById('".$randID."').style.display='inline'\" onmouseout=\"document.getElementById('".$randID."').style.display='none'\">".$id."</span>";
			}
		}

		return $ttName;
	}

	function apply_talkname($id,$name) {
				global $array_adminid,$row_member,$admin;
				$randID = rand(1,99999);

				if($admin[superLevel] != 9) {
					if(@array_key_exists($row_member[id],$array_adminid) != true) {
						return $name;
					}
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

				$ment = "<span onclick=\"document.getElementById('".$randID."').style.display='none'\" style='cursor:hand'><b>[닫기]</b></span><br>";

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
					$cRes = mysql_query("select Time,Connect_Route from odtCounter where Connect_IP = '".$orderIP."' and Connect_Route != '' and !(Connect_Route like '%".str_replace('www.','',$_SERVER[HTTP_HOST])."%')  order by Time desc limit 5");
					if(!mysql_num_rows($cRes)) $ment .= "<br>즐겨찾기나 주소를 바로 입력하여 접속.";
					while($cRow = mysql_fetch_array($cRes)) {
						$ment .= "<br><a href='".$cRow[Connect_Route]."' target='_blank'>[".date('m.d H:i',$cRow[Time])."] ".$cRow[Connect_Route]."</a>";
					}
				}

				$ttName = "<div id=".$randID." style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none'><div style='position:absolute;z-index:3;top:20;left:0;'><table border='0' cellpadding='2' cellspacing='3' bgcolor='#7B7B7B'>
										<tr>
											<td nowrap bgcolor='#FFFFFF' style='padding:7;font-family:굴림체'>".$ment."</td>
										</tr>
									</table></div></div><span style='font-weight:".$weight.";cursor:pointer' onclick=\"document.getElementById('".$randID."').style.display='inline'\">".$name."</span>";


		return $ttName;
	}



	function link_delivery($com,$no) {
		if(!trim($no)) return;
		switch($com) {
			case "우체국택배" :
				$url = "http://service.epost.go.kr/trace.RetrieveRegiPrclDeliv.postal?sid1=".$no;
				break;
			case "현대택배" :
				$url = "http://www.hlc.co.kr/hydex/jsp/tracking/trackingViewCus.jsp?InvNo=".$no;
				break;
			case "한진택배" :
				$url = "http://www.hanjinexpress.hanjin.net/customer/plsql/hddcw07.result?wbl_num=".$no;
				break;
			case "KGB택배" :
				$url = "http://www.kgbls.co.kr/sub5/trace.asp?f_slipno=".$no;
				break;
			case "대한통운" :
				$url = "http://www.doortodoor.co.kr/servlets/cmnChnnel?tc=dtd.cmn.command.c03condiCrg01Cmd&invc_no=".$no;
				break;
			case "로젠택배" :
				$url = "http://d2d.ilogen.com/d2d/delivery/invoice_tracesearch_quick.jsp?slipno=".$no;
				break;
			case "삼성택배" :
				$url = "http://www.cjgls.co.kr/kor/service/service02.asp";
				break;
			case "옐로우택배" :
				$url = "http://www.yellowcap.co.kr/custom/inquiry_result.asp?INVOICE_NO=".$no;
				break;
			case "CJ택배" :
				$url = "http://www.cjgls.co.kr/kor/service/service02.asp";
				break;
			case "하나로택배":
				$url = "http://www.hanarologis.com/branch/chase/listbody.html?a_gb=center&a_cd=4&a_item=0&fr_slipno=".$no;
				break;
			case "동부익스프레스":
				$url = "http://www.dongbuexpress.co.kr/Html/Delivery/DeliveryCheckView.jsp?item_no=".$no;
				break;
		}
		$resPrint = "<br><a href='".$url."' target='_blank'><img src='/img/modify_img_43.jpg' border=0></a>";
		return $resPrint;
	}


	function conn_hID($hID) {
		$id = @mysql_result(mysql_query("select id from odtMember where hID='".$hID."'"),0);
		if(!$id) $id = "error_".$hID;
		
		return $id;
	}



?>