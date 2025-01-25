</div>
<div class="clr"></div>

<?php if($paging) { ?>
<!-- 페이징 -->
<div id="paging"><?php echo $paging; ?></div>
<?php } ?>

<!-- 검색폼 -->
<?php if($conf_search) { ?>
<div class="sidebar">
<form id="searchBlog" method="post" action="<?php echo $grblog; ?>">
<div id="searchForm">
<select name="so">
	<option value="subject" <?php echo (($so == 'subject')?'selected="selected"':'');?>>제목</option>
	<option value="content" <?php echo (($st == 'content')?'selected="selected"':'');?>>내용</option>
	<option value="tag" <?php echo (($st == 'tag')?'selected="selected"':'');?>>태그</option>
	<option value="writer" <?php echo (($st == 'writer')?'selected="selected"':'');?>>ID</option>
</select><input type="text" name="st" value="<?php echo $st; ?>" class="i" /><input type="image" src="<?php echo $grblog.$theme; ?>/image/search.icon.gif" class="s" title="검색합니다." />
</div>
</form>
</div>
<?php } ?>

<!-- 블로그 메뉴 -->
<div id="viewBtns">
	<ul>
		<li><a href="<?php echo $grblog; ?>" title="블로그 첫화면으로 갑니다. (단축키: h)" accesskey="h">Home</a></li>
		<li><a href="<?php echo $grblog; ?>photo/" title="포토로그를 엽니다. (단축키: p)" accesskey="p">Photolog</a></li>
		<li><a href="<?php echo $grblog; ?>mono/" title="모노로그를 엽니다. (단축키: m)" accesskey="m">Monolog</a></li>
		<?php 
		// 관리자로 로그인 시
		if($_SESSION['no']) { ?>
		<li><a href="<?php echo $grblog; ?>write.php" title="블로그에 관리자로 새 글을 작성 합니다. (단축키: w)" accesskey="w">Write</a></li>
		<li><a href="<?php echo $grblog; ?>admin.php?admin=20&inView=adminBox" title="관리자 화면으로 갑니다 (단축키: a)" accesskey="a">Admin</a></li>
		<?php 
		// 로그인 하지 않았을 때
		} else { ?>
		<li><a href="<?php echo $grblog; ?>login.php" title="관리자로 로그인 하러 갑니다 (단축키: i)" accesskey="i">Login</a></li>
		<?php }
		// 일반 멤버로 로그인 시
		if($_SESSION['user_no']) { ?>
		<li><a href="<?php echo $grblog; ?>user/write/" title="멤버 전용 글쓰기 화면으로 가기 (단축키: w)" accesskey="w">Write</a></li>
		<li><a href="<?php echo $grblog; ?>user/admin/" title="멤버 전용 관리자 화면으로 가기 (단축키: a)" accesskey="a">Manage</a></li>
		<?php } elseif(!$_SESSION['no']) { ?>
		<li><a href="<?php echo $grblog; ?>user/login/" title="멤버 전용 로그인 화면으로 가기 (단축키: u)" accesskey="u">Member</a></li>
		<?php } 
		// 모두 보기
		?>
		<li><a href="<?php echo $grblog; ?>article_list.php" title="포스트 목록들을 봅니다. (단축키: t)" accesskey="t">List</a></li>
		<li><a href="mailto:<?php echo $config['email']; ?>" title="관리자에게 메일을 보냅니다. (단축키: e)" accesskey="t">Email</a></li>
		<li><a href="<?php echo $grblog; ?>tag.php" title="태그 구름을 봅니다. (단축키: c)" accesskey="c">Tags</a></li>
		<li><a href="<?php echo $grblog; ?>guestbook/" title="방명록을 펼쳐 봅니다. (단축키: g)" accesskey="g">Guestbook</a></li>
		<li><a href="<?php echo $grblog; ?>rss.php" title="RSS 2.0 피드를 봅니다. (단축키: r)" onclick="window.open(this.href, '_blank'); return false" accesskey="r" style="color: orange">RSS</a></li>
	</ul>
</div>
</div><!-- // end of main -->

<?php if(!$p && !$config['use_cache']) { ?></body></html><?php } ?>