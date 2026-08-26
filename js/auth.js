$(document).ready(function(){

	var atualizarNavbar = function(){

		$.get('usuario-logado', function(response){

			if (response.logado) {
				$('.auth-guest').hide();
				$('.auth-logado').show();
				$('.auth-nome-usuario').text(response.usuario.nome);
			} else {
				$('.auth-guest').show();
				$('.auth-logado').hide();
			}

		});

	};

	var limparMensagens = function(){
		$('.auth-mensagem, #login-mensagem, #cadastro-mensagem, #perfil-mensagem')
			.hide()
			.removeClass('text-danger text-success')
			.text('');
	};

	$('.btn-abrir-login').on('click', function(){
		limparMensagens();
		$('#form-login')[0].reset();
		$('#modal-login').modal('show');
	});

	$('.btn-abrir-cadastro').on('click', function(){
		limparMensagens();
		$('#form-cadastro')[0].reset();
		$('#modal-cadastro').modal('show');
	});

	$('#form-login').on('submit', function(event){

		event.preventDefault();
		limparMensagens();

		var email = $('#login-email').val();
		var senha = $('#login-senha').val();

		$.ajax({
			url: 'login',
			method: 'POST',
			contentType: 'application/json',
			data: JSON.stringify({ email: email, senha: senha }),
			dataType: 'json'
		}).done(function(response){

			if (response.success) {

				$('#modal-login').modal('hide');
				atualizarNavbar();

			} else if (response.existe === false) {

				$('#login-mensagem')
					.html('Não encontramos uma conta com esse e-mail. <a href="#" id="link-ir-cadastro">Cadastre-se aqui</a>.')
					.addClass('text-danger')
					.show();

				$('#link-ir-cadastro').on('click', function(event){
					event.preventDefault();
					$('#modal-login').modal('hide');
					limparMensagens();
					$('#form-cadastro')[0].reset();
					$('#modal-cadastro').modal('show');
				});

			} else {
				$('#login-mensagem').text(response.message).addClass('text-danger').show();
			}

		}).fail(function(){
			$('#login-mensagem').text('Erro ao tentar logar. Tente novamente.').addClass('text-danger').show();
		});

	});

	$('#form-cadastro').on('submit', function(event){

		event.preventDefault();
		limparMensagens();

		var nome = $('#cadastro-nome').val();
		var email = $('#cadastro-email').val();
		var senha = $('#cadastro-senha').val();
		var confirmarSenha = $('#cadastro-confirmar-senha').val();

		if (senha !== confirmarSenha) {
			$('#cadastro-mensagem').text('As senhas não coincidem.').addClass('text-danger').show();
			return;
		}

		$.ajax({
			url: 'cadastro',
			method: 'POST',
			contentType: 'application/json',
			data: JSON.stringify({ nome: nome, email: email, senha: senha }),
			dataType: 'json'
		}).done(function(response){

			if (response.success) {

				// Loga automaticamente após o cadastro
				$.ajax({
					url: 'login',
					method: 'POST',
					contentType: 'application/json',
					data: JSON.stringify({ email: email, senha: senha }),
					dataType: 'json'
				}).done(function(){
					$('#modal-cadastro').modal('hide');
					atualizarNavbar();
				});

			} else {
				$('#cadastro-mensagem').text(response.message).addClass('text-danger').show();
			}

		}).fail(function(){
			$('#cadastro-mensagem').text('Erro ao cadastrar. Tente novamente.').addClass('text-danger').show();
		});

	});

	$('.btn-logout').on('click', function(event){
		event.preventDefault();
		$.post('logout', function(){
			atualizarNavbar();
		});
	});

	$('.btn-meus-pedidos').on('click', function(event){

		event.preventDefault();

		$.get('meus-pedidos', function(pedidos){

			var $corpo = $('#pedidos-corpo');
			$corpo.empty();

			if (!pedidos || pedidos.length === 0) {
				$corpo.append('<p>Você ainda não fez nenhuma compra.</p>');
			} else {

				pedidos.forEach(function(pedido){

					var $bloco = $('<div style="border-bottom:1px solid #eee; padding:10px 0;"></div>');

					$bloco.append(
						'<strong>Pedido #' + pedido.id_ped + '</strong> - ' + pedido.data_ped + '<br>' +
						'Total: R$ ' + pedido.total_ped + ' (Frete: R$ ' + pedido.frete_ped + ')<br>'
					);

					var $lista = $('<ul></ul>');

					(pedido.produtos || []).forEach(function(produto){
						$lista.append('<li>' + produto.qtd + 'x ' + produto.nome_prod_curto + ' - R$ ' + produto.preco_unit + '</li>');
					});

					$bloco.append($lista);
					$corpo.append($bloco);

				});

			}

			$('#modal-pedidos').modal('show');

		});

	});

	$('.btn-editar-dados').on('click', function(event){

		event.preventDefault();

		$.get('usuario-logado', function(response){

			if (response.logado) {
				$('#perfil-nome').val(response.usuario.nome);
				$('#perfil-email').val(response.usuario.email);
				$('#perfil-senha').val('');
			}

			$('#modal-perfil').modal('show');

		});

	});

	$('#form-perfil').on('submit', function(event){

		event.preventDefault();
		limparMensagens();

		var payload = {
			nome: $('#perfil-nome').val(),
			email: $('#perfil-email').val(),
			senha: $('#perfil-senha').val()
		};

		$.ajax({
			url: 'usuario',
			method: 'PUT',
			contentType: 'application/json',
			data: JSON.stringify(payload),
			dataType: 'json'
		}).done(function(response){

			if (response.success) {
				$('#perfil-mensagem').text('Dados atualizados com sucesso!').addClass('text-success').show();
				atualizarNavbar();
			} else {
				$('#perfil-mensagem').text(response.message).addClass('text-danger').show();
			}

		}).fail(function(){
			$('#perfil-mensagem').text('Erro ao atualizar dados.').addClass('text-danger').show();
		});

	});

	atualizarNavbar();

});
