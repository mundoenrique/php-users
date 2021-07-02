<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<div class="logout-content max-width-4 mx-auto p-responsive py-4 hide-out hide">
	<h1 class="primary h0"><?= lang('GEN_MENU_PAYS_TRANSFER');?></h1>
	<section>
		<hr class="separador-one">
		<div class="pt-3">
		<h4><?= lang('USER_AUTH_REQUIRED');?></h4>
			<p><?= lang('USER_OPER_PASS_MSG');?></p>
			<form id="change-pass-form" class="mt-4" method="post">
				<div class="row">
					<div class="col-8">
						<div class="form-group col-12 col-lg-6">
							<label for="currentOperKey"><?= lang('USER_KEY_OPER');?></label>
							<div class="input-group">
								<input id="currentOperKey" class="form-control pwd-input" type="password" name="currentOperKey">
								<div class="input-group-append">
									<span class="input-group-text pwd-action" title="<?= lang('GEN_SHOW_PASS') ?>"><i class="icon-view mr-0"></i></span>
								</div>
							</div>
							<div class="help-block"></div>
						</div>
					</div>

					<div class="col-12">
						<div class="field-meter" id="password-strength-meter">
							<p class="text-warning"><strong class="forget-password">¿Olvidaste tu clave de operaciones especiales?.</strong> Escríbenos a <strong><a href= "mailto:soporteempresas@tebca.com">soporteempresas@tebca.com</a></strong> y con gusto te ayudaremos.<br>Envía tu nombre, cédula, empresa en la que trabajas y los 4 últimos dígitos de tu tarjeta.</b></p>
							<ul class="pwd-rules">
								<li class="pwd-rules-item"><?= lang('USER_OPER_KEY_1'); ?></li>
								<li class="pwd-rules-item"><?= lang('USER_OPER_KEY_2'); ?></li>
								<li class="pwd-rules-item"><?= lang('USER_OPER_KEY_3'); ?></li>
								<li class="pwd-rules-item"><?= lang('USER_OPER_KEY_4'); ?></li>
							</ul>
						</div>
					</div>
				</div>

				<hr class="separador-one mt-2 mb-4">
				<div class="flex items-center justify-end">
					<a class="btn btn-link btn-small big-modal" href="<?= $cancelBtn ?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
					<button id="change-pass-btn" class="btn btn-small btn-loading btn-primary" type="submit">
						<?= lang('GEN_BTN_ACCEPT'); ?>
					</button>
				</div>
			</form>
		</div>
	</section>
</div>
