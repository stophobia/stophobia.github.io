<?php
	$modify = @mysql_fetch_array(mysql_query("select * from ".$dbFIX."photo where uid = '$modifyTarget'"));
	if($_FILES['file']['size'] > 0)
	{
		$filename = $_FILES['file']['name'];
		$filetype = $_FILES['file']['type'];
		$filesize = $_FILES['file']['size'];
		$filetmpname = $_FILES['file']['tmp_name'];

		if(!is_uploaded_file($filetmpname)) 
			error('정상적으로 파일을 업로드 해 주세요');
			
		if(!eregi('\.png|\.jpg|\.jpeg|\.gif|\.bmp', $filename))
			error('그림파일이 아닙니다');

		$filetmpname = str_replace('\\\\', '\\', $filetmpname);
		$filename = str_replace(' ', '_', $filename);
		$filename = str_replace('-', '_', $filename);

		if(file_exists('data/photo/'.$filename))
			$filename = 'data/photo/'.substr(md5(time()), -5).'_'.$filename;
		else $filename = 'data/photo/'.$filename;

		if(!move_uploaded_file($filetmpname, $filename)) 
			error('파일을 업로드 하지 못했습니다. 파일용량을 확인해 보세요');

		@unlink($modify['file_route']);
	}
	if(!$filename) $filename = $modify['file_route'];
	if($_POST['title']) {
		$title = addslashes($title);
		$content = addslashes($content);
		$content = str_replace(array('<p>', '</p>'), array('', '<br />'), $content);
		if($photo_modifyTarget) {
			$photoMsg = '수정';
			@mysql_query("update ".$dbFIX."photo set title = '$title', content = '$content', file_route = '$filename', category = '$selectCategory' where uid = '$photo_modifyTarget'");
		} else {
			$photoMsg = '추가';
			@mysql_query("insert into ".$dbFIX."photo set uid = '', file_route = '$filename', signdate = '".time()."', title = '$title', content = '$content', category = '$selectCategory', comment = '0'");
		}
		error('사진첩에 사진을 '.$photoMsg.' 했습니다.', 'location.href=\'admin.php?admin=10&modifyTarget='.$photo_modifyTarget.'\';');
	}
?>