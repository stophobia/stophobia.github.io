<?php
/*
	GR Paper HTML캐쉬 비우기
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-1-12
	내  용: Ajax 로 넘어온 값들을 확인하여 스킨 설정을 변경한다.
	참  고: phpThumb 에서 생성한 썸네일 이미지 파일들도 여기서 한번에 정리한다.
	주  의: 관리자만 HTML 캐쉬를 비울 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin() || !$_POST['x']) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

$cd = dir('../cache');
while($cache = $cd->read()) {
	if($cache == '.' || $cache == '..') continue;
	@unlink('../cache/'.$cache);
}
$cd->close();

// 재귀호출 방식으로 캐쉬 처리 (by GR보드)
function rmrf($dir, $isRootDelete=false)
{
	if(!$dh = @opendir($dir)) return;
	while (false !== ($obj = @readdir($dh))) {
		if($obj == '.' || $obj == '..') continue;
		if(!@unlink($dir . '/' . $obj)) rmrf($dir.'/'.$obj, true);
	}
	@closedir($dh);	   
	if ($isRootDelete) @rmdir($dir);	   
	return;
}
rmrf('../phpThumb/cache/');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
