<?php

header("Content-Type: text/html; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
include "./addon_rss.php";

##START
echo "<dailycost>";

##DATA FORMAT
$dataForm = "
<saleitem>
    <saleid><![CDATA[{##PIDNUM##}]]></saleid>
    <title><![CDATA[[{##PNAME##}]]></title>
    <descript><![CDATA[{##PMSG##}]]></descript>
    <areacode>100</areacode>
    <areatxt><![CDATA[{##RSSAREA1##}]]></areatxt>
    <category>100</category>
    <categorytxt><![CDATA[{##CATEGORY##}]]></categorytxt>
    <price><![CDATA[{##PRICEO##}]]></price>
    <dcprice><![CDATA[{##PRICES##}]]></dcprice>
    <dcpercent><![CDATA[{##PRICER##}]]></dcpercent>
    <imgurl><![CDATA[{##PIMG##}]]></imgurl>
    <linkurl><![CDATA[{##LINK##}]]></linkurl>
    <enddate><![CDATA[{##END_DATETIME##}]]></enddate>
    <maxcnt><![CDATA[{##CNTMAX##}]]></maxcnt>
    <minicnt><![CDATA[{##CNTMIN##}]]></minicnt>
    <salecnt><![CDATA[{##CNTSALE##}]]></salecnt>
    <address><![CDATA[{##SUP_ADDRESS##}]]></address>
    <phone>{##SUP_TEL1##}-{##SUP_TEL2##}-{##SUP_TEL3##}</phone>
</saleitem>";

##FORLOOP
RunLoop($dataForm);

##END
echo "</dailycost>";
?>