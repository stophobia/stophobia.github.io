<?
//-----------------------------------------------------------------------------
// 상품등록시 메인상품인지 서브상품인지 체크하는 페이지
//-----------------------------------------------------------------------------
include "../../odcommon/od_config.inc.php";
include "../../odcommon/od_lib.inc.php";
include "../odcommon/od_function.inc.php";   

// 지역구분 + 해당일자에 제일 먼저 등록된 데이타를 하나 추출 //////////////////
$common_query = "
	and ( 
		(sale_date <='".$_GET[sale_date]."' and  sale_enddate >'".$_GET[sale_date]."')
		||
		(sale_date <'".$_GET[sale_enddate]."' and  sale_enddate >='".$_GET[sale_enddate]."')
	)
";
$Query  = "select * from odtProduct where parent_code=code and cateCode = '".$_GET[cateCode]."' $common_query order by inputDate limit 1  ";
$Result = mysql_query($Query);

if (0 == mysql_num_rows($Result))
{
    // 추출된 데이타가 없을때는 등록된 상품이 없으므로 메인상품처리 ///////////
    echo "
    <script>
    parent.document.getElementById('pro_type').innerHTML = '(메인상품)';
    parent.document.snsForm.parent_code.value = parent.document.snsForm.code.value;
    </script>";
} 
else
{
    $Record = mysql_fetch_array($Result);

    // 추출된 데이타가 있을때 처리 ////////////////////////////////////////////
    if (!$_GET[code])
    {
        // 메인상품이 존재하고 새로 등록하는 상품정보일때는 서브상품으로 처리 /
        echo "
        <script>
        parent.document.getElementById('pro_type').innerHTML = '(서브상품) - ".$Record[name]."';
        parent.document.snsForm.parent_code.value = '".$Record[code]."';
        </script>";
    }
    else
    {
        // 기존 지역구분 + 해당일자에 해당하는 모든 데이타의 메인상품코드를 위에서 추출한 코드값으로 셋팅처리
        $Query2  = "update odtProduct set parent_code = '$Record[code]' where cateCode = '".$_GET[cateCode]."' $common_query ";
        $Result2 = mysql_query($Query2);

        // 넘어온 상품코드에 해당하는 데이타값을 추출 /////////////////////
        $Query3  = "select * from odtProduct where code = '".$_GET[code]."'     ";
        $Result3 = mysql_query($Query3);
        $Record3 = mysql_fetch_array($Result3);

        if ($Record3[code] == $Record[parent_code])
        {
            echo "
            <script>
            parent.document.getElementById('pro_type').innerHTML = '(메인상품)';
            parent.document.snsForm.parent_code.value = parent.document.snsForm.code.value;
            </script>";
        }
        else
        {
            echo "
            <script>
            parent.document.getElementById('pro_type').innerHTML = '(서브상품) - ".$Record[name]."';
            parent.document.snsForm.parent_code.value = '".$Record[code]."';
            </script>";
        }
    }
}

exit;
?>