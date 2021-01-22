//CLICKS TO LOGIN

//CONTROL VARS
//Item do pedido é multiplo ou não
mppMultiComanda = new Array();
MPP_CTRL_MULTI = 0;

$('.face-login').click(function(){
  
  $('#face_login_load').css('display','flex');

	//var popup = window.open('/facebook/login', '_self');

});


$('.google-login').click(function(){

	var popup = window.open('/google/login', '_self');

});


//FUCNTION TO CHANGE SCREEN

function screenShow(screen){

	//window.location.hash = '#'+screen;

	screenHide();

	$('#mppBottomBar').css('display','flex');
	$('#mpps_top_bar').css('display','flex');

	if(screen == 'mpps_qr'){
		
		startQR();
		$('#mpps_top_bar').css('display','none');
		$('#mppBottomBar').css('display','none');
		$('#'+screen).css('display','flex');

	}
	else if(screen == 'mpps_cardapio'){

		startCardapio(screen);

	}
	else if(screen == 'mpps_home'){

		$('#mpps_top_bar').css('display','none');
		$('#'+screen).css('display','flex');

	}
  else if(screen == 'mpps_loja'){

		$('#mpps_top_bar').css('display','none');
		$('#'+screen).css('display','flex');

	}
  else if(screen == 'mpps_configuracao'){
    
    $('#mpps_top_bar').css('display','none');
		$('#'+screen).css('display','flex');

	}
  else if(screen == 'mpps_sobre'){
    
    $('#mpps_top_bar').css('display','none');
		$('#'+screen).css('display','flex');
    
  }
	else{

		$('#'+screen).css('display','flex');

	}
	
	localStorage.setItem('MPP_LAST_SCREEN',screen);
	location.hash = screen;
	
}

function screenHide(){
  
  mpps_login.style.display = 'none';
	mpps_home.style.display = 'none';
  mpps_loja.style.display = 'none';
	mpps_qr.style.display = 'none';
	mpps_categoria.style.display = 'none';
	mpps_cardapio.style.display = 'none';
	mpps_comanda.style.display = 'none';
  mpps_sobre.style.display = 'none';  
	mpps_avaliacao.style.display = 'none';
	mpps_configuracao.style.display = 'none';
	mpps_tamanho.style.display = 'none';
  mppLoadScreen.style.display = 'none';
  
}

//FUNÇÕES COMPLEMENTARES DAS TELAS
function startCardapio(screen){

	//mppComanda.innerHTML = appSession.cd_comanda;
	//mppLoja.innerHTML = appSession.cd_loja;
	//mppNome.innerHTML = appSession.nm_usuario;

	$('#'+screen).css('display','flex');

}


//BOTÕES DA BARRA
$('#mppBarPedido').click(function(){

	screenShow('mpps_comanda');

});


$('#mppBarQR').click(function(){

	screenShow('mpps_qr');

});

// $('#mpp_valor_comanda').click(function(){
  
//   screenShow('mpps_finalizar');
  
// });


$('#mppBarCardapio').click(function(){


	if(appSession['cd_comanda']){

		//buscaCategoriasCardapio();
		screenShow('mpps_categoria');

	}
	else{

		screenShow('mpps_home');

	}


});

$('#mppBarSocial').click(function(){

	screenShow('mpps_social');

});

$('#mppBarFinalizar').click(function(){
  
  $('#mpps_finalizar').css('top','0vh');
  
});

$('#mppButtonConfiguracaoSobre').click(function(){
  
  screenShow('mpps_sobre');
  
});


$('#mppBarConfig').click(function(){
	//logout();
	screenShow('mpps_configuracao');

});

$('#mppButtonConfiguracaoLogout').click(function(){
  
  logout();

});

$('#mppAdicionaFracionado').click(function(){
  
  finalizarMultiComanda();
  
});


$('#mppChamaObservacao').click(function(){

	$('#mpps_observacao').css('top','0vh');

});

