<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="affiliationsView" class="transfer-operation" style="display:none">
  <div class="flex mb-1 mx-4 flex-column">
    <h4 class="line-text mb-2 semibold primary"><?= lang('TRANSF_MANAGE_AFFILIATIONS') ?></h4>
    <div class="w-100">
      <div class="mx-auto">
        <span><?= lang('TRANSF_MANAGE_AFFILIATE_MSG') ?></span>
        <div class="line-text my-2"></div>
        <div class="row">
          <div class="col-6">
            <button id="newAffiliate" class="btn btn-small btn-loading btn-primary w-auto"><?= lang('TRANSF_NEW_AFFILIATE') ?></button>
          </div>
          <div class="col-6">
            <form id="searchAffiliate" method="post" class="hide">
              <div class="row pl-2 pr-3 justify-end">
                <div class="form-group col-auto px-1">
                  <input id="filterSearchAffiliate" name="filterSearchAffiliate" class="form-control" name="filterSearchAffiliate" type="text"
                    placeholder="<?= lang('GEN_BTN_SEARCH') ?>" autocomplete="off">
                  <div class="help-block"></div>
                </div>
                <div class="flex items-center">
                  <button id="searchAffiliateBtn" class="btn btn-small btn-rounded-right btn-primary mb-3">
                    <span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
                  </button>
                </div>
              </div>
            </form>
          </div>
					<div id="pre-loader" class="w-100 hide">
						<div class="mt-5 mb-4 pt-5 mx-auto flex justify-center">
							<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
						</div>
					</div>
          <div class="col-12 hide-out hide">
            <div id="transferRecord" class="mt-1 justify-center hide">
              <table id="affiliationTable" class="cell-border h6 display responsive w-100 dataTable no-footer dtr-inline">
                <thead class="bg-primary secondary regular">
                  <tr>
									<?php foreach($tHeaders as $key => $value) : ?>
                    <th> <?= $value ?></th>
									<?php endforeach; ?>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <div id="no-moves" class="hide">
              <div class="flex flex-column items-center justify-center pt-5">
                <h3 class="h4 regular mb-0"><?= lang('GEN_DATATABLE_SEMPTYTABLE'); ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('/transfer/affiliate/managementAffiliate_content-core.php') ?>
