<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="field-meter">
	<h4><?=  novoLang(lang('GEN_INFO_TITLE'), $title)  ?></h4>
	<ul class="pwd-rules">
		<li id="length" class="pwd-rules-item rule-invalid"><?= lang('GEN_INFO_1'); ?></li>
		<li id="letter" class="pwd-rules-item rule-invalid"><?= lang('GEN_INFO_2'); ?></li>
		<li id="capital" class="pwd-rules-item rule-invalid"><?= lang('GEN_INFO_3'); ?></li>
		<li id="number" class="pwd-rules-item rule-invalid"><?= lang('GEN_INFO_4'); ?></li>
		<li id="special" class="pwd-rules-item rule-invalid"><?= lang('GEN_INFO_5'); ?></li>
		<li id="consecutive" class="pwd-rules-item rule-invalid"><?= lang('GEN_INFO_6'); ?></li>
	</ul>
</div>