$('#mppObservacaoVoltar').click(function(){

	$('#mpps_observacao').css('top','150vh');

});

$('#mppFinalizarComanda').click(function(){
  
  //FIM
  
});

$('#mppFinalizarVoltar').click(function(){
  
  $('#mpps_finalizar').css('top','150vh');
  
});

$('#mppEnviaPedido').click(function(){

	enviarComanda();

})

function logout(){

	mppAjaxVar = {

		url: 'ajax/ajaxLogout'
	
	};
	
	ajaxAppRequest(mppAjaxVar,function(mpp){

		location.reload();

	});

}


function buscaListarLojas(mppSearch){

	mppAjaxVar = {

		url: '/ajax/ajaxListarLojas',
    search: mppSearch
	
	};

	ajaxAppRequest(mppAjaxVar, function(mppcat){
    
    mppprod = JSON.parse(mppcat);
    
    if(mppprod['empty'] == 'true'){
      
      document.getElementById('mpps_home').getElementsByClassName('lista')[0].innerHTML = '';
      
      mpp_div = document.createElement('p');
      mpp_div.innerText = 'Nenhum item encontrado!';
      document.getElementById('mpps_home').getElementsByClassName('lista')[0].appendChild(mpp_div);
      
      
      
    }
    else{
    
      document.getElementById('mpps_home').getElementsByClassName('lista')[0].innerHTML = '';

      for(i=0; i< mppprod.length; i++){

        mpp_div = document.createElement('div');
        mpp_div.className = 'produto padding flex mpp-loja';
        mpp_div.setAttribute('codeloja', mppprod[i].cd_loja);

        mpp_button = document.createElement('img');
        mpp_button.className = 'logo-restaurante profile';
        mpp_button.src = 'image/lojas/'+mppprod[i].nm_loja_logo;
        mpp_div.appendChild(mpp_button);


        mpp_subdiv = document.createElement('div');
        mpp_subdiv.style.paddingLeft = '20px';

        mpp_subdiv_p = document.createElement('h2');
        mpp_subdiv_p.className = 'nome-restaurante';
        mpp_subdiv_p.innerText = mppprod[i].nm_loja;

        mpp_p = document.createElement('p');
        mpp_p.className = 'tipo-restaurante text-gray';
        mpp_p.innerText = mppprod[i].ds_loja;


        mpp_star = document.createElement('p');
        mpp_star.className = 'valor-produto';
        mpp_star.innerText ="5.0⭐";


        mpp_subdiv.appendChild(mpp_subdiv_p);
        mpp_subdiv.appendChild(mpp_p);


        mpp_div.appendChild(mpp_subdiv);
        mpp_div.appendChild(mpp_star);


        document.getElementById('mpps_home').getElementsByClassName('lista')[0].appendChild(mpp_div);

      }
      
    }
    
    $('.mpp-loja').click(function(){
       
       ajaxBuscaLojaInfo(this.getAttribute('codeloja'));
      
    });
    
    
    screenShow('mpps_home');
    
    
    
  });
  
}


function ajaxBuscaLojaInfo(codeloja){
  
  mppAjaxVar = {

		url: '/ajax/ajaxBuscaLojaInfo',
    loja: codeloja
	
	};

	ajaxAppRequest(mppAjaxVar, function(mppcat){

		mpploja = JSON.parse(mppcat);
    
    mpps_loja.innerHTML += '<p>'+mpploja.nm_loja+'</p>';
    mpps_loja.innerHTML += '<p>'+mpploja.nm_loja_logo+'</p>';
    mpps_loja.innerHTML += '<p>'+mpploja.ds_loja+'</p>';
    
    screenShow('mpps_loja');
    
    
  });
  
  
  
  
}





//CONSULTAS

