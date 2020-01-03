<form method="post" action=''>
	<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>' >
	<input type='hidden' name='frmInitialDate' value=''>
	<input type='hidden' name='frmFinalDate' value=''>
	<input type='hidden' name='frmTypeFile' value=''>
</form>

<div id="report" class="report-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Reportes</h1>
		</header>
		<section>
			<div class="pt-3">
				<div class="flex max-width-4 flex-wrap items-center mb-2">
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

				<h2 class="h4 regular tertiary">Gastos por categoría</h2>
				<nav id="filtersStack" class="navbar detail-filters-nav p-1 px-lg-5 bg-widget">
					<div class="stack-form mr-auto flex items-center" id="period-form">
						<div class="form-inline">
							<label class="nowrap mb-0" for="fromDate">Mostrar desde</label>
							<input type="text" id="fromDate" name="fromDate" class="mx-2 form-control">
							<label class="nowrap mb-0" for="toDate">Hasta</label>
							<input type="text" id="toDate" name="toDate" class="mx-2 form-control">
							<button id="buscar" class="btn btn-small btn-primary"><span aria-hidden="true" class="icon-arrow-right mr-0"></span></button>
						</div>
					</div>
					<div class="field-options btn-group btn-group-toggle" data-toggle="buttons">
						<label id="detailToogle" class="btn-small btn-options btn-outline btn-rounded-left active">
							<input id="optionDetail" type="radio" name="reportes" checked> Detalle
						</label>
						<label id="statsToogle" class="btn-small btn-options btn-outline btn-rounded-right nowrap is-disabled" >
							<input id="optionStats" type="radio" name="reportes" disabled> Gráfico
						</label>
					</div>
					<ul class="stack-extra list-inline mb-0 flex items-center">
						<li class="px-1 list-inline-item text border rounded">
							<a id="downloadPDF" href="" rel="subsection"><span aria-hidden="true" title="Descargar PDF" class="icon-download h5 mr-0"></span></a>
						</li>
						<li class="px-1 list-inline-item text border rounded">
							<a id="downloadXLS" href="" rel="subsection"><span aria-hidden="true" title="Descargar Excel" class="icon-file-excel h5 mr-0"></span></a>
						</li>
					</ul>
				</nav>

				<div class="group max-width-6 mt-3">

					<div id="results" class="">
						<div id="noRecords" class="my-5 pt-4 center none">
							<span class="block mb-1 h4">No se encontraron registros</span>
							<span>Seleccione un rango de fecha a consultar.</span>
						</div>

						<div id="reportAnnual" class="feed content-anio">
						<?php if (!empty($expenses) && $expenses !== ''): ?>
							<table class="feed-table">
								<thead>
									<tr>
										<th class="feed-headline">Meses</th>
										<th class="feed-category feed-category-1x"><span aria-hidden="true" class="icon-car" title="Alquiler de vehículos"></span></th>
										<th class="feed-category feed-category-2x"><span aria-hidden="true" class="icon-bag" title="Comercios y tiendas por departamento"></span></th>
										<th class="feed-category feed-category-3x"><span aria-hidden="true" class="icon-food" title="Comida, despensa y restaurantes"></span></th>
										<th class="feed-category feed-category-4x"><span aria-hidden="true" class="icon-film" title="Diversión y entretenimiento"></span></th>
										<th class="feed-category feed-category-5x"><span aria-hidden="true" class="icon-lab" title="Farmacias"></span></th>
										<th class="feed-category feed-category-6x"><span aria-hidden="true" class="icon-suitcase" title="Hoteles"></span></th>
										<th class="feed-category feed-category-7x"><span aria-hidden="true" class="icon-plane" title="Líneas áereas y transporte"></span></th>
										<th class="feed-category feed-category-8x"><span aria-hidden="true" class="icon-medkit" title="Servicios médicos"></span></th>
										<th class="feed-category feed-category-9x"><span aria-hidden="true" class="icon-card" title="Cajeros automáticos"></span></th>
										<th class="feed-category feed-category-10x"><span aria-hidden="true" class="icon-asterisk" title="Otros"></span></th>
										<th class="feed-headline text-right">Total <?php echo lang("GEN_COIN"); ?></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($expenses->data->totalesAlMes as $key => $value): ?>
									<tr id="<?= strtolower($value->mes); ?>">
										<td class="feed-headline"><?= ucfirst(strtolower($value->mes)); ?></td>
									<?php foreach($expenses->data->listaGrupo as $col): ?>
										<td class="feed-monetary"><?= number_format(str_replace(',','',$col->gastoMensual[$key]->monto),2,",","."); ?></td>
									<?php endforeach; ?>
										<td class="feed-total"><?= number_format(str_replace(',','',$value->monto),2,",","."); ?></td>
									</tr>
								<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr id="totales">
										<td class="feed-headline">Total</td>
									<?php foreach($expenses->data->listaGrupo as $key => $value): ?>
										<td class="feed-monetary feed-category-<?= $key+1; ?>x"><?= number_format(str_replace(',','',$value->totalCategoria),2,",","."); ?></td>
									<?php endforeach; ?>
										<td class="feed-total"><?= number_format(str_replace(',','',$expenses->data->totalGeneral),2,",","."); ?></td>
									</tr>
								</tfoot>
							</table>
						<?php endif; ?>
						</div>

						<div id="reportMonthly" class="feed content-mes">
							<table class="feed-table">
								<thead>
									<tr>
										<th class="feed-headline">Fecha</th>
										<th class="feed-category feed-category-1x"><span aria-hidden="true" class="icon-car" title="Alquiler de vehículos"></span></th>
										<th class="feed-category feed-category-2x"><span aria-hidden="true" class="icon-bag" title="Comercios y tiendas por departamento"></span></th>
										<th class="feed-category feed-category-3x"><span aria-hidden="true" class="icon-food" title="Comida, despensa y restaurantes"></span></th>
										<th class="feed-category feed-category-4x"><span aria-hidden="true" class="icon-film" title="Diversión y entretenimiento"></span></th>
										<th class="feed-category feed-category-5x"><span aria-hidden="true" class="icon-lab" title="Farmacias"></span></th>
										<th class="feed-category feed-category-6x"><span aria-hidden="true" class="icon-suitcase" title="Hoteles"></span></th>
										<th class="feed-category feed-category-7x"><span aria-hidden="true" class="icon-plane" title="Líneas áereas y transporte"></span></th>
										<th class="feed-category feed-category-8x"><span aria-hidden="true" class="icon-medkit" title="Servicios médicos"></span></th>
										<th class="feed-category feed-category-9x"><span aria-hidden="true" class="icon-card" title="Cajeros automáticos"></span></th>
										<th class="feed-category feed-category-10x"><span aria-hidden="true" class="icon-asterisk" title="Otros"></span></th>
										<th class="feed-headline text-right">Total <?php echo lang("GEN_COIN"); ?></th>
									</tr>
								</thead>
								<tbody id="tbodyMes">
								</tbody>
								<tfoot>
									<tr id="totalesMes">
									</tr>
								</tfoot>
							</table>
						</div>
					</div>

					<div id="chart" class="feed"></div>

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





