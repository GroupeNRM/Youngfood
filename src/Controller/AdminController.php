<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.index")
     */
    public function adminHome()
    {
        return $this->render('admin/admin_home.html.twig');
    }


    /**
     * @Route("/admin_login", name="admin.login")
     */
    public function adminLogin()
    {
        return $this->render('admin/admin_login.html.twig');
    }
}
