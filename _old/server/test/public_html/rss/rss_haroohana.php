<?php

header("Content-Type: text/html; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
include "./addon_rss.php";

##START
$slntype = get_slntype();
$company = getRow("SELECT * FROM ".$slntype."Company");  //회사기본설정

echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<root>";
echo "<company_id><![CDATA[$company[homepage_title]]]></company_id>";

##DATA FORMAT
$dataForm = "
<coupon>
    <id>{##PID##}</id> 
    <title><![CDATA[{##PNAME##}]]></title>
    <category>{##CATEID##}</category> 
    <description><![CDATA[{##PMSG##}]]></description>
    <original_price>{##PRICEO##}</original_price> 
    <discount_price>{##PRICES##}</discount_price> 
    <discount_description><![CDATA[{##PRICER##}%할인]]></discount_description>
    <image>{##PIMG##}</image> 
    <start_date>{##STT_DATETIME##}</start_date> 
    <end_date>{##END_DATETIME##}</end_date> 
    <link><![CDATA[{##LINK##}]]></link> 
    <mobile_link><![CDATA[]]></mobile_link> 
    <coupon_company>{##SUP_NAME##}</coupon_company> 
    <coupon_sale_max>{##CNTMAX##}</coupon_sale_max> 
    <coupon_sale_condition></coupon_sale_condition> 
    <coupon_sale_count>{##CNTSALE##}</coupon_sale_count> 
    <coupon_start_date>{##STT_DATETIME##}</coupon_start_date> 
    <coupon_end_date>{##END_DATETIME##}</coupon_end_date> 
    <coupon_address>{##SUP_ADDRESS##}</coupon_address> 
    <coupon_latitude /> 
    <coupon_longitude /> 
    <coupon_phone>{##SUP_TEL1##}-{##SUP_TEL2##}-{##SUP_TEL3##}</coupon_phone> 
</coupon>";


##FORLOOP
RunLoop($dataForm);

##END
echo "</root>";
?>