<?php require ROOT . '/views/layouts/header.php'; ?>

<div class="grid-content">
	<div class="main__content">
		<form class="common-ajax-form" action="/admin/role/create" method="POST">
			<label>Имя:</label>
				<input type="text" name="name" value="">
			<button type="submit">Создать</button>
		</form>

		<?php foreach($roles as $role): ?>
			<p><?php print $role['name']; ?></p>

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/role/edit/<?php print $role['id'] ?>" method="GET">
				<button>Редактировать</button>
			</form>
			<!-- Пока не появиться js -->

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/role/update" method="POST">
				<input type="hidden" name="id" value="<?php print $role['id']; ?>">
				<input type="text" name="name" value="<?php print $role['name']; ?>">
				<button>Обновить</button>
			</form>
			<!-- Пока не появиться js -->
			
			<form class="common-ajax-form" action="/admin/role/delete" method="POST">
				<input type="hidden" name="id" value="<?php print $role['id']; ?>">
				<button type="submit">удалить</button>
			</form>
		<?php endforeach; ?>

		<?php if($total > 20): ?>
			<?php print $paginator->get(); ?>
		<?php endif; ?>
	</div>
</div>

<?php require ROOT . '/views/layouts/footer.php'; ?>