<?php
if($_GET['photoNo']) $photoNo = $_GET['photoNo'];
if($_GET['category']) $category = $_GET['category'];
if($_GET['p']) $p = $_GET['p'];
include 'photo_head.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR BLog" />
<meta name="Nationality" content="Korean" />
<link rel="stylesheet" href="./photo_style.css" type="text/css" title="style" />
<title><?php echo stripslashes($photo['photoTitle']); ?></title>
<script src="../js/spica.js" type="text/javascript"></script>
<script src="../js/lightbox_plus.js" type="text/javascript"></script>
</head>
<body>
<div id="topMenu">
	<div id="logo"><a href="./"><img src="./image/top_logo.gif" alt="PHOTOLOG" /></a></div>
	<div id="menu">
		<div><a href="./" title="포토로그 첫화면으로 갑니다."><img src="./image/menu_main_page.gif" alt="처음화면" /></a></div>
		<div class="on"><a href="photo_list.php" title="찍었던 사진들 목록을 한번에 봅니다."><img src="./image/menu_photo_list.gif" alt="목록보기" /></a></div>
		<div><a href="../" title="블로그로 돌아갑니다."><img src="./image/menu_back_blog.gif" alt="블로그로 가기" /></a></div>
		<div class="clr"></div>
	</div>
</div>
<div id="mainList">
	<table rules="none" summary="GR Blog Photolog Photo List" cellpadding="0" cellspacing="0" border="0" style="width: 100%; table-layout: fixed">
	<caption></caption>
	<thead>
	<tr>
		<th colspan="4" class="s">
		<select name="chooseCategory" onchange="location.href='./photo_list.php?category='+this.value;">
		<?php
		$getCategory = @mysql_query('select * from '.$dbFIX.'photo_category');
		while($selectCa = @mysql_fetch_array($getCategory)) { ?>
		<option value="<?php echo $selectCa['uid']; ?>"<?php echo (($selectCa['uid']==$category)?' selected="selected"':''); ?>><?php echo stripslashes($selectCa['name']); ?></option>
		<?php } ?>
		</select>
		</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<?php
		if(!$p) $p = 1;
		$loop = 0;
		if($category) $addQ = ' where category = '.$category; else $addQ = '';
		$fromPage = ($p - 1) * $photo['photo_list_num'];
		$totalCount = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'photo'.$addQ));
		$totalPage = ceil($totalCount[0] / $photo['photo_list_num']);
		$getPhoto = @mysql_query('select * from '.$dbFIX.'photo'.$addQ.' order by uid desc limit '.$fromPage.', '.$photo['photo_list_num']);
		while($photos = mysql_fetch_array($getPhoto)) { 
			$ca = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'photo_category where uid = '.$photos['category']));
			$ca['name'] = stripslashes($ca['name']);
		?>
		<td class="list"><a href="../<?php echo $photos['file_route']; ?>" rel="lightbox1" class="photolog" title="클릭하시면 닫힙니다"><img src="../phpThumb/phpThumb.php?src=../<?php echo $photos['file_route']; ?>&amp;w=<?php echo $photo['photo_list_width']; ?>&amp;h=<?php echo $photo['photo_list_height']; ?>&amp;q=<?php echo $photo['quality']; ?>&amp;fltr[]=usm|99|0.5|3" alt="photo list" onmouseover="this.style.borderColor='#000000'" onmouseout="this.style.borderColor=''" /></a><br />
		<a href="./?photoNo=<?php echo $photos['uid']; ?>" title="분류: <?php echo $ca['name']; ?>"><?php echo stripslashes($photos['title']); ?></a><?php if($photo['use_comment']) { ?> <span>(<?php echo $photos['comment']; ?>)</span><?php } ?></td>
		<?php
			$loop++;
			if($loop % 4 == 0) echo '</tr>';
			} 
		$paging = getPaging($photo['photo_list_num'], $p, $totalPage, './photo_list.php?category='.$category.'&amp;p=');
		?>
	<tr>
		<td colspan="4" class="paging"><?php echo $paging; ?></td>
	</tr>
	</tbody>
	</table>
</div>
</body>
</html>