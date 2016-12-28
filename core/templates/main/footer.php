<? if ($isAuthPage) { ?>
    <?/*<div id="scrollup"><img alt="Прокрутить вверх" src="<?= TEMPLATE_PATH ?>/images/up.png"></div>*/?>

    <div class="modal fade" id="detailCard" tabindex="-1" role="dialog" aria-labelledby="detailCardLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="detailCardLabel">Карточка товара</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container fix" id="footer">

	<button type="button" class="btn btn-danger help_button" data-toggle="modal" data-target="#help"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Справка</button>
    <button type="button" class="btn btn-default support_button" data-toggle="modal" data-target="#supportForm">
        Вопрос в техподдержку
    </button>

	<div class="footerLogo">
		<a href="http://sysopt.ru/" target="_blank"><img src="<?= TEMPLATE_PATH ?>/images/logo_sysopt.png" alt="Система оптового самообслуживания"></a>
	</div>


</div>
<div class="modal fade" id="supportForm" tabindex="-1" role="dialog" aria-labelledby="supportFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="supportFormLabel">Вопрос в техподдержку</h4>
			</div>
			<div class="modal-body">
			    <div id="#supportFormDanger" class="alert alert-danger support-form-danger">

                </div>
                <form class="supportForm-forma" role="form">
                     <div class="form-group">
                        <input id="suppName" type="text"  class="form-control" placeholder="Имя"/>
                     </div>
                     <div class="form-group">
                        <input id="suppMail" name="email" type="text" class="form-control" placeholder="Введите E-mail или телефон"/>
                     </div>

                     <div class="form-group">
                        <textarea rows="5" id="suppText" class="form-control" placeholder="Ваш вопрос"></textarea>
                     </div>
                </form>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-primary send-support-mail">Отправить</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="detailCity" tabindex="-1" role="dialog" aria-labelledby="detailCityLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="detailCityLabel">Количество в разрезе по городам</h4>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="userModalLabel">Справка</h4>
			</div>
			<div class="modal-body">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
						  <h4 class="panel-title">
								  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
									Как найти товар?
								  </a>
								</h4>
						</div>
						<div id="collapse1" class="panel-collapse collapse">
						  <div class="panel-body">
							<strong>1. Кликая по разделам каталога</strong><br>
							<img src="/images/help/1_1.jpg" alt="" class="help_img">
							<br><br>
							<strong>2. Воспользовавшись поиском</strong><br>
							<img src="/images/help/1_2.jpg" class="help_img" alt="">
							<br><br>
							<strong>Кликая по заголовкам таблицы, можно отсортировать товары по Цене, Количеству или Названию</strong><br>
							<img src="/images/help/1_3.jpg" class="help_img" alt="">
							
						  </div>
						</div>
					  </div>
				  <div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
							  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
								Как сделать заказ?
							  </a>
							</h4>
					</div>
					<div id="collapse2" class="panel-collapse collapse">
					  <div class="panel-body">
						Выберите товар из каталога, укажите количество, нажмите на значок с изображением Корзины.<br>
						Выбранный товар попадет в <strong>Текущий заказ</strong>.
						<img src="/images/help/2_1.jpg" class="help_img" alt="">
						<br><br>
						Для оформления заказа - перейдите на вкладку <strong>Текущий заказ</strong>.<br>
						Проверьте все позиции заказа.<br>
						Можете указать вариант доставки, Адрес доставки и Комментарий к заказу.<br>
						Нажмите <strong>Оформит заказ</strong>.<br>
						<img src="/images/help/2_2.jpg" class="help_img" alt="">
					  </div>
					</div>
				  </div>
				  <div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
							  <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
								Как распечатать счет на оплату?
							  </a>
							</h4>
					</div>
					<div id="collapse3" class="panel-collapse collapse">
					  <div class="panel-body">
						Перейдите на вкладку <strong>Заказы</strong>. Откроется список заказов за выбранную дату.<br>
						<img src="/images/help/3_1.jpg" class="help_img" alt="">
						<br><br>
						Выберите заказ, для которого хотите распечатать счет. Кликните по Номеру заказа - откроется детальная карточка Заказа.
						Для того, чтобы распечатать Счет - кликнике на кропку <strong>Счет на оплату</strong>.
						<img src="/images/help/3_2.jpg" class="help_img" alt="">
					  </div>
					</div>
				  </div>
				  <div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
							  <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
								Как посмотреть взаиморасчеты?
							  </a>
							</h4>
					</div>
					<div id="collapse4" class="panel-collapse collapse">
					  <div class="panel-body">
						Перейдите на вкладку <strong>Взаиморасчеты</strong>. Выберите промежуток, за который хотите сформировать Отчет и нажмите на кнопку <strong>Сформировать</strong>. 
						Откроется спиок документов за выбранную дату.
						<img src="/images/help/4_1.jpg" class="help_img" alt="">
						<br><br>
						При клике на название документа - можно посмотреть детальную информацию и распечатать документы (Например, ТОРГ-12 или Счет-фактуру)
						<img src="/images/help/4_2.jpg" class="help_img" alt="">
					  </div>
					</div>
				  </div>
				  <div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
							  <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
								Как повторить заказ?
							  </a>
							</h4>
					</div>
					<div id="collapse5" class="panel-collapse collapse">
					  <div class="panel-body">
						Перейдите на вкладку <strong>Заказы</strong>. Откроется список заказов за выбранную дату.<br>
						<img src="/images/help/3_1.jpg" class="help_img" alt="">
						<br><br>
						Выберите заказ, который хотите повторить. Кликните по Номеру заказа - откроется детальная карточка Заказа.
						Для того, чтобы повторить заказ - кликнике на кропку <strong>Повторить заказ</strong>. Все позиции заказа добавятся в <strong>Текущий заказ<strong>.
						<img src="/images/help/5_2.jpg" class="help_img" alt="">
					  </div>
					</div>
				  </div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>
<?}?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter40496045 = new Ya.Metrika({
                    id:40496045,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/40496045" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<?php if ($GLOBALS['config']['jSite'] == 1) { ?>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'P4f98cTIcI';var d=document;var w=window;function l(){
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<?php } ?>
</body>
</html>