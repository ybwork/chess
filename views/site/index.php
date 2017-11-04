<?php require_once(ROOT . '/views/layouts/header.php'); ?>

			<div class="grid-content">
				<div id="sidebarCount" class="sidebar">

					<div class="flat__body">
						<?php foreach($general_info_apartments as $general_info_apartment): ?>
							<div class="flat-item" data-flat="<?php print $general_info_apartment['type_id'] ?>">
								<div class="flat-item-icon"><span><?php print $general_info_apartment['total_area']; ?>м<sup>2</span></div>
								<div class="flat-item-title"><?php print $general_info_apartment['type']; ?>:</div>
								<div class="flat-item-count"><span id="studioLeft"> </span><?php print $general_info_apartment['free']; ?>&nbsp; из &nbsp;<span id="studioTotal"><?php print $general_info_apartment['summary']; ?></span></div>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="flat-table">
						<!-- Up data -->
						<div class="flat-table-header">
							<div class="flat-table-item">Этаж</div>
							<?php foreach ($general_info_apartments as $general_info_apartment): ?>
								<div class="flat-table-item" data-flat="<?php print $general_info_apartment['type_id'] ?>">
									<?php print $general_info_apartment['type']; ?>
								</div>
							<?php endforeach; ?>
						</div>

						<!-- Table down data -->
						<?php foreach ($floors_types_aparts as $floor_type_apart): ?>
							<div class="flat-table-row">
								<div class="flat-table-item floor"><?php print $floor_type_apart['floor']; ?></div>
							<? $i = 0; ?>
							<? unset($floor_type_apart['floor']); ?>
							<?php foreach ($floor_type_apart as $type_id => $value): ?>
									<div class="flat-table-item" data-flat="<?php isset($type_id) ? print($type_id) : print ''; ?>">

										<?php print $value; ?>
									</div>
									<?php $i++; ?>
							<?php endforeach; ?>
							</div>
						<?php endforeach; ?>
					</div>

				</div>



					<div class="buy-panel">

						<div class="status-block">
							<div class="circle-loader">
							  <div class="checkmark draw"></div>
							</div>
							<p class="error-msg" style="display: none"></p>
						</div>

						<div class="form-panel">

							<div class="form-panel-header">
								Купить / забронировать
							</div>

							<div class="close-panel">
								<div class="close-panel-icon"></div>
							</div>

							<div class="select-flat-info">
								<div class="flat-number">Квартира № <span></span></div>
								<div class="flat-type">Тип <span></span></div>
								<div class="flat-floor">Этаж <span></span></div>
								<div class="flat-total-area">Площадь <span></span></div>
								<div class="flat-status">Статус <span></span></div>
								<div class="flat-price">Цена <span></span></div>
							</div>

							<?php if (isset($_SESSION['errors'])): ?>
								<?php print $_SESSION['errors']; ?>
								<?php unset($_SESSION['errors']); ?>
							<?php elseif(isset($_SESSION['success'])): ?>
								<?php print $_SESSION['success']; ?>
								<?php unset($_SESSION['success']); ?>
							<?php endif; ?>

							<form id="reserve-lead" action="" method="POST">
								<input id="apartmentId" type="hidden" name="apartment_id">
								<input id="apartmentNum" type="hidden" name="apartment_num">
								<input id="buyerId" type="hidden" name="buyer_id">
								<div>
									<input type="text" name="name" placeholder="Имя">
								</div>
								<div>
									<input type="text" name="surname" placeholder="Фамилия">
								</div>
								<div>
									<input type="tel" name="phone" placeholder="Телефон*">
								</div>
								<div>
									<input type="email" name="email" placeholder="Эл. почта">
								</div>
								<div class="form-button-group">
									<button class="button button-buy">Купить</button>
									<button class="button button-reserve">Бронировать</button>
								</div>
							</form>
						</div>
					</div>



				<div class="main__content">
					<div class="floor__detail-number">
					    <div id="GalleryRun"><img src="/public/image/icon/photo.svg">Галерея</div>
						<a href="#" class="floor-arrow-down"></a>
						<div class="floor__number"><span class="number-text"></span>&nbsp; этаж</div>
						<a href="#" class="floor-arrow-up"></a>
					</div>
					<main class="home__content">
						<section id="floorInfo" class="floor__detail">

							<div id="floorSchema" class="floor__block">
								<div class="floor__map-info">
									<div class="map-info-item">
										<div class="map-info-icon saled"></div>
										<div class="map-info-title">Квартира<br>продана</div>
									</div>
									<div class="map-info-item">
										<div class="map-info-icon booked"></div>
										<div class="map-info-title">Обычная<br>бронь</div>
									</div>
									<div class="map-info-item">
										<div class="map-info-icon your-flat"></div>
										<div class="map-info-title">Оплаченная<br>бронь</div>
									</div>
									<div class="map-info-item">
										<div class="map-info-icon free"></div>
										<div class="map-info-title">Квартира<br>свободна</div>
									</div>
								</div>
								<div id="floorMapSchema">
									<div class="name-street">ул. Энгельса</div>
									<div class="name-street">Ростов-на-Дону</div>
									<div class="name-street">ул. М.Горького</div>
									<div class="name-street">ул. Куйбышева</div>
									<img class="floor-schema" src="/public/image/flats/floor/walls2.png">
									<svg version="1.1" id="apartmentsLayout" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
										 viewBox="0 0 630.4 279.2" style="enable-background:new 0 0 630.4 279.2;" xml:space="preserve">
									</svg>
								</div>
							</div>

							<div id="flatInfo" class="flat__block">

								<div class="grid-content">
									<div class="grid-expand grid-expand-50">
										<div class="flat-view-block">
											<div id="FloorView"><img src="/public/image/icon/eye.svg" /> Вид из окна</div>
										</div>
										<img class="img-responsive flat-img" src="/public/image/flats/52/flat.svg">
									</div>
									<div class="grid-expand grid-expand-50">
										<div class="flat-desc">

											<div class="flat-header">Евродвухкомнатная квартира </div>

											<div class="flat-description">
												<div class="flat-floor">Этаж: <span>8</span></div>
												<div class="flat-number">Номер квартиры: <span>8</span></div>
												<div class="flat-total-area">Общая площадь: <span>8</span></div>
												<div class="flat-living-area">Фактическая площадь: <span>8</span></div>
											</div>

										</div>

									</div>
									<div class="grid-expand grid-expand-100">

										<div class="flat-price">
											<div class="flat-cost">Цена:<br><span id="flatCost">2 160 000 руб.</span>
											<!--<div class="flat-price-calc">от 15 500 руб./мес.</div>-->
											</div>

											<button class="btn btn-buy">Купить / бронировать </button>
										</div>
									</div>
								</div>
							</div>

						</section>

					</main>



					<!-- Галерея  -->


					<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

						<div class="pswp__bg"></div>

						<div class="pswp__scroll-wrap">

							<div class="pswp__container">
								<div class="pswp__item"></div>
								<div class="pswp__item"></div>
								<div class="pswp__item"></div>
							</div>

							<div class="pswp__ui pswp__ui--hidden">

								<div class="pswp__top-bar">

									<div class="pswp__counter"></div>

									<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

									<button class="pswp__button pswp__button--share" title="Share"></button>

									<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

									<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

									<div class="pswp__preloader">
										<div class="pswp__preloader__icn">
											<div class="pswp__preloader__cut">
												<div class="pswp__preloader__donut"></div>
											</div>
										</div>
									</div>
								</div>

								<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
									<div class="pswp__share-tooltip"></div>
								</div>

								<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
								</button>

								<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
								</button>

								<div class="pswp__caption">
									<div class="pswp__caption__center"></div>
								</div>

							</div>

						</div>

					</div>



				</div>
			</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>
