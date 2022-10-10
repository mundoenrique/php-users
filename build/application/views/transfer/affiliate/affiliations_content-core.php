<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="manageAffiliationsView" class="transfer-operation" style="display:none">
  <div class="flex mb-1 mx-4 flex-column">
    <h4 class="line-text mb-2 semibold primary"><?= lang('TRANSF_MANAGE_AFFILIATIONS') ?></h4>
    <div class="w-100">
      <div class="mx-auto">
        <span><?= lang('TRANSF_MANAGE_AFFILIATE_MSG') ?></span>
        <div class="line-text my-2"></div>
        <div class="row">
          <div class="col-6">
            <button id="toTransferBtn" class="btn btn-small btn-loading btn-primary w-auto"><?= lang('TRANSF_NEW_AFFILIATE') ?></button>
          </div>
          <div class="col-6">
            <form id="searchAffiliate" method="post">
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
          <div class="col-12">
            <div id="transferRecord" class="mt-1 justify-center">
              <div id="pre-loader" class="mt-5 mx-auto flex justify-center">
                <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
              </div>
              <table id="movements" class="cell-border h6 display responsive w-100 dataTable no-footer dtr-inline">
                <thead class="bg-primary secondary regular">
                  <tr>
                    <th><?= lang('TRANSF_AFFILIATE') ?></th>
                    <th><?= lang('TRANSF_BANK') ?></th>
                    <th><?= lang('TRANSF_ACCOUNT_PHONE') ?> / <?= lang('TRANSF_DESTINATION_CARD') ?> / <?= lang('TRANSF_NUMBER_PHONE') ?></th>
                    <th><?= lang('TRANSF_OPTIONS') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>David Gutierrez</td>
                    <td>Banco Provincial</td>
                    <td>04242345678</td>
                    <td class="py-0 px-1 flex justify-center items-center">
                      <button id="editAffiliate" class="btn mx-1 px-0 title="<?= lang('TRANSF_EDIT') ?>" data-toggle="tooltip">
                        <i class="icon icon-edit" aria-hidden="true"></i>
                      </button>
                      <button id="deletAffiliate" class="btn mx-1 px-0 big-modal" title="<?= lang('TRANSF_DELETE') ?>" data-toggle="tooltip">
                        <i class="icon icon-remove" aria-hidden="true"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('/transfer/affiliate/managementAffiliate_content-core.php') ?>
