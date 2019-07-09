
<div id="content">
	<article>
		<header>
			<h1>Clave SMS</h1>
		</header>
		<section>
			<div id="content-holder">
				<div id="content-pass">


				</div>
				<div id="msg"></div>
			</div>
		</section>
	</article>
</div>



<!-- CONFIRMAR CREAR -->

		<div id="confirmaCrear" style='display:none'>
			<article>
				<header>
					<h1>Crear Clave SMS</h1>
				</header>
				<section>
					<div id="content-holder">
						<h2>Confirmación</h2>
							<div class="alert-success" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Contraseña creada exitosamente
								<p>Su clave de operaciones SMS ha sido creada <strong>con éxito.</strong></p>
								<?php
									$this->session->set_userdata('passwordOperaciones','clave');
 								?>
							</div>
							<div class="form-actions">
								<button id="continuar" class="novo-btn-primary">Continuar</button>
							</div>
					</div>
				</section>
			</article>
		</div>


<!-- CONFIRMAR ACTUALIZAR -->

		<div id="confirmaActualizar" style='display:none'>
			<article>
				<header>
					<h1>Actualizar Clave SMS</h1>
				</header>
				<section>
					<div id="content-holder">
						<h2>Confirmación</h2>
							<div class="alert-success" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave actualizada exitosamente
								<p>Su clave de operaciones SMS ha sido actualizada <strong>con éxito</strong>.</p>
							</div>
							<div class="form-actions">
								<button id="confirmar" class="novo-btn-primary">Continuar</button>
							</div>
					</div>
				</section>
			</article>
		</div>
<!-- CONFIRMAR CREAR -->

		<div id="confirmaCrear" style='display:none'>
			<article>
				<header>
					<h1>Crear Clave SMS</h1>
				</header>
				<section>
					<div id="content-holder">
						<h2>Confirmación</h2>
							<div class="alert-success" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave creada exitosamente
								<p>Su clave de operaciones SMS ha sido creada <strong>con éxito</strong>.</p>
							</div>
							<div class="form-actions">
								<button id="confirmar-crear" class="novo-btn-primary">Continuar</button>
							</div>
					</div>
				</section>
			</article>
		</div>
<!-- CONFIRMAR ELIMINAR -->

		<div id="confirmaEliminar" style='display:none'>
			<article>
				<header>
					<h1>Eliminar Clave SMS</h1>
				</header>
				<section>
					<div id="content-holder">
						<h2>Confirmación</h2>
							<div class="alert-success" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave eliminada exitosamente
								<p>Su clave de operaciones SMS ha sido eliminada <strong>con éxito</strong>.</p>
							</div>
							<div class="form-actions">
								<button id="confirmar-eliminar">Continuar</button>
							</div>
					</div>
				</section>
			</article>
		</div>
<!-- error ACTUALIZAR 1 -->

		<div id="sinExito" style='display:none'>
			<article>
				<header>
					<h1>Error actualizando Clave de Operaciones SMS</h1>
				</header>
				<section>
					<div id="content-holder">
							<div class="alert-error" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave no actualizada
								<p>Su clave de operaciones SMS no ha sido actualizada. Por favor verifique sus datos.</p>
							</div>
							<div class="form-actions">
								<button id="regresar" class="novo-btn-primary">Regresar</button>
							</div>
					</div>
				</section>
			</article>
		</div>

<!-- error ACTUALIZAR 2 -->

		<div id="sinExito2" style='display:none'>
			<article>
				<header>
					<h1>Error actualizando Clave de Operaciones SMS</h1>
				</header>
				<section>
					<div id="content-holder">
							<div class="alert-error" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave no actualizada
								<p>Error, el numero móvil no tiene asociada ninguna cuenta plata. Por favor verifique sus datos.</p>
							</div>
							<div class="form-actions">
								<button id="regresar2" class="novo-btn-primary">Regresar</button>
							</div>
					</div>
				</section>
			</article>
		</div>
<!-- error ACTUALIZAR 2 -->

		<div id="sinExito7" style='display:none'>
			<article>
				<header>
					<h1>Error actualizando Clave de Operaciones SMS</h1>
				</header>
				<section>
					<div id="content-holder">
							<div class="alert-error" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave no actualizada
								<p>Ha ocurrido un error actualizando su clave SMS. Por favor intente de nuevo.</p>
							</div>
							<div class="form-actions">
								<button id="regresar7" class="novo-btn-primary">Regresar</button>
							</div>
					</div>
				</section>
			</article>
		</div>
<!-- error ELIMINAR 1 -->

		<div id="sinExito3" style='display:none'>
			<article>
				<header>
					<h1>Error eliminando Clave de Operaciones SMS</h1>
				</header>
				<section>
					<div id="content-holder">
							<div class="alert-error" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span>
								<p>Su clave de operaciones SMS ha sido eliminada previamente.</p>
							</div>
							<div class="form-actions">
								<button id="regresar3" class="novo-btn-primary">Regresar</button>
							</div>
					</div>
				</section>
			</article>
		</div>

<!-- error ELIMINAR 2 -->

		<div id="sinExito4" style='display:none'>
			<article>
				<header>
					<h1>Error eliminando Clave de Operaciones SMS</h1>
				</header>
				<section>
					<div id="content-holder">
							<div class="alert-error" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave no eliminada
								<p>Su clave de operaciones no ha sido eliminada. Por favor verifique sus datos.</p>
							</div>
							<div class="form-actions">
								<button id="regresar4" class="novo-btn-primary">Regresar</button>
							</div>
					</div>
				</section>
			</article>
		</div>

<!-- error CREAR 1 -->

		<div id="sinExito5" style='display:none'>
			<article>
				<header>
					<h1>Error creando Clave de Operaciones SMS</h1>
				</header>
				<section>
					<div id="content-holder">
							<div class="alert-error" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span>
								<p>Su clave de operaciones SMS ya existe.</p>
							</div>
							<div class="form-actions">
								<button id="regresar5" class="novo-btn-primary">Regresar</button>
							</div>
					</div>
				</section>
			</article>
		</div>

<!-- error CREAR 2 -->

		<div id="sinExito6" style='display:none'>
			<article>
				<header>
					<h1>Error creando Clave de Operaciones SMS</h1>
				</header>
				<section>
					<div id="content-holder">
							<div class="alert-error" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave no creada
								<p>Su clave de operaciones no ha sido creada. Por favor verifique sus datos.</p>
							</div>
							<div class="form-actions">
								<button id="regresar6" class="novo-btn-primary">Regresar</button>
							</div>
					</div>
				</section>
			</article>
		</div>
