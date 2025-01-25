<?php if($p) echo '</div>'; # 글보기일 때 출력 ?>

		<div class="clearfix pagination bluegray">
		<?php echo $paging; ?>
		</div>
	</div>
</div>

<div id="right-col">

	<div id="logo">
		<h1><?php echo $blogTitle; ?></h1>
	</div>

	<ul id="right-content">
		<li><h5>About</h5>
			<?php echo $blogInfo; ?>
		</li>

	<?php if($conf_notice): ?>
	<li><h5>Notice</h5>
		<?php getNotice(); ?>
	</li>
	<?php endif; ?>

	<?php if($conf_calendar): ?>
	<li class="calendar">
		<?php getCalendar(); ?>
	</li>
	<?php endif; ?>
	
	<?php if($conf_photolog): ?>
	<li id="flickr" class="clearfix"><h5>Photolog</h5>
		<?php getPhoto(); ?>
	</li>
	<?php endif; ?>

	<?php if($conf_monolog): ?>
	<li><h5>Monolog</h5>
		<?php getLatestMonolog(5, 42); ?>
	</li>
	<?php endif; ?>

	<?php if($conf_comment): ?>
	<li><h5>Comments</h5>
		<?php getLatestComment(10, 42); ?>
	</li>
	<?php endif; ?>

	<?php if($conf_trackback): ?>
	<li><h5>Trackbacks</h5>
		<?php getLatestTrackback(5, 42); ?>
	</li>
	<?php endif; ?>

	<li><h5>Categories</h5>
		<?php getCategory(); ?>
	</li>
	
	<?php if($conf_article): ?>
	<li><h5>Recent Articles</h5>
		<?php getLatestPost(10, 42); ?>
	</li>
	<? endif; ?>

	<?php if($conf_link): ?>
	<li><h5>Links</h5>
		<?php getLink(); ?>
	</li>
	<?php endif; ?>

	<?php if($conf_nowConnect): ?>
	<li><h5>Now connecting</h5>
		현재 <strong><?php echo getNowVisitNum(); ?></strong> 명 접속중...
	</li>
	<?php endif; ?>
				
	<li>	
		<div class="box">

		<form id="searchBlog" method="post" action="<?php echo $grblog; ?>">
		<div id="searchForm">
		<select name="so">
			<option value="subject" <?php echo (($so == 'subject')?'selected="selected"':'');?>>제목</option>
			<option value="content" <?php echo (($st == 'content')?'selected="selected"':'');?>>내용</option>
			<option value="tag" <?php echo (($st == 'tag')?'selected="selected"':'');?>>태그</option>
			<option value="writer" <?php echo (($st == 'writer')?'selected="selected"':'');?>>ID</option>
		</select><input type="text" value="<?php echo $st; ?>" name="st" class="text" size="30" />
		<div style="padding-top: 15px"><input type="submit" id="searchsubmit" value="Search" class="btn submit btn-green" /></div>
		</div>
		</form>

		</div>
	</li>
	<li><a href="<?php echo $absPath; ?>rss" title="RSS 로 편하게 구독하실 수 있습니다~!"><img src="<?php echo $absPath.$theme; ?>/images/rss.png" alt="RSS Feed" onmouseover="this.src='<?php echo $absPath.$theme; ?>/images/rss_over.png'" onmouseout="this.src='<?php echo $absPath.$theme; ?>/images/rss.png'" /></a></li>
	
</ul>

</div>

</div></div>

				</div>
			</div>
		</div>
	</div></div>

<?php if(!$p && !$config['use_cache']) { ?></body></html><?php } ?>
