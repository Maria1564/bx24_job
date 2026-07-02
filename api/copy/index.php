<?
	$GLOBALS['H1_NO_USE'] = "Y";
	$GLOBALS['NOT_USE_CONTENT_WRAP'] = "Y";
	$GLOBALS['SHOW_ABOUT'] = "N";
	$GLOBALS['SHOW_REGFORM'] = "N";
	$GLOBALS['THEME_CLASS'] = "html--header-dark";
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("Бережливое производство");
?>


<div class="unit-breadcrumbs unit-breadcrumbs--small" style="    top: 160px;">
	<div class="unit-wrapper">
		<div class="unit-breadcrumbs__list" itemprop="http://schema.org/breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
			<div class="unit-breadcrumbs__list-item" id="bx_breadcrumb_0" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
				<a href="/" title="" itemprop="url">
					Главная
				</a>
			</div>
			<div class="bx-breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
				Бережливое производство
			</div>
		</div>
	</div>
</div>
<div class="unit-about-project-presentation__subnav" style="margin-top:100px;">
	<div class="unit-wrapper">
		<a href="#" class="unit-about-project-presentation__subnav-item" data-number="0">О проекте</a>
		<a href="#" class="unit-about-project-presentation__subnav-item" data-number="1">Участие</a>
		<a href="#" class="unit-about-project-presentation__subnav-item" data-number="2">Новости</a>
		<a href="#" class="unit-about-project-presentation__subnav-item" data-number="3">Вопросы и ответы</a>
		<a href="#" class="unit-about-project-presentation__subnav-item" data-number="4">Команда</a>
		<a href="#" class="unit-about-project-presentation__subnav-item" data-number="5">Контакты</a>
	</div>
</div>


<div class="unit-about-project-presentation">
	<div class="unit-about-project-presentation__contain-graphic" style="background-image:url(img/bg-3.png)">
		<div class="unit-wrapper">
			<div class="unit-title__group">
				<div class="unit-about-project-presentation__subtitle">
					Внедрим
				</div>
				<h1 class="unit-about-project-presentation__title">бережливое<br>производство<br>в вашем бизнесе</h1>
			</div>
		</div>
		<div class="unit-about-project-presentation__nav-popups">
			<a href="#" class="unit-about-project-presentation__nav-popups-item">
				Получить<br>финансирование
			</a>
			<a href="#" class="unit-about-project-presentation__nav-popups-item">
				Пройти диагностику<br>организации
			</a>
			<a href="#" class="unit-about-project-presentation__nav-popups-item">
				Стать<br>участником проекта
			</a>
		</div>
	</div>
</div>
<? /**** + О ПРОЕКТЕ ****/?>
<? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "MODE" => 'php', "PATH" => '_about-project.php')); ?>  

<? /**** КАК СТАТЬ УЧАСТНИКОМ ****/?>
<? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "MODE" => 'php', "PATH" => '_how-to-participant.php')); ?>  

<? /**** Участники проекта ****/?>
<? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "MODE" => 'php', "PATH" => '_project-users.php')); ?>

<? /**** Новости, пресса о нас ****/?>
<? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "MODE" => 'php', "PATH" => '_news.php')); ?>

<? /**** + faq ****/?>
<? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "MODE" => 'php', "PATH" => '_faq.php')); ?>

<? /**** +- Контакты ****/?>
<? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "MODE" => 'php', "PATH" => '_contacts.php')); ?>

<? /**** Оставьте заявку ****/?>
<? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "MODE" => 'php', "PATH" => '_bottom-form.php')); ?>




<link rel="stylesheet" href="css/main.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<script src="js/jquery.matchHeight-min.js"></script>
<script src="js/app.js"></script>




<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>