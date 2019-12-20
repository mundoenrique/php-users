<?php
	echo "<pre>";
		print_r($data);
		print_r($expenses);
	echo "<pre>";
?>
<form method="post">
	<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
</form>

<div id="service" class="service-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Reportes</h1>
		</header>
		<section>
			<div class="pt-3">
				<div class="service-group flex max-width-4 flex-wrap items-center mb-2">
					<div class="product-presentation relative mr-4">
						<div class="item-network <?= $data['marca']; ?>"></div>
						<img class="card-image" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
					</div>
					<div class="product-info mr-5">
						<p class="product-cardholder mb-1 semibold h4 primary"><?= $data['nomPlastico']; ?></p>
						<p id="card" class="product-cardnumber mb-0 primary"><?= $data['nroTarjetaMascara'];?></p>
						<p class="product-metadata h6"><?= $data['marca'];?></p>
						<p class="product-metadata mb-0 h6"><?= strtoupper($data['nomEmp']);?></p>

					</div>
					<div class="product-scheme">
						<p class="field-tip">Selecciona la operación que deseas realizar</p>
						<ul class='services-content list-inline flex mx-auto justify-between'>
						</ul>
					</div>
				</div>
				<div class="line mt-1"></div>

				<h2 class="h4 regular tertiary">Gastos por categoría</h2>
				<nav id="filtersStack" class="navbar detail-filters-nav p-1 px-lg-5 bg-widget">
					<div class="stack-form mr-auto flex items-center" id="period-form">
							<label class="my-1 mr-1 text" for="filterMonth">Mostrar:</label>
						<button id="buscar" class="btn btn-small btn-primary" disabled><span aria-hidden="true" class="icon-arrow-right mr-0"></span></button>
					</div>
					<div class="field-options btn-group btn-group-toggle" data-toggle="buttons">
						<label id="movementsToogle" class="btn-small btn-options btn-outline btn-rounded-left active">
							<input id="optionMovements" type="radio" name="movimientos" checked> Movimientos
						</label>
						<label id="transitToogle" class="btn-small btn-options btn-outline btn-rounded-right nowrap is-disabled" >
							<input id="optionTransit" type="radio" name="movimientos" disabled> En tránsito
						</label>
					</div>
					<ul class="stack-extra list-inline mb-0 flex items-center">
						<li class="px-1 list-inline-item text border rounded">
							<a id="download" href="#download" rel="subsection"><span aria-hidden="true" title="Descargar PDF" class="icon-download h5 mr-0"></span></a>
						</li>
						<li class="px-1 list-inline-item text border rounded">
							<a id="downloadxls" href="#downloadxls" rel="subsection"><span aria-hidden="true" title="Descargar Excel" class="icon-file-excel h5 mr-0"></span></a>
						</li>
					</ul>
				</nav>

				<div class="group row mt-3" id="results">
				</div>

			</div>
		</section>
	</div>
</div>

<?php
	$data = json_encode([
		'detailProduct' => $data,
		'listExpenses' => $expenses
	]);
?>

<script>
	var dataExpensesReport = <?= $data;?>;
</script>





