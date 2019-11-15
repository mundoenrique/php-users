<?php
	$months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
?>
<div id="detail" class="detail-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Detalle de cuenta</h1>
		</header>
		<section>
			<div class="pt-3">
				<div class="flex items-center mb-2">
					<div class="product-presentation relative mr-4">
						<img class="item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
						<img class="card-image" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
					</div>
					<div class="product-info-full">
						<p class="product-cardholder mb-1 semibold h4 primary"><?= $data['nom_plastico']; ?></p>
						<p id="card" class="product-cardnumber mb-0 primary"><?= $data['noTarjetaConMascara'];?></p>
						<p class="product-metadata mb-2 h6"><?= $data['nombre_producto'];?></p>
						<ul class="product-balance-group flex justify-between mb-0 list-inline">
							<li class="list-inline-item">Actual
								<span id="actual" class="product-balance block primary">
									<?= $data['actualBalance'] !== '--'? lang('GEN_COIN'): '';?>
									<?= $data['actualBalance'];?>
								</span>
							</li>
							<li class="list-inline-item">En Tránsito
								<span id="bloqueado" class="product-balance block primary">
									<?= $data['ledgerBalance'] !== '--'? lang('GEN_COIN'): '';?>
									<?= $data['ledgerBalance'];?>
								</span>
							</li>
							<li class="list-inline-item">Disponible
								<span id="disponible" class="product-balance block primary">
									<?= $data['availableBalance'] !== '--'? lang('GEN_COIN'): '';?>
									<?= $data['availableBalance'];?>
								</span>
							</li>
						</ul>
					</div>
				</div>

				<h2 class="h4 regular tertiary">Mis movimientos</h2>
				<nav id="filters-stack" class="navbar detail-filters-nav p-1 px-lg-5 bg-widget">
					<div class="stack-form mr-auto flex items-center" id="period-form">
							<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
							<label class="my-1 mr-1 text" for="filter-month">Mostrar:</label>
							<select id="filter-month" class="custom-select form-control my-1 mr-1" name="filter-month">
								<option selected="" value="0">Más recientes</option>
								<option value="1">Enero</option>
								<option value="2">Febrero</option>
								<option value="3">Marzo</option>
								<option value="4">Abril</option>
								<option value="5">Mayo</option>
								<option value="6">Junio</option>
								<option value="7">Julio</option>
								<option value="8">Agosto</option>
								<option value="9">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
							</select>
							<select id="filter-year" class="custom-select form-control my-1 mr-1" name="filter-year" disabled="">
								<option selected="" value="0">-</option>
								<option value="2019">2019</option>
								<option value="2018">2018</option>
								<option value="2017">2017</option>
								<option value="2016">2016</option>
								<option value="2015">2015</option>
							</select>
						<button id="buscar" class="btn btn-small btn-primary"><span aria-hidden="true" class="icon-arrow-right mr-0"></span></button>
					</div>
					<ul class="list-inline mx-2 mb-0 flex items-center">
						<li class="px-1 list-inline-item text border rounded">
							<a id="print-detail" rel="subsection" onclick="window.print();"><span aria-hidden="true" title="Imprimir" class="icon-print h5 mr-0"></span></a>
						</li>
						<li class="px-1 list-inline-item text border rounded">
							<a id="download" href="#download" rel="subsection"><span aria-hidden="true" title="Descargar PDF" class="icon-download h5 mr-0"></span></a>
						</li>
						<li class="px-1 list-inline-item text border rounded">
							<a id="downloadxls" href="#downloadxls" rel="subsection"><span aria-hidden="true" title="Descargar EXCEL" class="icon-file-excel h5 mr-0"></span></a>
						</li>
					</ul>
					<div class="custom-control custom-radio custom-control-inline mr-1">
						<input type="radio" id="disponibleToogle" name="toggle" class="custom-control-input">
						<label class="custom-control-label" for="disponibleToogle">Disponible</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline mr-0">
						<input type="radio" id="transitoToogle" name="toggle" class="custom-control-input">
						<label class="custom-control-label" for="transitoToogle">En tránsito</label>
					</div>
				</nav>

				<div class="group row mt-3" id="results">
					<div class="group-main-view col-8" id="transactions">
						<h3 class="h4 regular">Actividad <span id="period">reciente</span>
							<span id="transit-datail-title" style="display: none;">Transacciones Pendientes</span>
						</h3>
						<div class="line mt-1"></div>
						<ul id="list-detail" class="feed list-style-none mt-3 pl-0">
							<?php
								$totalIncome = 0;
								$totalExpense = 0;
								foreach($data['movimientos'] as $row){
									$separedDate = explode('/',$row->fecha);
									$spanishMonth = substr($months[intval($separedDate[1])-1],0,3);

									$totalIncome += $row->signo == '+'? $row->monto: 0;
									$totalExpense += $row->signo == '-'? $row->monto: 0;
							?>
								<li class="feed-item <?= $row->signo == '+'? 'feed-income': 'feed-expense';?> flex py-1 items-center">
									<div class="flex px-2 border-right flex-column items-center feed-date">
										<span class="h5 feed-date-day"><?= $separedDate[0];?></span>
										<span class="h6 feed-date-month"><?= $spanishMonth;?></span>
										<span class="h6 feed-date-year"><?= $separedDate[2];?></span>
									</div>
									<div class="flex px-2 flex-column mr-auto">
										<span class="h5 semibold feed-product"><?= $row->concepto;?></span>
										<span class="h6 feed-metadata"><?= $row->referencia;?></span>
									</div>
									<span class="px-2 feed-amount items-center"><?= lang('GEN_COIN').' '.($row->signo == '+'? '': $row->signo). $row->monto;?></span>
								</li>
							<?php }?>
						</ul>

					<?php
						if (array_key_exists('pendingTransactions', $data)){
					?>
						<ul id="list-transit-detail" class="feed none list-style-none mt-3 pl-0">
							<?php foreach($data['pendingTransactions'] as $row){
								$separedDate = explode('/',$row->fecha);
								$spanishMonth = substr($months[intval($separedDate[1])-1],0,3);
							?>
								<li class="feed-item <?= $row->signo == '+'? 'feed-income': 'feed-expense';?> flex py-1 items-center">
									<div class="flex px-2 border-right flex-column items-center feed-date">
										<span class="h5 feed-date-day"><?= $separedDate[0];?></span>
										<span class="h6 feed-date-month"><?= $spanishMonth;?></span>
										<span class="h6 feed-date-year"><?= $separedDate[2];?></span>
									</div>
									<div class="flex px-2 flex-column mr-auto">
										<span class="h5 semibold feed-product"><?= $row->concepto;?></span>
										<span class="h6 feed-metadata"><?= $row->referencia;?></span>
									</div>
									<span class="px-2 feed-amount items-center"><?= lang('GEN_COIN').' '.($row->signo == '+'? '': $row->signo). number_format((float)$row->monto, 2,',','.');?></span>
								</li>
							<?php }?>
						</ul>
					<?php
						}
					?>

					</div>

					<div id="stats" class="group-aside-view col-4">
						<h3 class="h4 regular">Estadísticas</h3>
						<div id="estadisticas" class="detail-stats"></div>
						<div id="estadisticas-transit" class="detail-stats"></div>
					</div>

				</div>

				<div class="line mt-1"></div>
			</div>
		</section>
	</div>
</div>
<script>
	var totalIncome = <?= $totalIncome ?>;
	var	totalExpense = <?= $totalExpense ?>;
</script>
