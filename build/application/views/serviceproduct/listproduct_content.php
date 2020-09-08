<div id="dashboard" class="dashboard-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Atención al cliente</h1>
		</header>
		<section>
			<div class="pt-3">
				<h2 class="h4 regular tertiary">Selecciona un producto</h2>
				<div class="line mt-1"></div>
				<p class="mt-3"></p>
				<div id="dashboard" class="dashboard-items flex max-width-xl-6 mt-3 mx-auto flex-wrap justify-center">
					<form action="<?= base_url('atencioncliente'); ?>" id="frmProducto" method="post">
						<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
						<input type='hidden' name='nroTarjeta' id='nroTarjeta' value=''>
						<input type='hidden' name='noTarjetaConMascara' id='noTarjetaConMascara' value=''>
						<input type='hidden' name='prefix' id='prefix' value=''>
					</form>

					<?php
						if (count($data->data) > 0) {
							foreach ($data->data as $row) {
								$state = '';
								$infoCard = '';
								$title = '';
								switch ($row) {
									case ($row['bloqueo'] !== '' && $row['bloqueo'] !== 'NE'):
										$infoCard = '<span class="semibold danger">' . lang('GEN_TEXT_BLOCK_PRODUCT') . '</span>';
										if ($row['bloqueo'] !== 'PB') {
											$state = 'inactive cursor-default';
										}
										break;

									case (count($row['availableServices']) === 0):
										$title = lang('GEN_NOT_SERVICES_AVAILABLE');
										$state = 'inactive cursor-default';
										$infoCard = '<span class="semibold danger">' . lang('GEN_TEXT_PENDING_REPLACEMENT') . '</span>';
										break;

									case (in_array("120", $row['availableServices'])):
										$infoCard = '<button id="generate" class="btn btn-small btn-link" name="generate">Generar PIN </button>';
										break;

									default:
										$infoCard = '<p class="mb-0 h6 light text">' . strtoupper($row['nomEmp']) . '</p>';
								}
					?>
								<div class="dashboard-item big-modal p-1 mx-1 mb-1 <?= $state; ?>" id="<?= $row['noTarjeta']; ?>" title="<?= $title; ?>">
									<img class=" item-img" src="<?= $this->asset->insertFile('img-card_gray.svg', 'img', $countryUri); ?>" alt="Tarjeta gris">
									<div class="item-info <?= $row['marca']; ?> p-2 h5 tertiary bg-white">
										<p class="item-category semibold primary"><?= $row['nombre_producto']; ?></p>
										<p class="item-cardnumber mb-0"><?= $row['noTarjetaConMascara']; ?></p>
										<?= $infoCard ?>
									</div>
								</div>
							<?php
							}
							?>
							<div class="dashboard-item mx-1"></div>
							<div class="dashboard-item mx-1"></div>
							<div class="dashboard-item mx-1"></div>
						<?php
						} else {
						?>
							<h3 class="h4 regular tertiary pt-3"><?= $data->msg; ?></h3>
						<?php
						}
						?>
				</div>
			</div>
		</section>
	</div>
</div>
