<?php

namespace App\Controller;

use App\Service\Mensagem;
use Doctrine\DBAL\Driver\Connection;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends Controller
{
    /**
     * @Route("/default", name="default")
     */
    public function index(SessionInterface $session)
    {
        $user = new \stdClass();
        $user->nome = "Gilson";
        $user->idade = 19;

        echo dump($user)->nome;

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'name' => "Felipe"
        ]);
    }

    /**
     * @param SessionInterface $session
     *
     * @Route("/pegar-sessao")
     */
    public function pegarSessao(SessionInterface $session)
    {
        $session->remove('frase');
        echo $session->get('frase', "Nooooooo!");
        exit;
    }

    /**
     * @Route("/escrever-mensagem")
     */
    public function escreverMensagem()
    {
        $mensagem = $this->get("mensagem");
        echo $mensagem->escreverMensagem("Gilson");
        exit;
    }

    /**
     * @Route("/enviar-email")
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function email(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Symfony 4'))
            ->setFrom('noreplay@email.com')
            ->setTo(['envioson@gmail.com' => "School of Net"])
            ->setBody($this->renderView('default/index.html.twig', [
                'controller_name' => "DefaultController",

            ]), 'text/html');

        $mailer->send($message);
        return new Response("Enviado!");

    }

    /**
     * @Route("/logger")
     */
    public function logger(LoggerInterface $logger)
    {
        $logger->info("Somente uma informação!");
        $logger->error("Deu erro em alguma coisa!");

        $logger->critical("Erro crítico", ['motivo' => "Erro no sistema!"]);

        return new Response("Logger executado!");
    }

    /**
     * @Route("/listar-dados")
     * @Template("default/listar-dados.html.twig")
     */
    public function postgresql(Connection $connection)
    {
        $clientes = $connection->fetchAll("select * from clientes");

        return [
            'clientes' => $clientes
        ];
    }

    /**
     * @Route("/filesystem")
     */
    public function filesystem()
    {
        $fs = new Filesystem();
        $dir = $this->getParameter('kernel.project_dir');
//        $fs->mkdir($dir . "/teste");
//        $fs->remove($dir . "/teste");

//        $fs->touch($dir. "/teste/fs.txt");


//        $fs->copy($dir . "/public/imagens/1.jpg", $dir. "/teste/imagem1.jpg");

        $fs->mirror($dir . "/public/imagens", $dir . "/teste2");


        return new Response("File System");
    }

    /**
     *
     * @Route("/finder")
     */
    public function finder()
    {
        $f = new Finder();
        $dir = $this->getParameter('kernel.project_dir');

        $files = $f->files()->in($dir . "/teste2");

        echo "<pre>";
        foreach ($files as $file) {
            var_dump($file->getFileName());
            echo "<hr>";
        }

        return new Response("Finder");
    }

    /**
     * @Route("/translate/{nome}")
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function translate(TranslatorInterface $translator, $nome)
    {
//        echo $translator->trans("Hello man!");

        echo $translator->trans("Hello %name%!", ['%name%' => $nome]);

        echo "<br>";
        return new Response("Translate");
    }
}
