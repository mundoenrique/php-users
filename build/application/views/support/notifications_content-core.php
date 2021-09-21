<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 semibold inline"><?= lang('GEN_MENU_NOTIFICATIONS'); ?></h1>
<div class="bg-color">
	<div class="pt-3 pb-5 px-5 bg-content-config">
		<div class="flex mt-3 bg-color justify-between">
			<div class="flex mx-2">
				<nav class="nav-config">
					<ul class="nav-config-box">
						<li id="notifications" class="nav-item-config center active">
							<a href="<?= lang('CONF_NO_LINK'); ?>">
								<span class="icon-config icon-notification h1"></span>
								<h5>Notificaciones</h5>
								<div class="box up left regular">
									<span class="icon-notification h1"></span>
									<h4 class="h5">Configurar notificaciones</h4>
								</div>
							</a>
						</li>
						<li id="notificationHistory" class="nav-item-config center">
							<a href="<?= lang('CONF_NO_LINK'); ?>">
								<span class="icon-config icon-book h1"></span>
								<h5>Historial de notificaciones</h5>
								<div class="box up left regular">
									<span class="icon-book h1"></span>
									<h4 class="h5">Historial de notificaciones</h4>
								</div>
							</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="flex flex-auto flex-column">
				<div id="notificationsView"  option-service="on">
					<div class="flex mb-1 mx-4 flex-column">
						<h4 class="line-text mb-2 semibold primary">Configuración de notificaciones</h4>
						<div class="px-5">
							<p>Seleccione las notificaciones que desea recibir por correo electrónico</p>
							<!-- <div id="pre-loader" class="mt-5 mx-auto flex justify-center">
								<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
							</div> -->
							<div class="hide-out hide">
								<form id="">
									<div class="form-group flex flex-wrap max-width-2">
										<div class="flex flex-column col-6">
											<div class="custom-control custom-radio custom-control-inline mt-2">
												<input id="notifyLogin" class="custom-control-input" type="checkbox" <?= $login['active'] == '1' ? 'checked' : '' ?>>
												<label class="custom-control-label" for="notifyLogin">Iniciar sesión</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline mt-2">
												<input id="notifyChangePin" class="custom-control-input" type="checkbox" <?= $pinChange['active'] == '1' ? 'checked' : '' ?>>
												<label class="custom-control-label" for="notifyChangePin">Cambio de PIN</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline mt-2">
												<input id="notifyTempLock" class="custom-control-input" type="checkbox" <?= $temporaryLock['active'] == '1' ? 'checked' : '' ?>>
												<label class="custom-control-label" for="notifyTempLock">Bloqueo temporal</label>
											</div>
										</div>
										<div class="flex flex-column col-6">
											<div class="custom-control custom-radio custom-control-inline mt-2">
												<input id="notifyChangePass" class="custom-control-input" type="checkbox" <?= $passwordChange['active'] == '1' ? 'checked' : '' ?>>
												<label class="custom-control-label" for="notifyChangePass">Cambio de contraseña</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline mt-2">
												<input id="notifyReplaceCard" class="custom-control-input" type="checkbox" <?= $cardReplace['active'] == '1' ? 'checked' : '' ?>>
												<label class="custom-control-label" for="notifyReplaceCard">Reposición de tarjetas</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline mt-2">
												<input id="notifyBlockCard" class="custom-control-input" type="checkbox" <?= $temporaryUnLock['active'] == '1' ? 'checked' : '' ?>>
												<label class="custom-control-label" for="notifyBlockCard">Desbloqueo de tarjeta</label>
											</div>
										</div>
									</div>
									<div class="flex items-center justify-end pt-3">
										<a class="btn btn-link btn-small big-modal" href="">Cancelar</a>
										<button class="btn btn-small btn-primary btn-loading" type="submit">Continuar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div id="notificationHistoryView" option-service="on" style="display:none">
					<div class="flex mb-1 mx-4 flex-column">
						<h4 class="line-text semibold primary">Historial de notificaciones</h4>
							<div class="form-group flex flex-wrap line-text">
								<form id="">
									<nav class="navbar px-0">
										<div id="period-form" class="stack-form flex items-center col-auto col-lg-auto col-xl-auto px-0 px-lg-1">
											<label class="my-1 mr-1 regular" for="filterMonth">Desde</label>
											<input id="datepicker_start" name="datepicker_start" class="form-control hasDatepicker" type="text" placeholder="DD/MM/AAA" readonly="" autocomplete="off">
											<div class="help-block"></div>
										</div>
										<div id="period-form" class="stack-form mx-1 flex items-center col-auto col-lg-auto col-xl-auto px-0 px-lg-1">
											<label class="my-1 mr-1 regular" for="filterMonth">Hasta</label>
											<input id="datepicker_end" name="datepicker_end" class="form-control hasDatepicker" type="text" placeholder="DD/MM/AAA" readonly="" autocomplete="off">
											<div class="help-block "></div>
										</div>
										<div class="stack-form flex items-center col-auto col-lg-auto col-xl-auto px-0 pl-lg-1">
											<label class="regular">Tipo de notificación</label>
											<select id="status-order" name="status-order" class=" custom-select flex form-control ml-1">
												<option value="" selected="" disabled="">Todas</option>
												<option value="2">Login</option>
												<option value="3">Login</option>
												<option value="4">Login</option>
												<option value="5">Login</option>
												<option value="6">Login</option>
											</select>
											<div class="help-block"></div>
											<button id="buscar" class="btn btn-small btn-rounded-right btn-primary">
												<span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
											</button>
										</div>
									</nav>
								</form>
							</div>
						<div>
							<p>Notificaciones: Todo de: <span>01/05/2020 12:00 AM</span>  Hasta: <span>11/05/2020 11:59:59 PM</span></p>
							<div class="mt-3">
								<ul class="feed fade-in mt-3 pl-0">
									<li class="feed-item flex py-2 items-center thead">
										<div class="flex px-2 flex-column col-6 center">
											<span class="h5 semibold secondary">Descripción</span>
										</div>
										<div class="flex px-2 flex-column col-6 center">
											<span class="h5 semibold secondary">Fecha</span>
										</div>
									</li>
									<li class="feed-item flex items-center">
										<div class="flex px-2 py-2 flex-column col-6 feed-date">
											<span class="h5">Login</span>
										</div>
										<div class="flex px-2 py-2 flex-column col-6">
											<span class="h5">11/05/2020 <span>9:08:36 pm</span></span>
										</div>
									</li>
									<li class="feed-item flex items-center">
										<div class="flex px-2 py-2 flex-column col-6 feed-date">
											<span class="h5">Login</span>
										</div>
										<div class="flex px-2 py-2 flex-column col-6">
											<span class="h5">11/05/2020 <span>9:08:36 pm</span></span>
										</div>
									</li>
									<li class="feed-item flex items-center">
										<div class="flex px-2 py-2 flex-column col-6 feed-date">
											<span class="h5">Login</span>
										</div>
										<div class="flex px-2 py-2 flex-column col-6">
											<span class="h5">11/05/2020 <span>9:08:36 pm</span></span>
										</div>
									</li>
									<li class="feed-item flex items-center">
										<div class="flex px-2 py-2 flex-column col-6 feed-date">
											<span class="h5">Login</span>
										</div>
										<div class="flex px-2 py-2 flex-column col-6">
											<span class="h5">11/05/2020 <span>9:08:36 pm</span></span>
										</div>
									</li>
									<li class="feed-item flex items-center">
										<div class="flex px-2 py-2 flex-column col-6 feed-date">
											<span class="h5">Login</span>
										</div>
										<div class="flex px-2 py-2 flex-column col-6">
											<span class="h5">11/05/2020 <span>9:08:36 pm</span></span>
										</div>
									</li>
								</ul>

								<div id="" class="visible">
									<div class="pagination page-number flex mb-5 py-2 flex-auto justify-center">
										<nav class="h4">
											<a href="javascript:" position="first">Primera</a>
											<a href="javascript:" position="prev">«</a>
										</nav>
										<div id="show-page" class="h4 flex justify-center ">
											<span class="mx-1 page-current">
												<a href="javascript:" position="page" filter-page="page_">1</a>
											</span>
										</div>
										<nav class="h4">
											<a href="javascript:" position="next">»</a>
											<a href="javascript:" position="last">Última</a>
										</nav>
									</div>
								</div>
								<div class="hide">
									<div class="flex flex-column items-center justify-center pt-5">
										<h3 class="h4 regular mb-0">No se encontraron resultados</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
