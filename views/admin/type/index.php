<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<form class="common-ajax-form" action="/admin/type/create" method="POST">
			<label>Тип:</label>
			<input type="text" name="type" value="">
			<button type="submit">Создать</button>
		</form>

		<?php foreach($types as $type): ?>
			<p><?php print $type['type']; ?></p>

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/type/edit/<?php print $type['id']; ?>" method="GET">
				<button>Редактировать</button>
			</form>
			<!-- Пока не появиться js -->

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/type/update" method="POST">
				<input type="hidden" name="id" value="<?php print $type['id']; ?>">
				<input type="text" name="type" value="<?php print $type['type']; ?>">
				<button>Обновить</button>
			</form>
			<!-- Пока не появиться js -->

			<form class="common-ajax-form" action="/admin/type/delete" method="POST">
				<input type="hidden" name="id" value="<?php print $type['id']; ?>">
				<button type="submit">удалить</button>
			</form>
		<?php endforeach; ?>

		<?php if($total > 2): ?>
			<?php print $this->paginator->get(); ?>
		<?php endif; ?>
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>