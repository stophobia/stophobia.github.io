<?

echo "
<script>
    function f_win_form(img)
    {
        window.open('/odprogram/odmanager/odmall/img_form.php?img_name='+img, 'image','scrollbars=no, resizable=no, width=650,height=500,top=0,left=0');
    }
</script>
<table width='760' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td height='10'></td>
    </tr>
    <tr>
        <td><img src='/pages/skin/3/adm_img/skin_01_07.jpg' width='760' height='130' border='0' usemap='#Map'></td>
    </tr>
    <tr>
        <td height='20'></td>
    </tr>
    <tr>
        <td><img src='/pages/skin/3/adm_img/skin_01_15.jpg' width='760' height='149' border='0' usemap='#Map2'></td>
    </tr>
</table>
<map name='Map'>
    <area shape='rect' coords='320,25,496,57'   href=\"javascript:f_win_form('logo.gif');\">
    <area shape='rect' coords='706,40,744,58'   href=\"javascript:f_win_form('btn_paper.gif');\">
    <area shape='rect' coords='80,72,175,96'    href=\"javascript:f_win_form('main_menu01.gif');\">
    <area shape='rect' coords='175,73,245,95'   href=\"javascript:f_win_form('main_menu02.gif');\">
    <area shape='rect' coords='247,73,333,94'   href=\"javascript:f_win_form('main_menu03.gif');\">
    <area shape='rect' coords='334,73,436,95'   href=\"javascript:f_win_form('main_menu04.gif');\">
    <area shape='rect' coords='81,102,172,122'  href=\"javascript:f_win_form('main_menu01_hot.gif');\">
    <area shape='rect' coords='172,101,244,122' href=\"javascript:f_win_form('main_menu02_hot.gif');\">
    <area shape='rect' coords='247,102,332,123' href=\"javascript:f_win_form('main_menu03_hot.gif');\">
    <area shape='rect' coords='333,101,438,122' href=\"javascript:f_win_form('main_menu04_hot.gif');\">
</map>
<map name='Map2'>
    <area shape='rect' coords='70,25,235,62'    href=\"javascript:f_win_form('copy_logo.gif');\">
</map>";

?>