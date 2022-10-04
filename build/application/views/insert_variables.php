<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$dataclient = new stdClass();
$dataclient->inputModal = NULL;
$dataclient->who = NULL;
$dataclient->where = NULL;
$dataclient->dataResponse = NULL;
$dataclient->cpo_cook = NULL;
$dataclient->btnText = NULL;
$dataclient->form = NULL;
$dataclient->cypherPass = NULL;
$dataclient->loader = NULL;
$dataclient->validatePass = NULL;
$dataclient->defaultCode = NULL;
$dataclient->dataTableLang = NULL;
$dataclient->currentDate = NULL;
$dataclient->code = $code ?? NULL;
$dataclient->title = $title ?? NULL;
$dataclient->msg = $msg ?? NULL;
$dataclient->icon = $icon ?? NULL;
$dataclient->data = $data ?? NULL;
$dataclient->modalBtn = $modalBtn ?? NULL;
$dataclient->response = $response ?? NULL;
$dataclient->lang = $this->lang->language;
$dataclient->baseURL = base_url();
$dataclient->assetUrl = assetUrl();
$dataclient->redirectLink = uriRedirect();
$dataclient->logged = $this->session->has_userdata('logged');
$dataclient->userId = $this->session->has_userdata('userId');
$dataclient->otpActive = $this->session->otpActive;
$dataclient->otpChannel = $this->session->otpChannel;
$dataclient->otpMfaAuth = $this->session->otpMfaAuth;
$dataclient->customerUri = $customerUri;
$dataclient->totalCards = $totalCards;
$dataclient->sessionTime = $sessionTime;
$dataclient->callServer = $callServer;

$customerData = encryptData($dataclient);

?>
<script>
	var assetsClient = <?= $customerData; ?>;
</script>
