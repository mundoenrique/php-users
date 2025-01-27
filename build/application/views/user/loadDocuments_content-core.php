<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row justify-center">
  <div class="col-12 my-auto">
    <div class="row mr-2">
      <?php if(lang('SETT_LOAD_SELFIE') == 'ON'):?>
      <div class="col-4 flex items-center justify-center">
        <div class="form-group px-1 mb-2">
          <div class="drop-zone drop-zone-selfie img-preview px-1 label-file flex flex-column">
            <img src="../../../assets/images/img_avatar.png" alt="Avatar" id="imagePreviewContainer">
            <div class="drop-zone-prompt mt-1 flex justify-between ">
              <span class="js-file-name h5 regular"><?= lang('USER_ADD_PHOTO'); ?></span>
              <i class="icon icon-upload ml-2"></i>
            </div>
            <input type="file" name="SEL_A" id="SEL_A" class="drop-zone-input">
          </div>
					<div class="help-block"></div>
        </div>
      </div>
      <?php endif; ?>
      <div class="col-8 m-auto">
        <div class="row">
          <?php if(lang('SETT_LOAD_DOC_F_ID') == 'ON'):?>
          <div class="form-group col-6 col-lg-6 px-1 mb-2">
            <div class="drop-zone INE_A label-file p-1">
							<?php if($previewINE_A):?>
									<img id="preview-INE_A" class="drop-zone-thumb" style="background-image: url(<?= $imagesLoaded['INE_A']['base64'];?>)">
							<?php else:?>
								<div class="hide-INE_A drop-zone-prompt flex flex-column items-center">
									<i class="icon icon-upload h00"></i>
									<span class="js-file-name h6 regular bold"><?= lang('USER_ADD_F_DOC'); ?></span>
								</div>
							<?php endif; ?>
							<input type="file" name="INE_A" id="INE_A" class="drop-zone-input <?= $imagesLoaded['INE_A']['validate'] ?? '';?>">
            </div>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <?php if(lang('SETT_LOAD_DOC_B_ID') == 'ON'):?>
          <div class="form-group col-6 col-lg-6 px-1 mb-2">
            <div class="drop-zone INE_R label-file p-1">
							<?php if($previewINE_R):?>
								<img id="preview-INE_R" class="drop-zone-thumb" style="background-image: url(<?= $imagesLoaded['INE_R']['base64'];?>)">
							<?php else:?>
								<div class="hide-INE_R drop-zone-prompt flex flex-column items-center">
									<i class="icon icon-upload h00"></i>
									<span class="js-file-name h6 regular bold"><?= lang('USER_ADD_B_DOC'); ?></span>
								</div>
							<?php endif; ?>
							<input type="file" name="INE_R" id="INE_R" class="drop-zone-input <?= $imagesLoaded['INE_R']['validate'] ?? '';?>">
            </div>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <?php if(lang('SETT_LOAD_DOC_F_PASS') == 'ON'):?>
          <div class="form-group col-6 col-lg-6 px-1 mb-2">
            <div class="drop-zone label-file p-1">
              <div class="drop-zone-prompt flex flex-column items-center">
								<?php if($previewPASS_A):?>
									<img id="preview-PASS_A" class="drop-zone-thumb" src="<?= $imagesLoaded['PASS_A']['base64'];?>">
								<?php else:?>
									<i class="icon icon-upload h00"></i>
									<span class="js-file-name h6 regular bold"><?= lang('USER_ADD_F_PASSPORT'); ?></span>
								<?php endif; ?>
              </div>
              <input type="file" name="PASS_A" id="PASS_A" class="drop-zone-input <?= $imagesLoaded['PASS_A']['validate'] ?? '';?>">
            </div>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <?php if(lang('SETT_LOAD_DOC_B_PASS') == 'ON'):?>
          <div class="form-group col-6 col-lg-6 px-1 mb-2">
            <div class="drop-zone label-file p-1">
              <div class="drop-zone-prompt flex flex-column items-center">
								<?php if($previewPASS_B):?>
									<img id="preview-PASS_R" class="drop-zone-thumb" src="<?= $imagesLoaded['PASS_R']['base64'];?>">
								<?php else:?>
									<i class="icon icon-upload h00"></i>
									<span class="js-file-name h6 regular bold"><?= lang('USER_ADD_B_PASSPORT'); ?></span>
								<?php endif; ?>
              </div>
              <input type="file" name="PASS_R" id="PASS_R" class="drop-zone-input <?= $imagesLoaded['PASS_R']['validate'] ?? '';?>">
            </div>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
        </div>
			</div>
    </div>
  </div>
  <div class="col-12 flex justify-start">
    <div class="field-meter">
      <h4 class="semibold"><?= lang('USER_LOAD_DOCS_TITLE') ?></h4>
      <ul class="pwd-rules">
        <div class="row">
          <div class="col-6 col-lg-12">
            <li class="pwd-rules-item"><?= lang('USER_LOAD_DOCS_INFO1'); ?></li>
            <li class="pwd-rules-item"><?= lang('USER_LOAD_DOCS_INFO2'); ?></li>
            <li class="pwd-rules-item"><?= lang('USER_LOAD_DOCS_INFO3'); ?></li>
          </div>
          <div class="col-6 col-lg-12">
            <li class="pwd-rules-item">
							<?=
								novoLang(lang('USER_LOAD_DOCS_INFO4'), [lang('SETT_CONFIG_UPLOAD_FILE')['min_size'], lang('SETT_CONFIG_UPLOAD_FILE')['max_size']]);
							?>
						</li>
            <li class="pwd-rules-item"><?= lang('USER_LOAD_DOCS_INFO5'); ?></li>
          </div>
        </div>
      </ul>
    </div>
  </div>
</div>
<input id="countryDocument" type="hidden" name="countryDocument" value="<?= $countryDocument ?? ''; ?>">
<input id="img_valida" type="hidden" name="img_valida" value="<?= $img_valida ?? ''; ?>">
<input id="aplicaImgDoc" type="hidden" name="aplicaImgDoc" value="<?= $aplicaImgDoc ?? ''; ?>">


