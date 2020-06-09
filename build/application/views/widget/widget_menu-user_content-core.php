<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<nav class="main-nav main-nav-dropdown">
	<ul class="flex my-0 items-center list-style-none list-inline">
		<li>
			<a class="mt-1 mx-1 regular text-decoration-none white" href="<?= lang('GEN_NO_LINK') ?>">
				<?= $fullName ?>
				<i class="ml-5 icon icon-chevron-down" aria-hidden="true"></i>
			</a>
			<ul class="dropdown regular tertiary bg-secondary">
				<?php if(lang('CONF_NOTIFICATIONS') == 'ON'): ?>
				<li>
					<a class="pl-2 pr-1 h6 big-modal" href="<?= base_url('notificaciones') ?>"><?= lang('GEN_MENU_NOTIFICATIONS'); ?></a>
				</li>
				<?php endif; ?>
				<?php if(lang('CONF_PROFILE') == 'ON'): ?>
				<li>
					<a class="pl-2 pr-1 h6 big-modal" href="<?= base_url('perfil') ?>"><?= lang('GEN_MENU_PORFILE'); ?></a>
				</li>
				<?php endif; ?>
				<li>
					<a class="pl-2 pr-1 h6 big-modal" href="<?= base_url('cerrar-sesion/inicio') ?>"><?= lang('GEN_MENU_SIGNOUT'); ?></a>
				</li>
			</ul>
			<span></span>
		</li>
	</ul>
</nav>
