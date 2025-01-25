<?php
if(!defined('__GRBOARD__')) exit();

// 테마 라이브러리 불러오기
include $theme."/lib.php";

// 게시물 보기시 이미지 최대크기 지정 (지정한 크기 이상이면 자동 리사이즈)
$maxImageWidth = 550; # ← 여기 숫자 (픽셀 단위입니다) 를 자신의 홈페이지에 맞게 조절해주세요. (기본: 550)
$content = autoImgResize($maxImageWidth, $content);
?>
<div class="viewTitle">
	<div class="viewTitleLeft"></div>
	<?php echo $subject; ?>
	<div class="btn"><?php if($isTrackback) { ?><input type="button" onclick="clickToCopy('<?php echo $trackbackUrl; ?>');" title="이 글의 엮인글(트랙백) 주소 입니다." value="Trackback" />
	<?php } if($view['link1']) { ?><input type="button" onclick="window.open('<?php echo htmlspecialchars($view['link1']); ?>', '_blank'); return false" title="링크 #1 이 있습니다." value="Link 1" />
	<?php } if($view['link2']) { ?><input type="button" onclick="window.open('<?php echo htmlspecialchars($view['link2']); ?>', '_blank'); return false" title="링크 #2 이 있습니다." value="Link 2" /><?php } ?>
	</div>
	<div class="viewTitleRight"></div>
</div>

<?php
// 파일 다운로드
if($isFiles) { ?>
<div class="viewLeft">받은횟수</div>
<div class="viewRight"><?php echo $downloadHit; ?></div>
<div class="clear"></div>

<?php if($filename1) { ?>
<div class="viewLeft">파일 #1</div>
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

// 추가 첨부된 파일 목록
$extendLoop = 1;
$getExtendFile = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
while($extendFile = @mysql_fetch_array($getExtendFile)) {
	$extendFileName = end(explode('/', $extendFile['file_route']));
?>
<div class="viewLeft">추가파일 #<?php echo $extendLoop; ?></div>
<div class="viewRight"><?php echo showDownImg($extendFileName, $extendFile['no']); ?></div>
<div class="clear"></div>
<?php $extendLoop++; } ?>

<div class="viewContent">
	<!-- 게시물 내용 출력 -->
	<div id="mainContent">
		<?php echo $content; ?>
		<div id="writeBy">작성자: <?php echo $view['name']; ?>, 작성시각: <?php echo date('Y.m.d H:i:s', $view['signdate']); ?></div>
	</div>

	<!-- 태그 출력 -->
	<div class="viewTag"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_tag.gif" alt="태그" /> <?php echo $tag; ?></div>

	<!-- 작성자 소개 출력 -->
	<?php echo showMemberInfo($view['member_key']); ?>

	<!-- 하단 싱크걸기, 추천, 비추, 담기 버튼 출력 -->
	<div id="goodORbad">
		<?php if($isWriter) { ?><a href="#" onclick="window.open('<?php echo $grboard; ?>/sync.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>', 'sinkNET', 'width=10,height=10,menubar=no');" title="이 글을 시리니넷 SinkNET™ 에 싱크(Sync) 합니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_sink.gif" alt="싱크걸기" /></a><?php } ?> 
		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;good=1" style="color: #386d9f" title="이 글이 좋습니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_good.gif" alt="추천" /></a> 
		<a href="<?php echo $grboard; ?>/view_scrap.php?isAdd=1&amp;id=<?php echo $id; ?>&amp;article_num=<?php echo $articleNo; ?>" onclick="window.open(this.href, 'addScrap', 'width=600,height=650,menubar=no,scrollbars=yes'); return false" style="color: #a25757" title="이 글을 내 스크랩북에 담습니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_scrap.gif" alt="스크랩" /></a> 
		<a href="<?php echo $grboard; ?>/report.php?id=<?php echo $id; ?>&amp;article_num=<?php echo $articleNo; ?>" onclick="window.open(this.href, 'addReport', 'width=600,height=650,menubar=no,scrollbars=yes'); return false" style="color: green" title="이 글을 관리자와 마스터에게 신고합니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_report.gif" alt="신고" /></a>
	</div>
</div>