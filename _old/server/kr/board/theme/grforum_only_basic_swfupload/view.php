<?php
if(!defined('__GRBOARD__') || !defined('__GRFORUM__')) exit();

// 테마 라이브러리 불러오기
include $theme."/lib.php";

// 게시글 전처리 (이미지 리사이즈 / BBCode 구현)
$maxImageWidth = 550; # ← 여기 숫자 (픽셀 단위입니다) 를 자신의 홈페이지에 맞게 조절해주세요. (기본: 550)
$content = autoImgResize($maxImageWidth, $content);
$content = setBBCode($content, true); # ← true 면 BBCode 사용함 / false 면 BBCode 무시

// 글쓴이 정보 처리
$writerInfo = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'member_list where no = '.$view['member_key']));
$writerStatus = getWriterStatus($view['member_key']);
$isOnline = ($writerInfo['lastlogin']+600 > time())?'<span class="green">현재 접속중입니다</span>':'오프라인 상태입니다';
?>
<div class="viewTitle">
	<?php echo $forumTitle; ?>
	<div class="btn"><?php if($isTrackback) { ?><input type="button" onclick="clickToCopy('<?php echo $trackbackUrl; ?>');" title="이 글의 엮인글(트랙백) 주소 입니다." value="Trackback" />
	<?php } if($view['link1']) { ?><input type="button" onclick="window.open('<?php echo htmlspecialchars($view['link1']); ?>', '_blank'); return false" title="링크 #1 이 있습니다." value="Link 1" />
	<?php } if($view['link2']) { ?><input type="button" onclick="window.open('<?php echo htmlspecialchars($view['link2']); ?>', '_blank'); return false" title="링크 #2 이 있습니다." value="Link 2" /><?php } ?>
	</div>
</div>

<div class="viewTop center">
	<div class="side">글쓴이</div>
	<div class="text">내용</div>
</div>

<div class="viewMain">
	<div class="side">
		<div class="title center"><h3><?php echo $view['name']; ?></h3></div>
		<ul>
			<?php if($writerInfo['photo']) { ?><li><img src="<?php echo $grboard; ?>/phpThumb/phpThumb.php?src=<?php echo $grboard.'/'.$writerInfo['photo']; ?>&amp;w=100&amp;h=100&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="my photo" /></li><?php } ?>
			<li>작성시각: <?php echo date('Y.m.d H:i:s', $view['signdate']); ?></li>
			<li>총 작성한 글타래: <?php echo $writerStatus['post']; ?> 개</li>
			<li>총 작성한 댓글수: <?php echo $writerStatus['reply']; ?> 개</li>
			<li>가입일: <?php echo date('Y/m/d', $writerInfo['make_time']); ?></li>
			<li>포인트: <?php echo $writerInfo['point']; ?></li>
			<li>레벨: <?php echo $writerInfo['level']; ?></li>
			<?php if($view['member_key']) { ?><li><?php echo $isOnline; ?></li><?php } ?>
			<li><?php if($writerInfo['homepage']) echo '<a href="'.$writerInfo['homepage'].'">[homepage]</a> ';
				if($writerInfo['email']) echo '<a href="mailto:'.$writerInfo['email'].'">[email]</a>'; ?></li>
		</ul>
	</div>

	<div class="text">
		<div class="title"> <strong>글 제목:</strong> <?php echo $subject; ?></div>
		<div class="viewContent">
			<!-- 게시물 내용 출력 -->
			<?php echo $content; ?>

			<!-- 하단 싱크걸기, 추천, 비추, 담기 버튼 출력 -->
			<div id="goodORbad">
				<?php if($isWriter) { ?><a href="#" onclick="window.open('<?php echo $grboard; ?>/sync.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>', 'sinkNET', 'width=10,height=10,menubar=no');" title="이 글을 시리니넷 SinkNET™ 에 싱크(Sync) 합니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_sink.gif" alt="싱크걸기" /></a><?php } ?> 
				<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;good=1" style="color: #386d9f" title="이 글이 좋습니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_good.gif" alt="추천" /></a> 
				<a href="<?php echo $grboard; ?>/view_scrap.php?isAdd=1&amp;id=<?php echo $id; ?>&amp;article_num=<?php echo $articleNo; ?>" onclick="window.open(this.href, 'addScrap', 'width=600,height=650,menubar=no,scrollbars=yes'); return false" style="color: #a25757" title="이 글을 내 스크랩북에 담습니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_scrap.gif" alt="스크랩" /></a> 
				<a href="<?php echo $grboard; ?>/report.php?id=<?php echo $id; ?>&amp;article_num=<?php echo $articleNo; ?>" onclick="window.open(this.href, 'addReport', 'width=600,height=650,menubar=no,scrollbars=yes'); return false" style="color: green" title="이 글을 관리자와 마스터에게 신고합니다."><img src="<?php echo $grboard.'/'.$theme; ?>/image/btn_report.gif" alt="신고" /></a>
			</div>

			<!-- 태그 출력 / 추가 첨부 파일 목록 출력 -->
			<div class="viewTag">
				<p><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_tag.gif" alt="태그" /> <?php echo $tag; ?></p>
				<?php
				$additionalFile = '<p><img src="'.$grboard.'/'.$theme.'/image/disk.gif" alt="첨부파일" /> ';
				// 기본 첨부
				if($fileData['file_route1']) $additionalFile .= showImg($filename1, 1);
				if($fileData['file_route2']) $additionalFile .= showImg($filename2, 2);
				if($fileData['file_route3']) $additionalFile .= showImg($filename3, 3);
				if($fileData['file_route4']) $additionalFile .= showImg($filename4, 4);
				if($fileData['file_route5']) $additionalFile .= showImg($filename5, 5);
				if($fileData['file_route6']) $additionalFile .= showImg($filename6, 6);
				if($fileData['file_route7']) $additionalFile .= showImg($filename7, 7);
				if($fileData['file_route8']) $additionalFile .= showImg($filename8, 8);
				if($fileData['file_route9']) $additionalFile .= showImg($filename9, 9);
				if($fileData['file_route10']) $additionalFile .= showImg($filename10, 10);

				// 추가 첨부
				$extendLoop = 1;
				$getExtendFile = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
				while($extendFile = @mysql_fetch_array($getExtendFile)) { 
					$extendFileName = end(explode('/', $extendFile['file_route']));
					$additionalFile .= showDownImg($extendFileName, $extendFile['no']);
				}
				echo $additionalFile.'</p>';
				?>
			</div>

		</div>

	</div>
</div>