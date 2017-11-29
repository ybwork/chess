<?php require_once(ROOT . '/views/layouts/header.php'); ?>
	<div class="grid-content">
		<div class="main__content main-padding">
			<?php if (count($dealings) > 0): ?>
				<div class="col table seller-table">
					<table>
						<thead>
							<tr>
								<th>Номер квартиры</th>
								<th>Имя продавца</th>
								<th>Фамилия продавца</th>
								<th>Отчество продавца</th>
								<th>Телефон продавца</th>
								<th>Имя покупателя</th>
								<th>Фамилия покупателя</th>
								<th>Телефон покупателя</th>
								<th>Дата создания</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($dealings as $deal): ?>
								<tr>
									<td><?php print $deal['num']; ?></td>
									<td><?php print $deal['seller_name']; ?></td>
									<td><?php print $deal['seller_surname']; ?></td>
									<td><?php print $deal['seller_patronymic']; ?></td>
									<td><?php print $deal['seller_phone']; ?></td>
									<td><?php print $deal['buyer_name']; ?></td>
									<td><?php print $deal['buyer_surname']; ?></td>
									<td><?php print $deal['buyer_phone']; ?></td>
									<td><?php print $deal['time_purchase']; ?></td>
								</tr>
							<?php endforeach; ?>
				
				<?php 
					// Раскомментировать, когда появиться js для пагинации
					// if ($total > 20) {
					// 	print $this->paginator->get();
					// }
				?>
			<?php else: ?>
				<p>Пока нет сделок</p>
			<?php endif; ?>
		</div>
	</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>