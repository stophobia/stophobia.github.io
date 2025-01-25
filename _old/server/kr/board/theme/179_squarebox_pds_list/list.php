<?php
if(!defined('__GRBOARD__')) exit();

if($articleNo) echo '<div style="height: 30px"></div>'; 
$colspan = 9;
if($isAdmin) $colspan++;
?>

<form id="list" method="post" action="<?php echo $grboard; ?>/list_adjust.php">
<div><input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" /></div>
<table rules="none" summary="GR Board Article List" cellpadding="0" cellspacing="0" border="0" style="width: 100%; table-layout: fixed">
<caption></caption>
<thead> 
<tr>
	<th class="titleLeft"></th>
	<th class="titleBar" style="width: 40px"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=no&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>">번호</a></th>
	<?php if($isAdmin) { ?><th class="titleBar" style="width: 40px"><a href="#" onclick="selectAll();" class="listTopBox">담기</a></th><?php } 
	if($isCategory) { ?><th class="titleBar" style="width: 80px"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=category&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>">분류</a></th><?php } ?>
	<th class="titleBar" style="width: 60px"><a href="#">크기</a></th>
	<th class="titleBar"><a href="board.php?id=<?php echo $id; ?>&amp;sortList=subject&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>">자료명</a></th>
	<th class="titleBar" style="width: 85px"><a href="board.php?id=<?php echo $id; ?>&amp;sortList=name&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>">올린이</a></th>
	<th class="titleBar" style="width: 40px"><a href="#">받기</a></th>
	<th class="titleBar" style="width: 40px"><a href="board.php?id=<?php echo $id; ?>&amp;sortList=hit&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>">받음</a></th>
	<th class="titleRight"></th>
</tr>
</thead>
<tbody>
<?php 
## 상단 카테고리바 시작
if($isCategory) { 
	$totalCategoryNumber = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'bbs_'.$id));
	$showCategory = '<a href="board.php?id='.$id.'">전체</a> ('.$totalCategoryNumber[0].') | ';
	$categories = @mysql_fetch_array(mysql_query('select category from '.$dbFIX.'board_list where id = \''.$id.'\''));
	$categoryArray = @explode('|', $categories['category']);
	$countCategory = @count($categoryArray);
	for($ca=0; $ca<$countCategory; $ca++) {
		$categoryNumber = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'bbs_'.$id.' where category = \''.$categoryArray[$ca].'\''));
		$showCategory .= '<a href="board.php?id='.$id.'&amp;clickCategory='.urlencode($categoryArray[$ca]).'">'.$categoryArray[$ca].'</a> ('.$categoryNumber[0].') | ';
	}
	$showCategory = substr($showCategory, 0, -2);
	?>
<tr>
	<td colspan="<?php echo $colspan; ?>" class="categoryBar"><?php echo $showCategory; ?></td>
</tr>
<?php
}

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
	<?php if($isAdmin) { ?>
		<td class="name"><input type="checkbox" name="box[]" value="<?php echo $notice['no']; ?>" /></td>
	<?php } if($isCategory) { ?>
		<td class="category"><?php echo $notice['category']; ?></td>
	<?php } ?>
	<td class="list" colspan="6" style="text-align: center">
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

	// 첨부파일 #1 의 정보 가져오기
	$getFile1 = @mysql_fetch_array(mysql_query('select file_route1, hit from '.$dbFIX.'pds_save where id = \''.$id.'\' and article_num = '.$list['no']));
	$fileSize = fsize(filesize($getFile1['file_route1']));
	if($ft != 'jpg' && $ft != 'gif' && $ft != 'png' && $ft != 'bmp') $getFile1['file_route1'] = $theme.'/image/no_img.jpg';
	?>
<tr class="hover">
	<td class="no" colspan="2"><?php echo $number; ?></td>
	<?php if($isAdmin) { ?><td class="no"><input type="checkbox" name="box[]" value="<?php echo $list['no']; ?>" /></td>
	<?php } if($isCategory) { ?>
	<td class="category">
		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;clickCategory=<?php echo urlencode($list['category']); ?>"><?php echo $list['category']; ?></a>
	</td>
	<?php } ?>
	<td class="filesize"><?php echo $fileSize; ?></td>
	<td class="list">&nbsp;&nbsp;
	<?php if($list['is_secret']) { ?><img src="<?php echo $theme; ?>/image/secret.gif" alt="비밀" /><?php } // 비밀글일 때	 아이콘
	elseif(time() < $list['signdate']+86400) { ?><img src="<?php echo $theme; ?>/image/new.gif" alt="새글" /><?php } // 공지글일 때 아이콘
	else { ?><img src="<?php echo $theme; ?>/image/arrow.gif" alt="" /><?php } // 아무것도 아닐 때 아이콘 ?>
		<a href="<?php echo $listLink; ?>"><?php echo $listSubject; ?></a>
		<?php if($list['comment_count']) { ?>&nbsp; <span class="comment">(<?php echo $list['comment_count']; ?>)</span><?php } ?>
		<?php if($list['hit'] > 300) { ?> <img src="<?php echo $theme; ?>/image/icon_hot_article.gif" alt="" /><?php } // 조회수 300 이상일 경우 아이콘 출력 ?>
	</td>
	<td class="name"><span onclick="getMember(<?php echo (($list['member_key'])?$list['member_key']:0).','.(($_SESSION['no'])?$_SESSION['no']:0); ?>, event);"><?php echo $list['name']; ?></span></td>
	<td class="down"><a href="download.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $list['no']; ?>&amp;num=1" title="클릭하시면 첨부된 파일을 내려 받습니다."><img src="<?php echo $theme; ?>/image/disk.gif" alt="down" /></a></td>
	<td class="no"><?php echo $getFile1['hit']; ?></td>
</tr>
	<?php
		$number--; # 가상번호 감소
} # while
?>
</tbody>
</table>
</form>