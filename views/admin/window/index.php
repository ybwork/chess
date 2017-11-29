<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">

		<div class="row main-padding">
			<div class="col create-form">
				<form class="common-ajax-form nice-form form-add" action="/admin/window/create" method="POST">
					<input placeholder="Окна на" type="text" name="name" value="">
					<button class="btn-default" type="submit">Создать</button>
				</form>
			</div>
			<div class="col table">
				<table>
					<thead>
						<tr>
							<th>Окна на</th>
							<th>Действия</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($windows as $window): ?>
							<tr data-id="<?php print $window['id']; ?>" data-action="/admin/window/update">
								<td class="editable">
									<span><?php print $window['name']; ?></span>
									<form class="common-ajax-form form-update" action="" method="POST">
										<input type="text" name="name" value="<?php print $window['name']; ?>">
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
										<form class="common-ajax-form form-delete" action="/admin/window/delete" method="POST">
											<input type="hidden" name="id" value="<?php print $window['id']; ?>">
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