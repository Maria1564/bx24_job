<div class="unit-about-project-news" data-section="2">
	<div class="unit-wrapper">
		<h2 class="unit-title unit-title--h2 unit-title--uppercase">
			Новости
		</h2>
		<div class="unit-about-project-news__wrapper">
			<div class="unit-about-project-news__item">
				<div
				class="unit-about-project-news__label unit-about-project-news__label--orange"
				>
					Важная новость
				</div>
				<img src="https://avatars.mds.yandex.net/get-pdb/1220164/6b83cdb2-a9c7-4c32-97a1-0aa175ea52f3/s1200" alt="" class="unit-about-project-news__img" />
				<div class="unit-about-project-news__subtitle">
					Недавно прошел форум по внедрению БП на Калужские предприятия. Тут еще текста побольше, побольше текста. Прям много текста нужно
				</div>
			</div>
			<div class="unit-about-project-news__item">
				<div
				class="unit-about-project-news__label unit-about-project-news__label--green"
				>
					Новости
				</div>
				<img src="https://avatars.mds.yandex.net/get-pdb/1220164/6b83cdb2-a9c7-4c32-97a1-0aa175ea52f3/s1200" alt="" class="unit-about-project-news__img" />
				<div class="unit-about-project-news__subtitle">
					Недавно прошел форум по внедрению БП на Калужские предприятия...
				</div>
			</div>
			<div class="unit-about-project-news__item">
				<div
				class="unit-about-project-news__label unit-about-project-news__label--orange"
				>
					Важная новость
				</div>
				<img src="https://avatars.mds.yandex.net/get-pdb/1220164/6b83cdb2-a9c7-4c32-97a1-0aa175ea52f3/s1200" alt="" class="unit-about-project-news__img" />
				<div class="unit-about-project-news__subtitle">
					Недавно прошел форум по внедрению БП на Калужские предприятия...
				</div>
			</div>
		</div>
	</div>
</div>
<div class="unit-about-project-news unit-about-project-news--small-item">
	<div class="unit-wrapper">
		<h2 class="unit-title unit-title--h2 unit-title--uppercase">
			Мероприятия
		</h2>
		<div class="unit-about-project-news__wrapper">
			<div class="unit-about-project-news__item">
				<div
				class="unit-about-project-news__label unit-about-project-news__label--blue"
				>
					Семинары и тренинги
				</div>
				<img src="https://avatars.mds.yandex.net/get-pdb/1220164/6b83cdb2-a9c7-4c32-97a1-0aa175ea52f3/s1200" alt="" class="unit-about-project-news__img" />
				<div class="unit-about-project-news__subtitle">
					Недавно прошел форум по внедрению БП на Калужские предприятия...
				</div>
			</div>
			<div class="unit-about-project-news__item">
				<div
				class="unit-about-project-news__label unit-about-project-news__label--blue"
				>
					Семинары и тренинги
				</div>
				<img src="https://avatars.mds.yandex.net/get-pdb/1220164/6b83cdb2-a9c7-4c32-97a1-0aa175ea52f3/s1200" alt="" class="unit-about-project-news__img" />
				<div class="unit-about-project-news__subtitle">
					Недавно прошел форум по внедрению БП на Калужские предприятия...
				</div>
			</div>
			<div class="unit-about-project-news__item">
				<div
				class="unit-about-project-news__label unit-about-project-news__label--blue"
				>
					Семинары и тренинги
				</div>
				<img src="https://avatars.mds.yandex.net/get-pdb/1220164/6b83cdb2-a9c7-4c32-97a1-0aa175ea52f3/s1200" alt="" class="unit-about-project-news__img" />
				<div class="unit-about-project-news__subtitle">
					Недавно прошел форум по внедрению БП на Калужские предприятия...
				</div>
			</div>
		</div>
	</div>
</div>
<div class="unit-about-project-users-publications">
	<div class="unit-wrapper">
		<h2 class="unit-title unit-title--h2 unit-title--uppercase">
			Пресса о нас
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
	<div class="unit-about-project-users-publications__outer-wrapper">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list", 
			"bp-pressa-about-us", 
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
			"FILTER_NAME" => "",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"IBLOCK_ID" => "24",
			"IBLOCK_TYPE" => "content",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"INCLUDE_SUBSECTIONS" => "Y",
			"MESSAGE_404" => "",
			"NEWS_COUNT" => "20",
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
			"COMPONENT_TEMPLATE" => "bp-pressa-about-us",
			"TITLE" => ""
			),
			false
		);?>
		
	</div>
</div>