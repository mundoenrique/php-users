<div id="dashboard" class="dashboard-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Detalle de cuenta</h1>
		</header>
		<section>
			<div class="pt-3">
				<div class="flex">
					<div class="product-presentation mr-4">
						<img class="card-image" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
						<img class="item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
					</div>
					<div class="product-info-full" moneda="Bs.">
						<p class="product-cardholder mb-1 semibold h4 primary"><?= $data['nom_plastico']; ?></p>
						<p id="card" class="product-cardnumber mb-0 primary"><?= $data['noTarjetaConMascara'];?></p>
						<p class="product-metadata mb-2 h6"><?= $data['nombre_producto'];?></p>
						<ul class="product-balance-group list-inline">
							<li class="list-inline-item">Actual <span id="actual" class="product-balance block primary"><?= $data['productBalance'];?></span></li>
							<li class="list-inline-item">En Tránsito <span id="bloqueado" class="product-balance block primary"><?= $data['productBalance'];?></span></li>
							<li class="list-inline-item">Disponible <span id="disponible" class="product-balance block primary"><?= $data['productBalance'];?></span></li>
						</ul>
					</div>
				</div>
				<h2 class="h4 regular tertiary">Mis productos</h2>
				<div class="line mt-1"></div>
				<div id="dashboard" class="dashboard-items flex max-width-xl-5 mt-3 mx-auto flex-wrap justify-center">

				</div>
			</div>
		</section>
	</div>
</div>
