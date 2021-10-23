<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<div class="logout-content max-width-4 mx-auto p-responsive py-4 hide-out hide">
	<h1 class="primary h0"><?= lang('GEN_MENU_PAYS_TRANSFER');?></h1>
	<section>
		<hr class="separador-one">
		<div class="pt-3">
		<h4><?= lang('TRANSF_SET_OPER_KEY');?></h4>
			<p><?= lang('TRANSF_CREATE_OPER_KEY');?></p>
			<form id="change-pass-form" class="mt-4" method="post">
				<div class="row">
					<div class="col-6 col-lg-8 col-xl-6">
						<div class="row">
							<div class="form-group col-12 col-lg-6">
								<label for="currentKey"><?= lang('TRANSF_KEY_CURRENT');?></label>
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
								<label for="currentOperKey"><?= lang('TRANSF_KEY_OPER');?></label>
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
								<label for="confirmKey"><?= lang('TRANSF_CONFIRM_KEY_OPER'); ?></label>
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
						<?php $this->load->view('user/passwordInfo_content-core') ?>
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
