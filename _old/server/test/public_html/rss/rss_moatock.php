<?php

header("Content-Type: text/html; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
include "./addon_rss.php";

##START
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
echo "<rss version='2.0' xmlns:dc='http://purl.org/dc/elements/1.1/'>";
echo "<channel>";

##DATA FORMAT
$dataForm = "
<item>
    <title><![CDATA[{##PNAME##}]]></title>
    <time_start>{##STT_DATETIME##}</time_start>
    <time_end>{##END_DATETIME##}</time_end>
    <price_pub>{##PRICEO##}</price_pub>
    <price_sale>{##PRICES##}</price_sale>
    <sale>{##PRICER##}</sale>
    <pic_small><![CDATA[{##PIMG##}]]></pic_small>
    <link><![CDATA[{##LINK##}]]></link>
    <part><![CDATA[{##PTYPE##}]]></part>
    <category><![CDATA[{##CATEGORY##}]]></category>
    <area><![CDATA[{##RSSAREA1##}]]></area>
    <description><![CDATA[{##PMSG##}]]></description>
    <cnt_min>{##CNTMIN##}</cnt_min>
    <cnt_max>{##CNTMAX##}</cnt_max>
    <cnt_sale>{##CNTSALE##}</cnt_sale>
    <addr><![CDATA[{##SUP_ADDRESS##}]]></addr>
    <lng>0.0</lng>
    <lat>0.0</lat>
    <description_html><![CDATA[{##DESC_URL##}]]></description_html>
</item>";

##FORLOOP
RunLoop($dataForm);

##END
echo "</channel>";
echo "</rss>";
?>