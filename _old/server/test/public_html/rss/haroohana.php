<?php
header("Content-Type: text/html; charset=utf-8"); 

// 필요한 설정파일 불러오기
include "../odprogram/odcommon/od_config.inc.php";
include "../odprogram/odcommon/od_lib.inc.php";

function saleItem($cateCode)
{
    global $row_setup;
    $today = date('Y-m-d');
    $que = "select code from odtProduct where code = parent_code and cateCode = '".$cateCode."' and sale_date <= '${today}' order by sale_date desc limit 1";
    $res = mysql_query($que);
    return @mysql_result($res,0);
}
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

?>
<root>
	<company_id><?=$_GET[hanaCode]?></odcompany_id>
<?
// 지역구분 추출 //////////////////////////////////////////////////////////////
$Query  = "select catecode from odtCategory where cHidden = 'no' order by catecode asc  ";
$Result = mysql_query($Query);
while ($Record = mysql_fetch_array($Result))
{

    $Aid        = $Record[0];
    $code       = saleItem($Aid);
    if ( !$code ) continue;

    $Pinfo      = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$code."'"));
    $minPrice   = @mysql_result(mysql_query("select price from odtProduct where parent_code ='".$code."' order by mainPrice=1 desc, price asc limit 1"),0);
    $coupon     = @mysql_result(mysql_query("select coupon_sale from odtProduct where parent_code = code and and code ='".$code."'"),0);
    $minPrice   = $minPrice - $coupon;
    $proCnt     = @mysql_fetch_array(mysql_query("select max(price) as max ,min(price) as min from odtProduct where parent_code='".$code."'" ));

    $row_product2		= mysql_fetch_array(mysql_query("select * from odtProduct where parent_code ='".$code."' order by mainPrice=1 desc, price asc limit 1"));
    $proCnt		= @mysql_fetch_array(mysql_query("select max(price) as max ,min(price) as min from odtProduct where parent_code='".$code."'" ));

    $stock = $Pinfo[stock]; //= mysql_result(mysql_query("select max(stock) as stock from odtProduct where parent_code='".$code."' group by parent_code"),0);
    if( !$stock ) continue;//$Pinfo[price] = "Sold Out";

    $talkCnt = mysql_result(mysql_query("select count(*) from odtTt where ttProCode = '".$code."'"),0);
    $freeDel = !$Pinfo[del_price] ? "Y" : "N";
    $saleCntSum = mysql_result(mysql_query("select sum(saleCnt) from odtProduct where parent_code = '".$Pinfo[code]."'"),0);
    $comInfo = mysql_fetch_array(mysql_query("select * from odtMember where id='".$Pinfo[customerCode]."'"));

    if($proCnt['max'] != $proCnt['min'])	$Pinfo[price] = number_format($minPrice)."원~";
    else                                    $Pinfo[price] = number_format($minPrice)."원";

?>
	<coupon>
		<id><?=$Pinfo[code]?></id> 
		<title><![CDATA[<?=$Pinfo[mainName]?>]]></title> 
		<category>99</category>
		<description><![CDATA[]]></description> 
		<original_price><?=$row_product2[price_org]?></original_price> 
		<discount_price><?=$row_product2[price]?></discount_price> 
		<discount_description><![CDATA[<?=$row_product2[price_per]?>%할인]]></discount_description> 
		<image>http://<?=$_SERVER[HTTP_HOST].$Pinfo[side_img]?></image> 
		<link>http://<?=$_SERVER[HTTP_HOST]?>/?viewCode=<?=$Pinfo[code]?></link> 
		<mobile_link>http://<?=$_SERVER[HTTP_HOST]?>/?viewCode=<?=$Pinfo[code]?></mobile_link> 
		<start_date><?=str_replace("-","",$Pinfo[sale_date])?>00</start_date>
		<end_date><?=str_replace("-","",date_nextsale($Aid))?>00</end_date>
		<coupon_company><?=$comInfo[cName]?></coupon_company> 
		<coupon_sale_condition><?=$Pinfo[saleCntMax]?></coupon_sale_condition>
		<coupon_sale_count><?=$saleCntSum?></coupon_sale_count> 
		<coupon_start_date></coupon_start_date>
		<coupon_end_date></coupon_end_date> 
		<coupon_address><?=$comInfo[address]?></coupon_address>
		<coupon_latitude>0</coupon_latitude>
		<coupon_longitude>0</coupon_longitude>
		<coupon_phone><?=$comInfo[tel1].$comInfo[tel2].$comInfo[tel3]?></coupon_phone>
	</coupon>
<? } ?>
</root> 
