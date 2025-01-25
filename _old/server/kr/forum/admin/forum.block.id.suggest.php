<?php 
/**
 * GR Forum Block ID Suggest
 * @author sirini
 * @update 2009-08-01
 * @comment GR Forum 관리화면에서 차단 아이디 입력시 입력값 자동 검색
 * @warning Core 와 처음부터 연동 하고 작업한 뒤 결과는 HTML 로 반환
 */

if(!$_POST['id']) exit();

// 코어 연동
include '../core.php';
include '../' . $grcore . '/class/common.php';
$core = new Common('../' . $grcore);
$id = $_POST['id'];
$result = '<ul>';

// 입력한 값 연관 아이디 검색 후 출력
$blist = $core->query('select id from ' . $bbsFIX . 'member_list where id like \'%' . $id . '%\' limit 10');
while($b = $core->fetch($blist)) {
	$result .= '<li><a href="#" onclick="Forum.paste(\''.$b['id'].'\');" title="클릭하시면 붙여 넣습니다.">' . $b['id'] . '</a></li>';
	$isLooped = true;
}
if($isLooped) $result .= '</ul>';
else $result .= '<li>비슷한 아이디가 없습니다.</li></ul>';

echo $result;
?>
