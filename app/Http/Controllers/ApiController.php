<?php

namespace App\Http\Controllers;

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

                if ($token_email !== $email) {
                    $response['register'] = false;
                    $response['error'] = 'Token informado não é associado ao email';
                } else {
                    if (empty($key)) {

                        $key = bind2hex(random_bytes(16));
                        $created_at = now();

                        DB::table('tokens')->insert([
                            'token' => $key,
                            'email' => $email,
                            'created_at' => $created_at,
                        ]);

                        Mail::to($email)->send(new )
                    }
                }
            }
        }

        return response()->json($response);
    }
}
