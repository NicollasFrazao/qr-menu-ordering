<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Socialite;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallbackGoogle()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $this->socialLogin('google', $user);

        return redirect('/app');
    }

   

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallbackFacebook()
    {
        
        $user = Socialite::driver('facebook')->stateless()->user();

        $this->socialLogin('facebook', $user);

        return redirect('/app');
        
    }


    public function socialLogin($socialmedia, $user){

        //VERIFICO SE EXISTE ALGUM CLIENTE COM ESSE ID NO MPP

        //SE TIVER EU LOGO COMO ESSE USUÁRIO

        //SE NÃO TIVER, CADASTRO O USUÁRIO E VINCULO O ID NELE

        $selectSocialMedia = DB::connection('mpp')
        ->table('tb_usuario')
        ->where('cd_'.$socialmedia.'_id','=',$user->id)
        ->get();

        if(count($selectSocialMedia) > 0){

            Session::put('CD_USUARIO', $selectSocialMedia[0]->cd_usuario);
            Session::put('NM_USUARIO', $selectSocialMedia[0]->nm_usuario);
            Session::put('NM_FOTO', $selectSocialMedia[0]->nm_foto);

        }
        else{

            $usuario = DB::connection('mpp')
            ->table('tb_usuario')
            ->insertGetId([

                'nm_usuario' => $user->name,
                'nm_email' => $user->email,
                'nm_apelido' => $user->nickname,
                'dt_cadastro' => date('Y-m-d H:i:s'),
                'nm_foto' => $user->avatar,
                'cd_'.$socialmedia.'_id' => $user->id

            ]);

            Session::put('CD_USUARIO', $usuario);
            Session::put('NM_USUARIO', $user->name);
            Session::put('NM_FOTO', $user->avatar);

        }

    }

}
