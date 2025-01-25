<?php if($p) { ?>
<!-- 이전글 / 다음글 부분 -->
<div id="prevNextPost">
	<div class="prev">&nbsp;&nbsp;&nbsp; <?php echo $prevPost; ?></div>
	<div class="next"><?php echo $nextPost; ?> &nbsp;</div>
	<div class="clr"></div>
</div>
<div class="bottomBack"></div>
<?php } if(!isset($ds)) { ?><div class="bottomBack"></div><?php } ?>

<?php if($paging) { ?>
<!-- 페이징 -->
<div id="paging"><?php echo $paging; ?></div>
<?php } ?>

<div id="sidebar">

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
	<?php getLatestMonolog(5, 28); ?>
	</div>
	<?php } ?>
	
	<!-- 최근 코멘트 -->
	<?php if($conf_comment) { ?>
	<div id="latestComment" class="sidebar">
	<div class="t">latest reply</div>
	<?php getLatestComment(5, 28); ?>
	</div>
	<?php } ?>

	<!-- 최근 트랙백 -->
	<?php if($conf_trackback) { ?>
	<div id="latestTrackback" class="sidebar">
	<div class="t">trackbacks</div>
	<?php getLatestTrackback(5, 28); ?>
	</div>
	<?php } ?>

	<!-- 방명록 -->
	<?php if($conf_guestbook) { ?>
	<div id="guestBook" class="sidebar">
	<div class="t"><a href="<?php echo $grblog; ?>guestbook/" title="클릭하시면 방명록으로 이동합니다.">guestbook</a></div>
	<?php getLatestGuestbook(5, 28); ?>
	</div>
	<?php } ?>

	<div class="clr"></div>

</div>
