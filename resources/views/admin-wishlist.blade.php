<style>
  
  .mpp-admin-screen{
    
    display: flex;
    width: 100vw;
    background-color: #fff;
    
  }
  
  #mpp_admin_wishlist{
    display: flex;
    width: 100vw;
    background-color: #fff;

  }
  
  #mpp_wishlist_left{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    width: 70vw;
    height: 90vh;
    background-color: #fff;
  }

  #mpp_wishlist_right{
    width: 30vw;
    height: 100vh;
    background-color: #eee;
  }
  
  .mpp-wishlist-item{
      display: flex;
      justify-content: normal;
      flex-direction: column;
      padding: 20px;
      border-bottom: 1px solid #ddd;
  }
  
  .mpp-wish-card-name{
    font-size: 1em;
    font-weight: bold;
    color: #777;
  }
  .mpp-wish-description{
      text-overflow: ellipsis;
      width: 70%;
      white-space: nowrap;
      overflow: hidden;
      font-size: 0.8em;
      color: #777;
  }
  
  #mpp_wish_comanda{
      font-weight: bold;
      color: #333;
      font-size: 1em;
      margin-top: 20px;
  }
  
  #mpp_card_name{
     font-weight: bold;
     font-size: 2em;
     color: orange;
  }   
  
  #mpp_wish_desc{
    text-align: center;
    height: 60px;
    font-size: 1em;
  }
  
  #mpp_wish{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    height: 50vh;
    margin-top: 10vh;
    margin-bottom: 10vh;
  }
  
  .mpp-span-list{
    font-size: 1.3em;
    color: #333;
    text-align: center;
   }
  
  #mpp_btn_wishlist_pronto{
    display: none;
    font-size: 1em;
    color: #fff;
    padding: 20px;
    border: 0px;
    width: 200px;
    background: linear-gradient(#F66F00, #F35B17);
  }
</style>
<div class='mpp-admin-screen' id='mpp_wishlist'>
  
  <div id='mpp_admin_wishlist'>

    <div id='mpp_wishlist_left'>

        <span class='mpp_span_subtitle' id='mpp_wish_comanda'>#98765</span>
        <span class='mpp_span_title' id='mpp_card_name'>Mesa 05</span>
        <span class='mpp_span_title' id='mpp_wish_desc'>Sem cebola</span>

        <div class='mpp-list' id='mpp_wish'>
            <span class='mpp-span-list'>1 Item pedido</span>
            <span class='mpp-span-list'>2 Itens pedidos</span>
            <span class='mpp-span-list'>3 Itens pedidos</span>
        </div>

        <input type='button' value='Pronto!' id='mpp_btn_wishlist_pronto'>


    </div>
    
    <div id='mpp_wishlist_right'>
      
    </div>

  </div>
  
</div>