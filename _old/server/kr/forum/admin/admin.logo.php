<?php 
if(!defined('__GRFORUM__')) exit(); 

// 업로드 처리
if($_FILES['upload']['size']) {
	$fname = $_FILES['upload']['name'];
	$fype = $_FILES['upload']['type'];
	$fsize = $_FILES['upload']['size'];
	$ftmpname = $_FILES['upload']['tmp_name'];

	@unlink('../' . $logo['var']);

	if(!is_uploaded_file($ftmpname)) $core->alert('파일을 정상적으로 업로드 해 주세요');
	$ftmpname = str_replace('\\\\', '\\', $ftmpname);
	$fname = str_replace(' ', '_', strtolower($fname));

	if(!move_uploaded_file($ftmpname, '../' . $fname)) $core->alert('파일을 업로드하지 못했습니다.');
	$core->query('update '.$dbFIX.'view set var = \''.$fname.'\' where opt = \'logo_pos\' limit 1');
	$core->alert('로고를 변경하였습니다!', './?m=' . $m);
}

// 기존 로고 가져오기
$logo = $core->getData('select var from ' . $dbFIX . 'view where opt = \'logo_pos\' limit 1');
?>

<h3>포럼 사이트의 로고 이미지를 업로드 해 주세요!</h3>
포럼 로고는 사용하시는 포럼 스킨에 따라 보여지는 위치와 최적 사이즈가 달라집니다.<br />
최적 사이즈에 관한 정보는 사용하시는 포럼 스킨 폴더 안에 설명서.txt 파일을 참조하세요!<br />
(기본 스킨인 basic 의 경우 205 x 80 이하 사이즈에 최적화 되어 있습니다.)<br />
<br />

<p><img src="../<?php echo $logo['var']; ?>" alt="기본 포럼 로고" /><br />
(현재 설정된 로고)</p>

<form name="logo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<div><input type="hidden" name="m" value="<?php echo $m; ?>" /></div>

<div class="help"><input class="i" type="file" name="upload" /> <input class="s" type="submit" value="지정한 그림 파일을 올리기" /></div>

</form>