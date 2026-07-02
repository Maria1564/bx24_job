<div class="unit-header__contain unit-header__contain--top compensate-for-scrollbar">

    <div class="content unit-wrapper">

	<div class="unit-logo">
	    <a href="/">
		<svg class="icon" viewBox="0 0 402 197.7">
		<use xlink:href="#main-logo__foot"></use>
		</svg>
	    </a>
	</div>

	<div class="header-menu" >
	    <img src="/test-files/menu.svg">
	    <ul class="top-menu-submenu">
		<li><a href="/clients/">Клиенты</a></li>
		<li><a href="/service/">Услуги</a></li>
		<li><a href="/consult/">Консультации</a></li>
		<li><a href="/all/">Все данные</a></li>
		<li><a href="/analytics/"> Аналитика</a></li>
		<li><a href="/event/"> Мероприятия</a></li>
		<li><a href="/event/people/"> Участники меропр.</a></li>
	    </ul>
	</div>
	<div class="unit-header__search">
	    <form action="/search/" method="get">
		<div class="unit-header__search-contain">
		<?
		//$page = str_replace("/",$APPLICATION->GetCurDir());
	//	if($page == 'consult'){
		
		//}
		
		?>
		<input type="hidden" name="type" value="<?=$page?>">
		    <input 
			onkeyup="Search()" 
			onclick="Search()" 
			AUTOCOMPLETE="off" 
			type="search" 
			id="search-input" name="q" 
			value="<?= $_REQUEST['q'] ?>"
			class="unit-header__search-input" 
			placeholder="Ищите организацию по названию, ИНН, ОГРН">
		    <button class="unit-header__search-btn" type="submit" style="top: -33px;">
			<svg class="icon horiz-vert-center" viewBox="0 0 250.313 250.313">
			<use xlink:href="#form-search__loop"></use>
			</svg>
		    </button>
		</div>
	    </form>
	    <div class='search-result'></div>
	</div>



	<div class="header-user-block">
	    <? if ($USER->IsAuthorized()): ?>
		    <div class="top-user-fio">
			<a href="/personal/">


			    <?= $USER->GetFullName() ?>
			</a>
		    </div>

		    <?
		    $file = Helper::getUserPhoto($USER->getID());
		    if (!$file) {
			    $file = DEFAULT_AVATAR_IMAGE_MALE;
		    }
			/*
			<div class="top-user-ava" style="background-image:url(<?= $file ?>)">

		    </div>
			*/
		    ?>
		    
	    <? endif ?>
	</div>
    </div>
</div>