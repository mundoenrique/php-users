<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_CARD_DETAIL'); ?></h1>
<div class="flex justify-between row">
	<div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
		<div class="flex flex-wrap widget-product">
			<div class="line-text w-100">
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
			<div class="flex col-12 mt-2">
				<ul class="flex flex-auto justify-between px-2">
					<li class="list-inline-item">Actual
						<span id="actual" class="product-balance block">$---</span>
					</li>
					<li class="list-inline-item">En tránsito
						<span id="bloqueado" class="product-balance block">$---</span>
					</li>
					<li class="list-inline-item">Disponible
						<span id="disponible" class="product-balance block">$---</span>
					</li>
				</ul>
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
		<h4 class="h4 regular tertiary">Mis movimientos</h4>
		<nav id="filtersStack" class="navbar px-0">
			<div id="period-form" class="stack-form mr-auto flex items-center">
				<label class="my-1 mr-1 text" for="filterMonth">Mostrar:</label>
				<select id="filterMonth" class="custom-select form-control w-auto my-1" name="filterMonth">
					<option value="0">Más recientes</option>
					<option value="01">Enero</option>
					<option value="02">Febrero</option>
					<option value="03">Marzo</option>
					<option value="04">Abril</option>
					<option value="05">Mayo</option>
					<option value="06">Junio</option>
					<option value="07">Julio</option>
					<option value="08">Agosto</option>
					<option value="09">Septiembre</option>
					<option value="10">Octubre</option>
					<option value="11">Noviembre</option>
					<option value="12">Diciembre</option>
				</select>
				<select id="filterYear" class="custom-select form-control w-auto my-1" name="filterYear" disabled="">
					<option value="2020">-</option>
					<option value="2020">2020</option>
					<option value="2019">2019</option>
					<option value="2018">2018</option>
					<option value="2017">2017</option>
				</select>
				<button id="buscar" class="btn btn-small btn-rounded-right btn-primary">
					<span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
				</button>
			</div>
				<button class="btn btn-outline btn-small btn-rounded-left bg-white" data-jplist-control="reset" data-group="group-filter-pagination" data-name="reset">Movimientos</button>
				<button class="btn btn-outline btn-small btn-rounded-right nowrap is-disabled" data-jplist-control="reset" data-group="group-filter-pagination" data-name="reset">En tránsito</button>
			<ul class="stack list-inline mb-0 flex items-center">
				<li class="stack-item px-1 list-inline-item">
					<a id="downloadPDF" href="#" rel="subsection"><span class="icon-file-pdf h5 mr-0" aria-hidden="true" title="Descargar PDF"></span></a>
				</li>
				<li class="stack-item px-1 list-inline-item is-disabled">
					<a id="" href="#"><span class="icon-email h5 mr-0" aria-hidden="true" title="Enviar PDF"></span></a>
				</li>
				<li class="stack-item px-1 list-inline-item">
					<a id="downloadXLS" href="#" rel="subsection"><span class="icon-file-excel h5 mr-0" aria-hidden="true" title="Descargar Excel"></span></a>
				</li>
				<li class="stack-item px-1 list-inline-item is-disabled">
					<a id="" href="#"><span class="icon-email h5 mr-0" aria-hidden="true" title="Enviar Excel"></span></a>
				</li>
			</ul>
		</nav>
		<div class="line mb-1"></div>
		<div id="results" class="mt-3">
			<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
				<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
			</div>
			<ul id="movementsList" class="feed fade-in mt-3 pl-0 hide-out hide">
				<li class="feed-item feed-income flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">TRANSFERENCIA MOVIL VE</span>
						<span class="h6 feed-metadata">864881220211</span>
					</div>
					<span class="px-2 feed-amount items-center">$ 250,00</span>
				</li>
				<li class="feed-item feed-income flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">TRANSFERENCIA WEB VE</span>
						<span class="h6 feed-metadata">863872141611</span>
					</div>
					<span class="px-2 feed-amount items-center">$ 1,00</span>
				</li>
				<li class="feed-item feed-income flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">TRANSFERENCIA WEB VE</span>
						<span class="h6 feed-metadata">863803130916</span>
					</div>
					<span class="px-2 feed-amount items-center">$ 1,00</span>
				</li>
				<li class="feed-item feed-expense flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">Bank Name St Louis VE</span>
						<span class="h6 feed-metadata">546506</span>
					</div>
					<span class="px-2 feed-amount items-center">- $ 10,00</span>
				</li>
				<li class="feed-item feed-expense flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">Bank Name St Louis VE</span>
						<span class="h6 feed-metadata">546506</span>
					</div>
					<span class="px-2 feed-amount items-center">- $ 10,00</span>
				</li>
				<li class="feed-item feed-expense flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">Bank Name St Louis VE</span>
						<span class="h6 feed-metadata">546500</span>
					</div>
					<span class="px-2 feed-amount items-center">- $ 10,00	</span>
				</li>
				<li class="feed-item feed-expense flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">TRANSFERENCIA WEB VE</span>
						<span class="h6 feed-metadata">856181133624</span>
					</div>
					<span class="px-2 feed-amount items-center">- $ 100,00</span>
				</li>
				<li class="feed-item feed-expense flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">TRANSFERENCIA WEB VE</span>
						<span class="h6 feed-metadata">853866164643</span>
					</div>
					<span class="px-2 feed-amount items-center">- $ 100,00</span>
				</li>
				<li class="feed-item feed-expense flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">TRANSFERENCIA WEB VE</span>
						<span class="h6 feed-metadata">849992174402</span>
					</div>
					<span class="px-2 feed-amount items-center">- $ 100,00</span>
				</li>
				<li class="feed-item feed-expense flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5">13 Oct 2017</span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product">TRANSFERENCIA WEB VE</span>
						<span class="h6 feed-metadata">849637155758</span>
					</div>
					<span class="px-2 feed-amount items-center">- $ 1.000,00</span>
				</li>
			</ul>
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
					<h3 class="h4 regular mb-0">No se encontraron resultados</h3>
				</div>
			</div>
		</div>
	</div>
</div>


