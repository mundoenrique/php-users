<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<nav class="main-nav main-nav-dropdown">
	<ul class="flex my-0 items-center list-style-none list-inline">
		<li>
			<a class="mt-1 mx-1 regular text-decoration-none white flex" href="<?= lang('SETT_NO_LINK') ?>">
				<span class="tool-ellipsis mr-2"><?= $fullName ?></span>
        <i class="ml-5 icon icon-chevron-down" aria-hidden="true"></i>
      </a>
			<ul class="dropdown regular tertiary bg-secondary">
				<?php if(lang('SETT_PROFILE') == 'ON'): ?>
				<li>
					<a class="pl-2 pr-1 h6 big-modal" href="<?= base_url(lang('SETT_LINK_USER_PROFILE')) ?>"><?= lang('GEN_MENU_PROFILE'); ?></a>
				</li>
				<?php endif; ?>
				<li>
					<a class="pl-2 pr-1 h6 big-modal" href="<?= base_url(lang('SETT_LINK_CHANGE_PASS')); ?>"><?= lang('GEN_MENU_CHANGE_PASS') ?></a>
				</li>
				<?php if($this->session->canTransfer == 'S') : ?>
				<li>
					<a class="pl-2 pr-1 h6 big-modal" href="<?= base_url($this->session->operKey ? lang('SETT_LINK_CHANGE_OPERKEY') : lang('SETT_LINK_SET_OPER_KEY')) ?>"><?= lang('GEN_MENU_CHANGE_OPERKEY') ?></a>
				</li>
				<?php endif; ?>
				<?php if(lang('SETT_NOTIFICATIONS') == 'ON'): ?>
				<li>
					<a class="pl-2 pr-1 h6 big-modal" href="<?= base_url(lang('SETT_LINK_NOTIFICATIONS')) ?>"><?= lang('GEN_MENU_NOTIFICATIONS'); ?></a>
				</li>
				<?php endif; ?>
				<?php if(lang('SETT_MFA_ACTIVE') === 'ON' && $this->session->otpActive): ?>
				<li>
					<a id="disableTwoFactor" class="pl-2 pr-1 h6 truncate trun-mfa" href="<?= lang('SETT_NO_LINK'); ?>"><?= lang('GEN_MENU_TWO_FACTOR_DISABLE'); ?></a>
				</li>
				<?php endif; ?>
				<li>
					<a id="logout-session" class="pl-2 pr-1 h6" href="<?= lang('SETT_NO_LINK'); ?>"><?= lang('GEN_MENU_SIGNOUT'); ?></a>
				</li>
			</ul>
			<span></span>
		</li>
	</ul>
</nav>
