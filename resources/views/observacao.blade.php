<style>
  
  .mpp-screen-block{
      
    flex-wrap: wrap;
    justify-content: center;
    flex-direction: column;
    background-color: #eee!important;
  }
  
  
  .mpp-screen-title{
    
    display: block;
    font-size: 2em;
    width: 100%;
    text-align: center;
    font-family: impact;
    color: #f56a05;
    margin-top: 20px;
    margin-bottom: 20px;
  
  }
  
  .mpp-screen-desc{
    
    display: block;
    width: 80%;
    color: #333;
    text-align: center;
    margin-top: 20px;
    margin-bottom: 20px;
  
  }
  
  .mpp-preco{
    
    display: block;
    width: 80%;
    color: #333;
    text-align: center;
    margin-top: 20px;
    margin-bottom: 20px;
    font-size: 2em;
  
  }
  
  .mpp-observacao-txt{
    
    display: block;
    width: 80%;
    padding: 5%;
    border: 1px solid #eee;
    margin-top: 20px;
    margin-bottom: 20px;
  }
  
  .mpp-btn-enviar{
    display: block;
    width: 90%;
    padding: 3vh;
    background-color: #f56a05;
    border: 0px;
    color: #fff;
    text-transform: uppercase;
    font-family: impact;
    font-size: 1.3em;
    margin-top: 20px;
    border-radius: 30px;
    
  }
  
  .mpp-btn-voltar{
    display: block;
    width: 90%;
    padding: 3vh;
    background-color: #999;
    border: 0px;
    color: #fff;
    text-transform: uppercase;
    font-family: impact;
    font-size: 1.3em;
    margin-top: 20px;
    border-radius: 30px;
    
  }

</style>


<div id='mpps_observacao' class='mpps mpp-screen-block' align='center' style='display: flex;
    min-height: 100vh!important;
    width: 100vw;
    z-index: 9996;
    background-color: gray;
    position: fixed;
    top: 150vh; transition: 0.7s'>
	
    <span class='mpp-screen-title'>Ui, ele não gosta de picles!</span>
    <span class='mpp-screen-desc'>Escreva abaixo alguma observação sobre o seu pedido, caso necessário...</span>
		
    <textarea class='mpp-observacao-txt' name="" placeholder="Adicione uma observação sobre o seu pedido..." id="mppTextObservacao" cols="30" rows="10"></textarea>
		
    <button class='mpp-btn-enviar' id='mppEnviaPedido'>Enviar</button>
    <button class='mpp-btn-voltar' id='mppObservacaoVoltar'>Ver comanda</button>
		
</div>