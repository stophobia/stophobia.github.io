<?php
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
<script src="./photo.js" type="text/javascript"></script>
</head>
<body>
<div id="topMenu">
	<div id="logo"><a href="./"><img src="./image/top_logo.gif" alt="PHOTOLOG" /></a></div>
	<div id="menu">
		<div class="on"><a href="./" title="포토로그 첫화면으로 갑니다."><img src="./image/menu_main_page.gif" alt="처음화면" /></a></div>
		<div><a href="photo_list.php" title="찍었던 사진들 목록을 한번에 봅니다."><img src="./image/menu_photo_list.gif" alt="목록보기" /></a></div>
		<div><a href="../" title="블로그로 돌아갑니다."><img src="./image/menu_back_blog.gif" alt="블로그로 가기" /></a></div>
		<div class="clr"></div>
	</div>
</div>
<div id="main">
	<div id="mainPhoto">
		<div><a href="../<?php echo $nowPhoto['file_route']; ?>" rel="lightbox" class="photolog" title="클릭하시면 닫힙니다"><img src="<?php echo $resizePhoto; ?>" alt="main photo" /></a></div>
		<div class="exif"><?php echo $mainEXIF; ?></div>
	</div>
	<div id="photoInfo">
		<div id="txtInfo">
			<div class="title"><?php echo $photoCa; ?> | <?php echo $mainTitle; ?> <span class="date">(<?php echo date('Y.m.d H:i:s', $nowPhoto['signdate']);
			if($_SESSION['no']) echo ' / <a href="#" onclick="deletePhoto('.$nowPhoto['uid'].');" title="이 사진을 사진첩에서 삭제 합니다.">delete</a>'; ?>)</span></div>
			<div class="content"><?php echo $mainContent; ?></div>
		</div>
		<div id="prevNextInfo">
			<img src="image/prev_image_btn.gif" alt="이전사진" /> <?php echo $prevImage.' '.$justViewImage.' '.$nextImage; ?> <img src="image/next_image_btn.gif" alt="다음사진" />
		</div>
		<div class="clr"></div>
	</div>
</div>
<div id="latest"><img src="./image/title_latest_photo.gif" alt="My Latest Photo" /></div>
<div id="latestPhoto"><?php include 'latest_thumbnail.php'; ?></div>
<?php if($photo['use_comment']) include 'photo_comment.php'; ?>
<form id="enterCoPass" method="post" onsubmit="return checkCoPass()" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="deleteCoUid" value="<?php echo $deleteCoUid; ?>" />
<div id="enterPass" style="display: none">
	<div>비밀번호: <input type="password" class="i" name="coPass" /><input type="submit" value="확인" class="s" /></div>
</div>
</form>
</body>
</html>