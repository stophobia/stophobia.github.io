<?php
// 기본 클래스를 부른다
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 관리자가 아니면 볼 수 없다.
if(!$_SESSION['no']) exit();
$id = $_POST['id'];
if(!$id) $id = $_GET['id'];
$isAdmin = 0;
if($_SESSION['no'] == 1) $isAdmin = 1; else $isAdmin = 0;
$getMasters = @mysql_fetch_array(mysql_query('select master, group_no from '.$dbFIX.'board_list where id = \''.$id.'\''));

// 게시판 관리자
if($getMasters[0]) {
	$masterArr = explode('|', $getMasters[0]);
	$masterNum = count($masterArr);
	for($m=0; $m<$masterNum; $m++) {
		if($_SESSION['mId'] && ($_SESSION['mId'] == $masterArr[$m])) {
			$isAdmin = 1;
			break;
		}
	}
}
// 그룹 관리자
if($getMasters[1]) {
	$getGroupMaster = @mysql_fetch_array(mysql_query('select master from '.$dbFIX.'group_list where no = '.$getMasters[1]));
	$groupMaster = explode('|', $getGroupMaster[0]);
	$cntResult = count($groupMaster);
	for($g=0; $g<$cntResult; $g++) {
		if($_SESSION['mId'] && ($_SESSION['mId'] == $groupMaster[$g])) {
			$isAdmin = 1;
			break;
		}
	}
}
if(!$isAdmin) $GR->error('관리자만이 볼 수 있습니다.', 1, 'board.php?id='.$id);

// 변수 처리
$maxDefaultField = 22;
if(array_key_exists('exec', $_GET)) $exec = $_GET['exec'];
if(array_key_exists('exec', $_POST)) $exec = $_POST['exec'];
if($exec) {
	$id = $_GET['id'];
	$selectArticle = $_GET['selectArticle'];
} else {
	$id = $_POST['id'];
	$box = $_POST['box'];
	$selectArticle = "";
	$boxSize = count($box);
	for($tb=0; $tb<$boxSize; $tb++) $selectArticle .= $box[$tb].';';
}
$grboard = str_replace('/list_adjust.php', '', $_SERVER['PHP_SELF']);
$pathArr = @explode('/', $grboard);
if(count($pathArr) > 1) $grboard = '/'.$pathArr[1];

