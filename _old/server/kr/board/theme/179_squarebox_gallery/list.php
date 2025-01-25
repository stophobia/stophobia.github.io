<?php
if(!defined('__GRBOARD__')) exit();

if($articleNo) echo '<div style="height: 30px"></div>'; 
$rowPerImg = 4;
?>

<form id="list" method="post" action="<?php echo $grboard; ?>/list_adjust.php">
<div><input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" /></div>
<table rules="none" summary="GR Board Article List" cellpadding="0" cellspacing="0" border="0" style="width: 100%; table-layout: fixed">
<caption></caption>
<thead> 
<tr>
	<th class="titleBar" colspan="<?php echo $rowPerImg; ?>">갤러리</th>
</tr>
</thead>
<tbody>

<?php
// 공지 게시물 목록 출력하기
while($notice = @mysql_fetch_array($getNotice))
{
	// 글쓴이가 멤버고, 네임택이 있다면 닉네임 대신 출력 - modified by dragonkun - 대체 텍스트로 닉네임 사용
	if($notice['member_key'])
	{
		$noticeMemberKey = $notice['member_key'];
		$noticetag = @mysql_fetch_array(mysql_query("select nametag, icon from {$dbFIX}member_list where no = '$noticeMemberKey'"));
		if($noticetag['nametag']) 
			$notice['name'] = '<img src="'.$noticetag['nametag'].'" alt="'.$notice['name'].'" />';
		if($noticetag['icon']) $notice['name'] = '<img src="'.$noticetag['icon'].'" alt="" /> '.$notice['name'];
	}
	// 공지 제목 처리
	$noticeSubject = htmlspecialchars($GR->cutString(stripslashes($notice['subject']), $cutingSubject),ENT_COMPAT,"UTF-8");
	?>
<tr class="hover-notice">
	<td class="list" style="text-align: center" colspan="<?php echo $rowPerImg; ?>">
		<?php if($isCategory) echo '<span class="cat">['.$notice['category'].']</span> '; ?>
		<a href="board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $notice['no']; ?>&amp;page=<?php echo $page; ?>"><strong><?php echo $noticeSubject; ?></strong></a>
	</td>
</tr>

<?php
} # while

// 일반 게시물 목록 출력하기
$photoLoop = 0;
while($list = mysql_fetch_array($getList))
{
	// 블라인드 게시물이면 처리
	if($list['bad'] < -1000) $list['subject'] = $list['content'] = '── 관리자에 의해 블라인드 되었습니다 ──';

	// 글쓴이가 멤버고, 네임택이 있다면 닉네임 대신 출력 - modified by dragonkun - 대체 텍스트로 닉네임 사용
	if($list['member_key'])
	{
		$listtag = @mysql_fetch_array(mysql_query("select nametag, icon from {$dbFIX}member_list where no = '".$list['member_key']."'"));
		if($listtag['nametag']) $list['name'] = '<img src="'.$listtag['nametag'].'" alt="'.$list['name'].'" title="" />';
		else $list['name'] = '<strong>'.$list['name'].'</strong>';
		if($listtag['icon']) $list['name'] = '<img src="'.$listtag['icon'].'" alt="" /> '.$list['name'];
	}

	// 제목 처리
	$listSubject = htmlspecialchars($GR->cutString(stripslashes($list['subject']), $cutingSubject),ENT_COMPAT,"UTF-8"); 
	$listLink = $grboard.'/board.php?id='.$id.'&amp;articleNo='.(($list['board_no'])?$list['board_no']:$list['no']).'&amp;page='.$page.'&amp;searchText='.urlencode($searchText).'&amp;clickCategory='.$clickCategory;

	// 검색어가 있다면 하이라이트
	if($searchText) $listSubject = str_replace($searchText, '<span class="findMe">'.$searchText.'</span>', $listSubject);

	// 첨부파일 #1 의 정보 가져오기
	$getFile1 = @mysql_fetch_array(mysql_query('select file_route1 from '.$dbFIX.'pds_save where id = \''.$id.'\' and article_num = '.$list['no']));
	$ft = end(explode('.', $getFile1['file_route1']));
	if($ft != 'jpg' && $ft != 'gif' && $ft != 'png' && $ft != 'bmp') $getFile1['file_route1'] = $theme.'/image/no_img.jpg';

	if($photoLoop % $rowPerImg == 0) echo '<tr>';
	?>
	<td class="preview">
	<div><a href="<?php echo $getFile1['file_route1']; ?>" onclick="return hs.expand(this)"><img src="<?php echo $grboard; ?>/phpThumb/phpThumb.php?src=../<?php echo $getFile1['file_route1']; ?>&amp;w=100&amp;h=80&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="미리보기" /></a></div>
		<div><?php if($isCategory) { ?><a href="board.php?id=<?php echo $id; ?>&amp;clickCategory=<?php echo urlencode($list['category']); ?>">[<?php echo $list['category']; ?>]</a><?php } // 카테고리 있을 시 출력 ?>
		<a href="<?php echo $listLink; ?>"><?php echo $listSubject; ?></a>
		<?php if($list['comment_count']) { ?>&nbsp; <span class="comment">(<?php echo $list['comment_count']; ?>)</span><?php } ?>
		<?php if($isAdmin) { ?><input type="checkbox" name="box[]" value="<?php echo $list['no']; ?>" /><?php } ?></div>
	</td>
	<?php
	$number--; # 가상번호 감소
	$photoLoop++;
	if($photoLoop % $rowPerImg == 0) echo '</tr>';
} # while
if(($photoLoop % $rowPerImg) != 0) {
	$repeat = $rowPerImg - ($photoLoop % $rowPerImg);
	echo str_repeat('<td></td>', $repeat).'</tr>';
}
?>
</tbody>
</table>
</form>