//FUNÇÃO RESPONSÁVEL POR BUSCAR QUAIS SÃO AS CATEGORIAS DISPONÍVEIS PARA O CLIENTE DENTRO DE UMA LOJA
function buscaCategoriasCardapio(){

	mppAjaxVar = {

		url: '/ajax/ajaxCategoriasCardapio'
	
	};

	ajaxAppRequest(mppAjaxVar, function(mppcat){

		//mppcat = mppcat;

		mppcat = JSON.parse(mppcat);

		if(mppcat == '1' || mppcat == '2'){

			//Exibir mensagem de que não foi encontrada nenhuma categoria para mostrar

		}
		else{

			document.getElementById('mpps_categoria_slide').innerHTML = '';

			for(i=0; i< mppcat.length; i++){

				//alert(mppcat[1].nm_categoria_produto+' - '+mppcat[1].nm_imagem_categoria_produto);
        
       
        
        mpp_elemento = document.createElement('div');
        mpp_elemento.className = 'mpp-categoria mpp-cat-block';
        mpp_elemento.id = mppcat[i].cd_categoria_produto;
        mpp_elemento.name = mppcat[i].qt_tamanho;
        mpp_elemento.title = mppcat[i].nm_categoria_produto;
        
        mpp_imagem = document.createElement('img');
        mpp_imagem.className = 'mpp-cat-img';
				mpp_imagem.src = mppcat[i].nm_imagem_categoria_produto;
        
        mpp_elemento.appendChild(mpp_imagem);
        
        document.getElementById('mpps_categoria_slide').appendChild(mpp_elemento);
        
// 				//CRIANDO DIV PAI
// 				mpp_elemento = document.createElement('button');
// 				mpp_elemento.className = 'mpp-categoria';
// 				mpp_elemento.id = mppcat[i].cd_categoria_produto;
//         mpp_elemento.name = mppcat[i].qt_tamanho;

// 				//ADICIONANDO IMAGEM DA CATEGORIA
// 				mpp_imagem = document.createElement('img');
// 				mpp_imagem.src = 'image/categorias/mpp_cat_pizza.png';//mppcat[i].nm_imagem_categoria_produto;

// 				//ADICIONANDO LEGENDA COM O NOME DA CATEGORIA
// 				mpp_texto = document.createElement('span');
// 				mpp_texto.innerText = mppcat[i].nm_categoria_produto;

// 				//ATRIBUÍNDO AO HAGATÊ EMIÉLI
// 				mpp_elemento.appendChild(mpp_imagem);
// 				mpp_elemento.appendChild(mpp_texto);
// 				//document.getElementById('mpps_categoria').appendChild(mpp_elemento);
        
      


			}
      
       $('.mpp-cat-slide').slick({
          dots: false,
          infinite: true,
          speed: 300,
          slidesToShow: 1,               
          prevArrow: false,
          nextArrow: false,
          centerMode: true,   
          variableWidth: true
        });
      
        slidesCount = document.getElementsByClassName('mpp-cat-block').length;

        for(i=0; i < slidesCount; i++){

           slideClasses = document.getElementsByClassName('mpp-cat-block')[i].getAttribute('class');                       

           if(slideClasses.indexOf('slick-active') != -1){

              categoria_atual = document.getElementsByClassName('mpp-cat-block')[i].getAttribute('title')

              mpp_cat_active.innerHTML = categoria_atual;

           }

        }


        $('.mpp-cat-slide').on('afterChange', function(event, slick, currentSlide, nextSlide){

          slidesCount = document.getElementsByClassName('mpp-cat-block').length;

          for(i=0; i < slidesCount; i++){
            
             slideClasses = document.getElementsByClassName('mpp-cat-block')[i].getAttribute('class');                       
                                   
             if(slideClasses.indexOf('slick-active') != -1){
                                   
                categoria_atual = document.getElementsByClassName('mpp-cat-block')[i].getAttribute('title')

                mpp_cat_active.innerHTML = categoria_atual;
                                   
             }
                                   
          }


        });

			$('.mpp-categoria').click(function(){

        if(this.name == 1){
          
				  buscaProdutosCardapio(this.id,null);
        
        }
        else{
          
          buscaTamanhoCategoria(this.id);
        
          //produto com mais de um tamanho para selecionar
        
        }

				//PRECISA FAZER TROCAR DE TELA NESSE MOMENTO

			});

		}

		

	});

	
}




