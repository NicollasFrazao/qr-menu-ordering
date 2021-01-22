$('#mpp_btn_login').click(function(){
  
  mpp_user = mpp_txt_admin_login.value;
  mpp_pass = mpp_txt_admin_senha.value;
  
  mppAjaxVar = {

		url: '/ajax/ajaxAdminLogin',
    user: mpp_user,
    pass: mpp_pass
	
	};

	ajaxAppRequest(mppAjaxVar, function(mpp){

		mpp = JSON.parse(mpp);
    
    if(mpp.login == 'true'){
      
      // LOGIN VÁLIDO
      
      $('#mpp_admin_login').css('display','none');
      
      loadScreens();
      
    }
    else{
      
      // LOGIN INVÁLIDO
      alert('invalido');
    }    
    
  });

});


function loadScreens(){
  
  mppAjaxVar = {

		url: '/ajax/ajaxLoadScreens'
	
	};

	ajaxAppRequest(mppAjaxVar, function(mpp){

		mpp = JSON.parse(mpp);
    
    if(mpp != ''){
      
      
      
      mpp_admin_screens.innerHTML = '';
      
      //LOAD PAGES
      for(i=0; i< mpp.length; i++){
        
         mpp_admin_screens.innerHTML += mpp[i].estrutura;
        
      }
      
      mpp_modules.innerHTML = '';
      
      //LOAD ICONS
      for(i=0; i< mpp.length; i++){
        
        mpp_modulo = document.createElement('div');
        mpp_modulo.title = mpp[i].nm_modulo;
        mpp_modulo.className = 'mpp-module-button';

        mpp_modulo_imagem = document.createElement('img');
        mpp_modulo_imagem.src = 'image/modulos/'+mpp[i].nm_modulo_logo;

        mpp_modulo_titulo = document.createElement('span');
        mpp_modulo_titulo.innerText = mpp[i].nm_modulo;

        mpp_modulo.appendChild(mpp_modulo_imagem);
        mpp_modulo.appendChild(mpp_modulo_titulo);

        mpp_modules.appendChild(mpp_modulo);
        
      }
      
      $('.mpp-module-button').click(function(){
        
        showScreen(this.title);
        
      });
      
    }
    else{
      
      alert('nenhum modulo disponivel');
      
    }
    
  });

}


function showScreen(screen){
  
  // LIMPA TELA
  
  clearScreen();
  
  if(screen == 'Wishlist'){
    
    wishlistComponents();
    // EXECUTA LONGPOOLING
    startLongPollingWishlist();
    // DISPLAY NA TELA
    $('#mpp_wishlist').css('display','flex');
    
  }
  
}

function clearScreen(){
  
  $('#mpp_admin_login').css('display','none');
  $('#mpp_modules').css('display','none');
  $('#mpp_wishlist').css('display','none');
  
}

function wishlistComponents(){
  
  $('#mpp_btn_wishlist_pronto').click(function(){
  
    comanda = mpp_btn_wishlist_pronto.getAttribute('data-comanda');

    if(comanda != ''){

      pedidoPronto(comanda);

    }

  });
  
}


function startLongPollingWishlist(){
  
  mppAjaxVar = {

		url: '/ajax/ajaxLongPollingWishlist',
    command: 'start'
	
	};

	ajaxAppRequest(mppAjaxVar, function(mpp){
    
    if(mpp == ''){ 
      
      startLongPollingWishlist();
      
    }
    else if(mpp == 'stop'){
      // PARA A EXECUÇÃO DO LONGPOOLING
    }
    else{
      
      mpp = JSON.parse(mpp);
      
      
      for(i=0; i < mpp.length; i++){
        
        // criar estrutura
        mpp_item = document.createElement('div');
        mpp_item.className = 'mpp-wishlist-item';
        
        mpp_item.setAttribute('data-comanda', mpp[i].cd_comanda);
        mpp_item.setAttribute('data-card', mpp[i].nm_card);
        mpp_item.setAttribute('data-obs', mpp[i].ds_comanda);

        mpp_item_title = document.createElement('span');
        mpp_item_title.innerText = mpp[i].nm_card;
        mpp_item_title.className = 'mpp-wish-card-name';
        
        mpp_item_subtitle = document.createElement('span');
        mpp_item_subtitle.innerText = mpp[i].ds_comanda;
        mpp_item_subtitle.className = 'mpp-wish-description';

        mpp_item.appendChild(mpp_item_title);
        mpp_item.appendChild(mpp_item_subtitle);

        mpp_wishlist_right.appendChild(mpp_item);
      
      }
      
      $('.mpp-wishlist-item').click(function(){
        
          infoComandaWishlist(this.getAttribute('data-comanda'), this.getAttribute('data-card'), this.getAttribute('data-obs'));
        
      });
      
      mpp_btn_wishlist_pronto.style.display = 'flex'; 
      $('.mpp-wishlist-item')[0].click();
      
    }		
    
  });
  
}


function infoComandaWishlist(comanda, card, obs){
  
  mpp_wish_comanda.innerHTML = 'PEDIDO #'+comanda;
  mpp_card_name.innerHTML = card;
  mpp_wish_desc.innerHTML = obs;
  mpp_btn_wishlist_pronto.setAttribute('data-comanda', comanda);
  mpp_wish.innerHTML = "";
  mppAjaxVar = {

		url: '/ajax/ajaxInfoComandaWishlist',
    comanda: comanda
	
	};

	ajaxAppRequest(mppAjaxVar, function(mpp){
    
     // CAMPOS QUE SERÃO ALTERADOS NA TELA
     mpp = JSON.parse(mpp);
    
     for(i=0; i < mpp.length; i++){
      
        mpp_item_title = document.createElement('span');
        mpp_item_title.innerText = mpp[i].qt_produto+' '+mpp[i].nm_categoria_produto+' '+mpp[i].nm_produto;
        mpp_item_title.className = 'mpp-span-list';
       
        mpp_wish.appendChild(mpp_item_title);       
       
     }
    
  });
  
}

function pedidoPronto(comanda){
  
  mppAjaxVar = {

		url: '/ajax/ajaxAlteraStatusComanda',
    status: 2,
    comanda: comanda
	
	};

	ajaxAppRequest(mppAjaxVar, function(mpp){
     
     limpaWishlist();
     startLongPollingWishlist();
    
  });
  
}




function limpaWishlist(){
  
  mpp_btn_wishlist_pronto.style.display = 'none';
  mpp_wish_comanda.innerHTML = '';
  mpp_card_name.innerHTML = '';
  mpp_wish_desc.innerHTML = '';
  mpp_wish.innerHTML = '';
  mpp_btn_wishlist_pronto.setAttribute('data-comanda', '');
  
  mpp_wishlist_right.innerHTML = '';
  
}
