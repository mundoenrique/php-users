<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_REPORTS'); ?></h1>
<div class="flex justify-between row">
	<div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
		<div class="flex flex-wrap widget-product">
			<div class="w-100">
				<div class="flex inline-flex col-12 px-xl-2">
					<div class="flex flex-colunm justify-center col-6 py-5">
						<div class="product-presentation relative">
							<div class="item-network"></div>
							<div id="donor" class="product-search btn">
								<a class="dialog button product-button"><span aria-hidden="true" class="icon-find h1 icon-color"></span></a>
								<input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="">
							</div>
						</div>
					</div>
					<div class="flex flex-column items-start self-center col-6 py-5">
						<p class="mb-2">Seleccione una cuenta</p>
					</div>
				</div>
				<div class="flex inline-flex col-12 px-xl-2">
					<div class="flex flex-colunm justify-center col-6 py-5">
						<div class="product-presentation relative">
							<div class="item-network maestro"></div>
							<img class="card-image" src="../../../assets/images/default/bnt_default.svg" alt="Tarjeta Banorte">
						</div>
					</div>
					<div class="flex flex-column items-start col-6 py-5">
						<p class="semibold mb-0 h5">PLATA VIÁTICOS</p>
						<p id="card" class="mb-2">604842******4714</p>
						<a id="other-product" class="btn hyper-link btn-small p-0" href="">
							<i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto</a>
					</div>
				</div>
			</div>
		</div>
		<div class="flex optional widget-statistics p-3 mt-4">
			<h3 class="h4 regular">Estadísticas</h3>
				<div class="flex flex-column items-center">
					<div class="flex flex-wrap items-center">
						<div id="stats" class="group-aside-view">
							<div id="movementsStats" class="detail-stats"></div>
							<div id="transitStats" class="detail-stats"></div>
						</div>
					</div>
				</div>
		</div>
	</div>

	<div class="flex flex-column pt-3 col-lg-12 col-xl-8">
		<h2 class="h4 regular tertiary">Gastos por categoria</h2>
		<nav id="filtersStack" class="navbar px-0">
			<div class="flex mt-2">
				<form id="service-orders-form" method="post" class="w-100">
					<div class="row pl-2">
						<label class="mt-1" for="datepicker_start">Mostrar desde</label>
						<div class="form-group col-4 col-xl-auto">
							<input id="datepicker_start" name="datepicker_start" class="form-control date-picker" type="text" placeholder="DD/MM/AAA">
							<div class="help-block"></div>
						</div>
						<label class="mt-1" for="datepicker_end">Hasta</label>
						<div class="form-group col-4 col-xl-auto pr-1">
							<input id="datepicker_end" name="datepicker_end" class="form-control date-picker" type="text" placeholder="DD/MM/AAA">
							<div class="help-block "></div>
						</div>
						<div class="col-xl-auto flex items-center ml-auto mr-2">
							<button id="buscar" class="btn btn-small btn-rounded-right btn-primary mb-3">
								<span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
							</button>
						</div>
					</div>
				</form>
			</div>
			<ul class="stack list-inline mb-0 flex items-center">
				<li class="stack-item px-1 list-inline-item">
					<a id="downloadPDF" href="#" rel="subsection"><span class="icon-file-pdf h5 mr-0" aria-hidden="true" title="Descargar PDF"></span></a>
				</li>
				<li class="stack-item px-1 list-inline-item">
					<a id="downloadXLS" href="#" rel="subsection"><span class="icon-file-excel h5 mr-0" aria-hidden="true" title="Descargar Excel"></span></a>
				</li>
			</ul>
		</nav>
		<div class="line mb-1"></div>
		<div id="results" class="mt-3">
			<div id="pre-loader" class="mt-3 mx-auto flex justify-center">
				<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
			</div>

			<table id="" class="cell-border h6 display responsive w-100 dataTable no-footer dtr-inline">
				<thead class="bg-primary secondary regular">
					<tr>
						<th class="bold">Meses</th>
						<th><span aria-hidden="true" class="icon-suitcase h3" title="Hoteles"></span></th>
						<th><span aria-hidden="true" class="icon-card h3" title="Cajeros automáticos"></span></th>
						<th><span aria-hidden="true" class="icon-bag h3" title="Comercios y tiendas por departamento"></span></th>
						<th><span aria-hidden="true" class="icon-car h3" title="Alquiler de vehículos"></span></th>
						<th><span aria-hidden="true" class="icon-food h3" title="Comida, despensa y restaurantes"></span></th>
						<th><span aria-hidden="true" class="icon-plane h3" title="Líneas áereas y transporte"></span></th>
						<th><span aria-hidden="true" class="icon-lab h3" title="Farmacias"></span></th>
						<th><span aria-hidden="true" class="icon-film h3" title="Diversión y entretenimiento"></span></th>
						<th><span aria-hidden="true" class="icon-medkit h3" title="Servicios médicos"></span></th>
						<th><span aria-hidden="true" class="icon-asterisk h3" title="Otros"></span></th>
						<th class="bold">Total ($)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach(lang('GEN_SELECT_MONTH') AS $key => $month): ?>
					<tr>
						<td><?= $month ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php endforeach; ?>
					<tr>
						<td class="bold">Total</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>

			<table id="" class="cell-border h6 display responsive w-100 dataTable no-footer dtr-inline">
				<thead class="bg-primary secondary regular">
					<tr>
						<th class="bold">Meses</th>
						<th><span aria-hidden="true" class="icon-suitcase h3" title="Hoteles"></span></th>
						<th><span aria-hidden="true" class="icon-card h3" title="Cajeros automáticos"></span></th>
						<th><span aria-hidden="true" class="icon-bag h3" title="Comercios y tiendas por departamento"></span></th>
						<th><span aria-hidden="true" class="icon-car h3" title="Alquiler de vehículos"></span></th>
						<th><span aria-hidden="true" class="icon-food h3" title="Comida, despensa y restaurantes"></span></th>
						<th><span aria-hidden="true" class="icon-plane h3" title="Líneas áereas y transporte"></span></th>
						<th><span aria-hidden="true" class="icon-lab h3" title="Farmacias"></span></th>
						<th><span aria-hidden="true" class="icon-film h3" title="Diversión y entretenimiento"></span></th>
						<th><span aria-hidden="true" class="icon-medkit h3" title="Servicios médicos"></span></th>
						<th><span aria-hidden="true" class="icon-asterisk h3" title="Otros"></span></th>
						<th class="bold">Total ($)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>20/15/2020</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td class="bold">Total</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>

			<div id="" class="visible">
				<div class="pagination page-number flex mb-5 py-2 flex-auto justify-center">
					<nav class="h4">
						<a href="javascript:" position="first">Primera</a>
						<a href="javascript:" position="prev">«</a>
					</nav>
					<div id="show-page" class="h4 flex justify-center ">
						<span class="mx-1 page-current">
							<a href="javascript:" position="page" filter-page="page_">1</a>
						</span>
					</div>
					<nav class="h4">
						<a href="javascript:" position="next">»</a>
						<a href="javascript:" position="last">Última</a>
					</nav>
				</div>
			</div>
			<div id="" class="hide">
				<div class="flex flex-column items-center justify-center pt-5">
					<h2 class="h3 regular mb-1">No se encontraron registros.</h2>
					<span class="h6 regular mb-0">Seleccione un rango de fecha a consultar.</span>
				</div>
			</div>
		</div>
	</div>
</div>
