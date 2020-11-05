<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
	var lang = <?php print_r(json_encode($this->lang->language)); ?> ;
	var baseURL = '<?= base_url(); ?>';
	var assetUrl = '<?= assetUrl(); ?>';
	var country = '<?= $countryUri; ?>';
	var client = '<?= $this->config->item('client'); ?>';
	var newViews = '<?= $this->config->item('new-views'); ?>';
	var code = <?= $code ?? 0; ?> ;
	var title = '<?= $title ?? ' '; ?>';
	var msg = '<?= $msg ?? ' '; ?>';
	var icon = '<?= $icon ?? ' '; ?>';
	var data = <?= $data ?? 0; ?> ;
	var modalBtn = <?= $modalBtn ?? 0; ?> ;
	var logged = <?= json_encode($this->session->has_userdata('logged')); ?> ;
	var sessionTime = <?= $sessionTime; ?> ;
	var callModal = <?= $callModal; ?> ;
	var callServer = <?= $callServer; ?> ;
</script>
