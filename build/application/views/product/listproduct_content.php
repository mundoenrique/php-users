<div id="dashboard" class="dashboard-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Vista consolidada</h1>
		</header>
		<section>
			<div class="pt-3">
				<h2 class="tertiary h3">Mis productos</h2>
				<div id="dashboard" class="dashboard-items flex max-width-xl-5 flex-wrap justify-start my-5">

					<?php
					//var_dump($data);
						foreach($data as $row){

					?>
						<div class="dashboard-item p-1 mx-1 mb-1">
							<a href="#" rel="section">
								<img class="item-img active" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
								<div class="item-info p-1 h5 tertiary bg-white">
									<img class="dashboard-item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
									<p class="item-category semibold primary"><?= $row['nombre_producto'];?></p>
									<p class="item-cardnumber mb-0"><?= $row['noTarjetaConMascara'];?></p>
									<p class="item-balance mb-0 h6 light text"><?= $row['productBalance'] == '--'? $row['productBalance']: lang('GEN_COIN').' '.$row['productBalance'];?></p>
								</div>
							</a>
						</div>
					<?php
						}
					?>

					<div class="dashboard-item p-1 mx-1 mb-1 ">
						<a href="#" rel="section">
							<img class="item-img" src="<?= $this->asset->insertFile('img-card_blue.svg','img',$countryUri); ?>" alt="Tarjeta azul">
							<div class="item-info p-1 h5 tertiary bg-white">
								<img class="dashboard-item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
								<p class="item-category semibold primary">Plata Incentivos Plus</p>
								<p class="item-cardnumber mb-0">526749******9412</p>
								<p class="item-balance mb-0 h6 light text">Bs.5,99</p>
							</div>
						</a>
					</div>
					<div class="dashboard-item p-1 mx-1 mb-1">
						<a href="#" rel="section">
							<img class="item-img" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta azul">
							<div class="item-info p-1 h5 tertiary bg-white">
								<img class="dashboard-item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
								<p class="item-category semibold primary">Plata Incentivos Plus</p>
								<p class="item-cardnumber mb-0">526749******9412</p>
								<p class="item-balance mb-0 h6 light text">Bs.240.818,21</p>
							</div>
						</a>
					</div>
					<div class="dashboard-item p-1 mx-1 mb-1">
						<a href="#" rel="section">
							<img class="item-img" src="<?= $this->asset->insertFile('img-card_blue.svg','img',$countryUri); ?>" alt="Tarjeta azul">
							<div class="item-info p-1 h5 tertiary bg-white">
								<img class="dashboard-item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
								<p class="item-category semibold primary">Plata Incentivos Plus</p>
								<p class="item-cardnumber mb-0">526749******9412</p>
								<p class="item-balance mb-0 h6 light text">Bs.5,99</p>
							</div>
						</a>
					</div>
					<div class="dashboard-item p-1 mx-1 mb-1">
						<a href="#" rel="section">
							<img class="item-img" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta azul">
							<div class="item-info p-1 h5 tertiary bg-white">
								<img class="dashboard-item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
								<p class="item-category semibold primary">Plata Incentivos Plus</p>
								<p class="item-cardnumber mb-0">526749******9412</p>
								<p class="item-balance mb-0 h6 light text">Bs.240.818,21</p>
							</div>
						</a>
					</div>
					<div class="dashboard-item p-1 mx-1 mb-1">
						<a href="#" rel="section">
							<img class="item-img" src="<?= $this->asset->insertFile('img-card_blue.svg','img',$countryUri); ?>" alt="Tarjeta azul">
							<div class="item-info p-1 h5 tertiary bg-white">
								<img class="dashboard-item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
								<p class="item-category semibold primary">Plata Incentivos Plus</p>
								<p class="item-cardnumber mb-0">526749******9412</p>
								<p class="item-balance mb-0 h6 light text">Bs.5,99</p>
							</div>
						</a>
					</div>
					<div class="dashboard-item p-1 mx-1 mb-1">
						<a href="#" rel="section">
							<img class="item-img" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta azul">
							<div class="item-info p-1 h5 tertiary bg-white">
								<img class="dashboard-item-network" src="<?= $this->asset->insertFile('logo_visa.svg','img',$countryUri); ?>" alt="Logo marca">
								<p class="item-category semibold primary">Plata Incentivos Plus</p>
								<p class="item-cardnumber mb-0">526749******9412</p>
								<p class="item-balance mb-0 h6 light text">Bs.240.818,21</p>
							</div>
						</a>
					</div>

				</div>
			</div>
		</section>
	</div>
</div>
