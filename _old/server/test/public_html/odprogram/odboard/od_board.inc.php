<?
	## board에 쓰이는 공통된 환경 설정과 권한 설정을 한다.################################
	## 쓰이는 공통 변수 ################################################################

	## 회원 레벨값을 가져온다.
	$Cooki_Member_Level = $row_member[Mlevel];		
	
	## 관리자 권한을 설정한다.
	$Cooki_Manager_Level = 9;						
	
	## 긴제목 자르기
	$titleLimit = 40;									
	
	## 게시판이 선택되지 않은 경우에는 공지사항을 호출해 준다.
	if(!$board) $board=1;								

	$row = mysql_fetch_array(mysql_query("SELECT * FROM odtBoardConfig WHERE serialnum='$board'"));
	
	if(!$row) { 
		error_msgback_user("존재하지 않는 게시판 입니다.   "); 
	}
	
	if($row[boardhidden]=="Yes") { 
		error_msgback_user("존재하지 않는 게시판 입니다.   "); 
	}

	## 환경변수 설정 ##################################################################
	$configBoardName = $row[boardname];
	
	$boardtitle_ = file_exists("../upfiles/odboard/odtitleimg/title$row[serialnum].jpg");
	if($boardtitle_) $configBoardTitleIMG = "<img src='$folderpath_upfiles/odboard/odtitleimg/title".$row[serialnum].".jpg' width='720'>";
	else $configBoardTitleIMG = "<img src='../upload/design/tcommunidy.jpg' width='720'>";

	## 게시판에 사용될 이미지를 지정한다.
	## new 이미지
	$board_new_img_c = file_exists("../upfiles/odboard/odicons/newicon$row[serialnum].gif");
	if($board_new_img_c) $board_new_img = "../upfiles/odboard/odicons/newicon$row[serialnum].gif";
	else $board_new_img = "../upfiles/odboard/odicons/newicon.gif";
	
	## 비밀글 아이콘
	$board_privacy_img_c = file_exists("../upfiles/odboard/odicons/privacyicon$row[serialnum].gif");
	if($board_privacy_img_c) $board_privacy_img = "../upfiles/odboard/odicons/privacyicon$row[serialnum].gif";
	else $board_privacy_img = "../upfiles/odboard/odicons/privacyicon.gif";
	
	## 답변글 아이콘
	$board_reply_icon_img_c = file_exists("../upfiles/odboard/odicons/reply_icon$row[serialnum].gif");
	if($board_reply_icon_img_c) $board_reply_icon_img = "../upfiles/odboard/odicons/reply_icon$row[serialnum].gif";
	else $board_reply_icon_img = "../upfiles/odboard/odicons/reply_icon.gif";
	
	## 타이틀 아이콘
	$board_titleicon_img_c = file_exists("../upfiles/odboard/odicons/titleicon$row[serialnum].gif");
	if($board_titleicon_img_c) $board_titleicon_img = "../upfiles/odboard/odicons/titleicon$row[serialnum].gif";
	else $board_titleicon_img = "../upfiles/odboard/odicons/titleicon.gif";
	
	## 테이블 바탕 이미지
	$board_backimg_img_c = file_exists("../upfiles/odboard/odicons/backimg$row[serialnum].gif");
	if($board_backimg_img_c) $board_backimg_img = "../upfiles/odboard/odicons/backimg$row[serialnum].gif";
	else $board_backimg_img = "../upfiles/odboard/odicons/backimg.gif";
	
	## 테이블 구분선 이미지
	$board_line_img_c = file_exists("../upfiles/odboard/odicons/line$row[serialnum].gif");
	if($board_line_img_c) $board_line_img = "../upfiles/odboard/odicons/line$row[serialnum].gif";
	else $board_line_img = "../upfiles/odboard/odicons/line.gif";
	
	## 테이블 배경색상
	$configBgColor = $row[bgcolor];
	
	## 목록(리스트)버튼 이미지
	$board_list_img_c = file_exists("../upfiles/odboard/odicons/listicon$row[serialnum].gif");
	if($board_list_img_c) $board_list_img = "../upfiles/odboard/odicons/listicon$row[serialnum].gif";
	else $board_list_img = "../upfiles/odboard/odicons/listicon.gif";
	
	## 글쓰기버튼 이미지
	$board_write_img_c = file_exists("../upfiles/odboard/odicons/writeicon$row[serialnum].gif");
	if($board_write_img_c) $board_write_img = "../upfiles/odboard/odicons/writeicon$row[serialnum].gif";
	else $board_write_img = "../upfiles/odboard/odicons/writeicon.gif";
	
	## 글수정버튼 이미지
	if(file_exists("../upfiles/odboard/odicons/modifyicon$row[serialnum].gif")) 
		$board_modify_img = "../upfiles/odboard/odicons/modifyicon$row[serialnum].gif";
	else $board_modify_img = "../upfiles/odboard/odicons/modifyicon.gif";
	
	## 답변버튼 이미지
	$board_reply_img_c = file_exists("../upfiles/odboard/odicons/replyicon$row[serialnum].gif");
	if($board_reply_img_c) $board_reply_img = "../upfiles/odboard/odicons/replyicon$row[serialnum].gif";
	else $board_reply_img = "../upfiles/odboard/odicons/replyicon.gif";
	
	## 글삭제버튼 이미지
	$board_delete_img_c = file_exists("../upfiles/odboard/odicons/deleteicon$row[serialnum].gif");
	if($board_delete_img_c) $board_delete_img = "../upfiles/odboard/odicons/deleteicon$row[serialnum].gif";
	else $board_delete_img = "../upfiles/odboard/odicons/deleteicon.gif";
	
	## 검색버튼 이미지
	$board_search_img_c = file_exists("../upfiles/odboard/odicons/searchicon$row[serialnum].gif");
	if($board_search_img_c) $board_search_img = "../upfiles/odboard/odicons/searchicon$row[serialnum].gif";
	else $board_search_img = "../upfiles/odboard/odicons/searchicon.gif";
	
	## 확인버튼 이미지
	$board_ok_img_c = file_exists("../upfiles/odboard/odicons/okicon$row[serialnum].gif");
	if($board_ok_img_c) $board_ok_img = "../upfiles/odboard/odicons/okicon$row[serialnum].gif";
	else $board_ok_img = "../upfiles/odboard/odicons/okicon.gif";
	
	## 취소버튼 이미지
	$board_cancel_img_c = file_exists("../upfiles/odboard/odicons/cancelicon$row[serialnum].gif");
	if($board_cancel_img_c) $board_cancel_img = "../upfiles/odboard/odicons/cancelicon$row[serialnum].gif";
	else $board_cancel_img = "../upfiles/odboard/odicons/cancelicon.gif";

	$configBoardComment = nl2br(stripslashes($row[boardcomment]));
	$configCommentView = $row[commentview];
	$configBoardType = $row[boardtype];
	$configReadAuthority = $row[readauthority];
	
	## 글읽기권한 설정
	if($row[readauthority] == "manager") $configReadLevel = 9;
	else if($row[readauthority] == "user1") $configReadLevel = 5;
	else if($row[readauthority] == "user") $configReadLevel = 3;
	else if($row[readauthority] == "member") $configReadLevel = 1;
	else $configReadLevel = 0;

	$configWriteAuthority = $row[writeauthority];
	
	## 글쓰기권한 설정
	if($row[writeauthority] == "manager") $configWriteLevel = 9;
	else if($row[writeauthority] == "user1") $configWriteLevel = 5;
	else if($row[writeauthority] == "user") $configWriteLevel = 3;
	else if($row[writeauthority] == "member") $configWriteLevel = 1;
	else $configWriteLevel = 0;
	
	## 댓글쓰기권한 설정
	if($row[noticeauthority] == "manager") $configNoticeLevel = 9;
	else if($row[noticeauthority] == "user1") $configNoticeLevel = 5;
	else if($row[noticeauthority] == "user") $configNoticeLevel = 3;
	else if($row[noticeauthority] == "member") $configNoticeLevel = 1;
	else $configNoticeLevel = 0;

	$configBoardTemplate = $row[boardtemplate];
	$configReplyUsed = $row[replyused];
	$configNoticeUsed = $row[noticeused];
	$configRelationUsed = $row[relationused];
	$configEmailUsed = $row[emailused];
	$configHomepageUsed = $row[homepageused];
	$configPrivacyUsed = $row[privacyused];
	$configFileNum = $row[filenum];

	$configiconNew = $row[iconNew];

	if($configBoardType == "ImageBoard") $boardmoveTemp = "photo.php";
	else $boardmoveTemp = "od_board.php";
	
	$qry_BBFL = "SELECT filter, filefilter FROM odtBoardFilter";
	$res_BBFL = mysql_query($qry_BBFL);
	$num_BBFL = mysql_num_rows($res_BBFL);
	
	if($num_BBFL) {
		$row_BBFL = mysql_fetch_array($res_BBFL);

		$configFilter = $row_BBFL[filter];
		$configFileFilter = $row_BBFL[filefilter];
	}

	##########################################################################
	## fileUpload : 파일 업로드 ################################################
	## 입력 : $fileTemp -> 대상파일(DIR,확장자포함),						   
	##	  $fileName -> 타겟파일(확장자없음-파일이름만),					   
	##	  $del -> 지울지여부('Y'/'N'), 						           
	##        $kind -> 업할 확장자 제약(없으면 전부, 예 'jpg/gif')         
	##########################################################################
	function fileUpload($fileTemp,$fileName,$del,$kind,$configFileFilter) {
		global $folderpath_board_upload;
		$kindTemp = explode('/',$kind);
		
		if(strcmp($fileName,"none")) {
			if( ereg("[[:space:]]",$fileName)) { 
				error_msgback_user("파일명에 공백이 있습니다.   "); 
			}
			
			## 촥장자 검색 ############################
			$full_filename= explode(".", $fileName);
			$extension = $full_filename[sizeof($full_filename)-1];
			$NoExtenstion = $configFileFilter;
			$NoExtenstionTemp = explode(",",$NoExtenstion);
			
			for($i=0;$i<count($NoExtenstionTemp);$i++) {
				if($NoExtenstionTemp[$i] == $extension) { 
					error_msgback_user("업로드가 허용되지 않는 파일입니다.   "); 
				}
			}

			if(count($kindTemp) > 0 && strlen($kind)>0) {
				$matchStatus = "N";
				
				for($i=0;$i<count($kindTemp);$i++) {
					if(strtolower($kindTemp[$i]) == strtolower($extension)) {
						$matchStatus = "Y";
						
						break;
					}
				}
			}
			else {
				$matchStatus = "Y";
			}
			
			if($matchStatus == "N") { 
				error_msgback_user("업로드가 허용되지 않는 파일입니다.   "); 
			}
			
			## 중복시 처리 ##############################
			$exist = file_exists("$folderpath_board_upload/$fileName");
			
			if($del == "N") {
				while($exist) {
					$full_filename= explode(".", $fileName);
					$extension =  $full_filename[sizeof($full_filename)-1];
					$imgname   =  $full_filename[sizeof($full_filename)-2];
					$fileName = $imgname ."_1." .$extension;
					$exist = file_exists("$folderpath_board_upload/$fileName");
				}
			}
			else {
				if($exist) unlink("$folderpath_board_upload/$fileName");
			}
			
			## 화일 카피 ################################################################################
			if(!copy($fileTemp,"$folderpath_board_upload/$fileName")) { 
				error_msgback_user("파일을 지정한 디렉토리로 복사 하는 데 실패했습니다.   "); 
			}
			
			if(!unlink($fileTemp)) { 
				error_msgback_user("임시파일을 삭제 하는데 실패했습니다.   "); 
			}
			
			$img_name =$fileName;
		}

		return $img_name;
	}

	## historyBack() : 페이권한 뿌려주고 뒤로 이동 #####################################
	function historyBack() { 
		error_msgback_user("페이지에 대한 권한이 없습니다.   "); 
	}

	##################################################################################
	## authorityTest : 페이지에 권한 체크 ##############################################
	## 입력값 : 'Read', 'Write'                                                        
	## 처리 : 입력값에 해당하는 페이지의 권한에 적합하지 않은 사용사일 때는                   
	## history.back()해준다.                                                          
	##################################################################################
	function authorityTest($PageTemp) {
		global $Cooki_Manager_Level, $configReadAuthority, $configWriteAuthority, $Cooki_Member_Level;
		
		if($PageTemp == "Read") {
			if($configReadAuthority == "user") {
				if($Cooki_Member_Level == "") {
					historyBack();
				}
			}
			else if($configReadAuthority == "manager") {
				if($Cooki_Member_Level != $Cooki_Manager_Level) {
					historyBack();
				}
			}
		}
		else if($PageTemp == "Write") {
			if($configWriteAuthority == "user") {
				if($Cooki_Member_Level == "") {
					historyBack();
				}
			}
			else if($configWriteAuthority == "manager") {
				if($Cooki_Member_Level != $Cooki_Manager_Level) {
					historyBack();
				}
			}
		}
	}

	## 한글 길이체크해서 짤라 주고 리턴 ################################################3
	function han_substr($string, $limit_length) { 
		$string_length = strlen( $string); 
		
		if($limit_length <= $string_length) { 
			$string = substr($string, 0, $limit_length); 
			$han_char = 0; 
			
			for ( $i = $limit_length-1; $i>=0; $i-- ) { 
				## 뒤에서 한글자씩 떼어서 
				$lastword = ord( substr( $string, $i, 1 ) ); 
				
				## 정상적인 영문자,숫자라면..stop 
				if ( 127 > $lastword ) break;          
				## 한글 or 특수문자라면.. 
				else $han_char++; 
			}

			## 짝이 안맞으므로 한글자 더 작게 자른다. 
			if($han_char%2 == 1){
				$string  = substr( $string,  0, $limit_length-1 ); 
			}

			$string .= "...";
		}

		return $string; 
	}

	## HTML관련 ######################################################################
	function EnableHTML($data) {
		$data = eregi_replace("<\\?", "&lt;?", $data);
		$data = eregi_replace("\\?>", "?&gt;", $data);
		$data = eregi_replace("<script(.*)>", "&lt;script\\1&gt;", $data);
		$data = eregi_replace("</script>", "&lt;/script&gt;", $data);
		$data = chop($data);
		
		return ($data);
	}
	
	function DisableHTML($data) {
		$data = chop($data);
		$data = htmlspecialchars($data);
		
		return($data);
	}
?>
