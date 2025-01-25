<?php
if(!defined('__GRBOARD__')) exit();

// 테마 라이브러리 불러오기
include $theme."/lib.php";
?>
<div class="writeTitle" >記事を確認します。</div>
<div class="viewTitle">
	<div class="viewTitleLeft"></div>
	<?php echo $subject; ?>
	<div class="viewTitleRight"></div>
</div>

<?php
// 파일 다운로드
if($isFiles) { ?>

<?php if($filename1) { ?>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=1"><?php echo showImg($filename1); ?></a></div>
<div class="clear"></div>

<?php } if($filename2) { ?>
<div class="viewLeft">파일 #2</div>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=2"><?php echo showImg($filename2); ?></a></div>
<div class="clear"></div>

<?php } if($filename3) { ?>
<div class="viewLeft">파일 #3</div>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=3"><?php echo showImg($filename3); ?></a></div>
<div class="clear"></div>

<?php } if($filename4) { ?>
<div class="viewLeft">파일 #4</div>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=4"><?php echo showImg($filename4); ?></a></div>
<div class="clear"></div>

<?php } if($filename5) { ?>
<div class="viewLeft">파일 #5</div>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=5"><?php echo showImg($filename5); ?></a></div>
<div class="clear"></div>

<?php } if($filename6) { ?>
<div class="viewLeft">파일 #6</div>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=6"><?php echo showImg($filename6); ?></a></div>
<div class="clear"></div>

<?php } if($filename7) { ?>
<div class="viewLeft">파일 #7</div>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=7"><?php echo showImg($filename7); ?></a></div>
<div class="clear"></div>

<?php } if($filename8) { ?>
<div class="viewLeft">파일 #8</div>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=8"><?php echo showImg($filename8); ?></a></div>
<div class="clear"></div>

<?php } if($filename9) { ?>
<div class="viewLeft">파일 #9</div>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=9"><?php echo showImg($filename9); ?></a></div>
<div class="clear"></div>

<?php } if($filename10) { ?>
<div class="viewLeft">파일 #10</div>
<div class="viewRight"><a href="<?php echo $grboard; ?>/download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;num=10"><?php echo showImg($filename10); ?></a></div>
<div class="clear"></div>
<?php } # file10
} # isFiles
?>