<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="toTransferView" class="transfer-operation" <?= $totalCards === 1 ? '' : 'style="display:none"' ?>>
	<div class="flex mb-1 mx-4 flex-column">
		<h4 class="line-text mb-2 semibold primary"><?= $titleTransfer ?></h4>
		<div class="w-100">
			<div class="mx-auto">
				<span><?= $msgTransfer ?></span>
				<div class="line-text my-2"></div>
				<div id="pre-loader" class="w-100 hide">
					<div class="mt-5 mb-4 pt-5 mx-auto flex justify-center">
						<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-6 col-lg-4">
						<label for="directoryValue"><?= lang('TRANSF_AFFILIATE_DIRECTORY'); ?></label>
						<div class="form-control select-by-search p-0">
							<input id="directoryValue" type="hidden" name="directoryValue" value="">
							<input id="directory" class="custom-select select-search-input pl-1" placeholder='<?= lang('GEN_BTN_SEARCH') ?>' type="text" name="directoryValue" autocomplete="off">
							<ul id="affiliationList" class="select-search pl-0">
							</ul>
							<div class="close-selector"></div>
						</div>
						<div class="help-block"></div>
					</div>
				</div>
				<div class="line-text mb-2"></div>
				<form id="transferForm">
					<input type="hidden" id="filterMonth" name="filterMonth" value="0">
					<input type="hidden" id="filterYear" name="filterYear" value="0">
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
								<div class="form-group col-6 mb-0">
									<select id="typeDocument" class="custom-select form-control" name="typeDocument">
										<option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
										<?php foreach (lang('SETT_TRANSFER_DOCUMENT_TYPE') as $key => $value) : ?>
											<option value="<?= $key ?>"><?= $value ?></option>
										<?php endforeach; ?>
									</select>
									<div class="help-block"></div>
								</div>
								<div class="form-group col-6 mb-0">
									<input id="idNumber" class="form-control" type="text" name="idNumber" value="" autocomplete="off">
									<div class="help-block"></div>
								</div>
							</div>
						</div>
						<?php if ($view == 'cardToCard') : ?>
							<div class="form-group col-6 col-lg-4">
								<label for="destinationCard"><?= LANG('TRANSF_DESTINATION_CARD') ?></label>
								<input id="destinationCard" class="form-control" type="text" name="destinationCard" autocomplete="off">
								<div class="help-block"></div>
							</div>
						<?php endif; ?>
						<?php if ($view == 'cardToBank') : ?>
							<div class="form-group col-6 col-lg-4">
								<label class="block"><?= lang('TRANSF_INSTRUMENT_TYPE') ?></label>
								<div class="flex">
									<div class="custom-control custom-radio custom-control-inline">
										<input id="account" class="custom-control-input" type="radio" name="instrumentType" value="account">
										<label class="custom-control-label" for="account"><?= lang('TRANSF_ACCOUNT') ?></label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input id="phone" class="custom-control-input" type="radio" name="instrumentType" value="phone">
										<label class="custom-control-label" for="phone"><?= lang('TRANSF_PHONE') ?></label>
									</div>
								</div>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4">
								<div id="destinationAccountField" class="form-group" style="display:none">
									<label for="destinationAccount"><?= lang('TRANSF_DEST_ACCOUNT_NUMBER') ?></label>
									<input id="destinationAccount" class="form-control" type="text" name="destinationAccount" autocomplete="off">
									<div class="help-block"></div>
								</div>
								<div id="mobilePhoneField" class="form-group" style="display:none">
									<label for="mobilePhone"><?= lang('GEN_PHONE_MOBILE') ?></label>
									<input id="mobilePhone" class="form-control" type="text" name="mobilePhone" autocomplete="off">
									<div class="help-block"></div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($view == 'mobilePayment') : ?>
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
						<div class="form-group col-6 col-lg-4">
							<label for="amount"><?= lang('TRANSF_AMOUNT') ?></label>
							<input id="amount" name="amount" class="form-control text-right" type="text" autocomplete="off">
							<div class="help-block"></div>
						</div>
						<div class="form-group col-6 col-lg-4">
							<label for="concept">
								<?= lang('TRANSF_CONCEPT') ?>
								<span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
							</label>
							<input id="concept" name="concept" class="form-control" type="text" autocomplete="off">
							<div class="help-block"></div>
						</div>
						<div class="form-group col-6 col-lg-4">
							<label for="expDateCta"><?= lang('TRANSF_EXP_DATE_CTA') ?></label>
							<input id="expDateCta" name="expDateCta" class="form-control" name="datepicker" type="text" placeholder="<?= lang('GEN_DATEPICKER_DATEMEDIUM'); ?>" autocomplete="off" readonly>
							<div class="help-block"></div>
						</div>
					</div>
					<div class="line my-2"></div>
					<div class="flex items-center justify-end pt-3">
						<button id="deleteBtn" class="btn btn-small btn-loading btn-primary mx-2" type="reset"><?= lang('TRANSF_ERASE') ?></button>
						<button id="transferBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>