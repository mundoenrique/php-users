<?php

	$closeLink = $this->config->item('base_url') . '/users/closeSess';

?>
<div class="widget" id="widget-account">
	<div class="widget-header">
		<a class="user-avatar" href="<? echo $this->config->item("base_url"); ?>/perfil" rel="section">
			<span aria-hidden="true" class="icon icon-user"></span>
		</a>
	</div>
	<div class="widget-section">
		<p class="user-fullname"><a href="<? echo $this->config->item("base_url"); ?>/perfil"  rel="section"><?php echo ucwords($this->session->userdata('nombreCompleto'));?></a></p>
		<p class="user-metadata"><span aria-hidden="true" class="icon icon-geo"></span> <?php echo lang("PAIS") ?> </p>
		<p class="user-metadata"><span aria-hidden="true" class="icon icon-time"></span> <span class="tiempo"></span></p>
		<nav id="user-stack">
			<ul class="stack">
        <li class="stack-item">
          <a href="<? echo $this->config->item("base_url"); ?>/perfil" rel="section" title="Modificar" ><span aria-hidden="true" class="icon-edit"></span></a>
        </li>
				<li class="stack-item">
					<a href="<? echo $closeLink; ?>" rel="section" title="Cerrar Sesión" id="closeSession"><span aria-hidden="true" class="icon-off"></span></a>
				</li>
			</ul>
		</nav>
	</div>
	<div class="widget-footer">
		<p id="cantidad"></p>
	</div>
</div>
