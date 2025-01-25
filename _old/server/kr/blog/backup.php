<?php
include 'php_head.php';
if(!$_SESSION['no']) exit();

include 'lib/common.php';
include 'lib/admin.php';
dbConn();

// 데이터베이스 인터페이스
class DATABASE
{
	// 필드값 가져오기
	function getField($table)
	{
		$resultQue = @mysql_query('show fields from '.$table);
		$que = '';
		while($fieldData = mysql_fetch_array($resultQue))
		{
			$fieldData['Null'] = ($fieldData['Null'] == "YES")?' null':' not null';
			$fieldData['Default'] = ($fieldData['Default'])?' default \''.$fieldData['Default'].'\'':'';
			$fieldData['Key'] = ($fieldData['Key'] == "PRI")?' primary key':'';
			if($fieldData['Extra']) $fieldData['Extra'] = " ".$fieldData['Extra'];
			$que .= ' '.$fieldData['Field']." ".$fieldData['Type'].$fieldData['Null'].$fieldData['Default'].$fieldData['Extra'].$fieldData['Key'].',';
		}
		return $que;
	}

	// 키 값 가져오기
	function getKey($table)
	{
		$resultQue = @mysql_query("show keys from {$table}");
		$que = '';
		$hiddenName = '';
		$primaryQue = '';
		while($keyData = mysql_fetch_array($resultQue))
		{
			if($keyData['Key_name'] != 'PRIMARY')
			{
				if($hiddenName != $keyData['Key_name'])
				{
					if($hiddenName) $que .= "),";
					$que .= ' KEY '.$keyData['Key_name'].' ('.$keyData['Column_name'];
					$hiddenName = $keyData['Key_name'];
				}
				else
				{
					if($hiddenName)
					{
						$que .= ','.$keyData['Column_name'];
					}
				}
			}
		}
		if($hiddenName && ($hiddenName==$keyData['Key_name'])) $que .= '),';
		return $que;
	}

	// 스키마 가져오기
	function getSchema($table)
	{
		$field = $this->getField($table);
		$key = $this->getKey($table);
		$schema = $field.$key;
		if(!$key) 
		{
			$schema = substr($schema, 0, strlen($schema)-1);
			$schema = 'create table '.$table.' ('.$schema.') TYPE=MyISAM;'."\n";
		}
		else $schema = 'create table '.$table.' ('.$schema.')) TYPE=MyISAM;'."\n";
		echo $schema;
	}

	// 와일드카드 처리
	function sqlWildString($str)
	{
		$str = str_replace('\\', '\\\\', $str);
		$str = str_replace("\n", '\n', $str);
		$str = str_replace("\r", '\r', $str);
		$str = str_replace("\t", '\t', $str);
		return $str;
	}

	// 데이터 가져오기
	function getData($table)
	{
		$field = '';
		$resultQue = @mysql_query('show fields from '.$table);
		while($fieldData = mysql_fetch_array($resultQue))
		{
			$field .= $fieldData['Field'].',';
		}		
		$field = substr($field, 0, strlen($field)-1);
		$tmpArr = explode(',', $field);
		$tmpArrSize = count($tmpArr);
		$resultQueTable = @mysql_query('select '.$field.' from '.$table);
		while($saveData = mysql_fetch_array($resultQueTable))
		{
			if(!$value) $value = '';
			for($i=0; $i<$tmpArrSize; $i++)
			{
				$value .= "'".addslashes($saveData[$tmpArr[$i]])."',";
			}
			$value = substr($value, 0, strlen($value)-1);
			$value = $this->sqlWildString($value);
			echo 'insert into '.$table.' values('.$value.');'."\n";
			unset($value);
		}
	}

	// 모두 받기
	function allDown($dbName)
	{
		$resultQue = @mysql_query("show table status from {$dbName} like '{$dbFIX}%'");
		while($dbData = mysql_fetch_array($resultQue))
		{
			$this->getSchema($dbData['Name']);
			$this->getData($dbData['Name']);
		}
	}

	// 다운로드 헤더설정
	function dbHeader($file)
	{
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		header('Expires: 0');
		if(eregi('msie', $_SERVER['HTTP_USER_AGENT'])) header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	}
}

if(!isset($_SESSION['no'])) error('로그인 하신 후 다시 backup.php 를 실행해 주세요', 'location.href=\'login.php\';');
$DB = new DATABASE;
$admin = $_GET['admin'];
$result = $_GET['result'];
if(!isset($_GET['admin'])) $admin = 0;
if($admin == 1)
{
	include 'db_info.php';
	@set_time_limit(0);
	$saveDay = date('Ymd', time());
	$DB->dbHeader('grblog_'.$saveDay.'.sql');
	$DB->allDown($dbName);
	exit();
}

