<footer>
			
			<div class="row row-cinza-claro">
				
				<div class="container">
					
					<div class="row">
						
						<div class="col-md-2 text-center hidden-xs">
							
							<img class="logotipo" src="img/orlando-logo.png" alt="Logotipo">

						</div>
						<div class="col-md-10">
							
							<div class="row row-cols">
								<div class="col-md-4 col-popular-post hidden-xs">
									
									<h4>POPULAR POSTS</h4>

									<ul class="list-unstyled">
										<li>
											<h5>Neque porro quisquam est, quister.</h5>
											<time>January 01, 2016</time>
										</li>
										<li>
											<h5>Neque porro quisquam est, quister.</h5>
											<time>January 01, 2016</time>
										</li>

									</ul>

								</div>
								<div class="col-md-4 col-links hidden-xs">
									
									<h4>LINKS</h4>

									<ul class="list-unstyled">
										<li><a href="#"><i class="fa fa-angle-right"></i>Tickets</a></li>
										<li><a href="#"><i class="fa fa-angle-right"></i>News</a></li>
										<li><a href="#"><i class="fa fa-angle-right"></i>Schedule</a></li>
									</ul>

								</div>
								<div class="col-md-4 col-get-in-touch">
									
									<h4 class="hidden-xs">GET IN TOUCH</h4>

									<address class="hidden-xs">
										<i class="fa fa-map-marker"></i> <span>618 E. South Street, Suite 510<br/>Orlando, FL 32801</span>
									</address>

									<p class="hidden-xs"><a href="tel:1855ORLCITY"><i class="fa fa-phone"></i>1.855.ORL.CITY</a></p>
									
									<div class="row-fluid visible-xs">
										<div class="col-xs-6">
											<a href="#" class="btn btn-footer "><i class="fa fa-map-marker"></i>Location</a>
										</div>
										<div class="col-xs-6">
											<a href="#" class="btn btn-footer"><i class="fa fa-phone"></i>Call</a>
										</div>
									</div>

									<ul class="list-unstyled list-socials">
										<li>
											<a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
										</li>
										<li>
											<a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
										</li>
										<li>
											<a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
										</li>
										<li>
											<a href="#" target="_blank"><i class="fa fa-pinterest-p"></i></a>
										</li>
										<li class="page-up">
											<a href="#" id="page-up"><i class="fa fa-chevron-up"></i></a>
										</li>
									</ul>

								</div>
							</div>

						</div>

					</div>

				</div>

			</div>

			<div class="row row-cinza-escuro">
				
				<div class="container copyright-mobile">
					
					<p class="pull-left">Copyright © Orlando City Soccer 2016. All rights reserved.</p>
					<p class="pull-right text-roxo">Created by HCODE in Udemy</p>

				</div>

			</div>

		</footer>

		<!-- Modal de Login -->
		<div class="modal fade" id="modal-login" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Entrar</h4>
					</div>
					<form id="form-login">
						<div class="modal-body">
							<div id="login-mensagem" style="display:none; margin-bottom:15px;"></div>
							<div class="form-group">
								<label>E-mail</label>
								<input type="email" class="form-control" id="login-email" required>
							</div>
							<div class="form-group">
								<label>Senha</label>
								<input type="password" class="form-control" id="login-senha" required>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-roxo">Entrar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Modal de Cadastro -->
		<div class="modal fade" id="modal-cadastro" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Criar conta</h4>
					</div>
					<form id="form-cadastro">
						<div class="modal-body">
							<div id="cadastro-mensagem" style="display:none; margin-bottom:15px;"></div>
							<div class="form-group">
								<label>Nome</label>
								<input type="text" class="form-control" id="cadastro-nome" required>
							</div>
							<div class="form-group">
								<label>E-mail</label>
								<input type="email" class="form-control" id="cadastro-email" required>
							</div>
							<div class="form-group">
								<label>Senha</label>
								<input type="password" class="form-control" id="cadastro-senha" required>
							</div>
							<div class="form-group">
								<label>Confirmar senha</label>
								<input type="password" class="form-control" id="cadastro-confirmar-senha" required>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-roxo">Cadastrar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Modal de Meus Pedidos -->
		<div class="modal fade" id="modal-pedidos" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Meus Pedidos</h4>
					</div>
					<div class="modal-body" id="pedidos-corpo">
					</div>
				</div>
			</div>
		</div>

		<!-- Modal de Editar Dados -->
		<div class="modal fade" id="modal-perfil" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Editar Dados</h4>
					</div>
					<form id="form-perfil">
						<div class="modal-body">
							<div id="perfil-mensagem" style="display:none; margin-bottom:15px;"></div>
							<div class="form-group">
								<label>Nome</label>
								<input type="text" class="form-control" id="perfil-nome" required>
							</div>
							<div class="form-group">
								<label>E-mail</label>
								<input type="email" class="form-control" id="perfil-email" required>
							</div>
							<div class="form-group">
								<label>Nova senha (deixe em branco para não alterar)</label>
								<input type="password" class="form-control" id="perfil-senha">
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-roxo">Salvar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<script src="lib/jquery/jquery.min.js"></script>
		<script src="lib/owl.carousel/owl-carousel/owl.carousel.min.js"></script>
		<script src="lib/bootstrap/js/bootstrap.min.js"></script>
		<script src="lib/raty/lib/jquery.raty.js"></script>
		<script src="js/efeitos.js?v=2"></script>
		<script src="js/auth.js"></script>

	</body>
</html>