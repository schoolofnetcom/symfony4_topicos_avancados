<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SessionController extends Controller
{
    /**
     * @Route("/session", name="session")
     * @param SessionInterface $session
     */
    public function index(SessionInterface $session)
    {
        $session->set('frase', "Luke, I'm your FATHER!");
        exit;
    }
}
