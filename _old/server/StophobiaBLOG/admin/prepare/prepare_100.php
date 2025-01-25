<?php
	if($target) {
		$self_info = htmlspecialchars(addslashes($self_info));
		$updateMember = "update ".$dbFIX."user set ";
		if($password) $updateMember .= "password = '".md5($password)."', ";
		$updateMember .= "homepage = '$homepage', email = '$email', nickname = '$nickname', self_info = '$self_info' ".
			"where uid = '$target'";
		@mysql_query($updateMember);
		error($id.'님의 정보를 수정했습니다.', 'location.href=\'admin.php?admin=100\';');
	}
?>