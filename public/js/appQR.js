function startQR(){

    appReturn = "";

    let scanner = new Instascan.Scanner({ video: document.getElementById('mppQRCapture'), mirror: false, scanPeriod: 1, backgroundScan: true});
    
    scanner.addListener('scan', function (content) {
      readQR(content);
    });
    Instascan.Camera.getCameras().then(function (cameras) {
      if (cameras.length > 0) {
        scanner.start(cameras[1]);
      } else {
        console.error('No cameras found.');
      }
    }).catch(function (e) {
      console.error(e);
    });
      
    $('#mppQrReturnButton').click(function(){

     scanner.stop();
     screenShow('mpps_home');

    });
  
    mpps_qr.style.display = 'inline';

}


function readQR(content){

  
    if(appReturn == ''){
        
      mppAjaxVar = {
        url: '/ajax/ajaxScanCode',
        scancode: content
      };

      ajaxAppRequest(mppAjaxVar, function(mpp){
        
        appReturn = mpp;

        
        
        if(appReturn == 1){
          

           mppAjaxVar = {

            url: '/ajax/ajaxGetSession'

          }

          ajaxAppRequest(mppAjaxVar, function(mpp){
    
            appSession = JSON.parse(mpp);

            atualizarValorComanda();

            $("#mppBarQR").addClass("mppHide");
            $("#mppBarPedido").removeClass("mppHide");
            $("#mppBarCardapio").removeClass("mppHide");
            $("#mppBarFinalizar").removeClass("mppHide");

            mppLogoLoja.src = 'image/lojas/'+appSession['nm_loja_logo'];
            mppNomeLoja.innerHTML = appSession['nm_loja'];
            mppDescLoja.innerHTML = appSession['ds_loja'];
          
            buscaCategoriasCardapio();
            screenShow("mpps_categoria");

          });

        }
        else{

            
        }
      
      });

    }

}

function readQRType(){

  
    if(appReturn == ''){
        
      mppAjaxVar = {
        url: '/ajax/ajaxScanCodeType',
        scancode: mppQRCodeInput.value,
        scancode_name: mppQRCardInput.value
      };

      ajaxAppRequest(mppAjaxVar, function(mpp){
        
        appReturn = mpp;

        
        
        if(appReturn == 1){
          

           mppAjaxVar = {

            url: '/ajax/ajaxGetSession'

          }

          ajaxAppRequest(mppAjaxVar, function(mpp){
    
            appSession = JSON.parse(mpp);

            atualizarValorComanda();

            $("#mppBarQR").addClass("mppHide");
            $("#mppBarPedido").removeClass("mppHide");

            mppLogoLoja.src = 'image/lojas/'+appSession['nm_loja_logo'];
            mppNomeLoja.innerHTML = appSession['nm_loja'];
            mppDescLoja.innerHTML = appSession['ds_loja'];
          
            buscaCategoriasCardapio();
            screenShow("mpps_categoria");

          });

        }
        else{

            
        }
      
      });

    }

}

$('#mppQRTypeButton').click(function(){
  
  readQRType();
  
});