<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<div class="row main-padding">
			<div class="col create-form">
				<form class="common-ajax-form nice-form form-add" action="/admin/apartment/create" method="POST">

					<div class="main__content-input">
						<select name="type_id">
							<option value="">Тип</option>
							<?php foreach($types as $type): ?>
								<option value="<?php print $type['id'] ?>"><?php print $type['type'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="main__content-input">
						<select name="total_area_id">
							<option value="">Общая площадь</option>
							<?php foreach($total_areas as $total_area): ?>
								<option value="<?php print $total_area['id'] ?>"><?php print $total_area['total_area'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="main__content-input">
						<input placeholder="Фактическая площадь" type="number" name="factual_area">
					</div>

					<div class="main__content-input">
						<input placeholder="Этаж" type="number" name="floor" value="">
					</div>

					<div class="main__content-input">
						<input placeholder="Номер квартиры" type="number" name="num" value="">
					</div>
					
					<!-- <div class="main__content-input">
						<label>Окна на</label>
						<select class="js-example-basic-multiple" multiple="multiple" name="window[]">
							<?php foreach($windows as $window): ?>
								<option value="<?php print $window['id'] ?>"><?php print $window['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div> -->

					<div class="main__content-checkbox">
						<label>Тип остекления:</label><br>
						<?php foreach($windows as $window): ?>
							<div class="input-div">
								<input type="checkbox" name="window[]" value="<?php print $window['id']; ?>"><?php print $window['name']; ?>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="main__content-input">
						<input placeholder="Цена" type="number" name="price" value="">
					</div>

					<div class="main__content-input">
						<input placeholder="Скидка" type="number" name="discount" value="">
					</div>

					<div class="main__content-input">
						<select name="status">
							<option value="">Статус</option>
							<option value="1">Свободна</option>
							<option value="2">Забронирована</option>
							<option value="3">Продана</option>
						</select>
					</div>

					<!-- <div class="main__content-input">
						<label>Тип остекления</label>
						<select class="js-example-basic-multiple" multiple="multiple" name="glazing[]">
							<?php foreach($glazings as $glazing): ?>
								<option value="<?php print $glazing['id'] ?>"><?php print $glazing['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div> -->
					
					<div class="main__content-checkbox">
						<label>Тип остекления:</label>
						<?php foreach($glazings as $glazing): ?>
							<div class="input-div">
								<input type="checkbox" name="glazing[]" value="<?php print $glazing['id']; ?>"><?php print $glazing['name']; ?>
							</div>
						<?php endforeach; ?>
					</div>


					<button class="btn-default" type="submit">Создать</button>
				</form>
			</div>
			<div class="col table">
				<table>
					<thead>
						<tr>
							<th>Тип</th>
							<th>Общая площадь</th>
							<th>Фактическая площадь</th>
							<th>Этаж</th>
							<th>Номер квартиры</th>
							<th>Окна на</th>
							<th>Цена</th>
							<th>Скидка</th>
							<th>Статус</th>
							<th>Тип остекления</th>
							<th>Действия</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($apartments as $apartment): ?>
							<tr data-id="<?php print $apartment['id']; ?>" data-action="/admin/apartment/update">

								<td class="editable">
									<span><?php print $apartment['type']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<select name="type_id">
											<option value=""></option>
											<?php foreach($types as $type): ?>
												<option value="<?php print $type['id'] ?>" <?php $apartment['type_id'] == $type['id'] ? print 'selected' : '' ?>>
													<?php print $type['type'] ?>
												</option>
											<?php endforeach; ?>
										</select>

										<!-- <input type="text" name="type" value="<?php print $apartment['type']; ?>"> -->
									</form>
								</td>

								<td class="editable">
									<span><?php print $apartment['total_area']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<select name="total_area_id">
											<option value=""></option>
											<?php foreach($total_areas as $total_area): ?>
												<option value="<?php print $total_area['id'] ?>" <?php $apartment['total_area_id'] == $total_area['id'] ? print 'selected' : '' ?>>
													<?php print $total_area['total_area'] ?>
												</option>
											<?php endforeach; ?>
										</select>

										<!-- <input type="text" name="total_area" value="<?php print $apartment['total_area']; ?>"> -->
									</form>
								</td>

								<td class="editable">
									<span><?php print $apartment['factual_area']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="text" name="factual_area" value="<?php print $apartment['factual_area']; ?>">
									</form>
								</td>

								<td class="editable">
									<span><?php print $apartment['floor']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="text" name="floor" value="<?php print $apartment['floor']; ?>">
									</form>
								</td>

								<td class="editable">
									<span><?php print $apartment['num']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="text" name="num" value="<?php print $apartment['num']; ?>">
									</form>
								</td>

								<td class="editable">
									<span>
										<?php $windowIds = []; ?>
										<?php foreach ($apartment['windows'] as $k => $w): ?>
											<?php array_push($windowIds, $w['id']) ?>
											<div><?php print $w['name'] ?></div>
										<?php endforeach ?>
									</span>
									<form class="common-ajax-form form-update" action="" method="POST">

										<?php foreach($windows as $window): ?>
											<div class="input-div">
												<input type="checkbox" name="window[]" data-name="<?php print $window['name'] ?>" value="<?php print $window['id']; ?>" <?php in_array($window['id'], $windowIds) ? print 'checked="checked"' : '' ?>>
												<?php print $window['name']; ?>
											</div>
										<?php endforeach; ?>
									</form>
								</td>
								
								<td class="editable">
									<span><?php print $apartment['price']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="text" name="price" value="<?php print $apartment['price']; ?>">
									</form>
								</td>

								<td class="editable">
									<span><?php print $apartment['discount']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="text" name="discount" value="<?php print $apartment['discount']; ?>">
									</form>
								</td>
								
								<td class="editable">
									<span><?php print $apartment['status']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="text" name="status" value="<?php print $apartment['status']; ?>">
									</form>
								</td>
								
								<td class="editable">
									<span>
										<?php $glazingIds = []; ?>
										<?php foreach ($apartment['glazings'] as $k => $g): ?>
											<?php array_push($glazingIds, $g['id']) ?>
											<div><?php print $g['name'] ?></div>
										<?php endforeach ?>
									</span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<?php foreach($glazings as $glazing): ?>
											<div class="input-div">
												<input type="checkbox" name="glazing[]"  data-name="<?php print $glazing['name'] ?>" value="<?php print $glazing['id']; ?>" <?php in_array($glazing['id'], $glazingIds) ? print 'checked="checked"' : '' ?>>
												<?php print $glazing['name']; ?>
											</div>
										<?php endforeach; ?>

										<!-- <select class="js-example-basic-multiple" multiple="multiple" name="glazing[]">
											<?php foreach($glazings as $glazing): ?>
												<option value="<?php print $glazing['id'] ?>"><?php print $glazing['name'] ?></option>
											<?php endforeach; ?>
										</select> -->
										<!-- <input type="text" name="glazing" value="<?php print $apartment['glazings']; ?>"> -->
									</form>
								</td>
								


								<td class="actions">
									<div class="col">
										<button class="btn-icon btn-action gray form-edit" type="button">
											<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
										</button>
										<button class="btn-icon btn-action hidden green form-save">
											<i class="fa fa-floppy-o" aria-hidden="true"></i>
										</button>
									</div>
									<div class="col">
										<form class="common-ajax-form form-delete" action="/admin/apartment/delete" method="POST">
											<input type="hidden" name="id" value="<?php print $apartment['id']; ?>">
											<button class="btn-icon gray" type="submit">
												<i class="fa fa-trash-o" aria-hidden="true"></i>
											</button>
										</form>
									</div>
								</td>

							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php 
					// Раскомментировать, когда появиться js для пагинации
					// if ($total > 20) {
					// 	print $this->paginator->get();
					// }
				?>
			</div>
		</div>






<!-- 		<form class="common-ajax-form" class="admin__add-user-body" action="/admin/apartment/create" method="POST">
			<div class="main__content-input">
				<label>Тип:</label>
				<select name="type_id">
					<option value=""></option>
					<?php foreach($types as $type): ?>
						<option value="<?php print $type['id'] ?>"><?php print $type['type'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Общая площадь:</label>
				<select name="total_area_id">
					<option value=""></option>
					<?php foreach($total_areas as $total_area): ?>
						<option value="<?php print $total_area['id'] ?>"><?php print $total_area['total_area'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Фактическая площадь:</label>
				<input type="text" name="factual_area">
			</div>

			<div class="main__content-input">
				<label>Этаж:</label>
				<input type="number" name="floor" value="">
			</div>

			<div class="main__content-input">
				<label>Номер квартиры:</label>
				<input type="number" name="num" value="">
			</div>
			
			<div class="main__content-input">
				<label>Окна на:</label>
				<select class="js-example-basic-multiple" multiple="multiple" name="window[]">
					<option value=""></option>
					<?php foreach($windows as $window): ?>
						<option value="<?php print $window['id'] ?>"><?php print $window['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Цена:</label>
				<input type="number" name="price" value="">
			</div>

			<div class="main__content-input">
				<label>Скидка:</label>
				<input type="number" name="discount" value="">
			</div>

			<div class="main__content-input">
				<label>Статус:</label>
				<select name="status">
					<option value=""></option>
					<option value="1">Свободна</option>
					<option value="2">Забронирована</option>
					<option value="3">Продана</option>
				</select>
			</div>
			
			<div class="main__content-checkbox">
				<label>Тип остекления:</label>
				<?php foreach($glazings as $glazing): ?>
					<label>
						<input type="checkbox" name="glazing[]" value="<?php print $glazing['id']; ?>"><?php print $glazing['name']; ?>
					</label>
				<?php endforeach; ?>
			</div>
			
			<div class="main__content-button align-right">
				<button type="submit">Создать</button>
			</div>
		</form> -->
<!-- 
		<table class="admin__table">
			<thead>
				<th>Номер</th>
				<th>Этаж</th>
				<th>Площадь</th>
				<th></th>
			</thead>

			<?php foreach($apartments as $apartment): ?>
				<form class="common-ajax-form" action="/admin/apartment/update" method="POST">
					<input type="hidden" name="id" value="<?php print $apartment['id']; ?>">
						<label>Тип:</label>
						<select name="type_id">
							<option value=""></option>
							<?php foreach($types as $type): ?>
								<option value="<?php print $type['id'] ?>"><?php print $type['type'] ?></option>
							<?php endforeach; ?>
						</select>

						<label>Общая площадь:</label>
						<select name="total_area_id">
							<option value=""></option>
							<?php foreach($total_areas as $total_area): ?>
								<option value="<?php print $total_area['id'] ?>"><?php print $total_area['total_area'] ?></option>
							<?php endforeach; ?>
						</select>

						<label>Фактическая площадь:</label>
						<input type="text" name="factual_area" value="<?php print $apartment['factual_area']; ?>">

						<label>Этаж:</label>
						<input type="number" name="floor" value="<?php print $apartment['floor']; ?>">

						<label>Номер квартиры:</label>
						<input type="number" name="num" value="<?php print $apartment['num']; ?>">

						<label>Окна на:</label>
						<select class="js-example-basic-multiple" multiple="multiple" name="window[]">
							<option value=""></option>
							<?php foreach($windows as $window): ?>
								<option value="<?php print $window['id'] ?>"><?php print $window['name'] ?></option>
							<?php endforeach; ?>
						</select>

						<label>Цена:</label>
						<input type="number" name="price" value="<?php print $apartment['price']; ?>">

						<label>Скидка:</label>
						<input type="number" name="discount" value="<?php print $apartment['discount']; ?>">

						<label>Статус:</label>
						<select name="status">
							<option value=""></option>
							<option value="1">Свободна</option>
							<option value="2">Забронирована</option>
							<option value="3">Продана</option>
						</select>

						<label>Тип остекления:</label>
						<?php foreach($glazings as $glazing): ?>
							<label>
								<input type="checkbox" name="glazing[]" value="<?php print $glazing['id']; ?>"><?php print $glazing['name']; ?>
							</label>
						<?php endforeach; ?>
					<button>Обновить</button>
				</form>
				<br>
				<br>
				<br>
				<br>
				<br>

				<tr>
					<td><?php print $apartment['num']; ?></td>
					<td class="table-align-center"><?php print $apartment['floor']; ?></td>
					<td class="table-align-center"><?php print $apartment['factual_area']; ?></td>
					<td>
			
						<form class="common-ajax-form" action="/admin/apartment/edit/<?php print $apartment['id']; ?>" method="GET">
							<button>Редактировать</button>
						</form>

						<form class="common-ajax-form" action="/admin/apartment/delete" method="POST">
							<input type="hidden" name="id" value="<?php print $apartment['id']; ?>">
							<button type="submit">удалить</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		</table> -->

		<?php 
			// Раскомментировать, когда появиться js для пагинации
			// if ($total > 20) {
			// 	print $this->paginator->get();
			// }
		?>
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>