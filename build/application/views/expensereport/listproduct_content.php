<div id="dashboard" class="dashboard-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Reportes</h1>
		</header>
		<section>
			<div class="pt-3">
				<h2 class="h4 regular tertiary">Selecciona un producto</h2>
				<div class="line mt-1"></div>
				<div id="dashboard" class="dashboard-items flex max-width-xl-6 mt-3 mx-auto flex-wrap justify-center">
					<form action="<?= base_url('detallereporte'); ?>" id="frmProducto" method="post">
						<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
						<input id='nroTarjeta' type='hidden' name='nroTarjeta' value=''>
						<input id='noTarjetaConMascara' type='hidden' name='noTarjetaConMascara' value=''>
						<input id='prefix' type='hidden' name='prefix' value=''>
					</form>
					<?php if (is_array($data->data) && count($data->data) > 0): ?>
					<?php foreach($data->data as $row): ?>
					<div id="<?= $row['nroTarjeta'];?>" class="dashboard-item big-modal p-1 mx-1 mb-1">
						<img class="item-img" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
						<div class="item-info <?= strtolower($row['marca']);?> p-2 h5 tertiary bg-white">
							<p class="item-category semibold primary">
								<?= strtoupper($row['tarjetaHabiente']);?>
							</p>
							<p class="item-cardnumber mb-0"><?= $row['nroTarjetaMascara'];?></p>
							<?php if ($row['bloque'] === 'S'): ?>
							<span class="semibold danger"><?= lang('GEN_TEXT_BLOCK_PRODUCT');?></span>
							<?php else: ?>
							<p class="mb-0 h6 light text"><?= strtoupper($row['nomEmp']);?></p>
							<?php endif; ?>
						</div>
					</div>
					<?php endforeach; ?>
					<div class="dashboard-item mx-1"></div>
					<div class="dashboard-item mx-1"></div>
					<div class="dashboard-item mx-1"></div>
					<?php else: ?>
					<h3 class="h4 regular tertiary pt-3"><?= $data->msg;?></h3>
					<?php endif; ?>
				</div>
			</div>
		</section>
	</div>
</div>