function buscaTamanhoCategoria(categoria){
  
  mppAjaxVar = {
		url: '/ajax/ajaxSelecionarTamanho',
		cd_categoria_produto: categoria
	};

	ajaxAppRequest(mppAjaxVar, function(mppprod){

		mppprod = JSON.parse(mppprod);
    
    
    document.getElementById('mpps_tamanho').getElementsByClassName('lista')[0].innerHTML = '';

		for(i=0; i< mppprod.length; i++){
      
      mpp_div = document.createElement('div');
			mpp_div.className = 'produto padding flex';

			mpp_subdiv = document.createElement('div');
			mpp_subdiv.className = 'flex';

			//mpp_button = document.createElement('button');
			//mpp_button.className = 'add-gray mpp-produto';
			//mpp_button.id = mppprod[i].cd_categoria_produto;
      //mpp_button.name = mppprod[i].vl_fracao;
			//mpp_button.innerText = '+';

			mpp_subdiv_p = document.createElement('p');
			mpp_subdiv_p.className = 'nome-produto text-gray mpp-tamanho';
      mpp_subdiv_p.id = mppprod[i].cd_categoria_produto;
      mpp_subdiv_p.name = mppprod[i].vl_fracao;
      mpp_subdiv_p.content = mppprod[i].cd_tamanho;
			mpp_subdiv_p.innerText = mppprod[i].nm_tamanho;

			//mpp_p = document.createElement('p');
			//mpp_p.className = 'valor-produto';
			//mpp_p.innerText ="R$ "+mppprod[i].vl_produto;

			//mpp_subdiv.appendChild(mpp_button);
			mpp_subdiv.appendChild(mpp_subdiv_p);

			mpp_div.appendChild(mpp_subdiv);
			//mpp_div.appendChild(mpp_p);

			
			document.getElementById('mpps_tamanho').getElementsByClassName('lista')[0].appendChild(mpp_div);
      
    }
    
    screenShow('mpps_tamanho');
    
    $('.mpp-tamanho').click(function(){
      
         iniciarMultiComanda(this.name,this.content);
          
				 buscaProdutosCardapio(this.id,this.content);       

				//PRECISA FAZER TROCAR DE TELA NESSE MOMENTO

			});
    
    
    
  });
  
  
}

