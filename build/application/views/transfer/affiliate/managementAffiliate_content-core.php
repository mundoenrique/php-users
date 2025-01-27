<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="manageAffiliateView" style="display:none">
	<div class="flex mb-1 mx-4 flex-column">
		<h4 id="affiliateTitle" class="line-text mb-2 semibold primary"></h4>
		<div class="w-100">
			<div class="mx-auto">
				<span id="affiliateMessage"></span>
				<div class="line-text my-2"></div>
				<form id="manageAffiliate">
					<div class="row">
						<?php if ($view != 'cardToCard') : ?>
							<div class="form-group col-6 col-lg-4">
								<label for="bank"><?= lang('TRANSF_BANK') ?></label>
								<select id="bank" class="custom-select form-control" name="bank">
									<option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
								</select>
								<div class="help-block"></div>
							</div>
						<?php endif; ?>
						<div class="form-group col-6 col-lg-4">
							<label for="beneficiary"><?= lang('TRANSF_BENEFICIARY') ?></label>
							<input id="beneficiary" class="form-control" type="text" name="beneficiary" autocomplete="off">
							<div class="help-block"></div>
						</div>
						<div class="form-group col-6 col-lg-4">
							<label for="idNumber"><?= lang('GEN_DNI') ?></label>
							<div class="form-row">
								<div class="form-group col-5 mb-0">
									<select id="typeDocument" class="custom-select form-control" name="typeDocument">
										<option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
										<?php foreach ($view == 'cardToBank' ? lang('SETT_TRANSFER_DOCUMENT_TYPE_EXTENDED') : lang('SETT_TRANSFER_DOCUMENT_TYPE') as $key => $value) : ?>
											<option value="<?= $key ?>"><?= $value ?></option>
										<?php endforeach; ?>
									</select>
									<div class="help-block"></div>
								</div>
								<div class="form-group col-7 mb-0">
									<input id="idNumber" class="form-control" type="text" name="idNumber" value="" autocomplete="off">
									<div class="help-block"></div>
								</div>
							</div>
						</div>
						<?php if ($view != 'mobilePayment') : ?>
							<div class="form-group col-6 col-lg-4">
								<?php if ($view == 'cardToCard') : ?>
									<label for="destinationCard"><?= LANG('TRANSF_DESTINATION_CARD') ?></label>
									<input id="destinationCard" class="form-control" type="text" name="destinationCard" autocomplete="off">
									<div class="help-block"></div>
								<?php else : ?>
									<label for="destinationAccount"><?= LANG('TRANSF_DEST_ACCOUNT_NUMBER') ?></label>
									<input id="destinationAccount" class="form-control" type="text" name="destinationAccount" autocomplete="off">
									<div class="help-block"></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if ($view != 'cardToCard') : ?>
							<div class="form-group col-6 col-lg-4">
								<label for="mobilePhone"><?= lang('GEN_PHONE_MOBILE') ?></label>
								<input id="mobilePhone" class="form-control" type="text" name="mobilePhone" autocomplete="off">
								<div class="help-block"></div>
							</div>
						<?php endif; ?>
						<div class="form-group col-6 col-lg-4">
							<label for="beneficiaryEmail">
								<?= lang('GEN_EMAIL') ?>
								<span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
							</label>
							<input id="beneficiaryEmail" class="form-control" type="text" name="beneficiaryEmail" autocomplete="off">
							<div class="help-block"></div>
						</div>
					</div>
					<div class="line my-2"></div>
					<div class="flex items-center justify-end pt-3">
						<button id="affiliateCancelBtn" class="btn btn-small btn-link"><?= lang('GEN_BTN_CANCEL') ?></button>
						<button id="manageAffiliateBtn" class="btn btn-small btn-loading btn-primary send"></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
