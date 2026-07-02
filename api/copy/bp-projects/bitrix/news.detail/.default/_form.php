<div class="unit-case-request">
	<div class="unit-wrapper">
		<div class="unit-case-request__col unit-case-request__col--left">
			<h2 class="unit-title unit-title--h2 unit-title--uppercase">Хотите<br>такие же<br>результаты?</h2>
		</div>
		<div class="unit-case-request__col unit-case-request__col--right">
			<form action="" class="unit-case-request__form" data-ajax-href="/ajax/form.php">
				<input type="hidden" name="type" value="Зявка на участие со страницы - <?=$arResult['NAME']?>">
				<input type="hidden" name="form-type" value="events-registration">
				<input type="hidden" name="user" value="<?=$arResult['PROPERTIES']['MANAGER']['VALUE']?>" >
				<input type="hidden" name="page" value="http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>">
                <div class="unit-case-request__form-title">Заявка на участие</div>
                <div class="unit-case-request__form-wrapper">
					<input type="text" value="" name="name" placeholder="Ваше имя" class="unit-case-request__form-input-text">
					<input type="text" value="" name="phone" placeholder="Ваш телефон" class="unit-case-request__form-input-text js-mask-tel js--cursor-text" data-validation="length" data-validation-length="2-18">
				</div>
                <button type="submit" class="unit-case-request__form-btn">Заявка на участие</button>
				<div class="unit-form__list-item unit-form__list-item--terms">
					<div class="f-unit-wrap">
						<input type="checkbox" class="f-unit f-unit--checkbox js-inp-styled" name="policy" id="participation__cal-policy" data-validation="checkbox">
						<label for="participation__cal-policy" class="unit-label">Нажимая кнопку "Оставить заявку", я даю согласие на обработку персональных данных и соглашаюсь с условиями
							<span class="link js-popup" data-src="#popup__policy">политики конфиденциальности</span>.</label>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>