<?
	header("Content-Type: text/xml; charset=utf-8");

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


	/* 상품 지역 분류 정보를 가져온다 */
	$qry_LML = "SELECT catecode, catename FROM odtCategory WHERE (catecode > '06') And (cHidden = 'no') ORDER BY catecode";
	$res_LML = mysql_query($qry_LML);
	$num_LML = mysql_num_rows($res_LML);

	$row_count = 0;
	for ($i=0;$i<=($num_LML - 1);$i++) {
		mysql_data_seek($res_LML,$i);
		$row = mysql_fetch_array($res_LML);

		$Aid_arr[$row_count] = $row[catecode];
		$Aidname_arr[$row_count] = $row[catename];

	//	echo "catecode = ".$Aid_arr[$row_count]."<br>";

		$row_count++;
	}
	/* 상품 지역 분류 정보를 가져온다 */

	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>"."\n";
?>
<products>
<?
	for($row_num=0;$row_num<count($Aid_arr);$row_num++){
		$code = saleItem($Aid_arr[$row_num]);
		$Pinfo = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$code."'"));
		$minPrice = @mysql_result(mysql_query("select price from odtProduct where parent_code ='".$code."' order by mainPrice=1 desc, price asc limit 1"),0);
		$coupon = @mysql_result(mysql_query("select coupon_sale from odtProduct where parent_code = code and and code ='".$code."'"),0);
		$minPrice = $minPrice - $coupon;
		$proCnt = @mysql_fetch_array(mysql_query("select max(price) as max ,min(price) as min from odtProduct where parent_code='".$code."'" ));
		if($proCnt['max'] != $proCnt['min']) {
			$Pinfo[price] = number_format($minPrice)."원~";
		} else	 {
			$Pinfo[price] = number_format($minPrice)."원";
		}

		$userInfo = mysql_fetch_array(mysql_query("select * from odtMember where id='".$Pinfo[customerCode]."'"));

		$Pinfo[price_org] = number_format($Pinfo[price_org])."원";

		$homepage = reset(explode("/",str_replace("http://","",str_replace("www.","",$row_company[homepage]))));

		if ($Pinfo[parent_code] != "") {
?>
	<product>
		<product_id>
			<![CDATA[<?=$Pinfo[parent_code]?>]]>
		</product_id>
		<sale_start>
			<![CDATA[<?=$Pinfo[sale_date]?> 00:00:00]]>
		</sale_start>
		<sale_end>
			<![CDATA[<?=date('Y-m-d H:i:s',strtotime(date_nextsale($Aid))-1)?>]]>
		</sale_end>
		<coupon_use_start>
			<![CDATA[]]>
		</coupon_use_start>
		<coupon_use_end>
			<![CDATA[]]>
		</coupon_use_end>
		<product_title>
			<![CDATA[<?=$Pinfo[name]?>]]>
		</product_title>
		<product_desc>
			<![CDATA[<?=$Pinfo[message]?>]]>
		</product_desc>
		<product_area>
			<![CDATA[<?=$Aidname_arr[$row_num]?>]]>
		</product_area>
		<product_url>
			<![CDATA[http://<?=$homepage?>/change_chart.php?cateCode=<?=$Aid_arr[$row_num]?>&amp;viewCode=<?=$Pinfo[parent_code]?>]]>
		</product_url>
		<price_normal><?=$Pinfo[price_org]?></price_normal>
		<discount_rate><?=$Pinfo[price_per]?></discount_rate>
		<price_discount><?=$Pinfo[price]?></price_discount>
		<buy_max><?=$Pinfo[stockMax]?></buy_max>
		<buy_limit><?=$Pinfo[saleCntMax]?></buy_limit>
		<buy_count><?=$Pinfo[saleCnt]?></buy_count>
		<shop_name>
			<![CDATA[<?=$Pinfo[customerName]?>]]>
		</shop_name>
		<shop_address>
			<![CDATA[<?=$userInfo[address]?>]]>
		</shop_address>
		<shop_tel>
			<![CDATA[<?=$userInfo[tel1]?>-<?=$userInfo[tel2]?>-<?=$userInfo[tel3]?>]]>
		</shop_tel>
		<image_url1>
			<![CDATA[<?="http://".$homepage.$Pinfo[main_img]?>]]>
		</image_url1>
	</product>
<?
		}
	}
?>
</products>