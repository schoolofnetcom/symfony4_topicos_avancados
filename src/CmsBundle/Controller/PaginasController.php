<?php
/**
 * Created by PhpStorm.
 * User: gilso_nb9zlec
 * Date: 23/03/2018
 * Time: 04:57
 */

namespace App\CmsBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PaginasController extends Controller
{
    /**
     *
     * @Route("/listar")
     */
    public function index()
    {
        return new Response("<h1>Listando Paginas</h1>");
    }
}