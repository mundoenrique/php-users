<?php
$skin = $this->input->cookie($this->config->item('cookie_prefix') . 'skin');
if ($skin == 'latodo') {
  $ruta1 = $this->config->item('base_url') . '/users/closeSess_pe';
} else {
  $ruta1 = $this->config->item('base_url') . '/users/closeSess';
}
?>
<div id="content">
      <article>
         <header>
            <h1>Tarjeta no activa</h1>
         </header>
         <section>
            <div id="content-clave">
               <p>Estimado cliente, usted no posee cuentas activas para realizar consultas u operaciones.</p>
               <div class="empty-state-actions">
                  <a class="button" href="<? echo $ruta1; ?>" rel="section">Cerrar Sesión</a>
               </div>
            </div>
         </section>
      </article>
   </div>
