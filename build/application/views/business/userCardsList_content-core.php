<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="dashboard" class="dashboard-content h-100 bg-content">
	<div class="">
		<header class="">
			<h1 class="h3 semibold primary">Buenos días usuario</h1>
		</header>
		<section>
			<div class="pt-3">
				<div class="flex mt-3 light items-center">
					<div class="flex col-3">
						<h2 class="h4 regular tertiary mb-0">Mis productos</h2>
					</div>
					<div class="flex h6 flex-auto justify-end">
						<div class="flex h6 flex-auto justify-end">
							<span><?= lang('ENTERPRISE_LAST_ACCESS') ?>: Último acceso: 20/05/2020 9:17 PM</span>
						</div>
					</div>
				</div>
				<div class="line mt-1"></div>
				<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
					<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
				</div>
				<div id="dashboard" class="dashboard-items flex max-width-xl-6 mt-3 mx-auto flex-wrap justify-center hide-out hide">
					<div class="dashboard-item big-modal p-1 mx-1 mb-1">
						<img class="item-img" src="../../../assets/images/bnt/bnt_default.svg" alt="Tarjeta Banorte" />
						<div class="item-info maestro p-2 h5 bg-white">
							<p class="item-category semibold">PLATA VIÁTICOS</p>
							<p class="item-cardnumber mb-0">604842******1511</p>
							<p class="item-balance mb-0 h6 light text">$ ---</p>
						</div>
					</div>
					<div class="dashboard-item big-modal p-1 mx-1 mb-1">
						<img class="item-img" src="../../../assets/images/bnt/bnt_default.svg" alt="Tarjeta Banorte" />
						<div class="item-info visa p-2 h5 bg-white">
							<p class="item-category semibold">PLATA VIÁTICOS</p>
							<p class="item-cardnumber mb-0">604842******4714</p>
							<p class="item-balance mb-0 h6 light text">$ ---</p>
						</div>
					</div>
					<div class="dashboard-item big-modal p-1 mx-1 mb-1">
						<img class="item-img" src="../../../assets/images/bnt/bnt_default.svg" alt="Tarjeta Banorte" />
						<div class="item-info maestro p-2 h5 bg-white">
							<p class="item-category semibold">PLATA PROCURA</p>
							<p class="item-cardnumber mb-0">604842******9317</p>
							<p class="item-balance mb-0 h6 light text">$ ---</p>
						</div>
					</div>
					<div class="dashboard-item big-modal p-1 mx-1 mb-1">
						<img class="item-img" src="../../../assets/images/bnt/bnt_default.svg" alt="Tarjeta Banorte" />
						<div class="item-info maestro p-2 h5 bg-white">
							<p class="item-category semibold">PLATA NÓMINA</p>
							<p class="item-cardnumber mb-0">604842******9217</p>
							<p class="item-balance mb-0 h6 light text">$ ---</p>
						</div>
					</div>
					<div class="dashboard-item big-modal p-1 mx-1 mb-1">
						<img class="item-img" src="../../../assets/images/bnt/bnt_default.svg" alt="Tarjeta Banorte" />
						<div class="item-info maestro p-2 h5 bg-white">
							<p class="item-category semibold">PLATA PROMOCIONES</p>
							<p class="item-cardnumber mb-0">604842******0216</p>
							<p class="item-balance mb-0 h6 light text">$ ---</p>
						</div>
					</div>
					<div class="dashboard-item big-modal p-1 mx-1 mb-1">
						<img class="item-img" src="../../../assets/images/bnt/bnt_default.svg" alt="Tarjeta Banorte" />
						<div class="item-info visa-electron p-2 h5 bg-white">
							<p class="item-category semibold">BONUS ALIMENTACIÓN</p>
							<p class="item-cardnumber mb-0">604841******2716</p>
							<span class="semibold danger">Tarjeta bloqueada</span>
						</div>
					</div>
					<div class="dashboard-item big-modal p-1 mx-1 mb-1">
						<img class="item-img" src="../../../assets/images/bnt/bnt_default.svg" alt="Tarjeta Banorte" />
						<div class="item-info mastercard p-2 h5 bg-white">
							<p class="item-category semibold">PLATA RECARGA MASIVA</p>
							<p class="item-cardnumber mb-0">526749******5015</p>
							<p class="item-balance mb-0 h6 light text">$ ---</p>
						</div>
					</div>
					<div class="dashboard-item big-modal p-1 mx-1 mb-1">
						<img class="item-img" src="../../../assets/images/bnt/bnt_default.svg" alt="Tarjeta Banorte" />
						<div class="item-info mastercard p-2 h5 bg-white">
							<p class="item-category semibold">PLATA SALUD</p>
							<p class="item-cardnumber mb-0">526749******0124</p>
							<p class="item-balance mb-0 h6 light text">$ ---</p>
						</div>
					</div>
				</div>
				<div class="flex flex-column items-center justify-center pt-5">
					<h3 class="h4 regular mb-0">No posee productos registrados.</h3>
				</div>
			</div>
		</section>
	</div>
</div>
