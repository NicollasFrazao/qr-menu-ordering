<head>
	<meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="Cache-control" content="public">
    <meta name="description" content=""/>
    <meta name="author" content="">
    <meta name="title" content="@yield('title')">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:url" content="http://localhost" />
    <meta property="og:site_name" content="App" />
    
    <link rel="manifest" href="js/manifest.json">
    <link rel="canonical" href="http://localhost">
    <link rel="shortcut icon" href="image/app-favicon.svg"/>   
	<style>
		.mpp-leadbox-button{

			position:fixed;
			width: 50px;
			height: 50px;
			bottom: 10px;
			/* Precisa tratar a responsividade desse elemento para quando for em telas menores */
			right: 10px;

		}

		.mpp-leadbox{

			display: none;
			background-color: red;
			width:400px;
			height: 500px;

			position: fixed;
			right: 10px;
			bottom: 10px;
		}

		.mpp-leadbox-top{

			display: flex;
			height: 50px;
			padding-left: 10px;
			padding-right: 10px;
			background-color: orange;
			justify-content: space-between;
			align-items: center;

		}

		.mpp-leadbox-center{

			display: inline-block;
			width: 100%;
			height: calc(100% - 100px);
			background-color:  orange;

		}

		.mpp-leadbox-bottom{

			display: inline-block;
			width: 100%;
			height: 50px;
			background-color: orange;

		}

		.mpp-leadbox-screen{

			display: none;
			width: 100%;
			height: 100%;
			background-color: #eee;

		}

		.mpp-leadbox-category-item{

			display: flex;
			width: 30%;
			height: auto;
			background-color: green;
			flex-direction: column;
			align-items: center;
		}

		.mpp-category-image{

			width: 50%;
		}

		.mpp-category-name{

		}

		.mpp-item{

			display: flex;
			justify-content: space-between;
			align-items: center;
			background-color: red;
		}

		.mpp-add-item{

			width: 30px;
		}

		.mpp-remove-item{

			width: 30px;
		}

		.mpp-item-name{

			width: 100%;
			margin-left: 10px;
		}

		.mpp-item-price{

			width: 100px;

		}

		.mpp-icon-top{
			width: 30px;
		}
	</style>
</head>
<img class='mpp-leadbox-button' id='mpp_leadbox_button' src='image/app-favicon.svg'>

<div class='mpp-leadbox'>

	<div class='mpp-leadbox-top'>

		<img class='mpp-icon-top' src='images/app-voltar-icon.png'>

		<spanComanda Digital</span>

		<img class='mpp-icon-top' src='image/app-favicon.svg'>		

	</div>

	<div class='mpp-leadbox-center'>

		<div class='mpp-leadbox-screen' id='app_categories'>

			<!--<div class='mpp-leadbox-category-item' id='app_categories_itens'>

				<img class='mpp-category-image' src='images/app_pizza.png'>
				<span class='mpp-category-name'>Pizza</span>

			</div>-->

		</div>


		<div class='mpp-leadbox-screen' id='app_itens'>

			<div class='mpp-item'>

				<button class='mpp-add-item'> + </button>

				<span class='mpp-item-name'>Suco de Tamarindo</span>

				<span class='mpp-item-price'>R$ 20,90</span>

			</div>

		</div>


		<div class='mpp-leadbox-screen' id='app_order'>

			<div class='mpp-item'>

				<button class='mpp-remove-item'> x </button>

				<span class='mpp-item-name'>Suco de Tamarindo</span>

				<span class='mpp-item-price'>R$ 20,90</span>

			</div>

		</div>


		<div class='mpp-leadbox-screen' id='app_lead'>

			<input type='text' placeholder='Nome'>
			<input type='text' placeholder='Telefone'>
			<input type='text' placeholder='Endereço'>
			<textarea placeholder='Observações sobre o seu pedido'></textarea>

		</div>


		<div class='mpp-leadbox-screen' id='app_tks'>

			<span>Tks</span>

		</div>



	</div>

	<div class='mpp-leadbox-bottom'>

		<button id='app_see_order'>Ver Pedido</button>
		<button id='app_send_order'>Finalizar Pedido</button>
		<button id='app_end_order'>Enviar Pedido</button>

	</div>


