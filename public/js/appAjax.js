function ajaxAppRequest(parameters, callback){

	$.post(parameters.url,
    {
      parameters: JSON.stringify(parameters)

    },
    function(data){

      //NÃO CONSIGO RETORNAR O VALOR DESSA VARIAVEL PARA A FUNÇÃO QUE CHAMOU ESSE AJAX MANEIRO :(
      callback(data);

    });

}