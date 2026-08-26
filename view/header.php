<!DOCTYPE html>
<html ng-app="shop">
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Orlando City</title>
		<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="lib/owl.carousel/owl-carousel/owl.carousel.css">
		<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="lib/raty/lib/jquery.raty.css">
		<link rel="stylesheet" href="css/orlando.css">
		<link rel="stylesheet" href="css/orlando-mobile.css">

		<script src="lib/angularjs/angular.min.js"></script>

	</head>
	<body>

		<header>
			
			<div id="menu-mobile-mask" class="visible-xs"></div>

			<div id="menu-mobile" class="visible-xs">
				<img class="menu-mobile-logo" src="img/orlando-logo.png" alt="Logotipo">
				
				<ul class="list-unstyled">
					<li><a href="index">Home</a></li>
					<li><a href="videos">Videos</a></li>
					<li><a href="#">Tickets</a></li>
					<li><a href="#">News</a></li>
					<li><a href="#">Schedule</a></li>
					<li><a href="shop">Shop</a></li>
				</ul>

				<ul class="list-unstyled mobile-auth-nav">
					<li class="auth-guest">
						<button type="button" class="btn btn-sm btn-roxo btn-abrir-login">Entrar</button>
						<button type="button" class="btn btn-sm btn-roxo btn-abrir-cadastro">Cadastrar</button>
					</li>
					<li class="auth-logado dropdown" style="display:none;">
						<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user"></i> <span class="auth-nome-usuario"></span> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="#" class="btn-meus-pedidos">Meus Pedidos</a></li>
							<li><a href="#" class="btn-editar-dados">Editar Dados</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#" class="btn-logout">Sair</a></li>
						</ul>
					</li>
				</ul>

				<div class="bar-close">
					<button type="button" class="btn btn-close"><i class="fa fa-close"></i></button>
				</div>

			</div>
			
			<div class="container">
				<img id="logotipo" src="img/orlando-logo.png" alt="Logotipo">

				<ul class="list-unstyled pull-right" id="auth-nav">
					<li class="auth-guest">
						<button type="button" class="btn btn-sm btn-roxo btn-abrir-login">Entrar</button>
						<button type="button" class="btn btn-sm btn-roxo btn-abrir-cadastro">Cadastrar</button>
					</li>
					<li class="auth-logado dropdown" style="display:none;">
						<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user"></i> <span class="auth-nome-usuario"></span> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="#" class="btn-meus-pedidos">Meus Pedidos</a></li>
							<li><a href="#" class="btn-editar-dados">Editar Dados</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#" class="btn-logout">Sair</a></li>
						</ul>
					</li>
				</ul>
			</div>

			<div class="header-black">
				
				<div class="container">

					<input type="search" id="input-search-mobile" class="visible-xs" placeholder="search...">
				
					<button id="btn-bars" type="button"><i class="fa fa-bars"></i></button>
					<button id="btn-search" type="button"><i class="fa fa-search"></i></button>

				</div>

			</div>

			<div class="container">
				
				<div class="row">
					
					<nav id="menu" class="pull-right">
						<ul>
							<li><a href="index">Home</a></li>
							<li><a href="videos">Videos</a></li>
							<li><a href="#">Tickets</a></li>
							<li><a href="#">News</a></li>
							<li><a href="#">Schedule</a></li>
							<li><a href="shop">Shop</a></li>
							<li class="search">
								<div class="input-group">
							      <input type="search" placeholder="search" id="input-search">
							      <span class="input-group-btn">
							        <button type="button"><i class="fa fa-search"></i></button>
							      </span>
							    </div><!-- /input-group -->
							</li>
						</ul>
					</nav>

				</div>

			</div>			

		</header>
