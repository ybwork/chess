<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<div class="row main-padding">
			<div class="col create-form">
				<form class="common-ajax-form nice-form form-add" action="/admin/type/create" method="POST">
					<input placeholder="Тип" type="text" name="type" value="">
					<button class="btn-default" type="submit">Создать</button>
				</form>
			</div>
			<div class="col table">
				<table>
					<thead>
						<tr>
							<th>Тип</th>
							<th>Действия</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($types as $type): ?>
							<tr data-id="<?php print $type['id']; ?>" data-action="/admin/type/update">
								<td class="editable">
									<span><?php print $type['type']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="text" name="type" value="<?php print $type['type']; ?>">
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
										<form class="common-ajax-form form-delete" action="/admin/type/delete" method="POST">
											<input type="hidden" name="id" value="<?php print $type['id']; ?>">
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