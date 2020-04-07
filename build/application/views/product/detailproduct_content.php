<?php 

// echo "-----------------------------<br/>";
// Converting Array to bytes
// $iv = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
// $chars = array_map("chr", $iv);
// $IVbytes = join($chars);

// $data = '7JFeEF3KLvwDGc1r+J4DLwu003du003d';
// $encrypted = openssl_encrypt($data, 'AES-256-CBC', 's81z+L8S847MD/RIl4rO9IZJIz8GETNao/4gXox7l5Q=', OPENSSL_RAW_DATA, $IVbytes);
// echo bin2hex($encrypted);
// echo "<br/>-----------------------------";
// exit();
?>
<form method="post">
	<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
</form>

<form method="post" action='<?= base_url('detalle/download'); ?>'>
	<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
	<input type='hidden' name='frmMonth' value=''>
	<input type='hidden' name='frmYear' value=''>
	<input type='hidden' name='frmTypeFile' value=''>
</form>

<div id="detail" class="detail-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Detalle de cuenta</h1>
		</header>
		<section>
			<div class="pt-3">
				<div class="flex max-width-4 flex-wrap items-start justify-between mb-2">
					<div class="product-presentation flex flex-column items-end mr-4">
						<div class="relative">
							<div class="item-network <?= $data['marca']; ?>"></div>
							<img class="card-image" src="<?= $this->asset->insertFile('img-card_gray.svg', 'img', $countryUri); ?>" alt="Tarjeta gris">
						</div>
						<div class="flex">
						<?php if ($totalProducts > 1) : ?>
							<a id="other-product" class="flex items-baseline btn btn-link btn-small p-0 mr-1" href="<?= base_url('vistaconsolidada') ?>">
								<i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto
							</a>
						<?= ($data['vc']) ? '<span class="primary mr-1">|</span>' : ''; ?>
						<?php endif; ?>
						<?php if ($data['vc']) : ?>
							<button id="open-card-details" class="flex items-baseline btn btn-link btn-small p-0">
								<i aria-hidden="true" class="icon-view"></i>
								&nbsp;Ver detalles
							</button>
						<?php endif; ?>
						</div>
					</div>
					<div class="product-info-full mr-5">
						<p class="product-cardholder mb-1 semibold h4 primary"><?= $data['nom_plastico']; ?></p>
						<?php if ($data['bloqueo'] !== '') : ?>
							<p class="mb-1 semibold danger"><?= lang('GEN_TEXT_BLOCK_PRODUCT'); ?></p>
						<?php endif; ?>
						<p id="card" class="product-cardnumber mb-0 primary"><?= $data['noTarjetaConMascara']; ?></p>
						<p class="product-metadata mb-2 h6"><?= $data['nombre_producto']; ?></p>
						<ul class="product-balance-group flex justify-between mb-0 list-inline">
							<li class="list-inline-item">Actual
								<span id="actual" class="product-balance block primary">
									<?= lang('GEN_COIN') . ' '; ?>
									<?= $data['actualBalance'] !== '--' ?
										strval(number_format($data['actualBalance'], 2, ',', '.')) : '---'; ?>
								</span>
							</li>
							<li class="list-inline-item">En tránsito
								<span id="bloqueado" class="product-balance block primary">
									<?= lang('GEN_COIN') . ' '; ?>
									<?= $data['ledgerBalance'] !== '--' ?
										strval(number_format($data['ledgerBalance'], 2, ',', '.')) : '---'; ?>
								</span>
							</li>
							<li class="list-inline-item">Disponible
								<span id="disponible" class="product-balance block primary">
									<?= lang('GEN_COIN') . ' '; ?>
									<?= $data['availableBalance'] !== '--' ?
										strval(number_format($data['availableBalance'], 2, ',', '.')) : '---'; ?>
								</span>
							</li>
						</ul>
					</div>
					<div class="product-specifications none">
						<h3 class="h4 regular tertiary">Especificaciones</h3>
						<ul class="vinieta">
							<li>Aliquam tincidunt mauris eu risus.</li>
							<li>Vestibulum auctor dapibus neque.</li>
							<li>Nunc dignissim risus id metus.</li>
							<li>Cras ornare tristique elit.</li>
							<li>Ut aliquam sollicitudin leo.</li>
							<li>Cras iaculis ultricies nulla.</li>
						</ul>
					</div>
				</div>

				<h2 class="h4 regular tertiary">Mis movimientos</h2>
				<nav id="filtersStack" class="navbar detail-filters-nav p-1 px-lg-5 bg-widget">
					<div id="period-form" class="stack-form mr-auto flex items-center">
						<label class="my-1 mr-1 text" for="filterMonth">Mostrar:</label>
						<select id="filterMonth" class="custom-select form-control w-auto my-1 mr-1" name="filterMonth">
							<option value="0">Más recientes</option>
							<?php
							foreach ($months as $nroMonths => $txtMonths) {
								$monthValue = str_pad($nroMonths + 1, 2, '0', STR_PAD_LEFT);
							?>
								<option <?= @$monthSelected === $monthValue ? 'selected' : ''; ?> value="<?= $monthValue; ?>"><?= $txtMonths; ?></option>
							<?php
							}
							?>
						</select>
						<select id="filterYear" class="custom-select form-control w-auto my-1 mr-1" name="filterYear" <?= isset($yearSelected) ? '' : 'disabled'; ?>>
							<option value="<?= $years[0]; ?>">-</option>
							<?php
							foreach ($years as $year) {
							?>
								<option <?= @$yearSelected == $year ? 'selected' : ''; ?> value="<?= $year; ?>"><?= $year; ?></option>
							<?php
							}
							?>
						</select>
						<button id="buscar" class="btn btn-small btn-primary"><span class="icon-arrow-right mr-0" aria-hidden="true"></span></button>
					</div>
					<div class="field-options btn-group btn-group-toggle" data-toggle="buttons">
						<label id="movementsToogle" class="btn-small btn-options btn-outline btn-rounded-left active">
							<input id="optionMovements" type="radio" name="movimientos" checked> Movimientos
						</label>
						<label id="transitToogle" class="btn-small btn-options btn-outline btn-rounded-right nowrap is-disabled">
							<input id="optionTransit" type="radio" name="movimientos" disabled> En tránsito
						</label>
					</div>
					<ul class="stack list-inline mb-0 flex items-center">
						<li class="stack-item px-1 list-inline-item rounded">
							<a id="downloadPDF" href="#" rel="subsection"><span class="icon-file-pdf h5 mr-0" aria-hidden="true" title="Descargar PDF"></span></a>
						</li>
						<li class="stack-item px-1 list-inline-item rounded">
							<a id="downloadXLS" href="#" rel="subsection"><span class="icon-file-excel h5 mr-0" aria-hidden="true" title="Descargar Excel"></span></a>
						</li>
						<li class="stack-item px-1 list-inline-item rounded is-disabled">
							<a id="downloadExtract" href="#" rel="subsection"><span class="icon-download h5 mr-0" aria-hidden="true" title="Descargar Extracto"></span></a>
						</li>
					</ul>
				</nav>

				<div id="results" class="group row mt-3">
					<div id="transactions" class="group-main-view col-lg-8">
						<h3 class="h4 regular">Actividad <span id="period">reciente</span>
							<span id="transitTitle" class="none">transacciones pendientes</span>
						</h3>
						<div class="line mt-1"></div>
						<ul id="movementsList" class="feed list-style-none fade-in mt-3 pl-0">
							<?php
							$totalIncomeMovements = $data['totalInMovements']["totalIncome"];
							$totalExpenseMovements = $data['totalInMovements']["totalExpense"];

							if ($data['movements'] !== '--') {
								foreach ($data['movements'] as $row) {
									$separedDate = explode('/', $row->fecha);
									$spanishMonth = substr($months[intval($separedDate[1]) - 1], 0, 3);
							?>
									<li class="feed-item <?= $row->signo == '+' ? 'feed-income' : 'feed-expense'; ?> flex py-1 items-center">
										<div class="flex px-2 flex-column items-center feed-date">
											<span class="h5 feed-date-day"><?= $separedDate[0]; ?></span>
											<span class="h6 feed-date-month"><?= $spanishMonth; ?></span>
											<span class="h6 feed-date-year"><?= $separedDate[2]; ?></span>
										</div>
										<div class="flex px-2 flex-column mr-auto">
											<span class="h5 semibold feed-product"><?= $row->concepto; ?></span>
											<span class="h6 feed-metadata"><?= $row->referencia; ?></span>
										</div>
										<span class="px-2 feed-amount items-center">
											<?= ($row->signo == '+' ? '' : $row->signo) . ' ' . lang('GEN_COIN') . ' ' . $row->monto; ?>
										</span>
									</li>
								<?php
								}
							} else {
								?>
								<div class="my-5 py-4 center">
									<span class="h4">No se encontraron movimientos</span>
								</div>
							<?php
							}
							?>
						</ul>
						<?php
						if (array_key_exists('pendingTransactions', $data)) {
							$totalIncomePendingTransactions = $data['totalInPendingTransactions']["totalIncome"];
							$totalExpensePendingTransactions = $data['totalInPendingTransactions']["totalExpense"];
						?>
							<ul id="transitList" class="feed list-style-none mt-3 pl-0">
								<?php
								foreach ($data['pendingTransactions'] as $row) {
									$separedDate = explode('/', $row->fecha);
									$spanishMonth = substr($months[intval($separedDate[1]) - 1], 0, 3);
								?>
									<li class="feed-item <?= $row->signo == '+' ? 'feed-income' : 'feed-expense'; ?> flex py-1 items-center">
										<div class="flex px-2 flex-column items-center feed-date">
											<span class="h5 feed-date-day"><?= $separedDate[0]; ?></span>
											<span class="h6 feed-date-month"><?= $spanishMonth; ?></span>
											<span class="h6 feed-date-year"><?= $separedDate[2]; ?></span>
										</div>
										<div class="flex px-2 flex-column mr-auto">
											<span class="h5 semibold feed-product"><?= $row->concepto; ?></span>
											<span class="h6 feed-metadata"><?= $row->referencia; ?></span>
										</div>
										<span class="px-2 feed-amount items-center"><?= lang('GEN_COIN') . ' ' . ($row->signo == '+' ? '' : $row->signo) . $row->monto; ?></span>
									</li>
								<?php } ?>
							</ul>
						<?php
						}
						?>

					</div>

					<div id="stats" class="group-aside-view col-lg-4">
						<h3 class="h4 regular">Estadísticas</h3>
						<div class="line mt-1"></div>
						<div id="movementsStats" class="detail-stats"></div>
						<div id="transitStats" class="detail-stats"></div>
					</div>
				</div>

			</div>
		</section>
	</div>
</div>
<?php
$dataForm = json_encode([
	"noTarjeta" => $data['noTarjeta'],
	"id_ext_per" => $data['id_ext_per'],
	"totalIncomeMovements" => $totalIncomeMovements,
	"totalExpenseMovements" => $totalExpenseMovements,
	"totalIncomePendingTransactions" => isset($totalIncomePendingTransactions) ? $totalIncomePendingTransactions : 0,
	"totalExpensePendingTransactions" => isset($totalExpensePendingTransactions) ? $totalExpensePendingTransactions : 0,
	"currency" => lang('GEN_COIN')
])
?>
<script>
	var data = <?= $dataForm;?>
</script>

