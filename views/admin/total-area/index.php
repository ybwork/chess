<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<form class="common-ajax-form" action="/admin/total/area/create" method="POST">
			<label>Общая площадь:</label>
			<input type="number" name="total_area" value="">
			<button type="submit">Создать</button>
		</form>

		<?php foreach($total_areas as $total_area): ?>
			<p><?php print $total_area['total_area']; ?></p>

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/total/area/edit/<?php print $total_area['id']; ?>" method="GET">
				<button>Редактировать</button>
			</form>
			<!-- Пока не появиться js -->

			<!-- Пока не появиться js -->
			<form class="common-ajax-form" action="/admin/total/area/update" method="POST">
				<input type="hidden" name="id" value="<?php print $total_area['id']; ?>">
				<input type="text" name="total_area" value="<?php print $total_area['total_area']; ?>">
				<button>Обновить</button>
			</form>
			<!-- Пока не появиться js -->

			<form class="common-ajax-form" action="/admin/total/area/delete" method="POST">
				<input type="hidden" name="id" value="<?php print $total_area['id']; ?>">
				<button type="submit">удалить</button>
			</form>
		<?php endforeach; ?>

		<?php if($total > 20): ?>
			<?php print $paginator->get(); ?>
		<?php endif; ?>
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>