function buscaProdutosCardapio(categoria,tamanho){
  
	mppAjaxVar = {
		url: '/ajax/ajaxCardapioProdutos',
		cd_categoria_produto: categoria,
    cd_tamanho: tamanho
	};

	ajaxAppRequest(mppAjaxVar, function(mppprod){

		mppprod = JSON.parse(mppprod);

		document.getElementById('mpps_cardapio').getElementsByClassName('lista')[0].innerHTML = '';
    
    
    if(tamanho != null){
      
      mpp_alert = document.createElement('p');
		  mpp_alert.className = 'qt-sabores';
      mpp_alert.innerText = 'Você pode adicionar até '+mppItensMultiComandaMax+' sabores';
      document.getElementById('mpps_cardapio').getElementsByClassName('lista')[0].style.paddingTop = '28px';
      document.getElementById('mpps_cardapio').getElementsByClassName('lista')[0].appendChild(mpp_alert);
    
    }
    else{
    
      document.getElementById('mpps_cardapio').getElementsByClassName('lista')[0].style.paddingTop = '0px';
    
    }
    
		for(i=0; i< mppprod.length; i++){
      
      


			mpp_div = document.createElement('div');
			mpp_div.className = 'produto padding flex';

			mpp_subdiv = document.createElement('div');
			mpp_subdiv.className = 'flex';

			mpp_button = document.createElement('button');
			mpp_button.className = 'add-gray mpp-produto';
			mpp_button.id = mppprod[i].cd_produto;
      mpp_button.name = mppprod[i].cd_tamanho;
      mpp_button.setAttribute('valor', mppprod[i].vl_produto);
			mpp_button.innerText = '+';

			mpp_subdiv_p = document.createElement('p');
			mpp_subdiv_p.className = 'nome-produto text-gray';
			mpp_subdiv_p.innerText = mppprod[i].nm_produto;

			mpp_p = document.createElement('p');
			mpp_p.className = 'valor-produto';
			mpp_p.innerText ="R$ "+mppprod[i].vl_produto;

			mpp_subdiv.appendChild(mpp_button);
			mpp_subdiv.appendChild(mpp_subdiv_p);

			mpp_div.appendChild(mpp_subdiv);
			mpp_div.appendChild(mpp_p);

			
			document.getElementById('mpps_cardapio').getElementsByClassName('lista')[0].appendChild(mpp_div);


			/*mpp_elemento = document.createElement('button');
			mpp_elemento.className = 'mpp-produto';
			mpp_elemento.id = mppprod[i].cd_produto;

			mpp_produto = document.createElement('span');
			mpp_produto.innerText = mppprod[i].nm_produto;

			mpp_valor = document.createElement('span');
			mpp_valor.innerText = "R$ "+mppprod[i].vl_produto;

			mpp_elemento.appendChild(mpp_produto);
			mpp_elemento.appendChild(mpp_valor);

			document.getElementById('mpps_cardapio').appendChild(mpp_elemento);*/

		}

		screenShow('mpps_cardapio');

		$('.mpp-produto').click(function(){
      
			if(MPP_CTRL_MULTI == 0){

				adicionarNaComanda(this.id, this.name);

			}
			else{
                
				adicionarMultiComanda(this.id);

			}

			//PRECISA FAZER TROCAR DE TELA NESSE MOMENTO

		});
    
    

		


	});

	

}


