<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home.index", options={"expose"=true})
     */
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @return Response
     * @Route("/comment-ca-marche", name="home.how")
     */
    public function howDoesItWork(): Response
    {
        return $this->render('home/howItWorks.html.twig');
    }
}
