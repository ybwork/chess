<?php require ROOT . '/views/layouts/header.php'; ?>

<div class="grid-content">
	<div class="main__content">
		<div class="row main-padding">
			<div class="col create-form">
				<form class="common-ajax-form nice-form form-add" action="/admin/role/create" method="POST">
					<input placeholder="Имя" type="text" name="name" value="">
					<button class="btn-default" type="submit">Создать</button>
				</form>
			</div>
			<div class="col table">
				<table>
					<thead>
						<tr>
							<th>Роль</th>
							<th>Действия</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($roles as $role): ?>
							<tr data-id="<?php print $role['id']; ?>" data-action="/admin/role/update">
								<td class="editable">
									<span><?php print $role['name']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="text" name="name" value="<?php print $role['name']; ?>">
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
										<form class="common-ajax-form form-delete" action="/admin/role/delete" method="POST">
											<input type="hidden" name="id" value="<?php print $role['id']; ?>">
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

<?php require ROOT . '/views/layouts/footer.php'; ?>