<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<form class="common-ajax-form" action="/admin/settings/reserve/create" method="POST">
			<label>Бронь для риэлтора на (кол-во дней):</label>
			<input type="number" name="realtor" value="">
			<label>Бронь для менеджера на (кол-во дней):</label>
			<input type="number" name="manager" value="">
			<button type="submit">Создать</button>
		</form>

		<?php foreach($settings as $setting): ?>
			<p><?php print $setting['realtor']; ?></p>
			<p><?php print $setting['manager']; ?></p>

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/settings/reserve/edit/<?php print $setting['id']; ?>" method="GET">
				<button>Редактировать</button>
			</form>
			<!-- Пока не появиться js -->

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/settings/reserve/update" method="POST">
				<input type="hidden" name="id" value="<?php print $setting['id']; ?>">
				<label>Бронь для риэлтора на (кол-во дней):</label>
				<input type="text" name="realtor" value="<?php print $setting['realtor']; ?>">
				<label>Бронь для менеджера на (кол-во дней):</label>
				<input type="text" name="manager" value="<?php print $setting['manager']; ?>">
				<button>Обновить</button>
			</form>
			<!-- Пока не появиться js -->

			<form class="common-ajax-form" action="/admin/settings/reserve/delete" method="POST">
				<input type="hidden" name="id" value="<?php print $setting['id']; ?>">
				<button type="submit">удалить</button>
			</form>
		<?php endforeach; ?>
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>