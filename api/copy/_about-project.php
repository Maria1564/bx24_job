<?
	
	$arData = getElementsData(987,['PREVIEW_TEXT']);
	//l($arData);
?>
<div class="unit-about-project" data-section="0">
	<div class="unit-wrapper pd--tb-small">
		<div class="unit-about__contain">
			<div class="unit-about__column">
				<div class="unit-content">
					<h2 class="unit-title unit-title--h2 unit-title--uppercase">
						О проекте
					</h2>
				    <?=$arData['~PREVIEW_TEXT']?>
				</div>
			</div>
			<div class="unit-about__column">
				<div class="unit-content">
					<div class="unit-about-project__numbers">
						<div class="unit-about-project__numbers-title">
							О нас в цифрах
						</div>
						<div class="unit-about-project__numbers-row">
						<?$n = 0;
							foreach($arData['PROPERTIES']['TEXTS']['VALUE'] as $i => $text):?>
						     <?
							 
								 if($n==2){ 
									 $n=0;
									 echo '</div><div class="unit-about-project__numbers-row">';
								}
								$n++; 
									
									 ?>
							<div class="unit-about-project__numbers-col">
								<div class="unit-about-project__numbers-number"><?=$arData['PROPERTIES']['TEXTS']['DESCRIPTION'][ $i ]?></div>
								<div class="unit-about-project__numbers-text">
									<?=$text?>
								</div>
							</div>
				
						
						<?endforeach?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>