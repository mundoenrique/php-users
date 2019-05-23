<div id="content">
	<article>
		<header>
			<h1>Reportes</h1>
		</header>
		<section>
			<div class="group" id="donor">
				<div class="product-presentation">
					<a class="button product-button dialog"><span aria-hidden="true" class="icon-find"></span></a>
					<input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="" />
				</div>
				<div class="product-info-full">
					<p class="field-tip">Seleccione una cuenta asociada a visualizar.</p>
				</div>
			</div>
			<h2>Gastos por Categoría</h2>
			<nav id="filters-stack">

				<div class="stack-form" id="reporte" moneda="<?php echo lang("MONEDA"); ?>" id="<?php echo lang("ID"); ?>">
					<form accept-charset="utf-8" method="post" id="fechas">
						<fieldset>
							<label for="filter-range-from">Mostrar Desde</label>
							<div class="field-prepend">
								<span aria-hidden="true" class="icon-calendar"></span>
								<input class="field-small" id="filter-range-from" name="filter-range-from" maxlength="10" placeholder="dd/mm/aaaa" disabled/>
							</div>
							<label for="filter-range-to">Hasta</label>
							<div class="field-prepend">
								<span aria-hidden="true" class="icon-calendar"></span>
								<input class="field-small" id="filter-range-to" name="filter-range-to" maxlength="10" placeholder="dd/mm/aaaa" disabled/>
							</div>
						</fieldset>
					</form>


					<button id="mens" class="mensual disabled-button"><span aria-hidden="true" class="icon-arrow-right"></span></button>
				</div>

				<ul class="stack stack-extra" id="download-boxes">
					<li class="stack-item">

						<a href="#download-excel" id="export_excel" rel="subsection" title="Descargar EXCEL"><span aria-hidden="true" class="icon-file-excel"></span></a>
					</li><li class="stack-item">

						<a href="#download-pdf" id="export_pdf" rel="subsection" title="Descargar PDF"><span aria-hidden="true" class="icon-file-pdf"></span></a>
					</li>
				</ul>
				<div class="field-options">
					<input id="detalle" name="toggle" type="radio" checked disabled>
					<label for="detalle">Detalle</label>

					<input id="grafico" name="toggle" type="radio" disabled>
					<label for="grafico">Gráfico</label>
					<!-- <li class="stack-item">
						<a id ="detalle" href="#report-detail" rel="subsection">Detalle</a>
					</li>
					<li class="stack-item">
						<a id ="grafico" href="#report-chart" rel="subsection" display="none">Gráfica</a>
					</li> -->
				</div>
			</nav>
			<div id="empty-state">
				<h2>Sin resultados a mostrar</h2>
				<p>Debe seleccionar una cuenta asociada a visualizar.</p>
				<span aria-hidden="true" class="icon-chart-pie"></span>
			</div>
			<div id="empty-state" data-result="noresult" class="nodata-state" style="position: static;">
				<h2>Sin resultados a mostrar</h2>
				<p>Seleccione un rango de fecha a consultar</p>
				<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -410px;"></span>
			</div>
			<div id="chart" style="display:none;"></div>
			<div class="group" id="results" style="display:none">

				<div id="report-detail" class="content-anio" style="display:none">
					<table class="feed-table" cellpadding="0" cellspacing="0">
						<thead>
						<!--
						Hoteles
						Cajeros Automaticos
						Comercio y Tiendas por Departamento
						Alquiler de vehiculos
						Comida, Despensa y restaurantes
						Lineas Aereas y Transporte
						Farmacias
						Diversion y entretenimiento
						Servicios medicos
						Otros -->
						<tr>
							<th class="feed-headline">Meses</th>
							<th class="feed-category feed-category-1x"><span aria-hidden="true" class="icon-suitcase" title="Hoteles"></span></th>
							<th class="feed-category feed-category-2x"><span aria-hidden="true" class="icon-card" title="Cajeros automáticos"></span></th>
							<th class="feed-category feed-category-3x"><span aria-hidden="true" class="icon-bag" title="Comercios y tiendas por departamento"></span></th>
							<th class="feed-category feed-category-4x"><span aria-hidden="true" class="icon-car" title="Alquiler de vehículos"></span></th>
							<th class="feed-category feed-category-5x"><span aria-hidden="true" class="icon-food" title="Comida, despensa y restaurantes"></span></th>
							<th class="feed-category feed-category-6x"><span aria-hidden="true" class="icon-plane" title="Líneas áereas y transporte"></span></th>
							<th class="feed-category feed-category-7x"><span aria-hidden="true" class="icon-lab" title="Farmacias"></span></th>
							<th class="feed-category feed-category-8x"><span aria-hidden="true" class="icon-film" title="Diversión y entretenimiento"></span></th>
							<th class="feed-category feed-category-9x"><span aria-hidden="true" class="icon-medkit" title="Servicios médicos"></span></th>
							<th class="feed-category feed-category-10x"><span aria-hidden="true" class="icon-asterisk" title="Otros"></span></th>
							<th class="feed-headline">Total ( <?php echo lang("MONEDA"); ?>)</th>
						</tr>
						</thead>
						<tbody>
						<tr  id="enero">
							<td class="feed-headline">Enero</td>
						</tr>
						<tr id="febrero">
							<td class="feed-headline">Febrero</td>
						</tr>
						<tr id="marzo">
							<td class="feed-headline">Marzo</td>
						</tr>
						<tr id="abril">
							<td class="feed-headline">Abril</td>

						</tr>
						<tr id="mayo">
							<td class="feed-headline">Mayo</td>
						</tr>
						<tr id="junio">
							<td class="feed-headline">Junio</td>

						</tr>
						<tr id="julio">
							<td class="feed-headline">Julio</td>

						</tr>
						<tr id="agosto">
							<td class="feed-headline">Agosto</td>
						</tr>
						<tr id="septiembre">
							<td class="feed-headline">Septiembre</td>
						</tr>
						<tr id="octubre">
							<td class="feed-headline">Octubre</td>

						</tr>
						<tr id="noviembre">
							<td class="feed-headline">Noviembre</td>

						</tr>
						<tr id="diciembre">
							<td class="feed-headline">Diciembre</td>
						</tr>
						</tbody>
						<tfoot>
						<tr id="totales">
							<td class="feed-headline">Total</td>
						</tr>
						</tfoot>
					</table>
				</div>

				<div id="report-detail" class="content-mes" style="display:none">
					<table class="feed-table " cellpadding="0" cellspacing="0">
						<thead>
						<tr id="tabla_detalle">
							<th class="feed-headline">Fecha</th>
							<th class="feed-category feed-category-1x"><span aria-hidden="true" class="icon-suitcase" title="Hoteles"></span></th>
							<th class="feed-category feed-category-2x"><span aria-hidden="true" class="icon-card" title="Cajeros automáticos"></span></th>
							<th class="feed-category feed-category-3x"><span aria-hidden="true" class="icon-bag" title="Comercios y tiendas por departamento"></span></th>
							<th class="feed-category feed-category-4x"><span aria-hidden="true" class="icon-car" title="Alquiler de vehículos"></span></th>
							<th class="feed-category feed-category-5x"><span aria-hidden="true" class="icon-food" title="Comida, despensa y restaurantes"></span></th>
							<th class="feed-category feed-category-6x"><span aria-hidden="true" class="icon-plane" title="Líneas áereas y transporte"></span></th>
							<th class="feed-category feed-category-7x"><span aria-hidden="true" class="icon-lab" title="Farmacias"></span></th>
							<th class="feed-category feed-category-8x"><span aria-hidden="true" class="icon-film" title="Diversión y entretenimiento"></span></th>
							<th class="feed-category feed-category-9x"><span aria-hidden="true" class="icon-medkit" title="Servicios médicos"></span></th>
							<th class="feed-category feed-category-10x"><span aria-hidden="true" class="icon-asterisk" title="Otros"></span></th>
							<th class="feed-headline">Total <?php echo lang("MONEDA"); ?></th>
						</tr>
						</thead>
						<tbody id="tbody-datos-mes">

						</tbody>
						<tfoot>
						<tr id="totales-mes">
						</tr>
						</tfoot>
					</table>
				</div>
				<form id='form' method='post' action="report/exp_xls">
					<input id="tarjeta" type="hidden" name="tarjeta" value="" />
					<input id="idpersona" type="hidden" name="idpersona" value="" />
					<input id="producto" type="hidden" name="producto" value="" />
					<input id="tipoConsulta" type="hidden" name="tipoConsulta" value="" />
					<input id="fechaIni" type="hidden" name="fechaIni" value="" />
					<input id="fechaFin" type="hidden" name="fechaFin" value="" />
				</form>
				<form id='form_pdf' method='post' action="report/exp_pdf">
					<input id="tarjeta_pdf" type="hidden" name="tarjeta" value="" />
					<input id="idpersona_pdf" type="hidden" name="idpersona" value="" />
					<input id="producto_pdf" type="hidden" name="producto" value="" />
					<input id="tipoConsulta_pdf" type="hidden" name="tipoConsulta" value="" />
					<input id="fechaIni_pdf" type="hidden" name="fechaIni" value="" />
					<input id="fechaFin_pdf" type="hidden" name="fechaFin" value="" />
				</form>
			</div>
		</section>
	</article>
	<div id="msg"></div>
