<?php
$skin = $this->input->cookie($this->config->item('cookie_prefix') . 'skin');
if($skin == 'latodo'){
	$closeLink = $this->config->item('base_url') . '/users/closeSess_pe';
}else{
	$closeLink = $this->config->item('base_url') . '/users/closeSess';
}
?>
<div id="content">
      <article>
         <header>
            <h1>Error General</h1>
         </header>
         <section>
            <div id="content-clave">
               <p>Ha ocurrido un error en el sistema. Por favor intente más tarde.</p>
               <div class="empty-state-actions">
                  <a class="button" href="<? echo $closeLink; ?>" rel="section">Cerrar Sesión</a>
               </div>
            </div>
         </section>
      </article>
   </div>