<?
	
	$elements = $arResult['PROPERTIES']['ELEMENTS']['VALUE'];
	if(!$elements)return;
	//Получаем связанные элементы
	$GLOBALS['elFilter'] = ['ID'=>$elements];
?>

<div class="unit-about-project-users-participants unit-about-project-users-participants--case">
	<div class="unit-wrapper">
		<h2 class="unit-title unit-title--h2 unit-title--uppercase">
			Похожие проекты
		</h2>
	</div>
	<div class="unit-about-project-users-participants__nav">
		<div class="unit-about-project-users-participants__arrow unit-about-project-users-participants__arrow--left">
			<svg width="49" height="24" xmlns="http://www.w3.org/2000/svg"><path d="M.898 13.062a1.5 1.5 0 010-2.121l9.546-9.546a1.5 1.5 0 112.121 2.121L4.08 12.002l8.485 8.485a1.5 1.5 0 11-2.121 2.121L.898 13.062zm47.633.44H1.96v-3H48.53v3z" fill="#000" fill-rule="nonzero"/></svg>
		</div>
		<div class="unit-about-project-users-participants__arrow unit-about-project-users-participants__arrow--right">
			<svg width="49" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M48.102 13.062a1.5 1.5 0 000-2.121l-9.546-9.546a1.5 1.5 0 10-2.121 2.121l8.485 8.486-8.485 8.485a1.5 1.5 0 102.121 2.121l9.546-9.546zm-47.633.44H47.04v-3H.47v3z" fill="#000"/></svg>
		</div>
	</div>
	<div class="unit-about-project-users-participants__outer-wrapper">
		<div class="unit-about-project-users-participants__wrapper">
			
			<?$APPLICATION->IncludeComponent(
						"bitrix:news.list", 
						"bp-projects-list", 
						array(
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"ADD_SECTIONS_CHAIN" => "N",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "N",
						"CACHE_FILTER" => "N",
						"CACHE_GROUPS" => "Y",
						"CACHE_TIME" => "36000000",
						"CACHE_TYPE" => "A",
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"DISPLAY_DATE" => "N",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "N",
						"DISPLAY_PREVIEW_TEXT" => "N",
						"DISPLAY_TOP_PAGER" => "N",
						"FIELD_CODE" => array(
						0 => "",
						1 => "",
						),
						"FILTER_NAME" => "elFilter",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"IBLOCK_ID" => "23",
						"IBLOCK_TYPE" => "content",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"INCLUDE_SUBSECTIONS" => "Y",
						"MESSAGE_404" => "",
						"NEWS_COUNT" => "3",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => ".default",
						"PAGER_TITLE" => "Новости",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"PREVIEW_TRUNCATE_LEN" => "",
						"PROPERTY_CODE" => array(
						0 => "ICON_HREF",
						1 => "ICON_TEXT",
						2 => "",
						),
						"SET_BROWSER_TITLE" => "N",
						"SET_LAST_MODIFIED" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_STATUS_404" => "N",
						"SET_TITLE" => "N",
						"SHOW_404" => "N",
						"SORT_BY1" => "ACTIVE_FROM",
						"SORT_BY2" => "SORT",
						"SORT_ORDER1" => "DESC",
						"SORT_ORDER2" => "ASC",
						"STRICT_SECTION_CHECK" => "N",
						"COMPONENT_TEMPLATE" => "index-service-list",
						"TITLE" => ""
						),
						false
					);?>
		</div>
	</div>
</div>									