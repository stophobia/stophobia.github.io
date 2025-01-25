<?
    include "../odcommon/od_config.inc.php";
    include "../odcommon/od_function.inc.php";
    include "../odcommon/od_lib.inc.php";

/*
    ## 아이디에 한글이 포함되어 있는지 체크
    $row_memberber_ID = strtolower($id);		## 아이디(ID) 소문자로 변환
    if(!eregi("^[a-z].[_a-z0-9]{2,10}$",$row_memberber_ID)) {
        error_msgback_user('아이디(ID)에 한글 또는 공백이 있습니다.   \\n\\n첫자는 영문, 나머지는 영문/숫자 조합문자열로 입력해 주세요.   ');
    }

    ## 이름에 공백문자열이 있는지 체크
    if(!ereg("([^[:space:]]+)", $name) or ereg("([[:space:]]+)",$name)) {
        error_msgback_user('입력하신 이름에 공백이 있습니다.   \\n\\n공백이 없이 다시 입력해 주세요.   ');
    }

    ## 이름 영문 및 숫자가 포함되어 있는지 체크
    for($i=0; $i<strlen($name);$i++) {
        if(ord($name[$i]) <= 0x80) {
            error_msgback_user('입력하신 이름에 영문이 있습니다.   \\n\\n영문없이 한글로만 다시 입력해 주세요.   ');
        }
    }
*/

    ## 아이디 중복 체크
    $rows = mysql_result(mysql_query("SELECT count(id) FROM odtMember WHERE id='$id' AND secession<>'Y'"),0);
    if($rows) {
        error_msgback_user('입력하신 아이디는 이미 사용중입니다.   \\n\\n다시 입력해 주세요.   ');
    }

    ## 닉네임 중복 체크
    $rows = mysql_result(mysql_query("SELECT count(chatNickName) FROM odtMember WHERE chatNickName='$nickName' AND secession<>'Y'"),0);
    if($rows) {
        error_msgback_user('입력하신 닉네임은 이미 사용중입니다.   \\n\\n다시 입력해 주세요.   ');
    }

