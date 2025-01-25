<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 테마 수정 -->
<div id="all">
	<div class="normalTitle">사용중인 테마수정</div>
	<div id="chooseFile">
		<select name="getFile" onchange="if(this.value) location.href='admin.php?admin=16&mfile=theme/<?php echo $config['theme']; ?>/'+this.value;">
		<option value="">수정할 파일을 선택하세요.</option>
		<?php
		$openFile = @opendir('theme/'.$config['theme']);
		while($f = @readdir($openFile)) {
			if(!ereg('\.php|\.css|\.js', $f)) continue; 
		?>
		<option value="<?php echo $f; ?>"<?php echo (('theme/'.$config['theme'].'/'.$f == $_GET['mfile'])?' selected="selected"':''); ?>><?php echo $f; ?></option>
		<?php } ?>
		</select>
	</div>

	<div id="fileModify">
	<?php if($_GET['mfile']) { ?>
		<form id="modifyFile" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=16">
		<div><input type="hidden" name="fileName" value="<?php echo $_GET['mfile']; ?>" /></div>
		<div><textarea name="content" rows="20"><?php echo @file_get_contents($_GET['mfile']); ?></textarea></div>
		<div class="sendBox"><input type="image" src="image/darkgray/button.write.save.gif" title="테마 수정을 완료 합니다." /></div>
		</form>
		<?php if(!is_writable($_GET['mfile'])) { ?><br /><span style="color: red">※ <?php echo $_GET['mfile']; ?> 파일의 퍼미션(권한)을 707 로 맞추어 주세요!</span><?php } 
	} else { ?>
		<div id="helpBox">
		<span>※ 테마 수정 기능 활용법</span><br />
		<br />
		테마를 FTP프로그램을 통해서 받은 후 수정하여 다시 업로드하는 과정을 생략하고<br />
		웹 상에서 바로 수정할 수 있는 "테마 수정" 기능은 수정할 파일의 퍼미션(권한)이 반드시<br />
		<strong>707</strong>로 맞추어져 있어야 사용 가능한 기능 입니다.<br />
		편한 사용을 위해 아래와 같은 절차를 통해서 테마 수정 기능을 원할히 쓸 수 있도록 세팅합니다.<br />
		<br />
		<ol>
			<li>FTP 프로그램을 실행한다.</li>
			<li>/grblog/theme/<?php echo $config['theme']; ?>/ 로 이동한다.</li>
			<li>모든 파일들의 퍼미션(권한)을 707로 변경한다.</li>
			<li>"테마 수정" 페이지에서 특정 파일을 선택하고, 수정해본다.</li>
			<li>만약 다른 테마를 웹에서 수정하고자 할 경우 위의 1~4 과정을 반복해서 미리 세팅해둔다.</li>
		</ol>
		Windows Server 에서는 위의 세팅과정 없이 파일 수정이 가능 합니다.<br />
		</div>
	<?php } ?>
	</div>
</div>
<!--# 테마 수정 -->