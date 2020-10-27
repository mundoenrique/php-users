<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h4 class="mt-1 pb-2 h4"><?= lang('USER_LOAD_DOCS'); ?></h4>
<div class="row justify-center">
  <div class="col-12 col-lg-7 my-auto">
    <div class="row mr-2">
      <?php if(lang('CONF_LOAD_SELFIE') == 'ON'):?>
      <div class="col-4 flex items-center justify-center">
        <div class="form-group px-1 mb-2">
          <div class="drop-zone drop-zone-selfie img-preview px-1 label-file flex flex-column">
            <img src="../../../assets/images/img_avatar.png" alt="Avatar" id="imagePreviewContainer">
            <div class="drop-zone-prompt mt-1 flex justify-between ">
              <span class="js-file-name h5 regular"><?= lang('USER_ADD_PHOTO'); ?></span>
              <i class="icon icon-upload ml-2"></i>
            </div>
            <input type="file" name="myFile" id="imageUpload" class="drop-zone-input" accept=".png, .jpg, .jpeg">
          </div>
        </div>
        <div class="help-block"></div>
      </div>
      <?php endif; ?>
      <div class="col-8 m-auto">
        <div class="row">
          <?php if(lang('CONF_LOAD_DOC_F_ID') == 'ON'):?>
          <div class="form-group col-6 col-lg-6 px-1 mb-2">
            <div class="drop-zone label-file p-1">
              <div class="drop-zone-prompt flex flex-column items-center">
                <i class="icon icon-upload h00"></i>
                <span class="js-file-name h6 regular bold"><?= lang('USER_ADD_F_DOC'); ?></span>
              </div>
              <input type="file" name="myFile" class="drop-zone-input" accept=".png, .jpg, .jpeg">
            </div>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <?php if(lang('CONF_LOAD_DOC_B_ID') == 'ON'):?>
          <div class="form-group col-6 col-lg-6 px-1 mb-2">
            <div class="drop-zone label-file p-1">
              <div class="drop-zone-prompt flex flex-column items-center">
                <i class="icon icon-upload h00"></i>
                <span class="js-file-name h6 regular bold drop-zone-prompt"><?= lang('USER_ADD_B_DOC'); ?></span>
              </div>
              <input type="file" name="myFile" class="drop-zone-input" accept=".png, .jpg, .jpeg">
            </div>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <?php if(lang('CONF_LOAD_DOC_F_PASS') == 'ON'):?>
          <div class="form-group col-6 col-lg-6 px-1 mb-2">
            <div class="drop-zone label-file p-1">
              <div class="drop-zone-prompt flex flex-column items-center">
                <i class="icon icon-upload h00"></i>
                <span class="js-file-name h6 regular bold drop-zone-prompt"><?= lang('USER_ADD_F_PASSPORT'); ?></span>
              </div>
              <input type="file" name="myFile" class="drop-zone-input" accept=".png, .jpg, .jpeg">
            </div>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <?php if(lang('CONF_LOAD_DOC_B_PASS') == 'ON'):?>
          <div class="form-group col-6 col-lg-6 px-1 mb-2">
            <div class="drop-zone label-file p-1">
              <div class="drop-zone-prompt flex flex-column items-center">
                <i class="icon icon-upload h00"></i>
                <span class="js-file-name h6 regular bold drop-zone-prompt"><?= lang('USER_ADD_B_PASSPORT'); ?></span>
              </div>
              <input type="file" name="myFile" class="drop-zone-input" accept=".png, .jpg, .jpeg">
            </div>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-4 flex justify-start">
    <div class="field-meter">
      <h4><?= lang('USER_LOAD_DOCS_TITLE') ?></h4>
      <ul class="pwd-rules">
        <div class="row">
          <div class="col-6 col-lg-12">
            <li class="pwd-rules-item"><?= lang('USER_LOAD_DOCS_INFO1'); ?></li>
            <li class="pwd-rules-item"><?= lang('USER_LOAD_DOCS_INFO2'); ?></li>
            <li class="pwd-rules-item"><?= lang('USER_LOAD_DOCS_INFO3'); ?></li>
          </div>
          <div class="col-6 col-lg-12">
            <li class="pwd-rules-item"><?= lang('USER_LOAD_DOCS_INFO4'); ?></li>
            <li class="pwd-rules-item"><?= lang('USER_LOAD_DOCS_INFO5'); ?></li>
          </div>
        </div>
      </ul>
    </div>
  </div>
</div>