<?php if(!defined("__ZBXE__")) exit();?>
    <!-- 관리자 정보 -->
    <tr>
        <th rowspan="6" scope="row" class="hr"><label for="radio2"><?php @print($__Context->lang->admin_title);?></label></th>
        <th class="second" scope="row"><label for="textfield21"><?php @print($__Context->lang->user_id);?></label></th>
        <td><input type="text" id="textfield21" name="user_id" value="admin" class="inputTypeText" /></td>
    </tr>
    <tr>
        <th class="second" scope="row"><label for="textfield22"><?php @print($__Context->lang->password1);?></label></th>
        <td><input id="textfield22" type="password" name="password1" class="inputTypeText" /></td>
    </tr>
    <tr>
        <th class="second" scope="row"><label for="textfield23"><?php @print($__Context->lang->password2);?></label></th>
        <td><input id="textfield23" type="password" name="password2" class="inputTypeText" /></td>
    </tr>
    <tr>
        <th class="second" scope="row"><label for="textfield24"><?php @print($__Context->lang->user_name);?></label></th>
        <td><input id="textfield24" type="text" name="user_name" class="inputTypeText" /></td>
    </tr>
    <tr>
        <th class="second" scope="row"><label for="textfield25"><?php @print($__Context->lang->nick_name);?></label></th>
        <td><input id="textfield25" type="text" name="nick_name" class="inputTypeText" /></td>
    </tr>
    <tr>
        <th class="second hr" scope="row"><label for="textfield26"><?php @print($__Context->lang->email_address);?></label></th>
        <td class="hr"><input id="textfield26" type="text" name="email_address" class="inputTypeText" /></td>
    </tr>

    <!-- 기타 정보 -->
    <tr>
        <th rowspan="6" scope="row" class="borderBottomNone"><label for="radio2"><?php @print($__Context->lang->env_title);?></label></th>
        <th class="second" scope="row"><label for="textfield27"><?php @print($__Context->lang->use_rewrite);?></label></th>
        <td>
            <input type="checkbox" id="textfield27" name="use_rewrite" value="Y"  <?php  if(function_exists('apache_get_modules')&&in_array('mod_rewrite',apache_get_modules())){ ?>checked="checked"<?php  } ?> />
            <p><?php @print($__Context->lang->about_rewrite);?></p>
        </td>
    </tr>
    <tr>
        <th class="second" scope="row"><?php @print($__Context->lang->time_zone);?></th>
        <td>
            <select name="time_zone">
                <?php $Context->__idx[0]=0;if(count($__Context->time_zone))  foreach($__Context->time_zone as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
                    <option value="<?php @print($__Context->key);?>" <?php  if($__Context->key==date('O')){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val);?></option>
                <?php  } ?>
            </select>
            <p><?php @print($__Context->lang->about_time_zone);?></p>
        </td>
    </tr>
