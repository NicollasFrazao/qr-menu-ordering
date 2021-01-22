<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class AjaxController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    

    public function ajaxGetSession(){

        $selectSession = DB::connection('mpp')
        ->table('tb_usuario')
        ->leftJoin('tb_comanda','tb_comanda.cd_usuario','=','tb_usuario.cd_usuario')
        ->leftJoin('tb_card','tb_card.cd_card','=','tb_comanda.cd_card')
        ->where('tb_usuario.cd_usuario','=',Session::get('CD_USUARIO'))
        ->select(
            'nm_usuario',
            'nm_email',
            'tb_usuario.cd_usuario',
            'nm_foto',
            'tb_card.cd_loja',
            'cd_comanda')
        ->get();

        if(count($selectSession) > 0){
            
            $selectComanda = DB::connection('mpp')
            ->table('tb_comanda')
            ->leftJoin('tb_card','tb_card.cd_card','=','tb_comanda.cd_card')
            ->leftJoin('tb_loja','tb_loja.cd_loja','=','tb_card.cd_loja')
            ->where('cd_usuario','=',$selectSession[0]->cd_usuario)
            ->where('cd_comanda_status','<>','4')
            ->select(
                'cd_comanda',
                'tb_loja.cd_loja',
                'ds_loja',
                'nm_loja_logo',
                'nm_loja',
                'ds_comanda')
            ->get();

            $comanda = '';

            $nm_loja = '';
            $nm_loja_logo = '';
            $ds_loja = '';
            $ds_comanda = '';

            if(count($selectComanda) > 0){

                if($selectComanda[0]->cd_comanda != ''){
            
                    Session::put('CD_COMANDA',$selectComanda[0]->cd_comanda);
                    Session::put('CD_LOJA',$selectComanda[0]->cd_loja);

                    $comanda = $selectComanda[0]->cd_comanda;

                    $nm_loja = $selectComanda[0]->nm_loja;
                    $nm_loja_logo = $selectComanda[0]->nm_loja_logo;
                    $ds_loja = $selectComanda[0]->ds_loja;
                    $ds_comanda = $selectComanda[0]->ds_comanda;
            
                }
            }


            $app = array(
                "nm_usuario" => $selectSession[0]->nm_usuario,
                "nm_email" => $selectSession[0]->nm_email,
                "nm_foto" => $selectSession[0]->nm_foto,
                "cd_usuario" => $selectSession[0]->cd_usuario,
                "cd_comanda" => $comanda,
                "cd_loja" => $selectSession[0]->cd_loja,
                "ds_loja" => $ds_loja,
                "nm_loja" => $nm_loja,
                "nm_loja_logo" => $nm_loja_logo,
                "ds_comanda" => $ds_comanda
            );


            return json_encode($app);

        }


    }

    public function ajaxScanCode(Request $request){

        $scan = $request->all(); 

        $scan = json_decode($scan['parameters'],false);

    	if(!Session::get('CD_COMANDA')){

        	$selectQR = DB::connection('mpp')
        	->table('tb_card')
        	->where('nm_qrcode_card',$scan->scancode)
        	->get();

        	if(count($selectQR) > 0){

        		$appReturn = '1';

                $comanda = DB::connection('mpp')
                ->table('tb_comanda')
                ->insertGetId([
                    'cd_card' => $selectQR[0]->cd_card,
                    'cd_usuario' => Session::get('CD_USUARIO'),
                    'dt_comanda_inicio' => date('Y-m-d H:i:s')
                ]);

                Session::put('CD_COMANDA',$comanda);
                Session::put('CD_LOJA',$selectQR[0]->cd_loja);

        	}
        	else{

        		$appReturn = '';

        	}

        }
        else{

            if(!Session::get('CD_LOJA')){

                $selectQR = DB::connection('mpp')
                ->table('tb_card')
                ->where('nm_qrcode_card',$scan->scancode)
                ->get();

                if(count($selectQR) > 0){

                    Session::put('CD_LOJA',$selectQR[0]->cd_loja);

                }
                else{

                    $appReturn = '';

                }

            }
            else{

                $appReturn = '';

            }

        }

        return $appReturn;

    }
  
  
   public function ajaxScanCodeType(Request $request){

        $scan = $request->all(); 

        $scan = json_decode($scan['parameters'],false);

    	if(!Session::get('CD_COMANDA')){

        	$selectQR = DB::connection('mpp')
        	->table('tb_card')
        	->where('nm_qrcode_card',$scan->scancode)
          ->where('nm_card',$scan->scancode_name)
        	->get();

        	if(count($selectQR) > 0){

        		$appReturn = '1';

                $comanda = DB::connection('mpp')
                ->table('tb_comanda')
                ->insertGetId([
                    'cd_card' => $selectQR[0]->cd_card,
                    'cd_usuario' => Session::get('CD_USUARIO'),
                    'dt_comanda_inicio' => date('Y-m-d H:i:s')
                ]);

                Session::put('CD_COMANDA',$comanda);
                Session::put('CD_LOJA',$selectQR[0]->cd_loja);

        	}
        	else{

        		$appReturn = '';

        	}

        }
        else{

            if(!Session::get('CD_LOJA')){

                $selectQR = DB::connection('mpp')
                ->table('tb_card')
                ->where('nm_qrcode_card',$scan->scancode)
                ->where('nm_card',$scan->scancode_name)
                ->get();

                if(count($selectQR) > 0){

                    Session::put('CD_LOJA',$selectQR[0]->cd_loja);

                }
                else{

                    $appReturn = '';

                }

            }
            else{

                $appReturn = '';

            }

        }

        return $appReturn;

    }
  
  
    public function ajaxListarLojas(Request $request){

      $mpp_loja = $request->all(); 

      $mpp_loja = json_decode($mpp_loja['parameters'],false);
      
      
      if($mpp_loja->search == ''){
      
        $selectLojas = DB::connection('mpp')
        ->table('tb_loja')
        ->get();
        
      }
      else{
        
        $selectLojas = DB::connection('mpp')
        ->table('tb_loja')
        ->where('nm_loja','like','%'.$mpp_loja->search.'%')
        ->orWhere('ds_loja','like','%'.$mpp_loja->search.'%')
        ->orWhere('ds_loja','like','%'.$mpp_loja->search.'%')
        ->get();
        
      }
        
      if(count($selectLojas) > 0){
        
        $counter = 0;
        
        foreach($selectLojas as $mpp_sl){
          
            $lojas[$counter]['cd_loja'] = $mpp_sl->cd_loja;  
            $lojas[$counter]['nm_loja'] = $mpp_sl->nm_loja;  
            $lojas[$counter]['nm_loja_logo'] = $mpp_sl->nm_loja_logo;
            $lojas[$counter]['ds_loja'] = $mpp_sl->ds_loja;
          
            $counter++;
          
        }
        
        //$lojas['empty'] = false;
        
      }
      else{
        
        $lojas['empty'] = 'true';
      }
      
      return json_encode($lojas);
      
    }
  
  
    public function ajaxBuscaLojaInfo(Request $request){
      
      $mpp_loja = $request->all(); 

      $mpp_loja = json_decode($mpp_loja['parameters'],false);
      
      $selectLoja = DB::connection('mpp')
      ->table('tb_loja')
      ->where('cd_loja','=',$mpp_loja->loja)
      ->get();
      
      if(count($selectLoja) > 0){
        
        foreach($selectLoja as $mpp_sl){
          
          $loja['nm_loja'] = $mpp_sl->nm_loja;
          $loja['nm_loja_logo'] = $mpp_sl->nm_loja_logo;
          $loja['ds_loja'] = $mpp_sl->ds_loja;
          
        }
        
      }
      
      return json_encode($loja);

    }

    public function ajaxGlobalCategoriasCardapio(Request $request){

        echo Session::get('CD_LOJA');

    }


    public function ajaxCategoriasCardapio(Request $request){

        if(Session::get('CD_LOJA')){

            $selectCategorias = DB::connection('mpp')
            ->table('tb_loja_categoria')
            ->join('tb_categoria_produto','tb_loja_categoria.cd_categoria_produto','=','tb_categoria_produto.cd_categoria_produto')
            //->join('tb_produto','tb_categoria_produto.cd_categoria_produto','=','tb_produto.cd_categoria_produto')
            ->where('tb_loja_categoria.cd_loja','=',Session::get('CD_LOJA'))
            ->select(
              'tb_categoria_produto.cd_categoria_produto',
              'nm_categoria_produto',
              'nm_imagem_categoria_produto',
              DB::raw('count(*) as qt_tamanho')
            )
            ->groupBy('tb_loja_categoria.cd_categoria_produto')
            ->get();

            if(count($selectCategorias) > 0){

                $counter = 0;

                foreach($selectCategorias as $mpp_sc){

                    $categorias[$counter]['cd_categoria_produto'] = $mpp_sc->cd_categoria_produto;
                    $categorias[$counter]['nm_categoria_produto'] = $mpp_sc->nm_categoria_produto;
                    $categorias[$counter]['nm_imagem_categoria_produto'] = $mpp_sc->nm_imagem_categoria_produto;
                    $categorias[$counter]['qt_tamanho'] = $mpp_sc->qt_tamanho;

                    $counter++;
                }

            }
            else{

                //SEM CATEGORIA PARA MOSTRAR
                $categorias = Session::get('CD_LOJA');

            }

        }
        else{

            //ERRO DE SESSÃO NÃO IDENTIFICADA
            $categorias = '2';

        }


        return json_encode($categorias);



    }


    public function ajaxCardapioProdutos(Request $request){

        //função que trás os dados do cardápio

        $mpp_cardapio = $request->all(); 
        $mpp_cardapio = json_decode($mpp_cardapio['parameters'],false);

        $selectCardapio = DB::connection('mpp')
        ->table('tb_produto')
        ->join('tb_valor','tb_valor.cd_produto','=','tb_produto.cd_produto')
        ->leftJoin('tb_tamanho','tb_tamanho.cd_tamanho','=','tb_valor.cd_tamanho')
        ->where('cd_loja','=',Session::get('CD_LOJA'))
        ->where('cd_categoria_produto','=',$mpp_cardapio->cd_categoria_produto)
        ->where('tb_valor.cd_tamanho','=',$mpp_cardapio->cd_tamanho)
        ->select(
          'tb_produto.cd_produto',
          'nm_produto',
          'vl_produto',
          'nm_tamanho',
          'tb_valor.cd_tamanho'
        )
        ->get();

        if(count($selectCardapio) > 0){

            $counter = 0;

            foreach($selectCardapio as $mpp_sc){
                 
                $produtos[$counter]['cd_produto'] = $mpp_sc->cd_produto;
              
                if($mpp_sc->nm_tamanho != null){
                  
                  $produtos[$counter]['nm_produto'] = $mpp_sc->nm_produto;
                  //$produtos[$counter]['nm_produto'] = $mpp_sc->nm_produto.' ('.$mpp_sc->nm_tamanho.')';
                  
                }
                else{
                  
                  $produtos[$counter]['nm_produto'] = $mpp_sc->nm_produto;
                
                }
                
                $produtos[$counter]['vl_produto'] = $mpp_sc->vl_produto;
                $produtos[$counter]['cd_tamanho'] = $mpp_sc->cd_tamanho;
                //$produtos[$counter]['vl_produto_2'] = $mpp_sc->vl_produto_2;
                //$produtos[$counter]['vl_produto_3'] = $mpp_sc->vl_produto_3;
                //$produtos[$counter]['vl_produto_4'] = $mpp_sc->vl_produto_4;

                $counter++;

            }

        }
        else{

            $produtos = '';

        }

        return json_encode($produtos);

    }
  
  
    public function ajaxSelecionarTamanho(Request $request){
        
        $mpp_produto = $request->all(); 
        $mpp_produto = json_decode($mpp_produto['parameters'],false);
      
        $selectTamanhos = DB:: connection('mpp')
        ->table('tb_loja_categoria')
        ->join('tb_categoria_produto','tb_categoria_produto.cd_categoria_produto','=','tb_loja_categoria.cd_categoria_produto')
        ->join('tb_tamanho','tb_tamanho.cd_tamanho','=','tb_loja_categoria.cd_tamanho')
        ->join('tb_valor','tb_valor.cd_tamanho','=','tb_loja_categoria.cd_tamanho')
        ->where('cd_loja','=',Session::get('CD_LOJA'))
        ->where('tb_loja_categoria.cd_categoria_produto','=',$mpp_produto->cd_categoria_produto)
        ->select(
          'tb_tamanho.cd_tamanho',
          'nm_tamanho',
          'tb_loja_categoria.cd_categoria_produto',
          'vl_fracao'
        )
        ->groupBy('tb_loja_categoria.cd_tamanho')
        ->get();
      
        if(count($selectTamanhos) > 0){
          
          $counter = 0;
          
          foreach($selectTamanhos as $mpp_st){
            
          
             $tamanhos[$counter]['cd_tamanho'] = $mpp_st->cd_tamanho;
             $tamanhos[$counter]['nm_tamanho'] = $mpp_st->nm_tamanho;
             $tamanhos[$counter]['cd_categoria_produto'] = $mpp_st->cd_categoria_produto;
             $tamanhos[$counter]['vl_fracao'] = $mpp_st->vl_fracao;
            
             $counter++;
          
          }
        
        }
      
      return json_encode($tamanhos);
        
      
    }


    public function ajaxAdicionarNaComanda(Request $request){

        $mpp_produto = $request->all(); 
        $mpp_produto = json_decode($mpp_produto['parameters'],false);
      
        $tamanho = $mpp_produto->cd_tamanho;

        //ADICIONA O ITEM NA COMANDA
        $insertItem = DB::connection('mpp')
        ->table('tb_item')
        ->insertGetId([
            'cd_comanda' => Session::get('CD_COMANDA'),
            'ic_fracionado' => $mpp_produto->ic_multi
        ]);

        //VERIFICA SE O PRODUTO É UNI OU MULTI
        if($mpp_produto->ic_multi == 0){

            //ADICIONA PRODUTO NO ITEM
            $insertItemProduto = DB::connection('mpp')
            ->table('tb_item_produto')
            ->insertGetId([
                'cd_produto' => $mpp_produto->cd_produto,
                'cd_item' =>  $insertItem
            ]);
          

            if($mpp_produto->cd_tamanho == "null"){
              
              $selectValor = DB::connection('mpp')
              ->table('tb_produto')
              ->join('tb_valor','tb_valor.cd_produto','=','tb_produto.cd_produto')
              ->where('tb_produto.cd_produto','=',$mpp_produto->cd_produto)
              ->get();
              
            }
            else{
              
              $selectValor = DB::connection('mpp')
              ->table('tb_produto')
              ->join('tb_valor','tb_valor.cd_produto','=','tb_produto.cd_produto')
              ->where('tb_produto.cd_produto','=',$mpp_produto->cd_produto)
              ->where('tb_valor.cd_tamanho','=',$mpp_produto->cd_tamanho)
              ->get();
            }

            $mpp_valor = $selectValor[0]->vl_produto;
            
        }
        else{
          
            

            $mpp_produto_dep = explode(";",$mpp_produto->cd_produto);

            for($i = 0; $i < (count($mpp_produto_dep) - 1); $i++){

                //ADICIONA PRODUTO NO ITEM
                $insertItemProduto = DB::connection('mpp')
                ->table('tb_item_produto')
                ->insertGetId([
                    'cd_produto' => $mpp_produto_dep[$i],
                    'cd_item' =>  $insertItem
                ]);  

            }

            //COMO DETERMINAR O PREÇO DOS ITENS MULTIPLOS
            /*$selectValor = DB::connection('mpp')
            ->table('tb_produto')
            ->whereIn('cd_produto',$mpp_produto)
            ->orderBy('vl_produto','desc')
            ->limit(1)
            ->get();*/
          
            $selectValor = DB::connection('mpp')
            ->table('tb_produto')
            ->join('tb_valor','tb_valor.cd_produto','=','tb_produto.cd_produto')
            ->whereIn('tb_produto.cd_produto',$mpp_produto_dep)
            ->where('tb_valor.cd_tamanho','=',$mpp_produto->cd_tamanho)
            ->orderBy('vl_produto','desc')
            ->limit(1)
            ->get();

            if(count($selectValor) > 0){
              
              $mpp_valor = $selectValor[0]->vl_produto;
            
            }


        }
      
        
        $updatetItem = DB::connection('mpp')
        ->table('tb_item')
        ->where('cd_item','=',$insertItem)
        ->update([
            'vl_item' => $mpp_valor,
            'cd_tamanho' => $mpp_produto->cd_tamanho
        ]);

    }


    public function ajaxBuscaValorComanda(){

        $selectComandaValue = DB::connection('mpp')
        ->table('tb_item')
        ->where('cd_comanda','=',Session::get('CD_COMANDA'))
        ->select(db::raw('sum(vl_item) as vl_comanda'))
        ->get();

        if(count($selectComandaValue) > 0){

            $comanda['valor'] = $selectComandaValue[0]->vl_comanda;

            $selectComandaItens = DB::connection('mpp')
            ->table('tb_item')
            ->where('cd_comanda','=',Session::get('CD_COMANDA'))
            ->where('cd_item_status','=','0')
            ->select(db::raw('count(*) as qt_itens_pendentes'))
            ->get();

            if(count($selectComandaItens) > 0){

                $comanda['pendentes'] = $selectComandaItens[0]->qt_itens_pendentes;

            }
            else{

                $comanda['pendentes'] = '0';

            }



        }
        else{

            $comanda['valor'] = '0,00';
            $comanda['pendentes'] = '0';

        }

        return json_encode($comanda);
    }


    public function ajaxBuscaDadosComanda(){

        //FUNÇÃO RESPONSÁVEL POR TRAZER OS DADOS DO PEDIDO DO CLIENTE

        // $selectComanda = DB::connection('mpp')
        // ->table('tb_item')
        // ->join('tb_item_produto','tb_item_produto.cd_item','=','tb_item.cd_item')
        // ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
        // ->join('tb_categoria_produto','tb_categoria_produto.cd_categoria_produto','=','tb_produto.cd_categoria_produto')
        // ->where('tb_item.cd_comanda','=',Session::get('CD_COMANDA'))
        // ->select(

        //     'tb_item.cd_item',
        //     'nm_categoria_produto',
        //     'nm_produto',
        //     'vl_item',
        //     'cd_item_status'
        
        // )
        // ->orderBy('cd_item_status','asc')
        // ->orderBy('cd_item','asc')
        // ->get();

        // if(count($selectComanda) > 0){

        //     $counter = -1;

        //     $itemAtual = 0;

        //     foreach($selectComanda as $mpp_sc){

        //         if($itemAtual == $mpp_sc->cd_item){

        //             $same++;
        //             $comanda[$counter]['nm_produto'][$same] = $mpp_sc->nm_produto;

        //         }
        //         else{

        //             $itemAtual = $mpp_sc->cd_item;

        //             $same = 0;
        //             $counter++;

        //             $comanda[$counter]['cd_item'] = $mpp_sc->cd_item;    
        //             $comanda[$counter]['nm_categoria_produto'] = $mpp_sc->nm_categoria_produto;
        //             $comanda[$counter]['nm_produto'][$same] = $mpp_sc->nm_produto;
        //             $comanda[$counter]['vl_item'] = $mpp_sc->vl_item;
        //             $comanda[$counter]['cd_item_status'] = $mpp_sc->cd_item_status;                    

        //         }
               

        //     }

        // }
        // else{

        //     $comanda = '';

        // }

        // return json_encode($comanda);
      
      


        $counter = 0;
        $comanda = array();
      
        $selectComanda = DB::connection('mpp')
        ->table('tb_item')
        ->join('tb_item_produto','tb_item_produto.cd_item','=','tb_item.cd_item')
        ->leftJoin('tb_tamanho','tb_tamanho.cd_tamanho','=','tb_item.cd_tamanho')
        ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
        ->join('tb_categoria_produto','tb_categoria_produto.cd_categoria_produto','=','tb_produto.cd_categoria_produto')
        ->where('tb_item.cd_comanda','=',Session::get('CD_COMANDA'))
        ->whereIn('cd_item_status',['1','2'])
        ->where('ic_fracionado','=','1')
        ->select(

            'tb_item.cd_item',
            'nm_categoria_produto',
            'nm_produto',
            'vl_item',
            'nm_tamanho',
            'cd_item_status',
            db::raw('vl_item as vl_total_item')
        
        )      
        ->groupBy('tb_item_produto.cd_item')
        ->get();

        if(count($selectComanda) > 0){

            foreach($selectComanda as $mpp_sc){
              
              $comanda[$counter]['cd_item'] = $mpp_sc->cd_item;    
              $comanda[$counter]['nm_categoria_produto'] = $mpp_sc->nm_categoria_produto;
              
              $selectFracoes = DB::connection('mpp')
              ->table('tb_item_produto')
              ->join('tb_item','tb_item.cd_item','=','tb_item_produto.cd_item')
              ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
              ->where('tb_item_produto.cd_item','=',$mpp_sc->cd_item)
              ->get();

              $comanda[$counter]['nm_produto'] = '';

              if(count($selectFracoes) > 0){
                
                $fracao = 0;

                foreach($selectFracoes as $mpp_sf){
                  
                  if($fracao == 0){
                    
                    $comanda[$counter]['nm_produto'] = $comanda[$counter]['nm_produto'].' '.$mpp_sf->nm_produto;
                  
                  }
                  else{
                    
                    $comanda[$counter]['nm_produto'] = $comanda[$counter]['nm_produto'].' + '.$mpp_sf->nm_produto;
                    
                  }
                  
                  $fracao++;

                }

              }
              
              if($mpp_sc->nm_tamanho != null){
                
                 $comanda[$counter]['nm_produto'] = $comanda[$counter]['nm_produto'].' ('.$mpp_sc->nm_tamanho.')';
                
              }
              
              $comanda[$counter]['vl_item'] = $mpp_sc->vl_total_item;
              $comanda[$counter]['cd_item_status'] = $mpp_sc->cd_item_status;                    
              $comanda[$counter]['qt_produto'] = 1;
              
              $counter++;
              
            }
          
        }

        $selectComanda = DB::connection('mpp')
        ->table('tb_item')
        ->join('tb_item_produto','tb_item_produto.cd_item','=','tb_item.cd_item')
        ->leftJoin('tb_tamanho','tb_tamanho.cd_tamanho','=','tb_item.cd_tamanho')
        ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
        ->join('tb_categoria_produto','tb_categoria_produto.cd_categoria_produto','=','tb_produto.cd_categoria_produto')
        ->where('tb_item.cd_comanda','=',Session::get('CD_COMANDA'))
        ->whereIn('cd_item_status',['1','2'])
        ->where('ic_fracionado','=','0')
        ->select(

            'tb_item.cd_item',
            'nm_categoria_produto',
            'nm_produto',
            'vl_item',
            'nm_tamanho',
            'cd_item_status',
            db::raw('count(*) as qt_produto'),
            db::raw('sum(vl_item) as vl_total_item')
        
        )
        ->orderBy('qt_produto','asc')        
        ->groupBy('tb_item_produto.cd_produto')
        ->get();

        if(count($selectComanda) > 0){


            foreach($selectComanda as $mpp_sc){

                $comanda[$counter]['cd_item'] = $mpp_sc->cd_item;    
                $comanda[$counter]['nm_categoria_produto'] = $mpp_sc->nm_categoria_produto;
              
                  
                if($mpp_sc->nm_tamanho != null){
                                  
                    $comanda[$counter]['nm_produto'] = $mpp_sc->nm_produto.' ('.$mpp_sc->nm_tamanho.')';
                
                }
                else{
                
                    $comanda[$counter]['nm_produto'] = $mpp_sc->nm_produto;
                
                }
                
                
                
                $comanda[$counter]['vl_item'] = $mpp_sc->vl_total_item;
                $comanda[$counter]['cd_item_status'] = $mpp_sc->cd_item_status;                    
                $comanda[$counter]['qt_produto'] = $mpp_sc->qt_produto;

                $counter++;

            }

        }
      
      $selectComanda = DB::connection('mpp')
        ->table('tb_item')
        ->join('tb_item_produto','tb_item_produto.cd_item','=','tb_item.cd_item')
        ->leftJoin('tb_tamanho','tb_tamanho.cd_tamanho','=','tb_item.cd_tamanho')
        ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
        ->join('tb_categoria_produto','tb_categoria_produto.cd_categoria_produto','=','tb_produto.cd_categoria_produto')
        ->where('tb_item.cd_comanda','=',Session::get('CD_COMANDA'))
        ->where('cd_item_status','=','0')
        ->where('ic_fracionado','=','1')
        ->select(

            'tb_item.cd_item',
            'nm_categoria_produto',
            'nm_produto',
            'vl_item',
            'nm_tamanho',
            'cd_item_status',
            db::raw('vl_item as vl_total_item')
        
        )      
        ->groupBy('tb_item_produto.cd_item')
        ->get();

        if(count($selectComanda) > 0){

            foreach($selectComanda as $mpp_sc){
              
              $comanda[$counter]['cd_item'] = $mpp_sc->cd_item;    
              $comanda[$counter]['nm_categoria_produto'] = $mpp_sc->nm_categoria_produto;
              
              $selectFracoes = DB::connection('mpp')
              ->table('tb_item_produto')
              ->join('tb_item','tb_item.cd_item','=','tb_item_produto.cd_item')
              ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
              ->where('tb_item_produto.cd_item','=',$mpp_sc->cd_item)
              ->get();

              $comanda[$counter]['nm_produto'] = '';

              if(count($selectFracoes) > 0){
                
                $fracao = 0;

                foreach($selectFracoes as $mpp_sf){
                  
                  if($fracao == 0){
                    
                    $comanda[$counter]['nm_produto'] = $comanda[$counter]['nm_produto'].' '.$mpp_sf->nm_produto;
                  
                  }
                  else{
                    
                    $comanda[$counter]['nm_produto'] = $comanda[$counter]['nm_produto'].' + '.$mpp_sf->nm_produto;
                    
                  }
                  
                  $fracao++;

                }

              }
              
              if($mpp_sc->nm_tamanho != null){
                
                 $comanda[$counter]['nm_produto'] = $comanda[$counter]['nm_produto'].' ('.$mpp_sc->nm_tamanho.')';
                
              }
              
              $comanda[$counter]['vl_item'] = $mpp_sc->vl_total_item;
              $comanda[$counter]['cd_item_status'] = $mpp_sc->cd_item_status;                    
              $comanda[$counter]['qt_produto'] = 1;
              
              $counter++;
              
            }
          
        }


        $selectComanda2 = DB::connection('mpp')
        ->table('tb_item')
        ->join('tb_item_produto','tb_item_produto.cd_item','=','tb_item.cd_item')
        ->leftJoin('tb_tamanho','tb_tamanho.cd_tamanho','=','tb_item.cd_tamanho')
        ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
        ->join('tb_categoria_produto','tb_categoria_produto.cd_categoria_produto','=','tb_produto.cd_categoria_produto')
        ->where('tb_item.cd_comanda','=',Session::get('CD_COMANDA'))
        ->where('cd_item_status','=','0')
        ->where('ic_fracionado','=','0')
        ->select(
            'tb_item.cd_item',
            'nm_categoria_produto',
            'nm_produto',
            'vl_item',
            'nm_tamanho',
            'cd_item_status',
            db::raw('count(*) as qt_produto'),
            db::raw('sum(vl_item) as vl_total_item')
        
        )
        ->orderBy('qt_produto','asc')
        ->groupBy('tb_item_produto.cd_produto')
        ->get();


        if(count($selectComanda2) > 0){


            foreach($selectComanda2 as $mpp_sc2){


                $comanda[$counter]['cd_item'] = $mpp_sc2->cd_item;    
                $comanda[$counter]['nm_categoria_produto'] = $mpp_sc2->nm_categoria_produto;
              
                if($mpp_sc2->nm_tamanho != null){
                
                    $comanda[$counter]['nm_produto'] = $mpp_sc2->nm_produto.' ('.$mpp_sc2->nm_tamanho.')';
                
                }
                else{
                  
                  $comanda[$counter]['nm_produto'] = $mpp_sc2->nm_produto;
                
                }
              
                $comanda[$counter]['vl_item'] = $mpp_sc2->vl_total_item;
                $comanda[$counter]['cd_item_status'] = $mpp_sc2->cd_item_status;                    
                $comanda[$counter]['qt_produto'] = $mpp_sc2->qt_produto;

                $counter++;

            }

        }



        
       
        return json_encode($comanda);

    }


    public function ajaxRemoverItemComanda(Request $request){

        $mpp_item_produto = $request->all(); 
        $mpp_item_produto = json_decode($mpp_item_produto['parameters'],false);

        $delete = DB::connection('mpp')
        ->table('tb_item_produto')
        ->where('cd_item','=',$mpp_item_produto->cd_item)
        ->delete();

        $delete = DB::connection('mpp')
        ->table('tb_item')
        ->where('cd_item','=',$mpp_item_produto->cd_item)
        ->delete();

    }


    public function ajaxEnviarComanda(Request $request){

        $mpp_comanda = $request->all(); 
        $mpp_comanda = json_decode($mpp_comanda['parameters'],false);

        $updateComanda = DB::connection('mpp')
        ->table('tb_comanda')
        ->where('cd_comanda','=',Session::get('CD_COMANDA'))
        ->update([
            'ds_comanda' => $mpp_comanda->ds_comanda,
            'cd_comanda_status' => 1
        ]);

        $updateComanda = DB::connection('mpp')
        ->table('tb_item')
        ->where('cd_comanda','=',Session::get('CD_COMANDA'))
        ->where('cd_item_status','=','0')
        ->update([
            'cd_item_status' => 1
        ]);

    }

    public function ajaxFinalizarComanda(){

        $updateComanda = DB::connection('mpp')
        ->table('tb_comanda')
        ->where('cd_comanda','=',Session::get('CD_COMANDA'))
        ->update([
            'cd_comanda_status' => 1,
            'dt_comanda_fim' => date('Y-m-d H:i:s')
        ]);

        Session::forget('CD_COMANDA');
        Session::forget('CD_LOJA');

    }


    public function ajaxLogout(){

        Session::forget('CD_USUARIO');
        Session::forget('CD_LOJA');
        Session::forget('CD_COMANDA');

    }

  
    //ADMIN
  
    public function ajaxAdminLogin(Request $request){
      
        $login = array();
        
        $mpp = $request->all();
      
        $mpp = json_decode($mpp['parameters'],false);
        
        $selectLogin = DB::connection('mpp')        
        ->table('tb_funcionario')
        ->join('tb_loja','tb_loja.cd_loja','=','tb_funcionario.cd_loja')
        ->where('nm_usuario','=', $mpp->user)
        ->where('cd_senha','=',$mpp->pass)
        ->select(
          'cd_funcionario',
          'nm_funcionario',
          'tb_loja.cd_loja',
          'nm_loja'
        )
        ->get();
      
        if(count($selectLogin) > 0){

            foreach($selectLogin as $mpp_sl){
      
               $login['login'] = 'true';
               
               Session::put('CD_FUNCIONARIO',$mpp_sl->cd_funcionario);
               Session::put('NM_FUNCIONARIO',$mpp_sl->nm_funcionario);
               Session::put('CD_LOJA',$mpp_sl->cd_loja);
               Session::put('NM_LOJA',$mpp_sl->nm_loja);
              
            }
          
        }
        else{
          
          $login['login'] = 'false';
        
        }
        
        return json_encode($login);

    }
  
  
    public function ajaxLoadScreens(Request $request){
      
        $modulos = array();
      
        $selectModulos = DB::connection('mpp')        
        ->table('tb_funcionario_modulo')
        ->join('tb_modulo','tb_modulo.cd_modulo','=','tb_funcionario_modulo.cd_modulo')
        ->where('tb_funcionario_modulo.cd_funcionario','=',Session::get('CD_FUNCIONARIO'))
        ->get();
        
        if(count($selectModulos) > 0){
      
           
            $counter = 0;
          
            foreach($selectModulos as $mpp_sm){
              
              $modulos[$counter]['nm_modulo'] = $mpp_sm->nm_modulo;
              $modulos[$counter]['nm_modulo_logo'] = $mpp_sm->nm_modulo_logo;
              $modulos[$counter]['ds_modulo'] = $mpp_sm->ds_modulo;
              $modulos[$counter]['estrutura'] = file_get_contents('https://'.$_SERVER['HTTP_HOST'].$mpp_sm->nm_modulo_url);

              $counter++;
              
            }
          
        }
        else{
          
           $modulos = '';
          
        }
      
        return json_encode($modulos);
      
    }
  
  public function ajaxLongPollingWishlist(){
    
   
    $counter = 0;
    $back = '';

    do{

       $back = $this->longPollingWishlist();


       if($back == ''){

        sleep(2);

       }

       $counter++;  

    }
    while($counter < 10 && $back == '');
    
    return $back;
    
  }
  
  public function longPollingWishlist(){
    
      $wishlist = array();
    
      $selectWishList = DB::connection('mpp')
      ->table('tb_comanda')
      ->join('tb_card','tb_card.cd_card','=','tb_comanda.cd_card')
      ->where('tb_card.cd_loja','=',Session::get('CD_LOJA'))
      ->where('cd_comanda_status','=','1')
      ->select(
        'nm_card',
        'ds_comanda',
        'cd_comanda'
      )
      ->get();    
    
     if(count($selectWishList) > 0){
       
        $counter = 0;
       
        foreach($selectWishList as $mpp_sw){
           
            $wishlist[$counter]['cd_comanda'] = $mpp_sw->cd_comanda;
            $wishlist[$counter]['nm_card'] = $mpp_sw->nm_card;
            $wishlist[$counter]['ds_comanda'] = $mpp_sw->ds_comanda;
          
            $counter++;
          
        }
        
       return json_encode($wishlist);   
       
    }
    else{
      
      return '';
    }
    
     
    
  }
  
  
  public function ajaxAlteraStatusComanda(Request $request){
    
      $mpp = $request->all();
    
      $mpp = json_decode($mpp['parameters'],false);
      
      $dt_fim = null;
    
      if($mpp->status == 2){
       
        $update = DB::connection('mpp')
        ->table('tb_item')
        ->where('cd_comanda','=',$mpp->comanda)
        ->where('cd_item_status','=',1)
        ->update([
          
          'cd_item_status' => 2
          
        ]);
        
      }
      else if($mpp->status == 4){
        
        $dt_fim = date('Y-m-d H:i:s');
        
      }
      
      $update = DB::connection('mpp')
      ->table('tb_comanda')
      ->where('cd_comanda','=',$mpp->comanda)
      ->update([
        
        'cd_comanda_status' => $mpp->status,
        'dt_comanda_fim' => $dt_fim
        
      ]);
    
  }
  
  
  public function ajaxInfoComandaWishlist(Request $request){
    
        $mpp = $request->all();
    
        $mpp = json_decode($mpp['parameters'], false);
    
        $counter = 0;
        $comanda = array();
      
        $selectComanda = DB::connection('mpp')
        ->table('tb_item')
        ->join('tb_item_produto','tb_item_produto.cd_item','=','tb_item.cd_item')
        ->leftJoin('tb_tamanho','tb_tamanho.cd_tamanho','=','tb_item.cd_tamanho')
        ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
        ->join('tb_categoria_produto','tb_categoria_produto.cd_categoria_produto','=','tb_produto.cd_categoria_produto')
        ->where('tb_item.cd_comanda','=',$mpp->comanda)
        ->where('cd_item_status','=','1')
        ->where('ic_fracionado','=','1')
        ->select(

            'tb_item.cd_item',
            'nm_categoria_produto',
            'nm_produto',
            'vl_item',
            'nm_tamanho',
            'cd_item_status',
            db::raw('vl_item as vl_total_item')
        
        )      
        ->groupBy('tb_item_produto.cd_item')
        ->get();

        if(count($selectComanda) > 0){

            foreach($selectComanda as $mpp_sc){
              
              $comanda[$counter]['cd_item'] = $mpp_sc->cd_item;    
              $comanda[$counter]['nm_categoria_produto'] = $mpp_sc->nm_categoria_produto;
              
              $selectFracoes = DB::connection('mpp')
              ->table('tb_item_produto')
              ->join('tb_item','tb_item.cd_item','=','tb_item_produto.cd_item')
              ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
              ->where('tb_item_produto.cd_item','=',$mpp_sc->cd_item)
              ->get();

              $comanda[$counter]['nm_produto'] = '';

              if(count($selectFracoes) > 0){
                
                $fracao = 0;

                foreach($selectFracoes as $mpp_sf){
                  
                  if($fracao == 0){
                    
                    $comanda[$counter]['nm_produto'] = $comanda[$counter]['nm_produto'].' '.$mpp_sf->nm_produto;
                  
                  }
                  else{
                    
                    $comanda[$counter]['nm_produto'] = $comanda[$counter]['nm_produto'].' + '.$mpp_sf->nm_produto;
                    
                  }
                  
                  $fracao++;

                }

              }
              
              if($mpp_sc->nm_tamanho != null){
                
                 $comanda[$counter]['nm_produto'] = $comanda[$counter]['nm_produto'].' ('.$mpp_sc->nm_tamanho.')';
                
              }
              
              $comanda[$counter]['vl_item'] = $mpp_sc->vl_total_item;
              $comanda[$counter]['cd_item_status'] = $mpp_sc->cd_item_status;                    
              $comanda[$counter]['qt_produto'] = 1;
              
              $counter++;
              
            }
          
        }

        $selectComanda = DB::connection('mpp')
        ->table('tb_item')
        ->join('tb_item_produto','tb_item_produto.cd_item','=','tb_item.cd_item')
        ->leftJoin('tb_tamanho','tb_tamanho.cd_tamanho','=','tb_item.cd_tamanho')
        ->join('tb_produto','tb_produto.cd_produto','=','tb_item_produto.cd_produto')
        ->join('tb_categoria_produto','tb_categoria_produto.cd_categoria_produto','=','tb_produto.cd_categoria_produto')
        ->where('tb_item.cd_comanda','=',$mpp->comanda)
        ->where('cd_item_status','=','1')
        ->where('ic_fracionado','=','0')
        ->select(

            'tb_item.cd_item',
            'nm_categoria_produto',
            'nm_produto',
            'vl_item',
            'nm_tamanho',
            'cd_item_status',
            db::raw('count(*) as qt_produto'),
            db::raw('sum(vl_item) as vl_total_item')
        
        )
        ->orderBy('qt_produto','asc')        
        ->groupBy('tb_item_produto.cd_produto')
        ->get();

        if(count($selectComanda) > 0){


            foreach($selectComanda as $mpp_sc){

                $comanda[$counter]['cd_item'] = $mpp_sc->cd_item;    
                $comanda[$counter]['nm_categoria_produto'] = $mpp_sc->nm_categoria_produto;
              
                  
                if($mpp_sc->nm_tamanho != null){
                                  
                    $comanda[$counter]['nm_produto'] = $mpp_sc->nm_produto.' ('.$mpp_sc->nm_tamanho.')';
                
                }
                else{
                
                    $comanda[$counter]['nm_produto'] = $mpp_sc->nm_produto;
                
                }
                
                
                
                $comanda[$counter]['vl_item'] = $mpp_sc->vl_total_item;
                $comanda[$counter]['cd_item_status'] = $mpp_sc->cd_item_status;                    
                $comanda[$counter]['qt_produto'] = $mpp_sc->qt_produto;

                $counter++;

            }

        }
      
        return json_encode($comanda);
        
  }
  
}