</div>
	<?php 

		$timeNotRepeat = '?'.date('Ymdhis');

		Session::put('CD_LOJA', 1);

		echo Session::get('CD_LOJA');
	
	?>	


	<script src="js/jquery.js<?php echo $timeNotRepeat; ?>"></script>
	<script src="js/appAjax.js<?php echo $timeNotRepeat; ?>"></script>
	<script src="js/appScript.js<?php echo $timeNotRepeat; ?>"></script>


<script>

	$.ajaxSetup({

		beforeSend: function(xhr){
		     
		  xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
		     
		}

	}); 

</script>


<script>

	$("#mpp_leadbox_button").click(function(){
	  
		$('#app_categories').show();
		$(this).hide();
		$('.mpp-leadbox').show();

		//FUNção ajax para trazer as categorias e escrever nos negócios
		mppAjaxVar = {

			url: '/ajax/ajaxCategoriasCardapio'
		
		};

		ajaxAppRequest(mppAjaxVar, function(mppcat){

			//mppcat = mppcat;

			mppcat = JSON.parse(mppcat);

			document.getElementById('app_categories').innerHTML = '';

			for(i=0; i< mppcat.length; i++){

				//alert(mppcat[1].nm_categoria_produto+' - '+mppcat[1].nm_imagem_categoria_produto);

				//CRIANDO DIV PAI
				mpp_elemento = document.createElement('button');
				mpp_elemento.className = 'mpp-categoria';
				mpp_elemento.id = mppcat[i].cd_categoria_produto;

				//ADICIONANDO IMAGEM DA CATEGORIA
				mpp_imagem = document.createElement('img');
				mpp_imagem.className = 'mpp-category-image';
				mpp_imagem.src = mppcat[i].nm_imagem_categoria_produto;

				//ADICIONANDO LEGENDA COM O NOME DA CATEGORIA
				mpp_texto = document.createElement('span');
				mpp_texto.className = 'mpp-category-name';
				mpp_texto.innerText = mppcat[i].nm_categoria_produto;

				//ATRIBUÍNDO AO HAGATÊ EMIÉLI
				mpp_elemento.appendChild(mpp_imagem);
				mpp_elemento.appendChild(mpp_texto);
				document.getElementById('app_categories').appendChild(mpp_elemento);



			}

			$('.mpp-categoria').click(function(){

				buscaProdutosCardapioLeadbox(this.id);

				//PRECISA FAZER TROCAR DE TELA NESSE MOMENTO

			});

		});
	
	});


	function buscaProdutosCardapioLeadbox(categoria){

		mppAjaxVar = {
			url: '/ajax/ajaxCardapioProdutos',
			cd_categoria_produto: categoria
		};

		ajaxAppRequest(mppAjaxVar, function(mppprod){

			mppprod = JSON.parse(mppprod);

			for(i=0; i< mppprod.length; i++){

				mpp_elemento = document.createElement('button');
				mpp_elemento.className = 'mpp-produto';
				mpp_elemento.id = mppprod[i].cd_produto;

				mpp_produto = document.createElement('span');
				mpp_produto.innerText = mppprod[i].nm_produto;

				mpp_valor = document.createElement('span');
				mpp_valor.innerText = "R$ "+mppprod[i].vl_produto;

				mpp_elemento.appendChild(mpp_produto);
				mpp_elemento.appendChild(mpp_valor);

				document.getElementById('app_itens').appendChild(mpp_elemento);

			}

			$('#app_categories').hide();
			$('#app_itens').show();
			


		});

		

	}
		

	$('.mpp-leadbox-category-item').click(function(){

		$('#app_categories').hide();
		$('#app_itens').show();

	});

	$('#app_see_order').click(function(){

		$('#app_itens').hide();
		$('#app_order').show();

	});

	$('#app_send_order').click(function(){

		$('#app_order').hide();
		$('#app_lead').show();

	});



	/*function load_categories(){

		$.post("load_categories",
	    {

	        personagem: pers,
	          
		},
		function(data){

		  	nm_personagem.value = '';
		   	sel.innerHTML = data;	    	

		});

	}*/


	/* 1 TROCA DE TELAS */

	/* 2 CARREGAMENTO DE ITENS */

	/* 3 INSERT DO PEDIDO */

	/* 4 FINALIZAÇÃO */

</script>