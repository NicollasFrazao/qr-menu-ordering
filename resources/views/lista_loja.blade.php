<?php

  $select = DB::connection('mysql')
  ->table('usuario')
  ->join('cidade','cidade.cd_cidade','=','usuario.cd_cidade')
  ->join('estado','estado.cd_estado','=','cidade.cd_estado')
  ->where('categoria_usuario','=','4')
  ->get();

  if(count($select) > 0){
    
    foreach($select as $sl){
      
      $inner = '<tr>
                  <td>'.$sl->cd_usuario.'</td>
                  <td>'.$sl->nm_fantasia.'</td>
                  <td>'.$sl->cd_cnpj.'</td>
                  <td>'.$sl->nm_cidade.'</td>
                  <td>'.$sl->nm_estado.'</td>
                  <td>
                    <button class="btn btn-sm btn-primary" type="button">Small</button>
                    <button class="btn btn-sm btn-primary" type="button">Small</button>
                    <button class="btn btn-sm btn-primary" type="button">Small</button>
                  </td>
                </tr>';       
      
    }
    
  }

?>
    <div class="main-content" >

        <div class="header pb-6 pt-5 pt-lg-4 d-flex align-items-center">

          <span class="mask bg-gradient-default opacity-8"></span>

      </div>

      <div class="row mt--5">

          <div class="col-md-12">

            <h1 style='color: #fff; margin-left: 30px;'>Lista Loja</h1>

          </div>

      </div>

      <div class="container">

        <div class='col-md-12 box-content'>

          <form>


            <div class="row">

              <div class="col-md-6">

                <select id='qt_exibe'>
                    <option>10</option>           
                    <option>20</option>           
                </select>

              </div>
              
               <div class="col-md-6">

                <div class="form-group">
                  <label class="form-text">CPF</label>
                  <input type="email" class="form-control" id="txt_cpf" placeholder="" value="{{$selectVeterinario[0]->id_cpf}}">
                </div>

                </div>

            </div>


            <div class="row">

                <div class="col-md-6">

                  <div class="form-group">
                    <label class="form-text">E-mail</label>
                    <input type="email" class="form-control" id="txt_email" placeholder="" value="{{$selectVeterinario[0]->nm_email}}">
                  </div>

                </div>
              
                <div class="col-md-6">

                  <div class="form-group">
                    <label class="form-text">Telefone</label>
                    <input type="email" class="form-control" id="txt_telefone" placeholder="" value="{{$selectVeterinario[0]->id_telefone}}">
                  </div>

                </div>
             
            </div>
            
            <div class="row">

                <div class="col-md-6">

                  <div class="form-group">
                    <label class="form-text">Estados</label>
                    <select class="form-control" id='sel_estados'>
                        <?php
                          
                            $selectEstado = DB::connection('mysql')
                            ->table('estado')
                            ->get();
                      
                            if(count($selectEstado) > 0){
                              
                              foreach($selectEstado as $se){
                                
                                  if($se->cd_estado == $selectVeterinario[0]->id_estado){
                                    
                                    echo '<option selected value='.$se->cd_estado.'>'.$se->nm_estado.'</option>';
                                    
                                  }
                                  else{
                                    
                                    echo '<option value='.$se->cd_estado.'>'.$se->nm_estado.'</option>';
                                  
                                  }
                                
                                  
                                
                              }
                              
                            }
                          
                        ?>
                    </select>
                  </div>

                </div>
              
                <div class="col-md-6">

                  <div class="form-group">
                    <label class="form-text">Cidades</label>
                    <select class="form-control" id='sel_cidades'>
                        
                    </select>
                  </div>

                </div>
             
            </div>


            <div class="row">

              <div class="col-md-12">

                <button class="btn btn-primary" type="button" onclick='alterar_veterinarios_cadastro()'>Salvar</button>

              </div>

            </div>

          </form>

        </div>

      </div>    

    </div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
  
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  
  window.onload = function(){
    
    loadCidades();
    
  }
  
	function alterar_veterinarios_cadastro(){


		$.post('../alterar_veterinarios_cadastro',
		{
      id: <?php echo $id_veterinario; ?>,
			nome: txt_nome.value,
      senha: null,
			email: txt_email.value,
      estado: sel_estados.value,
      cidade: sel_cidades.value,
      cpf: txt_cpf.value,
      telefone: txt_telefone.value
     
      
		})
		.done(function(mS_return){

      alert('Veterinário alterado com sucesso!');

		})
		.fail(function(xhr, status, error){

	    alert('Ocorreu um erro ao tentar realizar um novo registro');

		});

	}


	function limpar_veterinarios_cadastro(){

		txt_nome.value = '';
		txt_telefone.value = '';
    txt_cpf.value = '';
		txt_email.value = '';

	}
  
  
  sel_estados.onclick = function(){
    
    loadCidades();
    
  }
  
  function loadCidades(){
    
    $.post('../carrega_cidades',
		{

			estado: sel_estados.value
      
		})
		.done(function(vba){
      
      sel_cidades.innerHTML = '';
      sel_cidades.innerHTML = vba;
      
      options = document.getElementById('sel_cidades').getElementsByTagName('option');
      
      for(i=0; i<=options.length; i++){
        
          if(options[i].value == <?php echo $selectVeterinario[0]->id_cidade; ?>){
          
             document.getElementById("sel_cidades").selectedIndex = i;
             
          }
      }
      
		})
		.fail(function(xhr, status, error){

		alert('Ocorreu um erro ao tentar exibir as cidades');

		});
    
  }
</script>
@endsection