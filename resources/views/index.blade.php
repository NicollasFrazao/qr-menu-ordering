@extends('layouts.master')

@section('title', 'Bom apetite')

@section('description', '')

@section('content')
  <section id="index">
    <header class="padding" style=' margin-top: 50px;
        display: flex;
        justify-content: space-around;
    '>

        <img id="logo" src="image/app-logo.svg" alt="Logotipo App">

    </header>

    <h1>Já está com fome?<br><span>Seu pedido está sendo preparado!</span></h1>

    <h2>Por enquanto, curta as redes sociais pra ficar por dentro de tudo!</h2>


    <div>
    	<a href="#" target="_blank"><img src="image/instagram.png" alt="Instagram"></a>
    	<a href="#" target="_blank"><img src="image/facebook.png" alt="Facebook"></a>
    </div>
    <div>
    	<h3>Bom apetite!</h3>
    </div>
  </section>
@endsection

@section('links')
    <link href="css/index.css" type="text/css" rel="stylesheet">
@endsection

@section('scripts')

@endsection

@section('scriptsOnPage')

  <?php

    //include('js/index.js');

  ?>

@endsection