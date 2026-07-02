<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?> 
<? global $USER;
	
if (!$USER->IsAuthorized() && !CSite::InDir('/auth/')&& !CSite::InDir('/api/')){
	header('location:/auth/');
	exit;
}
?>
<!DOCTYPE HTML>
<html lang="ru-RU">
    <head>
	<? IncludeTemplateLangFile(__FILE__); ?> 
	<meta charset="utf-8"/>
	<meta content="telephone=no" name="format-detection"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="HandheldFriendly" content="true"/>
	<? $APPLICATION->ShowHead(); ?>
	<script>
		var app = {
			  data:{  },
			  config:{  }
			 };
		window.app = {};
		//app.config.bx24crmlink = <?=BX_CRM_URL?>;
	</script>
	<title><? $APPLICATION->ShowTitle() ?> </title> 
	<link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH ?>/favicon.ico?v.1.1" type="image/x-icon">
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/assets/st/css/main.css">
	
	<?
		//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.min.js");
		 $APPLICATION->AddHeadScript("https://yastatic.net/jquery/3.1.1/jquery.min.js?ver=2.2"); ?>	
    </head>

    <body <?
    if ($USER->isAdmin()) {
	    echo 'id="bx-admin"';
    }
    ?>>
	    <? if ($USER->isAdmin()): ?>
		<div>
		    <? $APPLICATION->ShowPanel(); ?>   
		</div>
	<? endif ?>
        <div class="unit-main">
	    <header class="unit-header">
		<? include 'inc/header-top.php' ?>
	    </header>
	    <div class="unit-body">
                <div class="unit-wrapper">

<?


?>