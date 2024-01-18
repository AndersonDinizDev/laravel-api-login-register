<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

                $check_user_email = DB::table('users')->where('email', $email)->first();

                if ($check_user_email) {
                    if(Hash::check($password, $check_user_email->password)) {

                        $response['login'] = true;
                        $response['message'] = 'Autenticação bem-sucedida';
                    } else {
                        $response['login'] = false;
                        $response['message'] = 'Senha incorreta';
                    }
                } else {
                    $response['login'] = false;
                    $response['message'] = 'Usuário não encontrado';
                }
            } catch (\Exception $e) {
                $response['login'] = false;
                $response['message'] = "Erro durante a autenticação $e";
            }
        }
        return response()->json($response);
    }
}
