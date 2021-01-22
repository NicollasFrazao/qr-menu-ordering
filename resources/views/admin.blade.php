@extends('layouts.master')

@section('title', 'Admin')

@section('description', 'Bom apetite!')

@section('content')

	
	
	<?php 

		$timeNotRepeat = '?'.date('Ymdhis');

		if(Session::get('CD_FUNCIONARIO')){


		}
	
	?>

	

	<!-- SCREENS::BEGIN -->
  
	@include('admin-top-bar')
  @include('admin-login')
  
  @include('admin-modules')
	@include('admin-screens')

  <!-- SCREENS::END -->

@endsection

@section('links')
	<link href="css/owl.carousel.min.css" type="text/css" rel="stylesheet">
	<link href="css/owl.theme.default.min.css" type="text/css" rel="stylesheet">
	<link href="css/index.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/top-bar.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/app-bar.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/footer.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">

	<link href="css/login.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/pedido.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/home.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/qr.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/configuracao.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/categoria.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/cardapio.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/pedido.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/observacao.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
	<link href="css/avaliacao.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
  
  <link href="css/admin.css<?php echo $timeNotRepeat; ?>" type="text/css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css<?php echo $timeNotRepeat; ?>"/>




@endsection

@section('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
	<script src="js/appAjax.js<?php echo $timeNotRepeat; ?>"></script>
  <script src="js/appScriptAdmin.js<?php echo $timeNotRepeat; ?>"></script>
	
  <script src="js/bootbox.all.min.js<?php echo $timeNotRepeat; ?>"></script>

  

@endsection

@section('scriptsOnPage')

	$.ajaxSetup({

		beforeSend: function(xhr){
		     
		  xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
		     
		}

	}); 


@endsection