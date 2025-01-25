<?php if($p) echo '</div>'; ?>

<!-- ## 사이드바 시작 ## -->
<div id="sidebar" class="clearfix">

<div id="sidebarwrap" class="clearfix">

	<div id="l_sidebar" class="clearfix">
		<ul>

		<?php if($conf_notice): ?>
		<li><h2 title="공지사항입니다.">Notice</h2>
			 <?php getNotice(); ?>
		</li>
		<? endif; ?>

		<?php if($conf_category): ?>
		<li class="cate"><h2>Categories</h2>
			<?php getCategory(); ?>
		</li>
		<? endif; ?>

		<?php if($conf_article): ?>
		<li><h2>Recent Articles</h2>
			<?php getLatestPost(20, 70); ?>
		</li>
		<? endif; ?>
		
		<?php if($conf_comment): ?>
		<li><h2>Comments</h2>
			<?php getLatestComment(10, 70); ?>
		</li>
		<?php endif; ?>

		<?php if($conf_trackback): ?>
		<li><h2>Trackbacks</h2>
			<?php getLatestTrackback(5, 70); ?>
		</li>
		<?php endif; ?>

		<?php if($conf_guestbook): ?>
		<li><h2>Guestbooks</h2>
			<?php getLatestGuestbook(5, 70); ?>
		</li>
		<?php endif; ?>

		</ul>
	</div>

	<div id="r_sidebar" class="clearfix">
		<ul>

		<?php if($conf_photolog): ?>
		<li class="photolog"><h2 title="제가 촬영한 사진들을 모아둔 갤러리입니다.">Photolog</h2>
			<?php getPhoto(); ?>
		</li>
		<?php endif; ?>

		<?php if($conf_monolog): ?>
		<li><h2 title="짧게 기록하는 기억들을 모아둔 곳입니다.">Monolog</h2>
			<?php getLatestMonolog(5, 70); ?>
		</li>
		<?php endif; ?>

		<?php if($conf_twitter_id): ?>
		<li><h2><a href="http://twitter.com/<?php echo $conf_twitter_id; ?>" title="제 Twitter 에 올려진 최신글 목록입니다. 클릭하시면 제 Twitter 로 이동합니다.">My Twitter</a></h2>
			<div id="myTwitter"></div>
		</li>
		<?php endif; ?>

		<?php if($conf_link): ?>
		<li><h2 title="이웃 블로그들의 목록입니다.">Links</h2>
			<?php getLink(); ?>
		</li>
		<?php endif; ?>

		<?php if($conf_nowConnect): ?>
		<li><h2>Now connecting</h2>
			<span class="nowConn">현재 <strong><?php echo getNowVisitNum(); ?></strong> 명 접속중...</span>
		</li>
		<?php endif; ?>

		</ul>
	</div>
	 
</div>

</div>