<form method="post">
	<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
</form>

<div id="detail" class="detail-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Atención al Cliente</h1>
		</header>
		<section>
			<div class="pt-3">
				<div class="flex items-center justify-between mb-2">
					<div class="product-presentation relative mr-4">
						<div class="item-network <?= $data['marca']; ?>"></div>
						<img class="card-image" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
					</div>
					<div class="product-info-full mr-4">
						<p class="product-cardholder mb-1 semibold h4 primary"><?= $data['nom_plastico']; ?></p>
						<p id="card" class="product-cardnumber mb-0 primary"><?= $data['noTarjetaConMascara'];?></p>
						<p class="product-metadata mb-2 h6"><?= $data['nombre_producto'];?></p>
						<ul class="product-balance-group flex justify-between mb-0 list-inline">
							<li class="list-inline-item">Actual
								<span id="actual" class="product-balance block primary">
									<?= $data['actualBalance'] !== '--'?
										lang('GEN_COIN').' '.strval(number_format($data['actualBalance'],2,',','.')):
										$data['actualBalance'];?>
								</span>
							</li>
							<li class="list-inline-item">En Tránsito
								<span id="bloqueado" class="product-balance block primary">
									<?= $data['ledgerBalance'] !== '--'?
									lang('GEN_COIN').' '.strval(number_format($data['ledgerBalance'],2,',','.')): $data['ledgerBalance'];?>
								</span>
							</li>
							<li class="list-inline-item">Disponible
								<span id="disponible" class="product-balance block primary">
									<?= $data['availableBalance'] !== '--'?
									lang('GEN_COIN').' '.strval(number_format($data['availableBalance'],2,',','.')): $data['ledgerBalance'];?>
								</span>
							</li>
						</ul>
					</div>

				</div>


			</div>
		</section>
	</div>
</div>

