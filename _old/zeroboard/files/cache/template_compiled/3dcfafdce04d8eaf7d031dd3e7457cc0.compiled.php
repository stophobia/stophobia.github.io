<?php if(!defined("__ZBXE__")) exit();?>
<?php
$oTemplate = &TemplateHandler::getInstance();
print $oTemplate->compile('./modules/install/tpl/','header.html');
?>


<h2 class="xeAdmin"><?php @print($__Context->lang->select_db_type);?></h2>

    <form method="post" action="./">
    <input type="hidden" name="module" value="<?php @print($__Context->module);?>" />
    <input type="hidden" name="act" value="dispInstallForm" />

    <table cellspacing="0" class="tableType6">
    <col width="180" /><col />
    <?php $Context->__idx[0]=0;if(count(DB::getSupportedList()))  foreach(DB::getSupportedList() as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
    <tr>
        <th scope="row">
            <input type="radio" name="db_type" value="<?php @print($__Context->val->db_type);?>" <?php  if(!$__Context->val->enable){ ?>disabled="disabled"<?php  } ?> id="db_type_<?php @print($__Context->val->db_type);?>" <?php  if($__Context->val->db_type=="mysql"){ ?>checked="checked"<?php  } ?>/>
            <label for="db_type_<?php @print($__Context->val->db_type);?>"><?php @print($__Context->val->db_type);?></label>
        </th>
        <td><?php @print($__Context->lang->db_desc[$__Context->val->db_type]);?></td>
    </tr>
    <?php  } ?>
    </table>

    <div class="buttonCenter">
        <span class="button blue"><input type="submit" value="<?php @print($__Context->lang->cmd_install_next);?>" /></span>
    </div>

    </form>

<?php
$oTemplate = &TemplateHandler::getInstance();
print $oTemplate->compile('./modules/install/tpl/','footer.html');
?>

