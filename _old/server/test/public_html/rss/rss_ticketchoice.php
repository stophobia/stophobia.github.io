<?php

header("Content-Type: text/html; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
include "./addon_rss.php";

##START
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
echo "<products>";

##DATA FORMAT
$dataForm = "
<product>
    <url><![CDATA[{##LINK##}]]></url> 
    <division><![CDATA[{##CATEGORY##}]]></division>
    <region1><![CDATA[{##RSSAREA1##}]]></region1>
    <region2><![CDATA[{##RSSAREA2##}]]></region2>
    <name><![CDATA[{##PNAME##}]]></name>
    <image1><![CDATA[{##PIMG##}]]></image1> 
    <image2><![CDATA[{##PIMG##}]]></image2> 
    <image3><![CDATA[{##PIMG##}]]></image3> 
    <descript><![CDATA[{##PMSG##}]]></descript> 
    <price><![CDATA[{##PRICEO##}]]></price> 
    <saleprice><![CDATA[{##PRICES##}]]></saleprice>
    <salerate><![CDATA[{##PRICER##}]]></salerate>
    <mincnt><![CDATA[{##CNTMIN##}]]></mincnt> 
    <maxcnt><![CDATA[{##CNTMAX##}]]></maxcnt> 
    <salecnt><![CDATA[{##CNTSALE##}]]></salecnt> 
    <startdate><![CDATA[{##STT_DATETIME##}]]></startdate> 
    <enddate><![CDATA[{##END_DATETIME##}]]></enddate> 
    <shop_address><![CDATA[{##SUP_ADDRESS##}]]></shop_address>
    <shop_name><![CDATA[{##SUP_NAME##}]]></shop_name>
    <shop_tel><![CDATA[{##SUP_TEL1##}-{##SUP_TEL2##}-{##SUP_TEL3##}]]></shop_tel>
    <lng><![CDATA[]]></lng>
    <lat><![CDATA[]]></lat>
</product>";

##FORLOOP
RunLoop($dataForm);

##END
echo "</products>";
?>