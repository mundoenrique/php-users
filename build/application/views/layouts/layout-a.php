<?php
$skin = get_cookie('skin', TRUE);
if(isset($header)){
?>
{header}
<?php } ?>

<div id="wrapper" class="padding-top">
  <!-- Begin: Content Area -->
  {content}
  <!-- End: Content Area -->
  <?php if(isset($sidebarActive) && $sidebarActive){?>
	<?php if($skin == 'pichincha'): ?>
		<center class="margin-bottom">
			<img src="<?= insertFile('logo-pichincha-azul.png'); ?>" alt="Banco PICHINCHA">
		</center>
		<h1 class="welcome-title-bp"><?= lang('WELCOME_TITLE'); ?></h1>
	<?php endif; ?>

  <!-- Begin: Sidebar -->
  <div id="sidebar" class="signin">
    {sidebar}
  </div>
  <!-- End: Sidebar -->
	<?php if($skin == 'pichincha'): ?>
	<p class="align-center"><?= lang('WELCOME_MSG') ?></p>
	<?php endif; ?>
  <?php };?>
</div>
<?php if(isset($footer)){ ?>
{footer}
<?php } ?>
