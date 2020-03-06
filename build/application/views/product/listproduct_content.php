
<div id="dashboard" class="dashboard-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Vista consolidada</h1>
		</header>
		<section>
			<div class="pt-3">
				<h2 class="h4 regular tertiary">Mis productos</h2>
				<div class="line mt-1"></div>
				<div id="dashboard" class="dashboard-items flex max-width-xl-6 mt-3 mx-auto flex-wrap justify-center">
					<form action="<?= base_url('detalle'); ?>" id="frmProducto" method="post">
						<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
						<input type='hidden' name='nroTarjeta' id='nroTarjeta' value=''>
						<input type='hidden' name='noTarjetaConMascara' id='noTarjetaConMascara' value=''>
						<input type='hidden' name='prefix' id='prefix' value=''>
					</form>
					<?php if (count($data) > 0 and $data !== '--'): ?>
					<?php foreach($data as $row): ?>
					<?php	$state = (in_array("120", $row['availableServices'])) ? ' inactive' : ''; ?>
					<div id="<?= $row['noTarjeta'];?>" class="dashboard-item big-modal p-1 mx-1 mb-1<?= $state; ?>">
						<img class="item-img" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
						<div class="item-info <?= $row['marca'];?> p-2 h5 tertiary bg-white">
							<p class="item-category semibold primary"><?= $row['nombre_producto'];?></p>
							<p class="item-cardnumber mb-0"><?= $row['noTarjetaConMascara'];?></p>
							<?php if ($state === ' inactive'): ?>
							<button id="generate" class="btn btn-small btn-link" name="generate">Generar PIN </button>
							<?php elseif ($row['bloque'] !== '00' && $row['bloque'] !== ''): ?>
							<span class="semibold danger">Bloqueada</span>
							<?php else: ?>
							<p class="item-balance mb-0 h6 light text">
								<?= lang('GEN_COIN').' ';?>
								<?php if ($row['availableBalance'] !== '--'): ?>
								<?= strval(number_format($row['availableBalance'],2,',','.')); ?>
								<?php else: ?>
								---
								<?php endif; ?>
							</p>
							<?php endif; ?>
						</div>
					</div>
					<?php endforeach; ?>
					<div class="dashboard-item mx-1"></div>
					<div class="dashboard-item mx-1"></div>
					<div class="dashboard-item mx-1"></div>
					<?php else: ?>
					<h3 class="h4 regular tertiary pt-3"><?= lang('RESP_EMPTY_LIST_PRODUCTS');?></h3>
					<?php endif; ?>
				</div>
			</div>
		</section>
	</div>
</div>
