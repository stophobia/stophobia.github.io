<?php 
if(!defined('__GRFORUM__')) exit();

// 스킨 변경하기
if($_POST['start']) {
	$core->query('update ' . $dbFIX . 'view set var = \'' . $_POST['theme'] . '\' where opt = \'layout_skin\' limit 1');
	$core->alert('스킨을 ' . $_POST['theme'] . ' (으)로 변경하였습니다.', './?m=' . $m);
}

// 현재 스킨 가져오기
$skin = $core->getData('select var from ' . $dbFIX . 'view where opt = \'layout_skin\' limit 1');
?>

<h3>포럼 레이아웃 스킨을 선택해 주세요!</h3>
이 곳에서 웹사이트의 전체적인 디자인을 선택하실 수 있습니다.<br />
스킨을 변경하시게 되면, 현재 GR Forum 에서 사용하고 있는 모든 GR Board 게시판들의<br />
상/하단 디자인 서식파일 경로가 지금 선택하신 것에 맞추어 변경됩니다.<br />
<br />
스킨 파일의 대략적인 역할은 아래와 같습니다.
<ul>
	<li>skin.css: 포럼 디자인을 전체적으로 정의합니다.</li>
	<li>preview.gif: 디자인을 미리 볼 수 있도록 만들어진 스냅샷입니다.</li>
	<li>head.php: 포럼 상단 부분의 디자인을 담고 있습니다.</li>
	<li>head.board.php: 포럼에서 게시판 상단 부분의 디자인을 담고 있으며, head.php 파일과 거의 동일하나 GR Core 와 연동되지 않습니다.</li>
	<li>login.php: 중간 영역에서 로그인 화면을 보여줍니다.</li>
	<li>main.php: 중간 영역에서 포럼 최상단 분류 목록을 펼쳐 보여줍니다.</li>
	<li>view.php: 중간 영역에서 같은 부모 분류를 가지는 하위 분류 목록들을 펼칩니다.</li>
	<li>index.php: 스킨의 영역별 디자인 호출 및 동작별 형태 변형을 처리합니다.</li>
	<li>foot.board.php: 포럼에서 게시판 하단 부분의 디자인을 담고 있으며, foot.php 파일과 거의 동일하나 GR Core 와 연동되지 않습니다.</li>
	<li>foot.php: 포럼 하단 부분의 디자인을 담고 있습니다.</li>
</ul>

<form name="skin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="m" value="<?php echo $m; ?>" /><input type="hidden" name="start" value="1" /></div>

<div class="help">
	<p><select name="theme">
		<?php
		$d = opendir('../skin/');
		while($ls = readdir($d)) {
			if($ls == '.' || $ls == '..') continue;
			echo '<option value="' . $ls . '"'.(($ls==$skin['var'])?' selected="selected"':'').'>' . $ls . '</option>';
		}
		closedir($d);
		?>
	</select></p>
	<p>&nbsp;</p>
	<p><input class="s" type="submit" value="위에 지정한 스킨으로 변경하기" /></p>
</div>
</form>

<p>(현재 사용중이신 스킨 ▼)<br />
<img src="../skin/<?php echo $skin['var']; ?>/preview.gif" alt="스킨 미리보기" />
</p>