// 백업파일 받기
if(is_array($_FILES['dbsave']) && $_FILES['dbsave']['size'] > 0)
{
	$fn = $_FILES['dbsave']['tmp_name'];
	$fa = @file($fn);
	$count = count($fa);
	for($i=0; $i<$count; $i++)
	{
		$fa[$i] = str_replace('\\\\', '\\', $fa[$i]);
		@mysql_query($fa[$i]);
	}
	$result = '총 '.$count.' 개의 쿼리문 실행완료';
	error($result, 'location.href=\'backup.php?result='.urlencode($result).'\';');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<style type="text/css">
/*<![CDATA[*/
@import url(admin_style.css); 
.input {
	border-width:0px;
	border-bottom:#ddd 1px solid;
	background-color:transparent;
	font-family:verdana,굴림;
	font-size:12px;
}

.textarea {
	border:#ddd 1px solid;
	background-color:transparent;
	padding:3px;
	overflow:auto;
}
.submit {
	background-color:#f5f5f5;
	border: 3px double #999;
	border-left-color: #ccc;
	border-top-color: #ccc;
	color: #333;
}
ul {
	margin: 10px 0px 20px 15px;
}
/*]]>*/
</style>
<title>GR Blog DB Backup / Recover</title>
</head>
<body>

<!-- 상단 -->
<div id="adminTop">
<a href="#">GR Blog DB Backup / Recover</a>
</div>

<div id="adminMenu">
	<div class="<?php echo btn($admin, 1); ?>"><a href="backup.php?admin=1">DB 백업하기</a></div>
	<div class="<?php echo btn($admin, 2); ?>"><a href="backup.php?admin=2">DB 복구하기</a></div>
	<div class="n"><a href="admin.php?admin=7">로그아웃</a></div>
	<div class="clr"></div>
</div>

<form id="db" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<div id="adminControl">
	<?php if($admin == 2) { ?>
	<div><strong>.sql</strong> 파일 업로드
	(업로드 용량제한: <?php echo ini_get('post_max_size'); ?>)
	<input type="file" name="dbsave" class="input" title="GR블로그에서 백업받으신 .sql 파일을 첨부해 주세요" />
	<input type="submit" value="업로드" class="submit" /></div>
	<?php } elseif($result) { ?>
	<div style="padding-top: 50px">※ <?php echo $result; ?></div>
	<?php } else { ?>
	<p><strong>DB 백업하기</strong></p>
	<ul>
		<li>상단의 "DB 백업하기" 를 클릭하시면 GR Blog 가 사용중인 DB를 .sql 파일로 받습니다.</li>
		<li>.sql 파일은 메모장에서도 열립니다. (단, 파일 크기가 큰 경우 안 열릴 수 있습니다.)</li>
		<li>.sql 파일 내부에는 GR Blog 가 쓰던 모든 데이터가 들어가 있습니다. 외부로 유출되지 않도록 주의해 주세요.</li>
		<li>모든 DB 백업을 위해서 phpMyAdmin 이나 MySQL 콘솔작업을 하시는 걸 권장 합니다.</li>
		<li>백업 후 복구를 원하는 곳에 "DB 복구하기" 로 복구하시길 바랍니다.</li>
	</ul>
	<p><strong>DB 복구하기</strong></p>
	<ul>
		<li>상단의 "DB 복구하기" 를 클릭하여 백업하기로 받으신 .sql 파일을 첨부 하고 "업로드" 를 클릭 합니다.</li>
		<li>파일 크기가 "업로드 용량제한" 크기보다 클 경우 복구작업이 안될 수 있습니다.</li>
		<li>웹호스팅을 이용하신다면 해당 회사 고객 게시판 등에 비밀글로 DB복구를 요청하시는 게 가장 빠릅니다.</li>
		<li>호스팅 사에서 제공하는 매니져 프로그램에서 DB 백업과 DB 복구를 지원한다면, 그것을 이용하시는 게 가장 안전 합니다.</li>
		<li>복구 작업은 DB 서버에 부하가 가는 작업 입니다. 작업 완료 후 다시 또 작업을 시도하지 마시고 브라우저를 종료 해 주세요.</li>
	</ul>
	<?php } ?>
</div>
</form>

</body>
</html>