<?php if($nowPos == 'guestbook/index') echo '</div>'; ?>

<div id="sidebar">
  
  <div id="sidebar-top">
    <ul id="top-sidebarwidgets">
      <h2>Navigation</h2>
      <div class="sidebar-top-box">
        
        <div class="box-padding">
          <div class="Nav"><?php if($paging) echo $paging; else echo 'Only one page.'; ?></div>
          <div style="clear:both;"></div>
        </div>

      </div>
    </ul>
  </div>

  <div style="clear:both;"></div>
  
  <div id="sidebar-left">
    <ul id="l_sidebarwidgets">
      <div class="Categ">

		<?php if($conf_category) { ?>
		<h2>Categories</h2>
			<?php getCategory(); ?>
		<br />

		<?php } if($conf_article) { ?>
		<h2>Recent Posts</h2>
		  <?php getLatestPost(5, 45); ?>
		<br />

		<?php } if($conf_comment) { ?> 
		<h2>Recent Comments</h2>
          <?php getLatestComment(5, 45); ?>
        <br/>

		<?php } if($conf_trackback) { ?> 
		<h2>Recent Trackbacks</h2>
          <?php getLatestTrackback(5, 45); ?>
        <br/>

		<?php } if($conf_guestbook) { ?>
		<h2>Guestbooks</h2>
			<?php getLatestGuestbook(5, 45); ?>
		<br />

		<?php } if($conf_link) { ?>
		<h2>Links</h2>
			<?php getLink(); ?>
		<br />

		<?php } if($conf_nowConnect) { ?>
		<h2>Now connecting</h2>
			<ul><li>현재 <strong><?php echo getNowVisitNum(); ?></strong> 명 접속중...</li></ul>
		<?php } ?>

      </div>
    </ul>
  </div>
  
  <div id="sidebar-right">
    <ul id="r_sidebarwidgets">
	  <?php if($conf_twitter_id) { ?>
		<div id="myTwitter"></div>
	  <?php } ?>
	</ul>
  </div>

</div>