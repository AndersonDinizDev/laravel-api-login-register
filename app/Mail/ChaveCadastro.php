<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChaveCadastro extends Mailable
{
    use Queueable, SerializesModels;

    public $chave;

    public function __construct($chave)
    {
        $this->chave = $chave;
    }

    public function build()
    {
        return $this->subject('Chave Cadastro')
                    ->view('emails.chave_cadastro');
    }
}
