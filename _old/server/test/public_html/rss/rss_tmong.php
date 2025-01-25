<?php

header("Content-Type: text/html; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
include "./addon_rss.php";

##START
$slntype = get_slntype();
$company = getRow("SELECT * FROM ".$slntype."Company");  //회사기본설정

echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<timong>";
echo "<name><![CDATA[$company[homepage_title]]]></name>";
echo "<home><![CDATA[$_SERVER[HTTP_HOST]]]></home>";
echo "<logo_image />";
echo "<products>";

##DATA FORMAT
$dataForm = "
<product>
    <start_dt><![CDATA[{##STT_DATETIME##}]]></start_dt>
    <end_dt><![CDATA[{##END_DATETIME##}]]></end_dt>
    <title><![CDATA[{##PNAME##}]]></title>
    <description><![CDATA[{##PMSG##}]]></description>
    <url><![CDATA[$_SERVER[HTTP_HOST]/?cateCode={##AID##}&viewCode={##PID##}]]></url>
    <original>{##PRICEO##}</original> 
    <discount>{##PRICER##}</discount> 
    <price>{##PRICES##}</price> 
    <max_count>{##CNTMAX##}</max_count> 
    <min_count>{##CNTMIN##}</min_count> 
    <now_count>{##CNTSALE##}</now_count>
    <shops>
        <shop>
            <shop_name><![CDATA[{##SUP_NAME##}]]></shop_name>
            <shop_tel><![CDATA[{##SUP_TEL1##}-{##SUP_TEL2##}-{##SUP_TEL3##}]]></shop_tel>
            <shop_address><![CDATA[{##SUP_ADDRESS##}]]></shop_address>
            <region><![CDATA[{##RSSAREA1##}]]></region>
        </shop>
    </shops>
    <category><![CDATA[{##CATEGORY##}]]></category>
    <images>
        <image><![CDATA[http://$_SERVER[HTTP_HOST]{##PIMG##}]]></image>
    </images>    
</product>";

##FORLOOP
RunLoop($dataForm);

##END
echo "</products>";
echo "</timong>";
?>