</div>

<?php

	$datos = null;
	if(isset($data)){

	$datos = unserialize($data);
	if($datos->rc==0){
		$tebca = 0;
		$servitebca = 0;
		$todos = 0;
		foreach ($datos->cuentaOrigen as $value) {
			$nombre_empresa = $value->nomEmp;
			$cuenta = count(explode(" ", $nombre_empresa));

			if($cuenta>1){
				$findspace = ' ';
				$posicion = strpos($nombre_empresa , $findspace);
				$princ = 0;
				$nombre_empresa = substr($nombre_empresa, $princ, $posicion);
			}
			$todos = $todos +1;
		}
	}
	else if($datos->rc==-150){
		header("Location: report/error");
	}

	else{
		header("Location: users/error");
	}
?>

<div id='content-product' style='display:none'>
	<nav id="filters-stack">
		<ul id="filters" class="stack option-set" data-option-key="filter">
			<li class="stack-item current-stack-item">
				<a href="#all" rel="subsection" data-option-value="*"><span class="badge"><?php echo $todos; ?></span> <?php echo $todos > 1 ? 'Cuentas' : 'Cuenta'; ?></a>
			</li>
		</ul>
	</nav>

	<?php
		}
	?>

	<ul id='dashboard-donor'>

		<?php
			$base_cdn = $this->config->item('base_url_cdn');
			foreach ($datos->cuentaOrigen as $value) {
				// $img1=strtolower(str_replace(' ','-',$value->producto));
				// $img=str_replace("/", "-", $img1);
				$cadena = strtolower($value->producto);
				$producto1 = quitar_tildes($cadena);
				$img1=strtolower(str_replace(' ','-',$producto1));
				$img=str_replace("/", "-", $img1);
				$marca= strtolower(str_replace(" ", "-", $value->marca));
				$empresa = strtolower($value->nomEmp);
				$pais=ucwords($this->session->userdata('pais'));
				$moneda=lang("MONEDA");
				$id=lang("ID");

				echo "<li class='dashboard-item $empresa' card='$value->nroTarjeta' id='$id' nombre='$value->tarjetaHabiente' producto1='$value->producto' idpersona='$value->id_ext_per' marca='$marca' mascara='$value->nroTarjetaMascara' moneda='$moneda' empresa='$empresa' producto='$img' prefix='$value->prefix'>
							<a href='#' rel='section'>
								<img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' />
								<div class='dashboard-item-network $marca'>$value->marca</div>
								<div class='dashboard-item-info'>
									<p class='dashboard-item-cardholder'>$value->tarjetaHabiente</p>
									<p class='dashboard-item-cardnumber'>$value->nroTarjetaMascara</p>
									<p class='dashboard-item-category'>$value->producto</p>
								</div>
							</a>
						</li>";
			}
			function quitar_tildes($cadena) {
				$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
				$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
				$texto = str_replace($no_permitidas, $permitidas ,$cadena);
				return $texto;
			}
		?>
	</ul>
	<?php echo "<div class='form-actions'>
           <button  id='cerrar' type='reset'>Cancelar</button>
        </div>";
	?>
</div>


<!-- <div class="ui-dialog-content ui-widget-content" id="dialog-clave-load" style="width: auto; min-height: 128px; max-height: none; height: auto;"> -->

<div class="dialog-small" id="dialog" style="margin-top:400px;">

	<ul id= "list-detail" class="feed">
		<div id ="loading" class="data-indicator" style="text-align: center;">
			<h3 style="border-bottom: 0px;">Cargando</h3>
			<span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 50px;"></span>
		</div>
	</ul>
</div>
<!-- </div> -->
