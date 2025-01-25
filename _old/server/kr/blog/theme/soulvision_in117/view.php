<?php
	// 본문 출력 전 전처리
	$gb['content'] = str_replace(array('<img src="', '" alt="upload image"', '" alt="previewImg"'), 
		array('<img src="phpThumb/phpThumb.php?src=', '&amp;w=400&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="upload image"','&amp;w=400&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="upload image"'), 	$gb['content']);
?>
<div id="content">
  <div class="postwrap">

    <div class="post" id="post-<?php echo $gb['uid']; ?>" style="padding-bottom: 40px;">
      
	  <div class="posthead">
        <h1><a href="./?p=<?php echo $gb['uid']; ?>"><?php echo $gb['subject']; ?></a></h1>
        <small class="postauthor">Posted by <?php echo $config['name']; ?> 
			<?php if($_SESSION['no']) { ?><a href="./admin.php?admin=2&modifyTarget=<?php echo $gb['uid']; ?>">[modify]</a><?php } ?>
		</small>

        <p class="postdate"> 
			<small class="month"><?php echo date('M', $gb['signdate']); ?></small> 
			<small class="day"><?php echo date('j', $gb['signdate']); ?></small> 
		</p>
      </div>

      <div class="postcontent"><?php echo $gb['content']; ?></div>
      <div class="postinfo">
        <li class="postcat">tags: <?php echo $tagList; ?></li>
		<div class="clearer"></div>
      </div>

    </div>

    <div class="clearer"></div>

	<div id="commentblock">
	  <div class="comment-wrap">
	  <p class="commenttitle"><?php echo ($gb['comment_count']+$gb['trackback_count']); ?></strong> Responses</p>  
		<ol>