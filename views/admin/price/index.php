<?php require_once(ROOT . '/views/layouts/header.php'); ?>
		
<div class="grid-content">
	<div class="main__content">
		<form class="common-ajax-form" action="/admin/prices/upload" method="POST" enctype="multipart/form-data">
			<div class="parent-file">
				<div class="child-file">
					<div id="file-error" class="err"></div>
					<label class="fileContainer">
						<span>Выбрать файл</span>
						<input type="file" name="prices[]" multiple>
					</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
					<br>
					<button class="btn" type="submit">Загрузить</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>