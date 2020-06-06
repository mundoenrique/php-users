<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_CARD_DETAIL'); ?></h1>
<div class="flex justify-between row">
	<div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
		<div class="flex flex-wrap widget-product">
			<div class="line-text w-100">
				<div class="flex inline-flex col-12 px-xl-2">
					<div class="flex flex-colunm justify-center col-6 py-5">
						<div class="product-presentation relative">
							<div class="item-network <?= $brand ?>"></div>
							<img class="card-image" src="<?= $this->asset->insertFile($productImg, $productUrl); ?>" alt="<?= $productName; ?>">
						</div>
					</div>
					<div class="flex flex-column items-start col-6 py-5">
						<p class="semibold mb-0 h5 truncate" title="<?= $productName; ?>"><?= $productName; ?></p>
						<p id="card" class="mb-2"><?= $cardNumberMask; ?></p>
						<?php if ($cardsTotal > 1): ?>
						<a class="btn hyper-link btn-small p-0 big-modal" href="<?= lang('GEN_LINK_CARDS_LIST'); ?>">
							<i aria-hidden="true" class="icon-find"></i>
							&nbsp;<?= lang('BUSINESS_OTHER_PRODUCT'); ?>
						</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="flex col-12 mt-2">
				<ul class="flex flex-auto justify-between px-2">
					<li class="list-inline-item">Actual
						<span id="actual" class="product-balance block"><?= $balance->currentBalance; ?></span>
					</li>
					<li class="list-inline-item">En tránsito
						<span id="bloqueado" class="product-balance block"><?= $balance->inTransitBalance; ?></span>
					</li>
					<li class="list-inline-item">Disponible
						<span id="disponible" class="product-balance block"><?= $balance->availableBalance; ?></span>
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
				<form id="movements">
					<input type="hidden" id="userIdNumber" name="userIdNumber" value="<?= $userIdNumber ?>">
					<input type="hidden" id="cardNumber" name="cardNumber" value="<?= $cardNumber ?>">
					<select id="filterMonth" class="custom-select form-control w-auto my-1" name="filterMonth">
						<option value="0"><?= lang('BUSINESS_MOST_RECENT'); ?></option>
						<?php foreach (lang('GEN_SELECT_MONTH') AS $key => $month): ?>
						<option value="<?= $key ?>"><?= $month ?></option>
						<?php endforeach; ?>
					</select>
					<select id="filterYear" class="custom-select form-control w-auto my-1" name="filterYear" disabled>
						<option value="default">--</option>
						<?php for ($i = $currentYear; $i > $currentYear - 5; $i--): ?>
						<option value="<?= $i ?>"><?= $i ?></option>
						<?php endfor; ?>
					</select>
					<button id="buscar" class="btn btn-small btn-rounded-right btn-primary">
						<span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
					</button>
				</form>
			</div>
			<?php if (lang('CONF_IN_TRANSIT') == 'ON'): ?>
			<button class="btn btn-outline btn-small btn-rounded-left bg-white" data-jplist-control="reset" data-group="group-filter-pagination"
				data-name="reset">Movimientos</button>
			<button class="btn btn-outline btn-small btn-rounded-right nowrap is-disabled" data-jplist-control="reset" data-group="group-filter-pagination"
				data-name="reset">En tránsito</button>
			<?php endif; ?>
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
			<ul id="movementsList" class="feed fade-in mt-3 pl-0 hide">
				<?php foreach ($movesList AS $moves): ?>
				<?php $classCss = $moves->sign == '-' ? 'feed-expense' : 'feed-income' ?>
				<li class="feed-item <?= $classCss; ?> flex py-2 items-center">
					<div class="flex px-2 flex-column items-center feed-date">
						<span class="h5"><?= $moves->date; ?></span>
					</div>
					<div class="flex px-2 flex-column mr-auto">
						<span class="h5 semibold feed-product"><?= $moves->desc; ?></span>
						<span class="h6 feed-metadata"><?= $moves->ref; ?></span>
					</div>
					<span class="px-2 feed-amount items-center"><?= $moves->sign.' '.$moves->amount; ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
			<div id="no-moves" class="hide">
				<div class="flex flex-column items-center justify-center pt-5">
					<h3 class="h4 regular mb-0"><?= lang('GEN_TABLE_SEMPTYTABLE'); ?></h3>
				</div>
			</div>
		</div>
	</div>
</div>
