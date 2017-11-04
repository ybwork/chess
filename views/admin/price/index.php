<?php require_once(ROOT . '/views/layouts/header.php'); ?>
		
<div class="grid-content">
	<div class="main__content">
		<form class="common-ajax-form" action="/admin/prices/upload" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
			<input type="file" name="prices[]" multiple>
			<button type="submit">Загрузить</button>
		</form>
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>