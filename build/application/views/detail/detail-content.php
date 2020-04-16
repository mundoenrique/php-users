<?php
$country = $this->session->userdata('pais');
$CI =& get_instance();
$cdnPath = $CI->config->item('base_path_cdn');
$cookie = $this->input->cookie($this->config->item('cookie_prefix').'skin');
$cpo_name = $this->security->get_csrf_token_name();
$cpo_cook = $this->security->get_csrf_hash();
?>
			<div id="content">
				<article>
					<header>
						<h1>Detalle de la cuenta</h1>
					</header>
					<section>
						<div class="group" id="balance">
							<div class="product-presentation">
							<?php
								 $filepath = $cdnPath.'img/products/'.$country.'/'.$imgDetail.'.png';
								if(!file_exists($filepath))
								$imgDetail = 'default';
								$filepath = $cdnPath.'img/products/'.$country.'/'.$imgDetail.'.png';

								?>
								<img src="<?php echo $this->config->item('base_url_cdn').'img/products/'.$this->session->userdata('pais').'/'.$imgDetail.'.png'; ?>" width="200" height="130" alt="" />
								<div class="product-network <?php echo $marca; ?>"><?php echo $marca; ?></div>
							</div>
							<div class="product-info-full" moneda="<?php echo lang("MONEDA"); ?>">
								<p class="product-cardholder"><?php echo ucwords($this->session->userdata('nombreCompleto')); ?><span class="product-cardholder-id"><?php echo lang("ID")." ".$this->session->userdata('idUsuario'); ?></span></p>
								<p id="card" class="product-cardnumber" card='<?php echo $tarjeta; ?>' prefix='<?php echo $prefix; ?>'><?php echo $numt_mascara; ?></p>
								<p class="product-metadata"> <?php echo ucwords(strtolower(str_replace("-", " ",$producto)))." / ".ucwords(str_replace("-", " ", $marca))." / ".ucwords($empresa); ?></p>
								<ul class="product-balance-group">
									<li>Actual <span id="actual" class="product-balance"> <?php echo lang("MONEDA"); ?> --- </span></li>
									<li>En Tránsito <span id="bloqueado" class="product-balance"> <?php echo lang("MONEDA"); ?> --- </span></li>
									<li>Disponible <span id="disponible" class="product-balance"> <?php echo lang("MONEDA"); ?> --- </span></li>
								</ul>
							</div>
						</div>
						<?php if($country != 'Ec-bp'): ?>
						<a class="button alternate-button small-button novo-btn-secondary volver" href="<? echo $this->config->item("base_url"); ?>/dashboard">Volver atrás</a>
						<?php endif;?>
						<h2>Movimientos</h2>
						<nav id="filters-stack">
							<div class="stack-form" id="period-form">
								<form accept-charset="utf-8" class="stack-form" method="post">
									<fieldset>
										<label for="filter-month">Mostrar:</label>
										<select id="filter-month" name="filter-month">
											<option selected value="0">Más recientes</option>
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
										<select id="filter-year" name="filter-year" disabled>
											<option selected value="0">-</option>
											<?php
											// Fix to generate options from current year up to previous four @mpalazzo
											$anno_act = date('Y');
											for ($i = $anno_act; $i > $anno_act - 5; $i--): ?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php endfor; ?>
										</select>
									</fieldset>
								</form>
								<button id="buscar" class="mensual novo-btn-primary"><span aria-hidden="true" class="icon-arrow-right"></span></button>
							</div>
							<ul class="stack stack-extra">
								<?php if($country != 'Ec-bp'): ?>
								<li class="stack-item">
									<a id="print-detail" rel="subsection" onclick="window.print();"><span aria-hidden="true" title="Imprimir" class="icon-print"></span></a>
								</li>
								<li class="stack-item">
									<a id="download"  href="#download" rel="subsection"><span aria-hidden="true" title="Descargar PDF" class="icon-download"></span></a>
								</li>
								<?php endif; ?>
								<li class="stack-item">
									<a id="downloadxls"  href="#downloadxls" rel="subsection"><span aria-hidden="true" title="Descargar EXCEL" class="icon-file-excel"></span></a>
								</li>
							</ul>
							<?php if($country != 'Ec-bp'): ?>
								<div class="field-options">
									<input id="disponibleToogle" name="toggle" type="radio" checked>
									<label for="disponibleToogle">Disponible</label>

									<input id="transitoToogle" name="toggle" type="radio" disabled>
									<label for="transitoToogle">En tránsito</label>
								</div>
							<?php endif; ?>
						</nav>
						<div class="group" id="results">
							<div class="group-main-view" id="transactions">
								<h3>Actividad <span id="period"></span>
								<?php if($country != 'Ec-bp'): ?>
								<span id="transit-datail-title">Transacciones Pendientes</span>
								<?php endif; ?>
								</h3>
								<ul id= "list-detail" class="feed">
									<div id ="loading" class="data-indicator" style="text-align: center;">
										<h3 style="border-bottom: 0px;">Cargando</h3>
										<span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 50px;"></span>
									</div>
								</ul>
								<?php if($country != 'Ec-bp'): ?>
								<ul id="list-transit-detail" class="feed"></ul>
								<?php endif; ?>
								<form id='form' method='post' action="detalles/exportar">
									<input id="tarjeta" type="hidden" name="tarjeta" value="" />
									<input id="mes" type="hidden" name="mes" value="" />
									<input id="anio" type="hidden" name="anio" value="" />
									<input id="idOperation" type="hidden" name="idOperation" value="" />
								</form>
							</div>
							<div class="group-aside-view" id="stats">
								<h3>Estadísticas</h3>
								<div id="estadisticas" style="width:300px; height:250px"></div>
								<?php if($country != 'Ec-bp'): ?>
								<div id="estadisticas-transit" style="width:300px; height:250px">
								<?php endif; ?>
							</div>
						</div>
					</section>
				</article>
			</div>
