<?php
// 환경설정정보 가져오기
function getConfig()
{
	global $dbFIX;
	$get = @mysql_query('select * from '.$dbFIX.'config where uid = '.$_SESSION['no']);
	$result = @mysql_fetch_array($get);
	return $result;
}
// 블로그 홈 주소
function getHome()
{
	$result = 'http://'.$_SERVER['HTTP_HOST'];
	$result .= str_replace('/admin.php', '', $_SERVER['SCRIPT_NAME']);
	return $result;
}
// 메뉴 버튼 상태
function btn($n, $btn)
{
	if($n == $btn) return 'm';
	else return 'n';
}
// 전체설정저장
function saveConfig()
{
	global $dbFIX;
	$filename = $_FILES['file']['name'];
	$filetype = $_FILES['file']['type'];
	$filesize = $_FILES['file']['size'];
	$filetmpname = $_FILES['file']['tmp_name'];
	if($filesize > 0)
	{
		@unlink('image/my_photo.jpg');
		if(!is_uploaded_file($filetmpname)) 
			error('정상적으로 파일을 업로드 해 주세요');
		if(!eregi('\.jpg', $filename))
			error('그림파일(확장자 .jpg) 만 올려주세요.');
		$filetmpname = str_replace('\\\\', '\\', $filetmpname);
		if(!move_uploaded_file($filetmpname, 'image/my_photo.jpg')) 
			error('파일을 업로드 하지 못했습니다. 파일용량을 확인해 보세요');
	}
	if(!$_POST['name']) error('이름을 입력해 주세요');
	if(!$_POST['email']) error('이메일 주소를 입력해 주세요');
	if(!$_POST['user_key']) error('스팸 방지를 위한 키 값을 입력해 주세요');
	if(!$_POST['blog_name']) error('블로그 이름을 입력해 주세요');
	if(!$_POST['blog_info']) error('한줄 블로그 소개를 입력해 주세요');
	if(!$_POST['num_view_post'] or $_POST['num_view_post'] < 0 or $_POST['num_view_post'] > 999) 
		error('한 페이지당 글 수는 1 부터 999 사이로 지정해 주세요');
	if(!$_POST['num_rss_post'] or $_POST['num_rss_post'] < 0 or $_POST['num_rss_post'] > 999) 
		error('RSS 로 보일 글 수는 1 부터 999 사이로 지정해 주세요');
	$que = 'update '.$dbFIX.'config set ';
	if(array_key_exists('password', $_POST) && $_POST['password'])
		$que .= "password = '".md5($_POST['password'])."', ";
	$que .= "name = '".addslashes($_POST['name'])."', homepage = '".$_POST['homepage']."', ";
	$que .= "email = '".$_POST['email']."', blog_title = '".addslashes($_POST['blog_name'])."', ";
	$que .= "blog_info = '".addslashes($_POST['blog_info'])."', theme = '".$_POST['theme']."', ";
	$que .= "num_view_post = '".$_POST['num_view_post']."', ";
	$que .= "num_per_page = '".$_POST['num_per_page']."', ";
	$que .= "num_rss_post = '".$_POST['num_rss_post']."', ";
	$que .= "num_rss_content = '".$_POST['num_rss_content']."', ";
	$que .= "use_trackback = '".$_POST['use_trackback']."', ";
	$que .= "use_comment = '".$_POST['use_comment']."', ";
	$que .= "use_rss = '".$_POST['use_rss']."', ";
	$que .= "user_key = '".$_POST['user_key']."', ";
	$que .= "use_openid = '".$_POST['use_openid']."', ";
	$que .= "cache_time = '".$_POST['cache_time']."', ";
	$que .= "use_cache = '".$_POST['use_cache']."' ";
	$que .= "where uid = '".$_POST['target']."'";
	@mysql_query($que) or error('설정을 업데이트 하지 못했습니다');
	move('admin.php');
}
// 링크 저장
function addLink()
{
	global $dbFIX;
	if(!$_POST['name']) error('해당 링크의 사이트(블로그) 이름을 입력해 주세요');
	if(!$_POST['info']) error('해당 링크의 설명을 적어주세요');
	if(!$_POST['url']) error('링크 주소를 입력해 주세요');
	if($_POST['mt'])
	{
		$que = "update ".$dbFIX."link set url = '".$_POST['url']."', name = '".$_POST['name']."', ".
			"info = '".htmlspecialchars($_POST['info'])."' where uid = '".$_POST['mt']."'";
	}
	else
	{
		$que = "insert into ".$dbFIX."link set uid = '', url = '".$_POST['url']."', ".
			"name = '".$_POST['name']."', info = '".htmlspecialchars($_POST['info'])."'";
	}
	@mysql_query($que);
	move('admin.php?admin=3');
}
// 링크 순서 변경
function resort($str)
{
	global $dbFIX;
	$ar = explode(';', $str);
	@mysql_query("update ".$dbFIX."link set uid = 0 where uid = $ar[0]");
	@mysql_query("update ".$dbFIX."link set uid = -1 where uid = $ar[1]");
	@mysql_query("update ".$dbFIX."link set uid = $ar[0] where uid = -1");
	@mysql_query("update ".$dbFIX."link set uid = $ar[1] where uid = 0");
	move('admin.php?admin=3');
}
?>