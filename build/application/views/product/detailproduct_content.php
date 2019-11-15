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
					<div class="product-info-full" moneda="Bs.">
						<p class="product-cardholder mb-1 semibold h4 primary capitalize"><?= $data['nom_plastico']; ?></p>
						<p id="card" class="product-cardnumber mb-0 primary"><?= $data['noTarjetaConMascara'];?></p>
						<p class="product-metadata mb-2 h6 capitalize"><?= $data['nombre_producto'];?></p>
						<ul class="product-balance-group flex justify-between mb-0 list-inline">
							<li class="list-inline-item">Actual <span id="actual" class="product-balance block primary"><?= $data['actualBalance'];?></span></li>
							<li class="list-inline-item">En Tránsito <span id="bloqueado" class="product-balance block primary"><?= $data['ledgerBalance'];?></span></li>
							<li class="list-inline-item">Disponible <span id="disponible" class="product-balance block primary"><?= $data['availableBalance'];?></span></li>
						</ul>
					</div>
				</div>

				<h2 class="h4 regular tertiary">Mis movimientos</h2>
				<nav id="filters-stack" class="navbar detail-filters-nav p-1 px-lg-5 bg-widget">
					<div class="stack-form mr-auto flex items-center" id="period-form">
						<form accept-charset="utf-8" class="form-inline" method="post">
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
						</form>
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
						<label class="custom-control-label" for="disponibleToogle">Masculino</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline mr-0">
						<input type="radio" id="transitoToogle" name="toggle" class="custom-control-input">
						<label class="custom-control-label" for="transitoToogle">Masculino</label>
					</div>
				</nav>

				<div class="group row mt-3" id="results">
					<div class="group-main-view col-8" id="transactions">
						<h3 class="h4 regular">Actividad <span id="period">reciente</span>
							<span id="transit-datail-title" style="display: none;">Transacciones Pendientes</span>
						</h3>
						<div class="line mt-1"></div>
						<ul id="list-detail" class="feed list-style-none mt-3 pl-0">
							<li class="feed-item feed-income flex py-1 items-center">
								<div class="flex px-2 border-right flex-column items-center feed-date">
									<span class="h5 feed-date-day">08</span>
									<span class="h6 uppercase feed-date-month">Nov</span>
									<span class="h6 feed-date-year">2019</span>
								</div>
								<div class="flex px-2 flex-column mr-auto">
									<span class="h5 uppercase semibold feed-product">BENEFICIO DE ALIMENTACION</span>
									<span class="h6 feed-metadata">364271</span>
								</div>
								<span class="px-2 feed-amount items-center">Bs. 325.000,00</span>
							</li>
							<li class="feed-item feed-expense flex py-1 items-center">
								<div class="flex px-2 border-right flex-column items-center feed-date">
									<span class="h5 feed-date-day">08</span>
									<span class="h6 uppercase feed-date-month">Nov</span>
									<span class="h6 feed-date-year">2019</span>
								</div>
								<div class="flex px-2 flex-column mr-auto">
									<span class="h5 uppercase semibold feed-product">BENEFICIO DE ALIMENTACION</span>
									<span class="h6 feed-metadata">364271</span>
								</div>
								<span class="px-2 feed-amount items-center">Bs. -325.000,00</span>
							</li>
						</ul>
					</div>
					<div class="group-aside-view col-4" id="stats">
						<h3 class="h4 regular">Estadísticas</h3>
						<div class="line mt-1"></div>
						<div id="estadisticas" style="width: 300px; height: 250px; position: relative;" data-role="chart" class=" k-chart"><svg style="width: 100%; height: 100%; overflow: hidden; left: -0.5px; top: -0.5px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"><defs></defs><g><path d="M0 0 L 300 0 300 250 0 250Z" stroke="none" fill="transparent"></path><path d="M0 0 L 0 0 0 0 0 0Z" stroke="none" fill="transparent" fill-opacity="0"></path><g><g></g></g><g><g><g transform="matrix(1,0,0,1,0,0)"><path d="M150 41 C 169.394 41 188.715 47.972 203.64 60.357 218.565 72.741 228.982 90.445 232.559 109.507 236.136 128.568 232.847 148.844 223.428 165.797 L 181.469 142.484 C 185.506 135.219 186.915 126.529 185.382 118.36 183.849 110.191 179.385 102.603 172.989 97.296 166.592 91.988 158.312 89 150 89Z" stroke="none" fill="#E74C3C"></path></g><g transform="matrix(1,0,0,1,0,0)"><path d="M223.428 165.797 C 213.896 182.951 198.157 196.568 179.81 203.533 161.463 210.497 140.652 210.754 122.138 204.245 103.625 197.736 87.554 184.511 77.602 167.597 67.65 150.683 63.896 130.212 67.197 110.868 70.499 91.523 80.831 73.456 95.829 60.801 110.828 48.145 130.375 41 150 41 L 150 89 C 141.589 89 133.212 92.062 126.784 97.486 120.356 102.91 115.928 110.653 114.513 118.943 113.098 127.234 114.707 136.007 118.972 143.256 123.237 150.505 130.125 156.172 138.059 158.962 145.994 161.752 154.913 161.642 162.776 158.657 170.639 155.672 177.384 149.836 181.469 142.484Z" stroke="none" fill="#2ECC71"></path></g></g></g></g></svg></div>
						<div id="estadisticas-transit" style="width: 300px; height: 250px; visibility: hidden; display: none;"></div>
					</div>
				</div>

				<div class="line mt-1"></div>
			</div>
		</section>
	</div>
</div>
<script>
	var transactionsHistory = '<?= json_encode($data['movimientos']);?>';
	<?php if(array_key_exists('pendingTransactions', $data)) {	?>
		var pendingTransactions = '<?= json_encode($data['pendingTransactions']);?>';
	<?php } ?>
</script>
<?= var_dump($data);?>
