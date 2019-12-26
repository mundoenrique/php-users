<?php $disabled = (empty($expenses) || $expenses === '--')? 'disabled': '';?>
<form method="post">
	<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>' action=''>
	<input type='hidden' name='frmInitialDate' value=''>
	<input type='hidden' name='frmFinalDate' value=''>
	<input type='hidden' name='frmTypeFile' value=''>
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
						<div class="item-network <?= strtolower($data['marca']); ?>"></div>
						<img class="card-image" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
					</div>
					<div class="product-info mr-5">
						<p class="product-cardholder mb-1 semibold h4 primary"><?= $data['nomPlastico']; ?></p>
						<p id="card" class="product-cardnumber mb-0 primary"><?= $data['nroTarjetaMascara'];?></p>
						<p class="product-metadata h6"><?= $data['producto'];?></p>
						<p class="product-metadata mb-0 h6"><?= strtoupper($data['nomEmp']);?></p>

					</div>
				</div>
				<div class="line mt-1"></div>

				<h2 class="h4 regular tertiary">Gastos por categoría</h2>
				<nav id="filtersStack" class="navbar detail-filters-nav p-1 px-lg-5 bg-widget">
					<div class="stack-form mr-auto flex items-center" id="period-form">
						<div class="form-inline">
							<label class="nowrap mb-0" for="fromDate">Mostrar desde</label>
							<input type="text" id="fromDate" name="fromDate" class="mx-2 col-3 form-control"  <?=$disabled;?>>
							<label class="nowrap mb-0" for="toDate" >Hasta</label>
							<input type="text" id="toDate" name="toDate" class="mx-2 col-3 form-control" <?=$disabled;?>>
							<button id="buscar" class="btn btn-small btn-primary" disabled><span aria-hidden="true" class="icon-arrow-right mr-0"></span></button>
							<div class="help-block"></div>
						</div>
					</div>
					<div class="field-options btn-group btn-group-toggle" data-toggle="buttons">
						<label id="movementsToogle" class="btn-small btn-options btn-outline btn-rounded-left active">
							<input id="optionMovements" type="radio" name="movimientos" checked> Detalle
						</label>
						<label id="transitToogle" class="btn-small btn-options btn-outline btn-rounded-right nowrap is-disabled" >
							<input id="optionTransit" type="radio" name="movimientos" disabled> Gráfico
						</label>
					</div>
					<ul class="stack-extra list-inline mb-0 flex items-center">
						<li class="px-1 list-inline-item text border rounded">
							<a id="downloadPDF" href="" rel="subsection"><span aria-hidden="true" title="Descargar PDF" class="icon-download h5 mr-0" <?=$disabled;?>></span></a>
						</li>
						<li class="px-1 list-inline-item text border rounded">
							<a id="downloadXLS" href="" rel="subsection"><span aria-hidden="true" title="Descargar Excel" class="icon-file-excel h5 mr-0" <?=$disabled;?>></span></a>
						</li>
					</ul>
				</nav>

				<div class="group row mt-3" id="results">
					<?php
						if (empty($expenses) || $expenses === '--') {
					?>
							<div class="my-5 py-4 center">
								<span class="h4">No se encontraron movimientos.</span>
							</div>
					<?php
						}else{
					?>
							<div class="my-5 py-4 center">
								<span class="h4"></span>
							</div>
					<?php
						}
					?>
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





