<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $data = $request->json()->all();
        $response = [];

        if($request->isMethod('POST')) {
            try {
                $email = $data['user_email'];
                $password = $data['user_password'];
                $check = 0;

                // Busca o usuário no banco de dados
                $check_user_email = DB::table('users')->where('email', $email)->first();

                if ($check_user_email) {
                    // Verifica a senha usando Hash::check
                    if(Hash::check($password, $check_user_email->password)) {

                        // Autenticação bem-sucedida
                        $response['login'] = true;
                        $response['message'] = 'Autenticação bem-sucedida';
                    } else {
                         // Senha incorreta
                        $response['login'] = false;
                        $response['message'] = 'Senha incorreta';
                    }
                } else {
                     // Usuário não encontrado
                    $response['login'] = false;
                    $response['message'] = 'Usuário não encontrado';
                }
            } catch (\Exception $e) {
                $response['error'] = true;
                $response['message'] = $e->getMessage();
            }
        }
        return response()->json($response);
    }
}
