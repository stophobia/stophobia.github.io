<?php if(!defined("__ZBXE__")) exit();?>
<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$oXmlFilter = new XmlJSFilter("modules/install/tpl/filter/","mysql.xml");
$oXmlFilter->compile();
?>

<!--Meta:modules/install/tpl/js/install_admin.js--><?php Context::addJsFile("modules/install/tpl/js/install_admin.js", true, ""); ?>
<?php
$oTemplate = &TemplateHandler::getInstance();
print $oTemplate->compile('./modules/install/tpl/','header.html');
?>


<form action="./" method="post" onsubmit="return procFilter(this, install)">
<input type="hidden" name="db_type" value="<?php @print($__Context->db_type);?>" />

<h2 class="xeAdmin"><?php @print($__Context->lang->form_title);?></h2>

    <table cellspacing="0" class="tableType7">
    <col width="100" />
    <col width="160" />
    <col />

    <tr>
        <th rowspan="6" class="hr" scope="row"><?php @print($__Context->db_type);?></th>
        <th class="second" scope="row"><label for="textfield11"><?php @print($__Context->lang->db_hostname);?></label></th>
        <td><input type="text" name="db_hostname" value="localhost" class="inputTypeText w100" id="textfield11" /></td>
    </tr>
    <tr>
        <th class="second" scope="row"><label for="textfield12"><?php @print($__Context->lang->db_port);?></label></th>
        <td><input type="text" name="db_port" value="3306" class="inputTypeText w100" id="textfield12" /></td>
    </tr>
    <tr>
        <th class="second" scope="row"><label for="textfield13"><?php @print($__Context->lang->db_userid);?></label></th>
        <td><input type="text" name="db_userid" value="" class="inputTypeText w100" id="textfield13" /></td>
    </tr>
    <tr>
        <th class="second" scope="row"><label for="textfield14"><?php @print($__Context->lang->db_password);?></label></th>
        <td><input type="password" name="db_password" value="" class="inputTypeText w100" id="textfield14" /></td>
    </tr>
    <tr>
        <th class="second" scope="row"><label for="textfield15"><?php @print($__Context->lang->db_database);?></label></th>
        <td><input type="text" name="db_database" value="" class="inputTypeText w100" id="textfield15" /></td>
    </tr>
    <tr>
        <th class="second hr" scope="row"><label for="textfield16"><?php @print($__Context->lang->db_table_prefix);?></label></th>
        <td class="hr"><input type="text" name="db_table_prefix" value="xe" class="inputTypeText w100" id="textfield16" /></td>
    </tr>

    <?php
$oTemplate = &TemplateHandler::getInstance();
print $oTemplate->compile('./modules/install/tpl/','form.install.html');
?>


    </table>

    <div class="buttonCenter">
        <span class="button blue"><input type="submit" value="<?php @print($__Context->lang->cmd_registration);?>" /></span>
    </div>

</form>

<?php
$oTemplate = &TemplateHandler::getInstance();
print $oTemplate->compile('./modules/install/tpl/','footer.html');
?>

