<?php
/*
	GR Paper 기본스킨 블로그 목록 페이지
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-26
	내  용: 기본스킨의 블로그 목록보기 부분임. head.php 와 foot.php 사이 중간에 불려짐
	참  고: 공개되지 않은 블로그는 목록에 나타나지 않음. (관리자는 목록에서 볼 수 있음)
*/
?>
<table id="blogList" rules="none" summary="GR Paper Blog List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<colgroup>
	<col style="width: 70px" />
	<col style="width: 170px" />
	<col />
	<col style="width: 40px" />
	<col style="width: 40px" />
	<col style="width: 80px" />
</colgroup>
<thead>
<tr>
	<th>소속그룹</th>
	<th>블로그 이름</th>
	<th>블로그 정보</th>
	<th>글 수</th>
	<th>RSS</th>
	<th>마지막 수집</th>
</tr>
</thead>
<tbody>
<?php
while($blog = $getBlogList->fetch_array()) {
	$blogGroup = $c->db->query('select name, info from '.$c->prefix.'feed_group where uid = '.$blog['group_uid'])->fetch_array();
	$groupName = stripslashes($blogGroup['name']);
	$groupInfo = stripslashes($blogGroup['info']);
	$blogName = stripslashes($blog['name']);
	$blogInfo = ($blog['info'])?stripslashes($blog['info']):'<span class="unknown">없음</span>';
	$lastUpdate = date('m/d H:i', $blog['last_update']);
?>
<tr>
	<td title="<?php echo $groupInfo; ?>" class="help"><?php echo $groupName; ?></td>
	<td><a href="http://<?php echo $blog['url']; ?>" title="클릭하시면 이 블로그로 이동합니다."><?php echo $blogName; ?></a></td>
	<td><?php echo $blogInfo; ?></td>
	<td class="num"><?php echo $blog['total']; ?></td>
	<td><a href="http://<?php echo $blog['xml']; ?>" title="클릭하시면 이 블로그의 RSS 를 확인합니다."><img src="<?php echo $themePath; ?>/image/icon_get_rss.gif" alt="RSS" /></a></td>
	<td class="num"><?php echo $lastUpdate; ?></td>
</tr>
<?php } #while

if($paging) { ?><tr><td colspan="6" style="padding: 20px"></td></tr>
<tr><td colspan="6" class="paging"><?php echo $paging; ?></td></tr><?php } ?>
</tbody>
</table>
	