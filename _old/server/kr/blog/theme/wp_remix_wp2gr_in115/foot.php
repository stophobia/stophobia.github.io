<div class="page-nav">
<?php if($p) { ?>
	<div class="nav-previous"><?php 
		echo str_replace(array('<img src="'.$theme.'/list_back_arrow.gif" alt="이전글" />', '이전글이 없습니다.'), array('', '<a href="#">없음</a>'), $prevPost); ?>
	</div>
	<div class="nav-next"><?php 
		echo str_replace(array('<img src="'.$theme.'/list_arrow.gif" alt="다음글" />', '다음글이 없습니다.'), array('', '<a href="#">없음</a>'), $nextPost); ?>
	</div>
<?php } else echo '<div>'.$paging; ?></div>
</div>

<div class="clearfix"></div>

<?php if(!$p) echo '</div>'; ?>

<div class="container-bottom"></div>

<div id="footer">
<div id="footer-wrap">

<p class="copyright">Powered by <a href="http://sirini.net/">GR Blog</a>, <a href="http://cssace.com/free-wp-premium-theme-is-here/">WP Bliss</a> theme by <a href="http://hostwordpress.com/">Best Wordpress Hosts</a>, Converted by <a href="http://sirini.net/blog">sirini</a></p>
<ul id="nav-footer"> 
	<li class="current_page_item"><a href="<?php echo $grblog; ?>" title="처음 화면으로">Home</a></li>
	<li><a href="<?php echo $grblog; ?>photo/" title="포토로그를 엽니다. (단축키: p)" accesskey="p">Photolog</a></li>
	<li><a href="<?php echo $grblog; ?>mono/" title="모노로그를 엽니다. (단축키: m)" accesskey="m">Monolog</a></li>
	<?php 
	// 관리자로 로그인 시
	if($_SESSION['no']) { ?><li><a href="<?php echo $grblog; ?>admin.php?admin=20&inView=adminBox" title="관리자 화면으로 갑니다 (단축키: a)" accesskey="a">Admin</a></li><?php 
	// 로그인 하지 않았을 때
	} else { ?><li><a href="<?php echo $grblog; ?>login.php" title="관리자로 로그인 하러 갑니다 (단축키: i)" accesskey="i">Login</a></li><?php }
	// 모두 보기
	?>
	<li><a href="<?php echo $grblog; ?>article_list.php" title="포스트 목록들을 봅니다. (단축키: t)" accesskey="t">List</a></li>
	<li><a href="<?php echo $grblog; ?>tag.php" title="태그 구름을 봅니다. (단축키: c)" accesskey="c">Tag clouds</a></li>
	<li><a href="<?php echo $grblog; ?>guestbook/" title="방명록을 펼쳐 봅니다. (단축키: g)" accesskey="g">Guestbook</a></li>
</ul>

</div>
</div>

</body>
</html>