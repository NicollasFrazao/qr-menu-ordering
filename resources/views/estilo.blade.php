@extends('layouts.master')

@section('title', '')

@section('description', '')

@section('style')

  <?php

  	include('css/index.css');
    include('css/estilo.css');

  ?>

@endsection

@section('content')

<hr>

<h2>Botões</h2>

<article>

	<button class="bt yellow-red">Button 1</button>
	<p class="indicador-estilo">bt yellow-red</p>

	<button class="bt gray-white">Button 2</button>
	<p class="indicador-estilo">bt gray-white</p>

	<button class="bt white-red">Button 3</button>
	<p class="indicador-estilo">bt white-red</p>

	<button class="bt orange-white">Button 4</button>
	<p class="indicador-estilo">bt orange-white</p>

	<button class="close-red">X</button>
	<p class="indicador-estilo">close-red</p>

</article>

<hr>

<h2>Titulos</h2>

<article>

	<h2 class="title-gray">Title 1</h2>
	<p class="indicador-estilo">title-gray</p>

	<h2 class="subtitle-gray">Title 2</h2>
	<p class="indicador-estilo">subtitle-gray</p>

	<h2 class="text-gray">Title 3</h2>
	<p class="indicador-estilo">text-gray</p>

</article>

<hr>

@endsection

@section('links')

@endsection

@section('scripts')

@endsection

@section('scriptsOnPage')

@endsection