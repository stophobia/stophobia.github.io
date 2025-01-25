function install(fo_obj){
	var validator = xe.getApp('validator')[0];
	if(!validator) return false;
	if(!fo_obj.elements['_filter']) jQuery(fo_obj).prepend('<input type="hidden" name="_filter" value="" />');
	fo_obj.elements['_filter'].value = 'install';
	validator.cast('ADD_CALLBACK', ['install', function(form){
		var params={}, responses=[], elms=form.elements, data=jQuery(form).serializeArray();
		jQuery.each(data, function(i, field){
			var val = jQuery.trim(field.value);
			if(!val) return true;
			if(/\[\]$/.test(field.name)) field.name = field.name.replace(/\[\]$/, '');
			if(params[field.name]) params[field.name] += '|@|'+val;
			else params[field.name] = field.value;
		});
		params['password'] = params['password1']; delete params['password1'];
		responses = ['error','message','redirect_url'];
		exec_xml('install','procInstall', params, completeInstalled, responses, params, form);
	}]);
	validator.cast('VALIDATE', [fo_obj,'install']);
	return false;
};

(function($){
	var validator = xe.getApp('Validator')[0];
	if(!validator) return false;
	validator.cast('ADD_FILTER', ['install', {
		'db_type': {required:true},
		'db_hostname': {required:true,minlength:1,maxlength:250},
		'db_port': {minlength:1,maxlength:250},
		'db_userid': {required:true,minlength:1,maxlength:250},
		'db_password': {required:true,minlength:1,maxlength:250},
		'db_database': {required:true,minlength:1,maxlength:250},
		'db_table_prefix': {required:true,minlength:2,maxlength:20,rule:'alpha'},
		'user_id': {required:true,minlength:2,maxlength:20,rule:'userid'},
		'password1': {required:true,minlength:1,maxlength:20},
		'password2': {required:true,minlength:1,equalto:'password1'},
		'user_name': {required:true,minlength:2,maxlength:20},
		'nick_name': {required:true,minlength:2,maxlength:20},
		'email_address': {required:true,minlength:1,maxlength:200,rule:'email'}
	}]);
	validator.cast('ADD_MESSAGE', ['db_type', 'データベースの種類']);
	validator.cast('ADD_MESSAGE', ['db_hostname', 'ホスト名']);
	validator.cast('ADD_MESSAGE', ['db_port', 'ポート番号']);
	validator.cast('ADD_MESSAGE', ['db_userid', 'ユーザＩＤ']);
	validator.cast('ADD_MESSAGE', ['db_password', 'パスワード']);
	validator.cast('ADD_MESSAGE', ['db_database', 'データベース名']);
	validator.cast('ADD_MESSAGE', ['db_table_prefix', 'テーブルプレフィックス']);
	validator.cast('ADD_MESSAGE', ['user_id', 'ユーザーＩＤ']);
	validator.cast('ADD_MESSAGE', ['password1', 'パスワード']);
	validator.cast('ADD_MESSAGE', ['password2', 'パスワード確認']);
	validator.cast('ADD_MESSAGE', ['user_name', '名前']);
	validator.cast('ADD_MESSAGE', ['nick_name', 'ニックネーム']);
	validator.cast('ADD_MESSAGE', ['email_address', 'メールアドレス']);
	validator.cast('ADD_MESSAGE', ['password', 'パスワード']);
	validator.cast('ADD_MESSAGE', ['use_rewrite', 'リライト・モジュールを使用']);
	validator.cast('ADD_MESSAGE', ['time_zone', 'タイムゾーン']);
	validator.cast('ADD_MESSAGE', ['isnull', '%sを入力して下さい。']);
	validator.cast('ADD_MESSAGE', ['outofrange', '%sの文字の長さを合わせて下さい。']);
	validator.cast('ADD_MESSAGE', ['equalto', '%sが正しくありません。']);
	validator.cast('ADD_MESSAGE', ['invalid_email', '%sのパターンが正しくありません。 (例: zbxe@xepressengine.com)']);
	validator.cast('ADD_MESSAGE', ['invalid_userid', '%sの形式が正しくありません。\n半角の英数と記号「_」を組み合わせて入力して下さい。頭字は半角英文字でなければなりません。']);
	validator.cast('ADD_MESSAGE', ['invalid_user_id', '%sの形式が正しくありません。\n半角の英数と記号「_」を組み合わせて入力して下さい。頭字は半角英文字でなければなりません。']);
	validator.cast('ADD_MESSAGE', ['invalid_homepage', '%sの形式が正しくありません。 (例: http://www.xepressengine.com)']);
	validator.cast('ADD_MESSAGE', ['invalid_korean', '%sの形式が正しくありません。ハングルのみ入力して下さい。']);
	validator.cast('ADD_MESSAGE', ['invalid_korean_number', '%sの形式が正しくありません。ハングルと半角数字で入力して下さい。']);
	validator.cast('ADD_MESSAGE', ['invalid_alpha', '%sの形式が正しくありません。半角英文字のみ入力して下さい。']);
	validator.cast('ADD_MESSAGE', ['invalid_alpha_number', '%sの形式が正しくありません。半角英数で入力して下さい。']);
	validator.cast('ADD_MESSAGE', ['invalid_number', '%sの形式が正しくありません。半角数字で入力して下さい。']);
})(jQuery);