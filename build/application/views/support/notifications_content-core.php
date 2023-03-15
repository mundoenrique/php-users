<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 semibold inline"><?= lang('GEN_MENU_NOTIFICATIONS'); ?></h1>
<div class="bg-color">
  <div class="pt-3 pb-5 px-5 bg-content-config">
    <div class="flex mt-3 bg-color justify-between">
      <div class="flex mx-2">
        <nav class="nav-config">
          <ul class="nav-config-box">
            <li id="notifications" class="nav-item-config center active" render='off'>
              <a href="<?= lang('SETT_NO_LINK'); ?>" class="not-pointer">
                <span class="icon-config icon-notification h1"></span>
                <h5><?= lang('CUST_NOT_SETT') ?></h5>
                <div class="box up left regular">
                  <span class="icon-notification h1"></span>
                  <h4 class="h5"><?= lang('CUST_NOT_SETT') ?></h4>
                </div>
              </a>
            </li>
            <li id="notificationHistory" class="nav-item-config center" render='on'>
              <a href="<?= lang('SETT_NO_LINK'); ?>">
                <span class="icon-config icon-book h1"></span>
                <h5><?= lang('CUST_NOT_HIST') ?></h5>
                <div class="box up left regular">
                  <span class="icon-book h1"></span>
                  <h4 class="h5"><?= lang('CUST_NOT_HIST') ?></h4>
                </div>
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <div class="flex flex-auto flex-column">
        <div id="notificationsView" option-service="on">
          <div class="flex mb-1 mx-4 flex-column">
            <h4 class="line-text mb-2 semibold primary"><?= lang('CUST_NOT_SETT') ?></h4>
            <div id="pre-loader">
              <div class="mt-5 mx-auto flex justify-center">
                <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
              </div>
            </div>
            <div class="px-5 hide-out hide">
              <p><?= lang('CUST_NOT_MAIL') ?></p>
              <form id="form-notifications">
                <div class="form-group flex flex-wrap max-width-2">
                  <div class="flex flex-column col-6">
                    <div class="custom-control custom-radio custom-control-inline mt-2">
                      <input id="login" name="notify" class="custom-control-input" type="checkbox" <?= $login['active'] == '1' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="login"><?= lang('CUST_LOGIN'); ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline mt-2">
                      <input id="pinChange" name="notify" class="custom-control-input" type="checkbox"
                        <?= $pinChange['active'] == '1' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="pinChange"><?= lang('CUST_PIN_CHANGE'); ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline mt-2">
                      <input id="temporaryLock" name="notify" class="custom-control-input" type="checkbox"
                        <?= $temporaryLock['active'] == '1' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="temporaryLock"><?= lang('CUST_TEMP_LOCK'); ?></label>
                    </div>
                  </div>
                  <div class="flex flex-column col-6">
                    <div class="custom-control custom-radio custom-control-inline mt-2">
                      <input id="passwordChange" name="notify" class="custom-control-input" type="checkbox"
                        <?= $passwordChange['active'] == '1' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="passwordChange"><?= lang('CUST_PASS_CHANGE'); ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline mt-2">
                      <input id="cardReplace" name="notify" class="custom-control-input" type="checkbox"
                        <?= $cardReplace['active'] == '1' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="cardReplace"><?= lang('CUST_CARD_REPLACE'); ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline mt-2">
                      <input id="temporaryUnLock" name="notify" class="custom-control-input" type="checkbox"
                        <?= $temporaryUnLock['active'] == '1' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="temporaryUnLock"><?= lang('CUST_TEMP_UNLOCK'); ?></label>
                    </div>
                  </div>
                  <div class="help-block"></div>
                </div>
                <div class="flex items-center justify-end pt-3">
                  <a class="btn btn-link btn-small big-modal" href="">Cancelar</a>
                  <button id="btn-notifications" class="btn btn-small btn-primary btn-loading">Continuar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div id="notificationHistoryView" option-service="on" style="display:none">
          <div class="flex mb-1 mx-4 flex-column">
            <h4 class="line-text semibold primary"><?= lang('CUST_NOT_HIST') ?></h4>
            <div class="form-group flex flex-wrap line-text">
              <form class="w-100" id="form-noti-history">
                <div class="row px-1">
                  <div class="form-group col-xl-2 col-lg-3 col-6 px-1">
                    <label class="mt-1 regular" for="initDate"><?= lang('GEN_FROM') ?></label>
                    <input id="initDate" name="initDate" class="form-control datepicker" type="text" placeholder="DD/MM/AAAA" readonly
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-xl-2 col-lg-3 col-6 px-1">
                    <label class="mt-1 regular" for="finalDate"><?= lang('GEN_TO') ?></label>
                    <input id="finalDate" name="finalDate" class="form-control datepicker" type="text" placeholder="DD/MM/AAAA" readonly
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-xl-3 col-lg-4 col-6 px-1">
                    <label class="mt-1 regular" for="notificationType">Tipo de notificación</label>
                    <select id="notificationType" name="notificationType" class="custom-select flex form-control">
                      <option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
                      <?php foreach(lang('CUST_NOTIFY_OPTIONS') AS $key => $value): ?>
                      <option value="<?= $key ?>"><?= $value ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <div class="flex items-center col-2 pl-0 mt-1">
                    <button id="btn-noti-history" class="btn btn-small btn-rounded-right btn-primary">
                      <span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <div id="loader-history" class="hide">
              <div class="mt-5 mx-auto flex justify-center">
                <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
              </div>
            </div>
            <div class="history-out hide">
              <p>
                <?= lang('GEN_MENU_NOTIFICATIONS'); ?> (<span id="noti-type"><?= lang('CUST_SELECT_ALL') ?></span>)
                <?= lang('GEN_FROM'); ?>: <span id="noti-from"></span> <?= lang('GEN_TO'); ?>: <span id="noti-to"></span>
              </p>
              <div class="mt-3">
                <ul id="notifications-history" class="feed fade-in mt-3 pl-0">
                  <li class="feed-item flex py-2 items-center thead">
                    <div class="flex px-2 flex-column col-6 center">
                      <span class="h5 semibold secondary">Descripción</span>
                    </div>
                    <div class="flex px-2 flex-column col-6 center">
                      <span class="h5 semibold secondary">Fecha</span>
                    </div>
                  </li>
                  <span id="item-history"></span>
                </ul>
              </div>
            </div>
            <div id="no-notifications" class="hide">
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
