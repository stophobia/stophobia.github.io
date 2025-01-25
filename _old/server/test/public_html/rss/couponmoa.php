<?php
header("Content-Type: text/html; charset=utf-8"); 
// 필요한 설정파일 불러오기
include "../odprogram/odcommon/od_config.inc.php";
include "../odprogram/odcommon/od_function.inc.php";
include "../odprogram/odcommon/od_lib.inc.php";


function saleItem($cateCode)
{
    global $row_setup;
    $today = date('Y-m-d');
    $que = "select code from odtProduct where code = parent_code and cateCode = '".$cateCode."' and sale_date <= '${today}' order by sale_date desc limit 1";
    $res = mysql_query($que);
    return @mysql_result($res,0);
}


$homepage = reset(explode("/",str_replace("http://","",str_replace("www.","",$row_company[homepage]))));

?>
<coupon_feed>
  <doc_ver>1</doc_ver>
  <name>
    <![CDATA[<?=$row_company[name]?>]]>
  </name>
  <url>
    <![CDATA[http://<?=$homepage?>]]>
  </url>
  <logo_image>
    <![CDATA[http://<?=$homepage?>/images/group/top_logo.gif]]>
  </logo_image>
  <deals>

<?

// 지역구분 추출 //////////////////////////////////////////////////////////////
$Query  = "select catecode from odtCategory where cHidden = 'no' order by catecode asc  ";
$Result = mysql_query($Query);
while ($Record = mysql_fetch_array($Result))
{
    $Aid        = $Record[0];
    $code       = saleItem($Aid);

    if (!$code) continue;

        $Pinfo      = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$code."'"));
        $minPrice   = @mysql_result(mysql_query("select price from odtProduct where parent_code ='".$code."' order by mainPrice=1 desc, price asc limit 1"),0);
        $coupon     = @mysql_result(mysql_query("select coupon_sale from odtProduct where parent_code = code and and code ='".$code."'"),0);
        $minPrice   = $minPrice - $coupon;
        $proCnt     = @mysql_fetch_array(mysql_query("select max(price) as max ,min(price) as min from odtProduct where parent_code='".$code."'" ));
        if($proCnt['max'] != $proCnt['min'])    $Pinfo[price] = number_format($minPrice)."원~";
        else                                    $Pinfo[price] = number_format($minPrice)."원";   

        $userInfo = mysql_fetch_array(mysql_query("select * from odtMember where id='".$Pinfo[customerCode]."'"));

        $Pinfo[price_org] = number_format($Pinfo[price_org])."원"; 

        $stock = mysql_result(mysql_query("select max(stock) as stock from odtProduct where parent_code='".$code."' group by parent_code"),0);
        if(!$stock) $Pinfo[price] = "Sold Out";



?>


    <deal>
      <meta_id>
        <![CDATA[<?=$Pinfo[parent_code]?>]]>
      </meta_id>
      <start_at>
        <![CDATA[<?=$Pinfo[sale_date]?> 00:00:00]]>
      </start_at>
      <end_at>
        <![CDATA[<?=date('Y-m-d H:i:s',strtotime(date_nextsale($Aid))-1)?>]]>
      </end_at>
      <coupon_start_at>
        <![CDATA[]]>
      </coupon_start_at>
      <coupon_end_at>
        <![CDATA[]]>
      </coupon_end_at>
      <title>
        <![CDATA[<?=$Pinfo[name]?>]]>
      </title>
      <description>
        <![CDATA[<?=$Pinfo[message]?>]]>
      </description>
      <url>
        <![CDATA[http://<?=$homepage?>/?catecode=<?=$Aid?>&viewCode=<?=$Pinfo[parent_code]?>]]>
      </url>
    
      <support_mobile_transaction>N</support_mobile_transaction>
      <original><?=$Pinfo[price_org]?></original>
      <discount><?=$Pinfo[price_per]?></discount>
      <price><?=$Pinfo[price]?></price>
      <max_count><?=$Pinfo[stockMax]?></max_count>
      <min_count><?=$Pinfo[saleCntMax]?></min_count>
      <now_count><?=$Pinfo[saleCnt]?></now_count>
      <status>진행중</status>
      <category></category>
      <shops>
        <shop> 

          <shop_name>
            <![CDATA[<?=$Pinfo[customerName]?>]]>
          </shop_name>
          <shop_address>
                      <![CDATA[<?=$userInfo[address]?>]]>
                    </shop_address>
          <shop_tel>
            <![CDATA[<?=$userInfo[tel1]?><?=$userInfo[tel2]?><?=$userInfo[tel3]?>]]>
          </shop_tel>
          <region></region>
          <naver_map_url>
            <![CDATA[]]>
          </naver_map_url>
        </shop>
      </shops>
      <images>
        <image>
          <![CDATA[<?="http://".$homepage.$Pinfo[main_img]?>]]>
        </image>
   
      </odimages>
   
    </deal>
<?

}

?>


</deals>

</coupon_feed>