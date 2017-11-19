<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<form class="common-ajax-form" action="/admin/window/create" method="POST">
			<label>Окна на:</label>
			<input type="text" name="name" value="<?php isset($_SESSION['name']) ? print $_SESSION['name'] : ''; ?>">
			<button type="submit">Создать</button>
		</form>

		<?php foreach($windows as $window): ?>
			<p><?php print $window['name']; ?></p>

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/window/edit/<?php print $window['id']; ?>" method="GET">
				<button>Редактировать</button>
			</form>
			<!-- Пока не появиться js -->

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/window/update" method="POST">
				<input type="hidden" name="id" value="<?php print $window['id']; ?>">
				<input type="text" name="name" value="<?php print $window['name']; ?>">
				<button>Обновить</button>
			</form>
			<!-- Пока не появиться js -->

			<form class="common-ajax-form" action="/admin/window/delete" method="POST">
				<input type="hidden" name="id" value="<?php print $window['id']; ?>">
				<button type="submit">удалить</button>
			</form>
		<?php endforeach; ?>

		<?php 
			// Раскомментировать, когда появиться js для пагинации
			// if ($total > 20) {
			// 	print $this->paginator->get();
			// }
		?>
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>