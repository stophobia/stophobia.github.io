<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";



if ("view" == $subMode)
{
    // 해당 테이블 정보 추출 ///////////////////////////////////////////////////
    $Query  = " select * from odtMailContent where code = '$code'  ";
    $Result = mysql_query($Query);
    $Record = mysql_fetch_array($Result);
    $title  = $Record[subject] ? $Record[subject] : "&nbsp;";

    echo "
    <html>
    <head>
    <title>$title</title>
    <style> 
        body, td, ul, ol, pre
        {
           font-size : 9pt;
           font-family : 굴림체; 
        }
    </style>
    </head>
    <body><br>
    <table border=1 cellpadding=2 cellspacing=0 align=center bordercolordark=white bordercolorlight=silver>
      <tr height=20 bgcolor=#e8f3ff>
         <td width=150 align=center>성 명</td>
         <td width=200 align=center>메일주소</td>
      </tr>";

    $Query  = " SELECT * FROM odtMailLog WHERE code = '$code' ";
    $Result = mysql_query($Query);
    while ($Record = mysql_fetch_array($Result))
		{
				$NAME   = $Record[name]  ? $Record[name]  : "";
				$EMAIL  = $Record[email] ? $Record[email] : "";

				$emailArray = explode(",", $EMAIL);
				$nameArray  = explode(",", $NAME);

				for($i = 0; $i < count($emailArray); $i++)
				{
						$nameArray[$i]  = str_replace(" ", "", $nameArray[$i]);
						$emailArray[$i] = str_replace(" ", "", $emailArray[$i]);

						echo "
						<tr height=20>
								<td>$nameArray[$i]</td>
								<td>$emailArray[$i]</td>
						</tr>";
				}
		}
  

    echo "
    </table><br>
    </body>
    </html>";
    exit;
}
else if ("del" == $subMode)
{
    $no = $_POST[memSerialnum];

    for($i=0; $i < count($no); $i++)
    {
        mysql_query("delete from odtMailContent where code = '".$no[$i]."'");
        mysql_query("delete from odtMailLog where code = '".$no[$i]."'");
    }

    error_msgall('처리되었습니다.');
    echo "<script>parent.location.reload();</script>";
    exit;

}



?>