<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController
{
    /**
     * @Route("/register", name="signup.index")
     * @return Response
     */
    public function register(): Response
    {
        return $this->render('registration/register.html.twig');
    }
}
