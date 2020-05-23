<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if($this->session->has_userdata('logged') || isset($activeMenuUser)): ?>
<nav class="navbar-secondary line-main-nav flex bg-secondary items-center">
	<ul class="main-nav-user flex my-0 list-style-none">
		<?php foreach ($mainMenu AS $firstLevel => $menuLevel1): ?>
		<?php if(lang('CONF_'.$firstLevel) == 'ON'): ?>
		<?php $menuText1 = lang('GEN_MENU_'.$firstLevel); ?>
		<?php $menuLink1 = lang('GEN_LINK_'.$firstLevel); ?>
		<?php $menuLink1 = $menuLink1 != lang('GEN_NO_LINK') ? base_url($menuLink1) : lang('GEN_NO_LINK'); ?>
		<li class="nav-item mr-1 inline <?= $menuLink1 != lang('GEN_NO_LINK') ? 'big-modal' : '' ?> <?= setCurrentPage($currentClass, $menuText1); ?>">
			<a class="nav-link px-2 semibold primary" href="<?= $menuLink1 ?>"><?= $menuText1; ?></a>
			<ul class="dropdown-user pl-0 regular tertiary bg-secondary list-style-none list-inline">
				<?php foreach ($menuLevel1 AS $secondLevel => $menuLevel2): ?>
				<?php if(lang('CONF_'.$secondLevel) == 'ON'): ?>
				<?php $menuText2 = lang('GEN_MENU_'.$secondLevel); ?>
				<?php $menuLink2 = lang('GEN_LINK_'.$secondLevel); ?>
				<?php $menuLink2 = $menuLink2 != lang('GEN_NO_LINK') ? base_url($menuLink2) : lang('GEN_NO_LINK'); ?>
				<li <?= $menuLink2 != lang('GEN_NO_LINK') ? 'class="big-modal"' : '' ?>>
					<a href="<?= $menuLink2; ?>"><?= $menuText2; ?></a>
					<ul class="pl-0 regular tertiary bg-secondary list-style-none list-inline">
						<?php foreach ($menuLevel2 AS $thirdLevel => $menuLevel3): ?>
						<?php if(lang('CONF_'.$thirdLevel) == 'ON'): ?>
						<?php $menuText3 = lang('GEN_MENU_'.$thirdLevel); ?>
						<?php $menuLink3 = lang('GEN_LINK_'.$thirdLevel); ?>
						<?php $menuLink3 = $menuLink3 != lang('GEN_NO_LINK') ? base_url($menuLink3) : lang('GEN_NO_LINK'); ?>
						<li <?= $menuLink2 != lang('GEN_NO_LINK') ? 'class="big-modal"' : '' ?>>
							<a href="<?= $menuLink3; ?>"><?= $menuText3; ?></a>
						</li>
						<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</nav>
<?php endif; ?>
