<?php if($paging) { ?><div class="Nav"><?php echo $paging; ?></div><?php } ?>

</div><!-- End SC -->

<div class="SR">

<div class="SRL">
<div class="Search">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<div><select name="so">
		<option value="subject" <?php echo (($so == 'subject')?'selected="selected"':'');?>>제목</option>
		<option value="content" <?php echo (($st == 'content')?'selected="selected"':'');?>>내용</option>
		<option value="tag" <?php echo (($st == 'tag')?'selected="selected"':'');?>>태그</option>
		<option value="writer" <?php echo (($st == 'writer')?'selected="selected"':'');?>>ID</option>
	</select><input type="text" name="st" class="keyword" /></div>
<div id="buttonsearch"><input name="submit" type="image" class="search" title="Search" src="<?php echo $absPath.$theme; ?>/images/ButtonTransparent.png" alt="Search" /></div>
</form>
</div>

<div class="Syn">
<div class="SynTop"></div>
 <ul>
  <li><a href="<?php echo $absPath; ?>rss">Entries</a> (RSS)</li>
 </ul>
</div>

<?php if ($conf_photolog) { ?>
<div class="Flickr">
  <h2>PhotoStream</h2>
   <?php getPhoto(); ?>
</div>
<?php } 

if($conf_notice) { ?>
<div class="widget widget_categories">
<h2>Notice</h2>
  <?php getNotice(); ?>
</div>
<?php } 

if($conf_category) { ?>
<div class="widget widget_categories">
<h2>Categories</h2>
  <?php getCategory(); ?>
</div>
<?php } 

if($conf_article) { ?>
<div class="widget widget_categories">
<h2>Articles</h2>
  <?php getLatestPost(5, 45); ?>
</div>
<?php } 

if ($conf_comment) { ?>
<div class="widget widget_recent_entries">
<h2>Comments</h2>
  <?php getLatestComment(5, 45); ?>
</div>
<?php } 

if($conf_trackback) { ?>
<div class="widget widget_categories">
<h2>Trackbacks</h2>
  <?php getLatestTrackback(5, 45); ?>
</div>
<?php } 

if($conf_guestbook) { ?>
<div class="widget widget_categories">
<h2>Guestbooks</h2>
  <?php getLatestGuestbook(5, 45); ?>
</div>
<?php } 

if($conf_link) { ?>
<div class="widget widget_categories">
<h2>Links</h2>
  <?php getLink(); ?>
</div>
<?php } 

if($conf_nowConnect) { ?>
<div class="widget widget_categories">
<h2>Now connecting</h2>
	<ul><li>현재 <strong><?php echo getNowVisitNum(); ?></strong> 명 접속중...</li></ul>
</div>
<?php } ?>

</div>

<div class="SRR">

<?php if($conf_twitter_id) { ?>
<h3 class="center"><a href="http://twitter.com/<?php echo $conf_twitter_id; ?>" title="Follow me on Twitter!"><img src="<?php echo $absPath.$theme; ?>/images/twitter.png" alt="" /></a></h3>
	<div id="myTwitter"></div>
<?php } ?>
  
</div></div>