<!-- 목록보기 중앙 실제 리스트들 (루프 돌기) -->
<li class="articleList"><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$grblog.$gb['uid']; ?>"><?php echo stripslashes($gb['subject']); ?></a>
<span>(T: <?php echo $gb['trackback_count'].' / C: '.$gb['comment_count'].' / D: '.date('m.d', $gb['signdate']); ?>)</span></li>