<div id='mpp_admin_login'>
    <input type='text' id='mpp_txt_admin_login' value="">
    <input type='text' id='mpp_txt_admin_senha' value="">
    <input type='button' id='mpp_btn_login' value='Entrar'>
</div>

<input type="text" id="n1" maxlength='18'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
  
  $("#n1").on("keyup", function(e)
  {
      $(this).val(
          $(this).val()
          .replace(/\D/g, '')
          .replace(/^(\d{2})(\d{3})?(\d{3})?(\d{4})?(\d{2})?/, "$1.$2.$3/$4-$5"));
  });
</script>