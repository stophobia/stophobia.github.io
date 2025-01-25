<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
/*
	## 아이디 체크(4자이상 12자 이하) ###########################################
	if(!ereg("[[:alnum:]+]{4,12}",$id)) {
		error_msgback_user('아이디(ID) 입력이 잘못 되었습니다.   \\n\\n다시 입력해 주세요.   ');
	}

	## 비빌번호 체크(4자이상 12자 이하) ###############################################
	if(!ereg("[[:alnum:]+]{4,12}",$passwd)) {
		error_msgback_user('비밀번호 입력이 잘못 되었습니다.   \\n\\n다시 입력해 주세요.   ');
	}
*/
	## 로그인하기 위해 입력한 아이디와 비밀번호가 일치하는 레코드를 검색한다. ##########
	$result = mysql_query("SELECT * FROM odtMember WHERE id='$id'");

	## 일치하는 회원정보가 없을 경우 ##############################################
	if(!$rows = mysql_num_rows(mysql_query("SELECT * FROM odtMember WHERE id='$id'"))) {
		error_msgback_user('아이디나 비밀번호가 일치하지 않습니다.   \\n\\n다시 입력해 주세요.   ');
	}
	else {
		## 회원정보가 있을 경우 비밀번호 필드값을 가져온다. ############################
		$row = mysql_fetch_array($result);

		$onedaynet_password = $row[passwd];
		$serialnum = $row[serialnum];
		$visitnum = $row[visitnum];

		## 사용자가 입력한 비밀번호를 암호화한다. ######################################
		$result = mysql_query("SELECT password('$passwd')");
		$user_passwd = mysql_result($result,0,0);

		## 두 비밀번호를 비교하여 일치하면 쿠키를 생성한다. ####################################
		if(strcmp($onedaynet_password,$user_passwd)) {
			error_msgback_user('아이디나 비밀번호가 일치하지 않습니다.   \\n\\n다시 입력해 주세요.   ');
		}
		else {
			$recentdate = time();
			$counter = $visitnum + 1;

			## 최근 방문일 값과 방문횟수 증가 #####################################################
			mysql_query("UPDATE odtMember SET recentdate=$recentdate,visitnum=$counter WHERE id='$id'");

			## 참여점수 부여 #####################################################
			$isFirst = @mysql_num_rows(mysql_query("select * from odtActionLog where acID = '".$id."' and acTitle ='첫 로그인' and acRegidate like '".date('Y-m-d')."%'"));
			if(!$isFirst) {
				mysql_query("insert into odtActionLog set acID= '".$id."', acTitle ='첫 로그인', acPoint='1', acRegidate = now(), ip='".$_SERVER[REMOTE_ADDR]."'");
				mysql_query("update odtMember set action = action + 1 where id='".$id."'");
			}

			## 참여점수 1000점 단위로 참여등급을 조절해줌 ####

			#################################################

			apply_login($serialnum,$row_setup[ranDsum],$addSum);

			echo "<meta http-equiv='Refresh' content='0; URL=$_move_path'>";
		}
	}
?>