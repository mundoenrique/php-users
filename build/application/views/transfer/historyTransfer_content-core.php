<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="historyView" class="transfer-operation" style="display:none">
  <div class="flex mb-1 mx-4 flex-column">
    <h4 class="line-text semibold primary"><?= lang('TRANSF_HISTORY') ?></h4>
    <div class="w-100">
      <div class="mx-auto">
				<form id="historyForm">
					<input type="hidden" id="filterMonth" name="filterMonth">
					<input type="hidden" id="filterYear" name="filterYear">
        	<div class="row pl-2 mt-3">
						<label class="mt-1 regular" for="initDateFilter"><?= lang('TRANSF_SHOW'); ?></label>
						<div class="form-group col-3 px-1">
							<input id="filterHistoryDate" name="filterHistoryDate" class="form-control" name="datepicker" type="text"
								placeholder="<?= lang('GEN_DATEPICKER_DATEMEDIUM'); ?>">
							<div id='error' class="help-block"></div>
						</div>
						<div class="flex items-center">
							<button id="historySearch" class="btn btn-small btn-rounded-right btn-primary mb-3">
								<span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
							</button>
						</div>
					</div>
				</form>
        <div class="line-text my-2"></div>
        <div id="pre-loader" class="w-100 hide">
          <div class="mt-5 mb-4 pt-5 mx-auto flex justify-center">
            <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
          </div>
        </div>
        <div id="results" class="mt-1 justify-center hide-out hide">
          <ul id="movementsList" class="feed fade-in mt-3 pl-0 easyPaginateList">
          </ul>
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