function buscaDadosComanda(){

	atualizarValorComanda();

	mppAjaxVar = {
		
		url: '/ajax/ajaxBuscaDadosComanda'

	};

	ajaxAppRequest(mppAjaxVar, function(mppcomanda){

		mppcomanda = JSON.parse(mppcomanda);
		
		

		mpp_ridder = document.createElement('div');
		mpp_ridder.id = 'ridder';

		for(i=0; i< mppcomanda.length; i++){

			//alert(mppcat[1].nm_categoria_produto+' - '+mppcat[1].nm_imagem_categoria_produto);

			//CRIANDO DIV PAI
			


			///DIVISA
			

			/*mpp_item = document.createElement('div');
			mpp_item.className = 'mpp-item-comanda';
			mpp_item.id = mppcomanda[i].cd_categoria_produto;

			

			//ADICIONANDO LEGENDA COM O NOME DA CATEGORIA
			mpp_categoria = document.createElement('span');
			mpp_categoria.innerText = mppcomanda[i].nm_categoria_produto;*/

			/*mpp_produto = document.createElement('span');
			mpp_produto.innerText = mpp_item_produto;

			mpp_valor = document.createElement('span');
			mpp_valor.innerText = mppcomanda[i].vl_item;*/


			//ATRIBUÍNDO AO HAGATÊ EMIÉLI
			/*mpp_item.appendChild(mpp_categoria);
			mpp_item.appendChild(mpp_produto);
			mpp_item.appendChild(mpp_valor);*/

			mpp_div = document.createElement('div');
			mpp_div.className = 'produto padding flex';

			mpp_subdiv = document.createElement('div');
			mpp_subdiv.className = 'flex';

			mpp_button = document.createElement('button');
			mpp_button.className = 'add-gray';
			mpp_button.id = mppcomanda[i].cd_categoria_produto;
			mpp_button.innerText = mppcomanda[i].qt_produto;

			mpp_subdiv_p = document.createElement('p');
			mpp_subdiv_p.className = 'nome-produto text-gray';
			mpp_subdiv_p.innerText = mppcomanda[i].nm_categoria_produto+' '+mppcomanda[i].nm_produto;

			mpp_p = document.createElement('p');
			mpp_p.className = 'valor-produto';
			mpp_p.innerText ="R$ "+mppcomanda[i].vl_item;

			mpp_subdiv.appendChild(mpp_button);
			mpp_subdiv.appendChild(mpp_subdiv_p);

			mpp_div.appendChild(mpp_subdiv);
			mpp_div.appendChild(mpp_p);

			
			

			if(mppcomanda[i].cd_item_status == 0){

				//ITEM AINDA NÃO FOI SOLCITADO ENTÃO PODE EXIBIR O BOTÃO DE DELETAR
				mpp_botao_delete = document.createElement('button');
				mpp_botao_delete.className = 'mpp-botao-delete close-red';
				mpp_botao_delete.innerText = 'X';
				mpp_botao_delete.id = mppcomanda[i].cd_item;

				mpp_div.appendChild(mpp_botao_delete);		

			}
			else{

				//EXIBIR QUE ITEM JÁ FOI SOLICITADO
				mpp_solicitado = document.createElement('span');
				mpp_solicitado.className = 'checked-green';
				mpp_solicitado.innerText = '✓';

				mpp_div.appendChild(mpp_solicitado);	

			}



			//document.getElementById('mpps_comanda').appendChild(mpp_item);

			mpp_ridder.appendChild(mpp_div);

		}

		
		document.getElementById('mpps_comanda').getElementsByClassName('lista')[0].innerHTML = mpp_ridder.innerHTML;

		


		$('.mpp-botao-delete').click(function(){

			removerItemComanda(this.id);

			//PRECISA FAZER TROCAR DE TELA NESSE MOMENTO

		});

		//$('#'+screen).css('display','flex');

	});

}



function atualizarValorComanda(){

	mppAjaxVar = {
		
		url: '/ajax/ajaxBuscaValorComanda'

	};

	ajaxAppRequest(mppAjaxVar, function(mppvalor){

		mpp_valor = JSON.parse(mppvalor);

		if(mpp_valor['valor'] > 0){

			mpp_valor_comanda.innerText = 'R$ '+mpp_valor['valor'];

		}
		else{

			mpp_valor_comanda.innerText = 'R$ 0,00';

		}

		exibirBotaoEnvioPedido(mpp_valor['pendentes']);

	});	

}

function enviarComanda(){

	mppAjaxVar = {

		url: '/ajax/ajaxEnviarComanda',
		ds_comanda: mppTextObservacao.value

	}

	ajaxAppRequest(mppAjaxVar, function(){

		buscaDadosComanda();    
		screenShow('mpps_comanda');
    $('#mpps_observacao').css('top','150vh');

	});

}


function finalizarComanda(){

	mppAjaxVar = {

		url: '/ajax/ajaxFinalizarComanda'

	}

	ajaxAppRequest(mppAjaxVar, function(){

		screenShow('mpps_home');

	});

}


function removerItemComanda(item){

	mppAjaxVar = {

		url: '/ajax/ajaxRemoverItemComanda',
		cd_item: item

	}

	ajaxAppRequest(mppAjaxVar, function(mppcomanda){

		buscaDadosComanda();

	});


}



function adicionarNaComanda(produto,tamanho){

	mppAjaxVar = {
		url: '/ajax/ajaxAdicionarNaComanda',
		cd_produto: produto,
    cd_tamanho: tamanho,
		ic_multi: MPP_CTRL_MULTI
	};

	ajaxAppRequest(mppAjaxVar, function(){

    MPP_CTRL_MULTI = 0;
    
		buscaDadosComanda();

		atualizarValorComanda();

	});

}


