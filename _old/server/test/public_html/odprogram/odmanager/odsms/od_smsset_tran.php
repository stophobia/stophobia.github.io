<?
include "../../odcommon/od_config.inc.php";
include "$folderpath_manager_common/od_function.inc.php";   
include "$folderpath_manager_common/od_adminAuthority.inc.php";

/*
CREATE TABLE m_sms_set (
    smsseq int(6) NOT NULL auto_increment,
    smskbn  varchar(20),
    smschk char(1) default 'y',
    smstext varchar(100),
    primary key (smsseq)
);
*/

echo $smskbn;
echo $smschk;
echo $smstext;

if ($smsseq)
{
    $Query  = " UPDATE m_sms_set SET smschk = '$smschk', smstext = '$smstext' WHERE smsseq = '$smsseq'  ";
}
else
{
    $Query = " INSERT INTO m_sms_set (smsseq, smskbn, smschk, smstext) VALUES ('$smsseq', '$smskbn', '$smschk', '$smstext' )    ";
}

//echo $Query;exit;
$Result = mysql_query($Query);

echo "
<script>
    alert('처리되었습니다');
</script>";
exit;

?>