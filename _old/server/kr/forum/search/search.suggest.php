<?php
/**
 * GR Forum Search Page
 * @author sirini
 * @update 2009-09-19
 * @comment GR Forum 통합 검색 처리
 * @warning 검색 결과는 HTML 로 바로 반환한다.
 */

// 검색어 확인
if(!$_POST['keyword'] || !$_POST['type'] || !$_POST['limit']) exit();
$keyword = $_POST['keyword'];
$type = $_POST['type'];
$limit = $_POST['limit'];
$selectBBS = $_POST['selectBBS'];

// 코어 / 보드 연동
include '../core.php';
include '../' . $grcore . '/class/common.php';
$core = new Common('../' . $grcore);
$grboard = '../' . $core->config['grboard'];

// 검색하기
$addWhere = '';
if($selectBBS) {
	$bbsArr = @explode('/', $selectBBS);
	$bbsCnt = count($bbsArr)-1;
	$addWhere = ' and (id = \'' . $bbsArr[0] . '\'';
	for($i=1; $i<$bbsCnt; $i++) {
		$addWhere .= ' or id = \'' . $bbsArr[$i] . '\'';
	}
	$addWhere .= ')';
}
$result = '<ul>';
$find = $core->query('select * from ' . $bbsFIX . 'total_' . $type . ' where subject like \'%' . $keyword . '%\'' . $addWhere . ' order by signdate desc limit ' . $limit);
while($f = $core->fetch($find)) {
	$result .= '<li><a href="' . $grboard . '/board.php?id=' . $f['id'] . '&amp;articleNo=' . $f['article_num'] . '">' . stripslashes($f['subject']) . '</a></li>';
	$isLooped = true;
}
if($isLooped) $result .= '</ul>';
else $result .= '<li class="notFound">검색 결과가 없습니다.</li></ul>';
echo $result;
?>