function iniciarMultiComanda(qtProdutos,tamanho){

	
	mppItensMultiComanda = 0;
	mppItensMultiComandaMax = qtProdutos;
  mppItemTamanho = tamanho;
	MPP_CTRL_MULTI = 1;

}

function adicionarMultiComanda(produto){
  
  
  
  if(mppMultiComanda.indexOf(produto) != -1){
    
    document.getElementById(produto).className = 'add-gray mpp-produto';
    document.getElementById(produto).innerText = '+';
    removerMultiComanda(produto);
  
    
  }
  else{
    
    if(mppItensMultiComanda == mppItensMultiComandaMax){
      
      alert('Você já adicionou a quantidade máxima de produtos');
      
    }
    else{
      
      document.getElementById(produto).className = 'remove-gray mpp-produto';
      document.getElementById(produto).innerText = '-';

      mppMultiComanda[mppItensMultiComanda] = produto;
      mppItensMultiComanda++;
      

//       if(mppItensMultiComanda == mppItensMultiComandaMax){

//         preFinalizarMultiComanda();

//       }
    }
  }
  
  exibirBotaoFracao();

}

function removerMultiComanda(item){

  posit = mppMultiComanda.indexOf(item);
	mppMultiComanda.splice(posit,1);
	mppItensMultiComanda--;	

}


function exibirBotaoFracao(){
  
  if(mppMultiComanda.length > 0){
    
    $(".mpps").css("height", "calc(100vh - 17vh - 20px)");
    mppChamaObservacao.style.bottom = '-21vh';	
    
    mppAdicionaFracionado.innerHTML = 'Adicionar ao Pedido';
    $(".mpps").css("height", "calc(100vh - 25vh - 20px)");	
    mppAdicionaFracionado.style.bottom = '8vh';
    
  }
  else{
    
    $(".mpps").css("height", "calc(100vh - 17vh - 20px)");
    mppAdicionaFracionado.style.bottom = '-21vh';    
    atualizarValorComanda();
    
  }
  
}



function finalizarMultiComanda(){
  
	mppMultiProduto = '';
  
  if(mppMultiComanda.length == 1){
    
    MPP_CTRL_MULTI = 0;
    
  }

	for(i=0; i < mppItensMultiComandaMax; i++){

		mppMultiProduto += mppMultiComanda[i]+";";

	}
  
  mppMultiComanda = new Array();
  exibirBotaoFracao();
  screenShow('mpps_tamanho');

	
	adicionarNaComanda(mppMultiProduto,mppItemTamanho);
  
}

function hash(){

	if(location.hash != localStorage.getItem('MPP_LAST_SCREEN')){


		mpp_sep = location.hash.split('#');
		mpp_hash = mpp_sep[1];
		screenShow(mpp_hash);

	}
}


function exibirBotaoEnvioPedido(itens){

    if(itens > 0){

      if(itens == 1){

        text = 'Enviar 1 item pendente';

      }
      else{

        text = 'Enviar '+itens+' itens pendentes';

      }

      $(".mpps").css("height", "calc(100vh - 25vh - 20px)");		
      mppChamaObservacao.innerHTML = text;
      mppChamaObservacao.style.bottom = '8vh';

    }
    else{

      $(".mpps").css("height", "calc(100vh - 17vh - 20px)");
      mppChamaObservacao.style.bottom = '-21vh';		

    }
  

}


$('body').click(function(){

	//openFullscreen();

})


var elem = document.documentElement;
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}

function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  }
}

function initCar(){
  
  alert('bla');
  
  $('.your-class').slick({
          dots: false,
          infinite: true,
          speed: 300,
          slidesToShow: 1,
          centerMode: true,
          prevArrow: false,
          nextArrow: false,
          variableWidth: true
        });
  
}

//MPP HOME
$('#mppHomeSearch').keyup(function(){
  
  buscaListarLojas(mppHomeSearch.value);
  
});

