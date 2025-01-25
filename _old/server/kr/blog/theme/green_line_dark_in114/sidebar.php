<?php if($p) { ?>
<!-- 이전글 / 다음글 부분 -->
<div id="prevNextPost">
	<div class="prev">&nbsp;&nbsp;&nbsp; <?php echo $prevPost; ?></div>
	<div class="next"><?php echo $nextPost; ?> &nbsp;</div>
	<div class="clr"></div>
</div>
<?php } ?>

<div id="bottomBack"></div>

<div id="sidebar">

	<!-- 달력 -->
	<?php if($conf_calendar) { ?>
	<div id="calendar" class="sidebar">
	<?php getCalendar(); ?>
	</div>
	<?php } ?>

	<!-- 카테고리 -->
	<?php if($conf_category) { ?>
	<div id="categories" class="sidebar">
	<div class="t">category</div>
	<?php getCategory(); ?>
	</div>
	<?php } ?>

	<!-- 고정 페이지 -->
	<?php if($conf_notice) { ?>
	<div id="notice" class="sidebar">
	<div class="t">notice</div>
	<?php getNotice(); ?>
	</div>
	<?php } ?>


	<!-- 모노로그 -->
	<?php if($conf_monolog) { ?>
	<div id="monologs" class="sidebar">
	<div class="t">monolog</div>
	<?php getLatestMonolog(3, 38); ?>
	</div>
	<?php } ?>
	
	<!-- 포토로그 -->
	<?php if($conf_photolog) { ?>
	<div id="photos">
	<div class="t">photolog</div>
	<?php getPhoto(); ?>
	</div>
	<?php } ?>

	<!-- 최근 포스트 -->
	<?php if($conf_article) { ?>
	<div id="latestArticle" class="sidebar">
	<div class="t">latest article</div>
	<?php getLatestPost(5, 38); ?>
	</div>
	<?php } ?>

	<!-- 최근 코멘트 -->
	<?php if($conf_comment) { ?>
	<div id="latestComment" class="sidebar">
	<div class="t">latest reply</div>
	<?php getLatestComment(5, 38); ?>
	</div>
	<?php } ?>


	<!-- 최근 트랙백 -->
	<?php if($conf_trackback) { ?>
	<div id="latestTrackback" class="sidebar">
	<div class="t">trackbacks</div>
	<?php getLatestTrackback(5, 38); ?>
	</div>
	<?php } ?>

	<!-- 태그 -->
	<?php if($conf_tag) { ?>
	<div id="tags" class="sidebar">
	<div class="t">tags</div>
	<div style="padding-top: 5px"><?php getTag(30, 'count'); ?></div>
	</div>
	<?php } ?>

	<!-- 링크 -->
	<?php if($conf_link) { ?>
	<div id="links" class="sidebar">
	<div class="t">links</div>
	<?php getLink(); ?>
	</div>
	<?php } ?>

	<!-- 방명록 -->
	<?php if($conf_guestbook) { ?>
	<div id="guestBook" class="sidebar">
	<div class="t"><a href="<?php echo $grblog; ?>guestbook/" title="클릭하시면 방명록으로 이동합니다.">guestbook</a></div>
	<?php getLatestGuestbook(5, 38); ?>
	</div>
	<?php } ?>

	<!-- 현재접속자 -->
	<?php if($conf_nowConnect) { ?>
	<div id="nowConnect" class="sidebar">
	<div class="t">now visitor</div>
	<div style="padding-top: 15px; text-align: center" title="검색로봇/광고로봇 등 기계적인 현재 접속을 모두 포함한 추정치입니다."><?php echo getNowVisitNum(); ?>명 접속중...</div>
	</div>
	<?php } ?>

</div>