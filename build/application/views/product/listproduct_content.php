<div id="dashboard" class="dashboard-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Vista consolidada</h1>
		</header>
		<section>
			<div class="pt-3">
				<h2 class="h4 regular tertiary">Mis productos</h2>
				<div class="line mt-1"></div>
				<div id="dashboard" class="dashboard-items flex max-width-xl-5 mt-3 mx-auto flex-wrap justify-center">
					<form action="<?= base_url('detalle'); ?>" id="frmProducto" method="post">
						<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
						<input type='hidden' name='nroTarjeta' id='nroTarjeta' value=''>
					</form>
					<?php
						foreach($data as $row){
					?>
						<div class="dashboard-item p-1 mx-1 mb-1" id="<?= $row['noTarjeta'];?>">
							<img class="item-img active" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
							<div class="item-info p-1 h5 tertiary bg-white">
								<img class="item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
								<p class="item-category semibold primary"><?= $row['nombre_producto'];?></p>
								<p class="item-cardnumber mb-0"><?= $row['noTarjetaConMascara'];?></p>
								<p class="item-balance mb-0 h6 light text">
									<?= $row['productBalance'] == '--'?: lang('GEN_COIN').' '.$row['productBalance'];?>
								</p>
							</div>
						</div>
					<?php
						}
					?>

					<div class="dashboard-item mx-1"></div>
					<div class="dashboard-item mx-1"></div>
					<div class="dashboard-item mx-1"></div>

				</div>
			</div>
		</section>
	</div>
</div>
