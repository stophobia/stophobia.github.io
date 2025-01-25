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
	
	<?php if($conf_photolog): ?>
	<li id="flickr" class="clearfix"><h5>Photolog</h5>
		<?php getPhoto(); ?>
	</li>
	<?php endif; ?>

	<?php if($conf_monolog): ?>
	<li><h5>Monolog</h5>
		<?php getLatestMonolog(5, 55); ?>
	</li>
	<?php endif; ?>

	<?php if($conf_comment): ?>
	<li><h5>Comments</h5>
		<?php getLatestComment(10, 55); ?>
	</li>
	<?php endif; ?>

	<?php if($conf_trackback): ?>
	<li><h5>Trackbacks</h5>
		<?php getLatestTrackback(5, 55); ?>
	</li>
	<?php endif; ?>

	<li><h5>Categories</h5>
		<?php getCategory(); ?>
	</li>
	
	<?php if($conf_article): ?>
	<li><h5>Recent Articles</h5>
		<?php getLatestPost(10, 55); ?>
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
				
	<li><h5>Search</h5>
		
		<ul>				
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
		</ul>
	
</ul>
<br /><a href="<?php echo $absPath; ?>rss"><img src="<?php echo $absPath.$theme; ?>/img/rss.gif" hspace="22" border="0" /></a>
<br /><br /><br />

</div>

</div></div>

					<div id="footer" class="clearfix">
						<div>
							<br />
								<p>
								Designed by FTL <a href="http://www.freethemelayouts.com/">Wordpress Themes</a> brought to you by <a href="http://smashingmagazine.com/">Smashing Magazine</a> modified for <a href="http://sirini.net/">GR Blog</a> by <a href="http://sirini.net/blog">SIRINI</a>
								</p>
						</div>
						<a href="#top" class="btn btn-footer right">Back to Top</a>
					</div>
				</div>
			</div>
		</div>
	</div></div>

<?php if(!$p && !$config['use_cache']) { ?></body></html><?php } ?>
