<div class="unit-sidebar">
    <div class="unit-sidebar__icon js-sidebar-menu-close">
        <svg class="icon horiz-vert-center" viewBox="0 0 15.642 15.642">
            <use xlink:href="#icon__close"></use>
        </svg>
    </div>
    <div class="unit-sidebar__wrap js-custom-scroll js--cursor-def">
        <div class="unit-sidebar__contain unit-sidebar__contain--logo">
            <div class="unit-logo">
		<a href="/">
                <svg class="icon" viewBox="0 0 402 197.7">
                    <use xlink:href="#main-logo"></use>
                </svg>
		</a>
            </div>
            <div class="unit-name-project">Каталог предпринимателей<br> Калужской области</div>
        </div>

	<?$APPLICATION->IncludeComponent("bitrix:menu", "menu", Array(
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
		"CHILD_MENU_TYPE" => "top",	// Тип меню для остальных уровней
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
			0 => "",
		),
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_TYPE" => "N",	// Тип кеширования
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
		"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	),
	false
);?>
        <div class="unit-sidebar__contain unit-sidebar__contain--button">
            <span data-src="#popup__registration" class="btn btn--green btn--no-fill js-popup">Регистрация <span class="mobile-hide">в каталоге</span></span>
        </div>
    </div>
</div>