<li class="ComListLi" id="trackback-<?php echo $tb['uid']; ?>">
	<div class="ComListLiTop"></div>

 <span class="ListGrav">
 <img src="<?php echo $grblog.$theme; ?>/images/trackback.icon.gif" alt="" />
 </span>

 <big><?php echo '<a href="'.$tb['url'].'">'.stripslashes($tb['subject']); ?></a></big>
 <small><?php 
	echo date('r', $tb['signdate']); 
	echo ($_SESSION['no']==1)?' <a href="'.$grblog.'admin.php?admin=6&amp;modifyTarget='.$tb['uid'].'">[edit]</a>':'';
 ?></small>

 <span class="ListNr"><?php $commentNumber++; echo $commentNumber; ?></span>
 <span class="ListContent"><?php echo stripslashes($tb['summary']); ?>
 </span>

</li>