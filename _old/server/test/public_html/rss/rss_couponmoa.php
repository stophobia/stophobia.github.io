<?php

header("Content-Type: text/html; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
include "./addon_rss.php";

##START
$slntype = get_slntype();
$company = getRow("SELECT * FROM ".$slntype."Company");  //회사기본설정

echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<coupon_feed>";
echo "<doc_ver>1</doc_ver>";
echo "<name><![CDATA[$company[homepage_title]]]></name>";
echo "<url><![CDATA[http://$_SERVER[HTTP_HOST]]]></url>";
echo "<logo_image />";
echo "<deals>";

##DATA FORMAT
$dataForm = "
<deal>
    <meta_id><![CDATA[{##PPID##}]]></meta_id>
    <start_at><![CDATA[{##STT_DATETIME##}]]></start_at>
    <end_at><![CDATA[{##END_DATETIME##}]]></end_at>
    <coupon_start_at><![CDATA[{##BEG_DATE##}]]></coupon_start_at>
    <coupon_end_at><![CDATA[{##EXP_DATE##}]]></coupon_end_at>
    <title><![CDATA[{##PNAME##}]]></title>
    <description><![CDATA[{##PMSG##}]]></description>
    <url><![CDATA[{##LINK##}]]></url>
    <mobile_url><![CDATA[]]></mobile_url>
    <support_mobile_transaction>N</support_mobile_transaction> 
    <original>{##PRICEO##}</original> 
    <discount>{##PRICER##}</discount> 
    <price>{##PRICES##}</price> 
    <max_count>{##CNTMAX##}</max_count> 
    <min_count>{##CNTMIN##}</min_count> 
    <now_count>{##CNTSALE##}</now_count>
    <status>진행중</status> 
    <category><![CDATA[{##CATEGORY##}]]></category>
    <images>
        <image><![CDATA[{##PIMG##}]]></image>
    </images>
    <shops>
        <shop>
            <shop_name><![CDATA[{##SUP_NAME##}]]></shop_name>
            <shop_tel><![CDATA[{##SUP_TEL1##}-{##SUP_TEL2##}-{##SUP_TEL3##}]]></shop_tel>
            <region><![CDATA[{##RSSAREA1##}]]></region>
            <shop_address><![CDATA[{##SUP_ADDRESS##}]]></shop_address>
        </shop>
    </shops>
</deal>";

##FORLOOP
RunLoop($dataForm);

##END
echo "</deals>";
echo "</coupon_feed>";
?>