<?php
if(!defined('__GRBOARD__')) exit();

if($articleNo) echo '<div style="height: 30px"></div>'; 
?>
<img src="http://yoshikawa.crewja.com/images/pic-information.jpg" style="position:absolute; top:79px; right:99px" />
<form id="list" method="post" action="<?php echo $grboard; ?>/list_adjust.php">
<div><input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" /></div>
<table class="news-list" rules="none" summary="GR Board Article List" cellpadding="0" cellspacing="0" border="0">
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
	<td class="no" colspan="2"><img src="<?php echo $grboard.'/'.$theme; ?>/image/icon_notice.gif" alt="Notice" /></td>
	<td class="list" colspan="5">
		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $notice['no']; ?>&amp;page=<?php echo $page; ?>"><strong><?php echo $noticeSubject; ?></strong></a>
	</td>
</tr>
	<?php
} # while

// 일반 게시물 목록 출력하기
while($list = mysql_fetch_array($getList))
{
	// 블라인드 게시물이면 처리
	if($list['bad'] < -1000) $list['subject'] = $list['content'] = '── 관리자에 의해 블라인드 되었습니다 ──';

	// 글쓴이가 멤버고, 네임택이 있다면 닉네임 대신 출력 - modified by dragonkun - 대체 텍스트로 닉네임 사용
	if($list['member_key'])
	{
		$listtag = @mysql_fetch_array(mysql_query("select nametag, icon from {$dbFIX}member_list where no = '".$list['member_key']."'"));
		if($listtag['nametag']) $list['name'] = '<img src="'.$grboard.'/'.$listtag['nametag'].'" alt="'.$list['name'].'" title="" />';
		else $list['name'] = '<strong>'.$list['name'].'</strong>';
		if($listtag['icon']) $list['name'] = '<img src="'.$grboard.'/'.$listtag['icon'].'" alt="" /> '.$list['name'];
	}

	// 제목 처리
	$listSubject = htmlspecialchars($GR->cutString(stripslashes($list['subject']), $cutingSubject),ENT_COMPAT,"UTF-8"); 
	$listLink = $grboard.'/board.php?id='.$id.'&amp;articleNo='.(($list['board_no'])?$list['board_no']:$list['no']).'&amp;page='.$page.'&amp;searchText='.urlencode($searchText).'&amp;clickCategory='.$clickCategory;

	// 검색어가 있다면 하이라이트
	if($searchText) $listSubject = str_replace($searchText, '<span class="findMe">'.$searchText.'</span>', $listSubject);
	?>
<tr class="hover">
	<td class="no" colspan="2"><?php echo $number; ?></td>
	<td class="list">&nbsp;&nbsp;
		<a href="<?php echo $listLink; ?>"><?php echo $listSubject; ?></a>
		<?php if($list['comment_count']) { ?>&nbsp; <span class="comment">(<?php echo $list['comment_count']; ?>)</span><?php } ?>
	</td>
	<td class="date"><?php echo date('m.d', $list['signdate']); ?></td>
</tr>
	<?php
		$number--; # 가상번호 감소
} # while
?>
</tbody>
</table>
</form>