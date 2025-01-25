<?php
// 최근 사진들을 뽑아옴.
if(!$photoNo) $photoNo = $nowPhoto['uid'];
$newPhoto = @mysql_query('select uid, file_route, title from '.$dbFIX.'photo order by uid desc limit '.$photo['main_num']);
while($oPhoto = mysql_fetch_array($newPhoto)) {
	echo '<a href="./?photoNo='.$oPhoto['uid'].'"><img src="../phpThumb/phpThumb.php?src=../'.$oPhoto['file_route'].'&amp;w='.$photo['main_width'].'&amp;h='.$photo['main_height'].'&amp;q='.$photo['quality'].'&amp;fltr[]=usm|99|0.5|3" alt="" /></a> ';
}
?>