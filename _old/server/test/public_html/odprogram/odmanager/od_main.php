<?PHP

	## 환경변수파일 및 DB 접속 파일 include ############################
	include "../odcommon/od_config.inc.php";
	include "odcommon/od_function.inc.php";


//echo "->".$_GET[mode]."->".$skbn; exit;

	//공급업체파라미터가아니면 모두 관리자 로그인상태로전환
    if ($_GET[mode] != "sub") $_GET[mode]="main";


    // 관리자 로그인 체크
	if($_GET[mode]=="main" && $row_admin[id]) {
		if($row_admin[superLevel] == 9) echo "<meta http-equiv='Refresh' content='0; URL=od_submain.php'>";
		else echo "<meta http-equiv='Refresh' content='0; URL=./odorders/od_orderslist.php'>";
		exit;
	}

    if ("y" == $skbn)
    {
        SetCookie("auth_pass_log","",0,"/","$app_url");
        SetCookie("auth_pass_log","",0,"/");
        SetCookie("auth_comidmidi","",0,"/","$app_url");
        SetCookie("auth_comid_sess","",0,"/","$app_url");
        SetCookie("auth_comid","",0,"/");
        SetCookie("auth_comid_sess","",0,"/");

        echo "
        <form name='text' method='post' action='/odprogram/odmanager/od_main.php?mode=sub'>
        <input type='hidden' name='PartCode' value='$PartCode'>
        </form>
        <script>
            text.submit();
        </script>";
        exit;

        //echo "<meta http-equiv='Refresh' content='0; URL=/odprogram/odmanager/od_main.php?mode=sub&PartCode=$PartCode'>";
        exit;
    }

	// 입점업체 로그인 체크
	if($_GET[mode]=="sub" && $com[id] && !$PartCode) {
		echo "<meta http-equiv='Refresh' content='0; URL=/odprogram/odmanager/odorders2/od_orderslist.php'>";
		exit;
	}

    $check1 = $_GET[mode]=="main" ? "checked" : "";
    $check2 = $_GET[mode]=="sub" ? "checked" : "";

    //echo $PartCode;exit;
    
    if ($PartCode) {

        $Presult = mysql_query("SELECT serialnum,passwd FROM odtMember WHERE id='$PartCode' and userType='C'");
        $Prows = mysql_num_rows($Presult);
        if(!$Prows) {
                echo "
                    <script>
                        window.alert('로그인실패\\n\\n다시 입력해 주세요.   ');
                        history.go(-1);
                    </script>";
                exit;
        }
        $Pserialnum = mysql_result($Presult,0,0);
        $PkeepTermLogin = $row_setup[keepTerm]*60;
        login_subcompany($Pserialnum,$row_setup[ranDsum],$_MaddSum,$PkeepTermLogin);

        //echo "->".$_COOKIE['auth_comid'];exit;

        echo "<meta http-equiv='Refresh' content='0; URL=/odprogram/odmanager/odorders2/od_orderslist.php'>";
    }


	if(!strcmp($Form,"ManagerLoginAcc")) {
		// 아이디 길이 체크
/*
		if(!ereg("[[:alnum:]+]{4,12}",$id)) {
			echo "
				<script>
					window.alert('ID 입력이 잘못 되었습니다.   \\n\\n다시 입력해 주세요.   ');
					history.go(-1);
				</script>";

			exit;
		}

		// 비밀번호 길이 체크
		if(!ereg("[[:alnum:]+]{4,12}",$passwd)) {
			echo "
				<script>
					window.alert('비밀번호 입력이 잘못 되었습니다.   \\n\\n다시 입력해 주세요.   ');
					history.go(-1);
				</script>";

			exit;
		}
*/
		if($userType == "master") {
			$result = mysql_query("SELECT serialnum,passwd FROM odtAdmin WHERE id='$id'");
			$rows = mysql_num_rows($result);
			
			if(!$rows) {
				echo "
					<script>
						window.alert('등록되어 있지 않은 ID 입니다.   \\n\\n다시 입력해 주세요.   ');
						history.go(-1);
					</script>";

				exit;
			}
			else {
				$row = mysql_fetch_array($result);
				 
				$ManagerPA = $row[passwd];
				$serialnum = $row[serialnum];
				
				$result = mysql_query("SELECT password('$passwd')");
				$TablePassWD = mysql_result($result,0,0);
				 
				if(strcmp($ManagerPA,$TablePassWD)) {      
					echo "
						<script>
							window.alert('입력하신 비밀번호가 일치하지 않습니다.   \\n\\n다시 입력해 주세요.   ');
							history.go(-1);
						</script>";

					exit;
				 }
				 else {
					$keepTermLogin = $row_setup[keepTerm]*60;
					
					login_admin($serialnum,$row_setup[ranDsum],$_MaddSum,$keepTermLogin);
					
					echo "<meta http-equiv='Refresh' content='0; URL=od_submain.php'>";
				}
			}
		} else if($userType == "com") {
			$result = mysql_query("SELECT serialnum,passwd FROM odtMember WHERE id='$id' and passwd=password('$passwd') and userType='C'");
			$rows = mysql_num_rows($result);
			if(!$rows) {
					echo "
						<script>
							window.alert('입력하신 아이디나 비밀번호가 일치하지 않습니다.   \\n\\n다시 입력해 주세요.   ');
							history.go(-1);
						</script>";

					exit;
			}
			$serialnum = mysql_result($result,0,0);
			$keepTermLogin = $row_setup[keepTerm]*60;
			login_subcompany($serialnum,$row_setup[ranDsum],$_MaddSum,$keepTermLogin);
			echo "<meta http-equiv='Refresh' content='0; URL=/odprogram/odmanager/odorders2/od_orderslist.php'>";
		}
	}
	else {
		include "./odcommon/od_head.inc.php";
?>
<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;
				if(!form.id.value) {
					alert("아이디를 입력해 주세요.   ");
					form.id.focus();
					return false;
				}
				if(!form.passwd.value) {
					alert("비밀번호를 입력해 주세요.   ");
					form.passwd.focus();
					return false;
				}
			}
		</script>
