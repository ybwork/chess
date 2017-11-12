<?php require_once(ROOT . '/views/layouts/header.php'); ?>
	<div class="grid-content">
	<div class="main__content">
		<?php foreach($dealings as $deal): ?>
			<label>Номер квартиры</label>
			<p><?php print $deal['num']; ?></p>
			<label>Имя продавца</label>
			<p><?php print $deal['seller_name']; ?></p>
			<label>Фамилия продавца</label>
			<p><?php print $deal['seller_surname']; ?></p>
			<label>Отчество продавца</label>
			<p><?php print $deal['seller_patronymic']; ?></p>
			<label>Телефон продавца</label>
			<p><?php print $deal['seller_phone']; ?></p>
			<label>Имя покупателя</label>
			<p><?php print $deal['buyer_name']; ?></p>
			<label>Фамилия покупателя</label>
			<p><?php print $deal['buyer_surname']; ?></p>
			<label>Телефон покупателя</label>
			<p><?php print $deal['buyer_phone']; ?></p>
			<label>Дата создания</label>
			<p><?php print $deal['time_purchase']; ?></p>
			<br>
			<br>
			<br>
			<br>
		<?php endforeach; ?>

		<?php if($total > 2): ?>
			<?php print $this->paginator->get(); ?>
		<?php endif; ?>
	</div>
</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>