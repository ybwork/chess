<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<form class="common-ajax-form" action="/admin/glazing/create" method="POST">
			<label>Тип остекления:</label>
			<input type="text" name="name" value="">
			<button type="submit">Создать</button>
		</form>

		<?php foreach($glazings as $glazing): ?>
			<p><?php print $glazing['name']; ?></p>

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/glazing/edit/<?php print $glazing['id']; ?>" method="GET">
				<button>Редактировать</button>
			</form>
			<!-- Пока не появиться js -->

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/glazing/update" method="POST">
				<input type="hidden" name="id" value="<?php print $glazing['id']; ?>">
				<input type="text" name="name" value="<?php print $glazing['name']; ?>">
				<button>Обновить</button>
			</form>
			<!-- Пока не появиться js -->

			<form class="common-ajax-form" action="/admin/glazing/delete" method="POST">
				<input type="hidden" name="id" value="<?php print $glazing['id']; ?>">
				<button type="submit">удалить</button>
			</form>
		<?php endforeach; ?>

		<?php if($total > 20): ?>
			<?php print $paginator->get(); ?>
		<?php endif; ?>
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>