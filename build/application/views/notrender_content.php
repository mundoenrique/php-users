<div class="notrender-content flex items-center justify-center">
	<div class="flex items-center">
	<!-- <span class="icon-update" aria-hidden="true"></span> -->

		<h1><?= $reasonTitle;?></h1>
		<h2><?= $reasonMessage;?></h2>
	<?php if ($reason === 'b'): ?>
		<ul class="list-inline flex justify-between">
			<li class="list-inline-item">
				<img class="browser-img" src="<?= $this->asset->insertFile('icon-chrome.svg','img',$countryUri); ?>" alt="Icono chrome">
				<span class="browser-name">Google Chrome</span>
				<span class="browser-version">Version 48+</span>
			</li>
			<li class="list-inline-item">
				<img class="browser-img" src="<?= $this->asset->insertFile('icon-firefox.svg','img',$countryUri); ?>" alt="Icono firefox">
				<span class="browser-name">Mozilla Firefox</span>
				<span class="browser-version">Version 30+</span>
			</li>
			<li class="list-inline-item">
				<img class="browser-img" src="<?= $this->asset->insertFile('icon-safari.svg','img',$countryUri); ?>" alt="Icono safari">
				<span class="browser-name">Apple Safari</span>
				<span class="browser-version">Version 10+</span>
			</li>
		</ul>
	<? endif; ?>
	</div>
</div>
