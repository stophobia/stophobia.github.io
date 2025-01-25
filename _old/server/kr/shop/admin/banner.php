<?php
if(!defined('__GRSHOP__')) exit();

// 배너 등록시
if($_FILES['banner'] || $_POST['modifyUid']) {
	$getNumber = $core->getData('select uid from '.$shop->prefix.'banners where list_order = '.$_POST['list_order']);
	if(!$_POST['modifyUid'] && $getNumber['uid']) $core->alert($_POST['list_order'].'번은 이미 등록된 순번입니다. 해당 순번의 배너를 수정하세요.', './?menu=5');
	$filename = $_FILES['banner']['name'];
	$filetype = $_FILES['banner']['type'];
	$filesize = $_FILES['banner']['size'];
	$filetmpname = $_FILES['banner']['tmp_name'];
	$addQuery = '';
	if($filesize > 0 && is_uploaded_file($filetmpname)) {
		if(!is_dir('../banner')) {
			@mkdir('../banner');
			@chmod('../banner', 0707);
		}
		if($_POST['modifyUid']) {
			$getOldBanner = $core->getData('select file_route from '.$shop->prefix.'banners where uid = '.$_POST['modifyUid']);
			@unlink('../banner/'.$getOldBanner['file_route']);
		}
		$filetmpname = str_replace('\\\\', '\\', $filetmpname);
		$filename = str_replace(' ', '_', $filename);
		$filename = str_replace('-', '_', $filename);
		$type = @end(explode('.', $filename));
		if($type != 'jpg' && $type != 'gif' && $type != 'png' && $type != 'bmp') $core->alert('그림 파일이 아닙니다.', './?menu=5');	
		if(preg_match("/[가-힣]/uism", $filename)) $filename = md5($filename).'.'.$type;
		if(!move_uploaded_file($filetmpname, '../banner/'.$filename)) $core->alert('로고파일 업로드 실패 : 파일이 너무 크지 않은지 확인해 보세요', './?menu=4');
		$addQuery = 'file_route = \''.$filename.'\', ';
	}
	if($_POST['modifyUid']) $core->query('update '.$shop->prefix.'banners set '.$addQuery.'url = \''.$_POST['url'].'\', list_order = \''.$_POST['list_order'].'\' where uid = '.$_POST['modifyUid']);
	else $core->query('insert into '.$shop->prefix.'banners set uid = \'\', '.$addQuery.'url = \''.$_POST['url'].'\', list_order = \''.$_POST['list_order'].'\'');
	$core->alert('배너를 '.(($_POST['modifyUid'])?'수정':'등록').'하였습니다.', './?menu=5');
}

// 배너 삭제시
if($_GET['deleteTarget']) {
	$file = $core->getData('select file_route from '.$shop->prefix.'banners where uid = '.$_GET['deleteTarget']);
	$core->query('delete from '.$shop->prefix.'banners where uid = '.$_GET['deleteTarget']);
	@unlink('../banner/'.$file['file_route']);
	$core->alert('배너를 삭제하였습니다.', './?menu=5');
}

// 배너 수정시
if($_GET['modifyTarget']) {
	$modify = $core->getData('select * from '.$shop->prefix.'banners where uid = '.$_GET['modifyTarget']);
}
?>

<div id="bannerInfo" class="infoBox">
<strong>GR Shop 배너 관리화면입니다.</strong><br />
이 곳에서 GR Shop 첫화면 등에 보일 배너를 넣을 수 있습니다.<br />
사용하시는 GR Shop 레이아웃 스킨에 따라서, 각 번호별 배너 위치가 제각각 다릅니다.<br />
가령 기본 basic 의 경우 순번이 1번인 배너가 쇼핑몰 우측 상단에 위치하게 되며 최적 크기는 150 x 60 인데<br />
다른 레이아웃 스킨을 사용하실 경우 이 위치나 최적 크기가 다시 달라질 수 있습니다.<br />
<br />
배너의 위치나 최적 크기는 관리자로 로그인한 상태로 GR Shop 첫화면에 접속할 때<br />
우측 하단에 보이는 "레이아웃 설정" 을 클릭하시면 해당 레이아웃의 배너 설정을<br />
확인하실 수 있습니다. (거기에 나와 있는 설명에 맞게 이 곳에서 번호에 맞춰 업로드하시면 됩니다.)<br />
<br />
배너를 클릭할 때 이동할 곳을 적는 부분은 "http://" 부터 시작해서<br />
처음부터 끝까지 적어주세요. 가령 test 라는 GR Board 게시판으로 이동하고자 할 경우에는<br />
http://<?php echo $_SERVER['HTTP_HOST'].'/'.str_replace('../', '', $grboard); ?>/board.php?id=test<br />
위와 같은 방식으로 적어주셔야 합니다.<br />
</div>

<div id="bannerHelp" class="main">

<h2>등록된 배너 목록</h2>

<table rules="none" summary="GR Shop Banner List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 50px">순번</th>
	<th>이미지 미리보기</th>	
	<th style="width: 250px">연결할 페이지 주소</th>
	<th style="width: 50px">수정</th>
	<th style="width: 50px">삭제</th>
</tr>
</thead>
<tbody>
<?php
$loop = 1;
$bannerList = $core->query('select * from '.$shop->prefix.'banners');
while($banner = $core->fetch($bannerList)) {
	$bg = ($loop % 2) ? ' class="bg"': '';
?>
<tr>
	<td<?php echo $bg; ?>><?php echo $banner['list_order']; ?></td>
	<td<?php echo $bg; ?>><img src="../banner/<?php echo $banner['file_route']; ?>" alt="미리보기" /></td>
	<td<?php echo $bg; ?>><a href="<?php echo $banner['url']; ?>" title="클릭하시면 이동할 페이지를 새 탭으로 열어 확인해봅니다." onclick="window.open(this.href, '_blank'); return false"><?php echo $banner['url']; ?></a></td>
	<td<?php echo $bg; ?>><a href="./?menu=5&amp;modifyTarget=<?php echo $banner['uid']; ?>">수정</a></td>
	<td<?php echo $bg; ?>><a href="#" onclick="Banner.remove(<?php echo $banner['uid']; ?>); return false">삭제</a></td>
</tr>
<?php $loop++; } ?>
</tbody>
</table>

<h2>배너 <?php echo (($modify['uid'])?'수정':'등록'); ?>하기</h2>

<form id="addBanner" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?menu=5" onsubmit="return Banner.submit(this);" enctype="multipart/form-data">
<div><input type="hidden" name="modifyUid" value="<?php echo $modify['uid']; ?>" /></div>
<ul class="noneStyle">
	<li><select name="list_order">
	<?php for($i=1; $i<100; $i++) { ?><option value="<?php echo $i; ?>"<?php echo ($i==$modify['list_order'])?' selected="selected"':''; ?>><?php echo $i; ?></option><?php } ?>
	</select> : 순번지정. 사용중이신 레이아웃 스킨에서 번호별 지정된 위치에 배치됩니다. (예: 1번 배너 → 우측 상단, ...) ※ 순번을 중복되게 하지 마세요!</li>
	<li><input class="i" type="text" name="url" value="<?php echo $modify['url']; ?>" /> : 이동할 곳. 배너 클릭시 어디로 이동하게 할지 지정합니다. (http:// 를 붙여주세요)</li>
	<li><input type="file" name="banner" />
	<?php if($modify['uid']) echo '<br /><img src="../banner/'.$modify['file_route'].'" alt="미리보기" />'; ?>
	</li>
</ul>
<input class="s" type="submit" value="저장하기" />
</form>

</div>