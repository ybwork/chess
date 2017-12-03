<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<div class="row main-padding">
			<div class="col create-form">
				<form class="common-ajax-form nice-form form-add" action="/admin/settings/reserve/create" method="POST">
					<input placeholder="Риэлтор" type="number" name="realtor" value="">
					<input placeholder="Менеджер" type="number" name="manager" value="">
					<button class="btn-default" type="submit">Создать</button>
				</form>
			</div>
			<div class="col table">
				<table>
					<thead>
						<tr>
							<th>Бронь для риэлтора</th>
							<th>Бронь для менеджера</th>
							<th>Действия</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($settings as $setting): ?>
							<tr data-id="<?php print $setting['id']; ?>" data-action="/admin/settings/reserve/update">
								<td class="editable">
									<span><?php print $setting['realtor']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="number" name="realtor" value="<?php print $setting['realtor']; ?>">
									</form>
								</td>
								<td class="editable">
									<span><?php print $setting['manager']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="number" name="manager" value="<?php print $setting['manager']; ?>">
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
										<form class="common-ajax-form form-delete" action="/admin/settings/reserve/delete" method="POST">
											<input type="hidden" name="id" value="<?php print $setting['id']; ?>">
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
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>