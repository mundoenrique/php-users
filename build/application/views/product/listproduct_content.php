
<div id="dashboard" class="dashboard-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Vista consolidada</h1>
		</header>
		<section>
			<div class="pt-3">
				<h2 class="h4 regular tertiary">Selecciona un producto</h2>
				<div class="line mt-1"></div>
				<div id="dashboard" class="dashboard-items flex max-width-xl-6 mt-3 mx-auto flex-wrap justify-center">
					<form action="<?= base_url('detalle'); ?>" id="frmProducto" method="post">
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
									case ($row['bloqueo'] !== '' && $row['bloqueo'] == 'PB'):
										$infoCard = '<span class="semibold danger">' . lang('GEN_TEXT_BLOCK_PRODUCT') . '</span>';
										break;

									case (count($row['availableServices']) === 0):
										$title = lang('GEN_NOT_SERVICES_AVAILABLE');
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
										<p class="item-category semibold primary"><?= $row['nombre_producto']; ?>
											<span class="warning semibold h6 none"> ~Virtual</span>
										</p>
										<p class="item-cardnumber mb-0"><?= $row['noTarjetaConMascara']; ?></p>
										<?= $infoCard ?>
									</div>

									<form action="<?= base_url('detalle'); ?>" id="frmProduct-<?= $row['noTarjeta']; ?>" method="post">
										<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
										<input type='hidden' id='noTarjeta' name='noTarjeta' value='<?= $row['noTarjeta']; ?>'>
										<input type='hidden' id='prefix' name='prefix' value='<?= $row['prefix']; ?>'>
										<input type='hidden' id='bloqueo' name='bloqueo' value='<?= $row['bloqueo']; ?>'>
										<input type='hidden' id='nom_plastico' name='nom_plastico' value='<?= $row['nom_plastico']; ?>'>
										<input type='hidden' id='noTarjetaConMascara' name='noTarjetaConMascara' value='<?= $row['noTarjetaConMascara']; ?>'>
										<input type='hidden' id='actualBalance' name='actualBalance' value='<?= $row['actualBalance']; ?>'>
										<input type='hidden' id='ledgerBalance' name='ledgerBalance' value='<?= $row['ledgerBalance']; ?>'>
										<input type='hidden' id='marca' name='marca' value='<?= $row['marca']; ?>'>
										<input type='hidden' id='nombre_producto' name='nombre_producto' value='<?= $row['nombre_producto']; ?>'>
										<input type='hidden' id='id_ext_per' name='id_ext_per' value='<?= $row['id_ext_per']; ?>'>
										<input type='hidden' id='availableBalance' name='availableBalance' value='<?= $row['availableBalance']; ?>'>
										<input type='hidden' id='vc' name='vc' value='<?= $row['vc']; ?>'>
										<input type='hidden' id='totalProducts' name='totalProducts' value='<?= $row['totalProducts']; ?>'>
									</form>
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
