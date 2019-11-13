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

				<h2 class="h4 regular tertiary">Mis movimientos</h2>
				<nav id="filters-stack" class="navbar px-1 px-lg-5">
					<div class="stack-form mr-auto flex items-center" id="period-form">
						<form accept-charset="utf-8" class="form-inline" method="post">
							<label class="my-1 mr-1" for="filter-month">Mostrar:</label>
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
						<li class="list-inline-item text border">
							<a id="print-detail" rel="subsection" onclick="window.print();"><span aria-hidden="true" title="Imprimir" class="icon-print mr-0"></span></a>
						</li>
						<li class="list-inline-item text border">
							<a id="download" href="#download" rel="subsection"><span aria-hidden="true" title="Descargar PDF" class="icon-download mr-0"></span></a>
						</li>
						<li class="list-inline-item text border">
							<a id="downloadxls" href="#downloadxls" rel="subsection"><span aria-hidden="true" title="Descargar EXCEL" class="icon-file-excel mr-0"></span></a>
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

				<div class="line mt-1"></div>


				</div>
			</div>
		</section>
	</div>
</div>
