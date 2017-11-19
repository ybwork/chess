<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content admin__panel">
	<div class="main__content">
		<form class="common-ajax-form" class="admin__add-user-body" action="/admin/apartment/create" method="POST">
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
		</form>

		<table class="admin__table">
			<thead>
				<th>Номер</th>
				<th>Этаж</th>
				<th>Площадь</th>
				<th></th>
			</thead>

			<?php foreach($apartments as $apartment): ?>
				<!-- Пока не появиться js -->
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
				<!-- Пока не появиться js -->

				<tr>
					<td><?php print $apartment['num']; ?></td>
					<td class="table-align-center"><?php print $apartment['floor']; ?></td>
					<td class="table-align-center"><?php print $apartment['factual_area']; ?></td>
					<td>
			
						<!-- Пока не появиться js -->
						<form class="common-ajax-form" action="/admin/apartment/edit/<?php print $apartment['id']; ?>" method="GET">
							<button>Редактировать</button>
						</form>
						<!-- Пока не появиться js -->

						<form class="common-ajax-form" action="/admin/apartment/delete" method="POST">
							<input type="hidden" name="id" value="<?php print $apartment['id']; ?>">
							<button type="submit">удалить</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>

		<?php 
			// Раскомментировать, когда появиться js для пагинации
			// if ($total > 20) {
			// 	print $this->paginator->get();
			// }
		?>
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>