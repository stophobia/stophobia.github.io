<?
	# 카드결제에 필요한 셋팅
    /**************************
     * 1. 라이브러리 인클루드 *
     **************************/
    require($_SERVER[DOCUMENT_ROOT]."/../INIpayG/libs/INILib.php");

		/***************************************
     * 2. INIpay50 클래스의 인스턴스 생성  *
     ***************************************/
    $inipay = new INIpay50;

    /**************************
     * 3. 암호화 대상/값 설정 *
     **************************/
    $inipay->SetField("inipayhome", $_SERVER[DOCUMENT_ROOT]."/../INIpayG");       // 이니페이 홈디렉터리(상점수정 필요)
    $inipay->SetField("type", "chkfake");      // 고정 (절대 수정 불가)
    $inipay->SetField("debug", "true");        // 로그모드("true"로 설정하면 상세로그가 생성됨.)
    $inipay->SetField("enctype","asym"); 			//asym:비대칭, symm:대칭(현재 asym으로 고정)
    $inipay->SetField("admin", "1111"); 				// 키패스워드(키발급시 생성, 상점관리자 패스워드와 상관없음)
    $inipay->SetField("checkopt", "false"); 		//base64함:false, base64안함:true(현재 false로 고정)

		//필수항목 : mid, price, nointerest, quotabase
		//추가가능 : INIregno, oid
		//*주의* : 	추가가능한 항목중 암호화 대상항목에 추가한 필드는 반드시 hidden 필드에선 제거하고 
		//          SESSION이나 DB를 이용해 다음페이지(INIsecureresult.php)로 전달/셋팅되어야 합니다.
    $inipay->SetField("mid", $row_setup[P_ID]);            // 상점아이디
    $inipay->SetField("price", $tPrice);                // 가격
    $inipay->SetField("nointerest", "no");             //무이자여부(no:일반, yes:무이자)
    $inipay->SetField("quotabase", iconv("utf-8","euckr","선택:일시불:2개월:3개월:6개월"));//할부기간

    /********************************
     * 4. 암호화 대상/값을 암호화함 *
     ********************************/
    $inipay->startAction();

    /*********************
     * 5. 암호화 결과  *
     *********************/
 		if( $inipay->GetResult("ResultCode") != "00" ) 
		{
			echo $inipay->GetResult("ResultMsg");
			exit(0);
		}

    /*********************
     * 6. 세션정보 저장  *
     *********************/
		$HTTP_SESSION_VARS['INI_MID'] = $row_setup[P_ID];	//상점ID
		$HTTP_SESSION_VARS['INI_ADMIN'] = "1111";			// 키패스워드(키발급시 생성, 상점관리자 패스워드와 상관없음)
		$HTTP_SESSION_VARS['INI_PRICE'] = $tPrice;     //가격 
		$HTTP_SESSION_VARS['INI_RN'] = $inipay->GetResult("rn"); //고정 (절대 수정 불가)
		$HTTP_SESSION_VARS['INI_ENCTYPE'] = $inipay->GetResult("enctype"); //고정 (절대 수정 불가)
?>