// 문서설정
$title = 'GR Board Article Adjust Page';
$encoding = 'utf-8';
include 'html_head.php';
?>
<body>
<!-- 중앙배열 -->
<div id="installBox">

	<!-- 폭 설정 -->
	<div class="sizeFix">

		<!-- 타이틀 -->
		<div class="bigTitle">Article adjust</div>

		<!-- 게시물관리 보기 박스 -->
		<div id="admMenuTable">
			<div style="padding: 10px">선택한 게시물 관리</div>
			<div class="menu" onmouseover="Over(this);" onmouseout="Out(this);"><a href="javascript:isDeleteOk();" onfocus="this.blur()" title="선택한 게시물들을 삭제합니다"><img src="image/admin/arrow.gif" alt="" /> 삭제</a></div>
			<div class="menu" onmouseover="Over(this);" onmouseout="Out(this);"><a href="<?php echo $grboard; ?>/list_adjust.php?exec=move&amp;id=<?php echo $id; ?>&amp;selectArticle=<?php echo $selectArticle; ?>" title="선택한 게시물들을 이동합니다"><img src="image/admin/arrow.gif" alt="" /> 이동</a></div>
			<div class="menu" onmouseover="Over(this);" onmouseout="Out(this);"><a href="<?php echo $grboard; ?>/list_adjust.php?exec=copy&amp;id=<?php echo $id; ?>&amp;selectArticle=<?php echo $selectArticle; ?>" title="선택한 게시물들을 복사합니다"><img src="image/admin/arrow.gif" alt="" /> 복사</a></div>
			<div class="menu" onmouseover="Over(this);" onmouseout="Out(this);"><a href="<?php echo $grboard; ?>/list_adjust.php?exec=category&amp;id=<?php echo $id; ?>&amp;selectArticle=<?php echo $selectArticle; ?>" title="선택한 게시물들의 카테고리를 변경합니다."><img src="image/admin/arrow.gif" alt="" /> 카테고리 변경</a></div>
		</div><!--# 게시물관리 보기 박스 -->

		<!-- 우측 몸통 부분 -->
		<div id="admBody">

		<?php if(!$exec) { ?>
		<div class="mvBack" id="admSelectedList">
			<div class="mv">선택된 게시물 목록</div>
			<ul>
			<?php
			$countBox = count($box);
			for($g=0; $g<$countBox; $g++) {
				$articleNo = $box[$g];
				$deleteList = @mysql_fetch_array(mysql_query("select subject from {$dbFIX}bbs_{$id} where no = '$articleNo'"));
				echo '<li>'.stripslashes($deleteList['subject']).'</li>';
			}
			?>
			</ul>
		</div>

		<!-- 위아래 공백 -->
		<div class="vSpace"></div>

		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>" title="게시판으로 돌아갑니다." style="font-weight:bold;">[게시판으로 돌아가기]</a>

		<?php
		}
		// 게시물들 삭제
		elseif($exec == 'delete') {
			$tempArray = explode(';', $selectArticle);
			$countTmpArr = count($tempArray);
			for($g=0; $g<$countTmpArr; $g++) {
				$articleNo = $tempArray[$g];
				@mysql_query("delete from {$dbFIX}bbs_{$id} where no = '$articleNo'");
				@mysql_query("delete from {$dbFIX}comment_{$id} where board_no = '$articleNo'");
				@mysql_query("delete from {$dbFIX}total_article where id = '$id' and article_num = '$articleNo'");
				@mysql_query("delete from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'");
				@mysql_query("delete from {$dbFIX}total_comment where id = '$id' and article_num = '$articleNo'");
				@mysql_query("delete from {$dbFIX}time_bomb where id = '$id' and article_num = '$articleNo'");
				$files = @mysql_fetch_array(mysql_query("select * from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'"));
				if($files['no']) {
					for($f=1; $f<11; $f++) {
						$fileRoute = 'file_route'.$f;
						if($files[$fileRoute]) @unlink($files[$fileRoute]); 
					}
				} # if
				$getExtendFiles = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
				while($extFiles = @mysql_fetch_array($getExtendFiles)) {
					@unlink($extFiles['file_route']);
					@mysql_query('delete from '.$dbFIX.'pds_list where type = 1 and uid = '.$extFiles['no']);
				}
				@mysql_query('delete from '.$dbFIX.'pds_list where type = 0 and uid = '.$files['no']);
				@mysql_query('delete from '.$dbFIX."pds_extend where id = '$id' and article_num = '$articleNo'");
				@mysql_query("delete from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
				@mysql_query("delete from {$dbFIX}total_article where id = '$id' and article_num = '$articleNo'");
				@mysql_query("delete from {$dbFIX}total_comment where id = '$id' and article_num = '$articleNo'");
			} # for

			$GR->error('선택된 게시물을 모두 삭제했습니다.', 0, 'board.php?id='.$id);
		} # delete

		// 게시물들 이동
		elseif($exec == 'move') {
			if(array_key_exists('moveAction', $_POST)) {
				$id = $_POST['id'];
				$selectArticle = $_POST['selectArticle'];
				$moveTarget = $_POST['moveTarget'];
				$moveTargetID = str_replace($dbFIX.'bbs_', '', $moveTarget);
				$tempArray = explode(';', $selectArticle);
				sort($tempArray, SORT_NUMERIC);
				$totalArray = count($tempArray);

				for($g=1; $g<$totalArray; $g++) {
					$articleNo = $tempArray[$g];
					$moveData = @mysql_fetch_array(mysql_query("select * from {$dbFIX}bbs_{$id} where no = '$articleNo'"));

					$moveMemberKey = $moveData['member_key'];
					$moveName = $moveData['name'];
					$movePassword = $moveData['password'];
					$moveEmail = $moveData['email'];
					$moveHomepage = $moveData['homepage'];
					$moveIp = $moveData['ip'];
					$moveSigndate = $moveData['signdate'];
					$moveHit = $moveData['hit'];
					$moveGood = $moveData['good'];
					$moveBad = $moveData['bad'];
					$moveCommentCount = $moveData['comment_count'];
					$moveIsNotice = $moveData['is_notice'];
					$moveIsSecret = $moveData['is_secret'];
					$moveCategory = $moveData['category'];
					$moveSubject = $moveData['subject'];
					$moveContent = $moveData['content'];
					$moveLink1 = $moveData['link1'];
					$moveLink2 = $moveData['link2'];
					$moveTrackback = $moveData['trackback'];
					$moveTag = $moveData['tag'];

					$addExtendField = '';
					$getExtendField = @mysql_query('select * from '.$dbFIX.'bbs_'.$id.' where no = '.$articleNo);
					$numField = @mysql_num_fields($getExtendField);
					$targetExtendCheck = @mysql_num_fields(mysql_query('select * from '.$moveTarget.' limit 1'));
					if(($numField > $maxDefaultField) && ($numField == $targetExtendCheck)) {
						for($f=$maxDefaultField; $f<$numField; $f++) {
							$fields = @mysql_fetch_field($getExtendField, $f);
							$addExtendField .= ', '.$fields->name.' = \''.$moveData[$fields->name].'\'';
						}
					}

					$insertArticleQue = "insert into {$moveTarget}
						set no = '',
						member_key = '$moveMemberKey',
						name = '$moveName',
						password = '$movePassword',
						email = '$moveEmail',
						homepage = '$moveHomepage',
						ip = '$moveIp',
						signdate = '$moveSigndate',
						hit = '$moveHit',
						good = '$moveGood',
						bad = '$moveBad',
						comment_count = '$moveCommentCount',
						is_notice = '$moveIsNotice',
						is_secret = '$moveIsSecret',
						category = '$moveCategory',
						subject = '$moveSubject',
						content = '$moveContent',
						link1 = '$moveLink1',
						link2 = '$moveLink2',
						trackback = '$moveTrackback',
						tag = '$moveTag'
						$addExtendField
						";
					@mysql_query($insertArticleQue);
					$insertNo = mysql_insert_id();
					@mysql_query("delete from {$dbFIX}bbs_{$id} where no = '$articleNo'");

					$getOldComment = @mysql_query("select * from {$dbFIX}comment_{$id} where board_no = '$articleNo'");
					while($moveComment = mysql_fetch_array($getOldComment)) {
						$mvNo = $moveComment['no'];
						$mvFamilyNo = $moveComment['family_no'];
						$mvThread = $moveComment['thread'];
						$mvIsGrcode = $moveComment['is_grcode'];
						$mvMemberKey = $moveComment['member_key'];
						$mvName = $moveComment['name'];
						$mvPassword = $moveComment['password'];
						$mvEmail = $moveComment['email'];
						$mvHomepage = $moveComment['homepage'];
						$mvIp = $moveComment['ip'];
						$mvSigndate = $moveComment['signdate'];
						$mvGood = $moveComment['good'];
						$mvBad = $moveComment['bad'];
						$mvSubject = $moveComment['subject'];
						$mvContent = $moveComment['content'];

						$insertArticleQue = "insert into {$dbFIX}comment_{$moveTargetID}
							set no = '',
							board_no = '$insertNo',
							family_no = '$mvFamilyNo',
							thread = '$mvThread',
							member_key = '$mvMemberKey',
							is_grcode = '$mvIsGrcode',
							name = '$mvName',
							password = '$mvPassword',
							email = '$mvEmail',
							homepage = '$mvHomepage',
							ip = '$mvIp',
							signdate = '$mvSigndate',
							good = '$mvGood',
							bad = '$mvBad',
							subject = '$mvSubject',
							content = '$mvContent'";
						@mysql_query($insertArticleQue);
						@mysql_query("delete from {$dbFIX}comment_{$id} where no = '$mvNo'");
					}

					$moveFile = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'pds_save where id = \''.$id.'\' and article_num = '.$articleNo));

					$mvFileRoute1 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route1']);
					$mvFileRoute2 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route2']);
					$mvFileRoute3 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route3']);
					$mvFileRoute4 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route4']);
					$mvFileRoute5 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route5']);
					$mvFileRoute6 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route6']);
					$mvFileRoute7 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route7']);
					$mvFileRoute8 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route8']);
					$mvFileRoute9 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route9']);
					$mvFileRoute10 = str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $moveFile['file_route10']);
					
					if(!is_dir('data/'.$moveTargetID)) {
						@mkdir('data/'.$moveTargetID, 0705);
						@chmod('data/'.$moveTargetID, 0707);
					}

					$mvFileRoute = array();
					for($mf=1; $mf<11; $mf++) {
						$fileRoute = 'file_route'.$mf;
						if($moveFile[$fileRoute]) {
							$filename = end(explode('/', $moveFile[$fileRoute]));
							$afterMoveRoute = 'data/'.$moveTargetID.'/'.$filename;
							if(file_exists($afterMoveRoute)) $afterMoveRoute = 'data/'.$moveTargetID.'/'.substr(md5($GR->grTime()), -3).'_'.$filename;
							@copy($moveFile[$fileRoute], $afterMoveRoute);
							@unlink($moveFile[$fileRoute]);
							$mvFileRoute[$mf] = $afterMoveRoute;
						}
					}

					@mysql_query('update '.$dbFIX.'pds_save set id = \''.$moveTargetID.'\', article_num = '.$insertNo.
						", file_route1 = '$mvFileRoute[1]', file_route2 = '$mvFileRoute[2]', file_route3 = '$mvFileRoute[3]'".
						", file_route4 = '$mvFileRoute[4]', file_route5 = '$mvFileRoute[5]', file_route6 = '$mvFileRoute[6]'".
						", file_route7 = '$mvFileRoute[7]', file_route8 = '$mvFileRoute[8]', file_route9 = '$mvFileRoute[9]'".
						", file_route10 = '$mvFileRoute[10]' where no = ".$moveFile['no'].' limit 1');
					
					$getReals = @mysql_query('select * from '.$dbFIX.'pds_list where type = 0 and uid = '.$moveFile['no']);
					while($rf = @mysql_fetch_array($getReals)) {
						@mysql_query('update '.$dbFIX.'pds_list set name = \''.str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $rf['name']).'\' where no = '.$rf['no']);
					}

					$getExtendFiles = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
					while($extFiles = @mysql_fetch_array($getExtendFiles)) {
						$fileName = end(explode('/', $extFiles['file_route']));
						if(file_exists('data/'.$moveTargetID.'/'.$fileName)) $mvPath = 'data/'.$moveTargetID.'/'.substr(md5($GR->grTime()), -3).$fileName;
						else $mvPath = 'data/'.$moveTargetID.'/'.$fileName;
						@copy($extFiles['file_route'], $mvPath);
						@unlink($extFiles['file_route']);
						@mysql_query("update {$dbFIX}pds_extend set id = '$moveTargetID', article_num = '$insertNo', file_route = '$mvPath' where no = ".$extFiles['no']);
						
						$getRealName = @mysql_fetch_array(mysql_query('select no, name from '.$dbFIX.'pds_list where type = 1 and uid = '.$extFiles['no'].' limit 1'));
						@mysql_query('update '.$dbFIX.'pds_list set name = \''.str_replace('/'.$id.'/', '/'.$moveTargetID.'/', $getRealName['name']).'\' where no = '.$getRealName['no'].' limit 1');
					}
					@mysql_query("update {$dbFIX}total_article set id = '$moveTargetID', article_num = '$insertNo' where id = '$id' and article_num = '$articleNo'");
					@mysql_query("update {$dbFIX}total_comment set id = '$moveTargetID', article_num = '$insertNo' where id = '$id' and article_num = '$articleNo'");
					@mysql_query("update {$dbFIX}time_bomb set id = '$moveTargetID', article_num = '$insertNo' where id = '$id' and article_num = '$articleNo'");
				}
				$GR->error('게시물을 성공적으로 이동했습니다.', 0, 'board.php?id='.$id);
			}
		?>
		<form name="moveArticle" onsubmit="return moveOk();" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="hidden" name="exec" value="move" />
		<input type="hidden" name="moveAction" value="1" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="selectArticle" value="<?php echo $selectArticle; ?>" />
		<div class="mvBack">
			<div class="mv">이동할 게시판 선택</div>
			<div style="text-align:center;padding:10px;">
				<select name="moveTarget">
				<option value="">이동할 게시판을 선택하세요</option>
				<?php
				include 'db_info.php';
				$getTableList = @mysql_query("show table status from {$dbName} like '{$dbFIX}bbs%'");
				while($tables = mysql_fetch_array($getTableList)) { ?>
					<option value="<?php echo $tables['Name']; ?>"><?php echo str_replace($dbFIX.'bbs_', '', $tables['Name']); ?></option>
					<?php
				} # while
				?>
				</select>
				<input type="submit" value="이동 시작" class="submit" /> <input type="button" value="뒤로 가기" class="submit" onclick="location.href='<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>';" />
			</div>
		</div>
		</form>

		<!-- 위아래 공백 -->
		<div class="vSpace"></div>
		<div class="vSpace"></div>
		<div class="vSpace"></div>

		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>" title="게시판으로 돌아갑니다." style="font-weight:bold;">[게시판으로 돌아가기]</a>

		<?php
		} # move
		// 게시물 복사
		elseif($exec == 'copy') {
			if(array_key_exists('copyAction', $_POST)) {
				$id = $_POST['id'];
				$selectArticle = $_POST['selectArticle'];
				$copyTarget = $_POST['copyTarget'];
				$copyTargetID = str_replace($dbFIX.'bbs_', '', $copyTarget);
				$tempArray = explode(';', $selectArticle);
				sort($tempArray, SORT_NUMERIC);
				$totalArray = count($tempArray);

				for($g=1; $g<$totalArray; $g++) {
					$articleNo = $tempArray[$g];
					$copyData = @mysql_fetch_array(mysql_query("select * from {$dbFIX}bbs_{$id} where no = '$articleNo'"));
					$copyMemberKey = $copyData['member_key'];
					$copyName = $copyData['name'];
					$copyPassword = $copyData['password'];
					$copyEmail = $copyData['email'];
					$copyHomepage = $copyData['homepage'];
					$copyIp = $copyData['ip'];
					$copySigndate = $copyData['signdate'];
					$copyHit = $copyData['hit'];
					$copyGood = $copyData['good'];
					$copyBad = $copyData['bad'];
					$copyCommentCount = $copyData['comment_count'];
					$copyIsNotice = $copyData['is_notice'];
					$copyIsSecret = $copyData['is_secret'];
					$copyCategory = $copyData['category'];
					$copySubject = $copyData['subject'];
					$copyContent = $copyData['content'];
					$copyLink1 = $copyData['link1'];
					$copyLink2 = $copyData['link2'];
					$copyTrackback = $copyData['trackback'];
					$copyTag = $copyData['tag'];

					$addExtendField = '';
					$getExtendField = @mysql_query('select * from '.$dbFIX.'bbs_'.$id.' where no = '.$articleNo);
					$numField = @mysql_num_fields($getExtendField);
					$targetExtendCheck = @mysql_num_fields(mysql_query('select * from '.$copyTarget.' limit 1'));
					if(($numField > $maxDefaultField) && ($numField == $targetExtendCheck)) {
						for($f=$maxDefaultField; $f<$numField; $f++) {
							$fields = @mysql_fetch_field($getExtendField, $f);
							$addExtendField .= ', '.$fields->name.' = \''.$copyData[$fields->name].'\'';
						}
					}

					$insertArticleQue = "insert into {$copyTarget}
						set no = '',
						member_key = '$copyMemberKey',
						name = '$copyName',
						password = '$copyPassword',
						email = '$copyEmail',
						homepage = '$copyHomepage',
						ip = '$copyIp',
						signdate = '$copySigndate',
						hit = '$copyHit',
						good = '$copyGood',
						bad = '$copyBad',
						comment_count = '$copyCommentCount',
						is_notice = '$copyIsNotice',
						is_secret = '$copyIsSecret',
						category = '$copyCategory',
						subject = '$copySubject',
						content = '$copyContent',
						link1 = '$copyLink1',
						link2 = '$copyLink2',
						trackback = '$copyTrackback',
						tag = '$copyTag'
						$addExtendField
						";
					@mysql_query($insertArticleQue);
					$insertNo = mysql_insert_id();

					$getOldComment = @mysql_query("select * from {$dbFIX}comment_{$id} where board_no = '$articleNo'");
					while($copyComment = mysql_fetch_array($getOldComment)) {
						$cpMemberKey = $copyComment['member_key'];
						$cpFamilyNo = $copyComment['family_no'];
						$cpThread = $copyComment['thread'];
						$cpIsGrcode = $copyComment['is_grcode'];
						$cpName = $copyComment['name'];
						$cpPassword = $copyComment['password'];
						$cpEmail = $copyComment['email'];
						$cpHomepage = $copyComment['homepage'];
						$cpIp = $copyComment['ip'];
						$cpSigndate = $copyComment['signdate'];
						$cpGood = $copyComment['good'];
						$cpBad = $copyComment['bad'];
						$cpSubject = addslashes($copyComment['subject']);
						$cpContent = addslashes($copyComment['content']);

						$insertArticleQue = "insert into {$dbFIX}comment_{$copyTargetID}
							set no = '',
							board_no = '$insertNo',
							family_no = '$cpFamilyNo',
							thread = '$cpThread',
							member_key = '$cpMemberKey',
							is_grcode = '$cpIsGrcode',
							name = '$cpName',
							password = '$cpPassword',
							email = '$cpEmail',
							homepage = '$cpHomepage',
							ip = '$cpIp',
							signdate = '$cpSigndate',
							good = '$cpGood',
							bad = '$cpBad',
							subject = '$cpSubject',
							content = '$cpContent'";
						@mysql_query($insertArticleQue);
					}

					$copyFile = @mysql_fetch_array(mysql_query("select * from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'"));
					
					if(!is_dir('data/'.$copyTargetID)) {
						@mkdir('data/'.$copyTargetID, 0705);
						@chmod('data/'.$copyTargetID, 0707);
					}

					$targetPath = array();
					for($cf=1; $cf<11; $cf++) {
						$fileRoute = 'file_route'.$cf;
						if($copyFile[$fileRoute]) {
							$filename = end(explode('/', $copyFile[$fileRoute]));
							if(file_exists('data/'.$copyTargetID.'/'.$filename)) {
								$targetPath[$cf] = 'data/'.$copyTargetID.'/'.substr(md5($GR->grTime()), -3).'_'.$filename;
							} else {
								$targetPath[$cf] = 'data/'.$copyTargetID.'/'.$filename;
							}
							@copy($copyFile[$fileRoute], $targetPath[$cf]);
						}
					}
					$cpHit = $copyFile['hit'];

					if($copyFile[0]) {
						$insertPdsQue = "insert into {$dbFIX}pds_save
							set no = '',
							id = '$copyTargetID',
							article_num = '$insertNo',
							file_route1 = '$targetPath[1]',
							file_route2 = '$targetPath[2]',
							file_route3 = '$targetPath[3]',
							file_route4 = '$targetPath[4]',
							file_route5 = '$targetPath[5]',
							file_route6 = '$targetPath[6]',
							file_route7 = '$targetPath[7]',
							file_route8 = '$targetPath[8]',
							file_route9 = '$targetPath[9]',
							file_route10 = '$targetPath[10]',
							hit = '$cpHit'";
						@mysql_query($insertPdsQue);
						$copyInsertID = @mysql_insert_id();
						
						$getRealNames = @mysql_query('select * from '.$dbFIX.'pds_list where type = 0 and uid = '.$copyFile['no']);
						while($reals = @mysql_fetch_array($getRealNames)) {
							@mysql_query('insert into '.$dbFIX.'pds_list set no = \'\', type = 0, uid = '.$copyInsertID.', idx = '.$reals['idx'].', name = \''.str_replace('/'.$id.'/', '/'.$copyTargetID.'/', $reals['name']).'\'');
						}
					}

					$getExtendFiles = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
					while($extFiles = @mysql_fetch_array($getExtendFiles)) {
						$targetFile = end(explode('/', $extFiles['file_route']));
						if(file_exists('data/'.$copyTargetID.'/'.$targetFile)) $randExtPds = substr(md5($GR->grTime()), -3).'_';
						else $randExtPds = '';
						$copyExtendRoute = 'data/'.$copyTargetID.'/'.$randExtPds.$targetFile;
						@copy($extFiles['file_route'], $copyExtendRoute);
						@mysql_query('insert into '.$dbFIX."pds_extend set no = '', id = '$copyTargetID', article_num = '$insertNo', file_route = '$copyExtendRoute'");

						$getExtendInsertID = @mysql_insert_id();
						$getRealName = @mysql_fetch_array(mysql_query('select name from '.$dbFIX.'pds_list where type = 1 and uid = '.$extFiles['no'].' limit 1'));
						@mysql_query('insert into '.$dbFIX.'pds_list set no = \'\', type = 1, uid = '.$getExtendInsertID.', idx = 0, name = \''.str_replace('/'.$id.'/', '/'.$copyTargetID.'/', $getRealName['name']).'\'');
					}

					@mysql_query("insert into {$dbFIX}total_article set no = '', subject = '$copySubject', id = '$copyTargetID', article_num = '$insertNo', signdate = '$copySigndate', is_secret = '$copyIsSecret'");

					$getSetTime = @mysql_fetch_array(mysql_query('select set_time from '.$dbFIX."time_bomb where id = '$id' and article_num = '$articleNo'"));
					@mysql_query("insert into {$dbFIX}time_bomb set no = '', id = '$copyTargetID', article_num = '$insertNo', set_time = '".$getSetTime['set_time']."'");
				} # for				
				$GR->error('게시물을 성공적으로 복사했습니다.', 0, 'board.php?id='.$id);
			}
		?>
		<form name="copyArticle" onsubmit="return copyOk();" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="hidden" name="exec" value="copy" />
		<input type="hidden" name="copyAction" value="1" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="selectArticle" value="<?php echo $selectArticle; ?>" />
		<div class="mvBack">
			<div class="mv">복사할 게시판 선택</div>
			<div style="text-align: center; padding: 10px">
				<select name="copyTarget">
				<option value="">복사할 게시판을 선택하세요</option>
				<?php
				// 게시판 목록 받아오기
				include "db_info.php";
				$getTableList = @mysql_query("show table status from {$dbName} like '{$dbFIX}bbs%'");
				while($tables = mysql_fetch_array($getTableList)) { 	?>
					<option value="<?php echo $tables['Name']; ?>"><?php echo str_replace($dbFIX.'bbs_', "", $tables['Name']); ?></option>
					<?php
				} # while
				?>
				</select>
				<input type="submit" value="복사 시작" class="submit" /> <input type="button" value="뒤로 가기" class="submit" onclick="location.href='<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>';" />
			</div>
		</div>
		</form>

		<!-- 위아래 공백 -->
		<div class="vSpace"></div>
		<div class="vSpace"></div>
		<div class="vSpace"></div>

		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>" title="게시판으로 돌아갑니다." style="font-weight:bold;">[게시판으로 돌아가기]</a>

		<?php
		} # copy
		// 카테고리 변경
		// 2010.01.30 장화신은고양이 - 소스가 많이 지저분합니다. PHP와 MYSQL 완전 초보라서요..ㅜㅜ 죄송합니다.
		elseif($exec == 'category') {
		  if(array_key_exists('categoryAction', $_POST)) {
				$id = $_POST['id'];
				$selectArticle = $_POST['selectArticle'];
				$categoryTarget = $_POST['categoryTarget'];
				// 카테고리 값이 category_delete인 경우
				  if($categoryTarget == "category_delete")
				    $categoryTarget = "";
				$categoryTargetNAME = str_replace($dbFIX.'bbs_', '', $categoryTarget);
				$tempArray = explode(';', $selectArticle);
				sort($tempArray, SORT_NUMERIC);
				$totalArray = count($tempArray);
				
        for($g=0; $g<$totalArray; $g++) {
					$articleNo = $tempArray[$g];
          @mysql_query("update {$dbFIX}bbs_{$id} set category = '$categoryTargetNAME' where no = ".$articleNo);
          
		    } # for				
				  $GR->error('해당 게시물의 카테고리를 성공적으로 변경했습니다.', 0, 'board.php?id='.$id);
		  }
		?>
		<form name="categoryArticle" onsubmit="return categoryOk();" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="hidden" name="exec" value="category" />
		<input type="hidden" name="categoryAction" value="1" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="selectArticle" value="<?php echo $selectArticle; ?>" />
		<div class="mvBack">
			<div class="mv">카테고리 선택</div>
			<div style="text-align: center; padding: 10px">
				<select name="categoryTarget">
				<option value="">변경할 카테고리명을 선택하세요</option>
				<?php
				// 게시판 카테고리 목록 받아오기
				include "db_info.php";
				// 셀렉트박스형 카테고리 선택
	      $categories = @mysql_fetch_array(mysql_query('select category from '.$dbFIX.'board_list where id = \''.$id.'\''));
	      $categoryArray = @explode('|', $categories['category']);
	      $countCategory = @count($categoryArray);
	        for($ca=1; $ca<$countCategory; $ca++) { ?>
					  <option value="<?php echo stripslashes($categoryArray[$ca]); ?>"><?php echo stripslashes($categoryArray[$ca]); ?></option>
					<?php } # for ?> 
					  <option value="category_delete">카테고리 제거</option>
				</select>
				<input type="submit" value="변경 시작" class="submit" /> <input type="button" value="뒤로 가기" class="submit" onclick="location.href='<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>';" />
			</div>
		</div>
		</form>

		<!-- 위아래 공백 -->
		<div class="vSpace"></div>
		<div class="vSpace"></div>
		<div class="vSpace"></div>

		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>" title="게시판으로 돌아갑니다." style="font-weight:bold;">[게시판으로 돌아가기]</a>

		<?php
		} # category
		?>
		</div><!--# 우측 몸통 부분 -->
		<div class="clear"></div>

	</div><!--# 폭 설정 -->

