<div class="unit-about-project-contacts unit-about-project-contacts--gray">
	<div class="unit-wrapper">
		<div class="unit-about__contain">
			<div class="unit-about__column">
				<div class="unit-content">
					<div class="unit-about-project-contacts__wrapper">
						<div class="unit-about-project-contacts__subtitle">
							Оставьте заявку
						</div>
						<a  class="unit-about-project-contacts__btn js-popup" data-src="#popup__callback_bp">Заявка на участие</a>
					</div>
				</div>
			</div>
			<div class="unit-about__column">
				<div class="unit-content">
					<div class="unit-about-project-contacts__wrapper">
						<div class="unit-about-project-contacts__subtitle">
							Или свяжитесь с нами напрямую
						</div>
						<a
						href="tel:+79109091212"
						class="unit-about-project-contacts__link"
						>+7 910 909-12-12</a
						>
						<a
						href="mailto:info@arbko.ru"
						class="unit-about-project-contacts__link"
						>info@arbko.ru</a
						>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="hidden">
	<div class="unit-popup unit-popup--callback unit-form" id="popup__callback_bp">
                <form action="#" method="post" data-ajax-href="/ajax/form.php">
				<input type="hidden" name="user" id="user-input"  value="">
				<input type="hidden" name="type" id="form-type" value="Заявка на консультацию">
				<input type="hidden" name="page" value="http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>">
				
                    <div class="unit-popup__title-group">
                        <div class="unit-title unit-title--h2">Оставить заявку</div>
                        <div class="unit-popup__intro">
							
						</div>
                    </div>
                    <div class="unit-form__list">
                        <div class="unit-form__list-contain unit-form__list-item">
                            <div class="unit-form__list-item">
                                <input type="text" name="name" class="f-unit f-unit--input" data-validation="length" placeholder="Ваше имя" data-validation-length="2-200">
                            </div>
                            <div class="unit-form__list-item">
                                <input type="tel" name="phone" class="f-unit f-unit--input js-mask-tel js--cursor-text" data-validation="length" placeholder="Номер телефона" data-validation-length="18-18">
                            </div>
                            <div class="unit-form__list-item" id="input-msg">
						      <textarea name="msg" class="f-unit f-unit--textarea" placeholder="Сообщение"></textarea>
                            </div>
   
                            <div class="unit-form__list-item unit-form__list-item--button">
                                <button id="input-send-btn" class="unit-btn unit-btn--green unit-btn--no-fill unit-btn--large" type="submit">Отправить</button>
                            </div>
                        </div>
                        <div class="unit-form__list-item unit-form__list-item--terms">
                            <div class="f-unit-wrap">
                                <input type="checkbox" class="f-unit f-unit--checkbox js-inp-styled" name="policy" id="popup__cal-policy" data-validation="checkbox" checked>
                                <label for="popup__cal-policy" class="unit-label">Нажимая кнопку "Оставить заявку", я даю согласие на обработку персональных данных и соглашаюсь с условиями 
									<span class="link js-popup" data-src="#popup__policy">политики конфиденциальности</span>.
									</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
</div>