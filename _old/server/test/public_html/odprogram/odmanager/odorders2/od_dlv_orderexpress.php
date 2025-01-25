<?
    include "../../odcommon/od_config.inc.php";
    include "$folderpath_manager_common/od_function.inc.php";
    include "$folderpath_manager_common/od_comAuthority.inc.php";
	
	for($i=0;$i<count($OrderNumValue);$i++) {
		if($OrderNumValue[$i]) {
			$row = mysql_fetch_array(mysql_query("select * from odtOrder where ordernum = '".$OrderNumValue[$i]."'"));

			if(!$expressnum[$i] || array_search($OrderNumValue[$i],$OrderNum) === false) continue;


			mysql_query("update odtOrder set 
										delivstatus			=	'yes',
										expressname			= '".$expressname[$i]."',
										expressnum			= '".$expressnum[$i]."',
										expressdate			=	'".date('Y-m-d')."'
										where ordernum	= '".$OrderNumValue[$i]."'");


			if($row[delivstatus] == "no") {
				## 문자발송
				$orderhtel1			= $row[orderhtel1];
				$orderhtel2			= $row[orderhtel2];
				$orderhtel3			= $row[orderhtel3];
				$expressnumTmp	= $expressnum[$i];
				$expressnameTmp	= $expressname[$i];
				$expressdate		= date('Y-m-d');
				include "od_sms_delivery.inc.php";

				## 메일발송
				$mail_row = $row;
				if($mail_row[orderemail]) include "od_SendEmail_02.inc.php"; 

			
			}

		}
	}

	mysql_query("delete from odtExpressTmpTable where partnerCode = '".$com[id]."'");

exit;

?>
<script>
parent.location.reload();
</script>