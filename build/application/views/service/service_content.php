<div id="service" class="registro-content h-100 bg-white">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<header class="">
			<h1 class="primary h0">Atención al cliente</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class='product-scheme pt-3'>
				<p class="field-tip" style="color: #eee; margin-left: 10px;">Selecciona la operación que deseas realizar</p>
				<ul class='list-inline'>
					<li class="list-inline-item"><span class="icon-lock services-item"></span>Bloqueo <br>de cuenta</li>
					<li class="list-inline-item"><span class="icon-spinner services-item"></span>Solicitud <br>de reposición</li>
					<li class="list-inline-item"><span class="icon-key services-item"></span>Cambio <br>de PIN</li>
					<?php if($pais == 'Co' || $pais == 'Ve' || $pais == 'Pe'): ?>
					<li class="list-inline-item"><span class="icon-key services-item"></span>Solicitud <br>de PIN</li>
					<?php endif; ?>
				</ul>
			</div>
		</section>
	</div>
</div>
