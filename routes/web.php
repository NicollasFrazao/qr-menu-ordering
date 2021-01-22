<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/app', function(){
    return view('app');
});

Route::get('/', function () {
    return view('index');
});

Route::get('/teste', function () {
    return view('app2');
});


Route::get('/app', function () {
    return view('app');
});

Route::get('/leadbox', function () {
    return view('leadbox');
});

Route::get('/policy', function () {
    echo 'Policy';
});

Route::get('/{driver}/login', 'Auth\LoginController@redirectToProvider');

Route::post('/{driver}/login', 'Auth\LoginController@redirectToProvider');

Route::get('/gauth', 'Auth\LoginController@handleProviderCallbackGoogle');


Route::get('/fbauth', 'Auth\LoginController@handleProviderCallbackFacebook');


Route::get('/estilo', function(){
    return view('estilo');
});

Route::get('/index', function(){
    return view('index');
});

Route::get('/login', function(){
    return view('login');
});

Route::get('/cardapio_categorias', function(){
    return view('cardapio_categorias');
});

Route::get('/cardapio_produtos', function(){
    return view('cardapio_produtos');
});

Route::get('/configuracoes', function(){
    return view('configuracoes');
});

Route::get('/qr', function(){
    return view('qr');
});

Route::get('/restaurantes', function(){
    return view('restaurantes');
});


Route::post('/flush-login', function(){
    Session::forget('CD_USUARIO');

    return 'ok';
});


//ADMIN
Route::get('/admin', function(){
    return view('admin');
});

Route::get('/admin-top-bar', function(){
    return view('admin-top-bar');
});


Route::get('/admin-login', function(){
    return view('admin-login');
});

Route::get('/admin-box', function(){
    return view('admin-box');
});

Route::get('/admin-wishlist', function(){
    return view('admin-wishlist');
});

//AJAX
Route::post('/ajax/ajaxScanCode', 'AjaxController@ajaxScanCode');
Route::post('/ajax/ajaxScanCodeType', 'AjaxController@ajaxScanCodeType');
Route::post('/ajax/ajaxGetSession', 'AjaxController@ajaxGetSession');
Route::post('/ajax/ajaxCategoriasCardapio' ,'AjaxController@ajaxCategoriasCardapio');
Route::post('/ajax/ajaxCardapioProdutos' ,'AjaxController@ajaxCardapioProdutos');
Route::post('/ajax/ajaxAdicionarNaComanda' ,'AjaxController@ajaxAdicionarNaComanda');
Route::post('/ajax/ajaxBuscaDadosComanda' ,'AjaxController@ajaxBuscaDadosComanda');
Route::post('/ajax/ajaxBuscaValorComanda' ,'AjaxController@ajaxBuscaValorComanda');
Route::post('/ajax/ajaxRemoverItemComanda' ,'AjaxController@ajaxRemoverItemComanda');
Route::post('/ajax/ajaxEnviarComanda' ,'AjaxController@ajaxEnviarComanda');
Route::post('/ajax/ajaxFinalizarComanda' ,'AjaxController@ajaxFinalizarComanda');
Route::post('/ajax/ajaxLogout' ,'AjaxController@ajaxLogout');
Route::post('/ajax/ajaxListarLojas' ,'AjaxController@ajaxListarLojas');
Route::post('/ajax/ajaxSelecionarTamanho' ,'AjaxController@ajaxSelecionarTamanho');
Route::post('/ajax/ajaxBuscaLojaInfo' ,'AjaxController@ajaxBuscaLojaInfo');



//AJAX ADMIN
Route::post('/ajax/ajaxAdminLogin' ,'AjaxController@ajaxAdminLogin');
Route::post('/ajax/ajaxLoadScreens' ,'AjaxController@ajaxLoadScreens');
Route::post('/ajax/ajaxAlteraStatusComanda' ,'AjaxController@ajaxAlteraStatusComanda');
Route::post('/ajax/ajaxInfoComandaWishlist' ,'AjaxController@ajaxInfoComandaWishlist');


// LONGPOOLING
Route::post('/ajax/ajaxLongPollingWishlist' ,'AjaxController@ajaxLongPollingWishlist');






//GLOBAL AJAX
Route::post('/ajax/global/ajaxCategoriasCardapio' ,'AjaxController@ajaxGlobalCategoriasCardapio');