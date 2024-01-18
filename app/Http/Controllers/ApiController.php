<?php

namespace App\Http\Controllers;

use App\Mail\ChaveCadastro;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    public function register(Request $request) {
        $data = $request->json()->all();
        $response = [];

        if($request->isMethod('POST')) {
            try {
                $name = $data['user_name'];
                $email = $data['user_email'];
                $password = $data['user_password'];
                $key = $data['user_key'];
                $check = 0;

                $token_email = DB::table('tokens')->where('token', $key)->value('email');

                if (!empty($key) && $token_email !== $email) {
                    $response['register'] = false;
                    $response['error'] = 'Token informado não é associado ao email';

                } else {
                    if (empty($key)) {
                        $key = bin2hex(random_bytes(16));
                        $created_at = now();

                        Token::create([
                            'token' => $key,
                            'email' => $email,
                            'created_at' => $created_at,
                        ]);

                        Mail::to($email)->send(new ChaveCadastro($key));

                        $response['token_enviado'] = true;
                        $response['message'] = 'Token criado e enviado com sucesso';
                    }

                    if(!empty($key) && $token_email == $email) {
                        User::create([
                            'name' => $name,
                            'email' => $email,
                            'password' => Hash::make($password),
                            'register_token' => $key,
                        ]);

                        $check++;

                        if(!$check) {
                            $response['register'] = false;
                        } else {
                            $response['register'] = true;
                        }
                    }
                }
            } catch (\Exception $e) {
                $response['error'] = true;
                $response['message'] = $e->getMessage();
            }
        }

        return response()->json($response);
    }
}
