<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	
	$this->setFrameMode(true);
?>



<div class="unit-breadcrumbs unit-breadcrumbs--small-2">
	<div class="unit-wrapper">
		<div class="unit-breadcrumbs__list" itemprop="http://schema.org/breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
			<div class="unit-breadcrumbs__list-item" id="bx_breadcrumb_0" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/" title="Главная" itemprop="url">
					Главная
				</a>
			</div>
			<div class="unit-breadcrumbs__list-item" id="bx_breadcrumb_1" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/berezhlivoe-proizvodstvo/" title="Бережливое производство" itemprop="url">
					Бережливое производство
				</a>
			</div>
			<div class="bx-breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <?=$arResult["NAME"]?>
			</div>
		</div>
	</div>
</div>
<div class="unit-case-presentation">
	<div class="unit-service__contain-graphic" style="background-image:url(/berezhlivoe-proizvodstvo/img/bg-3.png?ver=3)">
		<div class="unit-wrapper">
			<div class="unit-title__group">
                <a href="/berezhlivoe-proizvodstvo/#projects" class="unit-case-presentation__back">
					<svg width="39" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M.453 7.213a1 1 0 000 1.414l6.364 6.364a1 1 0 001.414-1.414L2.574 7.92l5.657-5.657A1 1 0 106.817.85L.453 7.213zM38.16 6.92h-37v2h37v-2z" fill="#CAD22A"/>
					</svg>
				</a>
                <h1 class="unit-title unit-title--h1"><?=$arResult["NAME"]?></h1>
                <div class="unit-title__group-intro"><p><?=$arResult["PREVIEW_TEXT"]?></p></div>
			</div>
		</div>
	</div>
</div>


<div class="unit-case-results">
	<div class="unit-wrapper">
		<div class="unit-case-results__col unit-case-results__col--left">
			<div class="unit-case-results__wrapper" data-line="100">
                <div class="unit-case-results__item">
					<div class="unit-case-results__item-col">
						<div class="unit-case-results__item-line-wrapper">
							<div class="unit-case-results__item-line unit-case-results__item-line--blue" 
							data-line="<?=$arResult['PROPERTIES']['START_VALUE']['VALUE']?>" 
							data-text="<?=$arResult['PROPERTIES']['START_FORMAT']['VALUE']?>"
							>
								<div class="unit-case-results__item-number"></div>
								<div class="unit-case-results__item-text"></div>
							</div>
						</div>
					</div>
					<div class="unit-case-results__item-col">
						<div class="unit-case-results__item-subtitle">Было</div>
					</div>
				</div>
                <div class="unit-case-results__item">
					<div class="unit-case-results__item-col">
						<div class="unit-case-results__item-line-wrapper">
							<div class="unit-case-results__text-info-wrapper">
								<div class="unit-case-results__text-info-text">Эффективность</div>
								<div class="unit-case-results__text-info-num"><?=$arResult['PROPERTIES']['EFFICIENCY']['VALUE']?></div>
							</div>
							<div class="unit-case-results__item-line unit-case-results__item-line--green" 
							data-line="<?=$arResult['PROPERTIES']['END_VALUE']['VALUE']?>" 
							data-text="<?=$arResult['PROPERTIES']['END_FORMAT']['VALUE']?>">
								<div class="unit-case-results__item-number"></div>
								<div class="unit-case-results__item-text"></div>
							</div>
						</div>
					</div>
					<div class="unit-case-results__item-col">
						<div class="unit-case-results__item-subtitle">Стало</div>
					</div>
				</div>
			</div>
		</div>
		<div class="unit-case-results__col unit-case-results__col--right" style="max-width:1200px">
			<h2 class="unit-title unit-title--h2 unit-title--uppercase">Результаты</h2>
			<?=$arResult["DETAIL_TEXT"]?>
		</div>
	</div>
</div>


<div class="unit-case-progress-of-project">
	<div class="unit-wrapper pd--tb-small">
		<div class="unit-about__contain">
            <div class="unit-about__column">
				<div class="unit-content">
					<h2 class="unit-title unit-title--h2 unit-title--uppercase">
						О ходе проекта
					</h2>
					<?=$arResult['PROPERTIES']['ABOUT_TEXT']['~VALUE']['TEXT']?>
				</div>
			</div>
            <div class="unit-about__column">
				<div class="unit-content">
				<?
				$imagesIDs = $arResult['PROPERTIES']['ABOUT_IMAGE']['VALUE'];
				if($imagesIDs){
				foreach($imagesIDs as $idImg){
				   $arImages = CFile::GetFileArray($idImg);
				  // l( $arImages);
				   echo '<img src="'. $arImages['SRC'].'" alt="" style="max-width:600px"/>';
				}
				}
				?>
				</div>
			</div>
		</div>
	</div>
</div>


<? include '_form.php'?>
<? include '_projects.php'?>
