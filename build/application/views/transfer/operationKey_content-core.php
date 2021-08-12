<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<div class="logout-content max-width-4 mx-auto p-responsive py-4 hide-out hide">
	<h1 class="primary h0"><?= lang('GEN_MENU_PAYS_TRANSFER');?></h1>
	<section>
		<hr class="separador-one">
		<div class="pt-3">
		<h4><?= lang('USER_CREATION_OPER_KEY');?></h4>
			<p><?= lang('USER_OPER_PASS_MSG');?></p>
			<form id="change-pass-form" class="mt-4" method="post">
				<div class="row">
					<div class="col-6 col-lg-8 col-xl-6">
						<div class="row">
							<div class="form-group col-12 col-lg-6">
								<label for="currentKey"><?= lang('USER_KEY_CURRENT');?></label>
								<div class="input-group">
									<input id="currentKey" class="form-control pwd-input" type="password" name="currentKey">
									<div class="input-group-append">
										<span class="input-group-text pwd-action" title="<?= lang('GEN_SHOW_PASS') ?>"><i class="icon-view mr-0"></i></span>
									</div>
								</div>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="row">
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
						<div class="row">
							<div class="form-group col-12 col-lg-6">
								<label for="confirmKey"><?= lang('USER_CONFIRM_KEY_OPER'); ?></label>
								<div class="input-group">
									<input id="confirmKey" class="form-control pwd-input" type="password" name="confirmKey">
									<div class="input-group-append">
										<span class="input-group-text pwd-action" title="<?= lang('GEN_SHOW_PASS') ?>"><i class="icon-view mr-0"></i></span>
									</div>
								</div>
								<div class="help-block"></div>
							</div>
						</div>
					</div>

					<div class="col-6 col-lg-4 col-xl-6">
						<div class="field-meter" id="password-strength-meter">
							<h4><?= lang('USER_INFO_TITLE'); ?></h4>
							<ul class="pwd-rules">
								<li id="length" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_1'); ?></li>
								<li id="letter" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_2'); ?></li>
								<li id="capital" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_3'); ?></li>
								<li id="number" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_4'); ?></li>
								<li id="special" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_5'); ?></li>
								<li id="consecutive" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_6'); ?></li>
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
