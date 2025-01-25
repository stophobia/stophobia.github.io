<?php if(!defined("__ZBXE__")) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php @print(Context::getLangType());?>" xml:lang="<?php @print(Context::getLangType());?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="Generator" content="XpressEngine <?php @print(__ZBXE_VERSION__);?>" />
<?php  if($__Context->module_info->module){ ?>
    <meta name="module" content="<?php @print($__Context->module_info->module);?>" />
<?php  } ?>
<?php  if($__Context->module_info->skin){ ?>
    <meta name="module_skin" content="<?php @print($__Context->module_info->skin);?>" />
<?php  } ?>
<?php  if($__Context->layout_info->title){ ?>
    <meta name="layout" content="<?php @print($__Context->layout_info->title);?> (<?php @print($__Context->layout_info->layout);?>)" />
<?php  } ?>
<?php  if($__Context->layout_info->author){ ?>
    <?php $Context->__idx[1]=0;if(count($__Context->layout_info->author))  foreach($__Context->layout_info->author as $__Context->author){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
    <meta name="layout_maker" content="<?php @print($__Context->author->name);?> (<?php @print($__Context->author->homepage);?>)" />
    <?php  } ?>
<?php  } ?>
    <meta http-equiv="imagetoolbar" content="no" />
    <title><?php @print(Context::getBrowserTitle());?></title>
<?php @$__Context->css_files = Context::getCssFile();?>
<?php $Context->__idx[2]=0;if(count($__Context->css_files))  foreach($__Context->css_files as $__Context->key => $__Context->css_file){$__Context->__idx[3]=($__Context->__idx[3]+1)%2; $__Context->cycle_idx = $__Context->__idx[3]+1; ?>
<?php  if($__Context->css_file['targetie']){ ?>
    <!--[if <?php @print($__Context->css_file['targetie']);?>]>
<?php  } ?>
    <link rel="stylesheet" href="<?php @print($__Context->css_file['file']);?>" type="text/css" charset="UTF-8" media="<?php @print($__Context->css_file['media']);?>" />
<?php  if($__Context->css_file['targetie']){ ?>
    <![endif]-->
<?php  } ?>
<?php  } ?>
<?php @$__Context->js_files = Context::getJsFile();?>
<?php $Context->__idx[3]=0;if(count($__Context->js_files))  foreach($__Context->js_files as $__Context->key => $__Context->js_file){$__Context->__idx[4]=($__Context->__idx[4]+1)%2; $__Context->cycle_idx = $__Context->__idx[4]+1; ?>
<?php  if($__Context->js_file['targetie']){ ?>
    <!--[if <?php @print($__Context->js_file['targetie']);?>]>
<?php  } ?>
    <script type="text/javascript" src="<?php @print($__Context->js_file['file']);?>"></script>
<?php  if($__Context->js_file['targetie']){ ?>
    <![endif]-->
<?php  } ?>
<?php  } ?>
<?php  if($__Context->rss_url){ ?>
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php @print($__Context->rss_url);?>" />
    <link rel="alternate" type="application/atom+xml" title="Atom" href="<?php @print($__Context->atom_url);?>" />
<?php  } ?>
<?php  if($__Context->general_rss_url){ ?>
    <link rel="alternate" type="application/rss+xml" title="Site RSS" href="<?php @print($__Context->general_rss_url);?>" />
    <link rel="alternate" type="application/atom+xml" title="Site Atom" href="<?php @print($__Context->general_atom_url);?>" />
<?php  } ?>

<?php @$__Context->ssl_actions = Context::getSSLActions();?>
    <script type="text/javascript">//<![CDATA[
        var current_url = "<?php @print($__Context->current_url);?>";
        var request_uri = "<?php @print($__Context->request_uri);?>";
<?php  if($__Context->vid){ ?>var xeVid = "<?php @print($__Context->vid);?>";<?php  } ?>
        var current_mid = "<?php @print($__Context->mid);?>";
        var waiting_message = "<?php @print($__Context->lang->msg_call_server);?>";
        var ssl_actions = new Array(<?php  if(count($__Context->ssl_actions)){ ?>"<?php @print(implode('","',$__Context->ssl_actions));?>"<?php  } ?>);
        var default_url = "<?php @print(Context::getDefaultUrl());?>";
        <?php  if(Context::get("_http_port")){ ?>var http_port = <?php @print(Context::get("_http_port"));?>;<?php  } ?>
        <?php  if(Context::get("_https_port")){ ?>var https_port = <?php @print(Context::get("_https_port"));?>;<?php  } ?>
        <?php  if(Context::get("_use_ssl") && Context::get("_use_ssl") == "always"){ ?>var enforce_ssl = true;<?php  } ?>

    //]]></script>

    <?php @print(Context::getHtmlHeader());?>

</head>
<body<?php @print(Context::getBodyClass());?>>
    <?php @print(Context::getBodyHeader());?>

    <?php @print($__Context->content);?>

    <?php @print(Context::getHtmlFooter());?>

    <div id="waitingforserverresponse"></div>

</body>
</html>