<body onLoad="document.snsForm.id.focus();" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td height="100"></td>
    </tr>
    <form name="snsForm" method="post" action='od_main.php?mode=<?=$_GET[mode]?>' onSubmit="return valueCheck(this);">
        <input type="hidden" name="Form" value="ManagerLoginAcc">
        <tr>
            <td width="587" height="260" background="/images/od_login_01.jpg">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="247" align="center">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><img src="/images/od_login_02.jpg" width="196" height="30"></td>
                                </tr>
                                <tr>
                                    <td height="10"></td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <input type="radio" name="userType" value="master" <?=$check1?> >
                                        <img src="/images/od_login_03.jpg" width="32" height="12">&nbsp;&nbsp;
                                        <input type="radio" name="userType" value="com"  <?=$check2?> >
                                        <img src="/images/od_login_04.jpg" width="41" height="12"></td>
                                </tr>
                            </table>
                        </td>
                        <td width="340" align="center">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td colspan="2"><img src="/images/od_login_05.jpg" width="212" height="16"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:15 0 15 0"><img src="/images/od_login_10.jpg" width="272" height="1"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td><img src="/images/od_login_06.jpg" width="41" height="12">&nbsp;&nbsp;
                                                    <input class="input1" style="width:130" tabindex="1" name="id" type="text" size="10" value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="3"></td>
                                            </tr>
                                            <tr>
                                                <td><img src="/images/od_login_07.jpg" width="41" height="12">&nbsp;&nbsp;
                                                    <input class="input1" style="width:130" tabindex="2" name="passwd"  type="password" size="10" value="">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td><input type=image src="/images/od_login_08.jpg" width="70" height="53"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </form>
    <tr>
        <td align="center"><img src="/images/od_login_09.jpg" width="567" height="52"></td>
    </tr>
</table>
</body>
</html><? 
	} 
?>
