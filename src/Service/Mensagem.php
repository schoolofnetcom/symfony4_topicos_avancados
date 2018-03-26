<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Mensagem
{
    public function escreverMensagem($nome)
    {
        return "{$nome}, I'm your father!";
    }
}