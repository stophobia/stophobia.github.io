<?php
// 이동할 주소 정하기
$boardTargetID = $_GET['id'];
if($boardTargetID) $move = 'board.php?id='.$boardTargetID;
else $move = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
?>
<div class="loginTitle">Enjoy!</div>
<div class="loginLeft">ID</div>
<div class="loginRight"><?php echo $login['id']; ?></div>
<div class="loginClear"></div>
<div class="loginLeft">Name</div>
<div class="loginRight"><?php echo $login['nickname']; ?></div>
<div class="loginClear"></div>
<div class="loggedTag">(L:<?php echo $login['level']; ?>, P:<?php echo $login['point']; ?>)</div>
<div class="loginAlign"><input type="button" value="로그아웃" class="loginSubmit" onclick="location.href='<?php echo $grboard; ?>/logout.php?page=<?php echo $move; ?>'" />
</div>