/* 실명인증서비스로 대신함
	## 주민번호 체크 #################################################################
	if((strlen($resinum1) == 6) && (strlen($resinum2) == 7)) {
		$ser = $resinum1. "0$resinum2";
		
		for($i=0; $i <14; $i++) $a[$i] = intval($ser[$i]);
		
		$j = $a[0]*2+$a[1]*3+$a[2]*4+$a[3]*5+$a[4]*6+$a[5]*7+$a[7]*8+$a[8]*9+$a[9]*2+$a[10]*3+$a[11]*4+$a[12]*5;
		$j = $j % 11;
		$k = 11 - $j;
		
		if($k > 9) $k = $k % 10;
		
		$j = $a[13];
		
		if($j == $k) {
			if($a[7] == 1) {
				$sex =  "M";
				$Y = 1900;
			}
			else if($a[7] == 2) {
				$sex =  "F";
				$Y = 1900;
			}
			else if($a[7] == 3) {
				$sex =  "M";
				$Y = 2000;             
			}
			else if($a[7] == 4) {
				$sex =  "F";
				$Y = 2000;
			}
			else {
				error_msgback_user('성별을 확인할 수 없습니다.   \\n\\n다시 입력해 주세요.   ');
			}
			
			$Y = $Y + $a[0]*10 + $a[1];
			$M = $a[2]*10 + $a[3];
			
			if(($M == 0) || ($M >12)) {
				error_msgall('주민번호 앞번호 중 (월)을 잘못 입력하셨습니다.   \\n\\n다시 입력해 주세요.   ');
				exit;
			}

			$D = $a[4]*10 + $a[5];
			
			if(($D == 0) || ($D >31)) {
				error_msgall('주민번호 앞번호 중 (일)을 잘못 입력하셨습니다.   \\n\\n다시 입력해 주세요.   ');
				exit;
			}
			
			$birthday = mktime(0,0,0, "$M", "$D", "$Y");
			
			if(!$birthy) $birthy = date("Y",$birthday);
			if(!$birthm) $birthm = date("m",$birthday);
			if(!$birthd) $birthd = date("d",$birthday);
			
			$age = date('Y') - $birthy + 1;

			$resinum = md5($resinum1.$resinum2);
			
			if($a[7] == 1) $sex =  "M";
			else $sex =  "F";
		}
		else {
			error_msgall('주민번호를 잘못 입력하셨습니다.   \\n\\n다시 입력해 주세요.   ');
			exit;
		}
	}
	else {
		error_msgall('주민번호를 잘못 입력하셨습니다.   \\n\\n다시 입력해 주세요.   ');
		exit;
	}
*/
	## 주민번호 중복 체크
    if ( $resinum == "" ) $resinum = md5($resinum1.$resinum2);
    if ( $authtype == "I" ) {  //IPIN인증모드
        //echo "<Br>아이핀중복체크";
        $rows = mysql_result(mysql_query("SELECT COUNT(id) FROM odtMember where kcb_dupinfo='$kcb_dupinfo'"),0);
        if($rows) error_msgback_user('입력하신 IPIN 데이터는 이미 사용중입니다.   \\n\\n다시 입력해 주세요.   ');
    } else {
        //echo "<Br>주민등록번호중복체크";
        $rows = mysql_result(mysql_query("SELECT COUNT(id) FROM odtMember where resinum='$resinum' AND secession<>'Y'"),0);
        if($rows) error_msgback_user('입력하신 주민번호는 이미 사용중입니다.   \\n\\n다시 입력해 주세요.   ');
    }

    ## 회원신규 가입시 지급될 초기 포인트 점수
    $point = $row_setup[providepoint];

    ## 회원가입축하 쿠폰제공
    if($row_setup[mcouponnumber] AND $row_setup[mcouponnumber] > 0) {
        $offerdate = time();        
        $cprow = mysql_fetch_array(mysql_query("SELECT * FROM odtCoupon WHERE number='$row_setup[mcouponnumber]' AND couponuse='yes'"));        
        $couponname = addslashes($cprow[name]);
        
        ## 가입과 동시에 포인트로 합산시킨다.
        if($cprow[application] == "direct") {
            $point = $point + $cprow[couponprice];
            $status = "yes";
            $statusdate = time();
        }

        ## conversion 회원이 포인트로 전환하도록 한다.
        else {
            $point = $point;
            $status = "no";
            $statusdate = 0;
        }

        ## 쿠폰 유효기간이 있는경우 가입일로부터의 유효기간을 설정
        if($cprow[duedate] == "yes") $duedate = $cprow[term];
        else $duedate = 0;

        $result1 = mysql_query("INSERT INTO odtCouponHistory (couponnumber,couponstatus,name,id,price,offerdate,duedate,status,statusdate,ip) VALUES ('$row_setup[mcouponnumber]','yes','$couponname','$id','$cprow[couponprice]','$offerdate','$duedate','$status','$statusdate','$ip')");

        if($result1) {
            ## 해당쿠폰 발행수를 업데이트 한다.
            mysql_query("UPDATE odtCoupon SET offernumber=offernumber+1 WHERE number='$row_setup[mcouponnumber]' AND couponuse='yes'");	 
        }
    }

    ## 추천인 아이디가 없는 경우
    if(!$recomid) {
        $recomid = "";
    }
    else {
        ## 추천인 아이디가 있는 경우
        $RecomResult = mysql_query("SELECT id,point FROM odtMember WHERE id='$recomid' AND secession<>'Y'");
        
        if(!$RecomRows = mysql_num_rows($RecomResult)) {
            error_msgback_user("추천인 ID[$recomid]는 유효하지 않은 ID 입니다.   \\n\\n다시 확인 후 입력해 주시기 바랍니다.   ");
        }
        else {
            $Rrow = mysql_fetch_array($RecomResult);
            $RePoint = $Rrow[point] + $row_setup[recompoint];
            if($Rrow[id] == $id) {
                error_msgback_user('본인이 본인을 추천할 수 없습니다.   ');
            }
            else {
                ## 회원 정보를 업데이트 한다. ###############################################################
                mysql_query("UPDATE odtMember SET point='$RePoint' WHERE id='$Rrow[id]'");
            }
        }
    }

    if(!$calendar) $calendar = "S";
    if(!$marriage) $marriage = "N";

    $Mlevel = 1;
    $todayTemp = time();
    $visitnum = 1;

    $hID = strtoupper(substr(md5(uniqid(rand())),0,15));

    $id = trim($id); //Id의 공백제거 2010-12-07 (tindevil)
 
	## 데이타 입력
    $Query = "INSERT INTO odtMember (id,hID,passwd,repasswd,name,resinum,email,zip1,zip2,address,address1,tel1,tel2,tel3,htel1,htel2,htel3,job,mailling,sms,recomid,age,sex,calendar,birthy,birthm,birthd,interest,marriage,weddingy,weddingm,weddingd,finalsch,oname,ozip1,ozip2,oaddress,oaddress1,otel1,otel2,otel3,ofax1,ofax2,ofax3,odept,opost,mincome,motive,course,point,Mlevel,signdate,modifydate,recentdate,visitnum,ip,chatNickName,kcb_encPsnlInfo,kcb_virtualno,kcb_realname,kcb_age,kcb_sex,kcb_birthdate,kcb_dupinfo) VALUES ('$id','$hID',password('$passwd'),'$repasswd','$name','$resinum','$email','$zip1','$zip2','$address','$address1','$tel1','$tel2','$tel3','$htel1','$htel2','$htel3','$job','$mailling','$sms','$recomid','$age','$sex','$calendar','$birthy','$birthm','$birthd','$interest','$marriage','$weddingy','$weddingm','$weddingd','$finalsch','$oname','$ozip1','$ozip2','$oaddress','$oaddress1','$otel1','$otel2','$otel3','$ofax1','$ofax2','$ofax3','$odept','$opost','$mincome','$motive','$course','$point','$Mlevel','$todayTemp','$todayTemp','$todayTemp','$visitnum','$ip','$nickName','$kcb_encPsnlInfo','$kcb_virtualno','$kcb_realname','$kcb_age','$kcb_sex','$kcb_birthdate','$kcb_dupinfo')";
	$result = mysql_query($Query);

    echo "<Br>Query->".$Query;

	if($result) {

        ## 메일발송
        include "od_memberinput_mail.inc.php";
        
        ## 가입고객에게 문자발송
        include "od_sms_send_customer.inc.php";
        
        // 회원 100 포인트 적립 ///////////////////////////////////////////////
        //mysql_query("update odtMember set point = point + 100 where id ='".$id."'");

        ## 참여점수 입력
        $queP = "insert into odtActionLog set
                            acID = '".$id."',
                            acTitle = '회원가입',
                            acPoint = '100',
                            ip			=	'".$_SERVER[REMOTE_ADDR]."',
                            acRegidate = now()";
        @mysql_query($queP);

        #################################
        ## 회원모집 이벤트 3월 이후 삭제
        #################################
        function eventJoinRankIns($ip,$id) {
            $parentID = @mysql_result(mysql_query("select parentID from odtEventJoinLog where ip='".$ip."' order by regidate desc limit 1"),0);
            if($parentID) mysql_query("insert into odtEventJoinRank set parentID = '".$parentID."', childID ='".$id."', childIP ='".$ip."', regidate = now()");
        }

        if(time() < strtotime("2009-03-01 00:00:00")) {
            eventJoinRankIns($_SERVER[REMOTE_ADDR],$id);
        }

        #################################
        ## 회원모집 이벤트 끝
        #################################

        $_MemberInfo = mysql_fetch_array(mysql_query("SELECT serialnum FROM odtMember WHERE id='$id'"));
        apply_login($_MemberInfo[0],$row_setup[ranDsum],$addSum);
        error_msgall("[$id]님의 $row_company[name] 회원가입을 축하드립니다.   ");
        echo "<script>parent.location.href='/odprogram/odlogon/od_login.php';</script>";
    }
    else {
        error_msgloc("$path_home/odmembers/od_join.php","회원가입이 정상적으로 진행되지 않았습니다.   \\n\\n다시한번 시도해 주시기 바랍니다.   ");
    }
?>