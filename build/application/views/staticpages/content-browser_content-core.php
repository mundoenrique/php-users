<div class="notrender-content flex items-center justify-center">
	<div class="flex items-center">
		<h1><?= $title ?></h1>
		<h2><?= $msg1 ?></h2>
		<h2><?= $msg2 ?></h2>
		<?php if($platform === 'browser'): ?>
		<ul class="list-inline w-list flex justify-between">
			<li class="list-inline-item">
				<img
					class="browser-img"
					src="<?= $this->asset->insertFile('icon-chrome.svg', 'images', $customerFiles, 'browsers'); ?>"
					alt="chrome"
				>
				<span class="browser-name"><?= lang('GEN_BROWSER_GOOGLE_CHROME'); ?></span>
				<span class="browser-version"><?= lang('GEN_BROWSER_GOOGLE_CHROME_VERSION'); ?></span>
			</li>
			<li class="list-inline-item">
				<img
					class="browser-img"
					src="<?= $this->asset->insertFile('icon-firefox.svg', 'images', $customerFiles, 'browsers'); ?>"
					alt="firefox"
				>
				<span class="browser-name"><?= lang('GEN_BROWSER_MOZILLA_FIREFOX'); ?></span>
				<span class="browser-version"><?= lang('GEN_BROWSER_MOZILLA_FIREFOX_VERSION'); ?></span>
			</li>
			<li class="list-inline-item">
				<img
					class="browser-img"
					src="<?= $this->asset->insertFile('icon-safari.svg', 'images', $customerFiles, 'browsers'); ?>"
					alt="safari"
				>
				<span class="browser-name"><?= lang('GEN_BROWSER_APPLE_SAFARI'); ?></span>
				<span class="browser-version"><?= lang('GEN_BROWSER_APPLE_SAFARI_VERSION'); ?></span>
			</li>
			<li class="list-inline-item">
				<img
					class="browser-img"
					src="<?= $this->asset->insertFile('icon-edge.svg', 'images', $customerFiles, 'browsers'); ?>"
					alt="edge"
				>
				<span class="browser-name"><?= lang('GEN_BROWSER_MICROSOFT_EDGE'); ?></span>
				<span class="browser-version"><?= lang('GEN_BROWSER_MICROSOFT_EDGE_VERSION'); ?></span>
			</li>
			<?php if(lang('SETT_SUPPORT_IE') === 'ON'): ?>
			<li class="list-inline-item">
				<img
					class="browser-img"
					src="<?= $this->asset->insertFile('icon-explorer.svg', 'images', $customerFiles, 'browsers'); ?>"
					alt="explorer"
				>
				<span class="browser-name"><?= lang('GEN_BROWSER_INTERNET_EXPLORER'); ?></span>
				<span class="browser-version"><?= lang('GEN_BROWSER_INTERNET_EXPLORER_VERSION'); ?></span>
			</li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
	</div>
</div>
