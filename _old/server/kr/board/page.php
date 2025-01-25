<?php
$grboard = '.';
include $grboard . '/include.php';
$bbsId = str_replace('--', '', addslashes($_GET['id']));

// 지정된 opt 값에 맞는 var 를 가져오기
function getVar($opt) {
	global $dbFIX;
	$result = @mysql_fetch_array(mysql_query('select var from '.$dbFIX.'layout_config where opt = \''.$opt.'\''));
	return ($result['var']) ? $result['var'] : false;
}

// 페이지에서 사용할 변수 부르기
$getConfigList = array('theme', 'title', 'logo', 'useOutlogin', 'outlogin', 'usePoll', 'poll');
$countList = count($getConfigList);
$config = array();
for($i=0; $i<$countList; $i++) $config[$getConfigList[$i]] = getVar($getConfigList[$i]);
$content = @mysql_fetch_array(mysql_query('select var from '.$dbFIX.'layout_config where opt = \'page\' and var like \''.$bbsId.'|%\''));
$content = str_replace($bbsId.'|', '', $content['var']);
$path = 'layout/'.$config['theme'];
include 'layout/'.$config['theme'].'/head.page.php';
?>
<div id="mainFrame"><?php echo $content; ?></div>

<div class="clear"></div>
<?php
include 'layout/'.$config['theme'].'/foot.page.php';
?>