</div><!--# 중앙배열 -->
<script type="text/javascript">//<![CDATA[
function moveOk() {
	if(!document.forms["moveArticle"].elements["moveTarget"].value) {
		alert('이동할 게시판을 선택하세요.');
		return false;
	}
	return true;
}

function copyOk() {
	if(!document.forms["copyArticle"].elements["copyTarget"].value) {
		alert('복사할 게시판을 선택하세요.');
		return false;
	}
	return true;
}

function categoryOk() {
	if(!document.forms["categoryArticle"].elements["categoryTarget"].value) {
		alert('변경할 카테고리를 선택하세요.');
		return false;
	}
	return true;
}

// 선택한 게시물 삭제하기
function isDeleteOk() {
	if(confirm('정말로 선택한 게시물들을 삭제하시겠습니까?\n\n게시물과 연관된 첨부파일, 코멘트 모두 삭제됩니다.')) {
		location.href='<?php echo $grboard; ?>/list_adjust.php?exec=delete&id=<?php echo $id; ?>&selectArticle=<?php echo $selectArticle; ?>';
	}
}

// 마우스 온 이벤트
function Over(t) {
	t.style.backgroundColor='#ececec';
}

// 마우스 아웃 이벤트
function Out(t) {
	t.style.backgroundColor='';
}
//]]></script>

</body>
</html>