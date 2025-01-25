<?php if(!defined("__ZBXE__")) exit();?>
<?php
$oTemplate = &TemplateHandler::getInstance();
print $oTemplate->compile('./modules/install/tpl/','header.html');
?>


<h2 class="xeAdmin"><?php @print($__Context->lang->introduce_title);?></h2>

<div id="agreement"><?php @print(nl2br($__Context->lang->license));?></div>

<div class="tCenter">
    Select language : <select name="lang_type" onchange="doChangeLangType(this)">
        <?php $Context->__idx[0]=0;if(count($__Context->lang_supported))  foreach($__Context->lang_supported as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
        <option value="<?php @print($__Context->key);?>" <?php  if($__Context->key == $__Context->lang_type){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val);?></option>
        <?php  } ?>
    </select>
</div>

<div class="tCenter gap1">
    <a class="button blue" href="<?php @print(getUrl('','act','dispInstallCheckEnv'));?>"><span><?php @print($__Context->lang->cmd_agree_license);?></span></a>
</div>

<?php
$oTemplate = &TemplateHandler::getInstance();
print $oTemplate->compile('./modules/install/tpl/','footer.html');
?>

