<?php if(!defined("__ZBXE__")) exit();?>
<?php
$oTemplate = &TemplateHandler::getInstance();
print $oTemplate->compile('./modules/install/tpl/','header.html');
?>


<h2 class="xeAdmin"><?php @print($__Context->lang->install_condition_title);?></h2>

<table cellspacing="0" class="tableType6">
<col width="180" /><col />

<?php $Context->__idx[0]=0;if(count($__Context->checklist))  foreach($__Context->checklist as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
<tr>
    <th scope="row"><?php @print($__Context->lang->install_checklist_title[$__Context->key]);?></th>
    <td>
        <?php  if($__Context->val){ ?>
            <?php @print($__Context->lang->enable);?>
        <?php  }else{ ?>
            <span class="none"><?php @print($__Context->lang->disable);?></span>
            <br /><?php @print($__Context->lang->install_checklist_desc[$__Context->key]);?>
        <?php  } ?>
    </td>
</tr>
<?php  } ?>
</table>

<div class="buttonCenter">
    <?php  if($__Context->install_enable){ ?>
        <a href="<?php @print(getUrl('','act','dispInstallSelectDB'));?>" class="button blue"><span><?php @print($__Context->lang->cmd_install_next);?></span></a>
    <?php  }else{ ?>
        <a href="<?php @print(getUrl('','act',$__Context->act));?>" class="button red"><span><?php @print($__Context->lang->cmd_install_fix_checklist);?></span></a>
    <?php  } ?>
</div>

<?php
$oTemplate = &TemplateHandler::getInstance();
print $oTemplate->compile('./modules/install/tpl/','footer.html');
?>

