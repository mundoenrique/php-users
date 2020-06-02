<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_CUSTOMER_SUPPORT'); ?></h1>
<section>
	<div class="pt-3">

		<div class="row">

			<div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
				<div class="flex flex-wrap widget-product">
					<div class="line-text w-100">
						<div class="flex inline-flex col-12 px-xl-2">
							<div class="flex flex-colunm justify-center col-6 py-5">
								<div class="product-presentation relative">
									<div class="item-network maestro"></div>
									<!-- <img class="card-image" src="../../../assets/images/default/bnt_default.svg" alt="Tarjeta Banorte"> -->
									<div class="product-search">
										<a class="dialog button product-button"><span aria-hidden="true" class="icon-find"></span></a>
										<input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="">
										</div>
									</div>
								</div>
								<div class="flex flex-column items-start col-6 self-center pr-0 pl-1">
									<!-- <p class="semibold mb-0 h5">PLATA VIÁTICOS</p>
									<p id="card" class="mb-2">604842******4714</p>
									<a id="other-product" class="btn hyper-link btn-small p-0" href="">
									<i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto</a> -->

									<span>Seleccione una cuenta</span>
								</div>
							</div>
						</div>
					</div>
					<div class="flex optional mt-4">
						<nav class="nav-config">
							<ul class="nav-config-box flex">
								<li id="PIN" class="nav-item-config pr-1">
									<a href="javascript:">
										<i class='icon-key block icon-config h1'></i>
										<h5 class="center">Gestión<br>de PIN</h5>
									</a>
								</li>
								<li id="cardLock" class="nav-item-config pr-1">
									<a href="javascript:">
										<i class='icon-lock block icon-config h1'></i>
										<h5 class="center">Bloqueo<br>de tarjeta</h5>
									</a>
								</li>
								<li id="replacementRequest" class="nav-item-config">
									<a href="javascript:">
										<i class='icon-spinner block icon-config h1'></i>
										<h5 class="center">Solicitud<br>de reposición</h5>
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-lg-6 col-xl-8">
				</div>
			</div>
		</div>
	</div>
</section>
