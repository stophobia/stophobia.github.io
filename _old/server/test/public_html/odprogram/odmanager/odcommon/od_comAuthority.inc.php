<? 
	## 관리자 로긴 체크
	if(!$row_admin[id]) { 
		if(!$com[id]) {
			error_msgloc("$folderpath_manager/","\\n입점업체로 확인되지 않습니다.   \\n\\n정상적으로 로그인 후 접근해 주시기 바랍니다.   \\n"); 
		}
	}
?>