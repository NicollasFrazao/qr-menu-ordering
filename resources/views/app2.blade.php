@extends('layouts.master')

@section('title', 'App')

@section('description', 'Bom apetite!')

@section('content')

	<div class="owl-carousel owl-theme">
	  <div class="item">
	  	<img src="image/brocolis.png" alt="">
		<h3>Esfiha</h3>
	  </div>
	  
	  <div class="item">
	  	<img src="image/goiabada.png" alt="">
		<h3>Esfiha Doce</h3>
	  </div>
	</div>

@endsection

@section('links')
	<link href="css/owl.carousel.min.css" type="text/css" rel="stylesheet">
	<link href="css/owl.theme.default.min.css" type="text/css" rel="stylesheet">
@endsection

@section('scripts')
	<script src="js/jquery.js"></script>
	<script src="js/owl.carousel.min.js"></script>
@endsection

@section('scriptsOnPage')

	$.ajaxSetup({

		beforeSend: function(xhr){
		     
		  xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
		     
		}

	}); 

	$('.owl-carousel').owlCarousel({
	    loop:true,
	    margin:0,
	    nav:false,
	    autoplay:true,
	    autoplayTimeout:8000,
		autoplayHoverPause:false,
		touchDrag:false,
		mouseDrag:false,
		responsive:{
	        0:{
	            items:1
	        }
	    }
	})

@endsection